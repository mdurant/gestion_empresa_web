<?php
require_once("../../validatesession_json.php");
header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
	if($_GET["action"] == "list")
	{
		 date_default_timezone_set('America/Santiago');
		if($_POST["proveedores"]=="" or $_POST["proveedores"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["proveedores"];
		}
        
        if(empty($_POST["inicio"]) or empty($_POST["fin"]))
        {
            
        }else
        {
        $inicio = date("Y-m-d", strtotime($_POST["inicio"]));
        $fin = date("Y-m-d", strtotime($_POST["fin"]));
        $dat="(fecha_ingreso BETWEEN '".$inicio."' AND '".$fin."') and";
        }
        
        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
            
		$from="FROM
				ecompra
				INNER JOIN empresa ON ecompra.id_empresa = empresa.IDEmpresa
				INNER JOIN suppliers ON ecompra.id_provedores = suppliers.IDsuppliers";
		$where="WHERE $dat (suppliers.Suppliers LIKE '%$product%' or empresa.RazonSocial LIKE '%$product%' or ecompra.folio_compra LIKE '%$product%')";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
				SELECT
				ecompra.id_ecompra,
				ecompra.folio_compra,
				ecompra.fecha_ingreso,
				empresa.RazonSocial,
				suppliers.Suppliers,
				ecompra.total
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
		{ 	$vRESP="OK"; $vMENSAJE = "boleta :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "boleta :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
		
		
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
