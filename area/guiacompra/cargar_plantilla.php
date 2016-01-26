<?php
    require_once("select_orden.php");
    
    $id_plantilla=$_POST["oculto_pla"];
    
    $tra=new select();
    $res=$tra->dplantilla($id_plantilla);
    
    for($i=0;$i<sizeof($res);$i++)
    {
        $salida["Codigo".$i]=$res[$i]["Codigo"];
        $salida["descripcion".$i]=$res[$i]["descripcion"];
        $salida["cantidad".$i]=$res[$i]["cantidad"];
        $salida["almacen".$i]=$res[$i]["id_almacen"];
        $salida["valor".$i]=$res[$i]["valor"];
        $salida["total_tbl".$i]=($res[$i]["valor"]*$res[$i]["cantidad"]);
    }
    $salida["total"]=count($salida);
    echo json_encode($salida);

?>