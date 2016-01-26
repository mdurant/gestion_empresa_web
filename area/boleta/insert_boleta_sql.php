<?php
require_once("../../validatesession_json.php");
require_once("boleta_sql.php");

$tra=new cargar_cotizacion();

$Empresa = $_SESSION['SESS_EMPRESA_ID'];

if($_POST["contador"]=="")

{	$salida="nada";
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
	$contador=$tra->ObtieneBoleta();
	$empresa=$_SESSION['SESS_EMPRESA_ID'];
	// $fpago=$_POST["fpago"];
	$neto=$_POST["neto"];
	$iva=$_POST["iva"];
	$total=$_POST["total"];
	$folio=$_POST["folio"];//nuevo
    $result1=$tra->insertar_eboleta($contador,$ffinal,$empresa,"activo",$total,$iva,$neto);


	//los recorro para hacer el insert
	for($i=0;$i<26;$i++)
	{
		if($_POST["codigo"][$i]=="")
		{
			
		}
		else
		{
		$iva2=$_POST["total_tbl"][$i]*0.19;
		$neto2=$_POST["total_tbl"][$i]-$iva2;
		$proba=$_POST["descripcion"][$i];
		
		$tra->insertar_dboleta($contador,$ffinal,$_POST["posicion"][$i],$_POST["codigo"][$i],$proba,$_POST["cantidad"][$i],$_POST["descuento"][$i],$_POST["bodega"][$i],$neto2,$iva2,$_POST["total_tbl"][$i],$empresa,"activo",$neto,$iva,$total);
			
	//trabajar con el stock del producto
	
			$res=$tra->traer_datos($_POST["codigo"][$i]);
			$stocks=$res[0]["UnitsInStock"];
			$ide=$res[0]["IDProduct"];
			$stockNew=$stocks - $_POST["cantidad"][$i];
			$tra->Stock($ide,$stockNew);
		}
		
	}
	
	$salida="todo";
	echo json_encode($salida);
}
	
?>