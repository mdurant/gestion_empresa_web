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
	public function insertar_eboleta($contador,$folio_boleta,$fecha_compra,$fecha_ingreso,$id_empresa, $id_proveedor,
									 $estado,$total,$iva,$neto,$estadocontable)
	{
		
		$query="INSERT INTO eboleta (
				id_boleta,
				contador,
				folio_boleta,
				fecha_compra,
				fecha_ingreso,
				id_empresa,
				id_proveedor,
				estado,
				total,
				iva,
				neto,
				estadocontable)
				VALUES (
                    NULL,'$contador',  '$folio_boleta',  '$fecha_compra', NOW(),'$id_empresa',
					'$id_proveedor', 'activo','$total','$iva', '$neto', 'PENDIENTE PAGO')";
					
		$res=mysql_query($query,conectar::con());
		
		//echo $query;
		//die();
		
        $ID = mysql_query("SELECT id_boleta FROM eboleta WHERE id_boleta = LAST_INSERT_ID()",conectar::con());
        
		$row = mysql_fetch_array($ID);
		
        return $row;

		
		//Conectar::desconectar();
	}
	//insertar dcotizacion ese era el problea es que en la posiion 1 de los parametros envia null
	public function insertar_dboleta($id_eboleta, $posicion,$codigo, $descripcion, $cantidad, $descuento, $almacen,
									 $neto_detalle, $iva_detalle, $total_detalle, $estado)
	{
		$query="INSERT INTO dboleta (
				id_dboleta,
				id_eboleta,
				posicion,
				codigo,
				descripcion,
				cantidad,
				descuento,
				almacen,
				neto_detalle,
				iva_detalle,
				total_detalle,
				estado)
			VALUES
				(
				NULL ,'$id_eboleta','$posicion','$codigo','$descripcion','$cantidad','$descuento','$almacen',
				'$neto_detalle','$iva_detalle','$total_detalle','pendiente')";
				//die ($query);

			$res=mysql_query($query,conectar::con());
			
			//echo $query;
			//die();
		
			
	
	}
	
		//traer el ultimo dato de Boleta
		public function ObtieneCompraBoleta()
				{
				$Compra="";
				$query= "select * from eboleta";
				$resul=mysql_query($query,conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$Compra=$row["contador"];
				}
				if(!$Compra)
				{
					$Compra="20000001";
				}
				else
				{
					$Compra= $Compra + 1;
				}
				return $Compra;
				
				}
	//aumentar el stock 
	public function Stock($id,$suma)
	{
		$query="UPDATE product SET  UnitsInStock =  '$suma' WHERE  product.IDProduct ='$id'";
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