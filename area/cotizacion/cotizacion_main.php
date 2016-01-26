<?php
require_once("../../validatesession_html.php");


require_once("../../conexion/funciones.php");
$func = new funciones();

$PERMISOS=array();
$PERMISOS=$func->ISAUTORIZED($_SESSION['SESS_PERFILID'], 'AREA-COTIZACION');


if($_GET["id_cotizacion"])
{
    
	
	if (!$PERMISOS['MODIFICAR']=='1'){
	
		$message="Cotizacion :: MODIFICAR :: Acceso denegado.";
		print "<script>alert('$message');window.history.back();</script>";
		die;
		
	}
	
	
	$btn="btn-cotizacion-edit";
	$btncoment="Editar";
	
	
	
}else
{
    
	if (!$PERMISOS['CREAR']=='1'){
	
		$message="Cotizacion :: CREAR :: Acceso denegado.";
		print "<script>alert('$message');window.history.back();</script>";
		die;
		
	}	
	
	$btn="btn-cotizacion";
    $btncoment="";
}

require_once("select_cotizacion.php");
$id_cotizacion=$_GET["id_cotizacion"];
$tra=new select();
$res=$tra->clientes();
//$res2=$tra->empresas();
$res3=$tra->forma_pago();
$res5=$tra->ObtieneCotizacion();
$res6=$tra->code_autocomplete();
$res7=$tra->ecotizacion_datos($id_cotizacion);
$res8=$tra->dcotizacion_datos($id_cotizacion);

$Empresa = $_SESSION['SESS_EMPRESA_ID'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cotización</title>
<!--
<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../../css/guia_fullcode.css"/>
<link rel="stylesheet" type="text/css" href="../../css/select2.css"/>
<link rel="stylesheet" type="text/css" href="../../css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="../../css/jquery-ui-1.10.3.custom.css"/>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/bootstrap.js"></script>
<script type="text/javascript" src="guia_fullcode.js"></script>
<script type="text/javascript" src="../../js/select2.js"></script>
<script type="text/javascript" src="../../js/select2_locale_es.js"></script>
<script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.10.3.custom.js"></script>
-->

	<!-- bootstrap -->
	<script src="../../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
	<link  href="../../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="../../css/datepicker.css"/>
	

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
	<script type="text/javascript" src="guia_fullcode.js"></script>


</head>
<body  class="ui-widget">
	<div id="contenedor">
    		<div id="tbl_pri">
		<form name="form_tbl" id="form_tbl" action="insert_cotizacion_sql.php" method="post">
            <center><h3>Cotización</h3></center>
		<div id="cabecera" class="ui-widget-content ui-corner-all">
            	    
                <input type="hidden" id="neto" name="neto" value="<?php echo $res7[0]["Neto"]; ?>">
       			<input type="hidden" id="iva" name="iva" value="<?php echo $res7[0]["Iva"]; ?>">
        		<input type="hidden" id="total" name="total" value="<?php echo $res7[0]["Total"]; ?>">
                <input type="hidden" id="idcot" name="idcot" value="<?php echo $_GET["id_cotizacion"]; ?>" />
                	
			<table cellspacing="3" align="center" style="width: 100%;" cellpadding="1">
				<tbody>
				    <tr>
					<td style="width:70px">
					    <label for="contador">Contador</label>
					</td>
					<td  style="width:100px;">
					    <input disabled class="form-control input-sm ui-corner-all" type="text" value="<?=$res5?>" id="contador" class="span2" name="contador" style="width: 100%" />
					</td>
					<td style="width:60px;" align="center">
					    <label for="scliente">Cliente</label>
					</td>
					<td style="width:165px;">
					    
					    <select name="scliente" class="" id="scliente" style="width: 70%">
					    <option value="0">--Seleccionar--</option>
					    <?php
									for($t=0;$t<sizeof($res);$t++)
									{
									?>
					    <option value="<?php echo $res[$t]["IDCliente"]?>"><?php echo $res[$t]["Cliente"]?></option>
					    <?php
									}
									?>
					    
					    </select>
					    <button class="btn btn-default btn-sm ui-corner-all" type="button" id="opencliente">
						<span class="glyphicon glyphicon-search"></span>
					    </button>
					</td>
					<td style="width:60px;" align="center">
					    <label for="bsq_plantilla">Plantilla</label>
					</td>
					<td style="width:200px;" >
						<table>
							<tr>
								<td><input type="text" name="bsq_plantilla" class="form-control input-sm ui-corner-all" id="bsq_plantilla" value="" style="width: 100%"/></td>
								<td><button class="btn btn-default btn-sm ui-corner-all" type="button" id="bsqp">
									<span class="glyphicon glyphicon-search"></span>
								    </button></td>
								<td><button class="btn btn-default btn-sm ui-corner-all" type="button" id="bsq_pla"  >
									<span class="glyphicon glyphicon-ok"></span>
								    </button></td>
							</tr>
						</table>
					     <input type="hidden" name="oculto_pla" id="oculto_pla" value=""/>
					</td>
					<td style="width:60px;" align="center">
					    <label for="glosa">Glosa</label>
					</td>
					<td rowspan="2">
					    <textarea class="form-control input-sm ui-corner-all" value="" id="glosa" name="glosa" cols="20" rows="2" style="width:100%;"><?php echo $res7[0]["glosa"]; ?></textarea>
					</td>
				    </tr>
				    <tr>
					<td>
						<label for="tcotizacion" <?php if($_GET["id_cotizacion"]){echo "style='display:none'";}else{}  ?>>Cotizacion</label>
					</td>
					<td>
					    <select name="tcotizacion" class="span2" <?php if($_GET["id_cotizacion"]){echo "style='display:none'";}else{}  ?> id="tcotizacion" value="">
							<option  value="0">--Seleccionar--</option>
							<?php
								for($d=1;$d<7;$d++)
								{
								?>
							<option value="<?=$d*5?>"><?=$d*5?> dias</option>
							<?php
								}
								?>
					   </select>
					</td>
					<td align="center">
					    <label for="fpago">Forma de pago</label>
					</td>
					<td>
					    <select name="fpago" id="fpago" class="span2" value="0" style="width: 100%">
					    <option value="0">--Sleccionar--</option>
						<?php
						for($c=1;$c<=48;$c++)
						{
						?>
						<option value="<?=$c?>"><?=$c?> Cuotas</option>
						<?php
						}
						?>
					    </select>
					</td>
					<td align="center">
					    &nbsp;
					</td>
				    </tr>

				</tbody>
			    </table>

        </div><!--Cabecera-->
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
                        <th width="3%"></th>
						<th width="5px;"></th>
                    </thead>
                 </table>
	</div>
        <div id="cuerpo">
		<fieldset>
		 <input type="hidden" name="ctrl_prec" id="ctrl_prec" value=""/>
		 <input type="hidden" name="bsq" id="bsq" value=""/>
		</fieldset>
		<table align="center" id="tbl_bod" class=""  cellspacing="2">
        <tbody>
        	   

        	<?php 
			$e=0;
			for($i=1;$i<26;$i++)
			{				
			?>
         
            	<tr>
					<td width="50px;"><center><input style="border:none; width:100%;"  type="text" disabled name="posicion[]" id="" value="<?=$i*10?>" class="act  form-control input-sm"/></center></td>
					<td width="113px;"><center>
					<table style="width: 100%">
						<TR>
							 <TD tyle="width: 90%"><input style="border:none;width: 100%;"  type="text" name="codigo[]" id="cod_complete" value="<?=$res8[$i-1]["Codigo"]?>" class="form-control input-sm caja_cod cod cod_complete"/></TD>
							 <TD><button id="btn-codigo" class="btn btn-default btn-sm ui-corner-all btn-codigo" type="button" >
								<span class="glyphicon glyphicon-search"></span>
								</button></TD>
						</TR>
						</table>
					</center></td>
					<td width="170px;">
						<table style="width: 100%">
						<TR>
							 <TD style="width: 90%">
								<textarea style="border:none;width: 100%; height: 30px" class="form-control input-sm act" id="descri" name="descripcion[]" cols="20" rows="1" ><?=$res8[$i-1]["Descripcion"]?></textarea>
								
							 </TD>
							 <TD style="width: 10%">
								<button id="btn-descrip" class="btn btn-default btn-sm ui-corner-all btn-descrip" type="button" >
								<span class="glyphicon glyphicon-pencil"></span>
								</button></TD>
						</TR>
						</table>
					</td>
					<td width="81px;"><center><input style="border:none; width: 100%;"  type="text" name="cantidad[]" disabled maxlength="7" id="cantidad" value="<?=$res8[$i-1]["Cantidad"]?>" class="cant form-control input-sm act cantidad"/></center></td>
					<td width="81px;"><center><input style="border:none;width:100%;"  type="text" name="bodega[]" disabled id="" value="<?=$res8[$i-1]["Almacen"]?>" class="form-control input-sm act"/></center></td>
					<td width="81px;"><center><input style="border:none;width:100%;"  type="text" name="descuento[]" disabled id="" value="<?=$res8[$i-1]["Descuento"]?>" class="desc form-control input-sm act descuento"/></center></td>
					<td width="81px;"><center><input type="text" style="border:none;width: 100%;" class="precio_unitario form-control input-sm  act precio_unitario" name="precio_unitario[]" id="precio_unitario" disabled value="<?=$res8[$i-1]["Neto"]?>"/></center></td>
					<td width="81px;"><center><input type="text" class="total act form-control input-sm total_tbl " style="border:none;" name="total_tbl[]" id="total_tbl" disabled  value="<?=$res8[$i-1]["Total"]?>"/></center></td>
				    <td id="preciounitario" style="display:none"><?=$res8[$i-1]["Neto"]?></td>
					<td id="preciototal" class="total" style="display:none"><?=$res8[$i-1]["Total"]?></td>
					<td id="totalstock" style="display:none"><?=$res8[$i-1]["Cantidad"]?></td>
                    <td style="display:none;"><input type="hidden" value="<?=$res8[$i-1]["IdDCotizacion"]?>" name="id_detalles[]" id="id_detalles"/></td>
                    	<td style="width: 3%">

							<button style="width: 100%" id="btn-quitar" class="btn btn-default btn-sm ui-corner-all btn-quitar" type="button" >
							<span class="glyphicon glyphicon-trash"></span>
							</button>

					</td>
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
                <td width="81px"><center><small><strong>Neto:</strong></small>&nbsp;&nbsp;<?php echo $res7[0]["Neto"]; ?></center></td>
                <td width="81px"><center><small><strong>Iva:</strong></small>&nbsp;&nbsp;<?php echo $res7[0]["Iva"]; ?></center></td>
                <td width="81px"><center><small><strong>Total:</strong></small>&nbsp;&nbsp;<?php echo $res7[0]["Total"]; ?></center></td>
                <td width="5px"></td>
                </tr>
            </table>
            <table border="0" class="table table-condensed table-bordered" cellspacing="2">
            	<tr>
			 <td width="10%"><button type="button" class="btn btn-default" name="btn-volver" id="btn-volver"  value="">Volver</button></td>
                	<td><button type="button" class="btn btn-primary" name="btn-cotizacion" id="<?=$btn?>">Guardar Cotización</button></td>
                </tr>
            </table>
            <div>
    			<input type="hidden" name="nombrepla" id="nombrepla" value="" />
                <input type="hidden" name="descripcionpla" id="descripcionpla" value="" />
		</div>
         
        </div><!--Pie-->
         </form>  
        </div><!--Tbl_pri-->
    </div><!--Contenedor principal-->
    <div id="dialogcliente">
            <iframe id="framecliente2" src="" width="100%" height="100%"></iframe>
        </div>
        
    <div id="dialogplantilla" title="Guardar como plantilla" style="display: none;">
            <center><table>
                <tr>
                    <td><label for="nombrepla2">Nombre Plantilla:</label></td>
                    <td><input type="text" value="" name="nombrepla2" id="nombrepla2" /></td>
                </tr>
                <tr>
                    <td><label for="descripcionpla">Descripcion Plantilla:</label></td>
                    <td><textarea type="text" value="" name="descripcionpla2" id="descripcionpla2" ></textarea></td>
                </tr>
            </table></center>
        </div>
        
		<div id="plantillas-cotizacion" style="display: none;">
            <iframe id="framecliente" src="plantillacrud_main.php?seleccion=1" width="100%" height="100%"></iframe>
            <input type="hidden" id="prueba" name="prueba" />
        </div>
	 
	 
	 
    	<div id="dialog_btn-codigo" title="Productos">
        <div style="width: 1200px; background-color: transparent; font-family: lucida sans unicide, tahoma; font-size: 12px;">
		<h4>Maestro de Productos</h4>
		<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px">
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
		</div>
  		<div id="jt_productos" style="width: 1200px;"></div>
		</div>
	 
		<div id="modal1" style="display:none;">
            <textarea class="form-control input-sm " id="descripciones_dialog"   cols= "60" rows="30"  style="width: 973px; height: 300px;" ></textarea>
        </div>
	 
</body>
</html>

<script>
$(function(){
	
	$("#btn-volver").on("click", function() {

            window.history.back()

          //window.location="ordencrud_main.php";
      });
    
    //btn quitar
    quitar();
    function quitar(){
    $(".btn-quitar").on("click",function(){
        $(this).parent().parent().children("td:eq(1)").children().children().children().children().children().children().val('').attr('value','').attr('disabled','disabled');
        $(this).parent().parent().children("td:eq(2)").children().children().children().children("td:eq(0)").children().val('').attr('value','').attr('disabled','disabled');
        $(this).parent().parent().children("td:eq(2)").children().children().children().children("td:eq(1)").children().val('').attr('value','').attr('disabled','disabled');
        $(this).parent().parent().children("td:eq(3)").children().children().val('').attr('value','').attr('disabled','disabled');
        $(this).parent().parent().children("td:eq(4)").children().children().val('').attr('value','').attr('disabled','disabled');
        $(this).parent().parent().children("td:eq(5)").children().children().val('').attr('value','').attr('disabled','disabled');
        $(this).parent().parent().children("td:eq(6)").children().children().val('').attr('value','').attr('disabled','disabled');
        $(this).parent().parent().children("td:eq(7)").children().children().val('').attr('value','').attr('disabled','disabled');
        
        
        $(this).parent().parent().children("td:eq(8)").text("0");
        $(this).parent().parent().children("td:eq(9)").text("0");
        $(this).parent().parent().children("td:eq(10)").text("0");
        /* CALCULA TOTALES */
				var total_direct = 0;
				$('.total').each(function () {
					if($(this).val()==0)
					{ }
					else
					{ total_direct += Number($(this).val()); }
				});
				iva=(total_direct*19)/100;
				neto =(total_direct-iva);
				/*	var iva = parseFloat(total_direct)*0.19;*/
				$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
				$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
				$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
              
    });
    };
    
    
    
    //**************************************
    
	// valores de la edicion
    getvalor="<?php echo $_GET["id_cotizacion"];?>";
    if(getvalor=="")
    {
        
    }else
    {
    $("#contador").val(<?php echo $res7[0]["Contador"];  ?>);
    $("#scliente").val(<?php echo $res7[0]["IdCliente"];  ?>);
    $("tcotizacion").val(<?php echo $res7[0]["Tipo"]  ?>);
    $("#fpago").val(<?php echo $res7[0]["IdFormaPago"];  ?>);
    
    $(".cantidad").attr("disabled",false);
    $(".descuento").attr("disabled",false);
    $(".precio_unitario").attr("disabled",false);
    }
   
    
    
    ///////////////////////////////////////////////////////
	var availableTags = <?=json_encode($res6);?>;
	
	function include(file_path){
		var j = document.createElement("script");
		j.type = "text/javascript";
		j.src = file_path;
		document.body.appendChild(j);
	}
	
    //guardar la planilla**********************************************************
    
    $("#btn-plantilla").on("click", function(){
    
            $("#dialogplantilla").dialog("open");
    
    });
    
    //dialogo para guardar la plantilla
    	$("#dialogplantilla").dialog({
		autoOpen: false,
		width: 300,
		heigth: 300,
		position: ['middle', 20],
		show: {
			effect: "fade",
			duration: 500
		},
		hide: {
			effect: "fade",
			duration: 500
		},
		modal: true,
		open: function(ev, ui){
                      
		},
		buttons: {
            "Guardar": function() {
                $(".act").prop("disabled",false);
                $("#nombrepla").val($("#nombrepla2").val());
                $("#descripcionpla").val($("#descripcionpla2").val());
                var datasrl =$("#form_tbl").serialize();
                 
                 $.ajax({
    
					async: true,
					cache: false,
					type:"POST",
					dataType: "json",
					url: "insert_plantilla_sql.php",
                    data:datasrl,
					success: function(response) {
					   $(".act").prop("disabled",true);
					   //alert("listo");
					}
    
				});
				$("#dialogplantilla").dialog("close");
			},
			"Cerrar": function() {
				$("#dialogplantilla").dialog("close");
			}
		}
	});
    
    //abrir las plantillas
    
    $("#bsqp").on("click",function(){
       historico= $(this).parent().parent().children("td:eq(0)").children();
        $("#plantillas-cotizacion").dialog("open");
    
    });
    
    $("#plantillas-cotizacion").dialog({
		autoOpen: false,
		width: 1000,
		height: 600,
		position: ['middle', 20],
		show: {
			effect: "fade",
			duration: 500
		},
		hide: {
			effect: "fade",
			duration: 500
		},
		modal: true,
		open: function(ev, ui){
                      
		},
		buttons: {
		"Seleccionar": function() {
	
				var $frame = document.getElementById('framecliente').contentWindow.document;
				//var $grilla = $(this).parent().parent().parent().find('#jt_plantilla');
				//var $grilla = $frame.find("#jt_plantilla");
										
				var $tr_selec=$frame.getElementById("jt_plantilla");
				
				var a$=$tr_selec.getElementsByClassName("jtable-row-selected");
				
				//alert(a$.innerHTML);
				
				nombre_plantilla = $frame.getElementById('valor1').value;
				historico.val(nombre_plantilla);
				id_eplantilla = $frame.getElementById('valor2').value;
				$("#plantillas-cotizacion").dialog("close");
			
			},
			"Cerrar": function() {
				$("#plantillas-cotizacion").dialog("close");
			}
		}
	});
    
    
    $("#bsq_pla").on("click",function(){
        $.ajax({
			
			async:true,
			cache:false,
			type:"GET",
			dataType:"json",
			url:"consulta_plantilla.php?plantilla="+id_eplantilla,
			beforeSend: function () {
           },
			
			success: function(response){
				
				//alert(response);
				
				$("#tbl_bod").empty();
                $("#tbl_bod").html(response.sale);
				$("#neto").val(response.Neto);
                $("#iva").val(response.Iva);
                $("#Total").val(response.Total);
				include('guia_fullcode.js');
				
				$(".cod_complete").autocomplete({
					source: availableTags
				});
				
				/* CALCULA TOTALES */
				var total_direct = 0;
				$('.total').each(function () {
					if($(this).val()==0)
					{ }
					else
					{ total_direct += Number($(this).val()); }
				});
				iva=(total_direct*19)/100;
				neto =(total_direct-iva);
				/*	var iva = parseFloat(total_direct)*0.19;*/
				$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
				$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
				$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
				quitar();
				
                $("#plantillas-cotizacion").dialog("close");
			}
			
			});
            
        
    });
    
    //**************************************************************************
    
    $("#scliente").select2();
    $("#tcotizacion").select2();
    $("#fpago").select2();
    
    
    
	$(".cod_complete").autocomplete({
	    source: availableTags
    });
    //$("#fcreacion").datepicker({});
    var creacion = $('#fcreacion').datepicker();
    creacion.on('changeDate', function(ev) {
	    // do what you want here
	    creacion.datepicker('hide');
    });
    var termino = $("#ftermino").datepicker();
    termino.on('changeDate', function(ev) {
	    // do what you want here
	    termino.datepicker('hide');
    });

    	//clientes
	$("#dialogcliente").dialog({
		autoOpen: false,
		width: 500,
		height: 500,
		position: ['middle', 20],
		show: {
			effect: "fade",
			duration: 500
		},
		hide: {
			effect: "fade",
			duration: 500
		},
		modal: true,
		open: function(ev, ui){
                      $('#framecliente2').attr('src','../../crud/clientes_main.php');
		},
		buttons: {
			"Seleccionar": function() {
	
				var $frame = document.getElementById('framecliente').contentWindow.document;
				//var $grilla = $(this).parent().parent().parent().find('#jt_plantilla');
				//var $grilla = $frame.find("#jt_plantilla");
										
				var $tr_selec=$frame.getElementById("jt_clientes");
				
				var a$=$tr_selec.getElementsByClassName("jtable-row-selected");
				
				//alert(a$.innerHTML);
				
				nombre_plantilla = $frame.getElementById('valor1').value;
				historico.val(nombre_plantilla);
				id_eplantilla = $frame.getElementById('valor2').value;
				$("#dialogcliente").dialog("close");
			
			},
			"Cerrar": function() {
				$.ajax({
    
					async: true,
					cache: false,
					type: "GET",
					dataType: "json",
					url: "select_factura.php?action=clientes",
					success: function(response) {
						clientess = response.Options;
						$("#scliente").empty();
						for (var i = 0; i < clientess.length; i++) {
							$("#scliente").append("<option value='" + clientess[i].Value + "'>" + clientess[i].DisplayText + "</option>")
						}
    
    
					}
    
				});
				$("#dialogcliente").dialog("close");
			}
		}
	});
    
	$("#opencliente").on("click", function() {
    
		$("#dialogcliente").dialog("open");
	});

    $('form').keypress(function(e){
    if(e == 13){ 
      return false; 
    } 
	}); 
 
	$('input').keypress(function(e){ 
    if(e.which == 13){ 
      return false; 
    } 
	});
    
	$("#btn-cotizacion").on('click',function(event){
		 event.preventDefault();
		 
		 if($(".cod").val()==0 || $("#scliente").val()==0)
		 {
			 alert("Rellene los campos necesarios");
		 }
		 else
		 {
				$(".act").prop("disabled",false); 
				//trabajo con el ajax
					 //para guardar el valor del neto
				var neto1=$("#tbl_foot tr td:eq(1)").children().text().replace("Neto:","");
				var neto2=neto1.replace(/\s/g,"");
				$("#neto").val(neto2);
				var neto3=Number($("#neto").val());
				$("#neto").val(neto3);
				//para guardar el valor del iva
				var iva1=$("#tbl_foot tr td:eq(2)").children().text().replace("Iva:","");
				var iva2=iva1.replace(/\s/g,"");
				$("#iva").val(iva2);
				var iva3=Number($("#iva").val());
				$("#iva").val(iva3);
				//para guardar el valor del total
				var total1=$("#tbl_foot tr td:eq(3)").children().text().replace("Total:","");
				var total2=total1.replace(/\s/g,"");
				$("#total").val(total2);
				var total3=Number($("#total").val());
				$("#total").val(total3);
				var valores="valgo";
				if(valores=="valgo")
				{
						var datasrl =$("#form_tbl").serialize();
						//alert(datasrl);
						$.ajax({
					
								async:true,
								cache:false,
								type:"POST",
								dataType:"json",
								//url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/insert_cotizacion_sql.php",
								url:"insert_cotizacion_sql.php",
								data:datasrl,
								beforeSend: function () {
									$("#pre-load").show();
								},
								
								success: function(response){
										
										
										
										if (response=="todo") {
										    alert("Creada con exito!");
											$(".act").prop("disabled",true); 	
											window.location = 'cotizacioncrud_main.php';			//code
											return;
										}else
										{
												alert("Error: ".response);
												return;
										}
										/**/
									
								}
					
						});
				}
		
		 }//cierre del else del if de la validacion de los datos necesarios 
	});    
    
    
    $("#btn-cotizacion-edit").on('click',function(event){
		 event.preventDefault();
		 
		 if($(".cod").val()==0 || $("#scliente").val()==0)
		 {
			 alert("Rellene los campos necesarios");
		 }
		 else
		 {
				$(".act").prop("disabled",false); 
				//trabajo con el ajax
					 //para guardar el valor del neto
				var neto1=$("#tbl_foot tr td:eq(1)").children().text().replace("Neto:","");
				var neto2=neto1.replace(/\s/g,"");
				$("#neto").val(neto2);
				var neto3=Number($("#neto").val());
				$("#neto").val(neto3);
				//para guardar el valor del iva
				var iva1=$("#tbl_foot tr td:eq(2)").children().text().replace("Iva:","");
				var iva2=iva1.replace(/\s/g,"");
				$("#iva").val(iva2);
				var iva3=Number($("#iva").val());
				$("#iva").val(iva3);
				//para guardar el valor del total
				var total1=$("#tbl_foot tr td:eq(3)").children().text().replace("Total:","");
				var total2=total1.replace(/\s/g,"");
				$("#total").val(total2);
				var total3=Number($("#total").val());
				$("#total").val(total3);
				var valores="valgo";
				if(valores=="valgo")
				{
						var datasrl =$("#form_tbl").serialize();
						//alert(datasrl);
						$.ajax({
					
								async:true,
								cache:false,
								type:"POST",
								dataType:"json",
								url:"edit-cotizacion_sql.php",
								data:datasrl,
								beforeSend: function () {
									$("#pre-load").show();
								},
								
								success: function(response){
									
									//alert(response);
										    alert("Editada con exito!");
											$(".act").prop("disabled",true); 	
											window.location = 'cotizacioncrud_main.php';
											
											
		//									if (response=="todo") {
		////code
		//									return;
		//								}else
		//								{
		//										alert("Error: "+response);
		//										return;
		//								}
		//								/**/
									
								}
					
						});
				}
		
		 }//cierre del else del if de la validacion de los datos necesarios 
	});    
      $("#modal1").dialog({
		  autoOpen: false,
		  width: 1000,
		  heigth: 700,
		  position: ['middle', 20],
		  show: {
			  effect: "fade",
			  duration: 500
		  },
		  hide: {
			  effect: "fade",
			  duration: 500
		  },
		  modal: true,
		  buttons: {
			  "Cerrar": function() {
				  $tr.find("#descri").val($("#descripciones_dialog").val());
				  $(this).dialog("close");
				  $("#descripciones_dialog").val("");

			  }

		  }
	  });

	  $(".btn-descrip").on("click", function() {

		  $tr = $(this).parent().parent();
		  $("#descripciones_dialog").val($tr.find("#descri").val());
		  $("#modal1").dialog("open");
		  
	  });

    
    
});
</script>
