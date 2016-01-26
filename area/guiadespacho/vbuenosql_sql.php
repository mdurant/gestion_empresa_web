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
				customers.Cliente,
				empresa.RazonSocial,
				eorden.estado,
				eorden.vbueno1,
				eorden.fecha_vbueno1,
				eorden.usuario_1,
				eorden.vbueno2,
				eorden.fecha_vbueno2,
				eorden.usuario_2,
				eorden.vbueno3,
				eorden.fecha_vbueno3,
				eorden.usuario3
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
		$id_plantillaot=$_POST["id_plantillaot"];
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
		{ 	$vRESP="OK"; $vMENSAJE = "comunas :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "comunas :: Eliminar :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
	
		else if($_GET["action"] == "vbueno1")
	{
		 date_default_timezone_set('America/Santiago');
		$id_vb=$_GET["id_vb"];
		$seleccion=$_GET["vb1"];
        $user=$_GET["user"];
		$ahora=date("Y-m-d");
		//Delete from database
		$delete=<<<QUERY
		UPDATE eorden set vbueno1="$seleccion", usuario_1="$user", fecha_vbueno1="$ahora" WHERE id_orden = $id_vb;
QUERY;
		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "orden :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "orden :: Eliminar :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
		else if($_GET["action"] == "vbueno2")
	{
		 date_default_timezone_set('America/Santiago');
		$id_vb=$_GET["id_vb"];
		$seleccion=$_GET["vb2"];
        $user=$_GET["user2"];
		$ahora=date("Y-m-d");
		//Delete from database
		$delete=<<<QUERY
		UPDATE eorden set vbueno2="$seleccion", usuario_2="$user", fecha_vbueno2="$ahora" WHERE id_orden = $id_vb;
QUERY;
		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "orden :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "orden :: Eliminar :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
		else if($_GET["action"] == "vbueno3")
	{
		 date_default_timezone_set('America/Santiago');
		$id_vb=$_GET["id_vb"];
		$seleccion=$_GET["vb3"];
        $user=$_GET["user3"];
		$ahora=date("Y-m-d");
		//Delete from database
		$delete=<<<QUERY
		UPDATE eorden set vbueno3="$seleccion", usuario3="$user", fecha_vbueno3="$ahora" WHERE id_orden = $id_vb;
QUERY;
		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "orden :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "orden :: Eliminar :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
      else if($_GET["action"] == "Nombre")
	{
		$sqlnom=<<<QUERY
        
       SELECT
        users.Username,
        users.IDUser
        FROM
        users
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlnom,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Username"],"Value"=>$row["IDUser"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Almacen :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Almacen :: cargar :: SQLERROR -> $msgerror -> $sqlnom";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
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
