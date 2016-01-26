<?php
require_once("../../validatesession_json.php");
require_once("update_sql_cotizacion.php");


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

    
	$id_cliente=$_POST["scliente"];
	$id_empresa=$_SESSION['SESS_EMPRESA_ID'];
	$id_forma_pago=$_POST["fpago"];
	$neto=$_POST["neto"];
	$iva=$_POST["iva"];
	$total=$_POST["total"];
    $glosa=$_POST["glosa"];
    $id_cotizacion=$_POST["idcot"];
    
	$tra->editar_cotizacion($id_cliente,$id_forma_pago,$neto,$iva,$total,$id_empresa,$glosa,$id_cotizacion);
	

	$salida="";
	
	for($i=0;$i<54;$i++)
	{
		$valor =$_POST["precio_unitario"][$i]; // nuevo campo
		$total_tbl=$_POST["total_tbl"][$i];
        
		$iva2=($_POST["total_tbl"][$i]-$_POST["precio_unitario"][$i]);
		
		$posicion=$_POST["posicion"][$i];
		$descripcion=$_POST["descripcion"][$i];
		$codigo=$_POST["codigo"][$i];
		$cantidad=$_POST["cantidad"][$i];
		$bodega=$_POST["bodega"][$i];
		
		
		$id_detalles=$_POST["id_detalles"][$i];
		$descuento=$_POST["descuento"][$i];	
		
		//$ress=$tra->validar2($id_eorden,$posicion);

		//$salida=$salida.'['.$posicion.';'.$codigo.';'.$id_detalles.']';			
			
		if (value($codigo)=="" && value($id_detalles)!=="")
		{
			//$salida=$salida.'[eliminar_dorden;'.$posicion.';'.$codigo.';'.$id_detalles.']';
			$tra->eliminar_dorden($id_detalles);
			
			
		}
        
		if (value($codigo)!=="" && value($id_detalles)=="") //nuevo
		{
			//$salida=$salida.'[insertar_dcotizacion;'.$posicion.';'.$codigo.';'.$id_detalles.']';			
			$tra->insertar_dcotizacion($id_cotizacion,$posicion,$codigo,$descripcion,$cantidad,$descuento,$bodega,$valor,$iva2,"0.19",$total_tbl,$id_empresa);
			
			
		}
		
		if (value($codigo)!=="" && value($id_detalles)!=="")
		{	
			//$salida=$salida.'[editar_dcotizacion;'.$posicion.';'.$codigo.';'.$id_detalles.';'.$valor.';'.$total_tbl.']';			
			$tra->editar_dcotizacion($posicion,$codigo,$descripcion,$cantidad,$descuento,$bodega,$valor,$iva2,$total_tbl,$id_detalles);
            
		}
		
	}
	
	//$salida="todo";
	echo json_encode($salida);
	
?>