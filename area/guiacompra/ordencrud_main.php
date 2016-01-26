<?php
require_once("../../validatesession_html.php");
$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

$IDEmpresas = $_SESSION['SESS_EMPRESA_ID']; //$_GET['IDEmpresa'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Gestión Guias Despacho - Compras</title>

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

<h4>Gestión Guias Despacho - Compras</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="65%" cellspacing="2" cellpadding="4">
        <tbody><tr>
        <td width="60%">
            <table width="100%">
            <tbody><tr>
                <td><h5 style="width:30px">Buscar </h5></td>
                <td><input type="text" id="guia_compra" name="guia_compra" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
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


<div id="jt_guias_compra" style="width: 100%;"></div>


<script type="text/javascript">

        $(document).ready(function() {

            //Prepare jTable
            $('#jt_guias_compra').jtable({
                jqueryuiTheme: true,
                title: 'Listado',
                paging: true,
                pageSize: 10,
                sorting: true,
                openChildAsAccordion: true,
                //Enable this line to show child tabes as accordion style
                defaultSorting: 'ideguiacompra ASC',
                selecting: true,
                //Enable selecting
                multiselect: true,
                //Allow multiple selecting
                selectingCheckboxes: false,
                //Show checkboxes on first column
                //selectOnRowClick: true, //Enable this to only select using checkboxes
                toolbar: {
                    items: [{
                        icon: '../../toolbar-icon/ot.png',
                        text: 'Registrar Guia Despacho Compra',
                        click: function() {

                            window.location = 'orden_main.php';

                        }
                    },{
                        icon: '../../toolbar-icon/ot.png',
                        text: 'Asociar Folio',
                        click: function () {

                            var $selectedRows = $('#jt_guias_compra').jtable('selectedRows');
                            controlador =1;

                            if ($selectedRows.length > 0) {
                    
                                    
                                 $selectedRows.each(function () {
                                    var record = $(this).data('record');
                                    if(record.factura_numero != "")
                                    {
                                        alert('Selecciona guia sin folio solamente');
                                        controlador = 2;
                                        
                                    }
                                });

                                    
                                    

                                
                                    
                            } else {
                                        
                                alert('No Seleccionaste ninguna guia');
                            }


                            if(controlador == 2)
                            {

                            }else
                            {
                                $("#dialogo-ASO2").dialog('open');
                            }
                        }
                    }]
                },
                actions: {
                    listAction:   'ordensql_sql.php?action=list',
                    deleteAction: 'ordensql_sql.php?action=delete'
                },
                fields: {
                    ideguiacompra: {
                        key: true,
                        create: false,
                        edit: false,
                        list: false
                    },
                    
                    Detalle: {
                        title: 'Det',
                        width: '2%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(datos) {
                            //Create an image that will be used to open child table
                            var $img = $('<center><button title="Detalle de la Guia" class="btn btn-default btn-sm ui-corner-all" type="button" ><span class="glyphicon glyphicon-list"></span></button></center>');
                            //Open child table when user clicks the image
                            $img.click(function() {

                                //aqui*************** Primer Hijo

                                $('#jt_guias_compra').jtable('openChildTable', $img.closest('tr'), {
                                    title: 'Detalle:',
                                    paging: true,
                                    pageSize: 10,
                                    sorting: false,
                                    selecting: true,
                                    defaultSorting: 'id_dguia_compra ASC',
                                    actions: {
                                      //    listAction: 'dato.php?idguia='+datos.record.id_eguia_compras,   
                                       listAction: 'ordendet_sql.php?action=list&idguia='+datos.record.id_eguia_compra,
                                       // listAction: 'facturadet_sql.php?action=list&IDFactura='+ datos.record.IdEFactura,

                                    },

                                    fields: {
                                        id_eguia_compra: {
                                            type: 'hidden',
                                            defaultValue: datos.record.id_eguia_compra
                                        },
                                        id_dguia_compra: {
                                            key: true,
                                            create: false,
                                            edit: false,
                                            list: false
                                        },
                                        posicion: {
                                            title: 'Posición',
                                            width: "10%",
                                            list: true
                                        },
                                        codigo: {
                                            title: 'Código',
                                            width: '10%',
                                            create: true,
                                            edit: true,
                                            list: true
                                        },
                                        descripcion: {
                                            title: 'Descripción',
                                            width: '10%',
                                            create: true,
                                            edit: true,
                                            list: true
                                        },
                                        cantidad: {
                                            title: 'Cantidad',
                                            width: '10%',
                                            create: true,
                                            edit: false,
                                            list: true
                                        }

                            
                                    }
                                  //  return $img;

                                }, 
                                function(data) { //opened handler
                                    data.childTable.jtable('load');
                                    hello = data.childTable;
                                    return hello;

                                });
                            });
                        return $img;

                        },
                    },
                    
                    numero: {
                        title: 'Número',
                        width: '5%',
                        create: true,
                        edit: true,
                        list: true

                    },
                    Suppliers: {
                        title: 'Proveedor',
                        width: '20%',
                        create: false,
                        edit: false,
                        list: true
                    },
                    orden_compra: {
                        title: 'Nº de OC',
                        width: '5%',
                        create: true,
                        edit: true,
                        list: false
                    },
                    folio: {
                        title: 'Folio Guia',
                        width: '8%',
                        create: true,
                        edit: true,
                        list: true
                    },
                    factura_numero:{
                      title: 'Nº Factura',
                      width: '8%',
                      create: true,
                      edit: true,
                      list: true
                    },

                   
                     fecha_emision: {
                        title: 'Fecha Emisión',
                        width: '7%',
                        type: 'date',
                        displayFormat: 'dd-mm-yy',
                        create: true,
                        edit: true,
                        list: true

                    },
                    RazonSocial:{
                        title: 'Empresa',
                        width: '15%',
                        create: true,
                        edit: true,
                        list: true
                    },
                     total: {
                        title: 'Total ($)',
                        width: '10%',
                        create: true,
                        edit: true,
                        list: true
                    },
                    estado_contable:{
                        title: 'Estado',
                        width: '9%',
                        create: true,
                        edit: true,
                        list: true
                    },
                     
                    EC:{
                       title: '',
                        width: '1%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(datos) {
                        //Create an image that will be used to open child table
                        if(datos.record.estado_contable == "PENDIENTE PAGO")
                        {
                            var $img = $('<center><button title="EC" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../../toolbar-icon/Rojo.png" style="cursor:pointer;" title="" /></button></center>');
                            $img.on("click", function()
                            {

                            });
                            return $img;
                        }else
                        {
                            var $img = $('<center><button title="EC" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../../toolbar-icon/Verde.jpg" style="cursor:pointer;" title="" /></button></center>');
                            $img.on("click", function()
                            {

                            });
                            return $img;
                        }
                        
                        }
                    },
                    /*
                    folioss: {
                        title: '',
                        width: '1%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(datos) {
                            //Create an image that will be used to open child table
                            var $img = $('<center><button title="Vincular a Factura de Venta" class="btn btn-default btn-sm ui-corner-all" type="button" ><span class="glyphicon glyphicon-link"></span></button></center>');

                            $img.on("click", function() {
                                            $("#fol").val(datos.record.folio);
                        $("#dialogo-factura").dialog("open");
                                            $("#id_ots").val(datos.record.ideguiacompra);

                            });
                            return $img;
                        }
                    },
                    */
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
                            //alert(datos.record.ideguiacompra);
                            window.location = "../../reportes/ordentrabajo.php?ideguiacompra=" + datos.record.ideguiacompra;
                        });
                        return $img;
                        }
                    },
                    ASO: {
                        title: '',
                        width: '1%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(datos) {
                        //Create an image that will be used to open child table
                        var $img = $('<center><button title="Asociar a Nª Factura" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../../toolbar-icon/ot.png" style="cursor:pointer;" title="" /></button></center>');
                        $img.on("click", function()
                        {
                            if(datos.record.factura_numero== "")
                            {
                                folioAso = datos.record.ideguiacompra;
                                $("#dialogo-ASO").dialog('open');
                            }else
                            {
                                alert("Ya esta asociado a un folio");
                            }
                           
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
                            var $img = $('<center><button title="Modificar Documento." class="btn btn-default btn-sm ui-corner-all" type="button" ><span class="glyphicon glyphicon-pencil"></span></button></center>');
                            $img.on("click", function() {

                                window.location = "orden_main_edit.php?ideguiacompra=" + datos.record.ideguiacompra;

                            });
                            return $img;
                        }
                    }

                },

                //cuando se cierra el dialog
                formClosed: function(event, data) {
                    $('#jt_guias_compra').jtable('load');
                },



// inicio 
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
            
           $(".jtable-main-container tr").find("td:eq(7)").each(function () {
                        $(this).text(Moneda($(this).text()));
                       
            });
           
            $('#jt_guias_compra tbody tr').each(function()
			    {
			    	if($(this).find('td:eq(8)').text()=="PENDIENTE PAGO")
			    	{
			    		$(this).css("background", "#F2DEDE");
			    	}else{

			    	}
			    });
            
            
        },
        
       


        });
    
// // fin


            //Load person list from server
            $('#jt_guias_compra').jtable('load');

            //buscar por clientes
            $('#btnBUSCAR').on('click', function(e) {
                e.preventDefault();
                $('#jt_guias_compra').jtable('load', {
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
                                      $('#jt_guias_compra').jtable('reload');
                              }

                        });


                  },
                  "Cerrar": function() {
                        $(this).dialog("close");

                  }
            }
      });



            $("#dialogo-ASO2").dialog({
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


                            var $selectedRows = $('#jt_guias_compra').jtable('selectedRows');
                            

                             

                             if(controlador == 2)
                             {

                             }else
                             {
                                if ($selectedRows.length > 0) {
                    
                                $selectedRows.each(function () {

                                    var record = $(this).data('record');
                                    folioAso = "";
                                    folioAso = record.ideguiacompra;

                                    var parametros = {

                                   "id_ecompra"        : folioAso,
                                   "folio_factura"     : $("#aso2").val()

                                    };



                                     $.ajax({

                                          async: true,
                                          cache: false,
                                          type: "POST",
                                          dataType: "json",
                                          url: "ordensql_sql.php?action=aso",
                                          data: parametros,
                                          success: function(response) {
                                                
                                                  $("#dialogo-ASO2").dialog("close");
                                                  controlador = 1;
                                                  
                                          }

                                     });

                                });
                                    
                                }
                             }

                            

                            
                           
                            alert("Se Guardo Correctamente");
                            $("#aso2").val("");
                            $('#jt_guias_compra').jtable('reload');

                      },
                      "Cerrar": function() {
                            $("#aso").val("");
                            $(this).dialog("close");

                      }
                }
            });

        $("#dialogo-ASO").dialog({
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

                            var parametros = {

                                   "id_ecompra"        : folioAso,
                                   "folio_factura"     : $("#aso").val()

                           };
                            $.ajax({

                                  async: true,
                                  cache: false,
                                  type: "POST",
                                  dataType: "json",
                                  url: "ordensql_sql.php?action=aso",
                                  data: parametros,
                                  success: function(response) {
                                        alert("Se Guardo Correctamente");
                                          $("#dialogo-ASO").dialog("close");
                                          $("#aso").val("");
                                          $('#jt_guias_compra').jtable('reload');
                                  }

                            });


                      },
                      "Cerrar": function() {
                            $("#aso").val("");
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


<div id="dialogo-ASO" title="Ingrese Folio Factura a Asociar" style="width: 100%; display:none">

    <form id="ASO" method="post">
        <br />
        <center><input class="form-control input-sm ui-corner-all" type="text" name="aso" id="aso" value="" /></center>
       
    </form>

</div>

<div id="dialogo-ASO2" title="Ingrese Folio Factura a Asociar" style="width: 100%; display:none">

    <form id="ASO2" method="post">
        <br />
        <center><input class="form-control input-sm ui-corner-all" type="text" name="aso2" id="aso2" value="" /></center>
       
    </form>

</div>




</body>
</html>
