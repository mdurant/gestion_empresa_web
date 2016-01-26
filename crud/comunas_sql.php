<?php
header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_COMUNAS=array();
$PERMISOS_COMUNAS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'COMUNAS');



require_once("../conexion/conexion.php");


try
{

	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_COMUNAS['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Comunas :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


		//Get record count
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount FROM comunas;
QUERY;
		$result = mysql_query($sql2, conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];

		$name=$_POST["name"];
		$jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
		

		$sql=<<<QUERY
			
				SELECT
					a.IDComuna,
					a.Comuna,
					a.IDProvincia,
					b.provincia
					FROM comunas a
					INNER JOIN provincias b ON a.IDProvincia = b.IDProvincias
				where Comuna LIKE '%$name%'  ORDER BY $jtSorting LIMIT $jtStartIndex,$jtPageSize;		
QUERY;


		
		
		
		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "comunas :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "comunas :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
		
		
		//Add all records to an array
		$rows = array();
		while($row = mysql_fetch_array($result))
		{
		  // $rows[] = array_map('utf8_encode', $row);
			$rows[] = $row;
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
		
		if (!$PERMISOS_COMUNAS['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Comunas :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		//Insert record into database
		$comunai=$_POST['Comuna'];
		$idprovinciai=$_POST["IDProvincia"];
		$sql=<<<QUERY
		INSERT INTO comunas (Comuna ,IDProvincia) VALUES ("$comunai"  ,"$idprovinciai" )
		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "comunas :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "comunas :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
					
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['Record'] = $result;
		print json_encode($jTableResult);
	}
	
    else if($_GET["action"] == "update")
	{
		
		if (!$PERMISOS_COMUNAS['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Comunas :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		$comuna=$_POST["Comuna"];
		$idprov=$_POST["IDProvincia"];
		$idcomuna=$_POST["IDComuna"];
		//Update record in database
		$sql=<<<QUERY
		
		UPDATE comunas 
		SET Comuna = '$comuna', 
		IDProvincia = '$idprov' 
		WHERE IDComuna = '$idcomuna';
		
QUERY;
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "comunas :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "comunas :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
	
    
    else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_COMUNAS['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Comunas :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		$idcomuna=$_POST["IDComuna"];
		//Delete from database
		$delete=<<<QUERY
		DELETE FROM comunas WHERE IDComuna = $idcomuna;
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
	
	else if($_GET["action"] == "provincias")
	{
		$sqlprov=<<<QUERY
        
        SELECT
					a.IDProvincias,
					a.provincia
					FROM provincias a;
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlprov,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["provincia"],"Value"=>$row["IDProvincias"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "provincias :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "provincias :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

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
