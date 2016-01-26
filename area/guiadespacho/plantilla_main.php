<?php
require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

require_once("select_orden.php");

	$tra=new select();
	$res3=$tra->almacen();
if($_GET["id_plantilla"])
{
	$res=$tra->plantilla($_GET["id_plantilla"]);
	$res2=$tra->dplantilla($_GET["id_plantilla"]);
	$select=count($res2);
	$id_btn="Editar Plantilla";
	$id_btn2="btn-plantillae";
}else
{
	$id_btn="Ingresar Plantilla";
	$id_btn2="btn-plantilla";

}

 
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Plantilla OT</title>
<!--
<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../../css/guia_fullcode.css"/>
<link rel="stylesheet" type="text/css" href="../../css/select2.css"/>
<link rel="stylesheet" type="text/css" href="../../css/datepicker.css"/>
<link  href="../../scripts/jquery/themes/<?=$ACTUAL_THEME?>/jquery-ui.css" rel="stylesheet" type="text/css" />
<link  href="../../scripts/jtable/themes/<?=$JTABLE_THEME?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/bootstrap.js"></script>

<script type="text/javascript" src="orden_plantilla_js.js"></script>
<script type="text/javascript" src="guia_fullcode_plantilla.js"></script>

<script type="text/javascript" src="../../js/select2.js"></script>
<script type="text/javascript" src="../../js/select2_locale_es.js"></script>
<script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.10.3.custom.js"></script>	


<script src="../../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
<script src="../../scripts/jtable/jquery.jtable.es.js" type="text/javascript"></script>

<script type="text/javascript" src="../../js/jquery-barcode.js"></script>
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

	<!-- validationEngine -->
	<script type="text/javascript" src="../../scripts/jquery/validate/jquery.validationEngine.js" ></script>
	<script type="text/javascript" src="../../scripts/jquery/validate/jquery.validationEngine-es.js" ></script>
	<link type="text/css" href="../../scripts/validate/validationEngine.jquery.css" rel="stylesheet" />

	
	<!--Barcode-->
	<script type="text/javascript" src="../../js/jquery-barcode.js"></script>

	
	<!--Dependencias personalizadas-->
	<script type="text/javascript" src="../../js/select2.js"></script>
	<script type="text/javascript" src="../../js/select2_locale_es.js"></script>
	<link   type="text/css"        href="../../css/guia_fullcode.css" rel="stylesheet" />
	<link   type="text/css"        href="../../css/select2.css" rel="stylesheet" />
	
	<!--Propias de la pagina-->
	<script type="text/javascript" src="orden_plantilla_js.js"></script>
	<script type="text/javascript" src="guia_fullcode_plantilla.js"></script>

	
	
</head>
<body class="ui-widget">
	<div id="contenedor">
    	<div id="tbl_pri">
        <center><h3>Plantilla OT</h3></center>
    	<form name="form_tbl" id="form_tbl" action="" method="post">
			<div id="cabecera" class="ui-widget-content ui-corner-all">
                	<table cellspacing="3" align="center" style="width: 100%;" cellpadding="1">
                    	<tr>
                            <td >Nombre Plantilla:</td>
							<td><input type="text" name="nplantilla" class="form-control input-sm ui-corner-all" id="nplantilla" value="<?=$res[0]["nombre"]?>"/></td> 
							<td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td >Descripción:</td>
							<td ><textarea name="dplantilla" style="resize:none;" class="form-control input-sm ui-corner-all" id="dplantilla"><?=$res[0]["descripcion"]?></textarea></td>
						</tr>
                    </table>     
			</div><!--Cabecera-->
			<div style="height: 5px;width: 100%;"></div>	
			<div class="divcabecera ui-widget-header ui-corner-all">
				<table style="text-align: center; width:100%" id="tbl_cab" class="table table-bordered table-condensed table-hover " cellspacing="2" >
                	<thead>
                    	<th width="50px;"><center>Pos</center></th>
                        <th width="115px;"><center>Codigo</center></th>
                        <th width="107px;"><center>Descripcion</center></th>
                        <th width="75px;"><center>Can</center></th>
                        <th style="display:none" width="80px;"><center>alm</center></th>
                        <th width="88px;"><center>Valor</center></th>
                    </thead>
                 </table>
			</div>
			<div id="cuerpo">
				<table align="center" id="tbl_bod" class=""  cellspacing="2">
				<tbody>
				   
				   <fieldset>
					<input type="hidden" name="ctrl_pases" id="ctrl_pases" value="<?=$select?>"/>
					<input type="hidden" name="id_edicion" id="id_edicion" value="<?=$_GET["id_plantilla"]?>"/>
				   </fieldset>
					<?php 
					$e=0;
					for($i=1;$i<55;$i++)
					{				
					?>
					
					<tr>
						<td width="50px;"><center><input style="border:none; width:100%;"  type="text"  name="posicion[]" id="" value="<?=$i*10?>" class="form-control input-sm act"/></center></td>
						<td width="113px;"><center>
							<table style="width: 100%">
							<TR>
								 <TD tyle="width: 90%"><input style="border:none;width:100%;"  type="text" name="codigo[]" id="cod_complete" value="<?=$res2[$i-1]["Codigo"]?>" class="form-control input-sm caja_cod cod cod_complete"/></TD>
								 <TD><button id="btn-codigo" class="btn btn-default btn-sm ui-corner-all bsq" type="button" >
									<span class="glyphicon glyphicon-search"></span>
									</button></TD>
							</TR>
							</table>						
						</center></td>
						<td width="190px;"><center>
						<table style="width: 100%">
						<TR>
							 <TD style="width: 90%">
								<textarea style="border:none;width: 100%; height: 30px" class="form-control input-sm span2 act" id="descri" name="descripcion[]" cols="20" rows="1" ><?=$res2[$i-1]["descripcion"]?></textarea>
								<!--<input style="border:none;width: 100%;"  type="text" name="descripcion[]"  id="descri" value="<?=$res2[$i-1]["descripcion"]?>" class="form-control input-sm span2 act"/>-->
							 </TD>
							 <TD style="width: 10%"><button id="btn-descrip" class="btn btn-default btn-sm ui-corner-all btn-descrip" type="button" >
								<span class="glyphicon glyphicon-pencil"></span>
								</button></TD>
						</TR>
						</table>						</center>
						</td>
						<td width="75px;"><center><input style="border:none;width:100%;"  type="text" name="cantidad[]"  maxlength="7" id="cantidad" value="<?=$res2[$i-1]["cantidad"]?>" class="form-control input-sm span1 cant"/></center></td>
						<td style="display:none" width="81px;"><center><select name="bodega[]" style="width:100%;" id="bodega" class="form-control input-sm bodega span2">
								
								<?php
								for($e=0;$e<sizeof($res3);$e++)
								{
								?>
								
								<option value="<?=$res3[$e]["IdAlmacen"]?>"><?=$res3[$e]["Nombre"]."     -".$res3[$e]["Descripcion"];?></option>
								<?php
								}
								?>
							   
								</select></center></td>
	
						<td style="display:none"><?=$res2[$i-1]["id_almacen"]?></td>
						<td style="display:none"></td>
						<td style="display:none"></td>
						<td style="display:none;"><input type="hidden" value="<?=$res2[$i-1]["id_dplantillaot"]?>" name="id_detalles[]" id="id_detalles"/></td>
                        <td width="80px;"><center>
							<table style="width: 100%">
							<TR>
								 <TD style="width: 90%"><input style="border:none;width: 100%;"  type="text" name="valor[]"  id="valor" value="<? 
								 if($res2)
								 {
								   echo $res2[$i-1]["valor"];
								 }else
								 {
									echo 0;
								 }
								 ?>" class="form-control valor input-sm span2 act"/></TD>
							</TR>
							</table>
							</center>
						</td>
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
				<table border="0" class="table table-condensed table-bordered" cellspacing="2">
					<tr>
						<td><button class="btn btn-primary" name="btn-cotizacion" id="<?=$id_btn2?>"  value=""><?=$id_btn?></button></td>
	
				</table>

			</div><!--Pie-->
        </form>   
        </div><!--Tbl_pri-->
    </div><!--Contenedor principal-->
    
    <!--####################################################################################################################-->
    <!--####################################################################################################################-->
    	<div id="dialog_btn-codigo" title="Productos" style="display:none;">
			<div style="width: 1200px; background-color: transparent; font-family: lucida sans unicide, tahoma; font-size: 12px;">
				<form style="margin: 0px">
					<table style="margin: 0px; height:50px">
						<tr>
							<td><p >Nombre Producto</p></td>
							<td><input type="text" name="nombreproducto" id="nombreproducto" /></td>
							<td>&nbsp;</td>
							<td><p >Incluir Inactivos</p></td>
							<td><input type="checkbox" id="inactivo" name="inactivo" value="1"/></td>
							<td>&nbsp;</td>
							<td ><button type="submit" id="btnBUSCAR" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
								<span class="ui-icon ui-icon-search"></span>
								<span class="ui-button-text">Buscar</span>
								</button>
							</td>
						</tr>
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
                        <td><textarea name="dplantilla" id="dplantilla" style="resize:none;"></textarea><td>
                    </tr>
                </table>
         </div>
</body>
</html>

<script>
$(function(){
		
		//funcion para cargar los select segun su valor id para la modificacion
		for(i=0;i<$("#ctrl_pases").val();i++)
		{
			$("select#bodega").eq(i).val($("select#bodega").eq(i).parent().parent().parent().children("td:eq(5)").text());
		}

	});
</script>

