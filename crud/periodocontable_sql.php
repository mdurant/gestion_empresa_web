<?php

header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_PERIODOCONTABLE=array();
$PERMISOS_PERIODOCONTABLE=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'PERIODOCONTABLE');



require_once("../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{
		
		if (!$PERMISOS_PERIODOCONTABLE['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Periodo Contable :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
		
		if($_POST["periodocontable"]=="" or $_POST["periodocontable"]=="null")
		{
			$forma="";
		}else
		{
			$forma=$_POST["periodocontable"];
		}
        
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND periodo_contable.estado='Abierto'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM periodo_contable
		INNER JOIN trabajador ON 
		trabajador.id_trabajador = periodo_contable.id_autorizado
		";
		$where="LIKE '%$forma%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			SELECT periodo_contable.id_periodo, 
			periodo_contable.anio_periodo, 
			periodo_contable.id_autorizado,
			CONCAT(trabajador.nombres, ' ' , trabajador.apellidop) as datos_trabajador,
			periodo_contable.estado
				$from  
                $where
				ORDER BY $jtSorting
				$limit;		
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Periodo Contable :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Periodo Contable:: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
		
		if (!$PERMISOS_PERIODOCONTABLE['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Periodo Contable :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
				//Insert record into database
        $id_periodo=$_POST["id_periodo"];
		$id_autorizado =$_POST["id_autorizado"];
		$anio_periodo = $_POST["anio_periodo"];
        $estado=$_POST["estado"];
 
		$sql=<<<QUERY
			INSERT INTO
			periodo_contable
			(anio_periodo, id_autorizado, estado) 
			VALUES ('$anio_periodo','$id_autorizado', '$estado');

		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Periodo Contable :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Periodo Contable :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
					
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

		if (!$PERMISOS_PERIODOCONTABLE['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Periodo Contable :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		$id_periodo=$_POST["id_periodo"];
		$id_autorizado =$_POST["id_autorizado"];
		$anio_periodo = $_POST["anio_periodo"];
        $estado=$_POST["estado"];
	
			$sql=<<<QUERY
			UPDATE periodo_contable 
			SET anio_periodo = '$anio_periodo' ,
			id_autorizado = '$id_autorizado',
			estado = '$estado' 
			WHERE id_periodo = '$id_periodo'
			;
		
QUERY;

		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Cuentas Contable :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Cuentas Contable :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		
		if (!$PERMISOS_PERIODOCONTABLE['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Periodo Contable :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		

    	$id_periodo=$_POST["id_periodo"];

		$delete=<<<QUERY
		UPDATE  periodo_contable SET  estado =  'inactivo' WHERE  periodo_contable.id_periodo ='$id_periodo';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Periodo Contable :: Eliminada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Periodo Contable ::  Eliminada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
   
	else if($_GET["action"] == "autorizado")
	{
		$sqlprov=<<<QUERY
            SELECT id_trabajador,
			rut_trabajador,
			CONCAT(trabajador.nombres, ' ', trabajador.apellidop) as datos_trabajador,
			estado 
			FROM trabajador
			where
			estado ='activo'
   ;
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlprov,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["datos_trabajador"],"Value"=>$row["id_trabajador"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Datos Trabajador :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Datos Trabajador :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
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
