<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");


class cargar_solicitudes
{
	//editar esolicitudes internas
	public function editar_esolicitud($id_esolicitud,$fecha_sol,$id_jefe,$id_operario,$id_proyecto,$orden_trabajo,$estado,$glosa)
	{
		$query=<<<QUERY
		
			UPDATE esolicitud SET
			esolicitud.fecha_sol='$fecha_sol',
			esolicitud.id_jefe='$id_jefe',
			esolicitud.id_operario='$id_operario',
			esolicitud.id_proyecto='$id_proyecto',
			esolicitud.orden_trabajo='$orden_trabajo',
			esolicitud.glosa='$glosa'
			WHERE id_esolicitud='$id_esolicitud'
QUERY;
		$res=mysql_query($query,Conectar::con());
		
		
	}
	
	//editar dsolicitud
	public function editar_dsolicitud($id_esolicitud,$posicion,$codigo_producto,$producto,$cantidad)
	{
		$query=<<<QUERY
			UPDATE dsolicitud SET
			dsolicitud.esolicitud='$id_esolicitud',
			dsolicitud.posicion='$posicion',
			dsolicitud.codigo_producto='$codigo_producto',
			dsolicitud.producto='$producto',
			dsolicitud.cantidad='$cantidad'
	    	WHERE id_esolicitud = '$id_esolicitud';
QUERY;


		$res=mysql_query($query,Conectar::con());
	}
	//valido para hacer un insert
	public function validar2($id_esolicitud,$posicion)
	{
		$salida=array();
		$query=<<<QUERY
			SELECT
			dsolicitud.id_dsolicitud,
			dsolicitud.id_esolicitud,
			dsolicitud.posicion,
			dsolicitud.codigo_producto,
			dsolicitud.producto,
			dsolicitud.cantidad
			dsolicitud.valor
			FROM
			dsolicitud
			WHERE id_esolicitud='$id_esolicitud' AND posicion='$posicion'
QUERY;
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$res;
		}
		return $salida;
	}
	//insertar dsolicitud
	public function insertar_dsolicitud($id_esolicitud,$posicion,$codigo_producto,$producto,$cantidad)
	{
		$query2=<<<QUERY
	INSERT INTO dsolicitud (
	id_dsolicitud,
	id_esolicitud,
	posicion,
	codigo_producto,
	producto,
	cantidad
)
VALUES
	(
		NULL,
		'$id_esolicitud',
		'$posicion',
		'$codigo_producto',
		'$producto',
		'$cantidad'
	)
QUERY;
			$res=mysql_query($query2,Conectar::con());
            
            // mostrar registro para ver en browser
          //  echo $query2;
	}

	public function eliminar_dsolicitud($id_dsolicitud)
	{
		$query2=<<<QUERY
			UPDATE dsolicitud SET
			dsolicitud.estado='inactivo'
			WHERE id_dsolicitud = '$id_dsolicitud';
QUERY;
			$res=mysql_query($query2,Conectar::con());
	}
	
	
}

?>