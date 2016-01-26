<?php
require_once("../../validatesession_html.php");
require_once("select_guia.php");

$ACTUAL_THEME="tormesol";
$JTABLE_THEME="jqueryui/jtable_jqueryui.css";

$nota_credito=new funciones();
$Empresa = $_SESSION['SESS_EMPRESA_ID'];

    if (empty($_SESSION["ORD_FECHABUSQUEDA1"])) { $_SESSION["ORD_FECHABUSQUEDA1"] = date("d-m-Y");  }
    if (empty($_SESSION["ORD_FECHABUSQUEDA2"])) { $_SESSION["ORD_FECHABUSQUEDA2"] = date("d-m-Y");  }

$accion="";
$deshabilitar="";

$proveedores = $nota_credito->proveedores();
$contador=$nota_credito->obtiene_notacredito();
$empresa=$nota_credito->empresas();
$almacen=$nota_credito->almacen();
$trabajadores=$nota_credito->trabajadores();
$res6=$nota_credito->code_autocomplete();
$proy=$nota_credito->proyectos();
$autoriza =$nota_credito->quien_autoriza();
$motivo=$nota_credito->motivoguia();
$id_btn="Ingresar Nota Crédito";
$id_btn2="Ingresars";
$fecha2=$_SESSION["ORD_FECHABUSQUEDA1"];
$fecha4=$_SESSION["ORD_FECHABUSQUEDA2"];
$formaPago = $nota_credito->forma_pago();

if($_GET)
{

    $accion="modificar";
    $deshabilitar="readonly";
/*
    date_default_timezone_set("Chile/Continental");
    $ord=$nota_credito->eordend($_GET["IdEGuiaDespacho"]);
    $ord2=$nota_credito->dordend($_GET["IdEGuiaDespacho"]);
    $res=$ord[0]["contador"];
    $fecha1=$ord[0]["fecha_ingreso"];
    $fecha2=date("d-m-Y",strtotime($fecha1));
    $fecha3=$ord[0]["fecha_entrega"];
    $fecha4=date("d-m-Y",strtotime($fecha3));
    $select=count($ord2);
    $guiaba=$nota_credito->trabajadores();

    //$res2=$nota_credito->empresas();

    $query="SELECT
    IDEmpresa,
    RUT, RazonSocial
    FROM empresa
    WHERE
    empresa.IDEmpresa = '$Empresa'";
    $res1 = mysql_query($query,conectar::con());
    while($dato=mysql_fetch_assoc($res1))
    {
          $salidas[]=$dato;
    }

    //echo $salidas[0]["IDEmpresa"];
    $res3=$nota_credito->almacen();
    $res5=$nota_credito->clientes();
    $proy=$nota_credito->proyectos();
    $guiaba=$nota_credito->trabajadores();
    $res6=$nota_credito->code_autocomplete();
    $id_btn="Ingresar Nota Crédito";
    $id_btn2="Editars";
    */
 $accion="crear";



    //Principal datos

    //$datosPrincipales = $nota_credito->trae_guia($_GET["IdEGuiaDespacho"]);


  $proveedores = $nota_credito->proveedores();
    $contador=$nota_credito->obtieneguia();
    $empresa=$nota_credito->empresas();
    $almacen=$nota_credito->almacen();
    $trabajadores=$nota_credito->trabajadores();
    $res6=$nota_credito->code_autocomplete();
    $proy=$nota_credito->proyectos();
    $autoriza =$nota_credito->quien_autoriza();
    $motivo=$nota_credito->motivoguia();
    $id_btn="Ingresar Nota Crédito";
    $id_btn2="Ingresars";
    $fecha2=$_SESSION["ORD_FECHABUSQUEDA1"];
    $fecha4=$_SESSION["ORD_FECHABUSQUEDA2"];
    
}else
{

    // $accion="crear";

    // $contador=$nota_credito->obtieneguia();
    // $empresa=$nota_credito->empresas();
    // $almacen=$nota_credito->almacen();
    // $trabajadores=$nota_credito->trabajadores();
    // $res6=$nota_credito->code_autocomplete();
    // $proy=$nota_credito->proyectos();
    // $autoriza =$nota_credito->quien_autoriza();
    // $motivo=$nota_credito->motivoguia();
    // $id_btn="Ingresar Nota Crédito";
    // $id_btn2="Ingresars";
    // $fecha2=$_SESSION["ORD_FECHABUSQUEDA1"];
    // $fecha4=$_SESSION["ORD_FECHABUSQUEDA2"];
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Notas de Crédito</title>


    <!-- bootstrap -->
    <script src="../../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <link  href="../../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../../css/datepicker.css"/>


    <!-- jquery -->
    <script src="../../scripts/jquery/jquery.js" type="text/javascript"></script>
    <script src="../../scripts/jquery/jquery-ui.js" type="text/javascript"></script>
    <script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript" ></script>
    <link  href="../../scripts/jquery/themes/tormesol/jquery-ui.css" rel="stylesheet" type="text/css" />
    
    <!-- jquery rut -->
    <script src="../../js/jQuery.Rut.js" type="text/javascript"></script>
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
    

</head>
<script type="text/javascript">
    $(function(){

        ValorNeto = 0;

         function calcular_total() {
          var total_direct = 0;
          $('.total').each(function () {
              if($(this).val()==0)
              {
              }else
              {
                total_direct += Number($(this).val());
              }
          });
          
          ValorNeto =(total_direct);
          neto =(total_direct);
          
          $("#total").val(neto);

          $("#tbl_foot tr td:eq(1)").html('<center><small><strong>Total Neto: $</strong></small>  '+Moneda(neto.toFixed())+'</center>');
          
          } 
          
           Ultimo_ID = 0;

        
        //Creando el Cuerpo

          for (var i = 1; i < 55; i++) {              
            $("#cnt").append('<tr width:"1300px;" ><td width="34px;"><center><input type="hidden" id="idepos" value="0"/><input style="border:none; width:100%;"  type="text"   name="posicion[]" id="posicion'+i*10+'" readonly value="'+i*10+'" class="form-control input-sm act"/></center></td><td width="113px;"><center><table style="width: 100%"><TR><TD style="width: 100%"><input  style="border:none;width: 100%;"  type="text" name="codigo[]" id="cod_complete" value="" class="form-control input-sm caja_cod cod cod_complete"/></TD><TD ><button id="btn-codigo" class="btn btn-default btn-sm ui-corner-all btn-codigo" type="button" ><span class="glyphicon glyphicon-search"></span></button></TD></TR></table></center></td><td width="200px;"><center><table style="width: 100%"><TR><TD style="width: 90%"><textarea style="border:none;width: 100%; height: 30px" class="form-control input-sm act" id="descri" name="descripcion[]" cols="20" rows="1" ></textarea><!--<input style="border:none;width: 100%;"  type="text" name="descripcion[]"  id="descri" value="" class="form-control input-sm span2 act"/>--></TD><TD style="width: 10%"><button id="btn-descrip" class="btn btn-default btn-sm ui-corner-all btn-descrip" type="button" ><span class="glyphicon glyphicon-pencil"></span></button></TD></TR></table></center></td><td width="75px;"><center><input style="border:none;width:100%;"  type="text" id="cantidades" name="cantidad[]"  maxlength="7" class="form-control input-sm cant"/></center></td><td width="81px;" style="display: none;"><center><input type="hidden" name="bodega[]" id="bodega" value="1" /></center></td><td style="display:none"></td><td style="display:none;"><input type="hidden" value="" name="id_detalles[]" id="id_detalles"/></td><td width="80px;"><center><table style="width: 100%"><TR><TD style="width: 90%"><input disabled style="border:none;width: 100%;"  type="text" name="valor[]"  id="valor" value="" class="form-control valor input-sm span2 act"/></TD></TR></table></center></td><td width="80px;"><center><input type="text" class="total form-control input-sm " style="border:none;" name="total_tbl[]" id="total_tbl" readonly value=""/></center></td><td style="width: 3%"><button style="width: 100%" id="btn-quitar" class="btn btn-default btn-sm ui-corner-all btn-quitar" type="button" ><span class="glyphicon glyphicon-trash"></span></button></td><td id="preciounitario" style="display:none"></td><td id="preciototal" style="display:none"></td><td id="totalstock" style="display:none"></td></tr>');
                calcular_total();
          };

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
            
              function Moneda(entrada){
                    var num = entrada.replace(/\./g,"");
                    if(!isNaN(num)){
                        num = num.toString().split("").reverse().join("").replace(/(?=\d*\.?)(\d{3})/g,"$1.");
                        num = num.split("").reverse().join("").replace(/^[\.]/,"");
                        entrada = num;
                    }else{
                        entrada = input.value.replace(/[^\d\.]*/g,"");
                    }
                    return entrada;
                }           


                $("#btn-volver").on("click", function() {

                        window.history.back();

                      //window.location="ordencrud_main.php";
                  });
              
              calcular_total();

               $(".btn-quitar").on('click', function() {
                var $TR=$(this).parent().parent();
                
                $TR.find('#cod_complete').val('').attr('value','');
                $TR.find('#descri').val('').attr('value','');
                $TR.find('#cantidades').val('');
                $TR.find('#valor').val('');
                $TR.find('#total_tbl').val('');
                
                calcular_total();
          });

            $("#editarGuia").on("click", function(){ 
             var ValorNeto = 0;

            $('.total').each(function () {

              if($(this).val()==0)
              {

              }else
              {
                ValorNeto += Number($(this).val());
              }

          });      

                   var numero                  = $("#numero").val();
                   var Folio_nota_credito     = $("#folio_credito").val();
                   var IdFormaPago            = $("#forma_pago").val();  
                   var Neto                   = ValorNeto;
                   var Iva                    = parseInt(ValorNeto * 0.19);
                   var Total                  = parseInt(Neto) + parseInt(Iva);
                   var FechaFacturacion       = $('#fecha_guia').val();
                   var User                   = $("#txt_usuario").val();
                   var IDEmpresa              = $("#empresa").val();
                   var glosa                  = $("#glosa").val();
                   var IDMotivo               = $("#motivo").val();
                   var IDsuppliers            = $("#proveedor").val();
                   
                   
                   var parametros = {

                   "numero"                  : numero,
                   "Folio_nota_credito"     : Folio_nota_credito ,
                   "IdFormaPago"            : IdFormaPago,
                   "Neto"                   : Neto,
                   "Iva"                    : Iva,
                   "Total"                  : Total,
                   "FechaFacturacion"       : FechaFacturacion,
                   "User"                   : User,
                   "IDEmpresa"              : IDEmpresa,
                   "glosa"                  : glosa,
                   "IDMotivo"               : IDMotivo,
                   "IDsuppliers"            : IDsuppliers

                   };
     
                        
               $.ajax({
                        
                    async               :true,
                    cache               :false,
                    type                :"POST",
                    dataType            :"json",
                    data                : parametros,
                    url                 :"./select_guia.php?action=editarDatos",
                    beforeSend: function () {
                               
                    },                     
                    success: function(response){
                       

                      Ultimo_ID = response;

                       for(var i=1;i<=54;i++)
                    {
                        var indx = $("#posicion"+i*10).parent().parent().parent();

                           if(indx.find("#cod_complete").val()=="")
                    {
                    }else
                    {
                      
                          var posicion          = $("#posicion"+i*10).val();
                          var codigo            = indx.find("#cod_complete").val();
                          var descripcion       = indx.find("#descri").val();
                          var cantidad          = indx.find("#cantidades").val();
                          var Neto              = indx.find("#total_tbl").val();
                          var Iva               = parseInt(parseInt(Neto) * 0.19);                          
                          var Total             = parseInt(parseInt(Neto) + parseInt(Iva));
                      
                        var parametros2 = {

                          
                          "posicion"            : posicion ,
                          "codigo"              : codigo,
                          "descripcion"         : descripcion,
                          "cantidad"            : cantidad,
                          "Neto"                : Neto,
                          "Iva"                 : Iva,                        
                          "Total"               : Total,
                          
                        

                         };

                         
                         $.ajax({
                        
                              async               :true,
                              cache               :false,
                              type                :"POST",
                              dataType            :"json",
                              data                : parametros2,
                              url                 :"./select_guia.php?action=insertarDatos&id="+Ultimo_ID,
                              beforeSend: function () {
                                         
                              },                     
                              success: function(response){
                                 
                                 

                              }
                                  
                          });

                       }
                    }

                       window.location = "notacreditocrud_main.php";

                    }
                        
                });

               //editar e insertar datos detalles                        
                    

              // window.location.href = "./ordencrud_main.php";
                   
            });   
    });
</script>
 <!--Propias de la pagina-->
   <script type="text/javascript" src="guia_fullcode_orden.js"></script>
    <script type="text/javascript" src="orden_trabajo_js.js"></script>
<body class="ui-widget">
    
    <div id="contenedor">
            <div id="tbl_pri">
            <center><h3>Notas de Credito</h3></center>
        <form name="form_tbl" id="form_tbl" action="" method="post">

            <input type="hidden" id="total" name="total" value="<?=$res5[$e]["total"]?>">

             <div id="cabecera" class="ui-widget-content ui-corner-all">

            <table cellspacing="3" align="center" style="width: 100%;" cellpadding="1">
                <tr>
                <td style="width:110px"><label>Folio Interno:</label></td>
                <td style="width:150px;">
                    <input disabled type="text" name="numero" style="width: 100%" class="form-control input-sm ui-corner-all"  id="numero" value="<?=$contador?>" />
                </td>
                <td style="width:100px;" align="left"><label>Proveedor</label></td>
                <td style="width:280px;">
                  <table>
                            <tr>
                                <td style="width: 280px;">
                            <select name="proveedor" id="proveedor" style="width: 90%" class="span2"  value="">
                              <option value="0">--Seleccionar--</option>
                              <?php
                              	for($a=0;$a<sizeof($proveedores);$a++)
                              	{
                              ?>
                              <option value="<?=$proveedores[$a]["IDsuppliers"]?>"><?=strtoupper($proveedores[$a]["Suppliers"])?></option>
                              <?php
                              }
                              ?>

                           </select>
                                </td>
                                
                            </tr>
                        </table>
                </td>
                
                <td style="width:80px;" align="center"><label>Glosa</label></td>
                <td rowspan="4">
                    <textarea style="width: 100%" class="form-control input-sm ui-corner-all" id="glosa" name="glosa" cols="20" rows="6" ></textarea>
                </td>

                </tr>
                <tr>
                <td><label>Folio Nº</label></td>
                <td align="center">
                    <input style="width: 100%" class="form-control input-sm ui-corner-all" type="text" name="folio_credito" id="folio_credito" />
                </td>
                <td ><label >Foma Pago</label></td>
                <td>
                    <select name="motivo" id="forma_pago" style="width: 100%" class="span2"  value="">
                        <option value="0">--Seleccionar--</option>
                        <?php
                           for($a=0;$a<sizeof($formaPago);$a++)
                              {
                        ?>
                        <option value="<?=$formaPago[$a]["IdFormaPago"]?>"><?=strtoupper($formaPago[$a]["Nombre"])?></option>
                        <?php
                           }
                        ?>

                     </select>
                </td>

                </tr>
                <tr>
                <td><label>Fecha:</label></td>
                <td >
                    <input style="width: 100%" class="form-control input-sm ui-corner-all" type="text" name="fecha_guia" id="fecha_guia" value="<?=$fecha4?>" />
                </td>
                <td ><label>Motivo</label></td>
                <td>
                    <select name="motivo" id="motivo" style="width: 100%" class="span2"  value="">
                        <option value="0">--Seleccionar--</option>
                        <?php
                           for($a=0;$a<sizeof($motivo);$a++)
                              {
                        ?>
                        <option value="<?=$motivo[$a]["IDMotivo"]?>"><?=strtoupper($motivo[$a]["nombre"])?></option>
                        <?php
                           }
                        ?>

                     </select>
                </td>

                <td align="center" >&nbsp;</td>
            <tr>
        <td ><label>Usuario</label></td>
                <td >
                  <input style="width: 100%" class="form-control input-sm ui-corner-all" disabled type="text" name="txt_usuario" id="txt_usuario" value="<?php echo $_SESSION["SESS_USERNAME"]?>"/>
                  <input  type="hidden" name="usuario" value="<?php echo $_SESSION["SESS_USERNAME"]?>" />
                </td>

            </tr>
           <tr>
            <td><label>Empresa:</label></td>
            <td style="width: 180px;">
              <select name="empresa" id="empresa" style="width: 90%" class="span2"  value="">
                        <option value="0">--Seleccionar--</option>
                        <?php
                           for($a=0;$a<sizeof($empresa);$a++)
                              {
                        ?>
                        <option value="<?=$empresa[$a]["IDEmpresa"]?>"><?=strtoupper($empresa[$a]["RazonSocial"])?></option>
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
        <tbody id="cnt">
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
                    <td width="10%" align="right"><button type="button" class="btn btn-primary" name="<?=$id_btn2?>" id="editarGuia"  value="">Guardar Nota Credito</button></td>   
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

        <div id="modal1" style="display:none;">
            <textarea class="form-control input-sm " id="descripciones_dialog"   cols= "60" rows="30"  style="width: 973px; height: 300px;" ></textarea>
        </div>

        
</body>
</html>
<script>



$(function() {

  // Moneda
      
$("#empresa").select2();
$("#proveedor").select2();
$("#forma_pago").select2();
$("#motivo").select2();



       $(".valor").keyup(function(){


            if (!/^([0-9])*[.]?[0-9]*$/.test($(this).val()))
            {
              alert("ingresa un valor numerico");
              $(this).val('');
              $(this).focus();
            }else
            {
              if(isNaN($(this).val()))
              {
                alert("ingresa un valor numerico");
                $(this).val('');
                $(this).focus();
              }
              if($(this).val()==0)
              {
                var $tr=$(this).parent().parent().parent().parent().parent().parent().parent();
                
                      $tr.find("#total_tbl").val('');
                
                      calcular_total();

              }
              else
              {
                      var $tr=$(this).parent().parent().parent().parent().parent().parent().parent();
                      
                var v1=parseFloat($tr.find("#valor").val());
                var v2=parseFloat($tr.find("#cantidades").val());
                      
                var resultado = (v1 * v2).toFixed();

                      $tr.find("#total_tbl").val(resultado);
                      $tr.find("#preciototal").text(resultado);

                      calcular_total();

              }
            }
           

        });

   
   

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



      // $("#modal1").dialog({
      //     autoOpen: false,
      //     width: 1000,
      //     heigth: 700,
      //     position: ['middle', 20],
      //     show: {
      //         effect: "fade",
      //         duration: 500
      //     },
      //     hide: {
      //         effect: "fade",
      //         duration: 500
      //     },
      //     modal: true,
      //     buttons: {
      //         "Cerrar": function() {
      //             $tr.find("#descri").val($("#descripciones_dialog").val());
      //             $(this).dialog("close");
      //             $("#descripciones_dialog").val("");

      //         }

      //     }
      // });

      // $(".btn-descrip").on("click", function() {

      //     $tr = $(this).parent().parent();
      //     $("#descripciones_dialog").val($tr.find("#descri").val());
      //     $("#modal1").dialog("open");

      // });





      
});



 

</script>
