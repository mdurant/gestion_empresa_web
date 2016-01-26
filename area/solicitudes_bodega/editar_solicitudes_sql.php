<?php
require_once("../../validatesession_json.php");
require_once("eplantillasolicitudes_sql.php");


        function value($field, $default_value = "") {
            if (isset($field) && !empty($field)) {
                $value = trim($field);
                return $value;
            }
            
            return $default_value;
        }

$tra=new cargar_solicitudes();


	//Capturo la fecha de inicio y termino de la cotizacion
	date_default_timezone_set("Chile/Continental");
	//$f1=date("Y-m-d");
	$f1=$_POST["fecha_sol"];//nuevo
	//$f2=date("Y-m-d", strtotime('+'.$_POST["tcotizacion"].' day'));
	$fecha_sol=date('Y-m-d', strtotime($f1));
	//************************************************************
	$id_esolicitud=$_POST["id_esolicitud"];
	$id_solicitante=$_POST["solicitante"];
	$jefe=$_POST["jefe"];
	$glosa=$_POST["glosa"];
	$proyecto=$_POST["proyecto"];
	$orden_trabajo=$_POST["orden_trabajo"];

	$tra->editar_esolicitud($id_esolicitud,$fecha_sol,$id_jefe,$id_operario,$id_proyecto,$orden_trabajo,$estado,$glosa);

    
	//$tra->editar_eorden($idcliente,$empresa,$ffinal,$id_eorden,$ffinal2,$jefe,$glosa,$patente,$vehiculo,$total);
	
	
	$salida="";

	for($i=0;$i<54;$i++)
	{
		
		$codigo=$_POST["codigo"][$i];
		$cantidad=$_POST["cantidad"][$i];
		$descripcion =$_POST["descripcion"][$i];
		$posicion=$_POST["posicion"][$i];
		
		//$ress=$tra->validar2($id_eorden,$posicion);

		if (value($codigo)=="" && value($id_detalles)!=="")
		{
			$salida=$salida.'[eliminar_dsolicitud;'.$posicion.';'.$codigo.';'.$cantidad.';'.$descripcion.']';
			$tra->eliminar_dorden($id_detalles);
			
			
		}
		
		if (value($codigo)!=="" && value($id_detalles)=="")
		{
			$salida=$salida.'[insertar_dorden;'.$posicion.';'.$codigo.';'.$id_detalles.']';			
			$tra->insertar_dorden($id_eorden,$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor);
			
			
		}
		
		if (value($codigo)!=="" && value($id_detalles)!=="")
		{
			$salida=$salida.'[editar_dorden;'.$posicion.';'.$codigo.';'.$id_detalles.']';			
			$tra->editar_dorden($posicion,$codigo,$descripcion,$cantidad,$bodega,$id_detalles,$valor);
		}

			
		
	}
	
	//$salida="todo";
	echo json_encode($salida);
	
?>