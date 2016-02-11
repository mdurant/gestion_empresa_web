<?php
require_once("../../conexion/conexion.php");
class select
{

public function code_autocomplete()
  {
      $salida=array();
      $query="SELECT * FROM proyectos";
      $res=mysql_query($query,Conectar::con());
      while($row=mysql_fetch_assoc($res))
      {
        $salida[]=$row["nombre_proyecto"];
      }
    return $salida;

    }
}
?>