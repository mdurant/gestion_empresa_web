<?php
 
//Import the PhpJasperLibrary
include_once("tcpdf/tcpdf.php");
include_once("PHPJasperXML.inc.php");

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
 
 
//database connection details
 
$server="localhost";
$db="cne9836_bdgestion";
$user="cne9836_gestion";
$pass="1q2w3e4r5t6y";
$version="0.8b";
$mysqlport=3306;
$pchartfolder="./pchart2";

$contador = $_GET["id_reporte"];
$hoy_fecha = date("d")."/".date("m")."/".date("Y");
/*
$neto_ot =$_GET["totalot"];
$iva=($neto_ot*19)/100;
$total_ot=$neto_ot+$iva;
 */
//display errors should be off in the php.ini file
ini_set('display_errors', 0);
 
//setting the path to the created jrxml file
$xml =  simplexml_load_file("rp_toma_inventario.jrxml");
 
$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$PHPJasperXML->arrayParameter=array("id_inventario"=>$contador,"hoy"=>$hoy_fecha);

//$PHPJasperXML->arrayParameter=array("NETO"=>0);
$PHPJasperXML->xml_dismantle($xml);
 
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file
 
 
?>
