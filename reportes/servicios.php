<?php

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();
 
$PERMISOS=array();
$PERMISOS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'AREA-GUIADESPACHO');
 
 
if (!$PERMISOS['VER_DOCUMENTO']=='1'){

    $message="Gu’a de Despacho :: VER_DOCUMENTO :: Acceso denegado.";
    print "<script>alert('$message');window.history.back();</script>";
    die;
    
}
/***/

//Import the PhpJasperLibrary
include_once("tcpdf/tcpdf.php");
include_once("PHPJasperXML.inc.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
 
//database connection details
 
$server="localhost";
$db="cne9836_poblete";
$user="cne9836_userinox";
$pass="1q2w3e4r5t6y";
$version="0.8b";
$mysqlport=3306;
$pchartfolder="./pchart2";

$contador = $_GET["id_proyecto"];  // parametro de la URL de ordencrud_main.php
//$contador = "1";

 
//display errors should be off in the php.ini file
ini_set('display_errors', 0);
 
//setting the path to the created jrxml file
$xml =  simplexml_load_file("rp_servicios.jrxml");
 

 
 
$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$PHPJasperXML->arrayParameter=array("id"=>$contador);
$PHPJasperXML->xml_dismantle($xml);
 
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
 
 
?>
