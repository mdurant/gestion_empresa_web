<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{

	if($_GET["action"] == "list")
	{
		if($_POST["cliente"]=="" or $_POST["cliente"]=="null")
		{
			$cliente="";
		}else
		{
			$cliente=$_POST["cliente"];
		}

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM	ecotizacion LEFT OUTER JOIN customers ON ecotizacion.IdCliente = customers.IDCliente";
		$where="where customers.Cliente LIKE '%$cliente%' and ecotizacion.Estado <> 'Facturada'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
				SELECT
				ecotizacion.IdECotizacion,
				ecotizacion.FechaCreacion,
				ecotizacion.FechaTermino,
				ecotizacion.FechaFacturacion,
				ecotizacion.Estado,
				ecotizacion.motivo,
				customers.Cliente
				$from  
				$where
				ORDER BY $jtSorting 
				$limit;		
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "cotizacion :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "cotizacion :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
		//Add all records to an array
		$rows = array();
		while($row = mysql_fetch_array($result))
		{
			$va=date("Y-m-d");
			if($row["FechaTermino"] < $va)
			{
				$rows[] = $row;
			}
				
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
	else if($_GET["action"] == "update")
	{
		$opcion=$_POST["Estado"];
		$id=$_POST["IdECotizacion"];
		$motivo=$_POST["motivo"];
		$fecha=$_POST["FechaTermino"];
		$f2=date("Y-m-d",strtotime($fecha));
		
		if($opcion=="Facturada")
		{
		$jTableResult = array();
		$jTableResult['Result'] = "ERROR";
		$jTableResult['Message']= "Usted no puede Facturar atravez de esta opción";
		print json_encode($jTableResult);
		}else
		{
			$sql=<<<QUERY
		
		UPDATE ecotizacion SET 
		Estado =  '$opcion',
		motivo =  '$motivo',
		FechaTermino =  '$f2'
		WHERE  ecotizacion.IdECotizacion ='$id'
		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "comunas :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "comunas :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		}
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		$IdCotizacion=$_POST["IdECotizacion"];
		//Delete from database
		//$motivo=$_POST["motivo"];
		//insertar los datos a la tabla ctoizacion a factura
		// $vi=array();
		// $trae="select * from ecotizacion where IdECotizacion= '$IdCotizacion'";
		// $traeres=mysql_query($trae);
		// while($trow=mysql_fetch_assoc($traeres))
		// {
		// 	$vi[]=$trow;
		// }
		// $querys="INSERT INTO efactura (
		// 		IdEFactura ,
		// 		Numero ,
		// 		Folio ,
		// 		Referencia ,
		// 		IdCliente ,
		// 		IdFormaPago ,
		// 		Neto ,
		// 		Iva ,
		// 		Impuesto ,
		// 		Total ,
		// 		FechaCreacion ,
		// 		FechaFacturacion ,
		// 		Tipo ,
		// 		User ,
		// 		Estado ,
		// 		IDEmpresa ,
		// 		glosa
		// 		)
		// 		VALUES (
		// 		NULL ,  '".$vi[0]["Contador"]."',  'folio',   '".$vi[0]["Contador"]."',   '".$vi[0]["IdCliente"]."',  '".$vi[0]["IdFormaPago"]."',  '".$vi[0]["Neto"]."',  '".$vi[0]["Iva"]."',  '0.19',  '".$vi[0]["Total"]."', NOW( ) , NOW( ) ,  'FACTC',  '".$vi[0]["User"]."',  'activo',  '".$vi[0]["IDEmpresa"]."',  '".$vi[0]["glosa"]."'
		// 		)";
		// 		mysql_query($querys);
		
		
		//****************************************************
		//selecciono el contador y busco los datos en dcotizacion
		
				//crear la parte de obtener el numero de la cotizacion
			// $n="";
			// $Query="select * from ecotizacion where IdECotizacion= '$IdCotizacion' ";
			// $res=mysql_query($Query);
			// while($reg=mysql_fetch_assoc($res))
			// {
			// 	$n=$reg["Contador"];
			// }
			//****************************************************
			
			//traigo los datos de dcotizacion
			
			// $dat=array();
			// $dquery="select * from dcotizacion where IdECotizacion='$n'";
			// $datres=mysql_query($dquery);
			// while($datreg=mysql_fetch_assoc($datres))
			// {
			// 	$dat[]=$datreg;
			// }
			
			//comienaza la insercion
			// for($i=0;$i<sizeof($dat);$i++)
			// {
			// 	$iquery="INSERT INTO  dfactura (
			// 			IdDFactura ,
			// 			IdEFactura ,
			// 			Posicion ,
			// 			Codigo ,
			// 			Descripcion ,
			// 			Cantidad ,
			// 			Descuento ,
			// 			Almacen ,
			// 			Neto ,
			// 			Iva ,
			// 			MontoImpuesto ,
			// 			TipoImpuesto ,
			// 			Total ,
			// 			IDEmpresa
			// 			)
			// 			VALUES (
			// 			NULL ,  '".$dat[$i]["IdECotizacion"]."', '".$dat[$i]["Posicion"]."',  '".$dat[$i]["Codigo"]."',  '".$dat[$i]["Descripcion"]."',  '".$dat[$i]["Cantidad"]."',  '".$dat[$i]["Descuento"]."',  '".$dat[$i]["Almacen"]."',  '".$dat[$i]["Neto"]."',  '".$dat[$i]["Iva"]."',  '".$dat[$i]["MontoImpuesto"]."',  '".$dat[$i]["TipoImpuesto"]."',  '".$dat[$i]["Total"]."',  '".$dat[$i]["IDEmpresa"]."'
			// 			)";
			// 			mysql_query($iquery);
			// }
		
		//*************************************************************

		$delete=<<<QUERY
		UPDATE ecotizacion SET 
		Estado = 'Cancelada u Obsoleta' WHERE  ecotizacion.IdECotizacion ='$IdCotizacion';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Cotizacion :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Cotizacion :: Facturada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
	
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
