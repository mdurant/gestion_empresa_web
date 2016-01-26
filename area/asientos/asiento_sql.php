<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");

$usuario=$_SESSION['SESS_USER_ID'];

class cargar_cotizacion
{
	//traer los prouctos de la bd
	public function traer_datos($id)
	{
		$salida=array();
		$query="SELECT
				product.ProductName,
				product.UnitPrice,
				product.UnitsInStock,
				product.IDProduct,
				almacen.Nombre
				FROM
				product
				INNER JOIN almacen ON product.IDCellar = almacen.IdAlmacen
				WHERE CodeBar= '$id'";
		//die ($query);
		$res=mysql_query($query,conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
	//insertar los datos a la tbl efactura (12 campos)
	public function insertar_efactura($Numero,$Folio,$Referencia,$IdCliente,$IdFormaPago,$Neto,$Iva,$Impuesto,$Total,$FechaFacturacion,$Tipo,$IDEmpresa,$glosa)
	{
		$query="INSERT INTO  efactura (
				Numero ,
				Folio ,
				Referencia ,
				IdCliente ,
				IdFormaPago ,
				Neto ,
				Iva ,
				Impuesto ,
				Total ,
				FechaCreacion ,
				FechaFacturacion ,
				Tipo ,
				User ,
				Estado ,
				IDEmpresa,
				glosa
				)
				VALUES (
                    '$Numero',  '$Folio',  '$Referencia',  '$IdCliente',  '$IdFormaPago',  '$Neto',  '$Iva',  '$Impuesto',  '$Total', NOW( ) ,  '$FechaFacturacion',  '$Tipo',  '$usuario',  'activo',  '$IDEmpresa','$glosa'
				)";
		$res=mysql_query($query,conectar::con());
		
        $ID = mysql_query("SELECT IdEFactura FROM efactura WHERE IdEFactura = LAST_INSERT_ID()",conectar::con());
        $row = mysql_fetch_array($ID);
        return $row;
		//Conectar::desconectar();
	}
	//insertar dcotizacion
	public function insertar_dfactura($IdEFactura,$Posicion,$Codigo,$Descripcion,$Cantidad,$Descuento,$Almacen,$Neto,$Iva,$Total,$IDEmpresa)
	{
		$query="INSERT INTO  dfactura (
				IdDFactura ,
				IdEFactura ,
				Posicion ,
				Codigo ,
				Descripcion ,
				Cantidad ,
				Descuento ,
				Almacen ,
				Neto ,
				Iva ,
				MontoImpuesto ,
				TipoImpuesto ,
				Total ,
				IDEmpresa
				)
				VALUES (
				NULL ,  '$IdEFactura',  '$Posicion',  '$Codigo',  '$Descripcion',  '$Cantidad',  '$Descuento',  '$Almacen',  '$Neto',  '$Iva',  '0',  '0.19',  '$Total',  '$IDEmpresa'
				)";
				//die ($query);
			$res=mysql_query($query,conectar::con());
			
	}
	
		//traer el ultimo dato de factura
		public function ObtieneFactura()
				{
				$Factura="";
				$query= "select * from efactura";
				$resul=mysql_query($query,conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$Factura=$row["Numero"];
				}
				if(!$Factura)
				{
					$Factura="90000001";
				}
				else
				{
					$Factura= $Factura + 1;
				}
				return $Factura;
				
				}
	//disminuir el stock 
	public function Stock($id,$resta)
	{
		$query="UPDATE product SET  UnitsInStock =  '$resta' WHERE  product.IDProduct ='$id'";
		$res=mysql_query($query,conectar::con());
	}
	//insertar a tabla pagos segun tipo
	public function insertar_pago($id_efactura,$ncuota,$monto_cuota,$monto_final,$tipo_compromiso,$fecha_compromiso,$fecha_pa,$ID_Cliente)
	{
		$query="INSERT INTO  gestion_documento (
				id_gestion_documento ,
				id_efactura ,
				ncuota ,
				monto_cuota ,
				monto_abono ,
				monto_final ,
				tipo_compromiso ,
				estado ,
				fecha_compromiso ,
				fecha_pa ,
				ID_Cliente
				)
				VALUES (
				NULL ,  '$id_efactura',  '$ncuota',  '$monto_cuota',  '0',  '$monto_final',  '$tipo_compromiso',  'Por Cancelar',  '$fecha_compromiso',  '$fecha_pa',  '$ID_Cliente'
				)";
		$res=mysql_query($query,conectar::con());
	}
}

?>