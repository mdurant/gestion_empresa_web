<?php
// Se cambia a "Descripción el detalle del Producto de la Venta (child)
// Se cambia a columna "Descuento" por -> Neto de Prodcuto, para que la columna sea representativa
// Mauricio Duran

require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

    if (empty($_SESSION["BOL_FECHABUSQUEDA1"])) { $_SESSION["BOL_FECHABUSQUEDA1"] = date("d-m-Y");  }
    if (empty($_SESSION["BOL_FECHABUSQUEDA2"])) { $_SESSION["BOL_FECHABUSQUEDA2"] = date("d-m-Y");  }

$Empresa = $_SESSION['SESS_EMPRESA_ID'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Boleta de Venta</title>
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

  h2 h3{

      font-family: Lucida Sans Unicode, Verdana, Tahoma;
      font-size: 15px;
      color:#333131;
      text-decoration: none;
  }
  h2 a{
      text-decoration: none;
  }


</style>
<body class="ui-widget">

<h4>Boleta de Venta</h4>

<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px">
  <form style="margin: 0px">
    <table width="85%" cellspacing="2" cellpadding="4">
      <tbody>
    <tr>
      <td width="40%">
        <table width="100%">
          <tbody>
        <tr>
          <td>
            <h5>Buscar</h5>
          </td>

          <td><input type="text" id="rutcliente" name="rutcliente" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all"></td>
        </tr>
          </tbody>
        </table>
      </td>

      <td width="20%" align="center">
        <table style="width:285px">
          <tbody>
        <tr>
          <td style="width: 50px;text-align: center">
            <h5 style="width:50px">Desde</h5>
          </td>

          <td><input class="form-control input-sm ui-corner-all" type="text" name="inicio" id="inicio"></td>

          <td style="width: 50px;text-align: center">
            <h5 style="width:50px">Hasta</h5>
          </td>

          <td><input class="form-control input-sm ui-corner-all" type="text" name="fin" id="fin"></td>
        </tr>
          </tbody>
        </table>
      </td>

      <td width="20%">
        <table width="100%">
          <tbody>
        <tr>
          <td style="width: 110px; text-align: right">
            <h5>Incluir Inactivos</h5>
          </td>

          <td style="width: 50px; text-align: center"><input type="checkbox" id="inactivo" name="inactivo" value="1"></td>
        </tr>
          </tbody>
        </table>
      </td>

      <td width="20%" align="center"><button style="height: 30px; width: 100px" aria-disabled="false" role="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="btnBUSCAR" type="submit"><span class="ui-button-text">Buscar</span></button></td>
    </tr>
      </tbody>
    </table>
  </form>
</div>

<div style="height: 5px;width: 100%;"></div>

<div id="jt_boletas" style="width:100%"></div>

<div style="height: 5px;width: 100%;"></div>
<div style="width: 100%;">
    <table  class="jtable ui-widget-content" width="100%">
        <tbody >
            <tr id="tr_detalle"></tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">

        $('#inicio').attr('value', '<?php echo $_SESSION["BOL_FECHABUSQUEDA1"]; ?>');
        $('#fin').attr('value', '<?php echo $_SESSION["BOL_FECHABUSQUEDA2"]; ?>');

        $("#inicio").datepicker({
          dateFormat: 'dd-mm-yy'
        });
        $("#fin").datepicker({
          dateFormat: 'dd-mm-yy'
        });

        $(document).ready(function() {

          var msg = {
        deleteConfirmation: 'Realmente desea Anular esta boleta',
        deleteText: 'Anular'

          };
          //Prepare jTable
      $('#jt_boletas').jtable({
        messages: msg,
        jqueryuiTheme: true,
        title: 'Gesti&oacute;n de boletas',
        paging: true,
        pageSize: 10,
        sorting: true,
        openChildAsAccordion: true,
        //Enable this line to show child tabes as accordion style
        defaultSorting: 'id_boleta ASC',
        selecting: true,
        //Enable selecting
        multiselect: false,
        //Allow multiple selecting
        selectingCheckboxes: false,
        //Show checkboxes on first column
        //selectOnRowClick: true, //Enable this to only select using checkboxes
        toolbar: {
          items: [{
            icon: '../../toolbar-icon/ot.png',
            text: 'Crear Nueva Boleta',
            click: function() {

              window.location = 'boleta_main.php'; //?IDEmpresa=' + '<?=$IDEmpresas?>';

            }
          }]
        },
        actions: {
          listAction: 'boletasql_sql.php?action=list',
          deleteAction: 'boletasql_sql.php?action=delete'
        },
        fields: {
          id_boleta: {
            key: true,
            create: false,
            edit: false,
            list: false
          },
          folio_boleta: {
            title: 'Folio Boleta',
            width: '10%',
            create: false,
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
            title: 'Empresa Vendedora',
            width: '30%',
            create: true,
            edit: false,
            list: true

          },
            Suppliers:{
            title: 'Cliente',
            width: '30%',
            create: true,
            edit: false,
            list: true
            },
          contador: {
            title: 'Número',
            width: '20%',
            create: true,
            edit: false,
            list: true
          },
          total: {
            title: 'Total $',
            width: '20%',
            create: true,
            edit: false,
            list: true
          },
          fecha_ingreso: {
            title: 'Fecha de Creaci\u00f3n',
            width: '20%',
            type: 'date',
            displayFormat: 'dd-mm-yy',
            edit: false,
            list: true
          },
          estado: {
            title: 'Estado',
            width: '10%',
            create: true,
            options: {
              "Facturada": "Facturar",
              "activo": "activo",
              "inactivo": "inactivo"
            },
            edit: true,
            list: true
          },
          PDF: {
            title: '',
            width: '2%',
            sorting: false,
            edit: false,
            create: false,
            display: function (datos) {
                //Create an image that will be used to open child table
                var $img = $('<center><button title="Exportar a PDF" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../../toolbar-icon/pdf.gif" title="" /></button></center>');
                    $img.on("click", function() {
                        //alert(datos.record.Contador);

                        window.location = "../../reportes/boleta_venta.php?contador=" + datos.record.contador;
                        //window.location = "../../reportes/cotizacion.php";

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
    //alert (record.contador); Mostrar cual dato trae
                $('#jt_boletas').jtable('openChildTable', $("#tr_detalle"), {
                  title: 'Detalle Boletas de Venta:',
                  tableId: 'jt_boletas_productos',
                  paging: true,
                  showCloseButton: false,
                  selecting: true,
                  pageSize: 10,
                  sorting: false,
                  defaultSorting: 'id_eboleta ASC',
                  actions: {

                    listAction: 'boletadet_sql.php?action=list&IDPerfil=' + record.contador,
                  },

                  fields: {
                    id_eboleta: {
                      type: 'hidden',
                      defaultValue: record.id_eboleta
                    },
                    id_dboleta: {
                      key: true,
                      create: false,
                      edit: false,
                      list: false
                    },
                    contador: {
                      title: 'Número',
                      width: "20%",
                      list: false
                    },
                    ProductName: {
                      title: 'Producto',
                      width: '30%',
                      create: true,
                      edit: true,
                      list: true
                    },
                    cantidad: {
                      title: 'Cantidad',
                      width: '30%',
                      create: true,
                      edit: true,
                      list: true
                    },
                    neto_detalle: {
                      title: 'Valor Producto ($)',
                      width: '20%',
                      create: true,
                      edit: false,
                      list: true
                    }
                  }
                },
                function(data) { //opened handler
                  data.childTable.jtable('load');
                  hello = data.childTable;
                  return hello;
                });


            } else {

                  $('#jt_boletas_productos').parent().parent().css('display','none');

                  return;
            }


        }


      });


          //Load person list from server
          $('#jt_boletas').jtable('load');

          //buscar por clientes
          $('#btnBUSCAR').on('click', function(e) {
        e.preventDefault();
        $('#jt_boletas').jtable('load', {
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

          $("#dialog").dialog({
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
          "Anular": function() {
            var $selectedRows = $('#jt_cotizacion').jtable('selectedRows');
            $('#jt_cotizacion').jtable('deleteRows', $selectedRows);
            $(this).dialog("close");
          }
        }
          });






          $("#dialog2").dialog({
        autoOpen: false,
        show: {
          effect: "fade",
          duration: 500
        },
        hide: {
          effect: "fade",
          duration: 500
        }
          });

          $('#inactivo').on('change', function() {
        // From the other examples
        if (!this.checked) {
          $('#inactivo').val("1");
        } else {
          $('#inactivo').val("2");
        }
          });



        });
</script>

<div id="dialog" title="Basic dialog">
  <p>Desea Anular</p>
</div>



</body>
</html>
