<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");

$usuario=$_SESSION['SESS_USER_ID'];

class cargar_cotizacion
{
    public $salida;


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
    //insertar los datos a la tbl eguia (12 campos)
    public function insertar_eguia($Numero,$Folio,$Referencia,$IdCliente,$idproyecto,$Neto,$Iva,$Impuesto,$Total,$FechaFacturacion,$IDEmpresa,$motivo,$motivo,$glosa,$rut_chofer,$nom_chofer,$patente,$autoriza)
    {
        $query="INSERT INTO  eguiadespacho (
                Numero ,
                Folio ,
                Referencia ,
                IdCliente ,
                id_proyecto ,
                Neto ,
                Iva ,
                Impuesto ,
                Total ,
                FechaCreacion ,
                FechaFacturacion ,
                User ,
                Estado ,
                IDEmpresa,
                IDMotivo,
                glosa,
                estadocontable,
                rut_chofer,
                nom_chofer,
                patente,
                autoriza

                )
                VALUES (
                    '$Numero',  '$Folio',  '$Referencia',  '$IdCliente',  '$idproyecto',  '$Neto',  '$Iva',  '$Impuesto',  '$Total', NOW( ) ,  '$FechaFacturacion',   '$usuario',  'activo',  '$IDEmpresa','$motivo','$glosa','$rut_chofer','$nom_chofer','$patente','$autoriza'
                )";
        $this->salida=$query;

        $res=mysql_query($query,conectar::con());
        echo $query;

        $ID = mysql_query("SELECT IdEGuiaDespacho FROM eguiadespacho WHERE IdEGuiaDespacho = LAST_INSERT_ID()",conectar::con());
        $row = mysql_fetch_array($ID);
        return $row;
        //Conectar::desconectar();
    }
    //insertar dcotizacion
    public function insertar_dguia($IdEGuiaDespacho,$Posicion,$Codigo,$Descripcion,$Cantidad,$Descuento,$Almacen,$Neto,$Iva,$Total,$IDEmpresa)
    {
        $query2="INSERT INTO  dguiadespacho (
                IdDGuia ,
                IdEGuiaDespacho ,
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
                NULL ,  '$IdEGuiaDespacho',  '$Posicion',  '$Codigo',  '$Descripcion',  '$Cantidad',  '$Descuento',  '$Almacen',  '$Neto',  '$Iva',  '0',  '0.19',  '$Total',  '$IDEmpresa'
                )";
        //echo json_encode($query);
            $res=mysql_query($query2,conectar::con());

       // echo $query2;
    }

        //traer el ultimo dato de guia
        public function ObtieneGuia()
                {
                $Factura="";
                $query= "select * from eguiadespacho";
                $resul=mysql_query($query,conectar::con());
                while($row=mysql_fetch_assoc($resul))
                {
                    $Factura=$row["Numero"];
                }
                if(!$Factura)
                {
                    $Factura="70000001";
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
