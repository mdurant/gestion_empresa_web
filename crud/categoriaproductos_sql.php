<?php

header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_CATEGORIAPRODUCTOS=array();
$PERMISOS_CATEGORIAPRODUCTOS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'CATEGORIAPRODUCTOS');



require_once("../conexion/conexion.php");




try
{

	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_CATEGORIAPRODUCTOS['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Categorias de Productos :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}



		if($_POST["description"]=="" or $_POST["description"]=="null")
		{
			$catproductos="";
		}else
		{
			$catproductos=$_POST["description"];
		}

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM category_product";
		$where="WHERE Description like '%$catproductos%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2="SELECT COUNT(*) AS RecordCount $from $where";
        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
                SELECT
		IDCategoryProduct, 
                CategoryProduct, 
                Description 
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
		{ 	$vRESP="OK"; $vMENSAJE = "Categoria Productos :: Listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Categoria Productos :: Listar :: SQLERROR -> $msgerror -> $sql";};
		
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
        
        $CategoryProduct=$_POST["CategoryProduct"]; 
        $Description=$_POST["Description"];

    }
	
    
    if($_GET["action"] == "create")
	{
		
		if (!$PERMISOS_CATEGORIAPRODUCTOS['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Categorias de Productos :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		
		$sql=<<<QUERY
		
            INSERT INTO category_product
            (CategoryProduct, 
             Description) 
            VALUES ('$CategoryProduct', 
                    '$Description');

QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Categoria Productos :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Categoria Productos :: Ingresar :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['Record'] = $result;
		print json_encode($jTableResult);
    }
    
	if($_GET["action"] == "update")
	{

		if (!$PERMISOS_CATEGORIAPRODUCTOS['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Categorias de Productos :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

        $IDCategoryProduct=$_POST["IDCategoryProduct"];
        
        $sql=<<<QUERY
		
        
            UPDATE category_product
            SET
               CategoryProduct = '$CategoryProduct',
               Description     = '$Description' 
            WHERE IDCategoryProduct = $IDCategoryProduct; 
        

QUERY;
		
		
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Categoria Productos  :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Categoria Productos  :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
    }
	
    else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_CATEGORIAPRODUCTOS['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Categorias de Productos :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		$IDCategoryProduct=$_POST["IDCategoryProduct"];
        
        $sql=<<<QUERY
        
        DELETE FROM category_product 
        WHERE IDCategoryProduct = $IDCategoryProduct;

QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Categoria Productos  :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Categoria Productos  :: Eliminar :: SQLERROR -> $msgerror -> $sql";};


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
