<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
	if($_GET["action"] == "list")
	{
		 date_default_timezone_set('America/Santiago');
		if($_POST["inventario"]=="" or $_POST["inventario"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["inventario"];
		}
		if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND inventario.estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }
        
        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
            
		$from="FROM
				inventario
				INNER JOIN almacen ON inventario.id_bodega = almacen.IdAlmacen";
		$where="WHERE (almacen.Descripcion LIKE '%$product%' or inventario.responsable LIKE '%$product%') $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
				SELECT
				inventario.id_inventario,
				inventario.dia,
				inventario.hora,
				inventario.id_bodega,
				inventario.responsable,
				inventario.estado,
				almacen.Descripcion
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
		{ 	$vRESP="OK"; $vMENSAJE = "ordenes :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "ordenes :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
		
		
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
		
		//Insert a la tabla de inventarios primero
 			date_default_timezone_set('UTC');
			$dia=date("Y-m-d");
			$hora=date("h:i:s");
			$id_bodega=$_POST["id_bodega"];
			$responsable=$_POST["responsable"];
			
		$sql=<<<QUERY
			
			INSERT INTO inventario(
						inventario.id_inventario,
						inventario.dia,
						inventario.hora,
						inventario.id_bodega,
						inventario.responsable,
						inventario.estado)
						VALUES(NULL,"$dia","$hora","$id_bodega","$responsable","activo");
		
QUERY;
			$result=mysql_query($sql,conectar::con());
			
		//Ahora inserto los datos a la tabla de dinventario insert masivo de todos los nombres de productos mas su stock
		//en la bodega que estan 
		
		//busco el ultimo id insertado en la tabla de inventario para insertarla en la tabla de dinventario
			$IDe = mysql_query("SELECT * FROM inventario WHERE id_inventario = LAST_INSERT_ID()");
			$ultimo = mysql_fetch_array($IDe);
			
		//valido a la tabla que se le hace el select para los productos
		if($id_bodega=="1")
		{
			$salgo=array();
			$selectp=<<<QUERY
			
					SELECT
					product.IDProduct,
					product.IDCellar,
					product.UnitsInStock
					FROM
					product
					WHERE IDCellar = "$id_bodega"
QUERY;
			
			$resulp=mysql_query($selectp,conectar::con());
			while($rowd=mysql_fetch_assoc($resulp))
			{
				$salgo[]=$rowd;
			}
			
			
			for($i=0;$i<sizeof($salgo);$i++)
			{
				$producto=$salgo[$i]['IDProduct'];
				$stock=$salgo[$i]["UnitsInStock"];
				$myquery=<<<QUERY
				
				INSERT INTO dinventario(
							dinventario.id_dinventario,
							dinventario.id_inventario,
							dinventario.producto,
							dinventario.id_bodega,
							dinventario.existencia,
							dinventario.debe)
							VALUES(NULL,$ultimo[0],$producto,$id_bodega,"",$stock)
				
QUERY;

				
				mysql_query($myquery,conectar::con());
			}
			//ya traigo los datos que necesito para el insert masivo segun mis datos
		}else
		{
			$salgo=array();
			$selectp=<<<QUERY
			
					SELECT
					productos.id_productos,
					productos.stock,
					productos.id_bodega
					FROM
					productos
					WHERE id_bodega="$id_bodega"
QUERY;
			
			$resulp=mysql_query($selectp,conectar::con());
			while($rowd=mysql_fetch_assoc($resulp))
			{
				$salgo[]=$rowd;
			}
			
			
			for($i=0;$i<sizeof($salgo);$i++)
			{
				$producto=$salgo[$i]['id_productos'];
				$stock=$salgo[$i]["stock"];
				$myquerys=<<<QUERY
				
				INSERT INTO dinventario(
							dinventario.id_dinventario,
							dinventario.id_inventario,
							dinventario.producto2,
							dinventario.id_bodega,
							dinventario.existencia,
							dinventario.debe)
							VALUES(NULL,$ultimo[0],$producto,$id_bodega,"",$stock)
				
QUERY;
				
				
				$reto=mysql_query($myquerys,conectar::con());
				
			}
		}
		
		
		$msgerror="";
		try
		{  } 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "inventario:: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "inventario :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
					
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['Record'] = $result;
		print json_encode($jTableResult);
	}
	else if($_GET["action"] == "update")
	{
		$id_inventario=$_POST["id_inventario"];
		$id_bodega=$_POST["id_bodega"];
		$responsable=$_POST["responsable"];

			$sql=<<<QUERY
		
			UPDATE inventario SET
					inventario.id_bodega="$id_bodega",
					inventario.responsable="$responsable"
					WHERE id_inventario ="$id_inventario"


		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "inventarios :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "inventarios :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	else if($_GET["action"] == "delete")
	{
		$id_inventario=$_POST["id_inventario"];
		//Delete from database
		$delete=<<<QUERY
		UPDATE inventario set estado="inactivo" WHERE id_inventario = $id_inventario;
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "inventarios :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "inventarios :: Eliminar :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}   
	 else if($_GET["action"] == "Descripcion")
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
