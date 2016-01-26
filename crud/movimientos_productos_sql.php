<?php

header('Content-Type: text/html; charset=UTF-8');

require_once("../conexion/conexion.php");
require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_AFP=array();
$PERMISOS_AFP=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'MOVIMIENTOS_PRODUCTOS');


try
{
    
	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_AFP['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "MOVIMIENTOS_PRODUCTOS :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


		if($_POST["nombreproducto"]=="" or $_POST["nombreproducto"]=="null")
		{
			$forma="";
		}else
		{
			$forma=$_POST["nombreproducto"];
		}
        
        // if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        // {
        //     $radio="AND afp.Estado='activo'";
        // }elseif($_POST['inactivo']=="2")
        // {
        //     $radio="";
        // }

    $jtSorting=$_GET["jtSorting"];
	$jtStartIndex=$_GET["jtStartIndex"];
	$jtPageSize=$_GET["jtPageSize"];

		$from="FROM ecompra enc_compra INNER JOIN empresa tb_empresa ON enc_compra.id_empresa = tb_empresa.IDEmpresa
	 INNER JOIN suppliers tb_proveedores ON enc_compra.id_provedores = tb_proveedores.IDsuppliers
	 INNER JOIN dcompra det_compra ON enc_compra.id_ecompra = det_compra.id_compra
	 INNER JOIN product tb_producto ON det_compra.codigo = tb_producto.CodeBar";
	$where="where
			tb_producto.ProductName  ='$forma'";
	$limit="LIMIT $jtStartIndex,$jtPageSize";
	
	$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

    $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
				SELECT enc_compra.id_ecompra, 
					enc_compra.orden_compra, 
					enc_compra.contador AS folio_interno, 
					enc_compra.fecha_ingreso, 
					enc_compra.fecha_registro, 
					enc_compra.neto, 
					enc_compra.iva, 
					enc_compra.total, 
					enc_compra.folio_factura, 
					tb_empresa.RazonSocial AS empresa, 
					tb_proveedores.Suppliers AS proveedor, 
					tb_producto.ProductName AS producto, 
					det_compra.codigo, 
					det_compra.cantidad, 
					det_compra.precio_compra
					$from  
          			$where
					ORDER BY $jtSorting
					$limit;		
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	
// echo $sql;
		} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "MOVIMIENTOS_PRODUCTOS :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "MOVIMIENTOS_PRODUCTOS :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
		//Add all records to an array
		$rows = array();
		while($row = mysql_fetch_array($result))
		{

				$rows[] = $row;
		  // $rows[] = array_map('utf8_encode', $row);
			
		}

		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		
		print json_encode($jTableResult);
		
	}
	//Exporting to Excel
     else if($_GET["action"] == "exportar-excel")
	{
		

		if (!$PERMISOS_AFP['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Exportar :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		$sql=<<<QUERY
		SELECT enc_compra.id_ecompra, 
					enc_compra.orden_compra, 
					enc_compra.contador AS folio_interno, 
					enc_compra.fecha_ingreso, 
					enc_compra.fecha_registro, 
					enc_compra.neto, 
					enc_compra.iva, 
					enc_compra.total, 
					enc_compra.folio_factura, 
					tb_empresa.RazonSocial AS empresa, 
					tb_proveedores.Suppliers AS proveedor, 
					tb_producto.ProductName AS producto, 
					det_compra.codigo, 
					det_compra.cantidad, 
					det_compra.precio_compra
					$from  
          $where
					ORDER BY $jtSorting



		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());


 		require_once 'Classes/PHPExcel.php';

 		$objPHPExcel = new PHPExcel();
    $i = 3;
    while($row = mysql_fetch_object($result)){
    	 $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $row->proveedor)
            ->setCellValue('B'.$i, $row->fecha_ingreso);

        $i++;

    }
    //Agregamos encabezados
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Proveedor');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Fecha Ingreso');

    $f = Date("Y-m-d-His");
    header('Content-Type: application/vnd.ms-excel');
    $fecha01 = "Comportamiento-Productos".$f.".xls";
    header('Content-Disposition: attachment;filename='.$fecha01.'');
    header('Cache-Control: max-age=0');
    $objPHPExcel->getActiveSheet()->setTitle('Reporte');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');


		} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "formapago :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "formapago :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
					
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['Record'] = $result;
		print json_encode($jTableResult);
	}
	
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{

		if (!$PERMISOS_AFP['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "AFP :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


        $Id_afp=$_POST["Id_afp"];
        $nombre_afp=$_POST["nombre_afp"];
        $cotizacion=$_POST["cotizacion"];
        $codigo=$_POST["codigo"];
        $Estado=$_POST["Estado"];
	
			$sql=<<<QUERY
		
		UPDATE  afp SET  nombre_afp =  '$nombre_afp',
    cotizacion =  '$cotizacion',
    codigo = '$codigo',
    Estado =  '$Estado' WHERE  afp.Id_afp ='$Id_afp';
		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "comunas :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "comunas :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_AFP['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "AFP :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
    	$Id_afp=$_POST["Id_afp"];

		$delete=<<<QUERY
		UPDATE  afp SET  Estado =  'inactivo' WHERE  afp.Id_afp ='$Id_afp';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Cotizacion :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Cotizacion :: Facturada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
   
	
	conectar::desconectar();
}
catch(Exception $ex)
{
    //Return error message
	$jTableResult = array();
	$jTableResult['Result'] = "ERROR";
	$jTableResult['Message'] = $ex->getMessage();
	print json_encode($jTableResult);
}
?>
