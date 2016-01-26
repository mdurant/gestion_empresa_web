<?php
require_once("../../conexion/conexion.php");
class funciones
{

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

public function proveedores()
{
	$salida=array();
	$query="SELECT suppliers.IDsuppliers, 
	suppliers.RUT, 
	suppliers.Suppliers, 
	suppliers.CompanyName, 
	suppliers.ContactName
	FROM suppliers";
	$res=mysql_query($query,Conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}

public function obtiene_servicio()
				{
				$guia="";
				$query= "select * from eservicios";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$guia=$row["numero"];
				}
				if(!$guia)
				{
					$guia="110000001";
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

	}
?>