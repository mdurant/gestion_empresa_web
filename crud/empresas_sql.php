<?php

header('Content-Type: text/html; charset=UTF-8');


require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_EMPRESAS=array();
$PERMISOS_EMPRESAS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'EMPRESAS');


require_once("../conexion/conexion.php");



try
{

	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_EMPRESAS['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Empresas :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


		if($_POST["empresa"]=="" or $_POST["empresa"]=="null")
		{
			$empresa="";
		}else
		{
			$empresa=$_POST["empresa"];
		}

        if($_POST['chkinactivo']=="1" or $_POST['chkinactivo']=="")
        {
            $radio="AND Estado='activo'";
        }elseif($_POST['chkinactivo']=="2")
        {
            $radio="";
        }


        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM empresa";
		$where="where RazonSocial LIKE '%$empresa%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2="SELECT COUNT(*) AS RecordCount $from $where ";
        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		$sql=<<<QUERY
			
            
                SELECT IDEmpresa, 
                       RUT, 
                       RazonSocial, 
                       Giro, 
                       Domicilio, 
                       IDcomuna, 
                       Telefono1, 
                       Telefono2, 
                       EmailEmpresa, 
                       WebEmpresa, 
                       RUT_Representante, 
                       Representante, 
                       EmailRepresentante, 
                       Descripcion, 
                       Estado 
                $from  
				$where
				ORDER BY $jtSorting 
				$limit;		
QUERY;

        //die($sql);
        
        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
        $vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Empresas :: Listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Empresas :: Listar :: SQLERROR -> $msgerror -> $sql";};
		
		$rows = array();
        while($row = mysql_fetch_array($result))
        {
            $rows[] = $row;
        }
        
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		
        
        
		print json_encode($jTableResult);
		
	}
    
    if ($_GET["action"] == "create" || $_GET["action"] == "update")
    {
        
        
        $RUT=$_POST["RUT"];  
        $RazonSocial=$_POST["RazonSocial"];  
        $Giro=$_POST["Giro"];  
        $Domicilio=$_POST["Domicilio"];  
        $IDcomuna=$_POST["IDcomuna"];  
        $Telefono1=$_POST["Telefono1"];  
        $Telefono2=$_POST["Telefono2"];  
        $EmailEmpresa=$_POST["EmailEmpresa"];  
        $WebEmpresa=$_POST["WebEmpresa"];  
        $RUT_Representante=$_POST["RUT_Representante"];  
        $Representante=$_POST["Representante"];  
        $EmailRepresentante=$_POST["EmailRepresentante"];  
        $Descripcion=$_POST["Descripcion"];  
        $Estado=$_POST["Estado"]; 
        
    }
	
    
    if($_GET["action"] == "create")
	{

		if (!$PERMISOS_EMPRESAS['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Empresas :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
		$sql=<<<QUERY
		
        
            INSERT INTO empresa
            (RUT, 
             RazonSocial, 
             Giro, 
             Domicilio, 
             IDcomuna, 
             Telefono1, 
             Telefono2, 
             EmailEmpresa, 
             WebEmpresa, 
             RUT_Representante, 
             Representante, 
             EmailRepresentante, 
             Descripcion, 
             Estado) 
            VALUES ('$RUT', 
                    '$RazonSocial', 
                    '$Giro', 
                    '$Domicilio', 
                    $IDcomuna, 
                    '$Telefono1', 
                    '$Telefono2', 
                    '$EmailEmpresa', 
                    '$WebEmpresa', 
                    '$RUT_Representante', 
                    '$Representante', 
                    '$EmailRepresentante', 
                    '$Descripcion', 
                    '$Estado');

		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Empresas :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Empresas :: Ingresar :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['Record'] = $result;
		print json_encode($jTableResult);
    }
    
	if($_GET["action"] == "update")
	{
		if (!$PERMISOS_EMPRESAS['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Empresas :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

        $IDEmpresa=$_POST["IDEmpresa"]; 
        
        $sql=<<<QUERY
		
            UPDATE empresa
            SET
               RUT               = '$RUT',
               RazonSocial       = '$RazonSocial',
               Giro              = '$Giro',
               Domicilio         = '$Domicilio',
               IDcomuna          = $IDcomuna ,
               Telefono1         = '$Telefono1',
               Telefono2         = '$Telefono2',
               EmailEmpresa      = '$EmailEmpresa',
               WebEmpresa        = '$WebEmpresa',
               RUT_Representante = '$RUT_Representante',
               Representante     = '$Representante',
               EmailRepresentante = '$EmailRepresentante',
               Descripcion        = '$Descripcion',
               Estado             = '$Estado'
            WHERE IDEmpresa = $IDEmpresa;	
QUERY;
		
		
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Empresas :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Empresas :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
    }
	
    else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_EMPRESAS['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Empresas :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		$IDEmpresa=$_POST["IDEmpresa"]; 
        
        
        $sql=<<<QUERY
		DELETE FROM empresa 
        WHERE IDEmpresa = $IDEmpresa;
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Empresas :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Empresas :: Eliminar :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
	
	else if($_GET["action"] == "comunas")
	{
		$sql=<<<QUERY
        
            SELECT IDComuna, 
                   Comuna
            FROM comunas
            ORDER BY Comuna;

QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sql,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Comuna"],"Value"=>$row["IDComuna"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$resultsql;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Comunas :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Comunas :: cargar :: SQLERROR -> $msgerror -> $sql";};

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
