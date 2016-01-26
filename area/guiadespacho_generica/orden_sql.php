<?php
require_once("../../conexion/conexion.php");
// Clase con Funciones para Guia Despacho (venta) General y Específica asociada a Proyecto)

class cargar_orden
{
	//traer los prouctos de la bd
	public function traer_datos($id)
	{
		$salida=array();
		$query="SELECT * FROM product WHERE CodeBar='$id'";
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
	// Referencia = a Proyecto
	// FechaFacturacion = Fecha Guia
 
public function insertar_eguia_general($numero,$folio,$factura,$proyecto,$cliente,$forma_pago,$neto,$iva,$impuesto,$total,$fecha_creacion,$fecha_guia,$user,$estado,$empresa,$motivo,$glosa,$estado_contable,$rut_chofer,$nombre_chofer,$patente,$autoriza)
    {
        $query=<<<QUERY
			INSERT INTO eguiadespacho_general(
			IdEGuiaDespacho_General,
			Numero,
			Folio,
			Factura,
			Referencia,
			IdCliente,
			IdFormaPago,
			Neto,
			Iva,
			Impuesto,
			Total,
			FechaCreacion,
			FechaFacturacion,
			User,
			Estado,
			IDEmpresa,
			IDMotivo,
			glosa,
			estadocontable,
			rut_chofer,
			nom_chofer,
			patente,
			autoriza
			)
			VALUES
			(NULL,
			"$numero",
			"$folio",
			"$factura",
			"$proyecto",
			"$cliente",
			"$forma_pago",
			"$neto",
			"$iva",
			"$impuesto",
			"$total",
			"$fecha_creacion",
			"$fecha_guia",
			"$user",
			"$estado",
			"$empresa",
			"$motivo",
			"$glosa",
			"$estado_contable",
			"$rut_chofer",
			"$nombre_chofer",
			"$patente",
			"$autoriza"
			)
QUERY;

//echo json_encode($query);
//echo $query;

        $res=mysql_query($query,Conectar::con());
		
	//echo $query;
		$ID = mysql_query("SELECT IdEGuiaDespacho_General FROM eguiadespacho_general WHERE IdEGuiaDespacho_General = LAST_INSERT_ID()",conectar::con());
    $row = mysql_fetch_array($ID);
	
      return $row;
    }
    
	public function insertar_dguia_general($id_guia,$posicion,$codigo,$descripcion,$cantidad,$descuento,$almacen,$neto,$iva,$monto_impuesto,$tipo_impuesto,$total,$empresa)
	{
		$query2=<<<QUERY
			    INSERT INTO dguiadespacho_general(
			   IdDGuia_General,
				 IdEGuiaDespacho_General,
				 Posicion,
				 Codigo,
				 Descripcion,
				 Cantidad,
				 Descuento,
				 Almacen,
				 Neto,
				 Iva,
				 MontoImpuesto,
				 TipoImpuesto,
				 Total,
				 IDEmpresa
				 )
			    VALUES(NULL,
					"$id_guia",
					"$posicion",
					"$codigo",
					"$descripcion",
					"$cantidad",
					"$descuento",
					"$almacen",
					"$neto",
					"$iva",
					"$monto_impuesto",
					"$tipo_impuesto",
					"$total",
					"$empresa"
					)
QUERY;
			$res=mysql_query($query2,Conectar::con());
	}

public function ObtieneOrden()
	{
		$guia="";
		$query= "select * from eguiadespacho_general";
		$resul=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($resul))
	{
		$guia=$row["Numero"];
	}
		if(!$guia)
	{
		$guia="7100000001";
	}
	else
	{
		$guia= $guia + 1;
	}
	return $guia;
	
	}

	
	//disminuir el stock 
	public function Stock($id,$resta,$precio_venta,$precio_compra)
	{
		$query="UPDATE product SET  UnitsInStock =  '$resta', UnitPrice = '$precio_venta', PurchasePrice = '$precio_compra'   WHERE  product.IDProduct ='$id'";
		$res=mysql_query($query,Conectar::con());
	}


}


?>