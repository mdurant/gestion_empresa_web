// LA funcionalidad completa de gestion de compra

$(function() {

	$("#scliente").select2();
	$("#tcotizacion").select2();
	
	$("#fpago").select2();
	$("#proveedores").select2();



	//$("#fcreacion").datepicker({});
	var creacion = $('#facturacion').datepicker({
		dateFormat: 'dd-mm-yy'
	});
	creacion.on('changeDate', function(ev) {
		// do what you want here
		creacion.datepicker('hide');
	});

	//trabajar con jtable

	$("#dialog").dialog({
		autoOpen: false,
		width: 1300,
		heigth: 600,
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
			"Cerrar": function() {
				$(this).dialog("close");

			}
		}
	});

	//funcion para capturar el valor

	function valores() {
		valor.val(Dato);
		valor2.val(Dato2);
		valor3.val(Dato3);
		valor4.val(Dato4);
		valor5.val(Dato5);
        valor6.val(Dato4);
		//cantidaded.val(1);
		calcular_total();
		
		$("#dialog").dialog("close");
	}

	$(".bsq").on('click', function() {
        cantidaded = $(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(3)").children().children();
		valor = $(this).parent().parent().children("td:eq(0)").children();
		valor2 = $(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(2)").children().children();
		valor3 = $(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(4)").children();
		valor4 = $(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(5)").children().children();
		valor5 = $(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(6)").find("#precio_venta");
		valor6 = $(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(7)").children();
		$("#dialog").dialog("open");

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
						Dato4 = datos.record.PurchasePrice;
						Dato5 = datos.record.UnitPrice;
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
				title: 'Codigo Barra',
				width: '10%',
				list: false,
				input: function() {
					return '<a id="download" class="btn btn-primary" download="barcode.png"><canvas id="miscCanvas" width:200px; style="border:1px solid #ffffff;"></canvas></a>';
				}
			},
			CodeBar: {
				title: 'Codigo De Barra',
				width: '10%',
				create: true,
				edit: true,
				list: true

			},
			ProductName: {
				title: 'Nombre Producto',
				width: '20%',
				create: true,
				edit: true,
				list: true

			},
			UnidadMedida: {
				title: 'Unidad',
				width: '10%',
				create: true,
				options: 'productos_sql.php?action=unidad',
				edit: true,
				list: true
			},
			QuantityPerUnit: {
				title: 'Cantidad por unidad',
				width: '20%',
				create: false,
				edit: false,
				list: false
			},
			PurchasePrice: {
				title: 'Precio Compra($)',
				width: '20%',
				create: true,
				edit: true,
				list: true
			},
			UnitPrice: {
				title: 'Precio Venta($)',
				width: '20%',
				create: false,
				edit: true,
				list: true
			},
			UnitsInStock: {
				title: 'Stock',
				width: '10%',
				create: true,
				edit: true,
				list: true
			},
			Discontinued: {
				title: 'Descontinuado',
				width: '20%',
				create: true,
				options: {
					"N": "no",
					"Y": "si"
				},
				edit: true,
				list: false
			},
			Description: {
				title: 'Descripción',
				width: '20%',
				create: true,
				edit: true,
				list: true
			},
			Description2: {
				title: 'Descripción alternativa',
				width: '20%',
				create: true,
				edit: true,
				list: false
			},
			IDCellar: {
				create: false,
				edit: false,
				list: false
			},
			Estado: {
				title: 'Estado',
				width: '20%',
				options: {
					"activo": "activo",
					"inactivo": "inactivo"
				},
				create: true,
				edit: true,
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
			},
			Nombre: {
				title: 'almacen',
				width: '20%',
				options: 'productos_sql.php?action=Nombre',
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
		position: 'top',
		show: {
			effect: "face",
			duration: 500
		},
		hide: {
			effect: "face",
			duration: 500
		},
		modal: true,
		buttons: {
			"Aceptar": function() {
				
				compra_nuevo.val($("#nuevo_compra").val());
				venta_nuevo.val($("#news").val());
			
				calcular_total();
				
				$(this).dialog("close");
				$("#old").val('');
				$("#news").val('');
				$("#old2").val('');
				$("#news2").val('');
				$("#ultimo_compra").val('');
				$("#nuevo_compra").val('');
			}
		}
	});

	$(".bqs_calc").on('click', function() {
		
		var dat =  $(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(5)").children().children().val();
		var dat2 = $(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(2)").children().children().val();
		var data = "&codigo=" + $(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(1)").find("#cod_complete").val();
		
		
		
		if (dat == "") {
			alert("ingrese un valor al precio de compra");
		} else if (dat2 == "") {
			alert("Ingrese un producto antes de continuar");
		} else {
				
			compra_nuevo = $(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(5)").find("#precio_compra");
			venta_nuevo = $(this).parent().parent().parent().parent().parent().parent().parent().children("td:eq(6)").find("#precio_venta");
			
		
				
			//alert(datas);
			$.ajax({

				async: true,
				cache: false,
				type: "POST",
				dataType: "json",
				url: "compra_json.php",
				data: data,
				success: function(response) {
						
					var calc_old = (((response.precio_venta * 100) / response.precio_compra).toFixed(2) - 100).toFixed(2);
					var calc_new = (((venta_nuevo.val() * 100) / compra_nuevo.val()).toFixed(2) - 100).toFixed(2);
					
					$("#old").val(response.precio_venta); //Ultimo Precio Venta
					$("#news").val(venta_nuevo.val()); //Nuevo Precio Venta
					
					$("#old2").val(calc_old); //Ultimo % Utilidad
					$("#news2").val(calc_new); //Nuevo % Utilidad
					
					
					$("#ultimo_compra").val(response.precio_compra); //
					$("#nuevo_compra").val(compra_nuevo.val()); //
					
					$("#dialog2").dialog("open");

				}

			});
		}


	});

	$("#news").on('keyup', function() { //Nuevo Precio Venta

		var $precio = $(this).val();
		var calc2 = ((($precio * 100) / compra_nuevo.val()).toFixed(2) - 100).toFixed(2);
		$("#news2").val(calc2);
	});
	$("#nuevo_compra").on('keyup', function() { //
		var $precio = $(this).val();
		var calc2 = (((venta_nuevo.val() * 100) / $precio).toFixed(2) - 100).toFixed(2);
		$("#news2").val(calc2);
	});


});