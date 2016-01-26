<?php
require_once("../../validatesession_json.php");
require_once("compra_sql.php");

$tra=new cargar_compra();

if($_POST["sproveedor"]=="")
{
	$salida="nada";
	echo json_encode($salida);
}
else
{
	//Capturo la fecha de inicio y termino de la compra
	date_default_timezone_set("Chile/Continental");
	//$f1=date("Y-m-d");
	$f1=$_POST["facturacion"];//nuevo
	//$f2=date("Y-m-d", strtotime('+'.$_POST["tcotizacion"].' day'));
	$ffinal=date('Y-m-d', strtotime(str_replace("/","-",$f1)));
	//************************************************************

	//Capturo los datos de los select y contador
	$proveedor =$_POST["sproveedor"];
	$_SESSION['SESS_PROVEEDOR']=$proveedor;
	$contador=$tra->ObtieneCompra();
	$empresa=$_POST["sempresa"];
	$fpago=$_POST["spago"];
	$neto=$_POST["neto"];
	$iva=$_POST["iva"];
	$total=$_POST["total"];
	$folio=$_POST["folio"];
	$glosa=$_POST["glosa"];
	$impuesto = "0";
	$guia_despacho =$_POST["guiadespacho"];
	$orden_compra =$_POST["ordencompra"];
	$fecha_sistema =date('Y-m-d H:i:s');
	$glosa=$_POST["glosa"];
	$idet=$tra->insertar_ecompra($contador,$empresa,$proveedor,$fpago,$guia_despacho,$orden_compra,$glosa,$ffinal,$fecha_sistema,$neto,$iva,$impuesto,$total,$folio,'Pendiente');


	//capturo datos del tbl-body

	//los recorro para hacer el insert

	for($i=0;$i<26;$i++)
	{
		if($_POST["codigo"][$i]=="")
		{
			//echo "No hay Datos ";
		}
		else
		{
		$iva2=$_POST["total_tbl"][$i]*0.19;
		$neto2=$_POST["total_tbl"][$i]-$iva2;
		$precio_venta = "0";
		$posicion=$_POST["posicion"][$i];
		$codigo =$_POST["codigo"][$i];
		$descripcion =$_POST["descripcion"][$i];
		$cantidad =$_POST["cantidad"][$i];
		$almacen =$_POST["bodega"][$i];
		$precio_compra =$_POST["precio_unitario"][$i];
		$descuento =$_POST["descuento"][$i];
		//$neto_detalle =$_POST["neto"][$i];
		//$iva_detalle =$_POST["iva"][$i];
		$impuesto_detalle ="0";
		$tipo_impuesto ="iva";
		$total_detalle=$_POST["total"][$i];

		// $tra->insertar_dcompra($idet[0],NULL,$posicion,$codigo,$descripcion,$cantidad,$almacen,$precio_compra,
		//$precio_venta,$descuento,$neto2,$iva2,$impuesto_detalle,$tipo_impuesto,$total_detalle);
		$tra->insertar_dcompra($idet[0],$posicion,$codigo,$descripcion,$cantidad,$almacen,$precio_compra,$precio_venta,$descuento,$neto2,$iva2,$impuesto_detalle,$tipo_impuesto,$total_detalle);

			$res=$tra->traer_datos($_POST["codigo"][$i]);
			$stocks=$res[0]["UnitsInStock"];
			$ide=$res[0]["IDProduct"];
			//$cant = $res[0]["cantidad"];
			$stockNew=$stocks + $cantidad;
			$valor_compra=$_POST["precio_unitario"][$i];
		$tra->Stock($ide,$stockNew,$precio_venta,$valor_compra);
	}
	
}
	//iniciando la forma de pago
//echo $_SESSION['SESS_PROVEEDOR'];

		if($fpago==13) // Documento

		{
			$valor=$_SESSION['SESS_PROVEEDOR'];
			$fecha=$ffinal;
			//$fecha_30=strtotime ('+1 month' , strtotime ($ffinal)) ;
			//$tra->insertar_pago($idet[0],"1",$total,$total,"Documento",$fecha,$fecha_30,$proveedor,$usuario);
			$id_pago=$tra->insertar_pago($idet[0],$total,$total,'Documento',$fecha,$fecha,$valor,$usuario);
			$tra->insetar_dpago($id_pago[0]);
		}
		else
		{
			
			$id_pago=$tra->insertar_pago($idet[0],$total,$total,'Transferencia/Efectivo',$fecha,$fecha,$valor,$usuario);
			$tra->insetar_dpago($id_pago[0]);
		}
	


	$salida="todo";
	echo json_encode($salida); // ahora le va a mostar la salida del $query, en html y despues en json, lo que tenga en $salida
}

?>