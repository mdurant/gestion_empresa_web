<?php

header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");




require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_ALMACENES=array();
$PERMISOS_ALMACENES=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'ALMACENES');


require_once("../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_ALMACENES['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Jefaturas :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		
		if($_POST["nombres"]=="" or $_POST["nombres"]=="null")
		{
			$forma="";
		}else
		{
			$forma=$_POST["nombres"];
		}
        
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND jefaturas.estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM jefaturas";
		$where="WHERE estado = 'activo' and jefaturas.nombres LIKE '%$forma%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
	SELECT
	jefaturas.id_jefatura,
	jefaturas.nombres,
	jefaturas.paterno,
	jefaturas.materno,
	jefaturas.email,
	jefaturas.estado
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
		{ 	$vRESP="OK"; $vMENSAJE = "Jefaturas :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Jefaturas :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
		
		if (!$PERMISOS_ALMACENES['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Jefaturas :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		//Insert record into database
		$id_jefatura=$_POST["id_jefatura"];
		$nombres=$_POST["nombres"];
		$paterno=$_POST["paterno"];
		$materno=$_POST["materno"];
		$email=$_POST["email"];
		$estado=$_POST["estado"];
 
		$sql=<<<QUERY
		INSERT INTO  jefaturas (
            id_jefatura ,
            nombres ,
            paterno ,
            materno,
            email,
            estado
            )
        VALUES (
        NULL ,  '$nombres',  '$paterno', '$materno','$email', '$estado'
        );



		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Jefaturas :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Jefaturas :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
					
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['Record'] = $result;
		print json_encode($jTableResult);
	}
	
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{

		if (!$PERMISOS_ALMACENES['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Jefaturas :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


	    $id_jefatura=$_POST["id_jefatura"];
	    $nombres=$_POST["nombres"];
	    $paterno=$_POST["paterno"];
	    $materno=$_POST["materno"];
        $email=$_POST["email"];
        $estado=$_POST["estado"];
	
		$sql=<<<QUERY
		
		UPDATE  jefaturas SET  nombres =  '$nombres',
                paterno =  '$paterno',
                materno ='$materno',
                email ='$email',
                estado =  '$estado' WHERE  jefaturas.id_jefatura ='$id_jefatura';
		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Jefaturas :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Jefaturas :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_ALMACENES['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Jefaturas :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
    	$id_jefatura=$_POST["id_jefatura"];

		$delete=<<<QUERY
		UPDATE  jefaturas SET  estado =  'inactivo' WHERE  jefaturas.id_jefatura ='$id_jefatura';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Jefaturas :: Eliminada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Jefaturas :: Eliminada :: SQLERROR -> $msgerror -> $sql";};


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
