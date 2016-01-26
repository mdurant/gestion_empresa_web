<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
  if($_GET["action"] == "list")
  {
     date_default_timezone_set('America/Santiago');
     if($_POST)
     {
        if($_POST["guia_compra"]=="" or $_POST["guia_compra"]=="null")
        {
          $product="";
        }else
        {
          $product=$_POST["guia_compra"];
        }
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
            {
                 $radio="AND eguiacompra.estado='activo'";
            }elseif($_POST['inactivo']=="2")
            {
                $radio="";
            }
     }else
     {
      $product="";
      $radio="";
     }
    
        
    $jtSorting=$_GET["jtSorting"];
    $jtStartIndex=$_GET["jtStartIndex"];
    $jtPageSize=$_GET["jtPageSize"];
            
    $from="FROM eguiacompra
    INNER JOIN suppliers ON eguiacompra.id_proveedor = suppliers.IDsuppliers
    INNER JOIN empresa ON eguiacompra.id_empresa = empresa.IDEmpresa";
    $where="WHERE (suppliers.Suppliers LIKE '%$product%' or empresa.RazonSocial LIKE '%$product%') $radio";
    $limit="LIMIT $jtStartIndex,$jtPageSize";

    $ordenar="order by $jtSorting";
    
    $sql2=<<<QUERY
    SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
    $row = mysql_fetch_array($result);
    $recordCount = $row['RecordCount'];
    
    
        $sql=<<<QUERY
  SELECT eguiacompra.ideguiacompra, 
  eguiacompra.numero, 
  suppliers.Suppliers, 
  eguiacompra.folio,
  eguiacompra.factura_numero,
  eguiacompra.neto, 
  eguiacompra.iva, 
  eguiacompra.impuesto, 
  eguiacompra.total, 
  eguiacompra.fecha_emision, 
  eguiacompra.fecha_ingreso, 
  eguiacompra.usuario, 
  empresa.RazonSocial, 
  eguiacompra.estado_contable,
  eguiacompra.orden_compra,
  eguiacompra.folio
  $from  
  $where
  $ordenar
  $limit;   
QUERY;

        $msgerror="";
    try
    {  $result = mysql_query($sql,conectar::con()); } 
        catch(Exception $ex){ $result=0; $msgerror=$ex;}
    
    $vRESP=$result;
    if ($result)
    {   $vRESP="OK"; $vMENSAJE = "Guia Compra :: listar :: OK!";  }
    else
    { $vRESP="ERROR"; $vMENSAJE = "Guia Compra :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
    
    
    //Add all records to an array
    $rows = array();
    while($row = mysql_fetch_array($result))
    {

        $rows[] = $row;
      // $rows[] = array_map('utf8_encode', $row);
      
    }

    //Return result to jTable
    $jTableResult = array();
    $jTableResult['Result'] = $vRESP;
    $jTableResult['Message']= $vMENSAJE;
    $jTableResult['TotalRecordCount'] = $recordCount;
    $jTableResult['Records'] = $rows;
    
    print json_encode($jTableResult);
    
  }
  
  else if($_GET["action"] == "delete")
  {
    $idguiacompra=$_POST["ideguiacompra"];
    //Delete from database
    $delete=<<<QUERY
        UPDATE eguiacompra set estado="inactivo" WHERE ideguiacompra = $idguiacompra;
QUERY;

    $msgerror="";
    try
    { $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){ $result=0; $msgerror=$ex;}
    
    $vRESP=$result;
    if ($result)
    {   $vRESP="OK"; $vMENSAJE = "Guia Compra :: Eliminar :: OK!";  }
    else
    { $vRESP="ERROR"; $vMENSAJE = "Guia Compra :: Eliminar :: SQLERROR -> $msgerror -> $delete";};


    //Return result to jTable
    $jTableResult = array();
    $jTableResult['Result'] = $vRESP;
    $jTableResult['Message']= $vMENSAJE;
    print json_encode($jTableResult);
  }
  else if($_GET["action"] == "aso")
  {
    $idguiacompra=$_POST["id_ecompra"];
    $Folio=$_POST["folio_factura"];
    //Delete from database
    $delete=<<<QUERY
        UPDATE eguiacompra set factura_numero="$Folio" WHERE ideguiacompra = $idguiacompra;
QUERY;

    $msgerror="";
    try
    { $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){ $result=0; $msgerror=$ex;}
    
    $vRESP=$result;
    if ($result)
    {   $vRESP="OK"; $vMENSAJE = "Guia Compra :: Aso :: OK!"; }
    else
    { $vRESP="ERROR"; $vMENSAJE = "Guia Compra :: Aso :: SQLERROR -> $msgerror -> $delete";};


    //Return result to jTable
    $jTableResult = array();
    $jTableResult['Result'] = $vRESP;
    $jTableResult['Message']= $vMENSAJE;
    print json_encode($jTableResult);
  }
        
  
  conectar::desconectar();
}
catch(Exception $ex)
{
    //Return error message
  $jTableResult = array();
  $jTableResult['Result'] = "ERROR";
  $jTableResult['Message'] = $ex->getMessage();
  print json_encode($jTableResult);
}
?>
