<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{

    if($_GET["action"] == "list")
    {
        if($_POST["sproveedor"]=="" or $_POST["sproveedor"]=="null")
        {
            $product="";
        }else
        {
            $product=$_POST["sproveedor"];
        }
        if($_POST["folio"]=="" or $_POST["folio"]=="null")
        {
            $folio="";
        }
        else
        {
            $folio=$_POST["folio"];
        }
        if($_POST["contador"] =="" or $_POST["contador"] == "null")
        {
            $contador = "";
        }
        else
        {
        $contador =$_POST["contador"];
        }
        $jtSorting=$_GET["jtSorting"];
        $jtStartIndex=$_GET["jtStartIndex"];
        $jtPageSize=$_GET["jtPageSize"];

        $from="FROM compromiso_pago_proveedores INNER JOIN users ON compromiso_pago_proveedores.id_usuario = users.IDUser
     INNER JOIN ecompra ON compromiso_pago_proveedores.id_compra = ecompra.id_ecompra
     INNER JOIN empresa ON ecompra.id_empresa = empresa.IDEmpresa
     INNER JOIN suppliers ON ecompra.id_provedores = suppliers.IDsuppliers";
        $where="WHERE ecompra.contador='$contador' OR
         ecompra.folio_factura = '$folio' OR
         suppliers.IDsuppliers = '$product'";
        $limit="LIMIT $jtStartIndex,$jtPageSize";

        $sql2=<<<QUERY
        SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
        $row = mysql_fetch_array($result);
        $recordCount = $row['RecordCount'];


        $sql=<<<QUERY

             SELECT
            compromiso_pago_proveedores.id_compromiso_proveedores,
            compromiso_pago_proveedores.numero_cuota,
            compromiso_pago_proveedores.monto_cuota,
            compromiso_pago_proveedores.monto_abono,
            compromiso_pago_proveedores.monto_final,
            compromiso_pago_proveedores.tipo_compromiso,
            compromiso_pago_proveedores.estado,
            compromiso_pago_proveedores.fecha_compromiso,
            compromiso_pago_proveedores.fecha_pago,
            users.Username,
            ecompra.contador,
            empresa.RazonSocial,
            suppliers.Suppliers,
            ecompra.folio_factura
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
        {     $vRESP="OK"; $vMENSAJE = "Pagos y Abonos :: listar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Pagos y Abonos :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};


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
       $id_pago_proveedores=$_GET["dat"];
       $tipopago=$_GET["tipopago"];
       $plaza1=$_GET["plaza1"];
       $banco1=$_GET["banco1"];
       if($banco1=="")
       {
        $banco1="10";
       }
       $titular1=$_GET["titular1"];
       $transaccion=$_GET["tran"];
       //insertar los datos a la tabla dgestion documento
       $sql_dpago_proveedores=<<<QUERY
       INSERT INTO dpago_proveedores
        (id_det_pago_proveedores,
        id_pago_proveedores,
        documento,
        plaza,
        titular,
        id_banco,
        fecha_pago,
        id_usuario)
        VALUES
        (NULL,
         "$"
         "$tipopago","$plaza1","$titular1","$banco1","$id_gestion_documento",NOW(),"$transaccion");
QUERY;
       mysql_query($sql_dgestion,conectar::con());

       date_default_timezone_set('America/Santiago');
        //Delete from database
        //$motivo=$_POST["motivo"];

        $sqlu=<<<QUERY

        UPDATE gestion_documento SET monto_final = "0", tipo_compromiso="$tipopago", estado ="Cancelada" WHERE id_gestion_documento ="$id_gestion_documento"

QUERY;

        //die($sql);

        $msgerror="";
        try
        { $result = mysql_query($sqlu,conectar::con());}
        catch(Exception $ex){    $result=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($result)
        {     $vRESP="OK"; $vMENSAJE = "Pagos y Abonos :: Modificar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Pagos y Abonos :: Modificar :: SQLERROR -> $msgerror -> $sql";};
        //*************************************************************

        //*************************************************************





        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = $vRESP;
        $jTableResult['Message']= $vMENSAJE;
        print json_encode($jTableResult);

    }
    else if($_GET["action"] == "compra")
    {

       $id_factura=$_GET["dat"];
       $id_gestion_documento=$_GET["igd"];
       $tipopago=$_GET["tipopago"];
       $plaza1=$_GET["plaza"];
       $banco1=$_GET["banco"];
       $titular1=$_GET["titular"];
       $monto=$_GET["monto"];
       $ncuotas=$_GET["ncuotas"];
       $transaccion2=$_GET["tran2"];
       if($banco1=="")
       {
        $banco1="10";
       }
       //seleccionamos los campos a editar de la tabla gestion_documento
       $sel=array();
       $gd=<<<QUERY
           SELECT * FROM gestion_documento WHERE id_efactura = "$id_factura" AND ncuota="$ncuotas"
QUERY;

        $res=mysql_query($gd,conectar::con());
        while($gdrow=mysql_fetch_assoc($res))
        {
            $sel[]=$gdrow;
        }

        //update a la tabla principla gestion documento
        $abonototal=($sel[0]["monto_cuota"]-$monto);

            $montos=<<<QUERY

        UPDATE gestion_documento SET monto_final = "$abonototal", tipo_compromiso="Abono", estado ="Por Cancelar", monto_abono = "$monto" WHERE id_gestion_documento ="$id_gestion_documento"

QUERY;


        mysql_query($montos,conectar::con());

        //insertar a la tabla dgestion_documento lo que se iso

        $otc=<<<QUERY
        INSERT INTO dgestion_documento
        (documento,plasa,titular,id_banco,id_gestion_documento,fecha_pago,numero_transaccion)
        VALUES
        ("$tipopago","$plasa","$titular","$banco1","$id_gestion_documento",NOW(),"$transaccion2");
QUERY;


    $msgerror="";
        try
        { $result = mysql_query($otc,conectar::con());}
        catch(Exception $ex){    $result=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($result)
        {     $vRESP="OK"; $vMENSAJE = "Cotizacion :: Facturada :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Cotizacion :: Facturada :: SQLERROR -> $msgerror -> $sql";};


        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = $vRESP;
        $jTableResult['Message']= $vMENSAJE;
        print json_encode($_GET["dat"]);
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
