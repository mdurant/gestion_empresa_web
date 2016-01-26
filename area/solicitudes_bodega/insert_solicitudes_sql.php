<?php
require_once("../../validatesession_json.php");
require_once("solicitudes_sql.php");

$tra=new cargar_solicitud();

	//Capturo la fecha de inicio y termino de la cotizacion
	date_default_timezone_set("Chile/Continental");
	//$f1=date("Y-m-d");
	$f1=$_POST["fecha_solicitud"];//nuevo
	$fecha_sol=date('Y-m-d', strtotime($f1));
	$jefes=$_POST["solicitante"];
	$glosa=$_POST["glosa"];
	$proyecto = $_POST["proyecto"];
    $orden_trabajo =$_POST["orden_trabajo"];
	$contador=$_POST["contador"];
	$solicitante = $_POST["solicitante"];
	// Este campo me sirve para actualizar en caso de ser asignado en Factura
	$folio=0;
	$esolicitud=$tra->insertar_esolicitud($fecha_sol,$jefes,$solicitante,$proyecto,$orden_trabajo,$contador,'activo',$glosa); 
	//echo json_encode($vare);
	//die($id_ultimo);
	
	//los recorro para hacer el insert
	for($i=0;$i<54;$i++)
	{
		if($_POST["codigo"][$i]=="")
		{
			
		}
		else
		{
	    $codigo=$_POST["codigo"][$i];
		$cantidad=$_POST["cantidad"][$i];
		$descripcion =$_POST["descripcion"][$i];
		$posicion=$_POST["posicion"][$i];
		
     $tra->insertar_dsolicitud($esolicitud[0],$posicion,$codigo,$descripcion,$cantidad);
		//$tra->insertar_dorden($id_ultimo[0],$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor,$sub_total);

			

	
			$res=$tra->traer_datos($_POST["codigo"][$i]);
			$stocks=$res[0]["UnitsInStock"];
			$ide=$res[0]["IDProduct"];
			$stockNew=$stocks - $_POST["cantidad"][$i];
			$tra->Stock($ide,$stockNew,$precio_venta,$precio_compra);
		}
		
	}
	$vare="Se Inserto Correctamente";
	$salida="todo";
	echo json_encode($vare);

	
?>