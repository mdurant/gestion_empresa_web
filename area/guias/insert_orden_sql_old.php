<?php
require_once("../../validatesession_json.php");
require_once("orden_sql.php");

$tra=new cargar_guia();




	//Capturo la fecha de inicio y termino de la cotizacion
	date_default_timezone_set("Chile/Continental");
	$f1=$_POST["facturacion"];//nuevo

	// Orden del POST en la BD
	$contador=$tra->ObtieneOrden();
	$folio=$_POST["folio"];
	$proyecto = $_POST["proyecto"];
	$cliente=$_POST["cliente"];
	$forma_pago="1"; // 30 dias
	$neto=$_POST["total"];
	$iva =($neto*19)/100;
	$impuesto="19";
	$total = $neto+$iva;
	$fecha_creacion=NOW();
	$fecha_facturacion=date('Y-m-d', strtotime($f1));
	$user =$_SESSION["SESS_USERNAME"];
	$estado='activo';
	$empresa = $_SESSION['SESS_EMPRESA_ID'];
	$motivo=$_POST["motivo"];
	$glosa=$_POST["glosa"];
	$estado_contable="Pendiente";
	$rut_chofer=$_POST["rut_chofer"];
	$nombre_chofer =$_POST["nombre_chofer"];
	$patente=$_POST["placa_patente"];
	$autoriza=$_POST["autorizado"];
	//$folio=0;
	$id_ultimo=$tra->insertar_eguia($contador,$folio,$proyecto,$cliente,$forma_pago,$neto,$iva,$impuesto,$total,$fecha_creacion,
    								$fecha_facturacion,$user,$estado,$empresa,$motivo,$glosa,$estado_contable,
    								$rut_chofer,$nombre_chofer,$patente,$autoriza);
   
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
	$vare="Guia de Despacho Generada";
	$salida="todo";
	echo json_encode($vare);

	
?>