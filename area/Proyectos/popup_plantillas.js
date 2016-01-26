// Popup de plantillas
$(document).ready(function() {





    // Cargar las Plantillas Para traer el id y buscarlas

    $("#dialog4").dialog({
        autoOpen: false,
        width: 1300,
        heigth: 700,
        position: ['middle', 40],
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
                $(this).dialog("close");
            }
        }
    });

    function ejecucion() {
        pla.val(idplan + "--" + nomplan);
        $("#oculto_pla").val(idplan);
        $("#dialog4").dialog("close");
    }



    $("#bsqp").on("click", function() {

        pla = $(this).parent().parent().children("td:eq(0)").children();
        $("#dialog4").dialog("open");

    });





    //Prepare jTable
    $('#jt_plantillaot').jtable({
        jqueryuiTheme: true,
        title: 'Gesti&oacute;n de Plantillas',
        paging: true,
        pageSize: 10,
        sorting: true,
        openChildAsAccordion: true,
        //Enable this line to show child tabes as accordion style
        defaultSorting: 'id_plantillaot ASC',
        selecting: false,
        //Enable selecting
        multiselect: false,
        //Allow multiple selecting
        selectingCheckboxes: false,
        //Show checkboxes on first column
        //selectOnRowClick: true, //Enable this to only select using checkboxes
        actions: {
            listAction: 'plantillasql_sql.php?action=list',
            deleteAction: 'plantillasql_sql.php?action=delete'
        },
        fields: {
            Seleccionad: {
                title: '',
                width: '1%',
                sorting: false,
                edit: false,
                create: false,
                display: function(datos) {
                    //Create an image that will be used to open child table
                    var $img = $('<center><img src="../../toolbar-icon/abono.gif" style="cursor:pointer;" title="Seleccionar" /></center>');

                    $img.on('click', function() {

                        idplan = datos.record.id_plantillaot;
                        nomplan = datos.record.nombre;
                        ejecucion();

                    });
                    return $img;
                }
            },
            id_plantillaot: {
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
                    var $img = $('<img src="../../toolbar-icon/candado.png" />');
                    //Open child table when user clicks the image
                    $img.click(function() {

                        //aqui***************

                        $('#jt_plantillaot').jtable('openChildTable', $img.closest('tr'), {
                            title: 'Detalle:',
                            paging: true,
                            pageSize: 10,
                            sorting: false,
                            defaultSorting: 'id_dplantillaot ASC',
                            actions: {
                                listAction: 'plantilladet_sql.php?action=list&IDPerfil=' + datos.record.id_plantillaot,
                            },
                            fields: {
                                id_plantillaot: {
                                    type: 'hidden',
                                    defaultValue: datos.record.id_plantillaot
                                },
                                id_dplantillaot: {
                                    key: true,
                                    create: false,
                                    edit: false,
                                    list: false
                                },
                                posicion: {
                                    title: 'Posici\u00f3n',
                                    width: "10%",
                                    list: true
                                },
                                Codigo: {
                                    title: 'Codigo',
                                    width: '10%',
                                    create: true,
                                    edit: true,
                                    list: true
                                },
                                descripcion: {
                                    title: 'Descripcion',
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
                                },
                                id_almacen: {
                                    title: 'Almacen',
                                    width: '20%',
                                    options: 'plantilladet_sql.php?action=Descripcion',
                                    list: true
                                }
                            }
                        }, function(data) { //opened handler
                            data.childTable.jtable('load');
                            hello = data.childTable;
                            return hello;
                        });
                    });
                    //Return image to show on the person row
                    return $img;
                }
            },
            nombre: {
                title: 'Nombre Plantilla',
                width: '20%',
                create: true,
                edit: true,
                list: true

            },
            descripcion: {
                title: 'Descripcion Plantilla',
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
                    var $img = $('<center><img src="../../toolbar-icon/pdf.gif" title="Exportar a PDF" /></center>');
                    return $img;
                }
            }



        },
        //cuando se cierra el dialog
        formClosed: function(event, data) {
            $('#jt_plantillaot').jtable('load');
        }

    });


    //Load person list from server
    $('#jt_plantillaot').jtable('load');

    //buscar por clientes
    $('#cargar').on('click', function(e) {
        e.preventDefault();
        $('#jt_plantillaot').jtable('load', {
            plantillas: $('#plantillas').val()
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



});