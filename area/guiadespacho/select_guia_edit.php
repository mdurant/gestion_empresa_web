<?php
require_once("../../conexion/conexion.php");
class funciones
{
 
 public function trae_guia($id)
 {
 	$salida=array();
 	$ides = $id;
 	$query=<<<QUERY

 		SELECT
			eguiadespacho.IdEGuiaDespacho,
			eguiadespacho.Numero,
			eguiadespacho.Folio,
			eguiadespacho.Referencia,
			eguiadespacho.IdCliente,
			eguiadespacho.IdFormaPago,
			eguiadespacho.Neto,
			eguiadespacho.Iva,
			eguiadespacho.Impuesto,
			eguiadespacho.Total,
			eguiadespacho.FechaCreacion,
			eguiadespacho.FechaFacturacion,
			eguiadespacho.`User`,
			eguiadespacho.Estado,
			eguiadespacho.IDEmpresa,
			eguiadespacho.IDMotivo,
			eguiadespacho.glosa,
			eguiadespacho.estadocontable,
			eguiadespacho.rut_chofer,
			eguiadespacho.nom_chofer,
			eguiadespacho.patente,
			eguiadespacho.autoriza
		FROM
			eguiadespacho
		WHERE
			IdEGuiaDespacho = $ides;


QUERY;

		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		return $salida;
 }
 public function plantilla($id)
 	{
 		$salida=array();
 		$query="SELECT * from eplantillaot where id_plantillaot ='$id'";
 		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		return $salida;
 	}
	public function dplantilla($id)
 	{
 		$salida=array();
 		$query="SELECT * from dplantillaot where id_plantillaot ='$id'";
 		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		return $salida;
 	}
public function trabajadores(){

	$salida=array();
	$query="SELECT trabajador.id_trabajador, concat(nombres, ' ' ,apellidop, ' ', apellidom) as datos_trabajador
FROM trabajador";
	$res=mysql_query($query,Conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}

public function empresas()
{
	$salida=array();
	$query="SELECT
			empresa.IDEmpresa,
			empresa.RazonSocial
			FROM
			empresa";
	$res=mysql_query($query,Conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}

public function proyectos()
{
	$salida=array();
	$query="SELECT proyectos.id_proyecto, 
	proyectos.nombre_proyecto, 
	proyectos.fecha_inicio, 
	proyectos.fecha_compromiso, 
	proyectos.id_cliente, 
	proyectos.Estado
	FROM proyectos
	where proyectos.Estado = 'activo'";
	$res=mysql_query($query,Conectar::con());
	while($row=mysql_fetch_assoc($res))
	{
		$salida[]=$row;
	}
	return $salida;
}
// Quien autoriza
public function quien_autoriza()
{
    $salida=array();
    $query="SELECT trabajador.id_trabajador,
UCASE(concat(nombres, ' ', apellidop) )as datos_trabajador
FROM trabajador";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}
    //

public function obtieneguia()
				{
				$guia="";
				$query= "select * from eguiadespacho";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$guia=$row["Numero"];
				}
				if(!$guia)
				{
					$guia="70000001";
				}
				else
				{
					$guia= $guia + 1;
				}
				return $guia;
				
				}
    public function code_autocomplete()
		{
			$salida=array();
			$query="SELECT * FROM product";
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row["CodeBar"];
			}
			return $salida;

		}

	public function motivoguia()
{
    $salida=array();
    $query="SELECT motivo_guia.IDMotivo,
    motivo_guia.nombre_motivo,
    motivo_guia.Estado
    FROM motivo_guia
    WHERE Estado='activo'";
    $res=mysql_query($query,conectar::con());
    while($row=mysql_fetch_assoc($res))
    {
        $salida[]=$row;
    }
    return $salida;
}
	public function almacen() // Se modifica query para apuntar s—lo a la 0100/Central - Mauricio
	{
		$salida=array();
		$query="SELECT
	       almacen.IdAlmacen,
	       almacen.Descripcion,
	       almacen.Estado,
	       almacen.Nombre
	       FROM
	       almacen
	       where 
	       Nombre <='0100'";
		$res=mysql_query($query,Conectar::con());
		while($row=mysql_fetch_assoc($res))
		{
			$salida[]=$row;
		}
		return $salida;
	}
	
	
	public function eguiad($id)
		{
			$salida=array();
			$query=<<<QUERY
			select * from eguiadespacho where IdEGuiaDespacho="$id"
QUERY;
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row;
			}
			return $salida;
			
		}
	
	public function dguiad($id)
		{
			$salida=array();
			$query=<<<QUERY
			select * from dguiadespacho where IdEGuiaDespacho="$id"
QUERY;
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row;
			}
			return $salida;
			
		}
	
}

if(isset($_GET["action"]))
{
	if($_GET["action"] == "clientes")
	{
		$sqlcat=<<<QUERY
        
        SELECT
        customers.IDCliente,
        customers.Cliente
        FROM
        customers
QUERY;

		$msgerror="";
		
        try
		{ 
		  
          $resultsql = mysql_query($sqlcat,conectar::con());
          while($row=mysql_fetch_assoc($resultsql))
    	  {
    			$resoptions[]=array("DisplayText"=>$row["Cliente"],"Value"=>$row["IDCliente"]);
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
	elseif ($_GET["action"]=="traerDatos")
	{
		$salida=array();
	 	$ides = $_GET["id"];
	 	$query=<<<QUERY

 		SELECT
			eguiadespacho.IdEGuiaDespacho,
			eguiadespacho.Numero,
			eguiadespacho.Folio,
			eguiadespacho.Referencia,
			eguiadespacho.IdCliente,
			eguiadespacho.IdFormaPago,
			eguiadespacho.Neto,
			eguiadespacho.Iva,
			eguiadespacho.Impuesto,
			eguiadespacho.Total,
			eguiadespacho.FechaCreacion,
			eguiadespacho.FechaFacturacion,
			eguiadespacho.`User`,
			eguiadespacho.Estado,
			eguiadespacho.IDEmpresa,
			eguiadespacho.IDMotivo,
			eguiadespacho.glosa,
			eguiadespacho.estadocontable,
			eguiadespacho.rut_chofer,
			eguiadespacho.nom_chofer,
			eguiadespacho.patente,
			eguiadespacho.autoriza,
			eguiadespacho.Factura
		FROM
			eguiadespacho
		WHERE
			IdEGuiaDespacho = $ides;


QUERY;

		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		echo json_encode($salida);
	}


	elseif ($_GET["action"]=="traerDatos2")
	{
		$salida=array();
	 	$ides = $_GET["id"];
	 	$query=<<<QUERY

 		SELECT
			dguiadespacho.IdDGuia,
			dguiadespacho.IdEGuiaDespacho,
			dguiadespacho.Posicion,
			dguiadespacho.Codigo,
			dguiadespacho.Descripcion,
			dguiadespacho.Cantidad,
			dguiadespacho.Neto,
			dguiadespacho.Total
		FROM
			dguiadespacho
		WHERE
			IdEGuiaDespacho = $ides;



QUERY;

		$res=mysql_query($query,Conectar::con());
 		while($row=mysql_fetch_assoc($res))
 		{
 			$salida[]=$row;
 		}
 		echo json_encode($salida);
	}
	elseif ($_GET["action"]=="editarDatos")
	{
		$salida	=array();
	 	$ides 	= $_GET["id"];


	 	//Variables rescatadas del POST

	   $Folio        = $_POST["Folio"];
       $Referencia   = $_POST["Referencia"];                   
       $Neto         = $_POST["Neto"];
       $Iva          = $_POST["Iva"];
       $Total        = $_POST["Total"];
       $IDMotivo     = $_POST["IDMotivo"];
       $glosa        = $_POST["glosa"];
       $rut_chofer   = $_POST["rut_chofer"];             
       $nom_chofer   = $_POST["nom_chofer"];    
       $patente      = $_POST["patente"];
       $autoriza     = $_POST["autoriza"];
       $factura 	 = $_POST["factura"];
       $fecha 		 = date_create($_POST["fecha"]);
	   $fecha2       = date_format($fecha, 'Y-m-d H:i:s');
       

       

      



	 	$query 	=<<<QUERY

		 		UPDATE eguiadespacho
					SET Folio = '$Folio',
					Referencia = "$Referencia",
					Neto = '$Neto',
					Iva = "$Iva",
					Total = "$Total",
					IDMotivo = "$IDMotivo",
					glosa = "$glosa",
					rut_chofer = "$rut_chofer",
					nom_chofer = "$nom_chofer",
					patente = "$patente",
					autoriza = "$autoriza",
					Factura = "$factura",
					FechaCreacion = "$fecha2"

				WHERE
					IdEGuiaDespacho = '$ides'



QUERY;

		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}

	elseif ($_GET["action"]=="insertarDatos")
	{
		$salida	=array();
	 	$ides 	= $_GET["id"];


	 	//Variables rescatadas del POST

	   		
			$Posicion 			= $_POST["Posicion"];
			$Codigo 			= $_POST["Codigo"];
			$Descripcion 		= $_POST["Descripcion"];
			$Cantidad 			= $_POST["Cantidad"]; 
			$Descuento 			= $_POST["Descuento"];
			$Almacen 			= $_POST["Almacen"];
			$Neto 				= $_POST["Neto"];
			$Iva 				= $_POST["Iva"];
			$MontoImpuesto 		= "19";
			$TipoImpuesto 		= "IVA 19%"; 
			$Total 				= $_POST["Total"];
			$IDEmpresa 			= 1;



	 	$query 	=<<<QUERY

 		INSERT INTO dguiadespacho (
			IdEGuiaDespacho,
			Posicion,
			Codigo,
			Descripcion,
			Cantidad,
			Descuento,
			Almacen,
			Neto,
			Iva,
			MontoImpuesto,
			TipoImpuesto,
			Total,
			IDEmpresa
		)
		VALUES
			(
				"$ides",
				"$Posicion",
				"$Codigo",
				"$Descripcion",
				"$Cantidad",
				"$Descuento",
				"$Almacen",
				"$Neto",
				"$Iva",
				"$MontoImpuesto",
				"$TipoImpuesto",
				"$Total",
				"$IDEmpresa"
			)


QUERY;

		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}elseif ($_GET["action"]=="editarDatos2")
	{
		$salida	=array();
	 	$ides 	= $_GET["id"];


	 	//Variables rescatadas del POST

	   		
			$Posicion 			= $_POST["Posicion"];
			$Codigo 			= $_POST["Codigo"];
			$Descripcion 		= $_POST["Descripcion"];
			$Cantidad 			= $_POST["Cantidad"]; 
			$Descuento 			= $_POST["Descuento"];
			$Almacen 			= $_POST["Almacen"];
			$Neto 				= $_POST["Neto"];
			$Iva 				= $_POST["Iva"];
			$MontoImpuesto 		= "19";
			$TipoImpuesto 		= "IVA 19%"; 
			$Total 				= $_POST["Total"];
			$IDEmpresa 			= 1;



	 	$query 	=<<<QUERY

 			UPDATE 
 				 dguiadespacho
			SET 
				 Codigo = '$Codigo',
				 Descripcion = '$Descripcion',
				 Cantidad = '$Cantidad',
				 Neto = '$Neto',
				 Iva = '$Iva',
				 Total = '$Total'
			WHERE
				(IdDGuia = '$ides')


QUERY;

		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}elseif ($_GET["action"]=="eliminarDatos2")
	{
		$salida	=array();
	 	$ides 	= $_GET["id"];





	 	$query 	=<<<QUERY

 			DELETE
			FROM
				dguiadespacho
			WHERE
				(IdDGuia = '$ides')


QUERY;

		$res =mysql_query($query,Conectar::con());

 		echo json_encode("Success");
	}




	//cierre del if get
}

?>