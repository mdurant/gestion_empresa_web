<?php
require_once("../../conexion/conexion.php");
class select
{
 public function trabajadores(){

	$salida=array();
	$query="SELECT trabajador.id_trabajador, concat(nombres, ' ' ,apellidop, ' ', apellidom) as datos_trabajador
FROM trabajador";
	$res=mysql_query($query,Conectar::con());
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
	$res=mysql_query($query,Conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}

public function proyecto()
{
    $salida=array();
    $query="SELECT proyectos.id_proyecto,
    proyectos.nombre_proyecto,
    proyectos.Estado
FROM proyectos
where Estado = 'activo'
order by id_proyecto asc";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}public function code_autocomplete()
	{
	$salida=array();
	$query="SELECT * FROM product";
	$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row["CodeBar"];
			}
		return $salida;

	}
public function clientes()
	{
	$salida=array();
	$query="Select * from customers";
	$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
	return $salida;
	}

// Quien autoriza
public function quien_autoriza()
{
    $salida=array();
    $query="SELECT trabajador.id_trabajador,
UCASE(concat(nombres, ' ', apellidop) )as datos_trabajador
FROM trabajador";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}

public function motivoguia()
{
    $salida=array();
    $query="SELECT motivo_guia.IDMotivo,
    motivo_guia.nombre_motivo,
    motivo_guia.Estado
    FROM motivo_guia
    WHERE Estado='activo'";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}

	
public function almacen() // Se modifica query para apuntar s�lo a la 0100/Central - Mauricio
	{
	$salida=array();
	$query="SELECT
	almacen.IdAlmacen,
	almacen.Descripcion,
	almacen.Estado,
	almacen.Nombre
	FROM
	almacen
	where 
	Nombre <='0100'";
	$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
	return $salida;
	}
	
	
public function ObtieneGuia()
	{
	$guia="";
	$query= "select * from eguiadespacho";
	$resul=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($resul))
			{
				$guia=$row["contador"];
			}
		if(!$Factura)
			{
				$guia="70000001";
			}
		else
		{
			$guia= $guia + 1;
		}
	return $guia;
				
	}
public function eordend($id)
		{
			$salida=array();
			$query=<<<QUERY
			select * from eorden where id_orden="$id"
QUERY;
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row;
			}
			return $salida;
			
		}
			public function dordend($id)
		{
			$salida=array();
			$query=<<<QUERY
			select * from dorden where id_orden="$id"
QUERY;
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row;
			}
			return $salida;
			
		}
	
}
if($_GET["action"] == "clientes")
	{
		$sqlcat=<<<QUERY
        
        SELECT
        customers.IDCliente,
        customers.Cliente
        FROM
        customers
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlcat,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Cliente"],"Value"=>$row["IDCliente"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Clientes :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Clientes :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
?>