<?php
require_once("../../conexion/conexion.php");
class select_solicitudes
{

public function jefes(){

	$salida=array();
	$query="SELECT
UPPER(jefaturas.id_jefatura) ,
UPPER(concat(jefaturas.nombres, ' ',jefaturas.paterno))as jefe,
	jefaturas.email, 
	jefaturas.estado
FROM jefaturas
WHERE
estado = 'activo'
";
	$res=mysql_query($query,Conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}

public function trabajadores(){

	$salida=array();
	$query="select 
	trabajador.id_trabajador,
	UPPER(CONCAT(trabajador.nombres, ' ', trabajador.apellidop)) as operario,
	trabajador.email
	from trabajador
	where
trabajador.estado = 'activo' and trabajador.id_trabajador > '1'";
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
public function obtiene_solicitud()
				{
				$solicitud="";
				$query= "select * from esolicitud";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$solicitud=$row["contador"];
				}
				if(!$solicitud)
				{
					$solicitud="40000001";
				}
				else
				{
					$solicitud= $solicitud + 1;
				}
				return $solicitud;
				
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
public function esolicitudd($id)
	{
			$salida=array();
			$query=<<<QUERY
			select * from esolicitud where id_esolicitud="$id"
QUERY;
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row;
			}
			return $salida;
			
		}
public function dsolicitud($id)
		{
			$salida=array();
			$query=<<<QUERY
			select * from dsolicitud where id_dsolicitud="$id"
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
		{ 	$vRESP="OK"; $vMENSAJE = "Cargar Clientes :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Cargar Clientes :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
?>