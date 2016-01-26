<?php
require_once("../../validatesession_html.php");
require_once("select_orden.php");

$ACTUAL_THEME="tormesol";
$JTABLE_THEME="jqueryui/jtable_jqueryui.css";
$tra=new select();


    if (empty($_SESSION["ORD_FECHABUSQUEDA1"])) { $_SESSION["ORD_FECHABUSQUEDA1"] = date("d-m-Y");  }
    if (empty($_SESSION["ORD_FECHABUSQUEDA2"])) { $_SESSION["ORD_FECHABUSQUEDA2"] = date("d-m-Y");  }

$accion="";
$deshabilitar="";

if($_GET["id_orden"])
{

    $accion="modificar";
    $deshabilitar="readonly";

    date_default_timezone_set("Chile/Continental");
    $ord=$tra->eordend($_GET["id_orden"]);
    $ord2=$tra->dordend($_GET["id_orden"]);
    $res=$ord[0]["contador"];
    $fecha1=$ord[0]["fecha_ingreso"];
    $fecha2=date("d-m-Y",strtotime($fecha1));
    $fecha3=$ord[0]["fecha_entrega"];
    $fecha4=date("d-m-Y",strtotime($fecha3));
    $select=count($ord2);
    $traba=$tra->trabajadores();

    //echo $salidas[0]["IDEmpresa"];
    $res3=$tra->almacen();
    $res5=$tra->clientes();
    $proy=$tra->proyecto();
    $mot=$tra->motivoguia();
    $quien=$tra->quien_autoriza();
    $traba=$tra->trabajadores();
    $res6=$tra->code_autocomplete();
    $id_btn="Editar Guia Despacho";
    $id_btn2="Editars";
}else
{

    $accion="crear";

    $query="SELECT
    IDEmpresa,
    RUT, RazonSocial
    FROM empresa
    WHERE
    empresa.IDEmpresa = '$Empresa'";
    $res9 = mysql_query($query,conectar::con());
    while($dato=mysql_fetch_assoc($res9))
    {
          $salidas[]=$dato;
    }
    $res=$tra->ObtieneGuia();
    $res2=$tra->empresas();
    $res3=$tra->almacen();
    $res5=$tra->clientes();
    $traba=$tra->trabajadores();
    $res6=$tra->code_autocomplete();
    $proy=$tra->proyecto();
    $mot=$tra->motivoguia();
    $quien=$tra->quien_autoriza();
    $id_btn="Ingresar Guia Despacho";
    $id_btn2="Ingresars";
    $fecha2=$_SESSION["ORD_FECHABUSQUEDA1"];
    $fecha4=$_SESSION["ORD_FECHABUSQUEDA2"];
}



?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Generar Guía Despacho</title>
    <!-- bootstrap -->
    <script src="../../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <link  href="../../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../../css/datepicker.css"/>

    <!-- jquery -->
    <script src="../../scripts/jquery/jquery.js" type="text/javascript"></script>
    <script src="../../scripts/jquery/jquery-ui.js" type="text/javascript"></script>
    <script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript" ></script>
    <link  href="../../scripts/jquery/themes/tormesol/jquery-ui.css" rel="stylesheet" type="text/css" />
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
            <center><h3>Generar Guía Despacho</h3></center>
        <form name="form_tbl" id="form_tbl" action="" method="post">

            <input type="hidden" id="total" name="total" value="<?=$res5[$e]["total"]?>">

            <div id="cabecera" class="ui-widget-content ui-corner-all">

            <table cellspacing="3" align="center" style="width: 100%;" cellpadding="1">
                <tr>
                <td style="width:110px"><label>Contador</label></td>
                <td style="width:150px;">
                    <input <?=$deshabilitar?>  disabled type="text" name="contador" style="width: 100%" class="form-control input-sm ui-corner-all"  id="contador" value="<?=$res?>" />
                </td>
                <td style="width:100px;" align="left"><label>Cliente</label></td>
                <td style="width:280px;" >

                        <table>
                            <tr>
                                <td style="width:280px;">
                                    <input type="text" name="cliente" style="width:100%" class="form-control input-sm ui-corner-all" id="cliente" disabled>
                                </td>
                                
                            </tr>
                        </table>
                </td>
                <td style="width:80px;" align="center"><label>Glosa</label></td>
                <td rowspan="4">
                    <textarea style="width: 100%" class="form-control input-sm ui-corner-all" id="glosa" name="glosa" cols="20" rows="6" ><?=$ord[0]["glosa"]?></textarea>
                </td>
                </tr>
                <tr>
                <td><label>Folio Nº</label></td>
                <td align="center">
                    <input style="width: 100%" class="form-control input-sm ui-corner-all" type="text" name="folio" id="folio"  />
                </td>
                <td ><?php if ($accion=='crear'){ ?><label>Proyecto</label><?php } ?></td>
                <td><?php if ($accion=='crear'){ ?>
                    <table>
                        <tr>
                        <select name="proyecto" id="proyecto" style="width: 100%" class="span2"  value="">
                            <option value="0">--Seleccionar--</option>
                            <?php
                            for($a=0;$a<sizeof($proy);$a++)
                                    {
                                    ?>
                                    <option value="<?=$traba[$a]["id_proyecto"]?>"><?=strtoupper($proy[$a]["nombre_proyecto"])?></option>
                                    <?php
                                    }
                                    ?>

                   </select>
                        </tr>
                    </table>
                    <input type="hidden" name="oculto_pla" id="oculto_pla" value=""/>
                    <?php } ?>
                </td>
                <td align="center" class="style2">
                    &nbsp;
                </td>
                </tr>
                <tr>
                <td><label>Fecha Guia</label></td>
                <td >
                    <input style="width: 100%" class="form-control input-sm ui-corner-all" type="text" name="facturacion" id="facturacion" value="<?=$fecha4?>" />
                </td>
                <td><label>Motivo Guia</label></td>
                <td>
                    <select name="motivo" id="motivo" style="width: 100%" class="span2"  value="">
                        <option value="0">--Seleccionar--</option>
                        <?php
                       for($a=0;$a<sizeof($mot);$a++)
                        {
                        ?>
                        <option value="<?=$mot[$a]["IDMotivo"]?>"><?=strtoupper($mot[$a]["nombre_motivo"])?></option>
                        <?php
                        }
                        ?>

                   </select>
                </td>
                <td align="center" >&nbsp;</td>
            <tr>

                <td ><label>Rut Chofer</label></td>
                <td >
                <input id="rut_chofer" class="form-control input-sm ui-corner-all" type="text" value="" name="rut_chofer" style="width: 100%">

                </td>
				
				<td ><label>Nombre Chofer</label></td>
                <td >
                <input id="nombre_chofer" class="form-control input-sm ui-corner-all" type="text" value="" name="nombre_chofer" style="width: 100%">
                </td>
                <!--
                <td style="padding-left: 10px" display="none">Vehículo/Pieza</td>
                <td>
                <input style="width: 100%" class="form-control input-sm ui-corner-all" type="text" name="vehiculo" id="vehiculo" value="<?=$ord[0]["vehiculo_pieza"]?>"/>
                </td>
-->
            </tr>
            <tr>
                <td><label>Placa Patente</label></td>
                <td><input id="placa_patente" class="form-control input-sm ui-corner-all" type="text" value="" name="placa_patente" style="width: 100%"></td>
                <td><label>Autorizado Por:</label></td>
                <td >
                <select name="autorizado" id="autorizado" style="width: 100%" class="span2"  value="">
                    <option value="0">--Seleccionar--</option>
                    <?php
                    for($a=0;$a<sizeof($quien);$a++)
                    {
                    ?>
                    <option value="<?=$quien[$a]["id_trabajador"]?>"><?=$quien[$a]["datos_trabajador"]?></option>
                    <?php
                    }
                    ?>
                    </select>

                </td>
                
            </tr>
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
                        <th width="200px;"><center>Descripción</center></th>
                        <th width="75px;"><center>Cant.</center></th>
                        <th width="81px;" style="display: none;"><center>Bod.</center></th>
                        <th width="80px"><center>Valor</center></th>
                        <th width="80px"><center>Sub-Total</center></th>
                        <th width="3%"></th>
                        <th width="2%"></th>
                    </thead>
                 </table>
        </div>
        <div id="cuerpo">
        <fieldset>
         <input type="hidden" name="ctrl_pases" id="ctrl_pases" value="<?=$select?>"/>
         <input type="hidden" name="id_ord" id="id_ord" value="<?=$_GET["id_orden"];?>"/>
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
                    <td width="34%" align="right" style="text-align:right;"><button type="button" class="btn btn-success" id="btn_plantilla" value="">Guardar Como Plantilla</button></td>
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
       </body>
</html>
<script>

  $(function() {

    $("#proyecto").select2();
    $("#motivo").select2();
    $("#autorizado").select2();

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
     // $("#clientes").val("<?=$ord[0]['id_cliente']?>");


      for (i = 0; i < $("#ctrl_pases").val(); i++) {
          $("select#bodega").eq(i).val($("select#bodega").eq(i).parent().parent().parent().children("td:eq(5)").text());
      }


      //trabajo con el nuevo modal

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
