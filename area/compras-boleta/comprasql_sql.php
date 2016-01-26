<?php
require_once("../../validatesession_json.php");
header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{
		if($_POST["rutproveedor"]=="" or $_POST["rutproveedor"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["rutproveedor"];
		}
        
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }
        
        if(empty($_POST["inicio"]) or empty($_POST["fin"]))
        {
            
        }else
        {
        $inicio = date("Y-m-d", strtotime($_POST["inicio"]));
        $fin = date("Y-m-d", strtotime($_POST["fin"]));
        $dat="(fecha_ingreso BETWEEN '".$inicio."' AND '".$fin."') OR";
        }
       
        

        
        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
            
		$from="FROM eboleta 
		INNER JOIN empresa ON 
		eboleta.id_empresa = empresa.IDEmpresa
		INNER JOIN suppliers ON 
		eboleta.id_proveedor = suppliers.IDsuppliers";
		
		$where="WHERE $dat (suppliers.Suppliers
			LIKE '%$product%' or empresa.RazonSocial
			LIKE '%$product%'
			or
			eboleta.contador LIKE '%$product%')  $radiosss";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<< QUERY
		SELECT eboleta.id_boleta, 
		eboleta.contador, 
		eboleta.folio_boleta, 
		eboleta.fecha_compra, 
		eboleta.fecha_ingreso, 
		eboleta.id_empresa, 
		eboleta.id_proveedor, 
		eboleta.estado, 
		replace(format(eboleta.total,0),',','.') total,
		replace(format(eboleta.iva,0),',','.')iva,
		replace(format(eboleta.neto,0),',','.') neto,
		eboleta.estadocontable, 
		empresa.RazonSocial, 
		suppliers.Suppliers
		$from  $where
		ORDER BY id_boleta DESC
		$limit;	
					
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Boletas :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Boletas :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
		
		
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

 
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		
    	 $IdEFactura=$_POST["id_boleta"];

		$delete=<<<QUERY
		UPDATE  eboleta SET  estado =  'inactivo' WHERE  eboleta.estado ='$IdEFactura';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Factura :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "factura :: Facturada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
    
    
    	else if($_GET["action"] == "devolucion")
	{
		
    	 $IdEFactura=$_GET["dato"];

    //primero cambio el estado de la efactura
        
		$seleccion=<<<QUERY
		update ecompra set Estado="Devuelto" where id_ecompra = "$IdEFactura";
QUERY;
        mysql_query($seleccion,conectar::con());
        
        //selecciono todos los rows de dfatura
        
        $selecciondfactura=<<<QUERY
        select * from dcompra where id_ecompra= "$IdEFactura"
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Factura :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Fctura :: Facturada :: SQLERROR -> $msgerror -> $sql";};


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
