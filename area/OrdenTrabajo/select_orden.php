<?php
require_once("../../conexion/conexion.php");
class select
{
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

// public function forma_pago()
// {
// 	$salida=array();
// 	$query="SELECT
// 			formapago.IdFormaPago,
// 			formapago.Nombre
// 			FROM
// 			formapago";
// 	$res=mysql_query($query,Conectar::con());
// 	while($row=mysql_fetch_assoc($res))
// 	{
// 		$salida[]=$row;
// 	}
// 	return $salida;
// }
		public function ObtieneBoleta()
				{
				$Factura="";
				$query= "select * from dboleta";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$Factura=$row["IdEboleta"];
				}
				if(!$Factura)
				{
					$Factura="50000001";
				}
				else
				{
					$Factura= $Factura + 1;
				}
				return $Factura;
				
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
	public function clientes()
	{
		$salida=array();
		$query="Select * from customers";
		$res=mysql_query($query,Conectar::con());
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
	
	
		public function ObtieneOrden()
				{
				$Factura="";
				$query= "select * from eorden";
				$resul=mysql_query($query,Conectar::con());
				while($row=mysql_fetch_assoc($resul))
				{
					$Factura=$row["contador"];
				}
				if(!$Factura)
				{
					$Factura="30000001";
				}
				else
				{
					$Factura= $Factura + 1;
				}
				return $Factura;
				
				}
		public function eordend($id)
		{
			$salida=array();
			$query=<<<QUERY
			select * from eorden where id_orden="$id"
QUERY;
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row;
			}
			return $salida;
			
		}
			public function dordend($id)
		{
			$salida=array();
			$query=<<<QUERY
			select * from dorden where id_orden="$id"
QUERY;
			$res=mysql_query($query,Conectar::con());
			while($row=mysql_fetch_assoc($res))
			{
				$salida[]=$row;
			}
			return $salida;
			
		}
	
}
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
?>