<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{

    if($_GET["action"] == "list")
    {

        if($_POST)
        {
            if($_POST["nombreproducto"]=="" or $_POST["nombreproducto"]=="null")
            {
                $product="";
            }else
            {
                $product=$_POST["nombreproducto"];
            }

            $product=strtoupper(str_replace(' ','%',$product));

            if($_POST['inactivo2']=="1" or $_POST['inactivo2']=="")
            {
                $radio="AND product.Estado='activo'";
            }elseif($_POST['inactivo2']=="2")
            {
                $radio="";
            }
        }
        

        $product="";
        $radio="";

        $jtSorting=$_GET["jtSorting"];
        $jtStartIndex=$_GET["jtStartIndex"];
        $jtPageSize=$_GET["jtPageSize"];

        $from="FROM
                product
                LEFT OUTER JOIN suppliers ON product.IDSupplier = suppliers.IDsuppliers
                LEFT OUTER JOIN category_product ON product.IDCategory = category_product.IDCategoryProduct
                LEFT OUTER JOIN almacen ON product.IDCellar = almacen.IdAlmacen
                LEFT OUTER JOIN unidad ON product.UnidadMedida = unidad.IDUnidad";
        $where="WHERE UPPER(REPLACE(CONCAT(product.CodeBar,product.CodeProduct,product.ProductName),' ',''))  LIKE '%$product%' $radio";
        $limit="LIMIT $jtStartIndex,$jtPageSize";

        $sql2=<<<QUERY
        SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
        $row = mysql_fetch_array($result);
        $recordCount = $row['RecordCount'];


        $sql=<<<QUERY

        SELECT
                product.IDProduct,
                product.CodeBar,
                product.ProductName,
                product.QuantityPerUnit,
                product.PurchasePrice,
                product.UnitPrice,
                product.UnitsInStock,
                product.Discontinued,
                product.CodeProduct,
                product.Description,
                product.Description2,
                product.LastUpdate,
                product.Estado,
                product.UnidadMedida,
                product.img_producto,
                suppliers.Suppliers,
                category_product.CategoryProduct,
                almacen.Nombre,
                unidad.Unidad,
        product.IDCellar
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
        {     $vRESP="OK"; $vMENSAJE = "producto :: listar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "producto :: listar :: SQLERROR -> $msgerror -> $sql";};


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
    $imgaen=$_POST[""];

        $sql=<<<QUERY
    INSERT INTO  product (
        IDProduct ,
        CodeBar ,
        ProductName ,
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
        NULL ,  '$CodeBar',  '$ProductName',  '$IDSupplier',  '$IDCategory',  '1',  '1',  '0',
          '0.19',  '0',  '0',  'N',  '$CodeBar',  '0',  '0',  '0',  '0',  '0',  '0',
            '$Description',  '$Description2',
        CURRENT_TIMESTAMP ,  'activo',  '$UnidadMedida'
        );


QUERY;
        $msgerror="";
        try
        {  $result = mysql_query($sql,conectar::con());}
        catch(Exception $ex){    $result=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($result)
        {     $vRESP="OK"; $vMENSAJE = "productos :: Ingresar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "productos :: Ingresar :: SQLERROR -> $msgerror -> $sql";};


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

        UPDATE  product SET  CodeBar =  '$CodeBar',
        ProductName =  '$ProductName',
        IDSupplier =  '$IDSupplier',
        IDCategory =  '$IDCategory',
        PurchasePrice =  '$PurchasePrice',
        TaxValue =  '0.19',
        UnitPrice =  '$UnitPrice',
        UnitsInStock =  '$UnitsInStock',
        CodeProduct =  '$CodeBar',
        Description =  '$Description',
        Description2 =  '$Description2',
        LastUpdate = NOW( ) ,
        Estado =  'activo',
        UnidadMedida =  '$UnidadMedida' WHERE  product.IDProduct ='$IDProduct';

QUERY;



        //die($sql);

        $msgerror="";
        try
        { $result = mysql_query($sql,conectar::con());}
        catch(Exception $ex){    $result=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($result)
        {     $vRESP="OK"; $vMENSAJE = "comunas :: Modificar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "comunas :: Modificar :: SQLERROR -> $msgerror -> $sql";};



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
        UPDATE  product SET Estado =  'inactivo' WHERE  product.IDProduct ='$IDProduct';
QUERY;

        $msgerror="";
        try
        { $result = mysql_query($delete,conectar::con());}
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
        print json_encode($jTableResult);
    }
    else if($_GET["action"] == "proveedores")
    {
        $sqlpro=<<<QUERY

        SELECT
        suppliers.Suppliers,
        suppliers.IDsuppliers
        FROM
        suppliers
QUERY;

        $msgerror="";

        try
        {

          $resultsql = mysql_query($sqlpro,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
          {
                $resoptions[]=array("DisplayText"=>$row["Suppliers"],"Value"=>$row["IDsuppliers"]);
          }

        }
        catch(Exception $ex){    $resultsql=0; $msgerror=$ex;}


        $vRESP=$result;
        if ($resultsql)
        {     $vRESP="OK"; $vMENSAJE = "proveedores :: cargar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "proveedores :: cargar :: SQLERROR -> $msgerror -> $sqlpro";};

        $result = array();
        $result['Result'] = $vRESP;
        $result['Message']= $vMENSAJE;
        $result['Options']= $resoptions;

        print json_encode($result);

    }
    else if($_GET["action"] == "CategoryProduct")
    {
        $sqlcat=<<<QUERY

        SELECT
        category_product.IDCategoryProduct,
        category_product.CategoryProduct
        FROM
        category_product
QUERY;

        $msgerror="";

        try
        {

          $resultsql = mysql_query($sqlcat,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
          {
                $resoptions[]=array("DisplayText"=>$row["CategoryProduct"],"Value"=>$row["IDCategoryProduct"]);
          }

        }
        catch(Exception $ex){    $resultsql=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($resultsql)
        {     $vRESP="OK"; $vMENSAJE = "CategoryProduct :: cargar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "CategoryProduct :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

        $result = array();
        $result['Result'] = $vRESP;
        $result['Message']= $vMENSAJE;
        $result['Options']= $resoptions;

        print json_encode($result);

    }
    else if($_GET["action"] == "Nombre")
    {
        $sqlnom=<<<QUERY

        SELECT
        almacen.IdAlmacen,
        almacen.Nombre
        FROM
        almacen
QUERY;

        $msgerror="";

        try
        {

          $resultsql = mysql_query($sqlnom,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
          {
                $resoptions[]=array("DisplayText"=>$row["Nombre"],"Value"=>$row["IdAlmacen"]);
          }

        }
        catch(Exception $ex){    $resultsql=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($resultsql)
        {     $vRESP="OK"; $vMENSAJE = "Almacen :: cargar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Almacen :: cargar :: SQLERROR -> $msgerror -> $sqlnom";};

        $result = array();
        $result['Result'] = $vRESP;
        $result['Message']= $vMENSAJE;
        $result['Options']= $resoptions;

        print json_encode($result);

    }
     else if($_GET["action"] == "unidad")
    {
        $sqlun=<<<QUERY

        SELECT
        unidad.IDUnidad,
        unidad.Unidad
        FROM
        unidad
QUERY;

        $msgerror="";

        try
        {

          $resultsql = mysql_query($sqlun,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
          {
                $resoptions[]=array("DisplayText"=>$row["Unidad"],"Value"=>$row["IDUnidad"]);
          }

        }
        catch(Exception $ex){    $resultsql=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($resultsql)
        {     $vRESP="OK"; $vMENSAJE = "Almacen :: cargar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "Almacen :: cargar :: SQLERROR -> $msgerror -> $sqlun";};

        $result = array();
        $result['Result'] = $vRESP;
        $result['Message']= $vMENSAJE;
        $result['Options']= $resoptions;

        print json_encode($result);

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
