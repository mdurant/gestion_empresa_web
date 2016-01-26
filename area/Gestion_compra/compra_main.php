<?php
require_once("../../validatesession_html.php");

require_once("select_compra.php");

$tra=new select();
// $res=$tra->clientes();
//$res2=$tra->empresas();
$res3=$tra->almacen();
$res5=$tra->proveedores();
$res6=$tra->code_autocomplete();

$Empresa = $_SESSION['SESS_EMPRESA_ID']; //$_GET['IDEmpresa'];
/*
$query="SELECT IDEmpresa, 
      RUT, RazonSocial
      FROM empresa
      WHERE 
      empresa.IDEmpresa = '$Empresa'";
$res1 = mysql_query($query,conectar::con());
$dato = mysql_fetch_assoc($res);
*/
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Gestion Compras</title>

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
	<script type="text/javascript" src="guia_fullcode_compra.js"></script>
	<script type="text/javascript" src="compra_js.js"></script>
	

</head>
<body class="ui-widget">
	<div id="contenedor">
    		<div id="tbl_pri">
            <center><h3>Gestion de Compra</h3></center>
	    <form name="form_tbl" id="form_tbl" action="" method="post">
    	    <div id="cabecera" class="ui-widget-content ui-corner-all">
            	        
                <input type="hidden" id="neto" name="neto" value="">
       			<input type="hidden" id="iva" name="iva" value="">
        		<input type="hidden" id="total" name="total" value="">
				
                	<table cellspacing="3" align="center" style="width: 100%;" cellpadding="1">
                    	<tr>
                            <td align="center"><label for="contador">Folio Compra</label></td>
                            <td ><input  disabled type="text" name="contador" class="form-control input-sm ui-corner-all span2" id="contador" value="<?=$tra->ObtieneCompras()?>"/></td>
                            <td align="center"><label for="proveedores">Proveedores</label></td>
                            <td ><select style="width: 85%;" name="proveedores" id="proveedores" class="span2" value="">
								<option value="0">--Seleccionar--</option>
								<?php
								for($e=0;$e<sizeof($res5);$e++)
								{
								?>
								<option value="<?=$res5[$e]["IDsuppliers"]?>"><?=$res5[$e]["Suppliers"]?></option>
								<?php
								}
								?>
							   
								</select>
								<button class="btn btn-default btn-sm ui-corner-all" type="button" id="opens">
								   <span class="glyphicon glyphicon-search"></span>
								</button>
							</td>
                            <td>&nbsp;</td>
                            <td style="width: 300px;">&nbsp;</td>
                            
                        </tr>
                        <tr>
                            <td align="center"><label for="folf">Folio Factura</label></td>
                            <td align="center"><input type="text" name="folf" class="form-control input-sm span2" id="folf" value=""/></td>
                            <td align="center"><label for="facturacion">Fecha</label></td>
                            <td align="center"><input type="text" name="facturacion" class="form-control input-sm span2" id="facturacion" value="<?=date("d-m-Y")?>"/></td>
                        </tr>
                    </table>
			
        </div><!--Cabecera-->
		<div style="height: 5px;width: 100%;"></div>
			<div class="divcabecera ui-widget-header ui-corner-all">
			
			<table style="text-align: center; width:100%" id="tbl_cab" class="table table-bordered table-condensed table-hover " cellspacing="2" >
			<thead>
							<th width="50px;"><center>Pos</center></th>
							<th width="113px;"><center>Codigo</center></th>
							<th width="160px;"><center>Descripcion</center></th>
							<th width="75px;"><center>Can</center></th>
							<th width="81px;"><center>alm</center></th>
							<th width="81px;"><center>Prec<br/>Compra</center></th>
							<th width="81px;"><center>Precio<br/>Venta</center></th>
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
				for($i=1;$i<55;$i++)
				{				
				?>
         
					<tr>
					   <td width="50px;"><center><input style="border:none; width:100%;"  type="text"  name="posicion[]" id="" value="<?=$i*10?>" class="form-control input-sm act"/></center></td>
					   <td width="113px;"><center>
							<table >
							<TR>
							 <TD><input style="border:none;width:100%;"  type="text" name="codigo[]" id="cod_complete" value="" class="form-control input-sm caja_cod cod cod_complete"/></TD>
							 <TD><button class="btn btn-default btn-sm ui-corner-all bsq" type="button" >
										 <span class="glyphicon glyphicon-search"></span>
										 </button></TD>
							</TR>
							</table>
							</center>
						</td>
						<td width="160px;"><center><input style="border:none;width:100%;"  type="text" name="descripcion[]"  id="" value="" class="form-control input-sm span2 act"/></center></td>
						<td width="75px;"><center><input style="border:none;width:100%;"  type="text" name="cantidad[]"  maxlength="7" id="" value="" class="form-control input-sm span1 cant"/></center></td>
						<td width="81px;"><select name="bodega[]" style="width: 81px;width:100%;" id="bodega" class="form-control input-sm span2" value="">
								<option value="0">--Seleccionar--</option>
								<?php
								for($e=0;$e<3;$e++)
								{
								?>
								<option value="<?=$res3[$e]["IdAlmacen"]?>"><?=$res3[$e]["Nombre"]."     -".$res3[$e]["Descripcion"];?></option>
								<?php
								}
								?>
								</select>
						</td>
					   <td width="81px;"><center><input type="text" style="border:none; width:100%;" class="form-control input-sm act compra" name="precio_compra[]" id="precio_compra"  value="0"/></center></td>
					   <td width="81px;"><center>
							<table>
							<TR>
							 <TD><input type="text" class="form-control input-sm total act" style="border:none; width:100%;" name="precio_venta[]" id="precio_venta"  value=""/></TD>
							 <TD><button class="btn btn-default btn-sm ui-corner-all bqs_calc" type="button" >
										 <span class="glyphicon glyphicon-usd"></span>
										 </button></TD>
							</TR>
							</table></center>
						</td>
					    <td style="display:none"><input type="hidden" class="precios" id="tot_calculo" name="tot_calculo" value="0" /></td>
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
            <table border="0" class="table table-condensed table-bordered" cellspacing="2">
            	<tr>
                	<td><button class="btn btn-primary" name="btn-cotizacion" id="btn-cotizacion"  value="">Ingresar Compra</button></td>
                     <td >
						<table align="right">
							<tr>
								<td style="vertical-align: middle;">
									<label for= "tot">Total Factura:</label> 
								</td>
								<td>
									<input disabled="true" type="text" name="tot" id="tot" value="0" style="width: 150px" class="form-control input-sm"/>
								</td>
							</tr>
						</table>
					    <input type="hidden" id="tot_2" name="tot_2" />
					</td>
				</tr>
            </table>
            <div>
    			
   		 </div>
         
        </div><!--Pie-->
         </form>  
        </div><!--Tbl_pri-->
    </div><!--Contenedor principal-->
    
    <!--####################################################################################################################-->
    <!--####################################################################################################################-->
    	<div id="dialog" title="Productos">
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
        
          <!--####################################################################################################################-->
    <!--####################################################################################################################-->
    	<div id="dialog2" style="display:none" title="Calculo utilidad de venta">
        <table>
        	<tr>
            	<td><label>Ultimo Precio Compra</label><input type="text" disabled id="ultimo_compra" class="form-control input-sm ui-corner-all" value=""/></td>
                <td><label>Nuevo Precio Compra</label><input type="text"  id="nuevo_compra" class="form-control input-sm ui-corner-all" value=""/></td>
			</tr>

            <tr>
				<td><label>Ultimo % Utilidad</label><input type="text" disabled id="old2" class="form-control input-sm ui-corner-all" value=""/></td>
				<td><label>Nuevo % Utilidad</label><input type="text" disabled id="news2" class="form-control input-sm ui-corner-all" value=""/></td>
			</tr>
			<tr>
            	<td><label>Ultimo Precio Venta</label><input type="text" disabled id="old" class="form-control input-sm ui-corner-all" value=""/></td>
                <td><label>Nuevo Precio Venta</label><input type="text"  id="news" class="form-control input-sm ui-corner-all" value=""/></td>
			</tr>
        </table>
        </div>
        
        
        <!--El Iframe-->
        <div id="dialogo_proveedores">
            <iframe id="frameproveedores" src="" width="100%" height="100%"></iframe>
        </div>
</body>
</html>
	

<script>
	
function calcular_total() {
	var importe_total = 0
	$(".precios").each(

	function(index, value) {
		importe_total = importe_total + eval($(this).val());
	});
	$("#tot").val(importe_total);
	$("#tot_2").val(importe_total);
}	
	

$(function() {
	

$(".cant").on("keyup",function(){
   dos= $(this).val();
   uno= $(this).parent().parent().parent().children("td:eq(5)").children().children().val();
    tot_cant_ot=($(this).val()*$(this).parent().parent().parent().children("td:eq(5)").children().children().val());
    //$(this).parent().parent().parent().children("td:eq(6)").children().children().children().children().children("td:eq(0)").children().val(tot_cant_ot);
    $(this).parent().parent().parent().children("td:eq(7)").children().val(tot_cant_ot);
    calcular_total();
});
$(".compra").on("keyup",function(){
    $(this).val();
    $(this).parent().parent().parent().children("td:eq(3)").children().children().val();
    tot_cant_ot_2=($(this).parent().parent().parent().children("td:eq(3)").children().children().val()*$(this).val());
    $(this).parent().parent().parent().children("td:eq(7)").children().val(tot_cant_ot_2);
    calcular_total();
});

	$("#dialogo_proveedores").dialog({
		autoOpen: false,
		width: 1300,
		height: 500,
		position: 'top',
		show: {
			effect: "fade",
			duration: 500
		},
		hide: {
			effect: "fade",
			duration: 500
		},
		open: function(ev, ui) {
			$('#frameproveedores').attr('src', '../../crud/proveedores_main.php');
		},

		modal: true,
		buttons: {
			"Cerrar": function() {
				$(this).dialog("close");
				$.ajax({

					async: true,
					cache: false,
					type: "GET",
					dataType: "json",
					url: "compra_sql.php?action=proveedores",
					success: function(response) {
						Prove = response.Options;
						$("#proveedores").empty();
						for (var i = 0; i < Prove.length; i++) {
							$("#proveedores").append("<option value='" + Prove[i].Value + "'>" + Prove[i].DisplayText + "</option>")
						}


					}

				});

			}
		}
	});

	$("#opens").on("click", function() {
		$("#dialogo_proveedores").dialog("open");

	});
/*
    $(".precios").on("keyup", function(){
		//vallor=parseFloat($(this).val());
		     tu=parseFloat($(this).val());
    });
    $(".precios").on("focusout", function(){
	if($("#tot").val()=="0")
	{
	    too=parseFloat($("#tot").val());
		tet=parseFloat(tu + too);
		 $("#tot").val(tet);
	}else
	{
		too=parseFloat($("#tot").val());
		tet=parseFloat(tu + too);
		 $("#tot").val(tet);
	       //  vallor=0;
	}

    });
    */

		$('#btnBUSCAR').on('click', function(e) {
				e.preventDefault();
				$('#jt_productos').jtable('load', {
				  nombreproducto: $('#nombreproducto').val(),
				  inactivo: $('#inactivo').val()
				});
		});	
	
	
	$(".precios").on("focusout", function() {

		calcular_total();
	});



});

</script>
