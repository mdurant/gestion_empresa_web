<?php

header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_USUARIOS=array();
$PERMISOS_USUARIOS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'USUARIOS');


//print $PERMISOS_USUARIOS['ELIMINAR'];
//print json_encode($PERMISOS_USUARIOS);
//die;

require_once("../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{
		
		if (!$PERMISOS_USUARIOS['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Modulo de Usuarios :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

				if($_POST["nombreusuario"]=="" or $_POST["nombreusuario"]=="null")
				{
					$forma="";
				}else
				{
					$forma=$_POST["nombreusuario"];
				}
				
				if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
				{
					$radio="AND users.Estado='activo'";
				}elseif($_POST['inactivo']=="2")
				{
					$radio="";
				}
		
				$jtSorting=$_GET["jtSorting"];
				$jtStartIndex=$_GET["jtStartIndex"];
				$jtPageSize=$_GET["jtPageSize"];
		
				$from="FROM users";
				$where="WHERE users.Username LIKE '%$forma%' $radio";
				$limit="LIMIT $jtStartIndex,$jtPageSize";
				
				$sql2=<<<QUERY
				SELECT COUNT(*) AS RecordCount $from $where;
QUERY;
		
				$result = mysql_query($sql2,conectar::con());
				$row = mysql_fetch_array($result);
				$recordCount = $row['RecordCount'];
				
				
				$sql=<<<QUERY
					
						SELECT
						users.IDUser,
						users.Username,
						users.Email,
				users.Name,
						users.Estado
						
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
				{ 	$vRESP="OK"; $vMENSAJE = "perfil :: listar :: OK!";	}
				else
				{	$vRESP="ERROR"; $vMENSAJE = "perfil :: listar :: SQLERROR -> $msgerror -> $sql";};
				
				
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
				$jTableResult['Message']= $vMENSAJE." :: ".$PERMISOS_USUARIOS_LISTAR;
				$jTableResult['TotalRecordCount'] = $recordCount;
				$jTableResult['Records'] = $rows;
				
				print json_encode($jTableResult);			
			

		
	}
     else if($_GET["action"] == "create")
	{
		
		
		if (!$PERMISOS_USUARIOS['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Modulo de Usuarios :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
		
		//Insert record into database
        $IDUser=$_POST["IDUser"];
        $Username=$_POST["Username"];
        $Email=$_POST["Email"];
	$Name=$_POST["Name"];
        $Estado=$_POST["Estado"];
 
		$sql=<<<QUERY
		INSERT INTO  users (
                        IDUser ,
                        Username ,
                        Email ,
			Name ,
                        Estado
                        )
                        VALUES (
                        NULL ,  '$Username',  '$Email',  '$Name',  '$Estado'
                        );



		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "formapago :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "formapago :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
					
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
		
		
		if (!$PERMISOS_USUARIOS['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Modulo de Usuarios :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}		
		
		
		
		
	$IDUser=$_POST["IDUser"];
        $Username=$_POST["Username"];
        $Email=$_POST["Email"];
	$Name=$_POST["Name"];
        $Estado=$_POST["Estado"];
	
			$sql=<<<QUERY
		
		UPDATE  users SET  Username =  '$Username',
                Email =  '$Email',Name =  '$Name',
                Estado =  '$Estado' WHERE  users.IDUser ='$IDUser';
		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "users :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "users :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		
		if (!$PERMISOS_USUARIOS['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Modulo de Usuarios :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}			
    	
		$IDUser=$_POST["IDUser"];

		$sql=<<<QUERY
		UPDATE  users SET  Estado =  'inactivo' WHERE  users.IDUser ='$IDUser';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "users :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "users :: Eliminar :: SQLERROR -> $msgerror -> $sql";};
		


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
