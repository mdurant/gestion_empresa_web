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
		       

    $jtSorting=$_GET["1"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
		$group_by ="GROUP BY a.id_operario";

		$from="FROM esolicitud a
			left outer join trabajador b ON
				a.id_operario = b.id_trabajador";
		$where="WHERE upper (concat(b.nombres, ' ', b.apellidop))  LIKE '$rut%' ";
		$limit=" $group_by  $jtSorting  LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2="SELECT COUNT(*) AS RecordCount $from $where";
		//die($sql2);
        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
  
           SELECT a.id_esolicitud, 
					a.fecha_sol, 
					a.id_jefe, 
					a.id_operario, 
					a.id_proyecto, 
					a.orden_trabajo, 
					a.contador, 
					a.estado, 
					a.glosa,
					COUNT(a.id_proyecto) as cantidad,
					concat(b.nombres, ' ' , b.apellidop) as operario
					$from
					$where
				 	$limit


QUERY;

       //die($sql);
        
        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
        $vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Lista Pedidos x Trabajador :: Listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Lista Pedidos x Trabajador :: Listar :: SQLERROR -> $msgerror -> $sql";};
		
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
		
		$idEcompra 			= explode(",", $_POST["idEcompra"]);
		$ultimoidEcompra	= count($idEcompra) - 1;
		unset($idEcompra[$ultimoidEcompra]);
		$idEcompraFinal		= implode(",", $idEcompra);


		$montoCuota 		= $_POST["montoCuota"];	
		$tipo_compromiso 	= $_POST["tipo_compromiso"];

		$fechaPago 			= explode(",", $_POST["fechaCompromiso"]);
		$ultimofechaPago	= count($fechaPago) - 1;
		unset($fechaPago[$ultimofechaPago]);


		

		$idProveedor 		= explode(",", $_POST["IDsuppliers"]);
		$ultimoidProveedor	= count($idProveedor) - 1;
		unset($idProveedor[$ultimoidProveedor]);

		
		$IDUser 			= $_POST["IDUser"];
	   	$TotalCheques		= $_POST["TotalCheques"];
	   	$voucher			= $_POST["codigoVoucher"];


	   	
	   	for($e=0;$e<$TotalCheques;$e++)
	   	{
	   		

	   		$fech = date("Y-m-d", strtotime(str_replace('/', '-',$fechaPago[$e])));
	   		//$array_voucher = explode(",", $voucher);
	   		$voucher			= $_POST["codigoVoucher"];
	   		
	   		
	   		$provee = $idProveedor[0];
	   		//$vou = $array_voucher[0];
	   		//$vou2 = implode(" ",$vou);
	   		
        $sql=<<<QUERY
		INSERT INTO compromiso_pago_proveedores (
			id_compra,
			numero_cuota,
			monto_cuota,
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
			"1",
			"$montoCuota",
			"$montoCuota",
			"$tipo_compromiso",
			'PENDIENTE PAGO',
			 NOW(),
			"$fech",
			"$provee",
			"$IDUser",
			"$voucher",
			"2"
		)
QUERY;

		$result = mysql_query($sql,conectar::con());

		echo $sql;
	   	}


	   	for($z=0;$z<count($idEcompra);$z++)
	   	{
	   		$idcom = $idEcompra[$z];
	   		$update=<<<QUERY
			UPDATE ecompra SET estadocontable='PAGADO' WHERE (id_ecompra="$idcom")
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
