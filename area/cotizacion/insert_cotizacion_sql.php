<?php
require_once("../../validatesession_json.php");
require_once("cotizacion_sql.php");

$tra=new cargar_cotizacion();

if($_POST["scliente"]=="")
{
	$salida="nada2";
	echo json_encode($salida);
}
else
{
	//Capturo la fecha de inicio y termino de la cotizacion
	date_default_timezone_set("Chile/Continental");
	$f1=date("Y-m-d");
	$f2=date("Y-m-d", strtotime('+'.$_POST["tcotizacion"].' day'));
	//************************************************************
	
	//Capturo los datos de los select y contador
	$cliente=$_POST["scliente"];
	$contador=$tra->ObtieneCotizacion();
	$empresa=$_SESSION['SESS_EMPRESA_ID'];
	$fpago=$_POST["fpago"];
	$neto=$_POST["neto"];
	$iva=$_POST["iva"];
	$total=$_POST["total"];
	
	$IdECotizacion=$tra->insertar_ecotizacion
		("2",
		$contador,
		$cliente,
		$fpago,
		$neto,
		$iva,
		"0",
		$total,
		'NOW()',
		$f2,"","",
		$_SESSION['SESS_USER_ID'],
		$empresa,
		$_POST["glosa"]);
	
	//die($IdECotizacion); 
	
	//termino de insertar a la table ecotizacion 
	
	//ahora inserto los datos a la table de dcotizacion
	
	//capturo datos del tbl-body
	
	
	
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
		$tra->insertar_dcotizacion($IdECotizacion,
			$_POST["posicion"][$i],
			$_POST["codigo"][$i],
			$proba,
			$_POST["cantidad"][$i],
			$_POST["descuento"][$i],
			$_POST["bodega"][$i],
			$neto2,
			$iva2,
			0.19,
			$_POST["total_tbl"][$i],
			$empresa);
		
		}
		
	}
	
	$salida="todo";
	echo json_encode($salida);
}
	
?>