<?php
require_once("../../validatesession_json.php");
require_once("../../conexion/conexion.php");
class select
{
public function jefatura()
    {
        $salida=array();
        $query="SELECT
        UPPER(jefaturas.id_jefatura) ,
        UPPER(concat(jefaturas.nombres, ' ',jefaturas.paterno)) as jefe,
        jefaturas.email, 
        jefaturas.estado
        FROM jefaturas
        WHERE
        estado = 'activo'";
        $res=mysql_query($query,conectar::con());
        while($row=mysql_fetch_assoc($res))
        {
        $salida[]=$row;
        }
        return $salida;
    }
public function trabajador()
{
    $salida=array();
    $query="select 
        trabajador.id_trabajador,
        UPPER(CONCAT(trabajador.nombres, ' ', trabajador.apellidop)) as operario,
        trabajador.email
        from trabajador
        where
        trabajador.estado = 'activo'";
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
public function proyecto()
{
    $salida=array();
    $query="select  id_proyecto,nombre_proyecto from proyectos
where Estado = 'activo'";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}
public function obtiene_solicitud()
        {
        $Factura="";
        $query= "select * from esolicitud";
        $resul=mysql_query($query,conectar::con());
        while($row=mysql_fetch_assoc($resul))
        {
            $Factura=$row["contador"];
        }
        if(!$Factura)
        {
            $Factura="400000001";
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
