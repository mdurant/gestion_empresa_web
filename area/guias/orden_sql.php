<?php
require_once("../../conexion/conexion.php");


class cargar_guia
{
	public $salida;

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
    
public function insertar_eguia($contador,$folio,$proyecto,$cliente,$forma_pago,$neto,$iva,$impuesto,$total,$fecha_creacion,$fecha_facturacion,$user,$estado,$empresa,$motivo,$glosa,$estado_contable,$rut_chofer,$nombre_chofer,$patente,$autoriza)
    {
    $query="INSERT INTO eguiadespacho (
	IdEGuiaDespacho,
	Numero,
	Folio,
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
	(
		NULL,
		'$contador',
		'$folio',
		'$proyecto',
		'$cliente',
		'$forma_pago',
		'$neto',
		'$iva',
		'$impuesto',
		'$total',
		'$fecha_creacion',
		'$fecha_facturacion',
		'$user',
		'$estado',
		'$empresa',
		'$motivo',
		'$glosa',
		'$estado_contable',
		'$rut_chofer',
		'$nombre_chofer',
		'$patente',
		'$autoriza'
	)";

//echo json_encode($query);
echo $query;

        $res=mysql_query($query,Conectar::con());
		
		//echo $query;
		$ID = mysql_query("SELECT IdEGuiaDespacho FROM eguiadespacho WHERE IdEGuiaDespacho = LAST_INSERT_ID()",conectar::con());
        $row = mysql_fetch_array($ID);
	
        return $row;
    }
    
public function insertar_dorden($id_orden,$posicion,$codigo,$descripcion,$cantidad,$id_almacen,$valor,$sub_total)
	{
		$query2="INSERT INTO dorden(
			    dorden.id_dorden,
			    dorden.id_orden,
			    dorden.posicion,
			    dorden.Codigo,
			    dorden.descripcion,
			    dorden.cantidad,
			    dorden.id_almacen,
				dorden.valor,
				dorden.sub_total)
			    VALUES(NULL,"$id_orden","$posicion","$codigo","$descripcion","$cantidad","$id_almacen","$valor","$sub_total")";
			$res=mysql_query($query2,Conectar::con());
	}
	
	//disminuir el stock 
	/*public function Stock($id,$resta,$precio_venta,$precio_compra)
	{
		$query="UPDATE product SET  UnitsInStock =  '$resta', UnitPrice = '$precio_venta', PurchasePrice = '$precio_compra'   WHERE  product.IDProduct ='$id'";
		$res=mysql_query($query,Conectar::con());
	}*/
	
}

?>