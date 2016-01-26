<?php
require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

    if (empty($_SESSION["COT_FECHABUSQUEDA1"])) { $_SESSION["COT_FECHABUSQUEDA1"] = date("d-m-Y");  }
    if (empty($_SESSION["COT_FECHABUSQUEDA2"])) { $_SESSION["COT_FECHABUSQUEDA2"] = date("d-m-Y");  }

$IDEmpresas = $_GET['IDEmpresa'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Gestión de Cotizaciones</title>

<!-- bootstrap -->
    <script src="../../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <link  href="../../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- jquery -->
    <script src="../../scripts/jquery/jquery.js" type="text/javascript"></script>
    <script src="../../scripts/jquery/jquery-ui.js" type="text/javascript"></script>
    <link  href="../../scripts/jquery/themes/<?=$ACTUAL_THEME?>/jquery-ui.css" rel="stylesheet" type="text/css" />

    <!-- jtable -->
    <script src="../../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
    <script src="../../scripts/jtable/jquery.jtable.es.js" type="text/javascript"></script>
    <script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript"></script>
    <link  href="../../scripts/jtable/themes/<?=$JTABLE_THEME?>" rel="stylesheet" type="text/css" />

    <!-- jquery.validationEngine -->
    <!--<script src="../../scripts/jquery/validate/jquery.validationEngine.js" type="text/javascript" ></script>
    <script src="../../scripts/jquery/validate/jquery.validationEngine-es.js" type="text/javascript"></script>
    <link  href="../../scripts/jquery/validate/validationEngine.jquery.css" rel="stylesheet" type="text/css" />-->



</head>
<style>

form.jtable-dialog-form {
  width:450px;
}
#btn
{
    cursor: pointer;
}

</style>
<body class="ui-widget">

<h4>Cotizaciones</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="85%" cellspacing="2" cellpadding="4">
        <tbody><tr>
        <td width="40%">
            <table width="100%">
            <tbody><tr>
                <td><h5>Buscar</h5></td>
                <td><input type="text" id="rutcliente" name="rutcliente" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
            </tr>
            </tbody></table>
        </td>
        <td width="30%" align="center">
            <table style="width:100%">
            <tbody><tr>
                  <td style="width: 50px;text-align: center"><h5 style="width:50px">Desde</h5></td>
                  <td><input class="form-control input-sm ui-corner-all " type="text" name="inicio" id="inicio" /></td>
                  <td style="width: 50px;text-align: center"><h5 style="width:50px">Hasta</h5></td>
                  <td><input class="form-control input-sm ui-corner-all " type="text" name="fin" id="fin" /></td>
                  <td align="center">
                      <button style="height: 30px; width: 40px" aria-disabled="false" role="button"
                          class="ui-button ui-widget ui-state-default ui-corner-all"
                          id="btnHOY" type="submit">Hoy
                  </button></td>
            </tr>
            </tbody></table>
        </td>
        <td width="20%">
            <table width="100%">
            <tbody><tr>
                <td style="width: 110px; text-align: right"><h5 >Incluir Inactivos </h5></td>
                <td style="width: 50px; text-align: center">
                  <input type="checkbox" id="inactivo" name="inactivo" value="1"/></td>
            </tr>
            </tbody></table>
        </td>
        <td width="20%" align="center">
            <button style="height: 30px; width: 100px" aria-disabled="false" role="button"
                class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary"
                id="btnBUSCAR" type="submit">
            <span class="ui-icon ui-icon-search"></span>
            <span class="ui-button-text">Buscar</span>
        </button></td>
        </tr>
    </tbody>
    </table>
    </form>
</div>
<div style="height: 5px;width: 100%;"></div>

<div id="jt_cotizacion" style="width: 100%;"></div>

<div style="height: 5px;width: 100%;"></div>
<div style="width: 100%;">
    <table  class="jtable ui-widget-content" width="100%">
        <tbody >
            <tr id="tr_detalle"></tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">

          $('#inicio').attr('value', '<?php echo $_SESSION["COT_FECHABUSQUEDA1"]; ?>');
          $('#fin').attr('value', '<?php echo $_SESSION["COT_FECHABUSQUEDA2"]; ?>');

          $("#inicio").datepicker({
              dateFormat: 'dd-mm-yy'
          });
          $("#fin").datepicker({
              dateFormat: 'dd-mm-yy'
          });


        $(document).ready(function () {

             var msg = {
            deleteConfirmation: 'Realmente desea Anular esta cotizacion',
            deleteText: 'Anular',
            save: 'Facturar',
            editRecord: 'Facturar Cotizacion',

        };
            //Prepare jTable
            $('#jt_cotizacion').jtable({
                messages: msg,
                jqueryuiTheme: true,
                title: 'Listado Cotizaciones',
                paging: true,
                pageSize: 5,
                sorting: true,
                openChildAsAccordion: true, //Enable this line to show child tabes as accordion style
                defaultSorting: 'IdECotizacion ASC',
                selecting: true, //Enable selecting
                multiselect: false, //Allow multiple selecting
                selectingCheckboxes: false, //Show checkboxes on first column
                //selectOnRowClick: true, //Enable this to only select using checkboxes
                toolbar: {
                            items: [{
                                icon: '../../toolbar-icon/ot.png',
                                text: 'Crear Nueva Cotizacion',
                                click: function () {

                                  window.location = 'cotizacion_main.php?IDEmpresa='+'<?=$IDEmpresas?>';

                                }
                            }]
                },
                actions: {
                  listAction: 'cotizacionsql_sql.php?action=list',
                  deleteAction: 'cotizacionsql_sql.php?action=delete'
                },
                fields: {
                  IdECotizacion: {
                    key: true,
                    create: false,
                    edit: false,
                    list: false
                  },
                  Cliente: {
                    title: 'Nombre',
                    width: '30%',
                    create: true,
                    edit: false,
                    list: true

                  },
                  Accion: {
                    title: 'Para Facturar',
                    width: '20%',
                    edit: true,
                    input: function(data) {
                      return '<p>Seleccione Facturarada</p>';
                    },
                    list: false

                  },
                  RazonSocial: {
                    title: 'Razon Social',
                    width: '35%',
                    create: true,
                    edit: false,
                    list: true

                  },
                  Contador: {
                    title: 'Número',
                    width: '10%',
                    create: true,
                    edit: false,
                    list: true
                  },
                  Total: {
                    title: 'Total $',
                    width: '10%',
                    create: true,
                    edit: false,
                    list: true
                  },
                  FechaCreacion: {
                    title: 'Fecha de Creaci&oacute;n',
                    width: '20%',
                    type: 'date',
                    displayFormat: 'dd-mm-yy',
                    edit: false,
                    list: true
                  },
                  Estado: {
                    title: 'Estado',
                    width: '5%',
                    create: true,
                    options: {
                      "Facturada": "Facturada",
                      "activo": "activo",
                      "inactivo": "inactivo",
                      "OTC": "OTC"
                    },
                    edit: true,
                    list: true
                  },
                /* OrdenTrabajo: {
                        title: '',
                        width: '2%',
                        list: true,
                        display: function (data) {
                              var $img = $('<center><button title="Generar Orden de Trabajo" class="btn btn-default btn-sm ui-corner-all" type="button" ><span class="glyphicon glyphicon-wrench"></span></button></center>');
                              $img.on("click",function () {

                                        $( "#dialogOT" ).dialog( "open" );
                                        $(".ui-dialog").css('top','0px');
                                        Dato=data.record.IdECotizacion;

                              });
                              //Return image to show on the person row
                              return $img;
                        }
                  },*/
                  Factura: {
                    title: '',
                    width: '2%',
                    list: true,
                    display: function(data) {
                      //Create an image that will be used to open child table
                      var $img = $('<center><button title="Generar Factura" class="btn btn-default btn-sm ui-corner-all" type="button" ><span class="glyphicon glyphicon-usd"></span></button></center>');
                      //Open child table when user clicks the image
                      $img.on("click", function() {


                        $("#dlgGENERARFACTURA").dialog("open");
                        $(".ui-dialog").css('top','0px');

                        Dat = data.record.IdECotizacion;



                      });
                      //Return image to show on the person row
                      return $img;
                    }
                  },
                  PDF: {
                    title: '',
                    width: '1%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(datos) {
                      //Create an image that will be used to open child table
                      var $img = $('<center><button title="Ver Documento" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../../toolbar-icon/pdf.gif" style="cursor:pointer;" title="" /></button></center>');
                      $img.on("click", function() {

                          //alert(datos.record.Contador);

                          window.location = "../../reportes/cotizacion.php?contador=" + datos.record.Contador;
                          //window.location = "../../reportes/cotizacion.php";

                      });
                      return $img;
                    }
                  },
                  Edicion: {
                        title: '',
                        width: '1%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(datos) {
                            //Create an image that will be used to open child table
                            var $img = $('<center><button title="Modificar O.T." class="btn btn-default btn-sm ui-corner-all" type="button" ><span class="glyphicon glyphicon-pencil"></span></button></center>');
                            $img.on("click", function() {

                                window.location = "cotizacion_main.php?id_cotizacion=" + datos.record.IdECotizacion;

                            });
                            return $img;
                        }
                    }

                },
                selectionChanged: function(event, data) {

                        var record;
                        var $selectedRows = $(this).jtable('selectedRows');


                        if ($selectedRows.length > 0) {
                            record = $selectedRows.data('record');


                            $('#jt_cotizacion').jtable('openChildTable', $("#tr_detalle"), {
                                title: 'Detalle de Cotizaci&oacute;n:',
                                paging: true,
                                pageSize: 10,
                                tableId: 'jt_cotizacion_detalle',
                                sorting: true,
                                showCloseButton: false,
                                selecting: true,
                                defaultSorting: 'IdDCotizacion ASC',
                                actions: {
                                  listAction: 'cotizaciondet_sql.php?action=list&IDPerfil=' + record.IdECotizacion,
                                },
                                fields: {
                                  IdECotizacion: {
                                    type: 'hidden',
                                    defaultValue: record.IdECotizacion
                                  },
                                  IdDCotizacion: {
                                    key: true,
                                    create: false,
                                    edit: false,
                                    list: false
                                  },
                                  Descripcion: {
                                    title: 'Producto/Servicio',
                                    width: '30%',
                                    create: true,
                                    edit: true,
                                    list: true
                                  },
                                  Cantidad: {
                                    title: 'Cantidad',
                                    width: '30%',
                                    create: true,
                                    edit: true,
                                    list: true
                                  },
                                  Neto: {
                                    title: 'Valor Neto($)',
                                    width: '30%',
                                    create: true,
                                    edit: true,
                                    list: true
                                  },
                                  Descuento: {
                                    title: 'Descuento',
                                    width: '20%',
                                    create: true,
                                    edit: false,
                                    list: false
                                  }
                                }
                              }, function(data) { //opened handler
                                data.childTable.jtable('load');
                                hello = data.childTable;
                                return hello;
                              });


                        } else {

                              $('#jt_cotizacion_detalle').parent().parent().css('display','none');

                              return;
                        }
                },

                recordsLoaded: function(event, data) {

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

            $(".jtable-main-container tr").find("td:eq(3)").each(function () {
                        $(this).text(Moneda($(this).text()));
            });
        },


      



                formClosed: function(event, data) {
                  $('#jt_cotizacion').jtable('load',{
                    rutcliente: $('#rutcliente').val(),
                    inicio: $('#inicio').val(),
                    fin: $("#fin").val(),
                    inactivo: $('#inactivo').val()

                  });
                }

                });


                //Load person list from server
                $('#jt_cotizacion').jtable('load', {
                    rutcliente: $('#rutcliente').val(),
                    inicio: $('#inicio').val(),
                    fin: $("#fin").val(),
                    inactivo: $('#inactivo').val()

                  });

                //buscar por clientes
                $('#btnBUSCAR').on('click', function(e) {
                  e.preventDefault();
                  $('#jt_cotizacion').jtable('load', {
                    rutcliente: $('#rutcliente').val(),
                    inicio: $('#inicio').val(),
                    fin: $("#fin").val(),
                    inactivo: $('#inactivo').val()

                  });
                });
//eliminar
// $('#DeleteAllButton').click(function () {
//         var $selectedRows = $('#PeopleTableContainer').jtable('selectedRows');
//         $('#PeopleTableContainer').jtable('deleteRows', $selectedRows);
//     });




//Initialize validation logic when a form is created


$("#inicio").datepicker({
  dateFormat: 'dd-mm-yy'
});
$("#fin").datepicker({
  dateFormat: 'dd-mm-yy'
});



$('#inactivo').on('change', function() {
  // From the other examples
  if (!this.checked) {
    $('#inactivo').val("1");
  } else {
    $('#inactivo').val("2");
  }
});

$("#dialogOT").dialog({
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

      $(this).dialog("close");
    },
    "Generar": function() {


      $.ajax({

        async: true,
        cache: false,
        type: "GET",
        dataType: "json",
        //url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
        url: "cotizacionsql_sql.php?action=ot&dat=" + Dato,
        beforeSend: function() {},

        success: function(response) {
          // alert(response);
          $('#jt_cotizacion').jtable('load');
          $("#dialog").dialog("close");
        }

      });



    }
  }
});






$("#dlgGENERARFACTURA").dialog({
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

      $(this).dialog("close");
    },
    "Generar": function() {


      $.ajax({

        async: true,
        type: "GET",
        dataType: "json",
        //url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
        url: "cotizacionsql_sql.php?action=generarfactura&dato=" + Dat,
        success: function(response) {

            if (response.Result=="ERROR") {
              alert(response.Message);
            }

            $('#jt_cotizacion').jtable('load');
            $("#dlgGENERARFACTURA").dialog("close");
        }

      });



    }
  }
});

});

</script>

<div id="dialogOT" title="OT">
  <p>Generar Orden de Trabajo?</p>
</div>

<div id="dlgGENERARFACTURA" title="Facturar">
  <p>Generar Factura?</p>
</div>

</body>
</html>
