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

		$from="FROM esolicitud enc_solicitud INNER JOIN dsolicitud det_solicitud ON enc_solicitud.id_esolicitud = det_solicitud.id_esolicitud
	 INNER JOIN proyectos tb_proyecto ON enc_solicitud.id_proyecto = tb_proyecto.id_proyecto
	 INNER JOIN customers ON tb_proyecto.id_cliente = customers.IDCliente";
	$where="where det_solicitud.producto ='$forma'";
	$limit="LIMIT $jtStartIndex,$jtPageSize";
	
	$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

    $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
    $sql=<<<QUERY
			
		SELECT enc_solicitud.id_esolicitud, 
		enc_solicitud.fecha_sol, 
		enc_solicitud.orden_trabajo, 
		enc_solicitud.contador, 
		enc_solicitud.estado, 
		enc_solicitud.glosa, 
		det_solicitud.codigo_producto, 
		det_solicitud.producto, 
		det_solicitud.cantidad, 
		det_solicitud.observacion, 
		tb_proyecto.nombre_proyecto, 
		customers.Cliente
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
		{ 	$vRESP="OK"; $vMENSAJE = "SALIDA PRODUCTOS :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "SALIDA PRODUCTOS :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
     else if($_GET["action"] == "create")
	{
		

		if (!$PERMISOS_AFP['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "AFP :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}


		//Insert record into database
        $Id_afp=$_POST["Id_afp"];
        $nombre_afp=$_POST["nombre_afp"];
        $cotizacion=$_POST["cotizacion"];
        $codigo=$_POST["codigo"];
        $Estado=$_POST["Estado"];
 
		$sql=<<<QUERY
		INSERT INTO  afp (
    Id_afp ,
    nombre_afp ,
    cotizacion ,
    codigo,
    Estado
    )
    VALUES (
    NULL , '$nombre_afp',  '$cotizacion','$codigo','$Estado'
    );



		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
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
