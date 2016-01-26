<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");


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
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
    //insertar eboleta
    public function insertar_eboleta($contador,$fecha_creacion,$id_empresa,$estado,$total,$iva,$neto)
    {
        $query="INSERT INTO  eboleta (
                id_boleta ,
                contador ,
                fecha_creacion ,
                id_empresa,
                Estado,
                Total,
                Iva,
                Neto
                )
                VALUES (
						NULL ,  '$contador',  '$fecha_creacion',  '$id_empresa', '$estado','$total','$iva','$neto'
                )";
				
		
        $res=mysql_query($query,Conectar::con());
		return $res;
    }
	//insertar dcotizacion
	public function insertar_dboleta($IdEboleta,$fecha_boleta,$Posicion,$Codigo,$Descripcion,$Cantidad,$Descuento,$Almacen,$Neto,$Iva,$Total,$IDEmpresa,$Estado,$Netob,$Ivab,$Totalb)
	{
		$query="INSERT INTO  dboleta (
				Idboleta ,
				IdEboleta ,
				fecha_boleta ,
				Posicion ,
				Codigo ,
				Descripcion ,
				Cantidad ,
				Descuento ,
				Almacen ,
				Neto ,
				Iva ,
				Total ,
				IDEmpresa,
                Estado,
                Netob,
                Ivab,
                Totalb
				)
				VALUES (
				NULL ,  '$IdEboleta',  '$fecha_boleta',  '$Posicion',  '$Codigo',  '$Descripcion',  '$Cantidad',  '$Descuento',  '$Almacen',  '$Neto',  '$Iva',  '$Total',  '$IDEmpresa','$Estado','$Netob','$Ivab','$Totalb'
				)";
			$res=mysql_query($query,Conectar::con());
	}
	
		//traer el ultimo dato de factura
		public function ObtieneBoleta()
				{
				$Factura="";
				$query= "select * from dboleta";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$Factura=$row["IdEboleta"];
				}
				if(!$Factura)
				{
					$Factura="50000001";
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
		$res=mysql_query($query,Conectar::con());
	}
}

?>