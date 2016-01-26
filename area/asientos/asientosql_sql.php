<?php
require_once("../../validatesession_json.php");
header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{
		if($_POST["asiento"]=="" or $_POST["asiento"]=="null")
		{
			$asiento="";
		}else
		{
			$asiento=$_POST["asiento"];
		}
        
        if($_POST['centralizado']=="1" or $_POST['centralizado']=="")
        {
            $radio="AND easientos.codigo='contabilizado'";
        }elseif($_POST['centralizado']=="2")
        {
            $radio="";
        }
        
        if(empty($_POST["inicio"]) or empty($_POST["fin"]))
        {
            
        }else
        {
        $inicio = date("Y-m-d", strtotime($_POST["inicio"]));
        $fin = date("Y-m-d", strtotime($_POST["fin"]));
        $dat="(fecha_registro BETWEEN '".$inicio."' AND '".$fin."') and";
        }
       
        

        
        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
            
		$from="FROM easientos";
		$where="WHERE $dat (easientos.voucher LIKE '%$asiento%')  $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		// Se agrega columna "Codigo: contabilizado o centralizado" 
        $sql=<<<QUERY
			
		SELECT idasiento,
		voucher,
		fecha_registro,
		fecha_contable,
		documento_referencia,
		referencia,
		glosa,
		total_debe,
		total_haber,
		id_empresa,
		codigo
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
		{ 	$vRESP="OK"; $vMENSAJE = "facturas :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "facturas :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
		
		
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
		
    	 $IdEFactura=$_POST["IdEFactura"];

		$delete=<<<QUERY
		UPDATE  efactura SET  Estado =  'inactivo' WHERE  efactura.IdEFactura ='$IdEFactura';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "factura :: Facturada :: OK!";	}
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
		update efactura set Estado="Devuelto" where IdEFactura = "$IdEFactura";
QUERY;
        mysql_query($seleccion,conectar::con());
        
        //selecciono todos los rows de dfatura
        
        $selecciondfactura=<<<QUERY
        select * from dfactura where IdDFactura= "$IdEFactura"
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "factura :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "factura :: Facturada :: SQLERROR -> $msgerror -> $sql";};


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
