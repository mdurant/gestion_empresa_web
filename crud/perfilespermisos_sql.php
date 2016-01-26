<?php

header('Content-Type: text/html; charset=UTF-8');


require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_PERFILESPERMISOS=array();
$PERMISOS_PERFILESPERMISOS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'PERFILESPERMISOS');



require_once("../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_PERFILESPERMISOS['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Perfiles > Permisos :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


		$jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
		$get_val=$_GET["IDPerfil"];
        $bsq=$_POST["Item"];

        $txtPERMISOBUSCAR=strtoupper(str_replace(' ','%',$_POST["txtPERMISOBUSCAR"]));

		$from=" FROM
                perfiles_permisos
                INNER JOIN modulos ON perfiles_permisos.IDModulo = modulos.IDmodulo
                INNER JOIN perfiles ON perfiles_permisos.IDPerfil = perfiles.IDPerfil";
		$where="WHERE perfiles_permisos.IDPerfil = '$get_val' and UPPER(REPLACE(CONCAT(modulo,Item),' ','')) Like '%$txtPERMISOBUSCAR%'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

		$result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
		$sql=<<<QUERY
			
				SELECT
                perfiles_permisos.IDPerfilesPermisos,
                perfiles_permisos.IDPerfil,
                perfiles_permisos.IDModulo,
                perfiles_permisos.Item,
                perfiles_permisos.Valor,
                perfiles.Nombre,
                modulos.modulo
                $from $where $limit;		
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "perfiles_permiso :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "perfiles_permiso :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
		
		if (!$PERMISOS_PERFILESPERMISOS['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Perfiles > Permisos :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		//Insert record into database
        $IDPerfilesPermisos = $_POST["IDPerfilesPermisos"];
        $IDPerfil = $_POST["IDPerfil"];
        $IDModulo = $_POST["IDModulo"];
        $Item = $_POST["Item"];
        $Valor = $_POST["Valor"];
 
		$sql=<<<QUERY
		INSERT INTO perfiles_permisos 
        (IDPerfil,
          IDModulo,
          Item, 
          Valor)
           VALUES ('$IDPerfil', '$IDModulo', '$Item', '$Valor');


		
QUERY;
        
		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "perfiles :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "perfiles :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
		$IDPerfilesPermisos = mysql_query("SELECT * FROM perfiles_permisos WHERE IDPerfilesPermisos = LAST_INSERT_ID()");
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

		if (!$PERMISOS_PERFILESPERMISOS['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Perfiles > Permisos :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


	    $IDPerfilesPermisos = $_POST["IDPerfilesPermisos"];
        $IDPerfil = $_POST["IDPerfil"];
        $IDModulo = $_POST["IDModulo"];
        $Item = $_POST["Item"];
        $Valor = $_POST["Valor"];
	
			$sql=<<<QUERY
		
		UPDATE  perfiles_permisos SET  IDPerfil =  '$IDPerfil',
        IDModulo =  '$IDModulo',
        Item =  '$Item',
        Valor =  '$Valor' WHERE  perfiles_permisos.IDPerfilesPermisos ='$IDPerfilesPermisos';
		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "permisos :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "permisos :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		
		if (!$PERMISOS_PERFILESPERMISOS['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Perfiles > Permisos :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
    	$IDPerfilesPermisos = $_POST["IDPerfilesPermisos"];

		$delete=<<<QUERY
		DELETE FROM perfiles_permisos WHERE perfiles_permisos.IDPerfilesPermisos = '$IDPerfilesPermisos';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "perfiles :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "perfiles :: Facturada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
    else if($_GET["action"] == "modulos")
	{
		
		$IDPerfil=$_GET["IDPerfil"];
		
		$sqlun=<<<QUERY
        
        SELECT
              a.IDmodulo,
              concat(a.modulo,
                     ' (',
                     IFNULL((select GROUP_CONCAT(b.Item SEPARATOR ', ') from perfiles_permisos b where b.IDPerfil='$IDPerfil' and b.IDModulo=a.IDmodulo),''),
                     ')'
                     ) as modulo
        FROM modulos a
		order by 2

QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlun,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["modulo"],"Value"=>$row["IDmodulo"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "modulo :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "modulo :: cargar :: SQLERROR -> $msgerror -> $sqlun";};

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
