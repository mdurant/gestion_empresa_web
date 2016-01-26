<?php
require_once("../../conexion/conexion.php");


class cargar_orden
{
	//traer los prouctos de la bd
	public function traer_datos($id)
	{
		$salida=array();
		$query="SELECT * FROM servicios WHERE codigo_ss='$id'";
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
 
public function insertar_eservicios($proyecto,$numero,$usuario,$fecha_ingreso,$id_proveedor,$numero_documento,$glosa,$neto,$iva,$total,$estado)
    {
        $query=<<<QUERY
	INSERT INTO eservicios(
			id_eservicios,
			id_proyecto,
			numero,
			usuario,
			fecha_ingreso,
			id_proveedor,
			numero_documento,
			glosa,
			neto,
			iva,
			total,
			estado
			)
			VALUES
			(NULL,
			"$proyecto",
			"$numero",
			"$usuario",
			"$fecha_ingreso",
			"$id_proveedor",
			"$numero_documento",
			"$glosa",
			"$neto",
			"$iva",
			"$total",
			"$estado"
			)
QUERY;

//echo json_encode($query);
//echo $query;

        $res=mysql_query($query,Conectar::con());
		
		// echo $query;
		$ID = mysql_query("SELECT id_eservicios FROM eservicios WHERE id_eservicios = LAST_INSERT_ID()",conectar::con());
        $row = mysql_fetch_array($ID);
	
        return $row;
    }
    
	public function insertar_dservicios($id_eservicio,$posicion,$codigo,$descripcion,$cantidad,$tipo_impuesto,$valor_neto,$valor_iva,$valor_subtotal)
	{
		$query2=<<<QUERY
			    INSERT INTO dservicios(
			     id_dservicios,
				 id_eservicios,
				 posicion,
				 codigo,
				 descripcion,
				 cantidad,
				 tipo_impuesto,
				 valor_neto,
				 valor_iva,
				 valor_subtotal
				 )
			    VALUES(
			    	NULL,
					"$id_eservicio",
					"$posicion",
					"$codigo",
					"$descripcion",
					"$cantidad",
					"$tipo_impuesto",
					"$valor_neto",
					"$valor_iva",
					"$valor_subtotal"
					)
QUERY;



			$res=mysql_query($query2,Conectar::con());

			//echo $query2;
	}
	
	//disminuir el stock 
	/*public function Stock($id,$resta,$precio_venta,$precio_compra)
	{
		$query="UPDATE product SET  UnitsInStock =  '$resta', UnitPrice = '$precio_venta', PurchasePrice = '$precio_compra'   WHERE  product.IDProduct ='$id'";
		$res=mysql_query($query,Conectar::con());
	}*/
public function obtiene_servicio()
	{
	$Factura="";
	$query= "select * from eservicios";
	$resul=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($resul))
				{
				$Factura=$row["numero"];
				}
		if(!$Factura)
			{
				$Factura="110000001";
			}
		else
			{
				$Factura= $Factura + 1;
			}
		return $Factura;
				
			}
}

?>