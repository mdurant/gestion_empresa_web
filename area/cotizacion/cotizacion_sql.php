<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");


class cargar_cotizacion
{
	public function traer_datos($id)
	{
		$salida=array();
		$query="SELECT
				product.ProductName,
				product.UnitPrice,
				product.UnitsInStock,
				almacen.Nombre
				FROM
				product
				INNER JOIN almacen ON product.IDCellar = almacen.IdAlmacen
				WHERE CodeBar= '$id'";
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
	
	public function insertar_ecotizacion($Tipo,$Contador,$IdCliente,$IdFormaPago,$Neto,$Iva,$Impuesto,$Total,$FechaCreacion,$FechaTermino,$FechaFacturacion,$FechaCancelacion,$User,$IDEmpresa,$glosa)
	{
		$query="INSERT INTO ecotizacion (
				IdECotizacion ,
				Tipo ,
				Contador ,
				IdCliente ,
				IdFormaPago ,
				Neto ,
				Iva ,
				Impuesto ,
				Total ,
				FechaCreacion ,
				FechaTermino ,
				FechaFacturacion ,
				FechaCancelacion ,
				User ,
				Estado ,
				IDEmpresa,
				glosa
				)
				VALUES (
				NULL ,  '$Tipo',  '$Contador',  '$IdCliente',  '$IdFormaPago',  '$Neto',  '$Iva',  '$Impuesto',  '$Total', $FechaCreacion ,  '$FechaTermino',  '$FechaFacturacion',  '$FechaCancelacion',  '$User',  'activo',  '$IDEmpresa', '$glosa'
				)";
				
		
		$res=mysql_query($query,Conectar::con());
		
		$IdECotizacion=-1;
		if ($res){
			$result = mysql_query("SELECT * FROM ecotizacion WHERE IdECotizacion = LAST_INSERT_ID();");
			
			$rows = array();
			while($row = mysql_fetch_array($result)) { $rows[] = $row; }
			
			
			$IdECotizacion=$rows[0]["IdECotizacion"];
			
		}

		
		/*
		$msgerror="";
		
		try
		{  $res=mysql_query($query,Conectar::con());	} 
        catch(Exception $ex){	$res=0; $msgerror=$ex;}*/
		
		return $IdECotizacion;
		
		//Conectar::desconectar();
	}
	public function insertar_dcotizacion($IdECotizacion,$Posicion,$Codigo,$Descripcion,$Cantidad,$Descuento,$Almacen,$Neto,$Iva,$MontoImpuesto,$Total,$IDEmpresa)
	{
		$query="INSERT INTO  dcotizacion (
				IdDCotizacion ,
				IdECotizacion ,
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
				         NULL ,  '$IdECotizacion',  '$Posicion',  '$Codigo', '$Descripcion',  '$Cantidad',  '$Descuento',  '$Almacen',  '$Neto',  '$Iva',  '$MontoImpuesto', '0',  '$Total',  '$IDEmpresa'
				)";
			$res=mysql_query($query,Conectar::con());
	}
	public function ObtieneCotizacion()
				{
				$Factura="";
				$query= "select * from ecotizacion";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$Factura=$row["Contador"];
				}
				if(!$Factura)
				{
					$Factura="80000001";
				}
				else
				{
					$Factura= $Factura + 1;
				}
				return $Factura;
				
				}
	
	
}

?>