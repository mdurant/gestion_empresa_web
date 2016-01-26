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
        

		$from="FROM
				dplantillaot
				INNER JOIN almacen ON dplantillaot.id_almacen = almacen.IdAlmacen";
		$where="WHERE id_plantillaot = '$get_val'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

		$result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
		$sql=<<<QUERY
			
				SELECT
				dplantillaot.id_dplantillaot,
				dplantillaot.id_plantillaot,
				dplantillaot.posicion,
				dplantillaot.Codigo,
				dplantillaot.descripcion,
				dplantillaot.cantidad,
				almacen.Descripcion,
				dplantillaot.id_almacen
                $from $where $limit;		
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "perfiles_permiso :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "perfiles_permiso :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
	else if($_GET["action"] == "Descripcion")
	{
		$sqlprov=<<<QUERY
        
					SELECT
						almacen.IdAlmacen,
						almacen.Descripcion
						FROM
						almacen

QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlprov,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Descripcion"],"Value"=>$row["IdAlmacen"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "provincias :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "provincias :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

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
