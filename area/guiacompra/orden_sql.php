<?php
require_once("../../conexion/conexion.php");


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
 
public function insertar_eguia_compra($numero,$proveedor,$orden_compra,$numero_factura,$neto,$iva,$impuesto,$total,$fecha_emision,$fecha_ingreso,$usuario,$empresa,$glosa,$estado_contable,$estado,$id_motivo,$folio)
    {
        $query=<<<QUERY
	INSERT INTO eguiacompra(
			ideguiacompra,
			numero,
			id_proveedor,
			orden_compra,
			factura_numero,
			neto,
			iva,
			impuesto,
			total,
			fecha_emision,
			fecha_ingreso,
			usuario,
			id_empresa,
			glosa,
			estado_contable,
			estado,
			id_motivo,
			folio
			)
			VALUES
			(NULL,
			"$numero",
			"$proveedor",
			"$orden_compra",
			"$numero_factura",
			"$neto",
			"$iva",
			"$impuesto",
			"$total",
			"$fecha_emision",
			"$fecha_emision",
			"$usuario",
			"$empresa",
			"$glosa",
			"$estado_contable",
			"$estado",
			"id_motivo",
			"folio"

			)
QUERY;

//echo json_encode($query);
//echo $query;

        $res=mysql_query($query,Conectar::con());
		
		//echo $query;
		$ID = mysql_query("SELECT ideguiacompra FROM eguiacompra WHERE ideguiacompra = LAST_INSERT_ID()",conectar::con());
        $row = mysql_fetch_array($ID);
	
        return $row;
    }
    
	public function insertar_dguia_compra($id_eguia_compra,$posicion,$codigo,$descripcion,$cantidad,$valor_compra,$descuento,$almacen,$neto_detalle,$iva_detalle,$tipo_impuesto,$total_detalle,$empresa)
	{
		$query2=<<<QUERY
			    INSERT INTO dguiacompra(
			   id_dguia_compra,
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
			    VALUES(NULL,
					"$id_eguia_compra",
					"$posicion",
					"$codigo",
					"$descripcion",
					"$cantidad",
					"$valor_compra",
					"$descuento",
					"$almacen",
					"$neto_detalle",
					"$iva_detalle",
					"$tipo_impuesto",
					"$total_detalle",
					"$empresa"
					)
QUERY;
			$res=mysql_query($query2,Conectar::con());
	}
	
	//aumentar el stock 
	public function Stock($id,$suma,$precio_venta,$precio_compra)
	{
		$query3="UPDATE product SET  UnitsInStock =  '$suma', UnitPrice = '$precio_venta', PurchasePrice = '$precio_compra'   
		WHERE  product.IDProduct ='$id'";
		$res=mysql_query($query3,Conectar::con());

	//	echo $query3;
	}

public function ObtieneGuiaCompra()
	{
	$folio_guia_compra="";
	$query= "select * from eguiacompra";
	$resul=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($resul))
				{
				$folio_guia_compra=$row["numero"];
				}
		if(!$folio_guia_compra)
			{
				$folio_guia_compra="60000001";
			}
		else
			{
				$folio_guia_compra= $folio_guia_compra + 1;
			}
		return $folio_guia_compra;
				
			}
}

?>