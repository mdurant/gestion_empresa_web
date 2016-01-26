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
	$f1=$_POST["facturacion"];//nuevo
	//$f2=date("Y-m-d", strtotime('+'.$_POST["tcotizacion"].' day'));
	$ffinal=date('Y-m-d', strtotime($f1));
	//************************************************************
	
	//Capturo los datos de los select y contador
	$nombre=$_POST["nplantilla"];
	$id_eplantilla=$_POST["id_edicion"];
	$describe=$_POST["dplantilla"];
    $tra->editar_eplantillaot($id_eplantilla,$nombre,$describe);
	
	$salida="";
	
	//los recorro para hacer el insert
	for($i=0;$i<54;$i++)
	{
		$posicion=$_POST["posicion"][$i];
		$descripcion=$_POST["descripcion"][$i];
		$codigo=$_POST["codigo"][$i];
		$cantidad=$_POST["cantidad"][$i];
		$bodega=$_POST["bodega"][$i];
		$id_detalles=$_POST["id_detalles"][$i];
		$valor=$_POST["valor"][$i];		
		
		//$ress=$tra->validar($id_eplantilla,$posicion);
		
		
		/*
		//aqui hago el update
		if($_POST["codigo"][$i]=="")
		{
		
		}
		elseif($ress[0]=="" or $ress[0]=="null")
		{

			
			//inserto el nuevo valor
			$tra->insertar_dplantillaot($id_eplantilla,$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor);
			
								
		}else
		{


		$tra->editar_dplantillaot($id_detalles,$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor);

		}
		*/
		
		
		
		if (value($codigo)=="" && value($id_detalles)!=="")
		{
			$salida=$salida.'[eliminar_dplantillaot;'.$posicion.';'.$codigo.';'.$id_detalles.']';
			$tra->eliminar_dplantillaot($id_detalles);
			
			
		}else if (value($codigo)!=="" && value($id_detalles)=="")
		{
			$salida=$salida.'[insertar_dplantillaot;'.$posicion.';'.$codigo.';'.$id_detalles.']';			
			$tra->insertar_dplantillaot($id_eplantilla,$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor);
			
			
		}else if (value($codigo)!=="" && value($id_detalles)!=="")
		{
			$salida=$salida.'[editar_dplantillaot;'.$posicion.';'.$codigo.';'.$id_detalles.']';			
			$tra->editar_dplantillaot($id_detalles,$posicion,$codigo,$descripcion,$cantidad,$bodega,$valor);
		}
		
		
	}
	
	//$salida.="todo";
	echo json_encode($salida);
	
?>