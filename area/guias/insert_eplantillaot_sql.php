<?php
require_once("eplantillaot_sql.php");

$tra=new cargar_plantilla();


	//Capturo la fecha de inicio y termino de la cotizacion
	date_default_timezone_set("Chile/Continental");
	//$f1=date("Y-m-d");
	$f1=$_POST["facturacion"];//nuevo
	//$f2=date("Y-m-d", strtotime('+'.$_POST["tcotizacion"].' day'));
	$ffinal=date('Y-m-d', strtotime($f1));
	//************************************************************
	
	//Capturo los datos de los select y contador
	// $cliente=$_POST["scliente"];
	$empresa=$_POST["tempresa"];
	// $fpago=$_POST["fpago"];
	$clientes=$_POST["clientes"];
	$folio=$_POST["folio"];
	$nombre=$_POST["nplantilla"];
	$describe=$_POST["dplantilla"];
        $id_ultimo=$tra->insertar_eplantillaot($nombre,$describe);
	
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

		$tra->insertar_dplantillaot($id_ultimo[0],$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor);

		}
		
	}
	
	$salida="todo";
	echo json_encode($ffinal);
	
?>