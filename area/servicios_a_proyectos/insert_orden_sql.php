<?php
require_once("../../validatesession_json.php");
require_once("orden_sql.php");

$tra=new cargar_orden();

//$Empresa = $_SESSION['SESS_EMPRESA_ID'];

	//Capturo la fecha de inicio y termino de la Guia
	date_default_timezone_set("Chile/Continental");
	$f1=$_POST["fecha_operacion"];//nuevo
	// Orden de los campos al insertar
	$contador=$tra->obtiene_servicio();
	$proyecto=$_POST["proyecto"];
	$proveedor=$_POST["proveedor"];
	$numero_documento=$_POST["txt_documento"];
	$usuario=$_SESSION['SESS_USERNAME'];
	$fecha_ingreso=date('Y-m-d', strtotime($f1));
	$glosa=$_POST["glosa"];
	 $neto=$_POST["total"];
	 $iva =($neto*19)/100;
	 $total =$neto+$iva;
	 $estado ="activo";
	 
	$id_ultimo=$tra->insertar_eservicios($proyecto,$contador,$usuario,$fecha_ingreso,$proveedor,$numero_documento,$glosa,$neto,$iva,$total,$estado);
	
	
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
		$tipo_impuesto="19% IVA";
		$valor=$_POST["valor"][$i];
		$valor_neto=$_POST["total_tbl"][$i];
		$valor_iva=($valor_neto*19)/100;
		$valor_subtotal =$valor_neto+$valor_iva;
		
		

	//	$tra->insertar_dorden($id_ultimo[0],$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor,$sub_total);
$tra->insertar_dservicios($id_ultimo[0],$posicion,$codigo,$descripcion,$cantidad,$tipo_impuesto,$valor_neto,$valor_iva,$valor_subtotal);
			
	
	
		}
		
	}
	$vare="Se Inserto Correctamente";
	$salida="todo";
	echo json_encode($vare);

	
?>