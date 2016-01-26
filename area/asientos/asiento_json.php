<?php
require_once("../../validatesession_json.php");
require_once("factura_sql.php");

$tra_cotizacion=new cargar_cotizacion();
$res=$tra_cotizacion->traer_datos($_POST["bsq"]);



if(empty($res[0]["ProductName"]) || empty($res[0]["UnitPrice"]) || empty($res[0]["UnitsInStock"]))
{
	$salida="nada";
	echo json_encode($salida);
}else
{
$salida=array("precio" => $res[0]["UnitPrice"],
			  "almacen" => $res[0]["Nombre"],
			  "descripcion" => $res[0]["ProductName"],
			  "stock" => $res[0]["UnitsInStock"]);
			  echo json_encode($salida);
}

?>
