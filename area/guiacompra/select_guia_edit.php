<?php
require_once("../../conexion/conexion.php");
class funciones
{
 
 public function trae_guia($id)
 {
 	$salida=array();
 	$ides = $id;
 	$query=<<<QUERY

 		SELECT
			eguiadespacho.IdEGuiaDespacho,
			eguiadespacho.Numero,
			eguiadespacho.Folio,
			eguiadespacho.Referencia,
			eguiadespacho.IdCliente,
			eguiadespacho.IdFormaPago,
			eguiadespacho.Neto,
			eguiadespacho.Iva,
			eguiadespacho.Impuesto,
			eguiadespacho.Total,
			eguiadespacho.FechaCreacion,
			eguiadespacho.FechaFacturacion,
			eguiadespacho.`User`,
			eguiadespacho.Estado,
			eguiadespacho.IDEmpresa,
			eguiadespacho.IDMotivo,
			eguiadespacho.glosa,
			eguiadespacho.estadocontable,
			eguiadespacho.rut_chofer,
			eguiadespacho.nom_chofer,
			eguiadespacho.patente,
			eguiadespacho.autoriza
		FROM
			eguiadespacho
		WHERE
			IdEGuiaDespacho = $ides;


QUERY;

		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		return $salida;
 }
 public function proveedores()
	{
		$salida=array();
		$query="SELECT * FROM
		suppliers
		where
		Estado = 'activo'
		order by Suppliers asc";
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
 public function plantilla($id)
 	{
 		$salida=array();
 		$query="SELECT * from eplantillaot where id_plantillaot ='$id'";
 		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		return $salida;
 	}
	public function dplantilla($id)
 	{
 		$salida=array();
 		$query="SELECT * from dplantillaot where id_plantillaot ='$id'";
 		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		return $salida;
 	}
public function trabajadores(){

	$salida=array();
	$query="SELECT trabajador.id_trabajador, concat(nombres, ' ' ,apellidop, ' ', apellidom) as datos_trabajador
FROM trabajador";
	$res=mysql_query($query,Conectar::con());
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
	$res=mysql_query($query,Conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}

public function proyectos()
{
	$salida=array();
	$query="SELECT proyectos.id_proyecto, 
	proyectos.nombre_proyecto, 
	proyectos.fecha_inicio, 
	proyectos.fecha_compromiso, 
	proyectos.id_cliente, 
	proyectos.Estado
	FROM proyectos
	where proyectos.Estado = 'activo'";
	$res=mysql_query($query,Conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}
// Quien autoriza
public function quien_autoriza()
{
    $salida=array();
    $query="SELECT trabajador.id_trabajador,
UCASE(concat(nombres, ' ', apellidop) )as datos_trabajador
FROM trabajador";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}
    //

public function obtieneguia()
				{
				$guia="";
				$query= "select * from eguiadespacho";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$guia=$row["Numero"];
				}
				if(!$guia)
				{
					$guia="70000001";
				}
				else
				{
					$guia= $guia + 1;
				}
				return $guia;
				
				}
    public function code_autocomplete()
		{
			$salida=array();
			$query="SELECT * FROM product";
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row["CodeBar"];
			}
			return $salida;

		}

	public function motivoguia()
{
    $salida=array();
    $query="SELECT motivo_guia.IDMotivo,
    motivo_guia.nombre_motivo,
    motivo_guia.Estado
    FROM motivo_guia
    WHERE Estado='activo'";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}
	public function almacen() // Se modifica query para apuntar s—lo a la 0100/Central - Mauricio
	{
		$salida=array();
		$query="SELECT
	       almacen.IdAlmacen,
	       almacen.Descripcion,
	       almacen.Estado,
	       almacen.Nombre
	       FROM
	       almacen
	       where 
	       Nombre <='0100'";
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
	
	
	public function eguiad($id)
		{
			$salida=array();
			$query=<<<QUERY
			select * from eguiadespacho where IdEGuiaDespacho="$id"
QUERY;
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row;
			}
			return $salida;
			
		}
	
	public function dguiad($id)
		{
			$salida=array();
			$query=<<<QUERY
			select * from dguiadespacho where IdEGuiaDespacho="$id"
QUERY;
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row;
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
			eguiacompra.ideguiacompra,
			eguiacompra.numero,
			eguiacompra.id_proveedor,
			eguiacompra.orden_compra,
			eguiacompra.factura_numero,
			eguiacompra.neto,
			eguiacompra.iva,
			eguiacompra.impuesto,
			eguiacompra.total,
			eguiacompra.fecha_emision,
			eguiacompra.fecha_ingreso,
			eguiacompra.usuario,
			eguiacompra.id_empresa,
			eguiacompra.glosa,
			eguiacompra.estado_contable,
			eguiacompra.estado,
			eguiacompra.id_motivo,
			eguiacompra.Folio
		FROM
			eguiacompra
		WHERE
			ideguiacompra = $ides;


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
			dguiacompra.posicion,
			dguiacompra.codigo,
			dguiacompra.id_dguia_compra,
			dguiacompra.id_eguia_compra,
			dguiacompra.descripcion,
			dguiacompra.cantidad,
			dguiacompra.valor_compra,
			dguiacompra.neto_detalle
		FROM
			dguiacompra
		WHERE
			id_eguia_compra = $ides;



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


	 	
	    $id_proveedor     = $_POST["id_proveedor"]; 
		$orden_compra     = $_POST["orden_compra"]; 
		$factura_numero   = $_POST["factura_numero"];
		$Neto             = $_POST["neto"]; 
		$Iva              = $_POST["iva"];
		$Total            = $_POST["total"];
		// $fecha_emision    = $_POST["fecha_emision"];
		$usuario          = $_POST["usuario"];
		$id_empresa       = $_POST["id_empresa"];
		$glosa            = $_POST["glosa"];
		$id_motivo        = $_POST["id_motivo"];
		$Folio            = $_POST["Folio"];
		$fecha 		 	  = date_create($_POST["fecha_emision"]);
	   	$fecha2       	  = date_format($fecha, 'Y-m-d H:i:s');
       

       

      



	 	$query 	=<<<QUERY

		 		UPDATE 
		 			 eguiacompra
				SET 
					 id_proveedor 	= '$id_proveedor',
					 orden_compra 	= '$orden_compra',
					 factura_numero = '$factura_numero',
					 neto 			= '$Neto',
					 iva 			= '$Iva',
					 total 			= '$Total',
					 fecha_emision 	= '$fecha2',
					 usuario		= '$usuario',
					 id_empresa 	= '$id_empresa',
					 glosa 			= '$glosa',
					 id_motivo 		= '$id_motivo',
					 Folio 			= '$Folio'
				WHERE
					 ideguiacompra = '$ides';


QUERY;

		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}

	elseif ($_GET["action"]=="insertarDatos")
	{
		$salida	=array();
	 	$ides 	= $_GET["id"];


	 	//Variables rescatadas del POST

	   		
			$Posicion 			= $_POST["posicion"];
			$Codigo 			= $_POST["codigo"];
			$Descripcion 		= $_POST["descripcion"];
			$Cantidad 			= $_POST["cantidad"]; 
			$Descuento 			= $_POST["descuento"];
			$Almacen 			= $_POST["almacen"];
			$Neto 				= $_POST["Neto"];
			$Iva 				= $_POST["Iva"];
			$MontoImpuesto 		= "19";
			$TipoImpuesto 		= "IVA 19%"; 
			$Total 				= $_POST["Total"];
			$IDEmpresa 			= 1;
			$valor_compra		= $_POST["valor_compra"];
			$id_empresa			= $_POST["id_empresa"];



	 	$query 	=<<<QUERY

		 		INSERT INTO dguiacompra (
					
					id_eguia_compra,
					posicion,
					codigo,
					descripcion,
					cantidad,
					valor_compra,
					descuento,
					almacen,
					neto_detalle,
					iva_detalle,
					tipo_impuesto,
					total_detalle,
					IDEmpresa
				)
				VALUES
					(
						'$ides',
						'$Posicion',
						'$Codigo',
						'$Descripcion',
						'$Cantidad',
						'$valor_compra',
						'$Descuento',
						'$Almacen',
						'$Neto',
						'$Iva',
						'$TipoImpuesto',
						'$Total',
						'$id_empresa'
				)

QUERY;


		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}elseif ($_GET["action"]=="editarDatos2")
	{
		$salida	=array();
	 	$ides 	= $_GET["id"];


	 	//Variables rescatadas del POST

	   		
			
			$Posicion 			= $_POST["posicion"];
			$Codigo 			= $_POST["codigo"];
			$Descripcion 		= $_POST["descripcion"];
			$Cantidad 			= $_POST["cantidad"]; 
			$Descuento 			= $_POST["descuento"];
			$Almacen 			= $_POST["almacen"];
			$Neto 				= $_POST["Neto"];
			$Iva 				= $_POST["Iva"];
			$MontoImpuesto 		= "19";
			$TipoImpuesto 		= "IVA 19%"; 
			$Total 				= $_POST["Total"];
			$IDEmpresa 			= 1;
			$valor_compra		= $_POST["valor_compra"];
			$id_empresa			= $_POST["id_empresa"];



	 	$query 	=<<<QUERY

 			UPDATE `dguiacompra`
			SET `posicion` = '$Posicion',
			 `codigo` = '$Codigo',
			 `descripcion` = '$Descripcion',
			 `cantidad` = '$Cantidad',
			 `valor_compra` = '$valor_compra',
			 `neto_detalle` = '$Neto',
			 `iva_detalle` = '$Iva',
			 `total_detalle` = '$Total'
			WHERE
				(`id_dguia_compra` = '$ides')


QUERY;

		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}elseif ($_GET["action"]=="eliminarDatos2")
	{
		$salida	=array();
	 	$ides 	= $_GET["id"];





	 	$query 	=<<<QUERY

 			DELETE
			FROM
				dguiacompra
			WHERE
				(`id_dguia_compra` = '$ides')


QUERY;

		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}




	//cierre del if get
}

?>