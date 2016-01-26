<?php
require_once("../../validatesession_json.php");
require_once("plantilla_sql.php");

    $tra=new cargar_cotizacion();
	//Capturo la fecha de inicio y termino de la cotizacion
	date_default_timezone_set("Chile/Continental");
	$f1=date("Y-m-d");
	//************************************************************
	
	//Capturo los datos de los select y contador
	$nombrepla=$_POST["nombrepla"];
	$descripcionpla=$_POST["descripcionpla"];
	$contador=$tra->insertar_eplantilla($nombrepla,$descripcionpla);
	
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
			$proba=$_POST["descripcion"][$i];
			$iva2=($_POST["total_tbl"][$i]-$_POST["precio_unitario"][$i]);
			$neto2=$_POST["precio_unitario"][$i];
			$totales=$_POST["total_tbl"][$i];
			$tra->insertar_dplantilla($contador[0],$_POST["cantidad"][$i],$_POST["descuento"][$i],$proba,$_POST["codigo"][$i],$neto2,$iva2,$totales,$_POST["posicion"][$i]);
			
		}
		
	}
	
	$salida="todo";
	echo json_encode($salida);
	
?>