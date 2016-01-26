<?php
header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_PROYECTOS=array();
$PERMISOS_PROYECTOS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'PROYECTOS');


require_once("../conexion/conexion.php");


try
{

	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_PROYECTOS['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Proyectos :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		if($_POST["proyecto"]=="" or $_POST["proyecto"]=="null")
		{
			$proyecto="";
		}else
		{
			$proyecto=$_POST["proyecto"];
		}
        
		$proyecto=strtoupper(str_replace(' ','%',$proyecto));
		
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="and proyectos.Estado ='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }


		//Get record count
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount FROM proyectos;
QUERY;
		$result = mysql_query($sql2, conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];

		$name=$_POST["proyecto"];
		$jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
		

		$sql=<<<QUERY
				SELECT
				proyectos.id_proyecto, 
				proyectos.nombre_proyecto, 
				proyectos.fecha_inicio, 
				proyectos.fecha_compromiso, 
				proyectos.id_cliente, 
				proyectos.Estado, 
				customers.IDCliente, 
				customers.rut, 
				customers.Cliente
				FROM proyectos 
				INNER JOIN customers ON proyectos.id_cliente = customers.IDCliente
				where
				nombre_proyecto LIKE '%$name%'  $radio ORDER BY $jtSorting LIMIT $jtStartIndex,$jtPageSize;		
QUERY;


		
		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Proyectos :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Proyectos :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
		
		
		//Add all records to an array
		$rows = array();
		while($row = mysql_fetch_array($result))
		{
		  // $rows[] = array_map('utf8_encode', $row);
			$rows[] = $row;
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
		
		if (!$PERMISOS_PROYECTOS['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Proyectos :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		//Insert record into database
		// Formato de las fechas
		$f_inicio = $_POST["fecha_inicio"];
		$fecha_inicio=date('Y-m-d', strtotime(str_replace("/","-",$f_inicio)));
		// Fecha_compromiso
		$f_compromiso = $_POST["fecha_compromiso"];
		$fecha_compromiso=date('Y-m-d', strtotime(str_replace("/","-",$f_compromiso)));

		$proyecto=$_POST['nombre_proyecto'];
		$idcliente=$_POST['id_cliente'];
		$estado =$_POST['Estado'];
		
		$sql=<<<QUERY
		INSERT INTO proyectos (id_proyecto, nombre_proyecto, fecha_inicio, fecha_compromiso, id_cliente, Estado)
		VALUES (NULL, '$proyecto', '$fecha_inicio', '$fecha_compromiso', '$idcliente', 'activo');
		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());
		
		echo $sql;
		
		} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Proyectos :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Proyectos :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
					
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		$jTableResult['Record'] = $result;
		print json_encode($jTableResult);
	}
	
    else if($_GET["action"] == "update")
	{
		
		if (!$PERMISOS_PROYECTOS['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Proyectos :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		$id_proyecto =$_POST['id_proyecto'];
		$proyecto=$_POST["nombre_proyecto"];
		$f_inicio = $_POST["fecha_inicio"];
		$inicio=date('Y-m-d', strtotime(str_replace("/","-",$f_inicio)));
		$f_fin = $_POST["fecha_compromiso"];
		$fin=date('Y-m-d', strtotime(str_replace("/","-",$f_fin)));
		//$fin=$_POST["fecha_compromiso"];
		$idcliente=$_POST["id_cliente"];
		$estado=$_POST["Estado"];
		//Update record in database
		$sql=<<<QUERY
		
		UPDATE proyectos 
		SET
		nombre_proyecto = '$proyecto',
		fecha_inicio ='$inicio',
		fecha_compromiso ='$fin',
		id_cliente = '$idcliente',
		Estado = '$estado'
		WHERE id_proyecto = '$id_proyecto';
		
QUERY;
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());
			 echo $sql;
		} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Proyectos :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Proyectos :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
	
    
    else if($_GET["action"] == "delete")
	{

		if (!$PERMISOS_PROYECTOS['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Proyectos :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		$id_proyecto=$_POST['id_proyecto'];
		//Delete from database
		$delete=<<<QUERY
		UPDATE proyectos SET Estado = 'inactivo' WHERE id_proyecto = $id_proyecto;
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Proyectos :: Eliminar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Proyectos :: Eliminar :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
	
	else if($_GET["action"] == "clientes")
	{
		$sqlprov=<<<QUERY
        
        SELECT customers.IDCliente, 
		customers.rut, 
		customers.Cliente
		FROM customers;
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlprov,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Cliente"],"Value"=>$row["IDCliente"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Clientes :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Clientes :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

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
