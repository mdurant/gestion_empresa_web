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
    //insertar eboleta
    
    //Se agregan nuevos campos como "Patente" y "Vehiculo_Pieza" en las OT
    // Se agregan nuevos campos IVA, Total_Gral
    public function insertar_eorden($contador,$folio,$id_cliente,$id_empresa,$proyecto,$fecha_ingreso,$f2,$jefe,$glosa,$total,$iva,$total_gral)
    {
        $query=<<<QUERY
			INSERT INTO eorden(
			eorden.id_orden,
			eorden.contador,
			eorden.folio,
			eorden.id_cliente,
			eorden.id_empresa,
			eorden.id_proyecto,
			eorden.fecha_ingreso,
			eorden.estado,
			eorden.fecha_entrega,
			eorden.jefe_responsable,
			eorden.glosa,
			eorden.total,
			eorden.iva,
			eorden.total_gral)
			VALUES(NULL,
			"$contador",
			"$folio",
			"$id_cliente",
			"$id_empresa",
			"$proyecto",
			"$fecha_ingreso",
			"activo",
			"$f2",
			"$jefe",
			"$glosa",
			"$total",
			"$iva",
			"$total_gral")
QUERY;

//echo json_encode($query);
echo $query;

        $res=mysql_query($query,Conectar::con());
		
		//echo $query;
		$ID = mysql_query("SELECT id_orden FROM eorden WHERE id_orden = LAST_INSERT_ID()",conectar::con());
        $row = mysql_fetch_array($ID);
	
        return $row;
    }
    
	public function insertar_dorden($id_orden,$posicion,$codigo,$descripcion,$cantidad,$id_almacen,$valor,$sub_total)
	{
		$query2=<<<QUERY
			    INSERT INTO dorden(
			    dorden.id_dorden,
			    dorden.id_orden,
			    dorden.posicion,
			    dorden.Codigo,
			    dorden.descripcion,
			    dorden.cantidad,
			    dorden.id_almacen,
				dorden.valor,
				dorden.sub_total)
			    VALUES(NULL,"$id_orden","$posicion","$codigo","$descripcion","$cantidad","$id_almacen","$valor","$sub_total")
QUERY;
			$res=mysql_query($query2,Conectar::con());
	}
	
	//disminuir el stock 
	/*public function Stock($id,$resta,$precio_venta,$precio_compra)
	{
		$query="UPDATE product SET  UnitsInStock =  '$resta', UnitPrice = '$precio_venta', PurchasePrice = '$precio_compra'   WHERE  product.IDProduct ='$id'";
		$res=mysql_query($query,Conectar::con());
	}*/
	public function ObtieneOrden()
				{
				$Factura="";
				$query= "select * from eorden";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
				$Factura=$row["contador"];
				}
				if(!$Factura)
				{
				$Factura="30000001";
				}
				else
				{
				$Factura= $Factura + 1;
				}
				return $Factura;
				
				}
}

?>