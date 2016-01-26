<?php
require_once("../../conexion/conexion.php");
$folio=$_POST["fol"];
$ot=$_POST["id_ots"];

$query="update eorden set folio='".$folio."' where id_orden='".$ot."'";

mysql_query($query,conectar::con());
echo json_encode("listo");


?>