<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
	if($_GET["action"] == "list")
	{
		 date_default_timezone_set('America/Santiago');
		if($_POST["plantillas"]=="" or $_POST["plantillas"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["plantillas"];
		}
		if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }
        
        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
            
		$from="FROM
				eplantillaot";
		$where="WHERE (eplantillaot.descripcion LIKE '%$product%' or eplantillaot.nombre LIKE '%$product%') $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
				SELECT
				eplantillaot.id_plantillaot,
				eplantillaot.nombre,
				eplantillaot.descripcion,
				eplantillaot.estado
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
		{ 	$vRESP="OK"; $vMENSAJE = "boleta :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "boleta :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
		
		
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
		$id_plantillaot=$_POST["id_plantillaot"];
		//Delete from database
		$delete2=<<<QUERY
		DELETE from eplantillaot WHERE id_plantillaot = "$id_plantillaot";
QUERY;
        mysql_query($delete2,conectar::con());
        
        $delete=<<<QUERY
        DELETE FROM dplantillaot WHERE id_plantillaot="$id_plantillaot";
        
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "comunas :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "comunas :: Eliminar :: SQLERROR -> $msgerror -> $sql";};


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
