<?php
header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");

try
{
	if($_GET["action"] == "list")
	{
		 date_default_timezone_set('America/Santiago');
		if($_POST["proyecto_valorizado"]=="" or $_POST["proyecto_valorizado"]=="null")
		{
			$nombre="";
		}else
		{
			$nombre=$_POST["proyecto_valorizado"];
		}
		$desde = $_POST["desde"];
		$hasta = $_POST["hasta"];
	  $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM proyectos p";
		$where="WHERE (p.nombre_proyecto LIKE '%$nombre%' or p.fecha_inicio BETWEEN '$desde' AND 'hasta')";
		$limit="LIMIT $jtStartIndex,$jtPageSize";

		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

    $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];

		$sql=<<<QUERY

				select
				p.id_proyecto,
				p.nombre_proyecto,
				p.fecha_inicio,
				p.fecha_compromiso,
				p.Estado
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
		{ 	$vRESP="OK"; $vMENSAJE = "Proyectos Valorizados :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Proyectos Valorizados :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};


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
		$id_orden=$_POST["id_orden"];
		//Delete from database
		$delete=<<<QUERY
				UPDATE eorden set estado="inactivo" WHERE id_orden = $id_orden;
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());}
        catch(Exception $ex){	$result=0; $msgerror=$ex;}

		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "eorden :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "eorden :: Eliminar :: SQLERROR -> $msgerror -> $delete";};


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
