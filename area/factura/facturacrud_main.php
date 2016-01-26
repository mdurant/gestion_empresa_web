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
<title>Facturas de Venta</title>
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

<h4>Facturas de Venta</h4>
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



<div id="jt_factura" style="width:100%;"></div>


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
              deleteConfirmation: 'Realmente desea Anular esta Factura',
              deleteText: 'Anular'

            };
            //Prepare jTable
            $('#jt_factura').jtable({
                    messages: msg,
                    jqueryuiTheme: true,
                    title: 'Gesti&oacute;n de Factura',
                    paging: true,
                    pageSize: 10,
                    sorting: true,
                    multiSorting: true,
                    openChildAsAccordion: true,
                    //Enable this line to show child tabes as accordion style
                    defaultSorting: 'Cliente ASC',
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
                              text: 'Crear Nueva Factura',
                              click: function() {

                                      window.location = 'factura_main.php?IDEmpresa=' + '<?=$IDEmpresas?>';

                              }
                            }]
                    },
                    actions: {
                        listAction:    'facturasql_sql.php?action=list',
                        deleteAction:  'facturasql_sql.php?action=delete'
                    },
                    fields: {
                            IdEFactura: {
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

                                  $('#jt_factura').jtable('openChildTable',
                                      $img.closest('tr'),
                                      {
                                            title: 'Detalle Productos',
                                            paging: true,
                                            pageSize: 10,
                                            sorting: false,
                                            selecting:true,
                                            defaultSorting: 'IdDFactura ASC',
                                            actions: {
                                                listAction: 'facturadet_sql.php?action=list&IDFactura='+ datos.record.IdEFactura,
                                            },
                                            fields: {
                                                IdEFactura: {
                                                  type: 'hidden',
                                                  defaultValue: datos.record.IdEFactura
                                                },
                                                IdDFactura: {
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
                                  title: 'Facturado por:',
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
                                  title: 'Total Factura($)',
                                  width: '20%',
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
                            Estado: {
                                        title: 'Estado',
                                        width: '20%',
                                        create: true,
                                        options: {"Facturada":"Facturar","activo":"activo","inactivo":"inactivo"},
                                        edit: true,
                                        list: true
                            },
                            Referencia: { list: false },
                            Devolucion: {
                                    title: '',
                                    width: '2%',
                                    sorting: false,
                                    edit: false,
                                    create: false,
                                    display: function (datos) {
                                        //Create an image that will be used to open child table
                                        var $img = $('<center><button title="Devolucion" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../../toolbar-icon/abono.gif" title="" /></button></center>');
                                        $img.on("click",function(){

                                            dato=datos.record.IdEFactura;
                                            devolucion(dato);

                                        });
                                        return $img;
                                    }
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

                                            window.open("../../reportes/factura_ventas.php?IdEFactura=" + datos.record.IdEFactura);
                                            //window.location = "../../reportes/cotizacion.php";

                                        });
                                        return $img;
                                    }
                            }



                          },
                          formClosed: function(event, data) {
                                $('#jt_factura').jtable('load');
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
            
           $(".jtable-main-container tr").find("td:eq(4)").each(function () {
                        $(this).text(Moneda($(this).text()));
                       
            });


            $(".jtable-child-table-container tr").find("th:eq(2)").each(function () {
                        $(this).text(Moneda($(this).text()));
                       
            });
        },


        });
                      //Load person list from server
                      $('#jt_factura').jtable('load');

                      //buscar por clientes
                       $('#btnBUSCAR').on('click',function(e) {
                      e.preventDefault();
                      $('#jt_factura').jtable('load', {
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
                    url:"facturasql_sql.php?action=devolucion&id_factura="+dato,
                    success: function(response){
                                alert(response);
                     }
                    });

          }



            });





</script>




</body>
</html>
