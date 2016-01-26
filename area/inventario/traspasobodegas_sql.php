<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{
		if($_POST["nombreproducto"]=="" or $_POST["nombreproducto"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["nombreproducto"];
		}
        
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND productos.estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM
				productos";
		$where="WHERE id_bodega <> '1' and productos.ProductName LIKE '%$product%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
                SELECT
				productos.id_productos,
				productos.ProductName,
				productos.descripcion,
				productos.stock,
				productos.precio_compra,
				productos.precio_venta,
				productos.id_bodega,
				productos.estado,
				productos.id_product
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
		{ 	$vRESP="OK"; $vMENSAJE = "producto :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "producto :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
		$id_porducto=$_GET["id_prod"];
		$nombre_producto=$_GET["pro_name"];
		$almacen=$_GET["almacen"];
		$cantidad=$_GET["canti"];
		$otro_id=$_GET["otro"];
		$descripciones=$_GET["descripcione"];
		$compra=$_GET["compra"];
		$venta=$_GET["venta"];
		if($almacen=="1")
		{
			$quer=<<<QUERY
		
		UPDATE product SET UnitsInStock=(UnitsInStock+"$cantidad") WHERE IDProduct="$otro_id"
QUERY;
			
				mysql_query($consulta,conectar::con());
	
		}else
		{
				$seleccion=<<<QUERY
				SELECT * FROM productos WHERE id_product="$otro_id" AND id_bodega="$almacen"
QUERY;
			$valor=mysql_query($seleccion,conectar::con());
			if(mysql_num_rows($valor)==0)
			{
				$inserto=<<<QUERY
				INSERT INTO productos(
				productos.id_productos,
				productos.ProductName,
				productos.descripcion,
				productos.stock,
				productos.precio_compra,
				productos.precio_venta,
				productos.id_bodega,
				productos.estado,
				productos.id_product)
				VALUES(NULL,"$nombre_producto","$descripciones","$cantidad","$compra","$venta","$almacen","activo","$otro_id")
QUERY;
				mysql_query($inserto,conectar::con());
			}else
			{
			}
		
		}
		
	
			
				$sql=<<<QUERY
		UPDATE productos SET stock=(stock-"$cantidad") WHERE id_productos="$id_porducto"
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
		
    	$IDProduct=$_POST["IDProduct"];

		$delete=<<<QUERY
		UPDATE  product SET Estado =  'inactivo' WHERE  product.IDProduct ='$IDProduct';
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
    else if($_GET["action"] == "proveedores")
	{
		$sqlpro=<<<QUERY
        
        SELECT
        suppliers.Suppliers,
        suppliers.IDsuppliers
        FROM
        suppliers
QUERY;
        
		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlpro,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Suppliers"],"Value"=>$row["IDsuppliers"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
        
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "proveedores :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "proveedores :: cargar :: SQLERROR -> $msgerror -> $sqlpro";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;
        
        print json_encode($result);
        
	}
    else if($_GET["action"] == "CategoryProduct")
	{
		$sqlcat=<<<QUERY
        
        SELECT
        category_product.IDCategoryProduct,
        category_product.CategoryProduct
        FROM
        category_product
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlcat,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["CategoryProduct"],"Value"=>$row["IDCategoryProduct"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "CategoryProduct :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "CategoryProduct :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
   
     else if($_GET["action"] == "unidad")
	{
		$sqlun=<<<QUERY
        
        SELECT
        unidad.IDUnidad,
        unidad.Unidad
        FROM
        unidad
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlun,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Unidad"],"Value"=>$row["IDUnidad"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Almacen :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Almacen :: cargar :: SQLERROR -> $msgerror -> $sqlun";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
	else if($_GET["action"] == "Nombre")
	{
		$sqlnom=<<<QUERY
        
        SELECT
        almacen.IdAlmacen,
      	almacen.Descripcion
        FROM
        almacen
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlnom,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Descripcion"],"Value"=>$row["IdAlmacen"]);
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
