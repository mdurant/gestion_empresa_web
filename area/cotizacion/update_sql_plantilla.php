<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");


class cargar_plantilla
{
    //insertar eplantilla
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
                VALUES(NULL,'$id_eplantilla_cot','$cantidad','$descuento','$descripcion','$codigo','$neto','$iva','$total','1','$posicion')";
			$res=mysql_query($query,Conectar::con());
	}	
	//insertar dplantilla
	
	//editar plantilla detalle
	
	public function editar_plantilla($posicion,$codigo,$descripcion,$cantidad,$descuento,$id_almacen,$neto,$iva,$total,$idedcotizacion)
	{                                
		$query=<<<QUERY
			UPDATE dcotizacion SET
                dplantillacot.posicion="$posicion",
                dplantillacot.Codigo="$codigo",
                dplantillacot.Descripcion="$descripcion",
                dplantillacot.Cantidad="$cantidad",
                dplantillacot.Descuento="$descuento",
                dplantillacot.Almacen="$id_almacen",
                dplantillacot.Neto="$neto",
                dplantillacot.Iva="$iva",
                dplantillacot.Total="$total"
                WHERE dplantillacot.id_dplantilla_cot="$idedcotizacion"
QUERY;
		$res=mysql_query($query,Conectar::con());
	}

	public function eliminar_dplantilla($id)
	{
		$query=<<<QUERY
			DELETE FROM dplantillacot
			WHERE id_dplantilla_cot = '$id';
QUERY;
		$res=mysql_query($query,Conectar::con());
	}

	
	//valido para hacer un insert
	public function validar($id_eplantilla,$posicion)
	{
		$salida=array();
		$query=<<<QUERY
			SELECT * FROM dplantillaot WHERE id_plantillaot = '$id_eplantilla' AND posicion = '$posicion'
QUERY;
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$res;
		}
		return $salida;
	}
	
	//editar eorden de trabajo
	public function editar_eplantilla($id,$nombre,$descripcion)
	{
		$query=<<<QUERY
		
			UPDATE eplantillacot SET
            eplantillacot.nombre="$nombre",
            eplantillacot.descripcion="$descripcion"
            WHERE eplantillacot.id_eplantilla_cot="$id"
QUERY;
		$res=mysql_query($query,Conectar::con());
		
		
	}
	
	//editar dorden
	public function editar_dplantilla($id_eplantilla_cot,$cantidad,$descuento,$descripcion,$codigo,$neto,$iva,$total,$almacen,$posicion,$id_dplantilla_cot)
	{
		$query=<<<QUERY
			UPDATE eplantillacot SET
					dplantillacot.id_eplantilla_cot="$id_eplantilla_cot",
					dplantillacot.cantidad="$cantidad",
					dplantillacot.descuento="$descuento",
					dplantillacot.descripcion="$descripcion",
					dplantillacot.codigo="$codigo",
					dplantillacot.Neto="$neto",
					dplantillacot.Iva="$iva",
					dplantillacot.Total="$total",
					dplantillacot.almacen="$almacen",
					dplantillacot.posicion="$posicion"
					WHERE dplantillacot.id_dplantilla_cot="$id_dplantilla_cot"
QUERY;


		$res=mysql_query($query,Conectar::con());
	}
	//valido para hacer un insert
	public function validar2($id_eorden,$posicion)
	{
		$salida=array();
		$query=<<<QUERY
			SELECT
			dorden.id_dorden,
			dorden.id_orden,
			dorden.posicion,
			dorden.Codigo,
			dorden.descripcion,
			dorden.cantidad,
			dorden.id_almacen,
			dorden.valor
			FROM
			dorden
			WHERE id_orden='$id_eorden' AND posicion='$posicion'
QUERY;
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$res;
		}
		return $salida;
	}

	public function eliminar_dorden($id_cot)
	{
		$query2=<<<QUERY
			DELETE FROM dcotizacion WHERE IdECotizacion = '$id_cot';
QUERY;
			$res=mysql_query($query2,Conectar::con());
	}
	
	
}

?>