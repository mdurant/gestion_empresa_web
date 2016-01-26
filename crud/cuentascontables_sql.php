<?php

header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_CUENTASCONTABLES=array();
$PERMISOS_CUENTASCONTABLES=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'CUENTASCONTABLES');



require_once("../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{
		
		if (!$PERMISOS_CUENTASCONTABLES['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Cuentas Contables :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
		
		if($_POST["cuentascontables"]=="" or $_POST["cuentascontables"]=="null")
		{
			$forma="";
		}else
		{
			$forma=$_POST["cuentascontables"];
		}
        
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND cuentacontable.Estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

		$from="FROM cuentacontable
			inner join grupocuentas on
			grupocuentas.IDGrupoCuenta = cuentacontable.IDGrupoCuenta
		";
		$where="WHERE cuentacontable.Cuenta LIKE '%$forma%' $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			SELECT
				cuentacontable.IDCuenta,
				cuentacontable.IDGrupoCuenta,
				grupocuentas.Grupo,
				cuentacontable.Cuenta,
				cuentacontable.Codigo,
				cuentacontable.Estado
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
		{ 	$vRESP="OK"; $vMENSAJE = "Cuenta Contable :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Cuenta Contable:: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
		
		if (!$PERMISOS_CUENTASCONTABLES['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Cuenta Contable :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		
				//Insert record into database
        $IDGrupoCuenta=$_POST["IDGrupoCuenta"];
		$cuenta = $_POST["Cuenta"];
        $codigo=$_POST["codigo"];
        $Estado=$_POST["Estado"];
 
		$sql=<<<QUERY
			INSERT INTO cuentacontable
			(IDGrupoCuenta, Cuenta, Codigo, IDClasificacionCuenta, Estado) 
			VALUES
			('$IDGrupoCuenta', '$cuenta', '$codigo', '1', '$Estado');

		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Cuenta Contable :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Cuenta Contable :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
					
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

		if (!$PERMISOS_CUENTASCONTABLES['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Cuenta Contable :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
	$idcuenta = $_POST["IDCuenta"];
        $IDGrupoCuenta=$_POST["IDGrupoCuenta"];
        $cuenta=$_POST["Cuenta"];
        $codigo=$_POST["Codigo"];
        $Estado=$_POST["Estado"];
	
			$sql=<<<QUERY
			UPDATE cuentacontable 
			SET IDGrupoCuenta = '$IDGrupoCuenta' ,
			Cuenta = '$cuenta',
			Codigo = '$codigo',
			IDClasificacionCuenta = '1',
			Estado = '$Estado' 
			WHERE
			IDCuenta ='$idcuenta';
		
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
		
		if (!$PERMISOS_CUENTASCONTABLES['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Cuentas Contables :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}
		

    	$idcuenta=$_POST["IDCuenta"];

		$delete=<<<QUERY
		UPDATE  cuentacontable SET  Estado =  'inactivo' WHERE  cuentacontable.IDCuenta ='$idcuenta';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Cuenta Contable :: Eliminada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Cuenta Contable ::  Eliminada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
   
	else if($_GET["action"] == "grupocuentas")
	{
		$sqlprov=<<<QUERY
            Select 
            IDGrupoCuenta,
            Grupo,
            Codigo,
            Estado
            from grupocuentas
            where 
            Estado ='activo'
   ;
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlprov,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Grupo"],"Value"=>$row["IDGrupoCuenta"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Grupo Cuentas :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Grupo Cuentas :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

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
