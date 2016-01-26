<?php

header('Content-Type: text/html; charset=UTF-8');

/*

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");

*/
//$func = new funciones();

/*$PERMISOS_CLIENTES=array();
$PERMISOS_CLIENTES=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'CLIENTES');*/



require_once("../conexion/conexion.php");



try
{

	if($_GET["action"] == "list")
	{

		/*if (!$PERMISOS_CLIENTES['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Clientes :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		*/
		
		$rut="";

		if(empty($_POST))
		{
			$rut="";
		}else
		{
			$rut=$_POST["bsqrut"];
		}
		       

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM ecompra INNER JOIN suppliers ON ecompra.id_provedores = suppliers.IDsuppliers";
		$where="WHERE suppliers.Suppliers LIKE '$rut%' or suppliers.RUT = '$rut'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2="SELECT COUNT(*) AS RecordCount $from $where";
		//die($sql2);
        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
  
           SELECT
          suppliers.IDsuppliers,
					suppliers.RUT,
					suppliers.Suppliers,
					ecompra.folio_factura,
					ecompra.contador,
					ecompra.total,
					ecompra.id_ecompra,
					ecompra.estadocontable
				$from
				$where
				order by $jtSorting
				 $limit
				

QUERY;

       //die($sql);
        
        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
        $vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Pago Proveedores :: Listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Pago Proveedores :: Listar :: SQLERROR -> $msgerror -> $sql";};
		
		$rows = array();
        while($row = mysql_fetch_array($result))
        {
            $rows[] = $row;
        }
        
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['TotalRecordCount'] = $recordCount;
		$jTableResult['Records'] = $rows;
		
        
        
		print json_encode($jTableResult);
		
	}
    
    
	
    else if($_GET["action"] == "documentar")
	{



		/*if (!$PERMISOS_CLIENTES['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Clientes :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}*/

		//Variables que estoy resiviendo
		//
		//
		
		$idEcompra 			= explode(",", $_POST["id_compra"]);
	
		
		


		
		


		

		

		
		

	   	//mis variables reales


	   	$idEcompraFinal		= implode(",", $idEcompra);
	   	$numero_cuota		= $_POST["numero_cuota"];
	   	$monto_cuota		= $_POST["monto_cuota"];
	   	$monto_abono		= $_POST["monto_abono"];
	   	$monto_final		= $_POST["monto_final"];
	   	$tipo_compromiso	= $_POST["tipo_compromiso"];
	   	$estado 			= $_POST["estado"];
	   	
	   	$fecha_pago			= date("Y-m-d", strtotime(str_replace('/', '-',$_POST["fecha_pago"])));
	   	$id_proveedor		= $_POST["id_proveedor"];
	   	$id_usuario			= $_POST["id_usuario"];
	   	$voucher			= $_POST["voucher"];
	   	$id_banco			= $_POST["id_banco"];


	   		//$vou = $array_voucher[0];
	   		//$vou2 = implode(" ",$vou);
	   		
        $sql=<<<QUERY
		INSERT INTO compromiso_pago_proveedores (
			id_compra,
			numero_cuota,
			monto_cuota,
			monto_abono,
			monto_final,
			tipo_compromiso,
			estado,
			fecha_compromiso,
			fecha_pago,
			id_proveedor,
			id_usuario,
			voucher,
			id_banco
		)
		VALUES
			(
			"$idEcompraFinal",
			"$numero_cuota",
			"$monto_cuota",
			"$monto_abono",
			"$monto_final",
			"$tipo_compromiso",
			'PAGADO',
			 NOW(),
			"$fecha_pago",
			"$id_proveedor",
			"$id_usuario",
			"$voucher",
			"$id_banco"
		)
QUERY;
		

		$result = mysql_query($sql,conectar::con());

		
	   	


	 		for($e=0;$e<sizeof($idEcompra);$e++)
	 		{

	 			$idEcompra2 = $idEcompra[$e];
	 			$update=<<<QUERY
			UPDATE ecompra SET estadocontable='PAGADO' WHERE (id_ecompra="$idEcompra2")
QUERY;
			
			$result = mysql_query($update,conectar::con());
	   	
	 		}
	   		

       
		
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Message']= "Documentar :: OK!";
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
