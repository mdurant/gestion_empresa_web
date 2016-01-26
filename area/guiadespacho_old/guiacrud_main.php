<?php
require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

    if (empty($_SESSION["FAC_FECHABUSQUEDA1"])) { $_SESSION["FAC_FECHABUSQUEDA1"] = date("d-m-Y");  }
    if (empty($_SESSION["FAC_FECHABUSQUEDA2"])) { $_SESSION["FAC_FECHABUSQUEDA2"] = date("d-m-Y");  }

$IDEmpresas = $_GET['IDEmpresa'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Guias de Despacho</title>
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

<h4>Guias de Despacho</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="65%" cellspacing="2" cellpadding="4">
        <tbody><tr>
        <td width="40%">
            <table width="100%">
            <tbody><tr>
                <td><h5>Busqueda:</h5></td>
                <td><input type="text" id="rutcliente" name="rutcliente" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
            </tr>
            </tbody></table>

        </td>
        <td width="20%" align="center">

            <table style="width:300px">
            <tbody><tr>
                  <td style="width: 50px;text-align: center"><h5 style="width:50px">Desde</h5></td>
                  <td><input class="form-control input-sm ui-corner-all " type="text" name="inicio" id="inicio" /></td>
                  <td style="width: 50px;text-align: center"><h5 style="width:50px">Hasta</h5></td>
                  <td><input class="form-control input-sm ui-corner-all " type="text" name="fin" id="fin" /></td>
            </tr>
            </tbody></table>
        </td>
        <td width="20%">
            <table width="100%">
            <tbody><tr>
                <td><h5>Incluir Inactivos </h5></td>
                <td><input type="checkbox" id="inactivo" name="inactivo" value="1"/></td>
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



<div id="jt_guia" style="width:100%;"></div>


<script type="text/javascript">

    $('#inicio').attr('value', '<?php echo $_SESSION["FAC_FECHABUSQUEDA1"]; ?>');
    $('#fin').attr('value', '<?php echo $_SESSION["FAC_FECHABUSQUEDA2"]; ?>');

    $("#inicio").datepicker({
      dateFormat: 'dd-mm-yy'
    });
    $("#fin").datepicker({
      dateFormat: 'dd-mm-yy'
    });


    $(document).ready(function() {

            var msg = {
              deleteConfirmation: 'Realmente desea Anular esta Guia',
              deleteText: 'Anular'

            };
            //Prepare jTable
            $('#jt_guia').jtable({
                    messages: msg,
                    jqueryuiTheme: true,
                    title: 'Gesti&oacute;n de Guias de Despacho',
                    paging: true,
                    pageSize: 10,
                    sorting: true,
                    openChildAsAccordion: true,
                    //Enable this line to show child tabes as accordion style
                    defaultSorting: 'IdEGuiaDespacho ASC',
                    selecting: false,
                    //Enable selecting
                    multiselect: false,
                    //Allow multiple selecting
                    selectingCheckboxes: false,
                    //Show checkboxes on first column
                    //selectOnRowClick: true, //Enable this to only select using checkboxes
                    toolbar: {
                            items: [{
                              icon: '../../toolbar-icon/ot.png',
                              text: 'Crear Nueva Guia Despacho',
                              click: function() {

                                      window.location = 'guia_main.php?IDEmpresa=' + '<?=$IDEmpresas?>';

                              }
                            }]
                    },
                    actions: {
                        listAction:    'guiasql_sql.php?action=list',
                        deleteAction:     'guiasql_sql.php?action=delete'
                    },
                    fields: {
                            IdEGuiaDespacho: {
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
                              var $img = $('<center><button title="Detalle" class="btn btn-default btn-sm ui-corner-all" type="button" ><span class="glyphicon glyphicon-list"></span></button></center>');
                              //Open child table when user clicks the image
                              $img.click(function () {

                                  //aqui***************

                                  $('#jt_guia').jtable('openChildTable',
                                      $img.closest('tr'),
                                      {
                                            title: 'Detalle Guia Despacho',
                                            paging: true,
                                            pageSize: 10,
                                            sorting: false,
                                            selecting:true,
                                            defaultSorting: 'IdDGuia ASC',
                                            actions: {
                                                listAction: 'guiadet_sql.php?action=list&IDPerfil='+ datos.record.IdEGuiaDespacho,
                                            },
                                            fields: {
                                                IdEGuiaDespacho: {
                                                  type: 'hidden',
                                                  defaultValue: datos.record.IdEGuiaDespacho
                                                },
                                                IdDGuia: {
                                                  key: true,
                                                  create: false,
                                                  edit: false,
                                                  list: false
                                                },
                                                ProductName: {
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
                                                  title: 'Valor Neto',
                                                  width: '30%',
                                                  create: true,
                                                  edit: true,
                                                  list: true
                                                },
                                                Descuento: {
                                                  title: 'Descuento %',
                                                  width: '20%',
                                                  create: true,
                                                  edit: false,
                                                  list: true
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
                            Cliente:{
                                  title: 'Cliente',
                                  width: '30%',
                                  create: true,
                                  edit: false,
                                  list: true

                              },
                              RazonSocial:
                              {
                                  title: 'Generado por:',
                                  width: '30%',
                                  create: true,
                                  edit: false,
                                  list: true

                              },
                              Numero:
                              {
                                  title: 'Número',
                                  width: '10%',
                                  create: true,
                                  edit: false,
                                  list: true
                              },
                              Total: {
                                  title: 'Total Guia ($)',
                                  width: '10%',
                                  create: true,
                                  edit: false,
                                  list: true
                              },
                            FechaCreacion:
                            {
                                    title: 'F/Creaci&oacute;n',
                                    width: '10%',
                                    type: 'date',
                                    displayFormat: 'dd-mm-yy',
                                    list: true
                            },
                            estadocontable: {
                                        title: 'Estado',
                                        width: '20%',
                                        create: true,
                                        //options: {"Emitida":"Emitida","activo":"activo","inactivo":"inactivo"},
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
                                        var $img = $('<center><button title="Explorar a PDF" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../../toolbar-icon/pdf.gif" title="" /></button></center>');
                                        $img.on("click", function() {

                                           // alert(datos.record.IdEGuiaDespacho);

                                            //window.location = "../../reportes/guia_despacho.php?IdEGuiaDespacho=" + datos.record.IdEGuiaDespacho;
                                            //window.location = "../../reportes/cotizacion.php";
                                            window.location = "../../reportes/guia_despacho.php";


                                        });
                                        return $img;
                                    }
                            }



                          },
                          formClosed: function(event, data) {
                                $('#jt_guia').jtable('load');
                             }

              });


                      //Load person list from server
                      $('#jt_guia').jtable('load');

                      //buscar por clientes
                       $('#btnBUSCAR').on('click',function(e) {
                      e.preventDefault();
                      $('#jt_guia').jtable('load', {
                      rutcliente: $('#rutcliente').val(),
                      inicio:$('#inicio').val(),
                      fin:$("#fin").val(),
                      inactivo: $('#inactivo').val()

                      });
              });
                      //eliminar
                       // $('#DeleteAllButton').click(function () {
              //         var $selectedRows = $('#PeopleTableContainer').jtable('selectedRows');
              //         $('#PeopleTableContainer').jtable('deleteRows', $selectedRows);
              //     });




                  //Initialize validation logic when a form is created


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



          function devolucion(dato){
                $.ajax({
                    async:true,
                    cache:false,
                    type:"GET",
                    url:"guiasql_sql.php?action=devolucion&id_guia="+dato,
                    success: function(response){
                                alert(response);
                     }
                    });

          }



            });





</script>




</body>
</html>
