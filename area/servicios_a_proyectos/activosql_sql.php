<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
	if($_GET["action"] == "list")
	{
		 date_default_timezone_set('America/Santiago');
		if($_POST["guia_compra"]=="" or $_POST["guia_compra"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["activos"];
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
            
		$from="FROM dsolicitud a 
			INNER JOIN esolicitud b ON a.id_esolicitud = b.id_esolicitud
			INNER JOIN proyectos c ON b.id_proyecto = c.id_proyecto
			GROUP BY b.id_proyecto";
		//$where="WHERE (eservicios.usuario LIKE '%$product%' or eservicios.numero LIKE '%$product%')  GROUP BY a.id_proyecto $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
	SELECT 
	a.id_dsolicitud, 
	a.id_esolicitud, 
	a.posicion, 
	a.codigo_producto, 
	a.producto, 
	a.cantidad, 
	a.observacion, 
	b.id_proyecto,
	b.id_esolicitud, 
	b.fecha_sol, 
	b.id_jefe, 
	b.id_operario, 
	b.orden_trabajo, 
	b.contador, 
	b.estado, 
	b.glosa,
	c.nombre_proyecto
	$from 
	$limit;		
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Activos :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Activos :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
		
		
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
		$id_eservicios=$_POST["id_eservicios"];
		//Delete from database
		$delete=<<<QUERY
				delete from eservicios
				where eservicios.id_eservicios =$id_eservicios
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());
//echo $delete;
		} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Servicios a Proyectos :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Servicios a Proyectos :: Eliminar :: SQLERROR -> $msgerror -> $delete";};


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
