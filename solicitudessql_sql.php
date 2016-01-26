<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");

try
{
	if($_GET["action"] == "list")
	{
		 date_default_timezone_set('America/Santiago');
		if($_POST["solicitudes"]=="" or $_POST["solicitudes"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["solicitudes"];
		}
		if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND esolicitud.estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }
        
        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
            
		$from="FROM
	esolicitud
LEFT OUTER JOIN jefaturas ON esolicitud.id_jefe = jefaturas.id_jefatura
LEFT OUTER JOIN trabajador ON esolicitud.id_operario = trabajador.id_trabajador
LEFT OUTER JOIN proyectos ON esolicitud.id_proyecto = proyectos.id_proyecto
LEFT OUTER JOIN dsolicitud ON esolicitud.id_esolicitud = dsolicitud.id_esolicitud
LEFT OUTER JOIN product ON dsolicitud.codigo_producto = product.CodeBar";
		$where="WHERE (esolicitud.contador LIKE '%$product%' or proyectos.nombre_proyecto LIKE '%$product%') $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
	SELECT
	esolicitud.id_esolicitud,
	esolicitud.fecha_sol,
	esolicitud.id_jefe,
	esolicitud.id_operario,
	esolicitud.id_proyecto,
	esolicitud.orden_trabajo,
	esolicitud.contador,
	esolicitud.estado,
	esolicitud.glosa,
	jefaturas.id_jefatura,
	UPPER(CONCAT(jefaturas.nombres, ' ' ,jefaturas.paterno)) as jefe,
	trabajador.id_trabajador,
	UPPER(CONCAT(trabajador.nombres, ' ', trabajador.apellidop)) as operario,
	proyectos.nombre_proyecto,
	dsolicitud.id_dsolicitud,
	dsolicitud.codigo_producto,
	dsolicitud.producto,
	dsolicitud.cantidad,
	product.CodeBar,
	product.ProductName
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
		{ 	$vRESP="OK"; $vMENSAJE = "Solicitudes :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Solicitudes :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
		
		
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
	
	else if($_GET["action"] == "delete")
	{
		$id_esolicitud=$_POST["id_esolicitud"];
		//Delete from database
		$delete=<<<QUERY
				UPDATE esolicitud set estado="inactivo" WHERE id_esolicitud = $id_esolicitud;
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Solicitudes :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Solicitudes :: Eliminar :: SQLERROR -> $msgerror -> $delete";};


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
