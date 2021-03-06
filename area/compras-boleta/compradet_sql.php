<?php

require_once("../../validatesession_json.php");
header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{
		$jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
		$get_val=$_GET["IDCompra"];
		$bsq=$_POST["Item"];
        

		$from="FROM dboleta 
		INNER JOIN product ON dboleta.codigo = product.CodeBar";
		$where="WHERE dboleta.id_eboleta = '$get_val'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

		$result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
		$sql=<<<QUERY
			SELECT dboleta.id_dboleta, 
			dboleta.id_eboleta, 
			dboleta.posicion, 
			dboleta.codigo, 
			dboleta.descripcion, 
			dboleta.cantidad, 
			dboleta.descuento, 
			dboleta.almacen, 
			replace(format(dboleta.neto_detalle,0),',','.') neto_detalle, 
			replace(format(dboleta.iva_detalle,0),',','.') iva_detalle, 
			replace(format(dboleta.total_detalle,0),',','.') total_detalle,
			dboleta.estado, 
			product.ProductName
                $from $where $limit;		
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Boleta :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Boleta :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
		//Add all records to an array
		$rows = array();
		while($row = mysql_fetch_array($result))
		{

				$rows[] = $row;
		  // $rows[] = array_map('utf8_encode', $row);
			
		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		
		print json_encode($jTableResult);
		
	}

	
	//Updating a record (updateAction)   
	
	conectar::desconectar();
}
catch(Exception $ex)
{
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
?>
