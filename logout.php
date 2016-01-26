<?php
/*
Cerrar Sesion en php
Update table: session
Mauricio Duran
*/
$var1=$_REQUEST['ID'];
require_once("conexion/conexion.php");
$query="SELECT * 
FROM  session 
WHERE  sessionid =  '$var1'";

$res = mysql_query($query,conectar::con());

session_start();
 date_default_timezone_set("Chile/Continental");

  
  unset($_SESSION['SESS_USER_ID']); 
  unset($_SESSION['SESS_USERNAME']);
  unset($_SESSION['SESS_FECHA']);
  unset($_SESSION['SESS_HORA']);
  unset($_SESSION['SESS_EQUIPO']);
  unset($_SESSION['SESS_IP']);
  $nueva_fecha=date('d')."/".date('m')."/".date('Y');
  $nueva_hora=date('G').":".date('i').":".date('s');
  $query_u="UPDATE  session SET  sessionid =  '$var1',
fecha_close =  '$nueva_fecha',
hora_close =  '$nueva_hora'
WHERE  session.IDSession =$var1";
  $res=mysql_query($query_u,conectar::con());
  
  session_destroy();
  header("Location: index.php");
  exit;
?>