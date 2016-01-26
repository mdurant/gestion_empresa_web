<?php
require_once("../../validatesession_html.php");

require_once("select_compra_edit.php");
require_once("../../conexion/conexion.php");



$tra=new select();
$res=$tra->proveedores();
$res5=$tra->ObtieneCompra();
$res6=$tra->code_autocomplete();
$res7=$tra->empresas();
$res8=$tra->forma_pago();


$Empresa = $_SESSION['SESS_EMPRESA_ID'];

    if (empty($_SESSION["ORD_FECHABUSQUEDA1"])) { $_SESSION["ORD_FECHABUSQUEDA1"] = date("d-m-Y");  }
    if (empty($_SESSION["ORD_FECHABUSQUEDA2"])) { $_SESSION["ORD_FECHABUSQUEDA2"] = date("d-m-Y");  }

$accion="";
$deshabilitar="";

?>

<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>Factura de Compra</title>
<!--
<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../../css/guia_fullcode.css"/>
<link rel="stylesheet" type="text/css" href="../../css/select2.css"/>
<link rel="stylesheet" type="text/css" href="../../css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="../../css/jquery-ui-1.10.3.custom.css"/>

<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/bootstrap.js"></script>


<script type="text/javascript" src="../../js/select2.js"></script>
<script type="text/javascript" src="../../js/select2_locale_es.js"></script>
<script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/jquery-ui-1.10.3.custom.js"></script>-->

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
    <link type="text/css" href="../../css/select2.css" rel="stylesheet"/E>

    <!--Propias de la pagina-->
    <script type="text/javascript" src="guia_netcode_compra_edit.js"></script>

    <script>

    $(function(){


      Iv  = 0;
      Ne  = 0;
      To = 0;

        var creacion = $('#facturacion').datepicker();

        function calcular_totales() {
            
            //funcion para el total
                //var total_valor=parseFloat($(".prec").val());
                
                var total_direct = 0;
                $('.total').each(function () {
                    if($(this).val()==0)
                    {
                    }else
                    {
                        //sumando=parseFloat($(this).text()).toFixed(2);
                
                        total_direct += Number($(this).val());      
                    }
                });
                //iva=(total_direct*19)/100;
                iva = total_direct - (total_direct / 1.19);
                neto = (total_direct - iva);
            /*  var iva = parseFloat(total_direct)*0.19;
                $("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
                $("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
                $("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
                $("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
                $("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
            

        }

        $.ajax({
            
            async:true,
            cache:false,
            type:"POST",
            dataType:"json",
            url:"./select_compra_edit.php?action=traerDatos&id=<?=$_GET['id_compra']?>",
                     
            success: function(response){

                //alert(response[0].IdEGuiaDespacho);
               
                $("#contador").val(response[0].contador);
                $("#folio").val(response[0].folio_factura);                
                $('#facturacion').datepicker( "option", "dateFormat", "yy-mm-dd");
                $("#facturacion").datepicker( "setDate", response[0].fecha_ingreso.substring(0,10).trim());
                $('#facturacion').datepicker( "option", "dateFormat", "dd-mm-yy");
                $("#sproveedor").val(response[0].id_provedores);
                $("#ordencompra").val(response[0].orden_compra);
                $("#guiadespacho").val(response[0].guia_despacho);
                $("#sempresa").val(response[0].id_empresa);
                $("#spago").val(response[0].forma_pago);                
                $("#glosa").val(response[0].glosa);
                

                }
            
        });



        $.ajax({
            
            async:true,
            cache:false,
            type:"POST",
            dataType:"json",
            url:"./select_compra_edit.php?action=traerDatos2&id=<?=$_GET['id_compra']?>",
                     
            success: function(response){

                //alert(response[0].IdEGuiaDespacho);
                for (var i = 0; i <=response.length; i++) {
                    
                    

                        $("#posicion"+response[i].posicion).parent().parent().parent().find("#idepos").val(response[i].id_dcompra);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#cod_complete').val(response[i].codigo);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#descripcion').prop('disabled',false);       
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#descripcion').val(response[i].descripcion);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#cantidad').prop('disabled',false);    
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#cantidad').val(response[i].cantidad);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#bodega').prop('disabled',false);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#bodega').val(response[i].almacen);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#descuento').prop('disabled',false);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#descuento').val(response[i].descuento);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#precio_unitario').prop('disabled',false);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#precio_unitario').val(response[i].precio_compra);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#preciounitario').text(response[i].precio_compra);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#preciototal').text(response[i].total_detalle);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#totalstock').text(response[i].UnitsInStock);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#total_tbl').prop('disabled',false);
                        $("#posicion"+response[i].posicion).parent().parent().parent().find('#total_tbl').val(response[i].total_detalle);

                        calcular_totales(); 
                        // $("#posicion"+response[i].posicion).parent().parent().parent().find('#total_tbl').val(response[i].Neto);

                    //calcular_total();
                    
                };
               
                

                }
            
        });




           $("#btn-editar").on("click", function(){

                     var ValorNeto = 0;

                $('.total').each(function () {

                    if($(this).val()==0)
                    {

                    }else
                    {
                      ValorNeto += Number($(this).val());
                    }

                });                


                   var contador        = $("#contador").val();
                   var folio_factura   = $("#folio").val();
                   var facturacion     = $("#facturacion").val();
                   var sproveedor        = $("#sproveedor").val();
                   var ordencompra   = $("#ordencompra").val();             
                   var guiadespacho   = $("#guiadespacho").val();    
                   var sempresa      = $("#sempresa").val();
                   var spago     = $("#spago").val();
                   var glosa      = $("#glosa").val();







                    var total_direct = 0;
                $('.total').each(function () {
                    if($(this).val()==0)
                    {
                    }else
                    {
                        //sumando=parseFloat($(this).text()).toFixed(2);
                
                        total_direct += Number($(this).val());      
                    }
                });
                //iva=(total_direct*19)/100;
                var iva = total_direct - (total_direct / 1.19);
                var neto = (total_direct - iva);

                   var Neto         = neto;
                   var Iva          = iva;
                   var Total        = total_direct;
                   
                   var parametros = {

                  "contador"        : contador,
                   "folio_factura"   : folio_factura,
                   "facturacion"     : facturacion,
                   "sproveedor"        : sproveedor,
                   "ordencompra"   : ordencompra,           
                   "guiadespacho"   : guiadespacho,   
                   "sempresa"      : sempresa,
                   "spago"     : spago,
                   "glosa"      : glosa,
                   "neto"   : Neto,
                   "iva"    : Iva,
                   "total"  : Total

                   };


                   
                   
     
                        
               $.ajax({
                        
                    async               :true,
                    cache               :false,
                    type                :"POST",
                    dataType            :"json",
                    data                : parametros,
                    url                 :"./select_compra_edit.php?action=editarDatos&id=<?=$_GET['id_compra']?>",
                    beforeSend: function () {
                               
                    },                     
                    success: function(response){
                       

                       

                    }
                        
                });






               //editar e insertar datos detalles





               for(var i=1;i<=54;i++)
               {
                   var indx = $("#posicion"+i*10).parent().parent().parent();

                    if(indx.find("#idepos").val() == 0)
                    {
                      
                      if(indx.find("#cod_complete").val().trim()=="")
                      {

                      }else
                      {

                          
                          var Posicion          = $("#posicion"+i*10).val();
                          var Codigo            = indx.find("#cod_complete").val();
                          var Descripcion       = indx.find("#descripcion").val();
                          var Cantidad          = indx.find("#cantidad").val();
                          var Bodega            =  indx.find("#bodega").val();
                          var Descuento         = indx.find("#descuento").val();
                          var Precio            = indx.find("#precio_unitario").val();
                          


                          


                              var Neto              = parseFloat(Precio * parseInt(Cantidad));
                              
                              var Iva               = parseInt(parseInt(Neto) * 0.19);    
                                                    
                              var Total             = parseInt(indx.find("#total_tbl").val());




                          if(Descuento.trim()=="0")
                          {

                                var Neto              = parseFloat(Precio * parseInt(Cantidad));
                                var PrecioDesc        = Precio;
                              
                              var Iva               = parseInt(parseInt(Neto) * 0.19);    
                                                    
                              var Total             = parseInt(indx.find("#total_tbl").val());
                          }else
                          {
                            
                          }



                        var parametros2 = {

                          
                          "Posicion"            : Posicion ,
                          "Codigo"              : Codigo,
                          "Descripcion"         : Descripcion,
                          "Cantidad"            : Cantidad,
                          "Descuento"           : Descuento,
                          "Bodega"              : Bodega,
                          "Neto"                : Neto,
                          "Precio"              : Precio,
                          "Iva"                 : Iva,                        
                          "Total"               : Total,
                        

                         };

                         
                         $.ajax({
                        
                              async               :true,
                              cache               :false,
                              type                :"POST",
                              dataType            :"json",
                              data                : parametros2,
                              url                 :"./select_compra_edit.php?action=insertarDatos&id=<?=$_GET['id_compra']?>",
                              beforeSend: function () {
                                         
                              },                     
                              success: function(response){
                                 
                                 

                              }
                                  
                          });
                      }
                        
                        
                    }else if(indx.find("#idepos").val() != 0 && indx.find("#cod_complete").val().trim()=="")
                    {

                      $.ajax({
                        
                              async               :true,
                              cache               :false,
                              type                :"POST",
                              dataType            :"json",
                              url                 :"./select_compra_edit.php?action=eliminarDatos2&id="+indx.find("#idepos").val(),
                              beforeSend: function () {
                                         
                              },                     
                              success: function(response){
                                 
                                 

                              }
                                  
                          });
                        

                    }else
                    {
                         var Posicion          = $("#posicion"+i*10).val();
                          var Codigo            = indx.find("#cod_complete").val();
                          var Descripcion       = indx.find("#descripcion").val();
                          var Cantidad          = indx.find("#cantidad").val();
                          var Bodega            =  indx.find("#bodega").val();
                          var Descuento         = indx.find("#descuento").val();
                          var Precio            = indx.find("#precio_unitario").val();


                           


                              var Neto              = parseFloat(Precio * parseInt(Cantidad));
                              
                              var Iva               = parseInt(parseInt(Neto) * 0.19);    
                                                    
                              var Total             = parseInt(indx.find("#total_tbl").val());

                              

                          if(Descuento.trim()=="0")
                          {

                                var Neto              = parseFloat(Precio * parseInt(Cantidad));
                                
                              
                              var Iva               = parseInt(parseInt(Neto) * 0.19);    
                                                    
                              var Total             = parseInt(indx.find("#total_tbl").val());
                          }else
                          {
                            
                          }
                          
                          


                         


                        var parametros4 = {

                          
                          "Posicion"            : Posicion ,
                          "Codigo"              : Codigo,
                          "Descripcion"         : Descripcion,
                          "Cantidad"            : Cantidad,
                          "Descuento"           : Descuento,
                          "Bodega"              : Bodega,
                          "Neto"                : Neto,
                          "Precio"              : Precio,
                          "Iva"                 : Iva,                        
                          "Total"               : Total,
                        

                         };


                         
                         $.ajax({
                        
                              async               :true,
                              cache               :false,
                              type                :"POST",
                              dataType            :"json",
                              data                : parametros4,
                              url                 :"./select_compra_edit.php?action=editarDatos2&id="+indx.find("#idepos").val(),
                              beforeSend: function () {
                                         
                              },                     
                              success: function(response){
                                 
                                 

                              }
                                  
                          });
                    }

                     window.location.href = "./compracrud_main.php";
                   
               }




            });   


      





    });

    </script>


</head>
<body  class="ui-widget">
 
    <div id="contenedor">
          <div id="tbl_pri">
            <center><h3>Factura de Compra</h3></center>
        <form name="form_tbl" id="form_tbl" action="" method="post">
            <div id="cabecera" class="ui-widget-content ui-corner-all">
                    <input type="hidden" id="neto" name="neto" value="">
                    <input type="hidden" id="iva" name="iva" value="">
                    <input type="hidden" id="total" name="total" value="">
                <table cellspacing="3" align="center" style="width: 100%;" cellpadding="1">
                <tbody>
                    <tr>
                    <td style="width:110px">
                        <label for="contador">Contador</label>
                    </td>
                    <td  style="width:100px;">
                        <input class="form-control input-sm ui-corner-all" type="text" value="" id="contador" class="span2" name="contador" style="width: 100%" />
                    </td>
                    <td style="width:120px;" align="left">
                        <label for="sproveedor">Proveedor</label>
                    </td>
                    <td style="width:280px;">
                        <select name="sproveedor" class="span2" id="sproveedor" style="width: 85%">
                        <option value="0">--Seleccionar--</option>
                        <?php
                                    for($t=0;$t<sizeof($res);$t++)
                                    {
                                    ?>
                        <option value="<?php echo $res[$t]["IDsuppliers"]?>"><?php echo $res[$t]["Suppliers"]?></option>
                        <?php
                                    }
                                    ?>

                        </select>
                        

                        
                        
                    </td>
                    <td style="width:110px;">
                        <label for="ordencompra">Orden de Compra</label>
                    </td>
                    <td style="width:110px;">
                    <input class="form-control input-sm ui-corner-all" type="text" id="ordencompra" class="span2" name="ordencompra" style="width: 100%" />
                    </td>

                    </tr>
                    <tr>
                    <td>
                        <label for="folio">Folio</label>
                    </td>
                    <td>
                        <input class="form-control input-sm ui-corner-all" type="text" value="" id="folio" class="span2" name="folio" />
                    </td>
                    <td align="left">
                        <label for="gdespacho">Guia Despacho</label>
                    </td>
                    <td style="width: 110px;">
                       <input class="form-control input-sm ui-corner-all" type="text" value="" id="guiadespacho" class="span2" name="guiadespacho" style="width: 50%"/>

                    </td>

                    <td align="left">
                        <label for="fpago">Forma Pago</label>
                    </td>
                    <td style="width: 110px;">
                    <select name="spago" class="span2" id="spago" style="width: 85%">
                        <option value="0">--Seleccionar--</option>
                        <?php
                                    for($t=0;$t<sizeof($res8);$t++)
                                    {
                                    ?>
                        <option value="<?php echo $res8[$t]["IdFormaPago"]?>"><?php echo $res8[$t]["Nombre"]?></option>
                        <?php
                                    }
                                    ?>

                        </select>
                    </td>
                    </tr>
                    <tr>
                    <td>
                        <label for="facturacion">Fecha Compra</label>
                    </td>
                    <td>
                        <input class="form-control input-sm ui-corner-all" type="text" value="" id="facturacion" class="span2 hasDatepicker"
                        name="facturacion" />
                    </td>
                    <td style="width:120px;" align="left">
                        <label for="folio">Empresa</label>
                    </td>
                    <td>
                        <select name="sempresa" class="span2" id="sempresa" style="width: 85%">
                        <option value="0">--Seleccionar--</option>
                        <?php
                                    for($t=0;$t<sizeof($res7);$t++)
                                    {
                                    ?>
                        <option value="<?php echo $res7[$t]["IDEmpresa"]?>"><?php echo $res7[$t]["RazonSocial"]?></option>
                        <?php
                                    }
                                    ?>

                        </select>
                    </td>
                    </tr>
                    <tr>
                        <td style="width:120px;" align="left">
                            <label>Glosa/Descripci贸n</label>
                        </td>
                        <td>
                            <textarea id="glosa" class="form-control input-sm ui-corner-all" style="width: 233px;" rows="4" cols="20" name="glosa" value=""></textarea>
                        </td>

                    </tr>

                </tbody>
                </table>
        </div><!--Cabecera-->
            <div style="height: 5px;width: 100%;"></div>
            <div class="divcabecera ui-widget-header ui-corner-all">

                <table style="text-align: center; width:100%" id="tbl_cab" class="table table-bordered table-condensed table-hover " cellspacing="2" >
                        <thead>
                        <th width="50px;"><center>Pos</center></th>
                        <th width="113px;"><center>C贸digo</center></th>
                        <th width="150px;"><center>Descripci贸n</center></th>
                        <th width="81px;"><center>Cant.</center></th>
                        <th width="81px;"><center>Bod.</center></th>
                        <th width="81px;" style="color: red;"><center>Desc.</center></th>
                        <th width="81px;"><center>Prec.<br/>Unitario</center></th>
                        <th width="81px;"><center>Prec.<br/>Total</center></th>
                        <th width="5px;"></th>
                        </thead>
                </table>
            </div>
            <div id="cuerpo">
                <table align="center" id="tbl_bod" class=""  cellspacing="2">
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
                    <input type="hidden" id="idepos" value="0"/>
                    <td width="50px;"><center><input style="border:none; width:100%;"  type="text" disabled name="posicion[]" id="posicion<?=$i*10?>" value="<?=$i*10?>" class="act  form-control input-sm"/></center></td>
                    <td width="113px;"><center>
                    <table style="width: 100%">
                        <TR>
                             <TD tyle="width: 90%"><input style="border:none;width: 100%;"  type="text" name="codigo[]" id="cod_complete" value="" class="form-control input-sm caja_cod cod typeahead cod_complete"  data-provide="typeahead"/></TD>
                             <TD><button id="btn-codigo" class="btn btn-default btn-sm ui-corner-all btn-codigo" type="button" >
                                <span class="glyphicon glyphicon-search"></span>
                                </button></TD>
                        </TR>
                        </table>
                    </center></td>
                    <td width="170px;">
                        <table style="width: 100%">
                        <TR>
                             <TD style="width: 100%">

                                <textarea style="border:none; width: 100%; height: 30px" class="form-control input-sm act" id="descripcion" name="descripcion[]" disabled></textarea>
                             </TD>
                        </TR>
                        </table>
                    </td>
                    <td width="81px;"><center><input style="border:none; width: 100%;"  type="text" name="cantidad[]" disabled maxlength="7" id="cantidad" value="" class="cant form-control input-sm act cantidad"/></center></td>
                    <td width="81px;"><center><input style="border:none;width:100%;"  type="text" name="bodega[]" disabled id="bodega" value="" class="form-control input-sm act"/></center></td>
                    <td width="81px;"><center><input style="border:none;width:100%;"  type="text" name="descuento[]" disabled id="descuento" value="" class="desc form-control input-sm act descuento"/></center></td>
                    <td width="81px;"><center><input type="text" style="border:none;width: 100%;" class="precio_unitario form-control input-sm  act precio_unitario" name="precio_unitario[]" id="precio_unitario" disabled value=""/></center></td>
                    <td width="81px;"><center><input type="text" class="total act form-control input-sm total_tbl " style="border:none;" name="total_tbl[]" id="total_tbl" disabled  value=""/></center></td>
                    <td id="preciounitario" style="display:none"></td>
                    <td id="preciototal" class="total" style="display:none"></td>
                    <td id="totalstock" style="display:none"></td>
                    <td style="display:none;"><input type="hidden" value="" name="id_detalles[]" id="id_detalles"/></td><!--id de la guia para la edicion -->
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
                <td width="81px"><center><small><strong>Neto:</strong></small>&nbsp;&nbsp;0</center></td>
                <td width="81px"><center><small><strong>Iva:</strong></small>&nbsp;&nbsp;0</center></td>
                <td width="81px"><center><small><strong>Total:</strong></small>&nbsp;&nbsp;0</center></td>
                <td width="5px"></td>
                </tr>
                </table>
                <table border="0" class="table table-condensed table-bordered" cellspacing="2">
                <tr>
                    <td><button type="button" class="btn btn-primary" name="" id="btn-editar"  value="">Registrar Factura</button></td>
                </tr>
                </table>

            </div><!--Pie-->
        </form>
          </div><!--Tbl_pri-->
    </div><!--Contenedor principal-->
    

        <div id="dialog_btn-codigo" title="Productos" style="display: none;">
        <div style="width: 1200px; background-color: transparent; font-family: lucida sans unicide, tahoma; font-size: 12px;">
        <h4 style="color:rgb(63, 60, 60);">Maestro de Productos</h4>
        <div class="ui-widget-content ui-corner-all" style="width: 80%; height: 45px">
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
</body>
</html>
<script>
$(function() {



//     $("#sproveedor").select2();
//     $("#tcotizacion").select2();
 //    $("#sempresa").select2();
 //    $("#gdespacho").select2();
 //    $("#spago").select2();




    var availableTags =<?=json_encode($res6);?>;

    $(".cod_complete").autocomplete({
        source: availableTags
    });
    // $("#fcreacion").datepicker({});
    // var creacion = $('#facturacion').datepicker({
    //     dateFormat: 'dd/mm/yy'
    // });
    // creacion.on('changeDate', function(ev) {
    //     // do what you want here
    //     creacion.datepicker('hide');
    // });

    

    $("#openproveedor").on("click", function() {

        $("#dialogproveedor").dialog("open");
    });


    });


    //Todo lo nuevooooooooooooooo



     quitar();
    function quitar(){
    $(".btn-quitar").on("click",function(){


        //$(this).parent().parent().find("#idepos").val("");
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
                /*    var iva = parseFloat(total_direct)*0.19;*/
                $("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
                $("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
                $("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');

    });
    };



    //**************************************

    function include(file_path){
        var j = document.createElement("script");
        j.type = "text/javascript";
        j.src = file_path;
        document.body.appendChild(j);
    }


    //*************************************************


    $("#btn-factura").on('click',function(event){
         event.preventDefault();

         if($(".cod").val()==0 || $("#sproveedor").val()==0)
         {
             alert(" Favor, rellene los campos necesarios");
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
                                url:"insert_compra_sql.php",
                                data:datasrl,
                                beforeSend: function () {
                                    $("#pre-load").show();
                                },

                                success: function(response){



                                        if (response=="todo") {

                                        //alert(response);
                                            alert("Creada con exito!");
                                            $(".act").prop("disabled",true);
                                            window.location = 'compracrud_main.php';            //code
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
</script>
