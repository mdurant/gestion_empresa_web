<?php

header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_PRODUCTOS=array();
$PERMISOS_PRODUCTOS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'SERVICIOS');


require_once("../conexion/conexion.php");


try
{
    
	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_PRODUCTOS['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Servicios :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}



		if($_POST["servicio"]=="" or $_POST["servicio"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["servicio"];
		}
        
		$product=strtoupper(str_replace(' ','%',$product));
		
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND servicios.estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="from servicios";
		$where="WHERE UPPER(REPLACE(CONCAT(servicios.codigo_ss,servicios.nombre_ss),' ','')) LIKE '%$product%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
		SELECT servicios.id_servicio, 
			servicios.nombre_ss, 
			servicios.codigo_ss, 
			servicios.estado
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
		{ 	$vRESP="OK"; $vMENSAJE = "Listado Servicios :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Listado Servicios :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
     else if($_GET["action"] == "create")
	{
		
		if (!$PERMISOS_PRODUCTOS['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Servicios :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

	
	$codigo_servicio=$_POST["codigo_ss"];
    $nombre_servicio=$_POST["nombre_ss"];
    $estado=$_POST["estado"];
 
		$sql=<<<QUERY
		INSERT INTO  servicios (
        id_servicio ,
        nombre_ss,
       	codigo_ss,
        estado
        )
        VALUES (
        NULL ,
		'$nombre_servicio',
		'$codigo_servicio',
		'$estado'
        );

		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Crear Servicios :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Crear Servicios :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		

		$id_servicios = mysql_query("SELECT * FROM servicios WHERE id_servicio = LAST_INSERT_ID();");
		$row = mysql_fetch_array($id_servicios);
					
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{

		if (!$PERMISOS_PRODUCTOS['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Servicios :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


		// variables
		$id_servicio=$_POST["id_servicio"];
    	$nombre_servicio=$_POST["nombre_ss"];
    	$estado=$_POST["estado"];


	    
		$sql=<<<QUERY
		UPDATE  servicios SET
		nombre_ss ='$nombre_servicio',
        estado ='$estado'
       
		WHERE
		servicios.id_servicio ='$id_servicio';
		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Actualizar Servicios :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Actualizar Servicios :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_PRODUCTOS['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Servicios :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		
    	$id_servicio=$_POST["id_servicio"];

		$delete=<<<QUERY
		UPDATE
		servicios SET
		estado =  'inactivo'
		WHERE
		servicios.id_servicio ='$id_servicio';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Eliminar Servicios :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Eliminar Servicios :: Facturada :: SQLERROR -> $msgerror -> $sql";};


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
