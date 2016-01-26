<?php
require_once("boleta_sql.php");

$tra_cotizacion=new cargar_cotizacion();
$res=$tra_cotizacion->traer_datos($_POST["bsq"]);


$salida=array("precio" => $res[0]["UnitPrice"],
			  "almacen" => $res[0]["Nombre"],
			  "descripcion" => $res[0]["ProductName"],
			  "stock" => $res[0]["UnitsInStock"]);
			  echo json_encode($salida);


?>
