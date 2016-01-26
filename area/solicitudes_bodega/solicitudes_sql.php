<?php
require_once("../../conexion/conexion.php");


class cargar_solicitud
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
    //insertar esolicitudes
    public function insertar_esolicitud($fecha_sol,$id_jefe,$id_operario,$id_proyecto,$orden_trabajo,$contador,$estado,$glosa)
    {
        $query=<<<QUERY
			INSERT INTO esolicitud (
	id_esolicitud,
	fecha_sol,
	id_jefe,
	id_operario,
	id_proyecto,
	orden_trabajo,
	contador,
	estado,
    glosa
)
VALUES
	(
		NULL,
		'$fecha_sol',
		'$id_jefe',
		'$id_operario',
		'$id_proyecto',
		'$orden_trabajo',
		'$contador',
		'$estado',
        '$glosa'
	);
QUERY;

//echo json_encode($query);


        $res=mysql_query($query,Conectar::con());
		// Mostrar Registros Browser
		//echo $query;
        
		$ID = mysql_query("SELECT id_esolicitud FROM esolicitud WHERE id_esolicitud = LAST_INSERT_ID()",conectar::con());
        $row = mysql_fetch_array($ID);
	
        return $row;
    }
    
	public function insertar_dsolicitud($id_esolicitud,$posicion,$codigo_producto,$producto,$cantidad)
	{
		$query2=<<<QUERY
	INSERT INTO dsolicitud (
	id_dsolicitud,
	id_esolicitud,
	posicion,
	codigo_producto,
	producto,
	cantidad
)
VALUES
	(
		NULL,
		'$id_esolicitud',
		'$posicion',
		'$codigo_producto',
		'$producto',
		'$cantidad'
	)
QUERY;
			$res=mysql_query($query2,Conectar::con());
            
            // mostrar registro para ver en browser
          //  echo $query2;
	}
	
	//disminuir el stock 
	public function Stock($id,$resta,$precio_venta,$precio_compra)
	{
		$query3="UPDATE product SET  UnitsInStock =  '$resta', UnitPrice = '$precio_venta', PurchasePrice = '$precio_compra'   WHERE  product.IDProduct ='$id'";
		$res=mysql_query($query3,Conectar::con());

		//echo $query3;
	}
	
}

?>