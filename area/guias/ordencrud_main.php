<?php
require_once("../../validatesession_html.php");
$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

//$IDEmpresas = $_SESSION['SESS_EMPRESA_ID']; //$_GET['IDEmpresa'];

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
    <link  href="../../scripts/jtable/themes/<?=$JTABLE_THEME?>" rel="stylesheet" type="text/css" />

    
</head>
<style>

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
        <td width="60%">
            <table width="100%">
            <tbody><tr>
                <td><h5 style="width:30px">Buscar </h5></td>
                <td><input type="text" id="guia_despacho" name="guia_despacho" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
            </tr>
            </tbody></table>

        </td>
        <td width="20%" align="center">

            <table style="width:130px">
            <tbody><tr>
                <td><h5>Incluir Inactivos </h5></td>
                <td><input type="checkbox" style="vertical-align: middle;" value="1" name="inactivo" id="inactivo"></td>
            </tr>
            </tbody></table>

        </td>
        <td width="20%" align="center">
            <button style="height: 30px; width: 100px" aria-disabled="false" role="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="btnBUSCAR" type="submit">
            <span class="ui-icon ui-icon-search"></span>
            <span class="ui-button-text">Buscar</span>

        </button></td>
        </tr>
    </tbody>
    </table>
    </form>
</div>
<div style="height: 5px;width: 100%;"></div>


<div id="jt_guias" style="width: 100%;"></div>


<script type="text/javascript">

        $(document).ready(function() {

            //Prepare jTable
            $('#jt_guias').jtable({
                jqueryuiTheme: true,
                title: 'Listado',
                paging: true,
                pageSize: 10,
                sorting: true,
                openChildAsAccordion: true,
                //Enable this line to show child tabes as accordion style
                defaultSorting: 'IdEGuiaDespacho ASC',
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
                        text: 'Ingresar Nueva Guia',
                        click: function() {

                            window.location = 'orden_main.php';

                        }
                    }]
                },
                actions: {
                    listAction:   'ordensql_sql.php?action=list',
                    deleteAction: 'ordensql_sql.php?action=delete'
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
                        display: function(datos) {
                            //Create an image that will be used to open child table
                            var $img = $('<center><button title="Productos de la Guia" class="btn btn-default btn-sm ui-corner-all" type="button" ><span class="glyphicon glyphicon-list"></span></button></center>');
                            //Open child table when user clicks the image
                            $img.click(function() {

                                //aqui*************** Primer Hijo

                                $('#jt_guias').jtable('openChildTable', $img.closest('tr'), {
                                    title: 'Detalle:',
                                    paging: true,
                                    pageSize: 10,
                                    sorting: false,
                                    selecting: true,
                                    defaultSorting: 'IdDGuia ASC',
                                    actions: {
                                        listAction: 'ordendet_sql.php?action=list&guia=' + datos.record.IdEGuiaDespacho,
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
                                            width: "30%",
                                            list: true,
                                            edit: true
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
                                    },
                                }, function(data) { //opened handler
                                    data.childTable.jtable('load');
                                    hello = data.childTable;
                                    return hello;

                                });
                            });
                             return $img;
                        }
                    },

                    Cliente: {
                        title: 'Cliente',
                        width: '30%',
                        create: true,
                        edit: false,
                        list: true

                    },
                    RazonSocial: {
                        title: 'Generado por:',
                        width: '30%',
                        create: true,
                        edit: false,
                        list: true
                    },
                    Numero: {
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
                    FechaCreacion: {
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
                        edit: true,
                        list: true
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
                        $img.on("click", function()
                        {
                            //alert(datos.record.id_orden);
                            window.location = "../../reportes/ordentrabajo.php?id_orden=" + datos.record.id_orden;
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

                                window.location = "orden_main.php?id_orden=" + datos.record.id_orden;

                            });
                            return $img;
                        }
                    }

                },

                //cuando se cierra el dialog
                formClosed: function(event, data) {
                    $('#jt_guias').jtable('load');
                },

                recordsLoaded: function() {
                    $(".jtable-toolbar").attr("id", "minuevoidmaslargoque");
                }


            });


            //Load person list from server
            $('#jt_guias').jtable('load');

            //buscar por clientes
            $('#btnBUSCAR').on('click', function(e) {
                e.preventDefault();
                $('#jt_guias').jtable('load', {
                    ordenes: $('#ordenes').val(),
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

        //dialogos
        $("#dialogo-factura").dialog({
            autoOpen: false,
            width: 300,
            heigth: 300,
            position: 'top',
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
                  "Guardar": function() {

                        var datasrl = $("#formularios").serialize();
                        $.ajax({

                              async: true,
                              cache: false,
                              type: "POST",
                              dataType: "json",
                              url: "asociar_folio.php",
                              data: datasrl,
                              success: function(response) {
                                    alert("Se Guardo Correctamente");
                                      $("#dialogo-factura").dialog("close");
                                      $("#fol").val("");
                                      $('#jt_guias').jtable('reload');
                              }

                        });


                  },
                  "Cerrar": function() {
                        $(this).dialog("close");

                  }
            }
      });


        });


</script>
<!-- Mauricio Duran : Titulo Folio Factura más descriptivo" -->
<div id="dialogo-factura" title="Ingrese Folio Factura Venta" style="width: 100%; display:none">

    <form id="formularios" method="post">
        <br />
        <center><input class="form-control input-sm ui-corner-all" type="text" name="fol" id="fol" value="" /></center>
        <input type="hidden" name="id_ots" id="id_ots" />
    </form>

</div>
</body>
</html>
