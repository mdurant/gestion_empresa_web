<?php
require_once("../../validatesession_json.php");
header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
    
  if($_GET["action"] == "list")
  {

    if($_POST)
    {
      if($_POST["rutproveedor"]=="" or $_POST["rutproveedor"]=="null")
      {
        $product="";
      }else
      {
        $product=$_POST["rutproveedor"];
      }
          
          if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
          {
              $radio="";
          }elseif($_POST['inactivo']=="2")
          {
              $radio="";
          }
          
          if(empty($_POST["inicio"]) or empty($_POST["fin"]))
          {
              
          }else
          {
            $inicio = date("Y-m-d", strtotime($_POST["inicio"]));
            $fin = date("Y-m-d", strtotime($_POST["fin"]));
            $dat="(FechaFacturacion BETWEEN '".$inicio."' AND '".$fin."') OR";
          }
    }
    
       $product="";
       $radio="";
       $inicio = "";
       $fin = "";
       $dat = "";
        

        
    $jtSorting=$_GET["jtSorting"];
    $jtStartIndex=$_GET["jtStartIndex"];
    $jtPageSize=$_GET["jtPageSize"];
            
    $from="FROM enotacredito a 
   INNER JOIN suppliers b ON a.IDsuppliers = b.IDsuppliers
   INNER JOIN empresa c ON a.IDEmpresa = c.IDEmpresa
   INNER JOIN motivo_credito d ON a.IDMotivo = d.IDMotivo
   INNER JOIN formapago e ON a.IdFormaPago = e.IdFormaPago";
    
    $where="WHERE $dat (b.Suppliers
      LIKE '%$product%' or c.RazonSocial
      LIKE '%$product%'
      or
      a.Numero LIKE '%$product%')  $radio";
    $limit="LIMIT $jtStartIndex,$jtPageSize";
    
    
    $sql2=<<<QUERY
    SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
    $row = mysql_fetch_array($result);
    $recordCount = $row['RecordCount'];
    
    
        $sql=<<< QUERY
      SELECT 
        a.IdEnotacredito, 
        a.Numero, 
        a.Folio_nota_credito, 
        a.IdFormaPago, 
        a.Neto, 
        a.Iva, 
        a.Total, 
        a.FechaFacturacion, 
        a.`User`, 
        a.Estado, 
        a.IDEmpresa, 
        a.IDMotivo, 
        a.IDsuppliers, 
        a.glosa, 
        a.estadocontable, 
        b.Suppliers, 
        c.RazonSocial, 
        c.RUT, 
        d.nombre, 
        e.Nombre as FormaPago
      $from  $where
      ORDER BY $jtSorting
      $limit; 
          
QUERY;

        $msgerror="";
    try
    {  $result = mysql_query($sql,conectar::con()); 
//echo $sql;
    } 
        catch(Exception $ex){ $result=0; $msgerror=$ex;}
    
    $vRESP=$result;
    if ($result)
    {   $vRESP="OK"; $vMENSAJE = "Notas de Crédito :: listar :: OK!"; }
    else
    { $vRESP="ERROR"; $vMENSAJE = "Notas de Crédito :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
    
    
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

 
  //Deleting a record (deleteAction)
  else if($_GET["action"] == "delete")
  {
    
       $IdEnotacredito=$_POST["IdEnotacredito"];

    $delete=<<<QUERY
    UPDATE  enotacredito SET  Estado =  'inactivo' WHERE  enotacredito.IdEnotacredito ='$IdEnotacredito';
QUERY;

    $msgerror="";
    try
    { $result = mysql_query($delete,conectar::con());
      echo $delete;
    } 
        catch(Exception $ex){ $result=0; $msgerror=$ex;}
    
    $vRESP=$result;
    if ($result)
    {   $vRESP="OK"; $vMENSAJE = "Nota de Crédito :: Eliminada/Inactiva :: OK!"; }
    else
    { $vRESP="ERROR"; $vMENSAJE = "Nota de Crédito :: Eliminada/Inactiva :: SQLERROR -> $msgerror -> $sql";};


    //Return result to jTable
    $jTableResult = array();
    $jTableResult['Result'] = $vRESP;
    $jTableResult['Message']= $vMENSAJE;
    print json_encode($jTableResult);
  }
    
    
      else if($_GET["action"] == "devolucion")
  {
    
       $IdEFactura=$_GET["dato"];

    //primero cambio el estado de la efactura
        
    $seleccion=<<<QUERY
    update ecompra set Estado="Devuelto" where id_ecompra = "$IdEFactura";
QUERY;
        mysql_query($seleccion,conectar::con());
        
        //selecciono todos los rows de dfatura
        
        $selecciondfactura=<<<QUERY
        select * from dcompra where id_ecompra= "$IdEFactura"
QUERY;

    $msgerror="";
    try
    { $result = mysql_query($delete,conectar::con());

    } 
        catch(Exception $ex){ $result=0; $msgerror=$ex;}
    
    $vRESP=$result;
    if ($result)
    {   $vRESP="OK"; $vMENSAJE = "Nota de Crédito :: Facturada :: OK!"; }
    else
    { $vRESP="ERROR"; $vMENSAJE = "Nota de Crédito :: Facturada :: SQLERROR -> $msgerror -> $sql";};


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
