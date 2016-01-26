<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
	if($_GET["action"] == "list")
	{
		// date_default_timezone_set('America/Santiago');
		if($_POST)
		{
			if($_POST["ordenes"]=="" or $_POST["ordenes"]=="null")
			{
				$product="";
			}else
			{
				$product=$_POST["ordenes"];
			}
			if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
	        {
	            $radio="AND eguiadespacho.Estado='activo'";
	        }elseif($_POST['inactivo']=="2")
	        {
	            $radio="";
	        }
		}else
		{
			$product="";
			 $radio="";
		}
		
        
        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
            
		$from="FROM
		eguiadespacho
		INNER JOIN empresa ON eguiadespacho.IDEmpresa = empresa.IDEmpresa
	 	INNER JOIN motivo_guia ON eguiadespacho.IDMotivo = motivo_guia.IDMotivo
	 	INNER JOIN proyectos ON eguiadespacho.Referencia = proyectos.id_proyecto
	 	INNER JOIN customers ON proyectos.id_cliente = customers.IDCliente";
		$where="WHERE (customers.Cliente LIKE '%$product%' or empresa.RazonSocial LIKE '%$product%') $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
		SELECT eguiadespacho.IdEGuiaDespacho, 
		eguiadespacho.Numero, 
		eguiadespacho.Folio, 
		eguiadespacho.Total, 
		eguiadespacho.`User`, 
		eguiadespacho.Estado, 
		empresa.RazonSocial, 
		motivo_guia.nombre_motivo, 
		proyectos.nombre_proyecto, 
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
		{ 	$vRESP="OK"; $vMENSAJE = "Guias de Despacho :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Guias de Despacho :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
		
		
		//Add all records to an array

		$rows = array();
		while($row = mysql_fetch_array($result))
		{

				//$rows[] = $row;
		  $rows[] = array_map('utf8_encode', $row);
			
		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		
		print json_encode($jTableResult);
		
	}
	
	else if($_GET["action"] == "delete")
	{
		$id_guia=$_POST["IdEGuiaDespacho"];
		//Delete from database
		$delete=<<<QUERY
		DELETE FROM a, b USING eguiadespacho AS a
INNER JOIN dguiadespacho AS b
WHERE a.IdEGuiaDespacho = b.IdEGuiaDespacho 
AND a.IdEGuiaDespacho LIKE '$id_guia'

QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Guia Despacho :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Guia Despacho :: Eliminar :: SQLERROR -> $msgerror -> $delete";};


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
