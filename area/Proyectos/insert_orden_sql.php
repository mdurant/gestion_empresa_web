<?php
require_once("../../validatesession_json.php");
require_once("orden_sql.php");

$tra=new cargar_orden();

$Empresa = $_SESSION['SESS_EMPRESA_ID'];


	//Capturo la fecha de inicio y termino de la cotizacion
	date_default_timezone_set("Chile/Continental");
	//$f1=date("Y-m-d");
	$f1=$_POST["facturacion"];//nuevo
	$f3=$_POST["facturacion2"];//nuevo
	//$f2=date("Y-m-d", strtotime('+'.$_POST["tcotizacion"].' day'));
	$ffinal=date('Y-m-d', strtotime($f1));
	$ffinal2=date("Y-m-d", strtotime($f3));
	$jefe=$_POST["jefe"];
	$glosa=$_POST["glosa"];
	// nuevos campos
	$patente=$_POST["patente"];
	$vehiculo=$_POST["vehiculo"];
	
	$total=$_POST["total"];
	$iva =($total*19)/100;
	$total_gral = $total+$iva;

	//************************************************************
	
	//Capturo los datos de los select y contador
	// $cliente=$_POST["scliente"];
	$contador=$tra->ObtieneOrden();
	$empresa = $Empresa;
	// $fpago=$_POST["fpago"];
	$clientes=$_POST["clientes"];
	// Este campo me sirve para actualizar en caso de ser asignado en Factura
	$folio=0;
	$id_ultimo=$tra->insertar_eorden($contador,$folio,$clientes,$empresa,$ffinal,$ffinal2,$jefe,$glosa,$patente,$vehiculo,$total,$iva,$total_gral);
   
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
		$descripcion=$_POST["descripcion"][$i];
		$posicion=$_POST["posicion"][$i];
		$codigo=$_POST["codigo"][$i];
		$cantidad=$_POST["cantidad"][$i];
		$bodega=$_POST["bodega"][$i];
		$valor=$_POST["valor"][$i];
		$sub_total=$_POST["total_tbl"][$i];

		$tra->insertar_dorden($id_ultimo[0],$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor,$sub_total);

			
/*	
	
			$res=$tra->traer_datos($_POST["codigo"][$i]);
			$stocks=$res[0]["UnitsInStock"];
			$ide=$res[0]["IDProduct"];
			$stockNew=$stocks + $_POST["cantidad"][$i];
			$tra->Stock($ide,$stockNew,$precio_venta,$precio_compra);*/
		}
		
	}
	$vare="Se Inserto Correctamente";
	$salida="todo";
	echo json_encode($vare);

	
?>