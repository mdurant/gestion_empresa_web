<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{
		$jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
		$get_val=$_GET["IDPerfil"];
        $bsq=$_POST["Item"];
        

		$from="FROM
                dplantillacot
                INNER JOIN eplantillacot ON dplantillacot.id_eplantilla_cot = eplantillacot.id_eplantilla_cot";
		$where="WHERE eplantillacot.id_eplantilla_cot = '$get_val'";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

		$result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
		$sql=<<<QUERY
			
				SELECT
                dplantillacot.id_dplantilla_cot,
                dplantillacot.cantidad,
                dplantillacot.descuento,
                dplantillacot.descripcion,
                dplantillacot.codigo,
                eplantillacot.id_eplantilla_cot
                $from $where $limit;		
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "plantillas :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "plantillas :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
		
		//Insert record into database
        $IDPerfilesPermisos = $_POST["IDPerfilesPermisos"];
        $IDPerfil = $_POST["IDPerfil"];
        $IDModulo = $_POST["IDModulo"];
        $Item = $_POST["Item"];
        $Valor = $_POST["Valor"];
 
		$sql=<<<QUERY
		INSERT INTO perfiles_permisos 
        (IDPerfil,
          IDModulo,
          Item, 
          Valor)
           VALUES ('$IDPerfil', '$IDModulo', '$Item', '$Valor');


		
QUERY;
        
		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "perfiles :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "perfiles :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
		$IDPerfilesPermisos = mysql_query("SELECT * FROM perfiles_permisos WHERE IDPerfilesPermisos = LAST_INSERT_ID();");
		$row = mysql_fetch_array($IDPerfilesPermisos);
        			
		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
        $jTableResult['Record'] = $row;
		print json_encode($jTableResult);
	}
	
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
	    $IDPerfilesPermisos = $_POST["IDPerfilesPermisos"];
        $IDPerfil = $_POST["IDPerfil"];
        $IDModulo = $_POST["IDModulo"];
        $Item = $_POST["Item"];
        $Valor = $_POST["Valor"];
	
			$sql=<<<QUERY
		
		UPDATE  perfiles_permisos SET  IDPerfil =  '$IDPerfil',
        IDModulo =  '$IDModulo',
        Item =  '$Item',
        Valor =  '$Valor' WHERE  perfiles_permisos.IDPerfilesPermisos ='$IDPerfilesPermisos';
		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "permisos :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "permisos :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		
    	$IDPerfilesPermisos = $_POST["IDPerfilesPermisos"];

		$delete=<<<QUERY
		DELETE FROM perfiles_permisos WHERE perfiles_permisos.IDPerfilesPermisos = '$IDPerfilesPermisos';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "perfiles :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "perfiles :: Facturada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
    else if($_GET["action"] == "modulo")
	{
		$sqlun=<<<QUERY
        
        SELECT
        modulos.IDmodulo,
        modulos.modulo
        FROM
        modulos
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlun,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["modulo"],"Value"=>$row["IDmodulo"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "modulo :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "modulo :: cargar :: SQLERROR -> $msgerror -> $sqlun";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
    else if($_GET["action"] == "modulos")
	{
		$sqlun=<<<QUERY
        
        SELECT
        modulos.IDmodulo,
        modulos.modulo
        FROM
        modulos

QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlun,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["modulo"],"Value"=>$row["IDmodulo"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "modulo :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "modulo :: cargar :: SQLERROR -> $msgerror -> $sqlun";};

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
