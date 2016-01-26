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
            $radio="AND eguiadespacho.Estado='activo'";
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
                eguiadespacho
                INNER JOIN empresa ON eguiadespacho.IDEmpresa = empresa.IDEmpresa
                INNER JOIN customers ON eguiadespacho.IdCliente = customers.IDCliente";
		$where="WHERE $dat (customers.rut LIKE '%$product%' or empresa.RazonSocial LIKE '%$product%' or eguiadespacho.Numero LIKE '%$product%')  $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			SELECT
			eguiadespacho.IdEGuiaDespacho, 
			eguiadespacho.Numero, 
			eguiadespacho.IdCliente,
			customers.Cliente,
			empresa.RazonSocial,
			eguiadespacho.Total, 
			eguiadespacho.FechaCreacion, 
			eguiadespacho.estadocontable
	
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
		{ 	$vRESP="OK"; $vMENSAJE = "Guias de Despacho :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Guias de Despacho :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
		
		
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
		
    	 $IdEGuiaDespacho=$_POST["IdEGuiaDespacho"];

		$delete=<<<QUERY
		UPDATE  eguiadespacho SET  Estado =  'inactivo' WHERE  eguiadespacho.IdEGuiaDespacho ='$IdEGuiaDespacho';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Guia de Despacho :: Anulada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Guia de Despacho :: Anulada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
    
    
    	else if($_GET["action"] == "devolucion")
	{
		
    	 $IdEGuiaDespacho=$_GET["dato"];

    //primero cambio el estado de la efactura
        
		$seleccion=<<<QUERY
		update eguiadespacho set Estado="Devuelto" where IdEGuiaDespacho = "$IdEGuiaDespacho";
QUERY;
        mysql_query($seleccion,conectar::con());
        
        //selecciono todos los rows de dfatura
        
        $selecciondfactura=<<<QUERY
        select * from dguiadespacho where IdDGuia= "$IdEGuiaDespacho"
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Guia de Despacho :: Devuelta :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Guia de Despacho :: Devuelta :: SQLERROR -> $msgerror -> $sql";};


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
