<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");


class cargar_plantilla
{
    //insertar eplantilla
    public function insertar_eplantillaot($nombre,$descripcion)
    {
        $query=<<<QUERY
			INSERT INTO eplantillaot(
			eplantillaot.id_plantillaot,
			eplantillaot.nombre,
			eplantillaot.descripcion,
			eplantillaot.estado)
			VALUES(NULL,"$nombre",'$descripcion',"activo")
QUERY;
        $res=mysql_query($query,Conectar::con());
	$ID = mysql_query("SELECT id_plantillaot FROM eplantillaot WHERE id_plantillaot = LAST_INSERT_ID()",conectar::con());
        $row = mysql_fetch_array($ID);
        return $row;
    }
	//insertar dplantilla
	public function insertar_dplantillaot($id_plantillaot,$posicion,$codigo,$descripcion,$cantidad,$id_almacen,$valor)
	{
		$query2=<<<QUERY
			INSERT INTO dplantillaot(
			dplantillaot.id_dplantillaot,
			dplantillaot.id_plantillaot,
			dplantillaot.posicion,
			dplantillaot.Codigo,
			dplantillaot.descripcion,
			dplantillaot.cantidad,
			dplantillaot.id_almacen,
			dplantillaot.valor)
			VALUES(NULL,"$id_plantillaot","$posicion","$codigo",'$descripcion',"$cantidad","$id_almacen","$valor")
QUERY;
			$res=mysql_query($query2,Conectar::con());
	}
	
	//editar plantilla
	public function editar_eplantillaot($id_plantillaot,$nombre,$descripcion)
	{
		$query=<<<QUERY
		
		UPDATE eplantillaot SET
		eplantillaot.nombre = '$nombre',
		eplantillaot.descripcion ='$descripcion'
		WHERE id_plantillaot = '$id_plantillaot';
		
QUERY;
 		$res=mysql_query($query,Conectar::con());
	}
	
	//editar plantilla detalle
	
	public function editar_dplantillaot($id,$posicion,$codigo,$descripcion,$cantidad,$id_almacen,$valor)
	{
		$query=<<<QUERY
			UPDATE dplantillaot SET
			dplantillaot.posicion= '$posicion',
			dplantillaot.Codigo= '$codigo',
			dplantillaot.descripcion= '$descripcion',
			dplantillaot.cantidad ='$cantidad',
			dplantillaot.id_almacen ='$id_almacen',
            dplantillaot.valor = '$valor'
			WHERE id_dplantillaot = '$id';
QUERY;
		$res=mysql_query($query,Conectar::con());
	}

	public function eliminar_dplantillaot($id)
	{
		$query=<<<QUERY
			DELETE FROM dplantillaot 
			WHERE id_dplantillaot = '$id';
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
	public function editar_eorden($id_cliente,$id_empresa,$fecha_ingreso,$id_orden,$f2,$jefe,$glosa,$patente,$vehiculo,$total)
	{
		$query=<<<QUERY
		
			UPDATE eorden SET
			eorden.id_cliente='$id_cliente',
			eorden.id_empresa='$id_empresa',
			eorden.fecha_ingreso='$fecha_ingreso',
			eorden.fecha_entrega='$f2',
			eorden.jefe_responsable='$jefe',
			eorden.glosa='$glosa',
			eorden.patente='$patente',
			eorden.vehiculo_pieza='$vehiculo',
			eorden.total='$total'
			WHERE id_orden='$id_orden'
QUERY;
		$res=mysql_query($query,Conectar::con());
		
		
	}
	
	//editar dorden
	public function editar_dorden($posicion,$codigo,$descripcion,$cantidad,$id_almacen,$id_orden,$valor)
	{
		$query=<<<QUERY
			UPDATE dorden SET
			dorden.posicion='$posicion',
			dorden.Codigo='$codigo',
			dorden.descripcion='$descripcion',
			dorden.cantidad='$cantidad',
			dorden.id_almacen='$id_almacen',
			dorden.valor='$valor'
	    		WHERE id_dorden = '$id_orden';
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
	//insertar ecompra
	public function insertar_dorden($id_orden,$posicion,$codigo,$descripcion,$cantidad,$id_almacen,$valor)
	{
		$query2=<<<QUERY
			INSERT INTO dorden(
			dorden.id_dorden,
			dorden.id_orden,
			dorden.posicion,
			dorden.Codigo,
			dorden.descripcion,
			dorden.cantidad,
			dorden.id_almacen,
			dorden.valor)
			VALUES(NULL,'$id_orden','$posicion','$codigo','$descripcion','$cantidad','$id_almacen','$valor')
QUERY;
			$res=mysql_query($query2,Conectar::con());
	}

	public function eliminar_dorden($id_dorden)
	{
		$query2=<<<QUERY
			DELETE FROM dorden WHERE id_dorden = '$id_dorden';
QUERY;
			$res=mysql_query($query2,Conectar::con());
	}
	
	
}

?>