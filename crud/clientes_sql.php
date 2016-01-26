<?php

header('Content-Type: text/html; charset=UTF-8');


require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_CLIENTES=array();
$PERMISOS_CLIENTES=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'CLIENTES');



require_once("../conexion/conexion.php");



try
{

	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_CLIENTES['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Clientes :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}



		if($_POST["cliente"]=="" or $_POST["cliente"]=="null")
		{
			$cliente="";
		}else
		{
			$cliente=$_POST["cliente"];
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

		$from="FROM customers";
		$where="where Cliente LIKE '%$cliente%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2="SELECT COUNT(*) AS RecordCount $from $where ";
        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
            
                SELECT IDCliente, 
                       rut, 
                       Cliente, 
                       Empresa, 
                       DomicilioEmpresa, 
                       DomicilioDespacho, 
                       Telefono, 
                       Web, 
                       EmailEmpresa, 
                       Giro, 
                       Contacto, 
                       TelefonoContacto, 
                       EmailContacto, 
                       TwitterContacto, 
                       IDComuna, 
                       IDFormaPago, 
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
		{ 	$vRESP="OK"; $vMENSAJE = "Clientes :: Listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Clientes :: Listar :: SQLERROR -> $msgerror -> $sql";};
		
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
        
        $rut=$_POST["rut"];
        $Cliente=$_POST["Cliente"];
        $Empresa=$_POST["Empresa"];
        $DomicilioEmpresa=$_POST["DomicilioEmpresa"];
        $DomicilioDespacho=$_POST["DomicilioDespacho"];
        $Telefono=$_POST["Telefono"];
        $Web=$_POST["Web"];
        $EmailEmpresa=$_POST["EmailEmpresa"];
        $Giro=$_POST["Giro"];
        $Contacto=$_POST["Contacto"];
        $TelefonoContacto=$_POST["TelefonoContacto"];
        $EmailContacto=$_POST["EmailContacto"];
        $TwitterContacto=$_POST["TwitterContacto"];
        $IDComuna=$_POST["IDComuna"];
        $IDFormaPago=$_POST["IDFormaPago"];      
        $Estado=$_POST["Estado"]; 
    }
	
    
    if($_GET["action"] == "create")
	{

		if (!$PERMISOS_CLIENTES['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Clientes :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
	
	$Estado="activo";
		
	$sql=<<<QUERY
		
            INSERT INTO customers
            (rut, 
             Cliente, 
             Empresa, 
             DomicilioEmpresa, 
             DomicilioDespacho, 
             Telefono, 
             Web, 
             EmailEmpresa, 
             Giro, 
             Contacto, 
             TelefonoContacto, 
             EmailContacto, 
             TwitterContacto, 
             IDComuna, 
             IDFormaPago, 
             Estado) 
            VALUES ('$rut', 
                    '$Cliente', 
                    '$Empresa', 
                    '$DomicilioEmpresa', 
                    '$DomicilioDespacho', 
                    '$Telefono', 
                    '$Web', 
                    '$EmailEmpresa', 
                    '$Giro', 
                    '$Contacto', 
                    '$TelefonoContacto', 
                    '$EmailContacto', 
                    '$TwitterContacto', 
                    $IDComuna, 
                    $IDFormaPago, 
                    '$Estado');
		
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
    
	if($_GET["action"] == "update")
	{

		if (!$PERMISOS_CLIENTES['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Clientes :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

        $IDCliente=$_POST["IDCliente"];
        
        $sql=<<<QUERY
		
                UPDATE  customers SET 	rut= '$rut',
					Cliente           = '$Cliente',
					Empresa           = '$Empresa',
					DomicilioEmpresa  = '$DomicilioEmpresa',
					DomicilioDespacho = '$DomicilioDespacho',
					Telefono          = '$Telefono',
					Web               = '$Web',
					EmailEmpresa      = '$EmailEmpresa',
					Giro              = '$Giro',
					Contacto          = '$Contacto',
					TelefonoContacto  = '$TelefonoContacto',
					EmailContacto     = '$EmailContacto',
					TwitterContacto   = '$TwitterContacto',
					IDComuna          = '$IDComuna',
					IDFormaPago       = '$IDFormaPago', 
					Estado            = '$Estado' 
                WHERE IDCliente ='$IDCliente' LIMIT 1 ;		
QUERY;
		
		
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Actualiza Clientes :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Actualiza Clientes :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
    }
	
    else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_CLIENTES['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Clientes :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		$IDCliente=$_POST["IDCliente"];
        
        $sql=<<<QUERY
		DELETE FROM customers 
        WHERE IDCliente = $IDCliente;
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
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
	
	else if($_GET["action"] == "comunas")
	{
		$sql=<<<QUERY
        
            SELECT IDComuna, 
                   Comuna
            FROM comunas order by Comuna;

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
    
    
	else if($_GET["action"] == "FormaPago")
	{
		$sql=<<<QUERY
                    
            SELECT IdFormaPago, Nombre
            FROM formapago;


QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sql,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Nombre"],"Value"=>$row["IdFormaPago"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$resultsql;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "FormaPago :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "FormaPago :: cargar :: SQLERROR -> $msgerror -> $sql";};

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
