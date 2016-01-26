<?php

require_once("conexion.php");

class funciones {


public function login($usuario, $password){
    $salida="";
    $query="SELECT users.IDUser, users.Username,
    users.Email, users.Name ,usuarios_perfiles.IDUsuariosPerfil,
    usuarios_perfiles.IDUsuario, usuarios_perfiles.Password
FROM users
INNER JOIN usuarios_perfiles ON users.IDUser = usuarios_perfiles.IDUsuario
WHERE users.Username =  '$usuario'
AND usuarios_perfiles.Password =  '$password'
    ";
    $res = mysql_query($query,Conectar::con());
    return $salida;
    }

public function cargaCiudades()
{
    $salida=array();
    $query="Select * from comunas";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;



}

public function cta_cte()
{
    $salida=array();
    $query="SELECT
cta_cte.id_ctacte,
cta_cte.numero_cta,
cta_cte.id_banco,
cta_cte.estado,
banco.nombre_banco
FROM
cta_cte
INNER JOIN banco ON cta_cte.id_banco = banco.id_banco";
    $res = mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
}

public function cargaProvincias(){
    $salida=array();
    $query="Select * from provincias";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }

public function cargaPais(){
    $salida=array();
    $query="Select * from pais";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }

public function cargaRegiones(){
    $salida=array();
    $query="Select * from region";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }

public function customer()
{
    $salida=array();
    $query="select * from customers";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
}

public function cargaFormaPago(){
    $salida=array();
    $query="Select * from formapago";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }
public function banco()
{
    $salida=array();
    $query="SELECT cuenta_corriente.id_cta_cte,
    concat(nombre_banco, ' - ' ,num_cuenta) AS DatoBancario,
    cuenta_corriente.ejecutivo,
    cuenta_corriente.titular_cuenta
FROM banco INNER JOIN cuenta_corriente ON banco.id_banco = cuenta_corriente.id_banco";
    $res = mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
}

public function cargaEmpresas(){
    $salida=array();
    $query="SELECT
    empresa.IDEmpresa,
    empresa.RazonSocial
    FROM
    empresa";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }

public function cargaAlmacen(){
    $salida=array();
    $query="Select * from almacen";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }
public function cargaAlmacenSinCentral(){
    $salida=array();
    $query="select * from almacen
where Descripcion <> 'Bodega Central'";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }

public function cargaCatProducto(){
    $salida=array();
    $query="Select * from category_product";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }

public function cargaClasificacionCuenta(){
    $salida=array();
    $query="Select * from clasificacioncuenta";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }

public function cargaDocumento(){
    $salida=array();
    $query="Select * from documento";
    $res =  mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }

public function cargaMovimientos(){
    $salida=array();
    $query="Select * from movimientos";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }

public function cargaPerfilUsuario(){
    $salida=array();
    $query="Select * from profile";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    return $salida;
    }

public function proveedores()
{
$salida=array();
$query="SELECT suppliers.IDsuppliers,
    suppliers.RUT,
    suppliers.Suppliers
    FROM suppliers
    WHERE Estado = 'activo'
    order by Suppliers asc";
$res=mysql_query($query,conectar::con());
while($row=mysql_fetch_assoc($res))
{
$salida[]=$row;
}
return $salida;
}

public function cargaUnidad(){
    $salida=array();
    $query="Select * from Unidad";
    $res = mysql_query($query,Conectar::con());
    while($row=mysql_fetch_assoc($res)){
        $salida[]=$row;
        }
    }

public function getRealIP(){

   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );

      // los proxys van añadiendo al final de esta cabecera
      // las direcciones ip que van "ocultando". Para localizar la ip real
      // del usuario se comienza a mirar por el principio hasta encontrar
      // una dirección ip que no sea del rango privado. En caso de no
      // encontrarse ninguna se toma como valor el REMOTE_ADDR

      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);

      reset($entries);
      while (list(, $entry) = each($entries))
      {
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
         {
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\./',
                  '/^127\.0\.0\.1/',
                  '/^192\.168\..*/',
                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                  '/^10\..*/');

            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

            if ($client_ip != $found_ip)
            {
               $client_ip = $found_ip;
               break;
            }
         }
      }
   }
   else
   {
      $client_ip =
         ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            :
            ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               :
               "unknown" );
   }

   return $client_ip;

}

public function ISAUTORIZED($PERFIL_ID, $vMODULO){

    $retorna=array();

    $query=<<<QUERY
            select Item, valor
              from perfiles_permisos a, modulos b
              where a.IDModulo = b.IDmodulo
                AND IDPerfil='$PERFIL_ID'
                AND b.modulo='$vMODULO'

QUERY;

    //return $query;

    $res = mysql_query($query,Conectar::con());

    if($res) {

        if(mysql_num_rows($res) > 0) {

            $rows = array();
            while($row = mysql_fetch_assoc($res))
            {
                    $rows[$row['Item']] = $row['valor'];
            }
            $retorna=$rows;
        }

    }

    return $retorna;

}




}

?>
