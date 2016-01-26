<?php

header('Content-Type: text/html; charset=UTF-8');


require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_IPC=array();
$PERMISOS_IPC=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'IPC');



require_once("../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_IPC['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "IPC :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		
		if($_POST["tablaipc"]=="" or $_POST["tablaipc"]=="null")
		{
			$forma="";
		}else
		{
			$forma=$_POST["tablaipc"];
		}
        
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND tabla_ipc.Estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM tabla_ipc";
		$where="WHERE tabla_ipc.anio_ipc LIKE '%$forma%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
		SELECT
		IDTablaIPC, 
                mes_ipc, 
                anio_ipc, 
                valor_ipc, 
                Estado 
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
		{ 	$vRESP="OK"; $vMENSAJE = "tabla_ipc :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "tabla_ipc :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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

		if (!$PERMISOS_IPC['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "IPC :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
		//Insert record into database
        $IDTablaIPC=$_POST["IDTablaIPC"];
        $mes_ipc=$_POST["mes_ipc"];
        $anio_ipc=$_POST["anio_ipc"];
        $valor_ipc=$_POST["valor_ipc"];
        $Estado=$_POST["Estado"];
 
		$sql=<<<QUERY
		INSERT INTO  tabla_ipc (
                        IDTablaIPC ,
                        mes_ipc ,
                        anio_ipc ,
                        valor_ipc,
                        Estado
                        )
                        VALUES (
                        NULL , '$mes_ipc',  '$anio_ipc','$valor_ipc','$Estado'
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

		if (!$PERMISOS_IPC['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "IPC :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

        $IDTablaIPC=$_POST["IDTablaIPC"];
        $mes_ipc=$_POST["mes_ipc"];
        $anio_ipc=$_POST["anio_ipc"];
        $valor_ipc=$_POST["valor_ipc"];
        $Estado=$_POST["Estado"];
	
			$sql=<<<QUERY
		
		UPDATE  tabla_ipc SET  mes_ipc =  '$mes_ipc',
                anio_ipc =  '$anio_ipc',
                valor_ipc = '$valor_ipc',
                Estado =  '$Estado' WHERE  tabla_ipc.IDTablaIPC ='$IDTablaIPC';
		
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

		if (!$PERMISOS_IPC['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "IPC :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
    	$IDTablaIPC=$_POST["$IDTablaIPC"];

		$delete=<<<QUERY
		UPDATE  tabla_ipc
		SET
		Estado =  'inactivo'
		WHERE  tabla_ipc.IDTablaIPC ='$IDTablaIPC';
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
