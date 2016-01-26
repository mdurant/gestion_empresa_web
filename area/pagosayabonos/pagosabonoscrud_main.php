<?php
require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

require_once("../../conexion/funciones.php");

$tra=new funciones();
$prove=$tra->Proveedores();
$banco=$tra->banco();



?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Pagos y Abonos Proveedores</title>

<!-- bootstrap -->
<script src="../../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
<link  href="../../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />

<!-- jquery -->
<script src="../../scripts/jquery/jquery.js" type="text/javascript"></script>
<script src="../../scripts/jquery/jquery-ui.js" type="text/javascript"></script>
<script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript"></script>
<link  href="../../scripts/jquery/themes/<?=$ACTUAL_THEME?>/jquery-ui.css" rel="stylesheet" type="text/css" />

<!-- jtable -->
<script src="../../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
<script src="../../scripts/jtable/jquery.jtable.es.js" type="text/javascript"></script>
<link  href="../../scripts/jtable/themes/<?=$JTABLE_THEME?>" rel="stylesheet" type="text/css" />

<!--SELECT2-->
<link rel="stylesheet" type="text/css" href="../../css/select2.css"/>
<script type="text/javascript" src="../../js/select2.js"></script>
<script type="text/x-javascript" src="../../js/select2_locale_es.js"></script>
<script>
$(function(){

$("#sproveedor").select2();
});

</script>
<!-- jquery.validationEngine -->
<!--<script src="../../scripts/jquery/validate/jquery.validationEngine.js" type="text/javascript" ></script>
<script src="../../scripts/jquery/validate/jquery.validationEngine-es.js" type="text/javascript"></script>
<link  href="../../scripts/jquery/validate/validationEngine.jquery.css" rel="stylesheet" type="text/css" />-->



</head>
<style>


#btn
{
cursor: pointer;
}



</style>
<body class="ui-widget">

<h4>Pagos y Abonos Proveedores</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
<form style="margin: 0px">
<table width="80%" cellspacing="2" cellpadding="4">
<tbody><tr>
<td width="30%" align="center">

<table style="width:60%">
<tbody><tr>
      <td style="width: 130px;text-align: center"><label>Folio Documento</label></td>
      <td><input type="text" id="folio" name="folio" class="form-control input-sm ui-corner-all" autocomplete="off"></td>
</tr>
</tbody></table>

</td>


<td width="20%" align="center"> <button style="height: 30px; width: 100px" type="submit" id="btnBUSCAR"
        class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary"
        role="button" aria-disabled="false">
<span class="ui-icon ui-icon-search"></span>
<span class="ui-button-text">Buscar</span>

</button></td>
</tr>
</tbody>
</table>
</div>
<div style="height: 5px;width: 100%;"></div>


<div id="jt_pagosabonos" style="width: 100%"></div>


<script type="text/javascript">

$(document).ready(function () {

 var msg = {
deleteConfirmation: 'Realmente desea Anular esta cotizacion',
deleteText: 'Anular',
save: 'Facturar',
editRecord: 'Facturar Cotizacion',

};
//Prepare jTable
$('#jt_pagosabonos').jtable({
    messages: msg,
    jqueryuiTheme: true,
    title: 'Listado',
    paging: true,
    pageSize: 10,
    sorting: true,
    openChildAsAccordion: true, //Enable this line to show child tabes as accordion style
    defaultSorting: 'id_compromiso_proveedores ASC',
    selecting: false, //Enable selecting
    multiselect: false, //Allow multiple selecting
    selectingCheckboxes: false, //Show checkboxes on first column
    //selectOnRowClick: true, //Enable this to only select using checkboxes
    actions: {
        listAction:    'pagosabonosql_sql.php?action=list'
    },
    fields: {
        id_compromiso_proveedores: {
            key: true,
            create: false,
            edit: false,
            list: false
        },
        Detalle: {
        title: '',
        width: '2%',
        sorting: false,
        edit: false,
        create: false,
        display: function (datos) {
        //Create an image that will be used to open child table
        var $img = $('<img src="../../toolbar-icon/candado.png" title="Editar Permisos" />');
        //Open child table when user clicks the image
        $img.click(function () {

            //aqui***************

            $('#jt_pagosabonos').jtable('openChildTable',
                $img.closest('tr'),
                {
                title: 'Detalle de pagos abonos:',
                paging: true,
                pageSize: 10,
                sorting: false,
                defaultSorting: 'id_pago_proveedores ASC',
                actions: {


                    listAction: 'pagosabonosdet_sql.php?action=list&IDPerfil='+datos.record.id_pago_proveedores,

                },
                fields: {
                    id_pago_proveedores: {
                    type: 'hidden',
                    defaultValue: datos.record.id_pago_proveedores
                    },
                    id_pago_documento: {
                    key: true,
                    create: false,
                    edit: false,
                    list: false
                    },
                    documento: {
                    title: 'Documento',
                    width: '20%',
                    create: true,
                    edit: true,
                    list: true
                    },
                    fecha_pago: {
                    title: 'Fecha Pago',
                    width: '20%',
                    create: true,
                    type: 'date',
                    displayFormat: 'dd-mm-yy',
                    edit: true,
                    list: true
                    },
                    Suppliers: {
                    title: 'Proveedor',
                    width: '20%',
                    create: true,
                    edit: false,
                    list: false
                    }
                }
                },
                function (data) { //opened handler
                data.childTable.jtable('load');
                hello = data.childTable;
                return hello;
                });
            });
                        //Return image to show on the person row
            return $img;
        }
    },
          ncuota:
        {
            title: 'N° Cuota',
            width: '3%',
            create: true,
            edit: false,
            list: true

        },
          Accion:
        {
            title: 'Para Facturar',
            width: '5%',
            edit: true,
            input: function (data) {
                        return '<p>Seleccione Facturarada</p>';
                    },
            list: false

        },
        monto_cuota:
        {
            title: 'Monto Cuota',
            width: '10%',
            create: true,
            edit: false,
            list: true

        },
        monto_abono:
        {
            title: 'Abono',
            width: '10%',
            create: true,
            edit: false,
            list: true
        },
        monto_final: {
            title: 'Deuda Cuota',
            width: '10%',
            create: true,
            edit: false,
            list: true
        },
        tipo_compromiso:
        {
            title: 'Tipo Compromiso',
            width: '10%',
            edit: false,
            list: true
        },
        fecha_compromiso: {
            title: 'Fecha Pago',
            width: '5%',
            type: 'date',
            displayFormat: 'dd-mm-yy',
            create: true,
            edit: true,
            list: true
        },
        estado:
        {
            title: 'Estado',
            width: '5%',
            list: true,
            edit: false
        },
        id_efactura:
        {
            title: 'idfactura',
            width: '5%',
            list: false,
            edit: false
        },
         Pago: {
            title: '',
            width: '2%',
            list: true,
             display: function (data) {
            //Create an image that will be used to open child table
            var $img = $('<img src="../../toolbar-icon/pago.gif" id="btn" title="Pagar" />');
            //Open child table when user clicks the image
            $img.on("click",function () {


                        $( "#dialog" ).dialog( "open" );
                      Dato=data.record.id_pago_proveedores;



            });
            //Return image to show on the person row
            return $img;
            }
        },
        Abono: {
            title: '',
            width: '2%',
            list: true,
             display: function (data) {
            //Create an image that will be used to open child table
            var $img = $('<img src="../../toolbar-icon/abono.gif" id="btn" title="Abonar" />');
            //Open child table when user clicks the image
            $img.on("click",function () {


                        $( "#dialog2" ).dialog( "open" );
                        Dat=data.record.id_compra;
                        ncuotas=data.record.numero_cuota;
                        igd=data.record.id_det_pago_proveedores;

            });
            //Return image to show on the person row
            return $img;
            }
        }


    },
    //cuando se cierra el dialog
     formClosed: function(event, data) {
          $('#jt_pagosabonos').jtable('load');
     }

});


//Load person list from server
$('#jt_pagosabonos').jtable('load');

//buscar por clientes
 $('#btnBUSCAR').on('click',function(e) {
        e.preventDefault();
        $('#jt_pagosabonos').jtable('load', {
            rutcliente: $('#rutcliente').val(),
            folio:$('#folio').val()

        });
});
//eliminar
 // $('#DeleteAllButton').click(function () {
//         var $selectedRows = $('#PeopleTableContainer').jtable('selectedRows');
//         $('#PeopleTableContainer').jtable('deleteRows', $selectedRows);
//     });




//Initialize validation logic when a form is created
$("#banco").select2();
$("#tipop").select2();
$("#tipopago").select2();
$("#banco1").select2();

$("#inicio").datepicker({dateFormat: 'dd-mm-yy'});
$("#fin").datepicker({dateFormat: 'dd-mm-yy'});

$('#inactivo').on('change', function() {
// From the other examples
if (!this.checked) {
$('#inactivo').val("1");
}else
{
$('#inactivo').val("2");
}
});

 $( "#dialog" ).dialog({
autoOpen: false,
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
"Cancelar": function() {

$( this ).dialog( "close" );
},
"Generar": function() {

  var tp=$("#tipopago").val();
  var plaza1=$("#plaza1").val();
  var titular1=$("#titular1").val();
  var banco1=$("#banco1").val();
  var tran=$("#ntransaccion").val();

 // alert(plaza1);

  $.ajax({
//este es el pago
async:true,
cache:false,
type:"GET",
dataType:"json",
//url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
url:"pagosabonosql_sql.php?action=update&dat="+Dato+"&tipopago="+tp+"&plaza1="+plaza1+"&banco1="+banco1+"&titular1="+titular1+"&tran="+tran,
beforeSend: function () {
},

success: function(response){
    // alert(response);
     $('#jt_pagosabonos').jtable('load');
     $("#dialog").dialog( "close" );
 }

});

}
}
});

$( "#dialog2" ).dialog({
autoOpen: false,
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
"Cancelar": function() {

$( this ).dialog( "close" );
},
"Generar": function() {

 var tpago=$("#tipop").val();
  var plaza=$("#plaza").val();
  var titular=$("#titular").val();
  var banco=$("#banco").val();
  var monto=$("#monto").val();
  var tran2=$("#ntransaccion2").val();

  $.ajax({

async:true,
type:"GET",
dataType:"json",
//url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
url:"pagosabonosql_sql.php?action=compra&dat="+Dat+"&tipopago="+tpago+"&plaza="+plaza+"&banco="+banco+"&titular="+titular+"&monto="+monto+"&ncuotas="+ncuotas+"&igd="+igd+"&tran2="+tran2,
success: function(response){
   //  alert(response);
     $('#jt_pagosabonos').jtable('load');
     $("#dialog2").dialog( "close" );
 }

});



}
}
});

$(".oculto").hide();
$(".oculto2").hide();
   $("#tipop").on("change",function(){
if($("#tipop").val()=="Cheque")
{
$(".oculto").show();
$(".oculto2").hide();

  $("#plaza").val("");
  $("#titular").val("");
  $("#banco").val("");
  $("#monto").val("");
  $("#ntransaccion2").val("");
}
else if($("#tipop").val()=="TarjetaCredito")
{

  $("#plaza").val("");
  $("#titular").val("");
  $("#banco").val("");
  $("#monto").val("");
  $("#ntransaccion2").val("");
$(".oculto").hide();
 $(".oculto2").show();
}else
{

  $("#plaza").val("");
  $("#titular").val("");
  $("#banco").val("");
  $("#monto").val("");
  $("#ntransaccion2").val("");
$(".oculto").hide();
$(".oculto2").hide();
}

});

$("#tipopago").on("change",function(){
if($("#tipopago").val()=="Cheque")
{

$("#plaza1").val("");
$("#titular1").val("");
$("#banco1").val("");
$("#ntransaccion").val("");
$(".oculto").show();
$(".oculto2").hide();
}else if($("#tipopago").val()=="TarjetaCredito")
{

$("#plaza1").val("");
$("#titular1").val("");
$("#banco1").val("");
$("#ntransaccion").val("");
$(".oculto").hide();
$(".oculto2").show();
}else
{

$("#plaza1").val("");
$("#titular1").val("");
$("#banco1").val("");
$("#ntransaccion").val("");
$(".oculto").hide();
$(".oculto2").hide();
}

});
});




</script>

<div id="dialog" title="Pago">
<table>
<tr>
<td><label>Tipo Pago:</label></td>
<td><select id="tipopago" name="tipopago">
<option value="">--SELECCIONAR--</option>
<option value="Cheque">Cheque</option>
    <option value="TarjetaCredito">Tarjeta Credito</option>
    <option value="Efectivo">Efectivo</option>
    </select></td>
</tr>
<tr>
<td><label class="oculto">Plaza</label></td>
<td><input type="text" name="plaza1" class="oculto" id="plaza1" value=""/></td>
</tr>
<tr>
<td><label class="oculto">Titular</label></td>
<td><input type="text" name="titular1" class="oculto" id="titular1" value="<?php echo $banco['titular_cuenta']?>"/></td>
</tr>
<tr>
<td><label class="oculto2">Numero Transaccion</label></td>
<td><input type="text" name="ntransaccion" class="oculto2" id="ntransaccion" value=""/></td>
</tr>
<tr>
<td><label class="oculto">Banco</label></td>
<td><select name="banco1" class="oculto" id="banco1">
<option value="">--SELECCIONE UN BANCO----</option>
<?php
for($b=0;$b<sizeof($banco);$b++)
{
?>
<option value="<?=$banco[$b]["id_cta_cte"]?>"><?=$banco[$b]["DatoBancario"]?></option>
<?php
}
?>
</select></td>
</tr>
</table>
</div>

<div id="dialog2" title="Abono">
<table>
<tr>
<td><label style="color:red;">Monto:</label></td>
<td><input type="text" name="monto" id="monto"/></td>
</tr>
<tr>
<td><label>Tipo Abono:</label></td>
<td><select id="tipop" name="tipop">
<option value="">--SELECCIONAR--</option>
<option value="Cheque">Cheque</option>
    <option value="TarjetaCredito">Tarjeta Credito</option>
    <option value="Efectivo">Efectivo</option>
    </select></td>
</tr>
<tr>
<td><label class="oculto">Plaza</label></td>
<td><input type="text" name="plaza" class="oculto" id="plaza" value=""/></td>
</tr>
<tr>
<td><label class="oculto">Titular</label></td>
<td><input type="text" name="titular" class="oculto" id="titular" value="<?php echo $banco['titular_cuenta'];?>"/></td>
</tr>
<tr>
<td><label class="oculto2">Numero Transaccion</label></td>
<td><input type="text" name="ntransaccion2" class="oculto2" id="ntransaccion2" value=""/></td>
</tr>
<tr>
<td><label class="oculto">Banco</label></td>
<td><select name="banco" class="oculto" id="banco">
<option value="">--SELECCIONE UN BANCO----</option>
<?php
for($b=0;$b<sizeof($banco);$b++)
{
?>
<option value="<?=$banco[$b]["id_cta_cte"]?>"><?=$banco[$b]["DatoBancario"]?></option>
<?php
}
?>
</select></td>
</tr>
</table>
</div>

</body>
</html>
