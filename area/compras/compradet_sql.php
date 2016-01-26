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
        

		$from="FROM dcompra 
INNER JOIN product ON dcompra.codigo = product.CodeBar";
		$where="WHERE dcompra.id_compra = '$get_val'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

		$result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
		$sql=<<<QUERY
			SELECT dcompra.id_dcompra, 
				dcompra.id_compra, 
				dcompra.posicion, 
				dcompra.codigo, 
				dcompra.descripcion, 
				dcompra.cantidad, 
				dcompra.almacen, 
				replace(format(dcompra.precio_compra,0),',','.') precio_compra,
				replace(format(dcompra.precio_venta,0),',','.') precio_venta,
				dcompra.descuento, 
				replace(format(dcompra.neto_detalle,0),',','.') neto_detalle,
				replace(format(dcompra.iva_detalle,0),',','.') iva_detalle, 
				dcompra.impuesto_detalle, 
				dcompra.tipo_impuesto, 
				replace(format(dcompra.total_detalle,0),',','.') total_detalle, 
				product.ProductName
                $from $where $limit;		
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "factura :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "factura :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
