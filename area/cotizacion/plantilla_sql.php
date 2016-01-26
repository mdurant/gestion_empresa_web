<?php
require_once("../../conexion/conexion.php");


class cargar_cotizacion
{
	public function traer_datos($id)
	{
		$salida=array();
		$query="SELECT
				product.ProductName,
				product.UnitPrice,
				product.UnitsInStock,
				almacen.Nombre
				FROM
				product
				INNER JOIN almacen ON product.IDCellar = almacen.IdAlmacen
				WHERE CodeBar= '$id'";
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
	public function insertar_eplantilla($nombre,$descripcion)
	{
		$query="INSERT INTO eplantillacot(
                eplantillacot.id_eplantilla_cot,
                eplantillacot.nombre,
                eplantillacot.descripcion,
                eplantillacot.estado)
                VALUES(NULL,'$nombre','$descripcion','activo')";
		$res=mysql_query($query,Conectar::con());
        $ID = mysql_query("SELECT id_eplantilla_cot FROM eplantillacot WHERE id_eplantilla_cot = LAST_INSERT_ID()",conectar::con());
        $row = mysql_fetch_array($ID);
        return $row;
		//Conectar::desconectar();
	}
	public function insertar_dplantilla($id_eplantilla_cot,$cantidad,$descuento,$descripcion,$codigo,$neto,$iva,$total,$posicion)
	{
		$query="INSERT INTO dplantillacot(
                dplantillacot.id_dplantilla_cot,
                dplantillacot.id_eplantilla_cot,
                dplantillacot.cantidad,
                dplantillacot.descuento,
                dplantillacot.descripcion,
                dplantillacot.codigo,
                dplantillacot.Neto,
                dplantillacot.Iva,
                dplantillacot.Total,
                dplantillacot.almacen,
				dplantillacot.posicion)
                VALUES(NULL,'$id_eplantilla_cot','$cantidad','$descuento','$descripcion','$codigo','$neto','$iva','$total','0100','$posicion')";
			$res=mysql_query($query,Conectar::con());
	}	
}

?>