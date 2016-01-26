<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");
class select
{
public function clientes()
    {
        $salida=array();
        $query="SELECT
            customers.IDCliente,
            customers.Cliente
            FROM
            customers
            where
            customers.Estado='activo'
            ";
        $res=mysql_query($query,conectar::con());
        while($row=mysql_fetch_assoc($res))
        {
        $salida[]=$row;
        }
        return $salida;
    }
public function empresas()
{
    $salida=array();
    $query="SELECT
            empresa.IDEmpresa,
            empresa.RazonSocial
            FROM
            empresa";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}

// Quien autoriza
public function quien_autoriza()
{
    $salida=array();
    $query="SELECT trabajador.id_trabajador,
UCASE(concat(nombres, ' ', apellidop) )as datos_trabajador
FROM trabajador";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}
    //
public function forma_pago()
{
    $salida=array();
    $query="SELECT
            formapago.IdFormaPago,
            formapago.Nombre
            FROM
            formapago";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}
// Motivo de la Guia de Despacho
public function motivoguia()
{
    $salida=array();
    $query="SELECT motivo_guia.IDMotivo,
    motivo_guia.nombre_motivo,
    motivo_guia.Estado
    FROM motivo_guia
    WHERE Estado='activo'";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}
    // Proyecto a Asignar
    public function proyecto()
{
    $salida=array();
    $query="SELECT proyectos.id_proyecto,
    proyectos.nombre_proyecto,
    proyectos.Estado
FROM proyectos
where Estado = 'activo'
order by id_proyecto asc";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}
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
public function code_autocomplete()
{
    $salida=array();
    $query="SELECT CodeBar FROM product";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row["CodeBar"];
    }
    return $salida;

}
}
if($_GET["action"] == "clientes")
    {
        $sqlcat=<<<QUERY

        SELECT
        customers.IDCliente,
        customers.Cliente
        FROM
        customers
QUERY;

        $msgerror="";

        try
        {

          $resultsql = mysql_query($sqlcat,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
          {
                $resoptions[]=array("DisplayText"=>$row["Cliente"],"Value"=>$row["IDCliente"]);
          }

        }
        catch(Exception $ex){    $resultsql=0; $msgerror=$ex;}

        $vRESP=$result;
        if ($resultsql)
        {     $vRESP="OK"; $vMENSAJE = "CategoryProduct :: cargar :: OK!";    }
        else
        {    $vRESP="ERROR"; $vMENSAJE = "CategoryProduct :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

        $result = array();
        $result['Result'] = $vRESP;
        $result['Message']= $vMENSAJE;
        $result['Options']= $resoptions;

        print json_encode($result);

    }
?>
