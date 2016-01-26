<?php

header('Content-Type: text/html; charset=UTF-8');


require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_SUCURSALES=array();
$PERMISOS_SUCURSALES=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'SUCURSALES');



require_once("../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_SUCURSALES['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Sucursales :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


		if($_POST["nombresucursal"]=="" or $_POST["nombresucursal"]=="null")
		{
			$forma="";
		}else
		{
			$forma=$_POST["nombresucursal"];
		}
        
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND sucursales.Estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM
                sucursales
                INNER JOIN empresa ON sucursales.IDempresa = empresa.IDEmpresa";
		$where="WHERE sucursales.Nombre LIKE '%$forma%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
				SELECT
                sucursales.IDSucursal,
                sucursales.Nombre,
                sucursales.Domicilio,
                sucursales.Email,
                sucursales.IDempresa,
                sucursales.Estado,
                empresa.RazonSocial
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
		{ 	$vRESP="OK"; $vMENSAJE = "sucursal :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "sucursal :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
		
		if (!$PERMISOS_SUCURSALES['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Sucursales :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		//Insert record into database
        $IDSucursal=$_POST["IDSucursal"];
        $Nombre=$_POST["Nombre"];
        $Domicilio=$_POST["Domicilio"];
        $Email=$_POST["Email"];
        $IDempresa=$_POST["IDempresa"];
        $Estado=$_POST["Estado"];
 
		$sql=<<<QUERY
		INSERT INTO sucursales (
                    IDSucursal ,
                    Nombre ,
                    Domicilio ,
                    Email ,
                    IDempresa ,
                    Estado
                    )
                    VALUES (
                    NULL ,  '$Nombre',  '$Domicilio',  '$Email',  '$IDempresa',  '$Estado'
                    );



		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "sucursal :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "sucursal :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
					
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


		if (!$PERMISOS_SUCURSALES['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Sucursales :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}



	     $IDSucursal=$_POST["IDSucursal"];
        $Nombre=$_POST["Nombre"];
        $Domicilio=$_POST["Domicilio"];
        $Email=$_POST["Email"];
        $IDempresa=$_POST["IDempresa"];
        $Estado=$_POST["Estado"];
	
			$sql=<<<QUERY
		
		UPDATE  sucursales SET  Nombre =  '$Nombre',
                Domicilio =  '$Domicilio',
                Email =  '$Email',
                IDempresa =  '$IDempresa',
                Estado =  '$Estado' WHERE  sucursales.IDSucursal ='$IDSucursal';

		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "sucursal :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "sucursal :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_SUCURSALES['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Sucursales :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
    	$IDSucursal=$_POST["IDSucursal"];

		$delete=<<<QUERY
		UPDATE  sucursales SET  Estado =  'inactivo' WHERE  sucursales.IDSucursal ='$IDSucursal';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "sucursal :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "sucursal :: Facturada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	} else if($_GET["action"] == "Nombre")
	{
		$sqlnom=<<<QUERY
        
        SELECT
        almacen.IdAlmacen,
        almacen.Nombre
        FROM
        almacen
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlnom,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Nombre"],"Value"=>$row["IdAlmacen"]);
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
     else if($_GET["action"] == "empresa")
	{
		$sqlun=<<<QUERY
        
        SELECT
        empresa.IDEmpresa,
        empresa.RazonSocial
        FROM
        empresa
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlun,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["RazonSocial"],"Value"=>$row["IDEmpresa"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "empresa :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "empresa :: cargar :: SQLERROR -> $msgerror -> $sqlun";};

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
