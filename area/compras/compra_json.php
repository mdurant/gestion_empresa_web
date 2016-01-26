<?php
require_once("compra_sql.php");
//require_once("../../validatesession_json.php");


$tra_cotizacion=new cargar_compra();
$res=$tra_cotizacion->traer_datos($_POST["bsq"]);

//if(empty($res[0]["ProductName"]) || empty($res[0]["UnitPrice"]) || empty($res[0]["UnitsInStock"]))

if(empty($res[0]["ProductName"]))
{
	$salida="NO hay nada";
	echo json_encode($salida);
}else
{
$salida=array("precio" => $res[0]["UnitPrice"],
		"almacen" => $res[0]["Nombre"],
		"descripcion" => $res[0]["ProductName"],
		"stock" => $res[0]["UnitsInStock"],
		"prueba" => $_POST["bsq"]);

	 echo json_encode($salida);
}

?>
