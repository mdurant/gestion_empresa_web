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
			$jTableResult['Message']= "Almacenes :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		
		if($_POST["nombrealmacen"]=="" or $_POST["nombrealmacen"]=="null")
		{
			$forma="";
		}else
		{
			$forma=$_POST["nombrealmacen"];
		}
        
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND almacen.Estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM almacen";
		$where="WHERE almacen.Nombre LIKE '%$forma%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
		SELECT
			almacen.IdAlmacen,
			almacen.Descripcion,
			almacen.Nombre,
			almacen.Estado
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
		{ 	$vRESP="OK"; $vMENSAJE = "almacen :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "almacen :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
			$jTableResult['Message']= "Almacenes :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		//Insert record into database
		$IdAlmacen=$_POST["IdAlmacen"];
		$Descripcion=$_POST["Descripcion"];
		$Nombre=$_POST["Nombre"];
		$Estado=$_POST["Estado"];
 
		$sql=<<<QUERY
		INSERT INTO  almacen (
                        IdAlmacen ,
                        Descripcion ,
                        Nombre ,
                        Estado
                        )
                        VALUES (
                        NULL ,  '$Descripcion',  '$Nombre',  '$Estado'
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

		if (!$PERMISOS_ALMACENES['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Almacenes :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


	    $IdAlmacen=$_POST["IdAlmacen"];
        $Descripcion=$_POST["Descripcion"];
        $Nombre=$_POST["Nombre"];
        $Estado=$_POST["Estado"];
	
		$sql=<<<QUERY
		
		UPDATE  almacen SET  Descripcion =  '$Descripcion',
                Nombre =  '$Nombre',
                Estado =  '$Estado' WHERE  almacen.IdAlmacen ='$IdAlmacen';
		
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
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_ALMACENES['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Almacenes :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
    	$IdAlmacen=$_POST["IdAlmacen"];

		$delete=<<<QUERY
		UPDATE  almacen SET  Estado =  'inactivo' WHERE  almacen.IdAlmacen ='$IdAlmacen';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Cotizacion :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Cotizacion :: Facturada :: SQLERROR -> $msgerror -> $sql";};


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
