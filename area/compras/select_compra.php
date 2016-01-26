<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");
class select
{
public function proveedores()
	{
		$salida=array();
		$query="SELECT suppliers.IDsuppliers, 
			suppliers.RUT, 
			suppliers.Suppliers
			FROM suppliers
			WHERE Estado = 'activo'
			order by Suppliers asc";
		$res=mysql_query($query,conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
		$salida[]=$row;
		}
		return $salida;
	}
public function empresas()
{
	$salida=array();
	$query="SELECT
			empresa.IDEmpresa,
			empresa.RazonSocial
			FROM
			empresa";
	$res=mysql_query($query,conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}
public function forma_pago()
{
	$salida=array();
	$query="SELECT
			formapago.IdFormaPago,
			formapago.Nombre
			FROM
			formapago
			where IdFormaPago = 3 or
			IdFormaPago = 13 or IdFormaPago = 14";
	$res=mysql_query($query,conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}
public function ObtieneCompra()
		{
		$Compra="";
		$query= "select * from ecompra";
		$resul=mysql_query($query,conectar::con());
		while($row=mysql_fetch_assoc($resul))
		{
			$Compra=$row["contador"];
		}
		if(!$Compra)
		{
			$Compra="10000001";
		}
		else
		{
			$Compra= $Compra + 1;
		}
		return $Compra;
		
		}
public function code_autocomplete()
{
	$salida=array();
	$query="SELECT CodeBar FROM product";
	$res=mysql_query($query,conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row["CodeBar"];
	}
	return $salida;

}
}
if($_GET["action"] == "proveedores")
	{
		$sqlcat=<<<QUERY
        
			SELECT suppliers.IDsuppliers, 
			suppliers.RUT, 
			suppliers.Suppliers
			FROM suppliers
			WHERE Estado = 'activo'
			order by Suppliers asc
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlcat,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Suppliers"],"Value"=>$row["IDsuppliers"]);
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
?>