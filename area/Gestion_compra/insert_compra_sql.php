<?php

require_once("../../validatesession_json.php");
require_once("compra_sql.php");



$tra=new cargar_compra();

if($_POST["proveedores"]=="" || $_POST["folf"]=="")
{
	$salida="nada";
	echo json_encode($salida);
}
else
{
	//Capturo la fecha de inicio y termino de la cotizacion
	date_default_timezone_set("Chile/Continental");
	//$f1=date("Y-m-d");
	$f1=$_POST["facturacion"];//nuevo
	//$f2=date("Y-m-d", strtotime('+'.$_POST["tcotizacion"].' day'));
	$ffinal=date('Y-m-d', strtotime($f1));
	//************************************************************
	
	//Capturo los datos de los select y contador
	// $cliente=$_POST["scliente"];
	$contador=$tra->ObtieneCompras();
	$empresa=$_SESSION['SESS_EMPRESA_ID'];
	$folf=$_POST["folf"];
	$neto=$_POST["neto"];
	$iva=$_POST["iva"];
	$total=$_POST["tot_2"];
	$proveedores=$_POST["proveedores"];
    
	$id_ultimo=$tra->insertar_ecompra($contador,$ffinal,$empresa,$proveedores,$total,"0","0",$folf);
	
	//echo json_encode($id_ultimo);
	//die();
	
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
			$precio_compra=$_POST["precio_compra"][$i];
			$precio_venta=$_POST["precio_venta"][$i];
	
			$resulta1=$tra->insertar_dcompra($id_ultimo[0],$posicion,$codigo,$descripcion,$cantidad,$bodega,$precio_compra,$precio_venta);
	
			//echo json_encode($resulta1);
			//die();
	
	
			$res=$tra->traer_datos($_POST["codigo"][$i]);
			$stocks=$res[0]["UnitsInStock"];
			$ide=$res[0]["IDProduct"];
			$stockNew=$stocks + $_POST["cantidad"][$i];

			$tra->Stock($ide,$stockNew,$precio_venta,$precio_compra,$bodega);
		}
		
	}
	
	$salida="todo";
	echo json_encode($salida);
}
	
?>