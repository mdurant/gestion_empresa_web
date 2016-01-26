<?php

header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_USUARIOS=array();
$PERMISOS_USUARIOS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'USUARIOS');

require_once("../conexion/conexion.php");


try
{
    
	if($_GET["action"] == "list"){
		
		
		if (!$PERMISOS_USUARIOS['PERFILES_LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Perfiles de Usuarios :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
		$jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
		$get_val=$_GET["IDUsuario"];
        

		$from=" FROM usuarios_perfiles a, perfiles b, sucursales c";
		$where="where a.IDPerfil=b.IDPerfil
                  and b.IDSucursal = c.IDSucursal
                  and a.IDUsuario='$get_val'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
        
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

		$result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
		$sql=<<<QUERY
			
				SELECT a.IDUsuariosPerfil,a.IDUsuario, a.IDPerfil, b.Nombre as nombreperfil, c.Nombre as sucursal, Password
                $from $where $limit;		
QUERY;

        //die($sql);

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "usuarios_perfiles :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "usuarios_perfiles :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
		
		if (!$PERMISOS_USUARIOS['PERFILES_CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Perfiles de Usuarios :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
		//Insert record into database
	    $IDUsuariosPerfil = $_POST["IDUsuariosPerfil"];
        $IDUsuario = $_POST["IDUsuario"];
        $IDPerfil = $_POST["IDPerfil"];
        $Password = $_POST["Password"];
 
		$sql=<<<QUERY
		INSERT INTO usuarios_perfiles 
        (IDUsuario,
          IDPerfil,
          Password)
           VALUES ('$IDUsuario', '$IDPerfil', '$Password');


		
QUERY;
        
		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "usuarios_perfiles :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "usuarios_perfiles :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
		$IDPerfilesPermisos = mysql_query("SELECT * FROM usuarios_perfiles WHERE IDUsuariosPerfil = LAST_INSERT_ID();");
		$row = mysql_fetch_array($IDPerfilesPermisos);
        			
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
		if (!$PERMISOS_USUARIOS['PERFILES_MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Perfiles de Usuarios :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
		$IDUsuariosPerfil = $_POST["IDUsuariosPerfil"];
        $IDUsuario = $_POST["IDUsuario"];
        $IDPerfil = $_POST["IDPerfil"];
        $Password = $_POST["Password"];
	
			$sql=<<<QUERY
		
		                  UPDATE  usuarios_perfiles 
                           SET  IDUsuario =  '$IDUsuario',
                                IDPerfil =  '$IDPerfil',
                                Password =  '$Password'
                           WHERE  IDUsuariosPerfil ='$IDUsuariosPerfil';
		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "usuarios_perfiles :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "usuarios_perfiles :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		
		if (!$PERMISOS_USUARIOS['PERFILES_ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Perfiles de Usuarios :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

    	$IDUsuariosPerfil = $_POST["IDUsuariosPerfil"];

		$delete=<<<QUERY
		DELETE FROM usuarios_perfiles WHERE IDUsuariosPerfil = '$IDUsuariosPerfil';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "usuarios_perfiles :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "usuarios_perfiles :: Facturada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
    else if($_GET["action"] == "perfiles")
	{
		$sqlun=<<<QUERY
        
        SELECT
            IDPerfil,
            Nombre
        FROM perfiles
		where Estado='activo'
       
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlun,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Nombre"],"Value"=>$row["IDPerfil"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "perfiles :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "perfiles :: cargar :: SQLERROR -> $msgerror -> $sqlun";};

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
