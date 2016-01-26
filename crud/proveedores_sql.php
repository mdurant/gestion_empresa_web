<?php

header('Content-Type: text/html; charset=UTF-8');


require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_PROVEEDORES=array();
$PERMISOS_PROVEEDORES=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'PROVEEDORES');


require_once("../conexion/conexion.php");




try
{

	if($_GET["action"] == "list")
	{


		if (!$PERMISOS_PROVEEDORES['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Proveedores :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}



		if($_POST["proveedor"]=="" or $_POST["proveedor"]=="null")
		{
			$proveedor="";
		}else
		{
			$proveedor=$_POST["proveedor"];
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

		$from="FROM suppliers";
		$where="where Suppliers LIKE '%$proveedor%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2="SELECT COUNT(*) AS RecordCount $from $where";
        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
            SELECT IDsuppliers, 
                   RUT, 
                   Suppliers, 
                   CompanyName, 
                   ContactName, 
                   PhoneContact, 
                   PhoneCompany, 
                   EmailCompany, 
                   WebCompany, 
                   Address, 
                   AddressOffice, 
                   IDCity, 
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
		{ 	$vRESP="OK"; $vMENSAJE = "Proveedores :: Listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Proveedores :: Listar :: SQLERROR -> $msgerror -> $sql";};
		
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
        $Suppliers=$_POST["Suppliers"]; 
        $CompanyName=$_POST["CompanyName"]; 
        $ContactName=$_POST["ContactName"]; 
        $PhoneContact=$_POST["PhoneContact"]; 
        $PhoneCompany=$_POST["PhoneCompany"]; 
        $EmailCompany=$_POST["EmailCompany"]; 
        $WebCompany=$_POST["WebCompany"]; 
        $Address=$_POST["Address"]; 
        $AddressOffice=$_POST["AddressOffice"]; 
        $IDCity=$_POST["IDCity"]; 
        $Estado=$_POST["Estado"];

    }
	
    
    if($_GET["action"] == "create")
	{
		
		if (!$PERMISOS_PROVEEDORES['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Proveedores :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		$sql=<<<QUERY
		
        
            INSERT INTO suppliers
            (RUT, 
             Suppliers, 
             CompanyName, 
             ContactName, 
             PhoneContact, 
             PhoneCompany, 
             EmailCompany, 
             WebCompany, 
             Address, 
             AddressOffice, 
             IDCity, 
             Estado) 
            VALUES ('$RUT', 
                    '$Suppliers', 
                    '$CompanyName', 
                    '$ContactName', 
                    '$PhoneContact', 
                    '$PhoneCompany', 
                    '$EmailCompany', 
                    '$WebCompany', 
                    '$Address', 
                    '$AddressOffice', 
                    $IDCity, 
                    '$Estado');

QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());
			
		} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Proveedores :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Proveedores :: Ingresar :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['Record'] = $result;
		print json_encode($jTableResult);
    }
    
	if($_GET["action"] == "update")
	{

		if (!$PERMISOS_PROVEEDORES['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Proveedores :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

        $IDsuppliers=$_POST["IDsuppliers"];
        
        $sql=<<<QUERY
		
            UPDATE suppliers
            SET
               RUT           = '$RUT',
               Suppliers     = '$Suppliers',
               CompanyName   = '$CompanyName',
               ContactName   = '$ContactName',
               PhoneContact  = '$PhoneContact',
               PhoneCompany  = '$PhoneCompany',
               EmailCompany  = '$EmailCompany',
               WebCompany    = '$WebCompany', 
               Address       = '$Address',
               AddressOffice = '$AddressOffice',
               IDCity        = $IDCity,
               Estado        = '$Estado' 
            WHERE IDsuppliers =  $IDsuppliers;


QUERY;
		
		
		
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

		if (!$PERMISOS_PROVEEDORES['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Proveedores :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		$IDsuppliers=$_POST["IDsuppliers"];
        
        $sql=<<<QUERY
        
        DELETE FROM suppliers 
        WHERE IDsuppliers = $IDsuppliers;

QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Proveedores :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Proveedores :: Eliminar :: SQLERROR -> $msgerror -> $sql";};


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
