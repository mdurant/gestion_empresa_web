<?php

//***************************************************************************************
//***************************************************************************************

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();
 
$PERMISOS=array();
$PERMISOS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'AREA-GUIADESPACHO');
 
 
if (!$PERMISOS['VER_DOCUMENTO']=='1'){

    $message="Guia Despacho :: VER_DOCUMENTO :: Acceso denegado.";
    print "<script>alert('$message');window.history.back();</script>";
    die;
    
}

//***************************************************************************************
//***************************************************************************************
 
//Import the PhpJasperLibrary
include_once("tcpdf/tcpdf.php");
include_once("PHPJasperXML.inc.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
 
//database connection details
 
$server="localhost";
$db="fullcode_tormesol";
$user="root";
$pass="1q2w3e4r";
$version="0.8b";
$mysqlport=3306;
$pchartfolder="./pchart2";

$contador = $_GET["IdEGuiaDespacho"];
 
 
//display errors should be off in the php.ini file
ini_set('display_errors', 0);
 
//setting the path to the created jrxml file
$xml =  simplexml_load_file("rp_guia_despacho.jrxml");
 
$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$PHPJasperXML->arrayParameter=array("Numero"=>$contador);
$PHPJasperXML->xml_dismantle($xml);
 
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
 
 
?>
