<?php
/*
Se modifican las tabulaciones (Query Beautiful) para las SQL
Se arreglan todos los mensajes de Ok o error (personalizados)
Se mejora el combobox de categoria de productos
Mauricio Duran
*/

header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_PRODUCTOS=array();
$PERMISOS_PRODUCTOS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'COMBUSTIBLE');


require_once("../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_PRODUCTOS['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Combustible :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}



		if($_POST["proveedor"]=="" or $_POST["proveedor"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["proveedor"];
		}
        
		$product=strtoupper(str_replace(' ','%',$product));
		
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND a.estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM compra_combustible a 
				INNER JOIN suppliers b ON a.id_proveedor = b.IDsuppliers";
		$where="WHERE UPPER(REPLACE(CONCAT(b.Suppliers),' ','')) LIKE '%$product%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
		SELECT a.id_compra_combustible, 
			a.id_proveedor, 
			a.id_empresa, 
			a.tipo_documento, 
			a.numero_documento, 
			a.glosa, 
			a.forma_pago, 
			a.fecha_emision, 
			a.fecha_registro, 
			a.neto, 
			a.excento, 
			a.impuesto_especifico, 
			a.iva, 
			a.total, 
			a.estado, 
			b.Suppliers
			$from  
            $where
			ORDER BY $jtSorting
			$limit;		
QUERY;
		
        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Compra Combustible :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Compra Combustible:: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
		
		if (!$PERMISOS_PRODUCTOS['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Compra Combustible :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

	
		$proveedor = $_POST["id_proveedor"];
		$empresa = $_POST["id_empresa"];
		$tipo_documento =$_POST["tipo_documento"];
		$numero_documento =$_POST["numero_documento"];
		$glosa=$_POST["glosa"];
		$forma_pago =$_POST["forma_pago"];
		$fecha_emision =$_POST["fecha_emision"];
		// Fecha Registro, Pendiente TimeStamp
		$neto=$_POST["neto"];
		$excento =$_POST["excento"];
		$impuesto_especifico =$_POST["impuesto_especifico"];
		$iva =$_POST["iva"];
		$total =$_POST["total"];
		$estado ="activo";
 
		$sql=<<<QUERY
		INSERT INTO compra_combustible
		(id_proveedor,
        id_empresa,
        tipo_documento,
        numero_documento,
        glosa,
        forma_pago,
        fecha_emision,
		neto,
        excento,
        impuesto_especifico,
        iva,
        total,
        estado)

		VALUES (
		'$proveedor',
        '$empresa',
        '$tipo_documento',
        '$numero_documento',
        '$glosa',
        '$forma_pago',
        '$fecha_emision',
        '$neto',
        '$excento',
        '$impuesto_especifico',
        '$iva',
        '$total',
        '$estado');
		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Compra Combustible :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Compra Combustible :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		

		 $IDProductos = mysql_query("SELECT * FROM compra_combustible WHERE id_compra_combustible = LAST_INSERT_ID();");
		 $row = mysql_fetch_array($IDProductos);
					
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{

		if (!$PERMISOS_PRODUCTOS['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Compra Combustible :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}




		$id_compra_combustible = $_POST["id_compra_combustible"];
	    $proveedor = $_POST["id_proveedor"];
		$empresa = $_POST["id_empresa"];
		$tipo_documento =$_POST["tipo_documento"];
		$numero_documento =$_POST["numero_documento"];
		$glosa=$_POST["glosa"];
		$forma_pago =$_POST["forma_pago"];
		$fecha_emision =$_POST["fecha_emision"];
		// Fecha Registro, Pendiente TimeStamp
		$neto=$_POST["neto"];
		$excento =$_POST["excento"];
		$impuesto_especifico =$_POST["impuesto_especifico"];
		$iva =$_POST["iva"];
		$total =$_POST["total"];
		$estado ="activo";
	
			$sql=<<<QUERY
		UPDATE compra_combustible
   		SET id_proveedor = '$proveedor',
       id_empresa = '$empresa',
       tipo_documento = '$tipo_documento',
       numero_documento = '$numero_documento',
       glosa = '$glosa',
       forma_pago = '$forma_pago',
       fecha_emision = '$fecha_emision',
       neto = '$neto',
       excento = '$excento',
       impuesto_especifico = '$impuesto_especifico',
       iva = '$iva',
       total = '$total',
       estado = '$estado'
 WHERE           
	id_compra_combustible = '$id_compra_combustible'
	
;
		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Combustibles :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Combustibles :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_PRODUCTOS['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Combustibles :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
    	$id_compra_combustible=$_POST["id_compra_combustible"];

		$delete=<<<QUERY
		UPDATE
		compra_combustible SET
		estado =  'inactivo'
		WHERE
		compra_combustible.id_compra_combustible ='$id_compra_combustible';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Eliminar Combustible :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Eliminar Combustible :: Facturada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
    else if($_GET["action"] == "proveedor")
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
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
        
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Lista Proveedores :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Lista Proveedores :: cargar :: SQLERROR -> $msgerror -> $sqlpro";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;
        
        print json_encode($result);
        
	}
    else if($_GET["action"] == "empresa")
	{
		$sqlcat=<<<QUERY
        
        SELECT 
        IDEmpresa, 
        RUT, 
        RazonSocial
		FROM empresa	
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlcat,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["RazonSocial"],"Value"=>$row["IDEmpresa"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Empresa :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Empresa :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
    else if($_GET["action"] == "forma_pago")
	{
		$sqlnom=<<<QUERY
        
        SELECT formapago.IdFormaPago, 
	formapago.Nombre
	FROM formapago
	where IdFormaPago in(3,13,14)
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlnom,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Nombre"],"Value"=>$row["IdFormaPago"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = " Lista Almacen :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = " Lista Bodega :: cargar :: SQLERROR -> $msgerror -> $sqlnom";};

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
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Unidad Medida :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Unidad Medida :: cargar :: SQLERROR -> $msgerror -> $sqlun";};

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
