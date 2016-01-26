<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");
class select
{
public function clientes()
	{
		$salida=array();
		$query="SELECT
				customers.IDCliente,
				customers.Cliente
				FROM
				customers
				";
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
public function forma_pago()
{
	$salida=array();
	$query="SELECT
			formapago.IdFormaPago,
			formapago.Nombre
			FROM
			formapago";
	$res=mysql_query($query,Conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}
	public function ObtieneCotizacion(){
		$Factura="";
		$query= "select * from ecotizacion";
		$resul=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($resul))
		{
			$Factura=$row["Contador"];
		}
		if(!$Factura)
		{
			$Factura="80000001";
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
  public function datos_plantilla($id)
  {
    $salida=array();
    $query="Select * from eplantillacot where id_eplantilla_cot='$id'";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
  }
  public function datos_dplantilla($id)
  {
    $salida=array();
    $query="SELECT
            dplantillacot.id_dplantilla_cot,
            dplantillacot.id_eplantilla_cot,
            dplantillacot.cantidad,
            dplantillacot.descuento,
            dplantillacot.descripcion,
            dplantillacot.codigo,
            dplantillacot.Neto,
            dplantillacot.Iva,
            dplantillacot.Total,
            dplantillacot.posicion,
            dplantillacot.almacen
            FROM
            dplantillacot
            where id_eplantilla_cot='$id'
            ";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
  }
}
?>