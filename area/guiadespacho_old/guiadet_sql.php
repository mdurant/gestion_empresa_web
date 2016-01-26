<?php
require_once("../../validatesession_json.php");
header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");

// Se cambia la query de listar detalle guia despacho, para despeglar información del producto y no del barcode para el detalle (child)
// Mauricio Duran

try
{
    
	if($_GET["action"] == "list")
	{
		$jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
		$get_val=$_GET["IDPerfil"];
		$bsq=$_POST["Item"];
        

		$from="FROM
                dguiadespacho
		left outer join product on
                dguiadespacho.Codigo = product.CodeBar
		";
		$where="WHERE dguiadespacho.IdEGuiaDespacho = '$get_val'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

		$result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
		$sql=<<<QUERY
			
				SELECT
				dguiadespacho.IdDGuia,
				dguiadespacho.IdEGuiaDespacho,
				dguiadespacho.Codigo,
				dguiadespacho.Cantidad,
				dguiadespacho.Descuento,
				dguiadespacho.Neto,
				dguiadespacho.Iva,
				dguiadespacho.Total,
				product.ProductName
                $from $where $limit;		
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Guia de Despacho :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Guia de Despacho :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
