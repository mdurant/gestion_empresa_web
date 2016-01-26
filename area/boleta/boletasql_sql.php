<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../validatesession_json.php");
require_once("../../conexion/funciones.php");
$func = new funciones();

$PERMISOS_AREABOLETA=array();
$PERMISOS_AREABOLETA=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'AREA-BOLETA');

require_once("../../conexion/conexion.php");


try
{
    if($_GET["action"] == "list")
    {

        if (!$PERMISOS_AREABOLETA['LISTAR']=='1'){

            $jTableResult = array();
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message']= "Boletas :: LISTAR :: Acceso denegado.";
            $jTableResult['TotalRecordCount'] = 0;
            $jTableResult['Records'] = array();

            print json_encode($jTableResult);
            die;

        }


        if($_POST["rutcliente"]=="" or $_POST["rutcliente"]=="null")
        {
            $product="";
        }else
        {
            $product=$_POST["rutcliente"];
        }

        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND eboleta.Estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }

        if(empty($_POST["inicio"]) or empty($_POST["fin"]))
        {

        }else
        {
            $inicio = date("d-m-Y", strtotime($_POST["inicio"]));
            $fin = date("d-m-Y", strtotime($_POST["fin"]));

            //$inicio = $_POST["inicio"]);
            //$fin = $_POST["fin"]);

            $_SESSION["BOL_FECHABUSQUEDA1"] = $inicio;
            $_SESSION["BOL_FECHABUSQUEDA2"] = $fin;

            $dat="(fecha_ingreso BETWEEN STR_TO_DATE('$inicio 00:00:00','%d-%m-%Y %H:%i:%s') and STR_TO_DATE('$fin 23:59:59','%d-%m-%Y %H:%i:%s')) and";
        }

        $jtSorting=$_GET["jtSorting"];
        $jtStartIndex=$_GET["jtStartIndex"];
        $jtPageSize=$_GET["jtPageSize"];

        $from="FROM eboleta INNER JOIN empresa ON eboleta.id_empresa = empresa.IDEmpresa
     INNER JOIN suppliers ON eboleta.id_proveedor = suppliers.IDsuppliers";
        $where="WHERE $dat (empresa.RUT LIKE '%$product%' or empresa.RazonSocial LIKE '%$product%' or eboleta.contador LIKE '%$product%')  $radio";
        $limit="LIMIT $jtStartIndex,$jtPageSize";

        $sql2=<<<QUERY
        SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
        $row = mysql_fetch_array($result);
        $recordCount = $row['RecordCount'];


        $sql=<<<QUERY

                SELECT eboleta.id_boleta,
    eboleta.contador,
    eboleta.folio_boleta,
    eboleta.fecha_compra,
    eboleta.fecha_ingreso,
    eboleta.id_empresa,
    eboleta.id_proveedor,
    eboleta.estado,
    replace(format(eboleta.total, 0),',','.') total,
    replace(format(eboleta.iva,0),',','.') iva,
    replace(format(eboleta.neto,0),',','.')neto,
    eboleta.estadocontable,
    empresa.RazonSocial,
    empresa.RUT as Rut_Empresa,
    suppliers.Suppliers,
    suppliers.RUT as Rut_Proveedor
                $from
                $where
                ORDER BY $jtSorting
                $limit;
QUERY;



        $msgerror="";
        try
        {  $result = mysql_query($sql,conectar::con());    }
        catch(Exception $ex){    $result=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($result)
        {     $vRESP="OK"; $vMENSAJE = "Boleta de Venta :: listar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Boleta de Venta :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};


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

        if (!$PERMISOS_AREABOLETA['ELIMINAR']=='1'){

            $jTableResult = array();
            $jTableResult['Result'] = "ERROR";
            $jTableResult['Message']= "Boletas :: ELIMINAR :: Acceso denegado.";
            $jTableResult['TotalRecordCount'] = 0;
            $jTableResult['Records'] = array();

            print json_encode($jTableResult);
            die;

        }

        $id_boleta=$_POST["id_boleta"];

        $delete=<<<QUERY
        UPDATE eboleta SET  Estado =  'inactivo' WHERE  eboleta.id_boleta ="$id_boleta";
QUERY;

        $msgerror="";
        try
        { $result = mysql_query($delete,conectar::con());}
        catch(Exception $ex){    $result=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($result)
        {     $vRESP="OK"; $vMENSAJE = "Boleta :: Facturada :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Boleta :: Facturada :: SQLERROR -> $msgerror -> $sql";};


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
