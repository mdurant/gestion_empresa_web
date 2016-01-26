<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");

$usuario=$_SESSION['SESS_USER_ID'];

class cargar_compra
{
	//traer los prouctos de la bd
	public function traer_datos($id)
	{
		$salida=array();
		$query="SELECT
				product.ProductName,
				product.IDProduct,
				almacen.Descripcion,
				almacen.Nombre
				FROM
				product
				left outer JOIN almacen ON 
				almacen.IdAlmacen = product.IDCellar
				WHERE CodeBar = '$id'";
		//die ($query);
		$res=mysql_query($query,conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
	//insertar los datos a la tbl efactura (12 campos)
	public function insertar_ecompra($contador,$id_empresa,$id_proveedores,$forma_pago,$guia_despacho,$orden_compra, $glosa,$fecha_ingreso,
									 $fecha_registro,$neto,$iva,$impuesto,$total,$folio_factura,$estado_contable)
	{
		
		$query="INSERT INTO ecompra (
				id_ecompra,
				contador,
				id_empresa,
				id_provedores,
				forma_pago,
				guia_despacho,
				orden_compra,
				glosa,
				fecha_ingreso,
				fecha_registro,
				neto,
				iva,
				impuesto,
				total,
				folio_factura,
				estadocontable)
				VALUES (
                    NULL,'$contador',  '$id_empresa',  '$id_proveedores', '$forma_pago','$guia_despacho','$orden_compra', '$glosa',
					'$fecha_ingreso',  NOW(),'$neto','$iva', '$impuesto', '$total', '$folio_factura','pendiente')";
					
		$res=mysql_query($query,conectar::con());

		 //echo $query;
		
        $ID = mysql_query("SELECT id_ecompra FROM ecompra WHERE id_ecompra = LAST_INSERT_ID()",conectar::con());
        
		$row = mysql_fetch_array($ID);
		
        return $row;

		
		//Conectar::desconectar();
	}
	//insertar dcotizacion ese era el problea es que en la posiion 1 de los parametros envia null
	public function insertar_dcompra($id_compra, $posicion, $codigo, $descripcion, $cantidad, $id_almacen, $precio_compra,
									 $precio_venta, $descuento, $neto_detalle, $iva_detalle, $impuesto_detalle, $tipo_impuesto,$total_detalle)
	{
		$query="INSERT INTO dcompra (
				id_dcompra,
				id_compra,
				posicion,
				codigo,
				descripcion,
				cantidad,
				almacen,
				precio_compra,
				precio_venta,
				descuento,
				neto_detalle,
				iva_detalle,
				impuesto_detalle,
				tipo_impuesto,
				total_detalle 
				)
			VALUES
				(
				NULL ,'$id_compra','$posicion','$codigo','$descripcion','$cantidad','$id_almacen','$precio_compra',
				'$precio_venta','$descuento','$neto_detalle','$iva_detalle','$impuesto_detalle','$tipo_impuesto','$total_detalle')";
				//die ($query);

			$res=mysql_query($query,conectar::con());
			
			// echo $query;
			
	
	}
	
		//traer el ultimo dato de factura
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
	//aumentar el stock 
	public function Stock($id,$suma,$precio_venta,$precio_compra)
	{
		$query3="UPDATE product SET  UnitsInStock = '$suma', UnitPrice = '$precio_venta', PurchasePrice = '$precio_compra'   
		WHERE  product.IDProduct ='$id'";
		$res=mysql_query($query3,Conectar::con());

		echo $query3;
	}
	//insertar a tabla pagos segun tipo
	// Insertar Documento Compra en Compromiso Pago Proveedores
    public function insertar_pago($id_compra,$monto_cuota,$monto_final,$tipo_compromiso,
                            $fecha_compromiso,$fecha_pago,$id_provedor,$id_usuario)
        {
            $query = "INSERT INTO compromiso_pago_proveedores (
        id_compromiso_proveedores,
        id_compra,
        numero_cuota,
        monto_cuota,
        monto_abono,
        monto_final,
        tipo_compromiso,
        estado,
        fecha_compromiso,
        fecha_pago,
        id_proveedor,
        id_usuario
    )
    VALUES
        (
            NULL,
            '$id_compra',
            '1',
            '$monto_cuota',
            '0',
            '$monto_final',
            '$tipo_compromiso',
            'Por Cancelar',
            '$fecha_compromiso',
            '$fecha_pago',
            '$id_proveedor',
            '$id_usuario'
        )";

        $res=mysql_query($query,conectar::con());
       //  echo $query;
	   $ID = mysql_query("SELECT id_compromiso_proveedores FROM compromiso_pago_proveedores WHERE id_compromiso_proveedores = LAST_INSERT_ID()",conectar::con());
        
		$row = mysql_fetch_array($ID);
		
        return $row;

    }
	// Funcion para el detalle de gestión de pago !
	public function insetar_dpago($id_pago_proveedores)
	{
	$query = "INSERT INTO dpago_proveedores (
	id_det_pago_proveedores,
	id_pago_proveedores,
	documento,
	plaza,
	titular,
	id_banco,
	fecha_pago,
	id_usuario
)
VALUES
	(
		NULL,
		'$id_pago_proveedores',
		'0',
		'0',
		'0',
		'0',
		'NOW()',
		'NULL'
	)";
$res = mysql_query($query,conectar::con());

//echo $query;
		}

}

?>