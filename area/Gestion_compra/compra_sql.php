<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");


class cargar_compra
{
	//traer los prouctos de la bd
	public function traer_datos($id)
	{
		$salida=array();
		$query="SELECT * FROM product WHERE CodeBar='$id'";
		$res=mysql_query($query,conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
    //insertar eboleta
    public function insertar_ecompra($contador,$fecha_creacion,$id_empresa,$id_proveedor,$total,$iva,$neto,$folio2)
    {
        $query=<<<QUERY
			INSERT INTO ecompra(
				ecompra.id_ecompra,
				ecompra.folio_compra,
				ecompra.id_empresa,
				ecompra.id_provedores,
				ecompra.fecha_ingreso,
				ecompra.neto,
				ecompra.iva,
				ecompra.total,
                ecompra.folio_factura)
				VALUES(NULL,"$contador","$id_empresa","$id_proveedor","$fecha_creacion","$neto","$iva","$total","$folio2");
QUERY;

		//return $query;
		//die();

        $res=mysql_query($query,Conectar::con());
		$ID = mysql_query("SELECT id_ecompra FROM ecompra WHERE id_ecompra = LAST_INSERT_ID()",conectar::con());
        $row = mysql_fetch_array($ID);
        return $row;
    }
	//insertar ecompra
	public function insertar_dcompra($id_compra,$posicion,$codigo,$descripcion,$cantidad,$id_almacen,$precio_compra,$precio_venta)
	{
		$query2=<<<QUERY
						INSERT INTO dcompra(
						dcompra.id_ecompra,
						dcompra.id_compra,
						dcompra.posicion,
						dcompra.codigo,
						dcompra.descripcion,
						dcompra.cantidad,
						dcompra.id_almacen,
						dcompra.precio_compra,
						dcompra.precio_venta)
						VALUES(NULL,"$id_compra","$posicion","$codigo","$descripcion","$cantidad","$id_almacen","$precio_compra","$precio_venta");
QUERY;
			//return $query2;
			//die();

			$res=mysql_query($query2,Conectar::con());
	}
	
	//disminuir el stock 
	public function Stock($id,$resta,$precio_venta,$precio_compra,$IDCellar)
	{
		$query="UPDATE product SET  UnitsInStock =  '$resta', UnitPrice = '$precio_venta', PurchasePrice = '$precio_compra', IDCellar = '$IDCellar'   WHERE  product.IDProduct ='$id'";
		$res=mysql_query($query,Conectar::con());
	}
    	public function ObtieneCompras()
				{
				$Factura="";
				$query= "select * from ecompra";
				$resul=mysql_query($query,conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$Factura=$row["folio_compra"];
				}
				if(!$Factura)
				{
					$Factura="10000001";
				}
				else
				{
					$Factura= $Factura + 1;
				}
				return $Factura;
				
				}
                
}
if($_GET["action"] == "proveedores")
	{
		$sqlpro=<<<QUERY
        
        SELECT
        suppliers.Suppliers,
        suppliers.IDsuppliers
        FROM
        suppliers
QUERY;
        
		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlpro,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Suppliers"],"Value"=>$row["IDsuppliers"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
        
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "proveedores :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "proveedores :: cargar :: SQLERROR -> $msgerror -> $sqlpro";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;
        
        print json_encode($result);
        
	}

?>