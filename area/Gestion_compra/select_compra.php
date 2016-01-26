<?php
require_once("../../conexion/conexion.php");
class select
{
// public function clientes()
// 	{
// 		$salida=array();
// 		$query="SELECT
// 				customers.IDCliente,
// 				customers.Cliente
// 				FROM
// 				customers
// 				";
// 		$res=mysql_query($query,Conectar::con());
// 		while($row=mysql_fetch_assoc($res))
// 		{
// 			$salida[]=$row;
// 		}
// 		return $salida;
// 	}
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
// public function forma_pago()
// {
// 	$salida=array();
// 	$query="SELECT
// 			formapago.IdFormaPago,
// 			formapago.Nombre
// 			FROM
// 			formapago";
// 	$res=mysql_query($query,Conectar::con());
// 	while($row=mysql_fetch_assoc($res))
// 	{
// 		$salida[]=$row;
// 	}
// 	return $salida;
// }
		public function ObtieneBoleta()
				{
				$Factura="";
				$query= "select * from dboleta";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$Factura=$row["IdEboleta"];
				}
				if(!$Factura)
				{
					$Factura="50000001";
				}
				else
				{
					$Factura= $Factura + 1;
				}
				return $Factura;
				
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
	public function proveedores()
	{
		$salida=array();
		$query="Select * from suppliers";
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
	
	
	public function almacen()
	{
		$salida=array();
		$query="Select * from almacen WHERE Estado='activo'";
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
    public function ObtieneCompras()
				{
				$Factura="";
				$query= "select * from ecompra";
				$resul=mysql_query($query,conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$Factura=$row["folio_compra"];
				}
				if(!$Factura)
				{
					$Factura="10000001";
				}
				else
				{
					$Factura= $Factura + 1;
				}
				return $Factura;
				
				}
	
}
?>