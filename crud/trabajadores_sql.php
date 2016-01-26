<?php

header('Content-Type: text/html; charset=UTF-8');

require_once("../validatesession_json.php");

require_once("../conexion/funciones.php");
$func = new funciones();

$PERMISOS_TRABAJADORES=array();
$PERMISOS_TRABAJADORES=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'TRABAJADORES');



require_once("../conexion/conexion.php");

try
{
    
	if($_GET["action"] == "list")
	{

		if (!$PERMISOS_TRABAJADORES['LISTAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Trabajadores :: LISTAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		
		if($_POST["nombretrabajador"]=="" or $_POST["nombretrabajador"]=="null")
		{
			$forma="";
		}else
		{
			$forma=$_POST["nombretrabajador"];
		}
        
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND trabajador.estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }

        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];

	$from="FROM trabajador
	 LEFT OUTER JOIN `salud` ON trabajador.`id_salud` = salud.`IDSalud`
     LEFT OUTER JOIN `afp` ON trabajador.`id_afp` = afp.`Id_afp`
     LEFT OUTER JOIN `nivel_estudios` ON trabajador.`id_estudios` = nivel_estudios.`IDNivel`
     LEFT OUTER JOIN `comunas` ON trabajador.`id_ciudad` = comunas.`IDComuna`
     LEFT OUTER JOIN `region` ON trabajador.`id_region` = region.`IDRegion`
     LEFT OUTER JOIN `pais` ON trabajador.`id_pais` = pais.`Id_pais`
     LEFT OUTER JOIN `estado_civil` ON trabajador.`id_civil` = estado_civil.`id_civil`
     LEFT OUTER JOIN `puesto_empresa` ON trabajador.`id_puestoempresa` = puesto_empresa.`id_puesto`";
	$where="WHERE trabajador.nombres LIKE '%$forma%' $radio";
	$limit="LIMIT $jtStartIndex,$jtPageSize";
		
	$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
		SELECT
     trabajador.`id_trabajador`,
     trabajador.`rut_trabajador`,
     trabajador.`nombres`,
     trabajador.`apellidop`,
     trabajador.`apellidom` ,
     trabajador.`edad`,
     trabajador.`fecha_nacimiento`,
     trabajador.`direccion`,
     trabajador.`telefono_fijo`,
     trabajador.`telefono_movil`,
     trabajador.`email`,
     trabajador.`id_salud`,
     trabajador.`id_afp`,
     trabajador.`id_estudios`,
     trabajador.`id_ciudad`,
     trabajador.`id_region`,
     trabajador.`id_pais`,
     trabajador.`id_civil` ,
     trabajador.`estado` ,
     trabajador.`id_puestoempresa`,
     salud.`IDSalud`,
     salud.`Nombre_Salud`,
     afp.`Id_afp`,
     afp.`nombre_afp`,
     nivel_estudios.`IDNivel`,
     nivel_estudios.`nombre_nivel`,
     comunas.`IDComuna`,
     comunas.`Comuna`,
     region.`IDRegion`,
     region.`region` ,
     pais.`Id_pais`,
     pais.`nombre_pais`,
     estado_civil.`id_civil`,
     estado_civil.`estado`,
     puesto_empresa.`id_puesto`,
     puesto_empresa.`nombre_puesto`
		$from
		$where
		ORDER BY $jtSorting
		$limit;		
QUERY;

        $msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());	

//echo $sql;
		} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Tabla Trabajadores :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Tabla Trabajadores :: listar :: SQLERROR -> $msgerror -> $sql";};
		
		
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
		
		if (!$PERMISOS_TRABAJADORES['CREAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Trabajadores :: CREAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		//Insert record into database table trabajador
        $id_trabajador=$_POST["id_trabajador"];
        $rut_trabajador=$_POST["rut_trabajador"];
        $nombres=$_POST["nombres"];
        $apellidop=$_POST["apellidop"];
        $apellidom=$_POST["apellidom"];
        $edad=$_POST["edad"];
        $fecha_nacimiento=$_POST["fecha_nacimiento"];
        $direccion=$_POST["direccion"];
        $telefono_fijo=$_POST["telefono_fijo"];
        $telefono_movil=$_POST["telefono_movil"];
        $email=$_POST["email"];
        $salud=$_POST["id_salud"];
        $afp=$_POST["id_afp"];
        $estudios=$_POST["id_estudios"];
        $ciudad=$_POST["id_ciudad"];
        $region=$_POST["id_region"];
        $pais=1; // Chile
        $civil=$_POST["id_civil"];
        $estado=$_POST["estado"];
 
	$sql=<<<QUERY
		INSERT INTO  trabajador (
		id_trabajador ,
		rut_trabajador ,
		nombres ,
		apellidop ,
		apellidom ,
		edad ,
		fecha_nacimiento ,
		direccion ,
		telefono_fijo ,
		telefono_movil ,
		email ,
		id_salud ,
		id_afp,
		id_estudios ,
		id_ciudad ,
		id_region ,
		id_pais ,
		id_civil ,
		estado
		)
		VALUES (
		NULL ,  '$rut_trabajador',  '$nombres',  '$apellidop',  '$apellidom',  '$edad',  
		'$fecha_nacimiento',  '$direccion',  '$telefono_fijo',  '$telefono_movil',  
		'$email',  '$salud',  '$afp',  '$estudios',  '$ciudad',  '$region',  '$pais',  
		'$civil',  'activo'
		);
		
QUERY;

		$msgerror="";
		try
		{  $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Crear Trabajador :: Ingresar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Crear Trabajador :: Ingresar :: SQLERROR -> $msgerror -> $sql";};
		
					
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

		if (!$PERMISOS_TRABAJADORES['MODIFICAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Trabajadores :: MODIFICAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}



        $id_trabajador=$_POST["id_trabajador"];
        $rut_trabajador=$_POST["rut_trabajador"];
        $nombres=$_POST["nombres"];
        $apellidop=$_POST["apellidop"];
        $apellidom=$_POST["apellidom"];
        $edad=$_POST["edad"];
        $fecha_nacimiento=$_POST["fecha_nacimiento"];
        $direccion=$_POST["direccion"];
        $telefono_fijo=$_POST["telefono_fijo"];
        $telefono_movil=$_POST["telefono_movil"];
        $email=$_POST["email"];
        $salud=$_POST["id_salud"];
        $afp=$_POST["id_afp"];
        $estudios=$_POST["id_estudios"];
        $ciudad=$_POST["id_ciudad"];
        $region=$_POST["id_region"];
        $pais=$_POST["id_pais"]; // Chile
        $civil=$_POST["id_civil"];
        $estado=$_POST["estado"];
	
	$sql=<<<QUERY
		UPDATE  trabajador SET  
		rut_trabajador =  '$rut_trabajador',
		nombres =  '$nombres',
		apellidop =  '$apellidop',
		apellidom =  '$apellidom',
		edad =  '$edad',
		fecha_nacimiento =  '$fecha_nacimiento',
		direccion =  '$direccion',
		telefono_fijo =  '$telefono_fijo',
		telefono_movil =  '$telefono_movil',
		email =  '$email',
		id_salud='$salud',
		id_afp =  '$afp',
		id_estudios =  '$estudios',
		id_ciudad =  '$ciudad',
		id_region =  '$region',
		id_pais =  '$pais',
		id_civil =  '$civil',
		estado ='$estado'
		WHERE  
		trabajador.id_trabajador =$id_trabajador;
		
QUERY;
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sql,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Actualiza Trabajador :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Actualiza Trabajador :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		
		if (!$PERMISOS_TRABAJADORES['ELIMINAR']=='1'){
		
			$jTableResult = array();
			$jTableResult['Result'] = "ERROR";
			$jTableResult['Message']= "Trabajadores :: ELIMINAR :: Acceso denegado.";
			$jTableResult['TotalRecordCount'] = 0;
			$jTableResult['Records'] = array();
			
			print json_encode($jTableResult);
			die;
			
		}

		
    	$id_trabajador=$_POST["id_trabajador"];

		$delete=<<<QUERY
		UPDATE  trabajador SET  estado =  'inactivo' WHERE  trabajador.id_trabajador ='$id_trabajador';
QUERY;

		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Modificar Trabajador :: Facturada :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Modificar Trabajdor :: Facturada :: SQLERROR -> $msgerror -> $sql";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
   // Combobox de Salud
	else if($_GET["action"] == "salud")
	{
		$sql=<<<QUERY
        
            Select 
            IDSalud, 
            Nombre_Salud,
            Cotizacion,
            Codigo,
            Estado 
            from salud
            ;

QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sql,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    		$resoptions[]=array("DisplayText"=>$row["Nombre_Salud"],"Value"=>$row["IDSalud"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$resultsql;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Salud :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Salud :: cargar :: SQLERROR -> $msgerror -> $sql";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
	// Combobox AFP
		else if($_GET["action"] == "afp")
	{
		$sql=<<<QUERY
        	SELECT
		afp.Id_afp, 
		afp.nombre_afp, 
		afp.cotizacion, 
		afp.codigo, 
		afp.Estado
		FROM afp
		;

QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sql,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    		$resoptions[]=array("DisplayText"=>$row["nombre_afp"],"Value"=>$row["Id_afp"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$resultsql;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "AFP :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "AFP :: cargar :: SQLERROR -> $msgerror -> $sql";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
	// Combobox nivel estudios
		else if($_GET["action"] == "estudios")
	{
		$sql=<<<QUERY
        	SELECT
		nivel_estudios.IDNivel, 
		nivel_estudios.nombre_nivel, 
		nivel_estudios.codigo, 
		nivel_estudios.Estado
		FROM 
		nivel_estudios
		;

QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sql,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    		$resoptions[]=array("DisplayText"=>$row["nombre_nivel"],"Value"=>$row["IDNivel"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$resultsql;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Nivel Estudios :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Nivel Estudios :: cargar :: SQLERROR -> $msgerror -> $sql";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
		// Combobox Civil
		else if($_GET["action"] == "civil")
	{
		$sql=<<<QUERY
        	SELECT
			estado_civil.id_civil, 
			estado_civil.estado
			FROM 
			estado_civil
		;

QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sql,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    		$resoptions[]=array("DisplayText"=>$row["estado"],"Value"=>$row["id_civil"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$resultsql;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Estado Civil :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Estado Civil :: cargar :: SQLERROR -> $msgerror -> $sql";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
			// Combobox Civil
		else if($_GET["action"] == "ciudad")
	{
		$sql=<<<QUERY
        	SELECT
		comunas.IDComuna, 
		comunas.Comuna
		FROM
		comunas
		;

QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sql,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    		$resoptions[]=array("DisplayText"=>$row["Comuna"],"Value"=>$row["IDComuna"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$resultsql;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Comunas :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Comunas :: cargar :: SQLERROR -> $msgerror -> $sql";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
			// Combobox Region
		else if($_GET["action"] == "region")
	{
		$sql=<<<QUERY
        	SELECT
		region.IDRegion, 
		region.region, 
		region.orden
		FROM region
		;

QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sql,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    		$resoptions[]=array("DisplayText"=>$row["region"],"Value"=>$row["IDRegion"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$resultsql;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Región :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Región :: cargar :: SQLERROR -> $msgerror -> $sql";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
			// Combobox Pais
		else if($_GET["action"] == "pais")
	{
		$sql=<<<QUERY
        	SELECT
		pais.Id_pais, 
		pais.nombre_pais, 
		pais.CodPais, 
		pais.Estado
		FROM
		pais
            ;

QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sql,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
		$resoptions[]=array("DisplayText"=>$row["nombre_pais"],"Value"=>$row["Id_pais"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$resultsql;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Pais :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Pais :: cargar :: SQLERROR -> $msgerror -> $sql";};

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
