<?php
//require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");
class select
{
public function proveedores()
	{
		$salida=array();
		$query="SELECT suppliers.IDsuppliers, 
			suppliers.RUT, 
			suppliers.Suppliers
			FROM suppliers
			WHERE Estado = 'activo'
			order by Suppliers asc";
		$res=mysql_query($query,conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
		$salida[]=$row;
		}
		return $salida;
	}
public function empresas()
{
	$salida=array();
	$query="SELECT
			empresa.IDEmpresa,
			empresa.RazonSocial
			FROM
			empresa";
	$res=mysql_query($query,conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}
public function forma_pago()
{
	$salida=array();
	$query="SELECT
			formapago.IdFormaPago,
			formapago.Nombre
			FROM
			formapago
			where IdFormaPago = 3 or
			IdFormaPago = 13 or IdFormaPago = 14";
	$res=mysql_query($query,conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}
public function ObtieneCompra()
		{
		$Compra="";
		$query= "select * from ecompra";
		$resul=mysql_query($query,conectar::con());
		while($row=mysql_fetch_assoc($resul))
		{
			$Compra=$row["contador"];
		}
		if(!$Compra)
		{
			$Compra="10000001";
		}
		else
		{
			$Compra= $Compra + 1;
		}
		return $Compra;
		
		}
public function code_autocomplete()
{
	$salida=array();
	$query="SELECT CodeBar FROM product";
	$res=mysql_query($query,conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row["CodeBar"];
	}
	return $salida;

}
}
if(isset($_GET["action"]))
{
	if($_GET["action"] == "clientes")
	{
		$sqlcat=<<<QUERY
        
        SELECT
        customers.IDCliente,
        customers.Cliente
        FROM
        customers
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlcat,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Cliente"],"Value"=>$row["IDCliente"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "CategoryProduct :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "CategoryProduct :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
	elseif ($_GET["action"]=="traerDatos")
	{
		$salida=array();
	 	$ides = $_GET["id"];
	 	$query=<<<QUERY
		SELECT
			ecompra.id_ecompra,
			ecompra.contador,
			ecompra.id_empresa,
			ecompra.id_provedores,
			ecompra.forma_pago,
			ecompra.guia_despacho,
			ecompra.orden_compra,
			ecompra.glosa,
			ecompra.fecha_ingreso,
			ecompra.fecha_registro,
			ecompra.neto,
			ecompra.iva,
			ecompra.impuesto,
			ecompra.total,
			ecompra.folio_factura,
			ecompra.estadocontable,
			ecompra.estado
		FROM
			ecompra

		WHERE
			id_ecompra = $ides;


QUERY;

		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		echo json_encode($salida);
	}


	elseif ($_GET["action"]=="traerDatos2")
	{
		$salida=array();
	 	$ides = $_GET["id"];
	 	$query=<<<QUERY

 		SELECT
			dcompra.id_dcompra,
			dcompra.id_compra,
			dcompra.posicion,
			dcompra.codigo,
			dcompra.descripcion,
			dcompra.cantidad,
			dcompra.almacen,
			dcompra.precio_compra,
			dcompra.precio_venta,
			dcompra.descuento,
			dcompra.neto_detalle,
			dcompra.iva_detalle,
			dcompra.impuesto_detalle,
			dcompra.tipo_impuesto,
			dcompra.total_detalle,
			product.IDCellar,
			product.UnitsInStock
		FROM
			dcompra
			INNER JOIN product ON dcompra.codigo = product.CodeBar
		WHERE
			id_compra = $ides;



QUERY;

		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		echo json_encode($salida);
	}
	elseif ($_GET["action"]=="editarDatos")
	{
		$salida	=array();
	 	$ides 	= $_GET["id"];


	 	//Variables rescatadas del POST

	   $contador        = $_POST["contador"];
       $folio_factura   = $_POST["folio_factura"];
       $facturacion    = $_POST["facturacion"];
       $sproveedor        = $_POST["sproveedor"];
       $ordencompra   = $_POST["ordencompra"];           
       $guiadespacho   = $_POST["guiadespacho"];   
       $sempresa      = $_POST["sempresa"];
       $spago     = $_POST["spago"];
       $glosa      = $_POST["glosa"];
       $neto   = $_POST["Neto"];
       $iva    = $_POST["Iva"];
       $total  = $_POST["Total"]; 
       $fecha 		 = date_create($_POST["facturacion"]);
	   $fecha2       = date_format($fecha, 'Y-m-d H:i:s');
       

       

      



	 	$query 	=<<<QUERY

		 		UPDATE
		 		 `ecompra`
				SET 
				 `id_empresa` = '$sempresa',
				 `id_provedores` = '$sproveedor',
				 `forma_pago` = '$spago',
				 `guia_despacho` = '$guiadespacho',
				 `orden_compra` = '$ordencompra',
				 `glosa` = '$glosa',
				 `fecha_ingreso` = '$fecha2',
				 `fecha_registro` = NOW(),
				 `neto` = '$Neto',
				 `iva` = '$Iva',
				 `impuesto` = '19',
				 `total` = '$Total',
				 `folio_factura` = '$folio_factura'
				WHERE
					(`id_ecompra` = '$ides')



QUERY;

		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}

	elseif ($_GET["action"]=="insertarDatos")
	{
		$salida	=array();
	 	$ides 	= $_GET["id"];


	 	//Variables rescatadas del POST

	   		
			$Posicion 			= $_POST["Posicion"];
			$Codigo 			= $_POST["Codigo"];
			$Descripcion 		= $_POST["Descripcion"];
			$Cantidad 			= $_POST["Cantidad"]; 
			$Descuento 			= $_POST["Descuento"];
			$Bodega 			= $_POST["Bodega"];
			$Neto 				= $_POST["Neto"];
			$Iva 				= $_POST["Iva"];
			$Precio 			= $_POST["Precio"];
			$MontoImpuesto 		= "19";
			$TipoImpuesto 		= "IVA 19%"; 
			$Total 				= $_POST["Total"];
			$IDEmpresa 			= 1;



	 	$query 	=<<<QUERY

	 	INSERT INTO `dcompra` (
			`id_compra`,
			`posicion`,
			`codigo`,
			`descripcion`,
			`cantidad`,
			`almacen`,
			`precio_compra`,
			`precio_venta`,
			`descuento`,
			`neto_detalle`,
			`iva_detalle`,
			`impuesto_detalle`,
			`tipo_impuesto`,
			`total_detalle`
		)
		VALUES
			(
				'$ides',
				'$Posicion',
				'$Codigo',
				'$Descripcion',
				'$Cantidad',
				'$Bodega',
				'$Precio',
				'0',
				'$Descuento',
				'$Neto',
				'$Iva',
				'$MontoImpuesto',
				'$TipoImpuesto',
				'$Total'
			)

 		


QUERY;

		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}elseif ($_GET["action"]=="editarDatos2")
	{
		$salida	=array();
	 	$ides 	= $_GET["id"];


	 	//Variables rescatadas del POST

	   		
			$Posicion 			= $_POST["Posicion"];
			$Codigo 			= $_POST["Codigo"];
			$Descripcion 		= $_POST["Descripcion"];
			$Cantidad 			= $_POST["Cantidad"]; 
			$Descuento 			= $_POST["Descuento"];
			$Bodega 			= $_POST["Bodega"];
			$Neto 				= $_POST["Neto"];
			$Iva 				= $_POST["Iva"];
			$Precio 			= $_POST["Precio"];
			$MontoImpuesto 		= "19";
			$TipoImpuesto 		= "IVA 19%"; 
			$Total 				= $_POST["Total"];
			$IDEmpresa 			= 1;




	 	$query 	=<<<QUERY

 			UPDATE `dcompra`
			SET 
			`posicion` = '$Posicion',
			 `codigo` = '$Codigo',
			 `descripcion` = '$Descripcion',
			 `cantidad` = '$Cantidad',
			 `almacen` = '$Bodega',
			 `precio_compra` = '$Precio',
			 `precio_venta` = '0',
			 `descuento` = '$Descuento',
			 `neto_detalle` = '$Neto',
			 `iva_detalle` = '$Iva',
			 `impuesto_detalle` = '$MontoImpuesto',
			 `tipo_impuesto` = '$TipoImpuesto',
			 `total_detalle` = '$Total'
			WHERE
				(`id_dcompra` = '$ides')

QUERY;

		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}elseif ($_GET["action"]=="eliminarDatos2")
	{
		$salida	=array();
	 	$ides 	= $_GET["id"];





	 	$query 	=<<<QUERY

 			DELETE FROM `dcompra` WHERE (`id_dcompra`='$ides')


QUERY;

		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}




	//cierre del if get
}

?>