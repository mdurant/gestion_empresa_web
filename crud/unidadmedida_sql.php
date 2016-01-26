<?php

header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_UNIDADMEDIDA=array();
$PERMISOS_UNIDADMEDIDA=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'UNIDADMEDIDA');

require_once("../conexion/conexion.php");




try
{

	if($_GET["action"] == "list")
	{
		
		if (!$PERMISOS_UNIDADMEDIDA['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Unidad de Medidas :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}		
		
		
		
		if($_POST["umedida"]=="" or $_POST["umedida"]=="null")
		{
			$umedida="";
		}else
		{
			$umedida=$_POST["umedida"];
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

		$from="FROM unidad";
		$where="where Unidad LIKE '%$umedida%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2="SELECT COUNT(*) AS RecordCount $from $where";
        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
            SELECT IDUnidad, 
                   Unidad, 
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
		{ 	$vRESP="OK"; $vMENSAJE = "Unidad Medida :: Listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Unidad Medida :: Listar :: SQLERROR -> $msgerror -> $sql";};
		
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
        
        $Unidad=$_POST["Unidad"]; 
        $Descripcion=$_POST["Descripcion"]; 
        $Estado=$_POST["Estado"]; 
        

    }
	
    
    if($_GET["action"] == "create")
	{

		if (!$PERMISOS_UNIDADMEDIDA['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Unidad de Medidas :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
		$sql=<<<QUERY
		
        
            INSERT INTO unidad
            (IDUnidad, 
             Unidad,
             Descripcion, 
             Estado) 
            VALUES ('$IDUnidad', 
                    '$Unidad', 
                    '$Descripcion', 
                    '$Estado');

QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Unidad Medida :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Unidad Medida :: Ingresar :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['Record'] = $result;
		print json_encode($jTableResult);
    }
    
	if($_GET["action"] == "update")
	{

		if (!$PERMISOS_UNIDADMEDIDA['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Unidad de Medidas :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
        $IDUnidad=$_POST["IDUnidad"];
        
        $sql=<<<QUERY
		
            UPDATE unidad
            SET
               Unidad      = '$Unidad',
               Descripcion = '$Descripcion',
               Estado      = '$Estado'
            WHERE IDUnidad =  $IDUnidad;


QUERY;
		
		
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Unidad Medida :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Unidad Medida :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
    }
	
    else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_UNIDADMEDIDA['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Unidad de Medidas :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


		$IDUnidad=$_POST["IDUnidad"];
        
        $sql=<<<QUERY
        
        DELETE FROM unidad 
        WHERE IDUnidad = $IDUnidad;

QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Unidad Medida :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Unidad Medida :: Eliminar :: SQLERROR -> $msgerror -> $sql";};


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
