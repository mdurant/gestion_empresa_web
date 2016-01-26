<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");


try
{

    if($_GET["action"] == "list")
    {
         date_default_timezone_set('America/Santiago');
        if($_POST["rutcliente"]=="" or $_POST["rutcliente"]=="null")
        {
            $product="";
        }else
        {
            $product=$_POST["rutcliente"];
        }

        if(empty($_POST["inicio"]) or empty($_POST["fin"]))
        {

        }else
        {
        $inicio = date("Y-m-d", strtotime($_POST["inicio"]));
        $fin = date("Y-m-d", strtotime($_POST["fin"]));
        $dat="(FechaCreacion BETWEEN '".$inicio."' AND '".$fin."') and";
        }

        $jtSorting=$_GET["jtSorting"];
        $jtStartIndex=$_GET["jtStartIndex"];
        $jtPageSize=$_GET["jtPageSize"];

        $from="FROM
                ecotizacion
                INNER JOIN customers ON ecotizacion.IdCliente = customers.IDCliente
                INNER JOIN empresa ON ecotizacion.IDEmpresa = empresa.IDEmpresa";
        $where="WHERE (ecotizacion.Estado ='activo') and $dat (customers.rut LIKE '%$product%' or empresa.RazonSocial LIKE '%$product%' or ecotizacion.Contador LIKE '%$product%')";
        $limit="LIMIT $jtStartIndex,$jtPageSize";

        $sql2=<<<QUERY
        SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
        $row = mysql_fetch_array($result);
        $recordCount = $row['RecordCount'];


        $sql=<<<QUERY

                SELECT
                ecotizacion.IdECotizacion,
                customers.rut,
                empresa.RazonSocial,
                ecotizacion.Contador,
                ecotizacion.Total,
                ecotizacion.FechaCreacion,
                ecotizacion.Estado,
                ecotizacion.FechaTermino,
                ecotizacion.motivo
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
        {     $vRESP="OK"; $vMENSAJE = "cotizacion :: listar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "cotizacion :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};


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
    //Updating a record (updateAction)
    else if($_GET["action"] == "update")
    {
       $IdECotizacion=$_POST["IdECotizacion"];
       $motivo=$_POST["motivo"];
       $fecha=$_POST["Aplazar"];
       date_default_timezone_set('America/Santiago');



        $sqlu=<<<QUERY

        UPDATE ecotizacion
            SET FechaTermino = "$fecha",
            motivo = "$motivo"
            WHERE IdECotizacion = "$IdECotizacion"

QUERY;

       // die($sql);

        $msgerror="";
        try
        { $result = mysql_query($sqlu,conectar::con());}
        catch(Exception $ex){    $result=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($result)
        {     $vRESP="OK"; $vMENSAJE = "Editar Cotización :: Modificar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Editar Cotización :: Modificar :: SQLERROR -> $msgerror -> $sql";};
        //*************************************************************

        //*************************************************************


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
