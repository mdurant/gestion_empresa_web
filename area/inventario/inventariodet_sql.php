<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{
		$jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
		$get_val=$_GET["IDPerfil"];
        $bsq=$_POST["Item"];
        $valido=$_GET["valido"];
		if($valido==1)
		{
		$from="FROM
				dinventario
				INNER JOIN inventario ON dinventario.id_inventario = inventario.id_inventario
				INNER JOIN product ON dinventario.producto = product.IDProduct
				INNER JOIN almacen ON dinventario.id_bodega = almacen.IdAlmacen";
		$where="WHERE dinventario.id_inventario = '$get_val'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

		$result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
		$sql=<<<QUERY
			
				SELECT
				dinventario.id_dinventario,
				dinventario.producto,
				dinventario.id_bodega,
				dinventario.existencia,
				dinventario.id_inventario,
				product.ProductName,
				product.UnitsInStock
                $from $where $limit;		
QUERY;
		
		}//cierre del if 
		else
		{
			$from="FROM
				dinventario
				INNER JOIN inventario ON dinventario.id_inventario = inventario.id_inventario
				INNER JOIN productos ON dinventario.producto2 = productos.id_productos
				INNER JOIN almacen ON dinventario.id_bodega = almacen.IdAlmacen";
		$where="WHERE dinventario.id_inventario = '$get_val'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

		$result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
		$sql=<<<QUERY
			
				SELECT
				dinventario.id_dinventario,
				dinventario.producto2,
				dinventario.id_bodega,
				dinventario.existencia,
				dinventario.id_inventario,
				productos.ProductName
                $from $where $limit;		
QUERY;
		
		}
        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "dorden :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "dorden :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
		else if($_GET["action"] == "update")
	{
		$id_inventario=$_POST["id_dinventario"];
		$existencia=$_POST["existencia"];

			$sql=<<<QUERY
		
			UPDATE dinventario set existencia="$existencia", haber="$existencia", saldo=(debe-$existencia) where id_dinventario="$id_inventario"


		
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
		
	}	else if($_GET["action"] == "actualizar")
	{
		$id_st=$_GET["dat"];
        $bodega=$_GET["dat2"];

			$sqles=<<<QUERY
		
	SELECT * FROM dinventario WHERE id_inventario="$id_st"
		
QUERY;
        $sted=array();
        $res=mysql_query($sqles,conectar::con());
        while($rod=mysql_fetch_assoc($res))
        {
            $sted[]=$rod;
        }
        if($bodega==1){
        for($i=0;$i<sizeof($sted);$i++)
        {
            $idproduct=$sted[$i]["producto"];
            $descontar=$sted[$i]["existencia"];
           $sqles2=<<<QUERY
           UPDATE product SET UnitsInStock="$descontar" WHERE IDProduct="$idproduct"
QUERY;
            mysql_query($sqles2,conectar::con());
        }
        }else
        {
            for($i=0;$i<sizeof($sted);$i++)
        {
            $idproduct=$sted[$i]["producto2"];
            $descontar=$sted[$i]["existencia"];
            $sqles2=<<<QUERY
           UPDATE productos SET stock="$descontar" WHERE id_productos="$idproduct" AND id_bodega="$bodega"
QUERY;
            mysql_query($sqles2,conectar::con());
          
        }
           
        }
		
		
		//die($sql);
        $sql=<<<QUERY
        
      UPDATE inventario set estado_act="actualizado" where id_inventario="$id_st"  ;
QUERY;
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
