<?php
require_once("../../validatesession_json.php");
require_once("orden_sql.php");

$tra=new cargar_orden();

//$Empresa = $_SESSION['SESS_EMPRESA_ID'];

	//Capturo la fecha de inicio y termino de la Guia
	date_default_timezone_set("Chile/Continental");
	$f1=$_POST["fecha_guia"];//nuevo
	// Orden de los campos al insertar
	$contador=$tra->ObtieneOrden();
	$folio=$_POST["folio"];
	$proyecto = $_POST["proyecto"];
  	$cliente=$_POST["clientes"];
	$forma_pago ="1" ; // 30 dias
	 $neto=$_POST["total"];
	 $iva =($neto*19)/100;
	 $impuesto="19";
	 $total =$neto+$iva;
	 $fecha_creacion=date('Y-m-d H:i:s');
	 $fecha_guia=date('Y-m-d', strtotime($f1));
	 $user=$_SESSION['SESS_USERNAME'];
	 $estado ="activo";
	 $empresa =$_SESSION['SESS_EMPRESA_ID'];
	 $motivo =$_POST["motivo"];
	 $glosa=$_POST["glosa"];
	 $estado_contable="Pendiente";
	 $rut_chofer=$_POST["rut_chofer"];
	 $nombre_chofer=$_POST["nombre_chofer"];
	 $patente =$_POST["placa_patente"];
	 $autoriza =$_POST["autoriza"];
	 $factura=$_POST["factura"];
	 
	 
	 
	// Este campo me sirve para actualizar en caso de ser asignado en Factura
	//$folio=0;
	//$id_ultimo=$tra->insertar_eorden($contador,$folio,$clientes,$empresa,$proyecto,$ffinal,$ffinal2,$jefe,$glosa,$total,$iva,$total_gral);
   $id_ultimo=$tra->insertar_eguia($contador,$folio,$factura,$proyecto,$cliente,$forma_pago,$neto,$iva,$impuesto,$total,$fecha_creacion,$fecha_guia,$user,$estado,$empresa,$motivo,$glosa,$estado_contable,$rut_chofer,$nombre_chofer,$patente,$autoriza);
	
	
	//los recorro para hacer el insert
	for($i=0;$i<54;$i++)
	{
		if($_POST["codigo"][$i]=="")
		{
			
		}
		else
		{
		$descripcion=$_POST["descripcion"][$i];
		$posicion=$_POST["posicion"][$i];
		$codigo=$_POST["codigo"][$i];
		$cantidad=$_POST["cantidad"][$i];
		$almacen=$_POST["bodega"][$i];
		$valor=$_POST["valor"][$i];
		$sub_total=$_POST["total_tbl"][$i];
		$iva_sub_total=($sub_total*19)/100;
		$monto_impuesto="19";
		$tipo_impuesto="IVA 19%";
		$total_gral =$sub_total+$iva_sub_total;
		$empresa =$_SESSION["SESS_EMPRESA_ID"];
		
		

	//	$tra->insertar_dorden($id_ultimo[0],$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor,$sub_total);
$tra->insertar_dguia($id_ultimo[0],$posicion,$codigo,$descripcion,$cantidad,$decuento,$almacen,$sub_total,$iva_sub_total,$monto_impuesto,$tipo_impuesto,$total_gral,$empresa);
			
	
	
			$res=$tra->traer_datos($_POST["codigo"][$i]);
			$stocks=$res[0]["UnitsInStock"];
			$ide=$res[0]["IDProduct"];
			$stockNew=$stocks - $_POST["cantidad"][$i];
			$tra->Stock($ide,$stockNew,$precio_venta,$precio_compra);
		}
		
	}

	$vare="Se Inserto Correctamente la Guia de Despacho";
	$salida="Todo";
	echo json_encode($vare);

	
?>