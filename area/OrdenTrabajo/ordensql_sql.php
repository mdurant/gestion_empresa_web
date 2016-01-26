<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
	if($_GET["action"] == "list")
	{
		 date_default_timezone_set('America/Santiago');
		if($_POST["ordenes"]=="" or $_POST["ordenes"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["ordenes"];
		}
		if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND eorden.estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }
        
        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
            
		$from="FROM
				eorden
				INNER JOIN customers ON eorden.id_cliente = customers.IDCliente
				INNER JOIN empresa ON eorden.id_empresa = empresa.IDEmpresa";
		$where="WHERE (customers.Cliente LIKE '%$product%' or empresa.RazonSocial LIKE '%$product%') $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
				SELECT
				eorden.id_orden,
				eorden.contador,
				eorden.folio,
				eorden.fecha_entrega,
				customers.Cliente,
				empresa.RazonSocial,
				eorden.estado
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
		{ 	$vRESP="OK"; $vMENSAJE = "ordenes :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "ordenes :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
		
		
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
