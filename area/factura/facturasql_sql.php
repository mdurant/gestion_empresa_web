<?php
require_once("../../validatesession_json.php");
header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{
		if($_POST["rutcliente"]=="" or $_POST["rutcliente"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["rutcliente"];
		}
        
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND efactura.Estado='activo'";
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
        $dat="(FechaCreacion BETWEEN '".$inicio."' AND '".$fin."') and";
        }
       
        

        
        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
            
		$from="FROM
                efactura
                INNER JOIN empresa ON efactura.IDEmpresa = empresa.IDEmpresa
                INNER JOIN customers ON efactura.IdCliente = customers.IDCliente";
		$where="WHERE $dat (customers.rut LIKE '%$product%' or empresa.RazonSocial LIKE '%$product%' or efactura.Numero LIKE '%$product%')  $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
		SELECT
                efactura.IdEFactura,
                efactura.Numero,
                efactura.IdCliente,
                customers.Cliente,
                empresa.RazonSocial,
                replace(format(efactura.Total,0),',','.') Total,
                efactura.FechaCreacion,
                efactura.Estado
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
