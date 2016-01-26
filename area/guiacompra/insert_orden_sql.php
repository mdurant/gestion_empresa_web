<?php
require_once("../../validatesession_json.php");
require_once("orden_sql.php");

$tra=new cargar_orden();

//$Empresa = $_SESSION['SESS_EMPRESA_ID'];

	//Capturo la fecha de inicio y termino de la Guia
	date_default_timezone_set("Chile/Continental");
	$f1=$_POST["fecha_guia"];//nuevo
	// Orden de los campos al insertar
	$contador=$tra->ObtieneGuiaCompra();
	$proveedor=$_POST["proveedor"];
	$orden_compra=$_POST["orden_compra"];
	$numero_factura=$_POST["numero_factura"];
	 $neto=$_POST["total"];
	 $iva =($neto*19)/100;
	 $impuesto="19";
	 $total =$neto+$iva;
	 $fecha_emision=date('Y-m-d', strtotime($f1));
	// $fecha_ingreso=date('Y-m-d H:i:s');
	 $fecha_ingreso=getdate();
	 $usuario=$_SESSION['SESS_USERNAME'];
	 $empresa =$_SESSION['SESS_EMPRESA_ID'];
	 $glosa=$_POST["glosa"];
	 $estado_contable="Pendiente";
	 $estado ="activo";
	 $id_motivo =$_POST["motivo"];
	 $folio= $_POST["folio"];
	 
	$id_ultimo=$tra->insertar_eguia_compra($contador,$proveedor,$orden_compra,$numero_factura,$neto,$iva,$impuesto,$total,$fecha_emision,$fecha_ingreso,$usuario,$empresa,$glosa,$estado_contable,$estado,$id_motivo,$folio);
	
	
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
		$descuento="0"; // No aplica Descuento, default "Cero"
		$almacen="1";  // Bodega Central
		$valor=$_POST["valor"][$i];
		$neto_detalle=$_POST["total_tbl"][$i];
		$iva_detalle=($sub_total*19)/100;
		$tipo_impuesto="IVA 19%";
		$total_detalle =$sub_total+$iva_sub_total;
		$empresa =$_SESSION["SESS_EMPRESA_ID"];
		
		

	//	$tra->insertar_dorden($id_ultimo[0],$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor,$sub_total);
$tra->insertar_dguia_compra($id_ultimo[0],$posicion,$codigo,$descripcion,$cantidad,$valor,$descuento,$almacen,$neto_detalle,$iva_detalle,$tipo_impuesto,$total_detalle,$empresa);
			

	
			$res=$tra->traer_datos($_POST["codigo"][$i]);
			$stocks=$res[0]["UnitsInStock"];
			$ide=$res[0]["IDProduct"];
			$stockNew=$stocks + $_POST["cantidad"][$i];
			$precio_compra=$_POST["valor"][$i];
			$tra->Stock($ide,$stockNew,$precio_venta,$precio_compra);
		}
		
	}
	$vare="Se Inserto Correctamente";
	$salida="todo";
	echo json_encode($vare);

	
?>