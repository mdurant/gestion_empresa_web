// LA funcionalidad completa de gestion de compra

$(function() {




      //$("#fcreacion").datepicker({});
      var creacion = $('#fecha_operacion').datepicker({
            dateFormat: 'dd-mm-yy'
      });
      
      creacion.on('changeDate', function(ev) {
            // do what you want here
            creacion.datepicker('hide');
      });

     
      //trabajar con jtable

      $("#dialog_btn-codigo").dialog({
            autoOpen: false,
            width: 1300,
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
                        $(this).dialog("close");

                  }
            }
      });

      //funcion para capturar el valor de las cajas

      function valores() {
            valor.val(Dato);
            valor1.val(Dato2);
           // valor3.val(Dato3);
           // valor4.val(Dato4);
            valor5.val('');
            $("#dialog_btn-codigo").dialog("close");
      }

      $(".btn-codigo").on('click', function() {
                
            var $tr=$(this).parent().parent().parent().parent().parent().parent().parent();
                
            valor = $tr.find("#cod_complete");
            valor1= $tr.find("#descri");
           // valor3 = $tr.find("#bodega");
          //  valor4= $tr.find("#valor");
            valor5= $tr.find("#id_detalles");
            
            $("#dialog_btn-codigo").dialog("open");

      });

      $(".btn-quitar").on('click', function() {
                

            var $TR=$(this).parent().parent();
            
            $TR.find('#cod_complete').val('').attr('value','').attr('disabled','disabled');
            $TR.find('#descri').val('').attr('value','').attr('disabled','disabled');
            $TR.find('#cantidades').val('').attr('disabled','disabled');
            $TR.find('#valor').val('').attr('disabled','disabled');
            $TR.find('#total_tbl').val('');
            
            calcular_total();
      });


      //*********************************************************************************************
      //******************************************************************************************

      $('#jt_productos').jtable({
            jqueryuiTheme: true,
            title: 'Servicios / Materiales / Otros',
            paging: true,
            pageSize: 10,
            sorting: true,
            defaultSorting: 'IDProduct ASC',
            //selecting: true, //Enable selecting
            //multiselect: true, //Allow multiple selecting
            //selectingCheckboxes: true, //Show checkboxes on first column
            //selectOnRowClick: true, //Enable this to only select using checkboxes
            actions: {
                  listAction: 'productos_sql.php?action=list',
                  createAction: 'productos_sql.php?action=create',
                  updateAction: 'productos_sql.php?action=update',
                  deleteAction: 'productos_sql.php?action=delete'
            },
            fields: {
                  Capturar: {
                        title: '',
                        width: '2%',
                        sorting: false,
                        list: true,
                        edit: false,
                        create: false,
                        display: function(datos) {
                              //Create an image that will be used to open child table
                              var $img = $('<img src="../../toolbar-icon/abono.gif" style="cursor:pointer;" title="Capturar Servicio/Material/Otros" />');
                              $img.on("click", function() {



                                    Dato = datos.record.CodeBar;
                                    Dato2 = datos.record.ProductName;
                                   // Dato3 = datos.record.IDCellar;
                                 //   Dato4 = datos.record.UnitPrice;
                                    valores();


                              });
                              return $img;
                        }
                  },
                  IDProduct: {
                        key: true,
                        create: false,
                        edit: false,
                        list: false
                  },
                  ProductName:{
                        title:'Servicio / Materiales / Otros',
                        create:true,
                        list: true,
                        edit: true
                  },
                  CodeBar:{
                        title:'Código Servicio',
                        list:true,
                        create: true,
                        edit: true
                  },
                  
                  tipo_producto:{
                        title:'Tipo Asignación',
                        list:true,
                        create: true,
                        edit: true,
                        options :{"SERVICIOS":"SERVICIOS", "MATERIALES":"MATERIALES","PRODUCTO":"PRODUCTO"},
                        
                        },
                  Estado:{
                        title:'Estado',
                        create:true,
                        edit: true,
                        list:true,
                        options: {
                              "activo": "Activo",
                              "inactivo": "Inactivo"
                        },

                  }

            },

            formCreated: function(event, data) {
                  function clearCanvas() {
                        var canvas = $('#miscCanvas').get(0);
                        var ctx = canvas.getContext('2d');
                        ctx.lineWidth = 0;
                        // ctx.lineCap = 'butt';
                        ctx.fillStyle = '#ffffff';
                        ctx.strokeStyle = '#ffffff';
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        ctx.strokeRect(0, 0, canvas.width, canvas.height);
                  }
                  $("input[name='CodeBar']").on("keyup", function() {
                        clearCanvas();
                        // $("#miscCanvas").empty();
                        $("#miscCanvas").barcode($("input[name='CodeBar']").val(), "code93", {
                              output: "canvas"
                        });
                        //$("#miscCanvas").barcode($("#valores").val(), "code93");  
                  });
                  $("#miscCanvas").barcode($("input[name='CodeBar']").val(), "code93", {
                        output: "canvas"
                  });

                  function download() {
                        var dt = canvas.toDataURL();
                        this.href = dt;
                  }

                  var canvas = document.getElementById('miscCanvas');
                  document.getElementById('download').addEventListener('click', download, false);
                  //validacion
                  data.form.find('input[name="CodeBar"]').addClass('validate[required]');
                  data.form.find('input[name="ProductName"]').addClass('validate[required]');
                  data.form.find('input[name="UnidadMedida"]').addClass('validate[required]');
                  data.form.find('input[name="IDCellar"]').addClass('validate[required]');
                  data.form.find('input[name="Description"]').addClass('validate[required]');
                  data.form.find('input[name="Suppliers"]').addClass('validate[required]');
                  data.form.find('input[name="CategoryProduct"]').addClass('validate[required]');
                  data.form.find('input[name="Nombre"]').addClass('validate[required]');
                  data.form.validationEngine();
            },
            //Validate form when it is being submitted
            formSubmitting: function(event, data) {
                  return data.form.validationEngine('validate');
            },
            //Dispose validation logic when form is closed
            formClosed: function(event, data) {
                  data.form.validationEngine('hide');
                  data.form.validationEngine('detach');
            }

      });


      //Load person list from server
      $('#jt_productos').jtable('load');

      //buscar por clientes
      $('#btnBUSCAR').on('click', function(e) {
            e.preventDefault();
            $('#jt_productos').jtable('load', {
                  nombreproducto: $('#nombreproducto').val(),
                  inactivo: $('#inactivo').val()
            });
      });

      $('#inactivo').on('change', function() {
            // From the other examples
            if (!this.checked) {
                  $('#inactivo').val("1");
            } else {
                  $('#inactivo').val("2");
            }
      });


      //el dialogo dos para la funcion del calculo de precio anterior precio de ahora

      $("#dialog2").dialog({
            autoOpen: false,
            width: 500,
            heigth: 500,
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
                  "Aceptrar": function() {
                        ob = venta.val();
                        venta2.val(ob);
                        $(this).dialog("close");
                  }
            }
      });



      // dialogo 3

      $("#dialog3").dialog({
            autoOpen: false,
            width: 500,
            heigth: 500,
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
                  "Cancelar": function() {
                        $("#dplantilla").val("");
                        $("#nplantilla").val("");
                        $("#dialog3").dialog("close");
                  },
                  "Aceptar": function() {
                        var datasrl = $("#form_tbl").serialize();
                        $.ajax({

                              async: true,
                              cache: false,
                              type: "POST",
                              dataType: "json",
                              url: "insert_eplantillaot_sql.php",
                              data: datasrl + "&nplantilla=" + $("#nplantilla").val() + "&dplantilla=" + $("#dplantilla").val(),
                              success: function(response) {
                                    alert("Se Guardo Correctamente");
                                    //cerrar
                                    $("#dialog3").dialog("close");
                                    $("#dplantilla").val("");
                                    $("#nplantilla").val("");
                              }

                        });

                  }
            }
      });

      $("#btn_plantilla").on('click', function() {

            $("#dialog3").dialog("open");

      });

});