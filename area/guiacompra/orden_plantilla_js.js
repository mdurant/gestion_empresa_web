// LA funcionalidad completa de gestion de compra

$(function(){
	
	$("#scliente").select2();
	$("#tcotizacion").select2();
	$("#tempresa").select2();
	$("#fpago").select2();
	$("#clientes").select2();
    
    

      $(".btn-quitar").on('click', function(e) {
            e.preventDefault();

            var $TR=$(this).parent().parent();
            
            $TR.find('#cod_complete').val('').attr('value','').attr('disabled','disabled');
            $TR.find('#descri').val('').attr('value','').attr('disabled','disabled');
            $TR.find('#cantidad').val('').attr('disabled','disabled');
            $TR.find('#valor').val('').attr('disabled','disabled');

      });

   
	//$("#fcreacion").datepicker({});
	var creacion=$('#facturacion').datepicker({dateFormat: 'dd-mm-yy'});
	creacion.on('changeDate', function(ev){
        // do what you want here
        creacion.datepicker('hide');
    });
	
	//trabajar con jtable
	
	$( "#dialog_btn-codigo" ).dialog({
              autoOpen: false,
			  width: 1300,
			  heigth: 700,
			  position:['middle',20],
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
					
					
					
        			$( this ).dialog( "close" );
                 
                }
			  }
          });
		
		//funcion para capturar el valor
		function valores()
		{
            valor.val(Dato);
            valor1.val(Dato2);
            valor3.val(Dato3);
            valor4.val(Dato4);
			valor5.val('');
			 $( "#dialog_btn-codigo" ).dialog( "close" );
		}
		
		$(".bsq").on('click',function(){
			
            var $tr=$(this).parent().parent().parent().parent().parent().parent().parent();
                
            valor = $tr.find("#cod_complete");
            valor1= $tr.find("#descri");
            valor3 = $tr.find("#bodega");
            valor4= $tr.find("#valor");
            valor5= $tr.find("#id_detalles");
            
            $("#dialog_btn-codigo").dialog("open");			
			
			/*
			valor=$(this).parent().parent().children("td:eq(0)").children();
			valor2=$(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(2)").children().children();
			valor3=$(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(4)").children().children();
			 //alert(valor3.val());
			 $( "#dialog" ).dialog( "open" );
			*/
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
					listAction:		'productos_sql.php?action=list',
                    createAction: 	'productos_sql.php?action=create',
					updateAction: 	'productos_sql.php?action=update',
					deleteAction: 	'productos_sql.php?action=delete'
				},
				fields: {
					 Capturar: {
				    title: '',
				    width: '2%',
				    sorting: false,
				    list: true,
					edit:false,
					create: false,
				    display: function (datos) {
					//Create an image that will be used to open child table
					var $img = $('<img src="../../toolbar-icon/abono.gif" style="cursor:pointer;" title="Capturar Producto" />');
					$img.on("click",function () {
                            
                            
                                 
                                  Dato=datos.record.CodeBar;
								  Dato2=datos.record.ProductName;
								  Dato3=datos.record.IDCellar;
								  Dato4=datos.record.UnitPrice;
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
                        width: '20%',
                        list: false,
                        input: function () {
                               return '<a id="download" class="btn btn-primary" download="barcode.png"><canvas id="miscCanvas" width:200px; style="border:1px solid #ffffff;"></canvas></a>';
                        }
                    },
                    CodeBar:
					{
						title: 'Codigo De Barra',
						width: '20%',
						create: true,
						edit: true,
						list: true

					},
					ProductName:
					{
						title: 'Nombre Producto',
						width: '20%',
						create: true,
						edit: true,
						list: true

					},
					UnidadMedida:
					{
						title: 'Unidad',
						width: '20%',
						create: true,
                        options:'productos_sql.php?action=unidad',
						edit: true,
						list: true
					},
					IDCellar:
                    {
						create: false,
						edit: false,
						list: false
                    },
					QuantityPerUnit: {
						title: 'Cantidad por unidad',
						width: '20%',
						create: true,
						edit: true,
						list: false
					},
                    PurchasePrice: {
						title: 'Precio Compra',
						width: '20%',
						create: true,
						edit: true,
						list: false
					},
                    UnitPrice: {
						title: 'Precio Unitario',
						width: '20%',
						create: true,
						edit: true,
						list: false
					},
                    UnitsInStock: {
						title: 'Stock',
						width: '20%',
						create: true,
						edit: true,
						list: false
					},
                    Discontinued: {
						title: 'Descontinuado',
						width: '20%',
						create: true,
                        options:{"Y":"si","N":"no"},
						edit: true,
						list: false
					},
                    Description: {
						title: 'Descripcion',
						width: '20%',
						create: true,
						edit: true,
						list: true
					},
                    Description2:
                    {
                        title: 'Descripcion alternativa',
						width: '20%',
						create: true,
						edit: true,
						list: false
                    },
                    Estado:
                    {
                        title: 'Estado',
						width: '20%',
                        options: {"inactivo":"inactivo","activo":"activo"},
						create: true,
						edit: true,
						list: false
                    },
                    Suppliers:
                    {
                        title: 'Proveedores',
						width: '20%',
                        options:'productos_sql.php?action=proveedores',
						create: true,
						edit: true,
						list: false
                    },
                    CategoryProduct:
                    {
                        title: 'CategoryProduct',
						width: '20%',
                        options:'productos_sql.php?action=CategoryProduct',
						create: true,
						edit: true,
						list: false
                    },
                    Nombre:
                    {
                        title: 'almacen',
						width: '20%',
                        options:'productos_sql.php?action=Nombre',
						create: true,
						edit: true,
						list: false
                    }
                    
					
					
				},
                 formCreated: function (event, data) {
                            function clearCanvas(){
                                    var canvas = $('#miscCanvas').get(0);
                                    var ctx = canvas.getContext('2d');
                                    ctx.lineWidth = 0;
                                    // ctx.lineCap = 'butt';
                                    ctx.fillStyle = '#ffffff';
                                    ctx.strokeStyle  = '#ffffff';
                                    ctx.clearRect (0, 0, canvas.width, canvas.height);
                                    ctx.strokeRect (0, 0, canvas.width, canvas.height);
                                  }
                        		  $("input[name='CodeBar']").on("keyup",function(){
                        				clearCanvas();
                        				// $("#miscCanvas").empty();
                    			        $("#miscCanvas").barcode($("input[name='CodeBar']").val(), "code93",{output:"canvas"});  
                        		        //$("#miscCanvas").barcode($("#valores").val(), "code93");  
                        		  });
                                  $("#miscCanvas").barcode($("input[name='CodeBar']").val(), "code93",{output:"canvas"}); 
                            
                              	  function download() {
                                     var dt = canvas.toDataURL();
                                     this.href = dt;
                                  }
                                
                                  var canvas = document.getElementById('miscCanvas');
                                  document.getElementById('download').addEventListener('click', download, false);
                 }

        });
			
				
			//Load person list from server
			$('#jt_productos').jtable('load');
			
			//buscar por clientes
			 $('#btnBUSCAR').on('click',function(e) {
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
    }else
    {
        $('#inactivo').val("2");
    }
});
		
		
	

	});