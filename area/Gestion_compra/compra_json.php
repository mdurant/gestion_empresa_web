<?php
require_once("compra_sql.php");
$tra_compra=new cargar_compra();
$res=$tra_compra->traer_datos($_POST["codigo"]);

$salida=array("precio_compra" => $res[0]["PurchasePrice"],
			  "precio_venta" => $res[0]["UnitPrice"]);

echo json_encode($salida);

?>
