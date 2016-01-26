<?php

header('Content-Type: text/html; charset=UTF-8');
require_once("../../conexion/conexion.php");




try
{
    
	if($_GET["action"] == "list")
	{
		if($_POST["nombre"]=="" or $_POST["nombre"]=="null")
		{
			$product="";
		}else
		{
			$product=$_POST["nombre"];
		}
        
        if($_POST['inactivo']=="1" or $_POST['inactivo']=="")
        {
            $radio="AND eplantillacot.estado='activo'";
        }elseif($_POST['inactivo']=="2")
        {
            $radio="";
        }
        
        $jtSorting=$_GET["jtSorting"];
		$jtStartIndex=$_GET["jtStartIndex"];
		$jtPageSize=$_GET["jtPageSize"];
		$from="FROM
            eplantillacot";
		$where="WHERE  (eplantillacot.nombre LIKE '%$product%')  $radio";
		$limit="LIMIT $jtStartIndex,$jtPageSize";
		
		$sql2=<<<QUERY
		SELECT COUNT(*) AS RecordCount $from $where;
QUERY;

        $result = mysql_query($sql2,conectar::con());
		$row = mysql_fetch_array($result);
		$recordCount = $row['RecordCount'];
		
		
        $sql=<<<QUERY
			
			SELECT
            eplantillacot.id_eplantilla_cot,
            eplantillacot.nombre,
            eplantillacot.descripcion,
            eplantillacot.estado
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
		{ 	$vRESP="OK"; $vMENSAJE = "plantilla :: listar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "plantilla :: listar :: SQLERROR -> $msgerror ".$fin."-> $sql";};
		
		
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
	//Updating a record (updateAction)
	else if($_GET["action"] == "update")
	{
	   $IdCotizacion=$_GET["dato"];
	   date_default_timezone_set('America/Santiago');
		//Delete from database
		//$motivo=$_POST["motivo"];
        $Factura="";
				$query= "select * from efactura";
				$resul=mysql_query($query,conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$Factura=$row["Numero"];
				}
				if(!$Factura)
				{
					$Factura="90000001";
				}
				else
				{
					$Factura= $Factura + 1;
				}
	      
          //insertar los datos a la tabla ctoizacion a factura
		   $vi=array();
		   $trae="select * from ecotizacion where IdECotizacion= '$IdCotizacion'";
		   $traeres=mysql_query($trae,conectar::con());
		   while($trow=mysql_fetch_assoc($traeres))
		   {
		   	$vi[]=$trow;
		   }
		   $queryse="INSERT INTO efactura (
		   		IdEFactura ,
		   		Numero ,
		   		Folio ,
		   		Referencia ,
		   		IdCliente ,
		   		IdFormaPago ,
		   		Neto ,
		   		Iva ,
		   		Impuesto ,
		   		Total ,
		   		FechaCreacion ,
		   		FechaFacturacion ,
		   		Tipo ,
		   		User ,
		   		Estado ,
		   		IDEmpresa ,
		   		glosa
		   		)
		   		VALUES (
		   		NULL ,  '".$Factura."', '".$vi[0]["Contador"]."',  '".$vi[0]["Contador"]."',   '".$vi[0]["IdCliente"]."',  '".$vi[0]["IdFormaPago"]."',  '".$vi[0]["Neto"]."',  '".$vi[0]["Iva"]."',  '0.19',  '".$vi[0]["Total"]."', NOW( ) , NOW( ) ,  'FACTC',  '".$vi[0]["User"]."',  'activo',  '".$vi[0]["IDEmpresa"]."',  '".$vi[0]["glosa"]."'
		   		)";
               // die($queryse);
		   		mysql_query($queryse,conectar::con());
		
		
		//****************************************************
        
        //****************************************************
		//selecciono el contador y busco los datos en dcotizacion
		//crear la parte de obtener el numero de la cotizacion
			 $n="";
			 $Query="select * from ecotizacion where IdECotizacion= '$IdCotizacion' ";
			 $res=mysql_query($Query,conectar::con());
			 while($reg=mysql_fetch_assoc($res))
			 {
			 	$n=$reg["Contador"];
			 }
			//****************************************************
            //traigo los datos de dcotizacion
            
            $ID_FACT = mysql_query("SELECT IdEFactura FROM efactura WHERE IdEFactura = LAST_INSERT_ID()",conectar::con());
            $row_id = mysql_fetch_array($ID_FACT);
			
			 $dat=array();
			 $dquery="select * from dcotizacion where IdECotizacion='$n'";
			 $datres=mysql_query($dquery,conectar::con());
			 while($datreg=mysql_fetch_assoc($datres))
			
             {
			 	$dat[]=$datreg;
			 }
			
			//comienaza la insercion
			 for($i=0;$i<sizeof($dat);$i++)
			 {
			     if($dat[$i]["Codigo"]=="")
                 {
                    
                 }else
                 {
			 	$iquery="INSERT INTO  dfactura (
			 			IdDFactura ,
			 			IdEFactura ,
			 			Posicion ,
			 			Codigo ,
			 			Descripcion ,
			 			Cantidad ,
			 			Descuento ,
			 			Almacen ,
			 			Neto ,
			 			Iva ,
			 			MontoImpuesto ,
			 			TipoImpuesto ,
			 			Total ,
			 			IDEmpresa
			 			)
			 			VALUES (
			 			NULL ,  '".$row_id[0]."', '".$dat[$i]["Posicion"]."',  '".$dat[$i]["Codigo"]."',  '".$dat[$i]["Descripcion"]."',  '".$dat[$i]["Cantidad"]."',  '".$dat[$i]["Descuento"]."',  '".$dat[$i]["Almacen"]."',  '".$dat[$i]["Neto"]."',  '".$dat[$i]["Iva"]."',  '".$dat[$i]["MontoImpuesto"]."',  '".$dat[$i]["TipoImpuesto"]."',  '".$dat[$i]["Total"]."',  '".$dat[$i]["IDEmpresa"]."'
			 		)";
			      			mysql_query($iquery,conectar::con());
                    
                }
				
				//generar todo lo demas
				//iniciando la forma de pago
					$total1=($vi[0]["Total"]/$vi[0]["IdFormaPago"]);
					$u=1;
					$fpago2=$vi[0]["IdFormaPago"]+1;
					//$fecha=date("Y-m-d");
					for($e=1;$e<$fpago2;$e++)
					{
						if($e==1)
						{
							$fecha=date("Y-m-d");
							$ffinal2=strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
							$ffinal2= date ( 'Y-m-d' , $ffinal2 );
							$insertandos="INSERT INTO  gestion_documento (
										id_gestion_documento ,
										id_efactura ,
										ncuota ,
										monto_cuota ,
										monto_abono ,
										monto_final ,
										tipo_compromiso ,
										estado ,
										fecha_compromiso ,
										fecha_pa ,
										ID_Cliente
										)
										VALUES (
										NULL ,  '".$row_id[0]."',  '".$e."',  '".$total1."', '0', '".$total1."', '0',  'Por Cancelar',  '".$fecha."',  '".$ffinal2."',  '".$vi[0]["IdCliente"]."'
										)";
										mysql_query($insertandos,conectar::con());
										
						}
						else
						{
							$fecha=strtotime ( '+'.$u.' month' , strtotime ( $fecha ) ) ;
							$fecha= date ( 'Y-m-d' , $fecha );
							$ffinal2=strtotime ( '+1 month' , strtotime ( $fecha ) ) ;
							$ffinal2= date ( 'Y-m-d' , $ffinal2 );
							$insertandoss="INSERT INTO  gestion_documento (
										id_gestion_documento ,
										id_efactura ,
										ncuota ,
										monto_cuota ,
										monto_abono ,
										monto_final ,
										tipo_compromiso ,
										estado ,
										fecha_compromiso ,
										fecha_pa ,
										ID_Cliente
										)
										VALUES (
										NULL ,  '".$row_id[0]."',  '".$e."',  '".$total1."', '0', '".$total1."', '0',  'activo',  '".$fecha."',  '".$ffinal2."',  '".$vi[0]["IdCliente"]."'
										)";
										mysql_query($insertandoss,conectar::con());
						}
					}//cierre de formapago
			  }
              
        
		$sqlu=<<<QUERY
		
		UPDATE ecotizacion SET 
		Estado = 'Facturada' WHERE  ecotizacion.IdECotizacion ='$IdCotizacion';
		
QUERY;
		
		
		
		//die($sql);
		
		$msgerror="";
		try
		{ $result = mysql_query($sqlu,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "comunas :: Modificar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "comunas :: Modificar :: SQLERROR -> $msgerror -> $sql";};
		//*************************************************************
		
		//*************************************************************
	
		
		


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
		
	}
 
	//Deleting a record (deleteAction)
	else if($_GET["action"] == "delete")
	{
		
    	 $id_eplantilla_cot=$_POST["id_eplantilla_cot"];

		$delete=<<<QUERY
		DELETE FROM eplantillacot where eplantillacot.id_eplantilla_cot="$id_eplantilla_cot";
QUERY;
/*
    mysql_query($delete2,conectar::con());
    /*
    $delete=<<<QUERY
        DELETE dplantillacot WHERE dplantillacot.id_eplantilla_cot="$id_eplantilla_cot";
QUERY;
*/
		$msgerror="";
		try
		{ $result = mysql_query($delete,conectar::con());} 
        catch(Exception $ex){	$result=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($result)
		{ 	$vRESP="OK"; $vMENSAJE = "Cotizacion :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Cotizacion :: SQLERROR -> $msgerror -> $delete2";};


		//Return result to jTable
		$jTableResult = array();
		$jTableResult['Result'] = $vRESP;
		$jTableResult['Message']= $vMENSAJE;
		print json_encode($jTableResult);
	}
    else if($_GET["action"] == "proveedores")
	{
		$sqlpro=<<<QUERY
        
        SELECT
        suppliers.Suppliers,
        suppliers.IDsuppliers
        FROM
        suppliers
QUERY;
        
		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlpro,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Suppliers"],"Value"=>$row["IDsuppliers"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
        
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "proveedores :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "proveedores :: cargar :: SQLERROR -> $msgerror -> $sqlpro";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;
        
        print json_encode($result);
        
	}
    else if($_GET["action"] == "CategoryProduct")
	{
		$sqlcat=<<<QUERY
        
        SELECT
        category_product.IDCategoryProduct,
        category_product.CategoryProduct
        FROM
        category_product
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlcat,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["CategoryProduct"],"Value"=>$row["IDCategoryProduct"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "CategoryProduct :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "CategoryProduct :: cargar :: SQLERROR -> $msgerror -> $sqlprov";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
    else if($_GET["action"] == "Nombre")
	{
		$sqlnom=<<<QUERY
        
        SELECT
        almacen.IdAlmacen,
        almacen.Nombre
        FROM
        almacen
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlnom,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Nombre"],"Value"=>$row["IdAlmacen"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Almacen :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Almacen :: cargar :: SQLERROR -> $msgerror -> $sqlnom";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
     else if($_GET["action"] == "unidad")
	{
		$sqlun=<<<QUERY
        
        SELECT
        unidad.IDUnidad,
        unidad.Unidad
        FROM
        unidad
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlun,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Unidad"],"Value"=>$row["IDUnidad"]);
    	  }
            	        
        } 
        catch(Exception $ex){	$resultsql=0; $msgerror=$ex;}
		
		$vRESP=$result;
		if ($resultsql)
		{ 	$vRESP="OK"; $vMENSAJE = "Almacen :: cargar :: OK!";	}
		else
		{	$vRESP="ERROR"; $vMENSAJE = "Almacen :: cargar :: SQLERROR -> $msgerror -> $sqlun";};

	    $result = array();
		$result['Result'] = $vRESP;
		$result['Message']= $vMENSAJE;
		$result['Options']= $resoptions;

        print json_encode($result);
        
	}
    else if($_GET["action"] == "ot")
	{
	   
       $IdCotizacion=$_GET["dat"];
		//Delete from database
		//$motivo=$_POST["motivo"];
        $Factura="";
				$query= "select * from eordentrabajo";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$Factura=$row["Numero"];
				}
				if(!$Factura)
				{
					$Factura="30000001";
				}
				else
				{
					$Factura= $Factura + 1;
				}
		//insertar los datos a la tabla ctoizacion a factura
		   $vi=array();
		   $trae="select * from ecotizacion where IdECotizacion= '$IdCotizacion'";
		   $traeres=mysql_query($trae,conectar::con());
		   while($trow=mysql_fetch_assoc($traeres))
		   {
		   	$vi[]=$trow;
		   }
		   $querys="INSERT INTO eordentrabajo (
		   		IdEOrdenTrabajo ,
		   		Numero ,
		   		Folio ,
		   		Referencia ,
		   		IdCliente ,
		   		IdFormaPago ,
		   		Neto ,
		   		Iva ,
		   		Impuesto ,
		   		Total ,
		   		FechaCreacion ,
		   		FechaFacturacion ,
		   		Tipo ,
		   		User ,
		   		Estado ,
		   		IDEmpresa ,
		   		glosa
		   		)
		   		VALUES (
		   		NULL ,  '".$Factura."',  '".$vi[0]["Contador"]."',   '".$vi[0]["Contador"]."',   '".$vi[0]["IdCliente"]."',  '".$vi[0]["IdFormaPago"]."',  '".$vi[0]["Neto"]."',  '".$vi[0]["Iva"]."',  '0.19',  '".$vi[0]["Total"]."', NOW( ) , NOW( ) ,  'OTC',  '".$vi[0]["User"]."',  'activo',  '".$vi[0]["IDEmpresa"]."',  '".$vi[0]["glosa"]."'
		   		)";
		   		mysql_query($querys,conectar::con());
		
		
		//****************************************************
		//selecciono el contador y busco los datos en dcotizacion
		//crear la parte de obtener el numero de la cotizacion
			 $n="";
			 $Query="select * from ecotizacion where IdECotizacion= '$IdCotizacion' ";
			 $res=mysql_query($Query,conectar::con());
			 while($reg=mysql_fetch_assoc($res))
			 {
			 	$n=$reg["Contador"];
			 }
			//****************************************************
            //traigo los datos de dcotizacion
			
			 $dat=array();
			 $dquery="select * from dcotizacion where IdECotizacion='$n'";
			 $datres=mysql_query($dquery,conectar::con());
			 while($datreg=mysql_fetch_assoc($datres))
			
             {
			 	$dat[]=$datreg;
			 }
			
			//comienaza la insercion
			 for($i=0;$i<sizeof($dat);$i++)
			 {
			     if($dat[$i]["Codigo"]=="")
                 {
                    
                 }else
                 {
			 	$iquery="INSERT INTO  dordentrabajo (
			 			IdDOrdenTrabajo ,
			 			IdEOrdenTrabajo ,
			 			Posicion ,
			 			Codigo ,
			 			Descripcion ,
			 			Cantidad ,
			 			Descuento ,
			 			Almacen ,
			 			Neto ,
			 			Iva ,
			 			MontoImpuesto ,
			 			TipoImpuesto ,
			 			Total ,
			 			IDEmpresa
			 			)
			 			VALUES (
			 			NULL ,  '".$Factura."', '".$dat[$i]["Posicion"]."',  '".$dat[$i]["Codigo"]."',  '".$dat[$i]["Descripcion"]."',  '".$dat[$i]["Cantidad"]."',  '".$dat[$i]["Descuento"]."',  '".$dat[$i]["Almacen"]."',  '".$dat[$i]["Neto"]."',  '".$dat[$i]["Iva"]."',  '".$dat[$i]["MontoImpuesto"]."',  '".$dat[$i]["TipoImpuesto"]."',  '".$dat[$i]["Total"]."',  '".$dat[$i]["IDEmpresa"]."'
			 		)";
			      			mysql_query($iquery,conectar::con());
                }
			  }
		
		//*************************************************************
		
		//*************************************************************
	
			$otc=<<<QUERY
		
		UPDATE ecotizacion SET 
		Estado = 'OTC' WHERE  ecotizacion.IdECotizacion ='$IdCotizacion';
		
QUERY;
       
       
	$msgerror="";
		try
		{ $result = mysql_query($otc,conectar::con());} 
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
		print json_encode($_GET["dat"]);
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
