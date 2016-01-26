<?php
require_once("../../validatesession_json.php");
require_once("eplantillaot_sql.php");


        function value($field, $default_value = "") {
            if (isset($field) && !empty($field)) {
                $value = trim($field);
                return $value;
            }
            
            return $default_value;
        }

$tra=new cargar_plantilla();


	//Capturo la fecha de inicio y termino de la cotizacion
	date_default_timezone_set("Chile/Continental");
	//$f1=date("Y-m-d");
	$f1=$_POST["facturacion"];//nuevo
	$f3=$_POST["facturacion2"];//nuevo
	//$f2=date("Y-m-d", strtotime('+'.$_POST["tcotizacion"].' day'));
	$ffinal=date('Y-m-d', strtotime($f1));
	$ffinal2=date("Y-m-d", strtotime($f3));
	//************************************************************
	
	//Capturo los datos de los select y contador
	$empresa=$_SESSION['SESS_EMPRESA_ID'];
	$id_eorden=$_POST["id_ord"];

    
	$idcliente=$_POST["clientes"];
    
	$jefe=$_POST["jefe"];
	$glosa=$_POST["glosa"];
	$patente=$_POST["patente"]; // nuevo campo
	$vehiculo=$_POST["vehiculo"]; // nuevo campo
    
	$total=$_POST["total"]; // nuevo campo
    
	$tra->editar_eorden($idcliente,$empresa,$ffinal,$id_eorden,$ffinal2,$jefe,$glosa,$patente,$vehiculo,$total);
	
	
	$salida="";

	for($i=0;$i<54;$i++)
	{
		
		$posicion=$_POST["posicion"][$i];
		$descripcion=$_POST["descripcion"][$i];
		$codigo=$_POST["codigo"][$i];
		$cantidad=$_POST["cantidad"][$i];
		$bodega=$_POST["bodega"][$i];
		$valor =$_POST["valor"][$i]; // nuevo campo
		$id_detalles=$_POST["id_detalles"][$i];
		
		//$ress=$tra->validar2($id_eorden,$posicion);

		if (value($codigo)=="" && value($id_detalles)!=="")
		{
			$salida=$salida.'[eliminar_dorden;'.$posicion.';'.$codigo.';'.$id_detalles.']';
			$tra->eliminar_dorden($id_detalles);
			
			
		}
		
		if (value($codigo)!=="" && value($id_detalles)=="")
		{
			$salida=$salida.'[insertar_dorden;'.$posicion.';'.$codigo.';'.$id_detalles.']';			
			$tra->insertar_dorden($id_eorden,$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor);
			
			
		}
		
		if (value($codigo)!=="" && value($id_detalles)!=="")
		{
			$salida=$salida.'[editar_dorden;'.$posicion.';'.$codigo.';'.$id_detalles.']';			
			$tra->editar_dorden($posicion,$codigo,$descripcion,$cantidad,$bodega,$id_detalles,$valor);
		}

			
		
	}
	
	//$salida="todo";
	echo json_encode($salida);
	
?>