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
	$cliente=$_POST["sproveedor"];
	$contador=$tra->ObtieneCompraBoleta();
	$empresa=$_POST["sempresa"];
	$fpago=$_POST["fpago"];
	$neto=$_POST["neto"];
	$iva=$_POST["iva"];
	$total=$_POST["total"];
	$folio=$_POST["folio"];
	$glosa=$_POST["glosa"];
	$impuesto = "0";
	$guia_despacho =$_POST["guiadespacho"];
	$orden_compra =$_POST["ordencompra"];
	$fecha_sistema =date('Y-m-d H:i:s');
	//$idet=$tra->insertar_ecompra($contador,$empresa,$proveedor,$guia_despacho,$orden_compra,$ffinal,$fecha_sistema,$neto,$iva,$impuesto,$total,$folio,'Pendiente');
	$idet=$tra->insertar_eboleta($contador,$folio,$ffinal,$fecha_sistema,$empresa,$proveedor,'activo',$total,$iva,$neto,'Pendiente');
	
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
		$impuesto_detalle ="0";
		$tipo_impuesto ="iva";
		$total_detalle=$_POST["total"][$i];
	
		// $tra->insertar_dcompra($idet[0],NULL,$posicion,$codigo,$descripcion,$cantidad,$almacen,$precio_compra,
		//$precio_venta,$descuento,$neto2,$iva2,$impuesto_detalle,$tipo_impuesto,$total_detalle);
		/*
		$tra->insertar_dcompra($idet[0],$posicion,$codigo,$descripcion,$cantidad,
						 $almacen,$precio_compra,$precio_venta,
		$descuento,$neto2,$iva2,$impuesto_detalle,$tipo_impuesto,$total_detalle);
		$id_boleta, $id_eboleta, $posicion,$codigo, $descripcion, $cantidad, $descuento, $almacen,
									 $neto_detalle, $iva_detalle, $total_detalle, $estado
		
		*/
		//$tra->insertar_dboleta($idet[0],$posicion,$codigo,$descripcion,$cantidad,$descuento,$almacen,$neto2,$iva2,$total_detalle);		
		//$tra->insertar_dboleta($idet[0],$posicion,$codigo,$descripcion,$cantidad,$descuento,$almacen,$neto2,$iva2,$total_detalle);
		$tra->insertar_dboleta($idet[0],$posicion,$codigo,$descripcion,$cantidad,$descuento,$almacen,
		$neto2,$iva2,$total_detalle,$estado);
		}
		

		$res=$tra->traer_datos($_POST["codigo"][$i]);
			$stocks=$res[0]["UnitsInStock"];
			$ide=$res[0]["IDProduct"];
			$stockNew=$stocks + $_POST["cantidad"][$i];

		$tra->Stock($ide,$stockNew,$precio_venta,$precio_compra,$bodega);
		
	}
	//iniciando la forma de pago
//	$total1=($total/$fpago);
$total1=($total/1);


	$u=1;
	$fpago2=$fpago+1;
	for($e=1;$e<$fpago2;$e++)
	{
		if($e==1)
		{
			$fecha=$ffinal;
			$ffinal2=strtotime ( '+1 month' , strtotime ( $ffinal ) ) ;
			$ffinal2= date ( 'Y-m-d' , $ffinal2 );
			$tra->insertar_pago($idet[0],$e,$total1,$total1,"0",$fecha,$ffinal2,$cliente);
		}
		else
		{
			$fecha=strtotime ( '+'.$u.' month' , strtotime ( $fecha ) ) ;
			$fecha= date ( 'Y-m-d' , $fecha );
			$ffinal2=strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
			$ffinal2= date ( 'Y-m-d' , $ffinal2 );
			$tra->insertar_pago($idet[0],$e,$total1,$total1,"0",$fecha,$ffinal2,$cliente);
		}
	}
	
	
	$salida="todo";
	echo json_encode($salida); // ahora le va a mostar la salida del $query, en html y despues en json, lo que tenga en $salida
}
	
?>