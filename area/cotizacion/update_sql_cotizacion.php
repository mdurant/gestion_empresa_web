<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");


class cargar_plantilla
{
    //insertar eplantilla
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
    //insertar dplantilla

    //editar plantilla detalle

    public function editar_dcotizacion($posicion,$codigo,$descripcion,$cantidad,$descuento,$id_almacen,$neto,$iva,$total,$idedcotizacion)
    {
        $query=<<<QUERY
        UPDATE dcotizacion SET
                dcotizacion.Posicion="$posicion",
                dcotizacion.Codigo="$codigo",
                dcotizacion.Descripcion="$descripcion",
                dcotizacion.Cantidad="$cantidad",
                dcotizacion.Descuento="$descuento",
                dcotizacion.Almacen="$id_almacen",
                dcotizacion.Neto="$neto",
                dcotizacion.Iva="$iva",
                dcotizacion.Total="$total"
                WHERE dcotizacion.IdDCotizacion="$idedcotizacion"
QUERY;
        $res=mysql_query($query,Conectar::con());
    }

    public function eliminar_dplantillaot($id)
    {
        $query=<<<QUERY
            DELETE FROM dplantillaot
            WHERE id_dplantillaot = '$id';
QUERY;
        $res=mysql_query($query,Conectar::con());
    }


    //valido para hacer un insert
    public function validar($id_eplantilla,$posicion)
    {
        $salida=array();
        $query=<<<QUERY
            SELECT * FROM dplantillaot WHERE id_plantillaot = '$id_eplantilla' AND posicion = '$posicion'
QUERY;
        $res=mysql_query($query,Conectar::con());
        while($row=mysql_fetch_assoc($res))
        {
            $salida[]=$res;
        }
        return $salida;
    }

    //editar eorden de trabajo
    public function editar_cotizacion($idcliente,$idformapago,$neto,$iva,$total,$empresa,$glosa,$id_cotizacion)
    {
        $query=<<<QUERY

            UPDATE ecotizacion SET
            ecotizacion.IdCliente="$idcliente",
            ecotizacion.IdFormaPago="$idformapago",
            ecotizacion.Neto="$neto",
            ecotizacion.Iva="$iva",
            ecotizacion.Total="$total",
            ecotizacion.IDEmpresa="$empresa",
            ecotizacion.glosa="$glosa"
            WHERE ecotizacion.IdECotizacion="$id_cotizacion"
QUERY;
        $res=mysql_query($query,Conectar::con());

        echo $query;
    }

    //editar dorden
    public function editar_dorden($posicion,$codigo,$descripcion,$cantidad,$id_almacen,$id_orden,$valor)
    {
        $query=<<<QUERY
            UPDATE dorden SET
            dorden.posicion='$posicion',
            dorden.Codigo='$codigo',
            dorden.descripcion='$descripcion',
            dorden.cantidad='$cantidad',
            dorden.id_almacen='$id_almacen',
            dorden.valor='$valor'
                WHERE id_dorden = '$id_orden';
QUERY;


        $res=mysql_query($query,Conectar::con());
    }
    //valido para hacer un insert
    public function validar2($id_eorden,$posicion)
    {
        $salida=array();
        $query=<<<QUERY
            SELECT
            dorden.id_dorden,
            dorden.id_orden,
            dorden.posicion,
            dorden.Codigo,
            dorden.descripcion,
            dorden.cantidad,
            dorden.id_almacen,
            dorden.valor
            FROM
            dorden
            WHERE id_orden='$id_eorden' AND posicion='$posicion'
QUERY;
        $res=mysql_query($query,Conectar::con());
        while($row=mysql_fetch_assoc($res))
        {
            $salida[]=$res;
        }
        return $salida;
    }
    //insertar ecompra
    public function insertar_dorden($id_orden,$posicion,$codigo,$descripcion,$cantidad,$id_almacen,$valor)
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
            dorden.valor)
            VALUES(NULL,'$id_orden','$posicion','$codigo','$descripcion','$cantidad','$id_almacen','$valor')
QUERY;
            $res=mysql_query($query2,Conectar::con());
    }

    public function eliminar_dorden($id_cot)
    {
        $query2=<<<QUERY
            DELETE FROM dcotizacion WHERE IdDCotizacion = '$id_cot';
QUERY;
            $res=mysql_query($query2,Conectar::con());
    }


}

?>
