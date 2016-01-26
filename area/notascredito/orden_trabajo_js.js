// LA funcionalidad completa de gestion de compra

$(function() {




      //$("#fcreacion").datepicker({});
      var creacion = $('#fecha_guia').datepicker();
      
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
                    
                    neto =(total_direct);
                    
                    $("#total").val(neto);

                    $("#tbl_foot tr td:eq(1)").html('<center><small><strong>Total Neto: $</strong></small>  '+Moneda(neto.toFixed())+'</center>');
                    
                }



      function valores() {
            valor.val(Dato);
            valor1.val(Dato2);
            valor3.val(Dato3);
            valor4.val(Dato4);
            valor4.prop("disabled", false);
            valor6.val("0");
            valor5.val('');
            valor7.val('0');

            calcular_total();
            $("#dialog_btn-codigo").dialog("close");

      }


      

      $(".btn-codigo").on('click', function() {
                
            var $tr=$(this).parent().parent().parent().parent().parent().parent().parent();
                
            valor = $tr.find("#cod_complete");
            valor1= $tr.find("#descri");
            valor3= $tr.find("#bodega");
            valor4= $tr.find("#valor");
            valor5= $tr.find("#id_detalles");
            valor6= $tr.find("#cantidades");
            valor7= $tr.find("#total_tbl");
            
            
            
            
            
            $("#dialog_btn-codigo").dialog("open");

      });



      $(".btn-quitar").on('click', function() {
                

            var $TR=$(this).parent().parent();
            
            $TR.find('#cod_complete').val('').attr('value','');
            $TR.find('#descri').val('').attr('value','');
            $TR.find('#cantidades').val('');
            $TR.find('#valor').val('');
            $TR.find('#total_tbl').val('');
            
            calcular_total();
      });


      //*********************************************************************************************
      //******************************************************************************************

      $('#jt_productos').jtable({
            jqueryuiTheme: true,
            title: 'Productos',
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
                              var $img = $('<img src="../../toolbar-icon/abono.gif" style="cursor:pointer;" title="Capturar Producto" />');
                              $img.on("click", function() {



                                    Dato = datos.record.CodeBar;
                                    Dato2 = datos.record.ProductName;
                                    Dato3 = datos.record.IDCellar;
                                    Dato4 = datos.record.UnitPrice;
                                    
                                    var $TR=$(this).parent().parent();
                                    // alert("hola");
                                    
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
                  CodigoBarra: {
                        title: 'CodigoBarra',
                        width: '10%',
                        list: false,
                        input: function() {
                              return '<a id="download" class="btn btn-primary" download="barcode.png"><canvas id="miscCanvas" width:200px; style="border:1px solid #ffffff;"></canvas></a>';
                        }
                  },
                  CodeBar: {
                        title: 'Codigo De Barra',
                        width: '15%',
                        create: true,
                        edit: true,
                        list: true

                  },
                  ProductName: {
                        title: 'Nombre Producto',
                        width: '40%',
                        create: true,
                        edit: true,
                        list: true

                  },
                  PurchasePrice: {
                        title: 'Precio Compra($)',
                        width: '10%',
                        create: true,
                        edit: true,
                        list: true
                  },
                  UnitPrice: {
                        title: 'Precio Venta($)',
                        width: '10%',
                        create: false,
                        edit: true,
                        list: true
                  },
                  UnitsInStock: {
                        title: 'Stock',
                        width: '5%',
                        create: true,
                        edit: true,
                        list: true
                  },
                 
                  IDCellar: {
                        create: false,
                        edit: false,
                        list: false
                  },
                  Description: {
                        title: 'Descripcion',
                        width: '20%',
                        create: true,
                        edit: true,
                        list: true
                  },
                  Description2: {
                        title: 'Descripcion alternativa',
                        width: '20%',
                        create: true,
                        edit: true,
                        list: false
                  },
                  Estado: {
                        title: 'Estado',
                        width: '5%',
                        options: {
                              "activo": "activo",
                              "inactivo": "inactivo"
                        },
                        create: false,
                        edit: false,
                        list: false
                  },
                  Suppliers: {
                        title: 'Proveedores',
                        width: '20%',
                        options: 'productos_sql.php?action=proveedores',
                        create: true,
                        edit: true,
                        list: false
                  },
                  CategoryProduct: {
                        title: 'CategoryProduct',
                        width: '20%',
                        options: 'productos_sql.php?action=CategoryProduct',
                        create: true,
                        edit: true,
                        list: false
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
                  // data.form.find('input[name="UnidadMedida"]').addClass('validate[required]');
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