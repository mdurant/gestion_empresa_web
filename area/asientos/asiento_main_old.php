<?php
require_once("../../validatesession_html.php");
require_once("select_asiento.php");

$ACTUAL_THEME="tormesol";
$JTABLE_THEME="jqueryui/jtable_jqueryui.css";
$tra=new select();
$Empresa = $_SESSION['SESS_EMPRESA_ID'];

	if (empty($_SESSION["ORD_FECHABUSQUEDA1"])) { $_SESSION["ORD_FECHABUSQUEDA1"] = date("d-m-Y");  }
	if (empty($_SESSION["ORD_FECHABUSQUEDA2"])) { $_SESSION["ORD_FECHABUSQUEDA2"] = date("d-m-Y");  }


	$res=$tra->obtieneasiento();
	$res2=$tra->empresas();
	$res3=$tra->almacen();
	$res5=$tra->clientes();
	$res6=$tra->code_autocomplete();
	$id_btn="Ingresar Asiento Contable";
	$id_btn2="Ingresars";
    $fecha2=$_SESSION["ORD_FECHABUSQUEDA1"]; 
    $fecha4=$_SESSION["ORD_FECHABUSQUEDA2"]; 

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Asiento Contable</title>
<!--
<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../../css/guia_fullcode.css"/>
<link rel="stylesheet" type="text/css" href="../../css/select2.css"/>
<link rel="stylesheet" type="text/css" href="../../css/datepicker.css"/>
<link  href="../../scripts/jquery/themes/<?=$ACTUAL_THEME?>/jquery-ui.css" rel="stylesheet" type="text/css" />
<link  href="../../scripts/jtable/themes/<?=$JTABLE_THEME?>" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/bootstrap.js"></script>
<script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.10.3.custom.js"></script>	


<script src="../../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
<script src="../../scripts/jtable/jquery.jtable.es.js" type="text/javascript"></script>

<script type="text/javascript" src="../../scripts/jquery/validate/jquery.validationEngine.js" ></script>
<script type="text/javascript" src="../../scripts/jquery/validate/jquery.validationEngine-es.js" ></script>
<link href="../../scripts/validate/validationEngine.jquery.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery-barcode.js"></script>
-->

	<!-- bootstrap -->
	<script src="../../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
	<link  href="../../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="../../css/datepicker.css"/>
	

	<!-- jquery -->
	<script src="../../scripts/jquery/jquery.js" type="text/javascript"></script>
	<script src="../../scripts/jquery/jquery-ui.js" type="text/javascript"></script>
	<script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript" ></script>
    <link  href="../../scripts/jquery/themes/tormesol/jquery-ui.css" rel="stylesheet" type="text/css" />
	<!--
	
	
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	
	-->
	
		
	<!-- jtable -->
	<script src="../../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
	<script src="../../scripts/jtable/jquery.jtable.es.js" type="text/javascript"></script>
	<script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript"></script>
	<link  href="../../scripts/jtable/themes/jqueryui/jtable_jqueryui.css" rel="stylesheet" type="text/css" />

	<!-- validationEngine -->
	<script type="text/javascript" src="../../scripts/jquery/validate/jquery.validationEngine.js" ></script>
	<script type="text/javascript" src="../../scripts/jquery/validate/jquery.validationEngine-es.js" ></script>
	<link type="text/css"         href="../../scripts/jquery/validate/validationEngine.jquery.css" rel="stylesheet" />

	
	<!--Barcode-->
	<script type="text/javascript" src="../../js/jquery-barcode.js"></script>

	
	<!--Dependencias personalizadas-->
	<script type="text/javascript" src="../../js/select2.js"></script>
	<script type="text/javascript" src="../../js/select2_locale_es.js"></script>
	<link   type="text/css"        href="../../css/guia_fullcode.css" rel="stylesheet" />
	<link   type="text/css"        href="../../css/select2.css" rel="stylesheet" />
	
	<!--Propias de la pagina-->
	<script type="text/javascript" src="guia_fullcode_orden.js"></script>
	<script type="text/javascript" src="orden_trabajo_js.js"></script>
	<script type="text/javascript" src="popup_plantillas.js"></script>

</head>
<body class="ui-widget">
	<div id="contenedor">
    		<div id="tbl_pri">
            <center><h3>Asiento Contable</h3></center>
	    <form name="form_tbl" id="form_tbl" action="" method="post">
    	
			<input type="hidden" id="debe" name="debe" value="<?=$res5[$e]["debe"]?>">
			<input type="hidden" id="haber" name="haber" value="<?=$res5[$e]["haber"]?>">
			<input type="hidden" id="saldo" name="saldo" value="<?=$res5[$e]["saldo"]?>">
	
			<div id="cabecera" class="ui-widget-content ui-corner-all">

			
			    
			<table cellspacing="3" align="center" style="width: 100%;" cellpadding="1">
			    <tr>
				<td style="width:110px">Voucher Nº</td>
				<td style="width:150px;">
				    <input <?=$deshabilitar?> type="text" name="voucher" style="width: 100%" class="form-control input-sm ui-corner-all"  id="voucher" value="<?=$res?>" />
				</td>
				<td style="width:100px;padding-left: 10px" align="left">Documento</td>
				<td style="width:280px;" >
					
						<table>
							<tr>
								<td>
									<select name="clientes" id="clientes" style="width: 100%" class="form-control input-sm ui-corner-all"  value="">
									<option value="0">--Seleccionar--</option>
									<?php
									for($e=0;$e<sizeof($res5);$e++)
									{
									?>
									<option value="<?=$res5[$e]["IDCliente"]?>"><?=$res5[$e]["Cliente"]?></option>
									<?php
									}
									?>
									</select>								
								
								</td>
								<td><button class="btn btn-default btn-sm ui-corner-all" type="button" id="opencliente">
									<span class="glyphicon glyphicon-search"></span>
								    </button></td>
							</tr>
						</table>
				</td>
				<td style="width:80px;" align="center">Glosa</td>
				<td rowspan="4">
				    <textarea style="width: 100%" class="form-control input-sm ui-corner-all" id="glosa" name="glosa" cols="20" rows="6" ><?=$ord[0]["glosa"]?></textarea>
				</td>
			    </tr>
			    <tr>
				<td >Fecha Asiento</td>
				<td align="center">
				    <input style="width: 100%" class="form-control input-sm ui-corner-all" type="text" name="facturacion" id="facturacion" value="<?=$fecha2?>" />
				</td>
				
				<td align="center" class="style2">&nbsp;
				  
				  </td>
			    </tr>
			    <tr>
				<td>Fecha Contable</td>
				<td >
				    <input style="width: 100%" class="form-control input-sm ui-corner-all" type="text" name="facturacion2" id="facturacion2" value="<?=$fecha4?>" />
				</td>
				
			
			</tr>
		    </table>
		</div><!--Cabecera-->
	
			

    
        </div><!--Cabecera-->
	<div style="height: 5px;width: 100%;"></div>	

	<div class="divcabecera ui-widget-header ui-corner-all">
        <table style="text-align: center; width:100%" id="tbl_cab" class="table table-bordered table-condensed table-hover " cellspacing="2" >
        
        		<thead>
                    	<th width="34px;"><center>Pos.</center></th>
                        <th width="113px;"><center>Código</center></th>
                        <th width="200px;"><center>
                        Cuenta Contable
                        </center></th>
                        <th width="75px;"><center>
                        Debe
                        </center></th>
                        <th width="81px;" style="display: none;"><center>
                          Haber
                        </center></th>
                        <th width="80px"><center>
                        Saldo
                        </center></th>
                 </table>
		</div>
        <div id="cuerpo">
		<fieldset>
		 <input type="hidden" name="ctrl_pases" id="ctrl_pases" value="<?=$select?>"/>
		 <input type="hidden" name="id_ord" id="id_ord" value="<?=$_GET["id_asiento"];?>"/>
		</fieldset>
	    <table align="center" id="tbl_bod" class=""  cellspacing="2">
        <tbody>
        	   

        	<?php 
			$e=0;
			for($i=1;$i<55;$i++)
			{
				
				if (($accion=='crear') || ($accion=='modificar' && $ord2[$i-1]["Codigo"]=="")){
					$deshabilitar="";
				}else{ $deshabilitar="readonly"; }
				
			?>
         
            	<tr>
					<td width="34px;"><center><input style="border:none; width:100%;"  type="text"   name="posicion[]" id="posicion" value="<?=$i*10?>" class="form-control input-sm act"/></center></td>
					<td width="113px;"><center>
						<table style="width: 100%">
							<TR>
								 <TD style="width: 100%"><input <?=$deshabilitar?> style="border:none;width: 100%;"  type="text" name="codigo[]" id="cod_complete" value="<?=$ord2[$i-1]["Codigo"]?>" class="form-control input-sm caja_cod cod cod_complete"/></TD>
								 <TD ><?php if ($deshabilitar==""){ ?>
									<button id="btn-codigo" class="btn btn-default btn-sm ui-corner-all btn-codigo" type="button" >
									<span class="glyphicon glyphicon-search"></span>
									</button><?php } ?>
								 </TD>
							</TR>
						</table>
						</center>
					</td>
					<td width="200px;"><center>
						<table style="width: 100%">
						<TR>
							 <TD style="width: 90%">
								<textarea style="border:none;width: 100%; height: 30px" class="form-control input-sm act" id="descri" name="descripcion[]" cols="20" rows="1" ><?=$ord2[$i-1]["descripcion"]?></textarea>
								<!--<input style="border:none;width: 100%;"  type="text" name="descripcion[]"  id="descri" value="<?=$ord2[$i-1]["descripcion"]?>" class="form-control input-sm span2 act"/>-->
							 </TD>
							 <TD style="width: 10%"><button id="btn-descrip" class="btn btn-default btn-sm ui-corner-all btn-descrip" type="button" >
								<span class="glyphicon glyphicon-pencil"></span>
								</button></TD>
						</TR>
						</table>
					</center>
					</td>
					<td width="75px;"><center><input style="border:none;width:100%;"  type="text" id="cantidades" name="cantidad[]"  maxlength="7" id="" value="<?=$ord2[$i-1]["cantidad"]?>" class="form-control input-sm cant"/></center></td>
					<td width="81px;" style="display: none;"><center><input type="hidden" name="bodega[]" id="bodega" value="1" /></center></td>
					<td style="display:none"><?=$ord2[$i-1]["id_almacen"]?></td>
					<td style="display:none;"><input type="hidden" value="<?=$ord2[$i-1]["id_dorden"]?>" name="id_detalles[]" id="id_detalles"/></td>
					<td width="80px;"><center>
						<table style="width: 100%">
						<TR>
							 <TD style="width: 90%"><input style="border:none;width: 100%;"  type="text" name="valor[]"  id="valor" value="<? 
								if($ord2[$i-1]["valor"])
								{
								   echo $ord2[$i-1]["valor"];
								}else
								{
									echo 0;
								}
							 ?>" class="form-control valor input-sm span2 act"/></TD>
						</TR>
						</table>
						</center>
					</td>
					<td width="80px;"><center><input type="text" class="total form-control input-sm " style="border:none;" name="total_tbl[]" id="total_tbl" readonly value="<?=($ord2[$i-1]["valor"]*$ord2[$i-1]["cantidad"])?>"/></center></td>
					<td style="width: 3%">

							<button style="width: 100%" id="btn-quitar" class="btn btn-default btn-sm ui-corner-all btn-quitar" type="button" >
							<span class="glyphicon glyphicon-trash"></span>
							</button>

					</td>
				    <td id="preciounitario" style="display:none"></td>
					<td id="preciototal" style="display:none"></td>
					<td id="totalstock" style="display:none"></td>					
										
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
                <td width="81px"><center><small><strong>Total Neto:</strong></small>&nbsp;&nbsp;0</center></td>
                <td width="5px"></td>
                </tr>
            </table>			
            <table border="0" class="table table-condensed table-bordered" cellspacing="2">
            	<tr>
                	<td width="10%"><button type="button" class="btn btn-default" name="btn-volver" id="btn-volver"  value="">Volver</button></td>
                	<td width="10%" align="left"><button type="button" class="btn btn-primary" name="<?=$id_btn2?>" id="<?=$id_btn2?>"  value=""><?=$id_btn?></button></td>
                </tr>

            </table>

        
			</div><!--Pie-->
		 
          </form>
		
        </div><!--Tbl_pri-->
		
    </div> <!--Contenedor principal-->
    
    <!--####################################################################################################################-->
    <!--####################################################################################################################-->
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
        
          <!--####################################################################################################################-->
    <!--####################################################################################################################-->
    	<div id="dialog2" style="display:none" title="Calculo de Productos">
        <table>
        	<tr>
            	<td><label>Ultimo Precio:&nbsp;</label></td>
                <td><input type="text" disabled id="old" class="span2" value=""/></td>
                <td><label>&nbsp;&nbsp;% Utilidad: &nbsp;</label></td>
                <td><input type="text" disabled id="old2" class="span2" value=""/></td>
            </tr>
            <tr>
            	<td><label>Nuevo Precio:&nbsp;</label></td>
                <td><input type="text"  id="news" class="span2" value=""/></td>
                <td><label>&nbsp;&nbsp;% Utilidad: &nbsp;</label></td>
                <td><input type="text" disabled id="news2" class="span2" value=""/></td>
            </tr>
        </table>
        </div>
        
        <!--*******************************************************************************************-->
        <div id="dialog3" title="Crear Plantilla" style="display:none;">
            	<table>
                    <tr>
                    	<td><label>Nombre Plantilla:</label></td>
                        <td><input type="text" name="nplantilla" id="nplantilla" value=""/></td>
                    </tr>
                    <tr>
                    	<td><label>Descripción:</label></td>
                        <td><textarea name="dplantilla" id="dplantilla" style="width: 973px; height: 139px;"></textarea><td>
                    </tr>
                </table>
 			   
         </div>
         
         <!--*******************************************************************************************-->
        <div id="dialog4" title="Seleccionar Plantilla" style="display:none;">
                    <h3>Gestion de Plantilla OT</h3>
            <div style="width: 1200px; background-color: transparent; font-family: lucida sans unicide, tahoma; font-size: 12px;">
                <form id="yo" style="margin: 0px">
                        <table style="margin: 0px; heigth:50px">
                        <tr>
                        <td><p >Busqueda:</p></td>
                        <td><input class="ui-corner-all" type="text" name="plantillas" id="plantillas" /></td>
                        <td>&nbsp;</td>
                        <td>
                        <button type="submit" id="cargar" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
                        <span class="ui-icon ui-icon-search"></span>
                        <span class="ui-button-text">Buscar</span>
                        </button>
                        </td>
                        </tr>
                        </table>
                </form>
            </div>
            <div id="jt_plantillaot" style="width: 1200px;"></div>
        </div>
        
        <div id="modal1" style="display:none;">
            <textarea class="form-control input-sm " id="descripciones_dialog"   cols= "60" rows="30"  style="width: 973px; height: 300px;" ></textarea>
        </div>
        <div id="dialogcliente" style="display:none;">
            <iframe src="../../crud/clientes_main.php" width="100%" height="100%"></iframe>
        </div>
</body>
</html>

<script>
    
   



  $(function() {
    

	  $("#btn-volver").on("click", function() {

			window.history.back()
	  
		  //window.location="ordencrud_main.php";
	  });	    
    
  /*
  		  $('#descripciones').keypress(function(event) {

  				//  if (event.keyCode == 10 || event.keyCode == 13) {
  				if (event.keyCode == 10 ) {
  						  event.preventDefault();
  						  return false;
  				  }

  		  });/**/
  /*
  		  $('#form_tbl').keypress(function(event) {

  				  if (event.keyCode == 10 || event.keyCode == 13) {
  						  event.preventDefault();
  						  return false;
  				  }

  		  });*/
  /*
  		  $('#yo').keypress(function(event) {

  				  if (event.keyCode == 10 || event.keyCode == 13) {
  						  event.preventDefault();
  						  return false;
  				  }

  		  });
  */



	  $("#tempresa").val("<?=$ord[0]['id_empresa']?>");
	  $("#clientes").val("<?=$ord[0]['id_cliente']?>");
	  

	  for (i = 0; i < $("#ctrl_pases").val(); i++) {
		  $("select#bodega").eq(i).val($("select#bodega").eq(i).parent().parent().parent().children("td:eq(5)").text());
	  }


	  //trabajo con el nuevo modal



	  //clientes
	  $("#dialogcliente").dialog({
		  autoOpen: false,
		  width: 1000,
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
		  buttons: {
			  "Cerrar": function() {
				  $.ajax({

					  async: true,
					  cache: false,
					  type: "GET",
					  dataType: "json",
					  url: "select_orden.php?action=clientes",
					  success: function(response) {
						  clientess = response.Options;
						  $("#clientes").empty();
						  for (var i = 0; i < clientess.length; i++) {
							  $("#clientes").append("<option value='" + clientess[i].Value + "'>" + clientess[i].DisplayText + "</option>")
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


	  //Calcular el total de los valores

	  function calcular_total() {
		  var importe_total = 0
		  $(".valor").each(

		  function(index, value) {
			  importe_total = importe_total + eval($(this).val());
		  });

	  }
        
		
		//validar para cliente
        idcliente = '<?=$ord[0]["id_cliente"]?>';
		
        if(idcliente=='')
        {
            
        }else
        {
            $("#clientes").val(idcliente);
        }
        
		
     
  });
  
  calcular_total();

</script>
