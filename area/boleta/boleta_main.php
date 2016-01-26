<?php
require_once("../../validatesession_html.php");


require_once("../../conexion/funciones.php");
$func = new funciones();

$PERMISOS_AREABOLETA=array();
$PERMISOS_AREABOLETA=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'AREA-BOLETA');

// if (!$PERMISOS_AREABOLETA['CREAR']=='1'){

// 	$message="Boletas :: CREAR :: Acceso denegado.";
// 	print "<script>alert('$message');window.history.back();</script>";
// 	die;
	
// }


require_once("select_boleta.php");
require_once("../../conexion/conexion.php");
$tra=new select();
// $res=$tra->clientes();
//$res2=$tra->empresas();
// $res3=$tra->forma_pago();
$res5=$tra->ObtieneBoleta();
$res6=$tra->code_autocomplete();

$Empresa = $_SESSION['SESS_EMPRESA_ID'];

if (empty($_SESSION["BOL_FECHABUSQUEDA1"])) { $_SESSION["BOL_FECHABUSQUEDA1"] = date("d-m-Y");  }

/*
$query="SELECT IDEmpresa, 
      RUT, RazonSocial
      FROM empresa
      WHERE 
      empresa.IDEmpresa = '$Empresa'";
$res1 = mysql_query($query,conectar::con());
$dato = mysql_fetch_assoc($res1);
*/
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Boleta</title>

<!--
<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../../css/guia_fullcode.css"/>
<link rel="stylesheet" type="text/css" href="../../css/select2.css"/>
<link rel="stylesheet" type="text/css" href="../../css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="../../css/jquery-ui-1.10.3.custom.css"/>


<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/bootstrap.js"></script>
<script type="text/javascript" src="guia_fullcode_boleta.js"></script>
<script type="text/javascript" src="../../js/select2.js"></script>
<script type="text/javascript" src="../../js/select2_locale_es.js"></script>
<script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.10.3.custom.js"></script>
-->


	<!-- bootstrap -->
	<script src="../../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="../../css/datepicker.css"/>
	<link  href="../../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />


	<!-- jquery -->
	<script src="../../scripts/jquery/jquery.js" type="text/javascript"></script>
	<script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript" ></script>
	<script src="../../scripts/jquery/jquery-ui.js" type="text/javascript"></script>
	<link  href="../../scripts/jquery/themes/tormesol/jquery-ui.css" rel="stylesheet" type="text/css" />
	
	<!-- jtable -->
	<script src="../../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
	<script src="../../scripts/jtable/jquery.jtable.es.js" type="text/javascript"></script>
	<script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript"></script>
	<link  href="../../scripts/jtable/themes/jqueryui/jtable_jqueryui.css" rel="stylesheet" type="text/css" />
	
	<!--Barcode-->
	<script type="text/javascript" src="../../js/jquery-barcode.js"></script>

	
	<!--Dependencias personalizadas-->
	<script type="text/javascript" src="../../js/select2.js"></script>
	<script type="text/javascript" src="../../js/select2_locale_es.js"></script>
	<link   type="text/css"        href="../../css/guia_fullcode.css" rel="stylesheet" />
	<link   type="text/css"        href="../../css/select2.css" rel="stylesheet" />

	<!--Propias de la pagina-->
	<script type="text/javascript" src="guia_fullcode_boleta.js"></script>
  <script type="text/javascript" src="orden_trabajo_js.js"></script>

</head>
<body class="ui-widget">
	<div id="contenedor">
    		<div id="tbl_pri">
            <center><h3>Boleta</h3></center>
	    <form name="form_tbl" id="form_tbl" action="insert_boleta_sql.php" method="post">
		<div id="cabecera" class="ui-widget-content ui-corner-all">
            	        
                <input type="hidden" id="neto" name="neto" value="">
       			<input type="hidden" id="iva" name="iva" value="">
        		<input type="hidden" id="total" name="total" value="">
                	<table cellspacing="3" align="center" style="width: 50%;" cellpadding="1">
                    	<tr>
                            <td >Contador</td>
                            <td ><input  disabled type="text" name="contador" style="width: 100%;" class="form-control input-sm span2" id="contador" value="<?=$res5?>"/></td>
                            <td align="center">Fecha</td>
                            <td ><input type="text" name="facturacion" class="form-control input-sm span2" id="facturacion" style="width: 100%;" value="<?=date("d-m-Y")?>"/></td>
                        </tr>
                       
			</table>     
        </div><!--Cabecera-->
        <div style="height: 5px;width: 100%;"></div>
	<div class="divcabecera ui-widget-header ui-corner-all">
		
		<table style="text-align: center; width:100%" id="tbl_cab" class="table table-bordered table-condensed table-hover " cellspacing="2" >
		<thead>
                    	<th width="50px;"><center>Pos</center></th>
                        <th width="113px;"><center>Código</center></th>
                        <th width="170px;"><center>Descripción</center></th>
                        <th width="81px;"><center>Cant.</center></th>
                        <th width="81px;"><center>Bod.</center></th>
                        <th width="81px;" style="color: red;"><center>Desc.</center></th>
                        <th width="81px;"><center>Prec.<br/>Unitario</center></th>
                        <th width="81px;"><center>Prec.<br/>Total</center></th>
			<th width="3px;"></th>
                    </thead>
                 </table>
	</div>
        <div id="cuerpo">
        <table align="center" id="tbl_bod" class="" >
        <tbody>
        	   
               <fieldset>
               	<input type="hidden" name="ctrl_prec" id="ctrl_prec" value=""/>
                <input type="hidden" name="bsq" id="bsq" value=""/>
               </fieldset>
        	<?php 
			$e=0;
			for($i=1;$i<26;$i++)
			{				
			?>
         
            	<tr>
		   <td width="50px;"><center><input style="border:none; width:100%;"  type="text" disabled name="posicion[]" id="" value="<?=$i*10?>" class="form-control input-sm act"/></center></td>
                   <td width="113px;"><center><input style="border:none; width:100%;"  type="text" name="codigo[]" id="cod_complete" value="" class="form-control input-sm caja_cod cod typeahead cod_complete" data-provide="typeahead"/>

                  <button id="btn-codigo" style=" float: right; margin-top:-5.5em; " class="btn btn-default btn-sm ui-corner-all btn-codigo" type="button" >
                                    <span class="glyphicon glyphicon-search"></span>
                                    </button>


                   </center></td>
		   <td width="170px;"><center><input style="border:none;width: 100%;"  type="text" name="descripcion[]" disabled id="descri" value="" class="form-control input-sm span2 act"/></center></td>
                   <td width="81px;"><center><input style="border:none; width: 100%;"  type="text" name="cantidad[]" disabled maxlength="7" id="cantidades" value="" class="form-control input-sm span1 cant"/></center></td>
                   <td width="81px;"><center><input style="border:none;width:100%;"  type="text" name="bodega[]" disabled id="bod" value="" class="form-control input-sm span1"/></center></td>
                   <td width="81px;"><center><input style="border:none;width:100%;"  type="text" name="descuento[]" disabled id="desc" value="" class="form-control input-sm span1 desc"/></center></td>
                   <td width="81px;"><center><input style="border:none;width: 100%;" type="text" class="form-control input-sm act valo" name="precio_unitario[]" id="valor" disabled value=""/></center></td>
                   <td width="81px;"><center><input style="border:none;width: 100%;" type="text" class="form-control input-sm total act" style="border:none;" name="total_tbl[]" id="total_tbl" disabled value=""/></center></td>
                   <td style="display:none"></td>
                   <td style="display:none"></td>
                   <td style="display:none"></td>
                </tr>
            <?php
			}
			?>
            
         </tbody>
        
            </table>
                
        </div><!--Cuerpo-->
        <div id="pie">
        	<table  id="tbl_foot" border="0" class="table table-condensed table-bordered" cellspacing="2">
            	<tr>
                <td width="540px"><p><span  id="pre-load" style="display:none;">&nbsp;&nbsp;Procesando....&nbsp;&nbsp;<img src="../../img/loadingAnimation.gif"/></span></p></td>
                <td width="81px"><center><small><strong>Neto:</strong></small>&nbsp;&nbsp;0</center></td>
                <td width="81px"><center><small><strong>Iva:</strong></small>&nbsp;&nbsp;0</center></td>
                <td width="81px"><center><small><strong>Total:</strong></small>&nbsp;&nbsp;0</center></td>
                <td width="5px"></td>
                </tr>
            </table>
            <table border="0" class="table table-condensed table-bordered" cellspacing="2">
            	<tr>
                	<td><button class="btn btn-primary" name="btn-cotizacion" id="btn-cotizacion"  value="">Generar Boleta</button></td>
                </tr>
            </table>
            <div>
    			
   		 </div>
       
        </div><!--Pie-->
           </form>  
        </div><!--Tbl_pri-->
    </div><!--Contenedor principal-->




     <div id="dialog_btn-codigo" title="Productos">
        <div style="width: 1200px; background-color: transparent; font-family: lucida sans unicide, tahoma; font-size: 12px;">
        <h4>Maestro de Productos</h4>
        <div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px">
            <form style="margin: 0px">
            <table width="65%" cellspacing="2" cellpadding="4">
                <tbody>
                <tr>
                    <td width="60%">
                    <table width="100%">
                        <tbody>
                        <tr>
                            <td>
                            <h5 style="width:30px">Buscar</h5>
                            </td>

                            <td><input type="text" id="nombreproducto" name="nombreproducto" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all"></td>
                        </tr>
                        </tbody>
                    </table>
                    </td>

                    <td width="20%" align="center">
                    <table style="width:100%">
                        <tbody>
                        <tr>
                            <td style="width: 170px; text-align: right">
                            <h5>Incluir Inactivos</h5>
                            </td>

                            <td style="width: 50px; text-align: center"><input type="checkbox" name="inactivo" id="inactivo" value="1"></td>
                        </tr>
                        </tbody>
                    </table>
                    </td>

                    <td width="20%" align="center"><button style="height: 30px; width: 100px" aria-disabled="false" role="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="btnBUSCAR" type="button"><span class="ui-button-text">Buscar</span></button></td>
                </tr>
                </tbody>
            </table>
            </form>
        </div>
          <div id="jt_productos" style="width: 1200px;"></div>
        </div>
</body>
</html>

<script>
	
$('#facturacion').attr('value', '<?php echo $_SESSION["BOL_FECHABUSQUEDA1"]; ?>');

$(function(){
	//$("#scliente").select2();
	//$("#tcotizacion").select2();
	//$("#tempresa").select2(); ya no se utiliza
	//$("#fpago").select2();
    
    
    var availableTags = <?=json_encode($res6);?>;
	$(".cod_complete").autocomplete({
	    source: availableTags
    });
    //$("#fcreacion").datepicker({});
    var creacion = $('#facturacion').datepicker({
	    dateFormat: 'dd-mm-yy'
    });
    creacion.on('changeDate', function(ev) {
	    // do what you want here
	    creacion.datepicker('hide');
    });
    /*var termino=$("#ftermino").datepicker();
    		termino.on('changeDate', function(ev){
	    // do what you want here
	    termino.datepicker('hide');
	});*/

    });

    
</script>
