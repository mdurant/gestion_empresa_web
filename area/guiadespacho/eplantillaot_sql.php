<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");


class editar_guia
{
	//editar guia de despacho
	public function editar_eorden($numero, $folio, $proyecto, $neto, $iva, $impuesto, $total, $fecha_guia, $user, $estado, $empresa, $motivo, $glosa, $estado_contable, $rut_chofer, $nombre_chofer, $patente, $autoriza,$id)
	{
		$query=<<<QUERY
		
			update eguiadespacho
eguiadespacho.Numero = '$numero',
eguiadespacho.Folio = '$folio',
eguiadespacho.Referencia = '$proyecto',
eguiadespacho.Neto = '$neto',
eguiadespacho.Iva = '$iva',
eguiadespacho.Impuesto = '$impuesto',
eguiadespacho.Total = '$total',
eguiadespacho.FechaFacturacion = '$fecha_guia',
eguiadespacho.User='$user',
eguiadespacho.Estado = '$estado',
eguiadespacho.IDEmpresa = '$empresa',
eguiadespacho.IDMotivo = '$motivo',
eguiadespacho.glosa = '$glosa',
eguiadespacho.estadocontable = '$estado_contable',
eguiadespacho.rut_chofer = '$rut_chofer',
eguiadespacho.nom_chofer = '$nombre_chofer',
eguiadespacho.patente = '$patente',
eguiadespacho.autoriza = '$autoriza'

WHERE
eguiadespacho.IdEGuiaDespacho = '$id'
QUERY;
		$res=mysql_query($query,Conectar::con());
		
		
	}
	
	//editar dorden
	public function editar_dorden($posicion,$codigo,$descripcion,$cantidad,$id_guia,$valor)
	{
		$query=<<<QUERY
			UPDATE dguiadespacho SET
			dguiadespacho.Posicion='$posicion',
			dguiadespacho.Codigo='$codigo',
			dguiadespacho.Descripcion='$descripcion',
			dguiadespacho.Cantidad='$cantidad',
			dguiadespacho.Neto='$valor'
	    		WHERE dguiadespacho.IdDGuia = '$id_guia'
QUERY;


		$res=mysql_query($query,Conectar::con());
	}
	//valido para hacer un insert
	public function validar2($id_eguia,$posicion)
	{
		$salida=array();
		$query=<<<QUERY
			SELECT
			dguiadespacho.idDGuia,
			dguiadespacho.idEGuiaDespacho,
			dguiadespacho.Posicion,
			dguiadespacho.Codigo,
			dguiadespacho.Descripcion,
			dguiadespacho.Cantidad,
			dguiadespacho.Neto
			FROM
			dguiadespacho
			WHERE dguiadespacho.idEGuiaDespacho='$id_eorden' AND dguiadespacho.Posicion='$posicion'
QUERY;
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$res;
		}
		return $salida;
	}
	

	public function eliminar_dorden($id_dguia)
	{
		$query2=<<<QUERY
			DELETE FROM dguiadespacho WHERE idDGuia = '$id_dguia';
QUERY;
			$res=mysql_query($query2,Conectar::con());
	}
	
	
}

?>