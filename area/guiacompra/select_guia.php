<?php
require_once("../../conexion/conexion.php");
class funciones
{
 public function plantilla($id)
 	{
 		$salida=array();
 		$query="SELECT * from eplantillaot where id_plantillaot ='$id'";
 		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		return $salida;
 	}
	public function dplantilla($id)
 	{
 		$salida=array();
 		$query="SELECT * from dplantillaot where id_plantillaot ='$id'";
 		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		return $salida;
 	}
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

public function proveedores()
{
	$salida=array();
	$query="SELECT * FROM
	suppliers
	where
	Estado = 'activo'
	order by Suppliers asc";
	$res=mysql_query($query,Conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}

public function proyectos()
{
	$salida=array();
	$query="SELECT proyectos.id_proyecto, 
	proyectos.nombre_proyecto, 
	proyectos.fecha_inicio, 
	proyectos.fecha_compromiso, 
	proyectos.id_cliente, 
	proyectos.Estado
FROM proyectos
where proyectos.Estado = 'activo'";
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
    //

public function obtieneguia()
				{
				$guia="";
				$query= "select * from eguiacompra";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$guia=$row["numero"];
				}
				if(!$guia)
				{
					$guia="60000001";
				}
				else
				{
					$guia= $guia + 1;
				}
				return $guia;
				
				}
    public function code_autocomplete()
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
	public function almacen() // Se modifica query para apuntar sólo a la 0100/Central - Mauricio
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
	
	
	public function eguiad($id)
		{
			$salida=array();
			$query=<<<QUERY
			select * from eguiadespacho where IdEGuiaDespacho="$id"
QUERY;
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row;
			}
			return $salida;
			
		}
	
	public function dguiad($id)
		{
			$salida=array();
			$query=<<<QUERY
			select * from dguiadespacho where IdEGuiaDespacho="$id"
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