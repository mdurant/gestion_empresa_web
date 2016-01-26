<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
	if($_GET["action"] == "list")
	{
		 date_default_timezone_set('America/Santiago');
		
        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
        $get_val=$_GET["IDPerfil"];
		
		if (!$get_val)
		{
			$get_val=$_POST["IDPerfil"];
		}
            
		$from="FROM
                entrega_orden";
		$where="WHERE id_dorden='$get_val'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
				SELECT
				entrega_orden.id_dorden,
                entrega_orden.id_entrega,
                entrega_orden.id_codebar,
                entrega_orden.cantidad_entrega,
                entrega_orden.fecha_entrega,
                entrega_orden.id_dorden,
                entrega_orden.responsable_entrega,
                entrega_orden.receptor
				$from  
                $where
				ORDER BY id_entrega
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
		
		//Insert record into database
        $id_dorden=$_POST["id_dorden"];
        $CodeBar=$_GET["Codigo"];
		
		if (!$CodeBar){
			$CodeBar=$_POST["Codigo"];
		}

        $cantidad=$_POST["cantidad_entrega"];
        $responsable=$_POST["responsable_entrega"];
        $receptor=$_POST["receptor"];
        $fecha=date("Y-m-d");
        
        
 
		$sql=<<<QUERY
        		INSERT INTO entrega_orden(
                            entrega_orden.id_entrega,
                            entrega_orden.id_codebar,
                            entrega_orden.cantidad_entrega,
                            entrega_orden.fecha_entrega,
                            entrega_orden.id_dorden,
                            entrega_orden.responsable_entrega,
                            entrega_orden.receptor)
                            VALUES(NULL,"$CodeBar","$cantidad","$fecha","$id_dorden","$responsable","$receptor");
QUERY;
            //hago un update al total de mi registro
            
            //aqui hago el descuento de stock a la tabla 0100
            $decuento=<<<QUERY
            
            UPDATE product SET UnitsInStock=(UnitsInStock-$cantidad) WHERE CodeBar="$CodeBar"
QUERY;
            mysql_query($decuento,conectar::con());
            
            
            
		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "productos :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "productos :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
		$traes = mysql_query("SELECT * FROM entrega_orden WHERE id_entrega = LAST_INSERT_ID()",conectar::con());
		$row = mysql_fetch_array($traes);
        		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
        $jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	
	
	else if($_GET["action"] == "delete")
	{
		$id_plantillaot=$_POST["id_plantillaot"];
		//Delete from database
		$delete=<<<QUERY
		UPDATE eplantillaot set estado="inactivo" WHERE id_plantillaot = $id_plantillaot;
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
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
    else if($_GET["action"] == "cer")
	{
		echo "estas viendo";
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
