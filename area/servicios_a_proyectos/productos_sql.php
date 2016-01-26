<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");

try
{

    if($_GET["action"] == "list")
    {
        if($_POST["nombre_servicio"]=="" or $_POST["nombre_servicio"]=="null")
        {
            $product="";
        }else
        {
            $product=$_POST["nombre_servicio"];
        }

        $product=strtoupper(str_replace(' ','%',$product));

        if($_POST['inactivo2']=="1" or $_POST['inactivo2']=="")
        {
            $radio="AND product.estado='activo'";
        }elseif($_POST['inactivo2']=="2")
        {
            $radio="";
        }

        $jtSorting=$_GET["jtSorting"];
        $jtStartIndex=$_GET["jtStartIndex"];
        $jtPageSize=$_GET["jtPageSize"];

        $from="FROM product";
        $where="WHERE
        product.tipo_producto = 'SERVICIO' or 
        product.tipo_producto ='MATERIAL'
        AND UPPER(REPLACE(CONCAT(product.CodeBar,product.ProductName),' ',''))  LIKE '%$product%' $radio";
        $limit="LIMIT $jtStartIndex,$jtPageSize";

        $sql2=<<<QUERY
        SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
        $row = mysql_fetch_array($result);
        $recordCount = $row['RecordCount'];


        $sql=<<<QUERY

        SELECT product.IDProduct, 
	product.CodeBar, 
	product.ProductName, 
	product.tipo_producto, 
	product.QuantityPerUnit, 
	product.PurchasePrice, 
	product.UnitPrice, 
	product.UnitsInStock,
        product.Estado
        $from
        $where
        ORDER BY IDProduct asc
        $limit;
QUERY;

        $msgerror="";
        try
        {  $result = mysql_query($sql,conectar::con());    }
        catch(Exception $ex){    $result=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($result)
        {     $vRESP="OK"; $vMENSAJE = "Servicios / Materiales :: listar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Servicios / Materiales :: listar :: SQLERROR -> $msgerror -> $sql";};


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
     else if($_GET["action"] == "create")
    {

    //Insert record into database
    	$CodeBar=$_POST["CodeBar"];
        $ProductName=$_POST["ProductName"];
	$tipo_producto=$_POST["tipo_producto"];
        $IDSupplier=$_POST["Suppliers"];
        $IDCategory=$_POST["CategoryProduct"];
        $IDCellar=$_POST["Nombre"];
        $QuantityPerUnit=$_POST["QuantityPerUnit"];
        $PurchasePrice=$_POST["PurchasePrice"];
        $UnitPrice=$_POST["UnitPrice"];
        $UnitsInStock=$_POST["UnitsInStock"];
        $Discontinued=$_POST["Discontinued"];
        $Description=$_POST["Description"];
        $Description2=$_POST["Description2"];
        $Estado=$_POST["Estado"];
        $UnidadMedida=$_POST["UnidadMedida"];

        $sql=<<<QUERY
    INSERT INTO  product (
        IDProduct ,
        CodeBar ,
        ProductName ,
	tipo_producto,
        IDSupplier ,
        IDCategory ,
        IDCellar ,
        QuantityPerUnit ,
        PurchasePrice ,
        TaxValue ,
        UnitPrice ,
        UnitsInStock ,
        Discontinued ,
        CodeProduct ,
        Alto ,
        Ancho ,
        Largo ,
        Volumen ,
        PesoNeto ,
        PesoBruto ,
        Description ,
        Description2 ,
        LastUpdate ,
        Estado ,
        UnidadMedida
        )
        VALUES (
        NULL ,
		'$CodeBar',
		'$ProductName',
		'$tipo_producto',
		'$IDSupplier',
		'$IDCategory',
		'1',
		'0',
		'0',
        '0.19',
		'0',
		'0',
		'N',
		'$CodeBar',
		'0',
		'0',
		'0',
		'0',
		'0',
		'0',
    '$Description',
		'$Description2', 
    CURRENT_TIMESTAMP ,
		'activo',
		'$UnidadMedida'
        );


QUERY;
        $msgerror="";
        try
        {  $result = mysql_query($sql,conectar::con());}
        catch(Exception $ex){    $result=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($result)
        {     $vRESP="OK"; $vMENSAJE = "Servicios / Materiales :: Ingresar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Servicios / Materiales :: Ingresar :: SQLERROR -> $msgerror -> $sql";};


        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = $vRESP;
        $jTableResult['Message']= $vMENSAJE;
        $jTableResult['Record'] = $result;
        print json_encode($jTableResult);
    }

    //Updating a record (updateAction)
    else if($_GET["action"] == "update")
    {
         $IDProduct=$_POST["IDProduct"];
	$CodeBar=$_POST["CodeBar"];
        $ProductName=$_POST["ProductName"];
	$tipo_producto=$_POST["tipo_producto"];
        $IDSupplier=$_POST["Suppliers"];
        $IDCategory=$_POST["CategoryProduct"];
        $QuantityPerUnit=$_POST["QuantityPerUnit"];
        $PurchasePrice=$_POST["PurchasePrice"];
        $UnitPrice=$_POST["UnitPrice"];
        $UnitsInStock=$_POST["UnitsInStock"];
        $Discontinued=$_POST["Discontinued"];
        $Description=$_POST["Description"];
        $Description2=$_POST["Description2"];
        $Estado=$_POST["Estado"];
        $UnidadMedida=$_POST["UnidadMedida"];

            $sql=<<<QUERY

        UPDATE  product SET
	CodeBar =  '$CodeBar',
        ProductName =  '$ProductName',
	tipo_producto ='$tipo_producto',
        IDSupplier =  '$IDSupplier',
        IDCategory =  '$IDCategory',
        QuantityPerUnit =  '$QuantityPerUnit',
        PurchasePrice =  '$PurchasePrice',
        TaxValue =  '0.19',
        UnitPrice =  '$UnitPrice',
        CodeProduct =  '$CodeBar',
        Description =  '$Description',
        Description2 =  '$Description2',
        LastUpdate = NOW( ) ,
        UnidadMedida =  '$UnidadMedida'
		WHERE
		product.IDProduct ='$IDProduct';

QUERY;



        //die($sql);

        $msgerror="";
        try
        { $result = mysql_query($sql,conectar::con());}
        catch(Exception $ex){    $result=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($result)
        {     $vRESP="OK"; $vMENSAJE = "Servicios / Materiales :: Modificar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Servicios / Materiales :: Modificar :: SQLERROR -> $msgerror -> $sql";};



        //Return result to jTable
        $jTableResult = array();
        $jTableResult['Result'] = $vRESP;
        $jTableResult['Message']= $vMENSAJE;
        print json_encode($jTableResult);

    }
    //Deleting a record (deleteAction)
    else if($_GET["action"] == "delete")
    {

        $IDProduct=$_POST["IDProduct"];

        $delete=<<<QUERY
       UPDATE
		product SET
		Estado =  'inactivo'
		WHERE
		product.IDProduct ='$IDProduct';
QUERY;

        $msgerror="";
        try
        { $result = mysql_query($delete,conectar::con());}
        catch(Exception $ex){    $result=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($result)
        {     $vRESP="OK"; $vMENSAJE = "Servicios / Materiales :: Facturada :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Servicios / Materiales :: Facturada :: SQLERROR -> $msgerror -> $sql";};


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
