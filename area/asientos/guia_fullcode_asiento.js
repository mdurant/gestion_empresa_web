// 


$(function(){
    
    
/*$(".cod").on('keyup',function(){
	
	$(this).parent().parent().parent().children('td:eq(2)').children().children().text('Holapos');
	});*/
	
	//FUNCION PARA CODIGO event
   
   
   
    
	
$(".cod").on('keyup',function(){
	if($(this).val()==0)
	{
		
		//var $tr=$(this).parent().parent().parent();
		var $tr=$(this).parent().parent().parent().parent().parent().parent().parent();
		
		$tr.children('td:eq(1)').children().children().val('');
		$tr.children('td:eq(2)').children().children().val('');
		$tr.children('td:eq(3)').children().children().val('');
		$tr.children('td:eq(4)').children().children().val('');
		$tr.children('td:eq(5)').children().children().val('');
		$tr.children('td:eq(6)').children().children().val('');
		$tr.children('td:eq(7)').children().children().val('');
		$tr.children('td:eq(8)').text('');
		$tr.children('td:eq(10)').text('');
		
		$("#tbl_foot tr td:eq(0)").children().html('<span  id="pre-load" style="display:none;">&nbsp;&nbsp;Procesando....&nbsp;&nbsp;<img src="../../img/loadingAnimation.gif"/></span>');
		
		
		
		calcular_totales();	
		
		//desactivo los input al perder los datos
		$tr.children('td:eq(3)').children().children().prop('disabled',true);
		$tr.children('td:eq(4)').children().children().prop('disabled',true);
		$tr.children('td:eq(5)').children().children().prop('disabled',true);
		$tr.find("#precio_unitario").prop('disabled',true);
		$tr.find("#total_tbl").prop('disabled',true);
		$("#pre-load").hide();
		
	}else
	{
		//alert('entro');
		
		$("#tbl_foot tr td:eq(0)").children().html('<span  id="pre-load" style="display:none;">&nbsp;&nbsp;Procesando....&nbsp;&nbsp;<img src="../../img/loadingAnimation.gif"/></span>');
		
		$("#bsq").val($(this).val());
		
		var $tr=$(this).parent().parent().parent().parent().parent().parent().parent();
		
		var datasrl =$("#form_tbl").serialize();
		
		$.ajax({
		
			async:true,
			cache:false,
			type:"POST",
			dataType:"json",
			//url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
			url:"factura_json.php",
			data:datasrl,
			beforeSend: function () {
				$("#pre-load").show();
			},
			
			success: function(response){
				//alert("se insertaron los datos correctamente");
				if(response=="nada")
				{
					$tr.children('td:eq(2)').children().children().val('');
					$tr.children('td:eq(3)').children().children().val('');
					$tr.children('td:eq(4)').children().children().val('');
					$tr.children('td:eq(5)').children().children().val('');
					$tr.children('td:eq(6)').children().children().val('');
					$tr.children('td:eq(7)').children().children().val('');
					$tr.children('td:eq(8)').text('');
					$tr.children('td:eq(10)').text('');
					
					calcular_totales();
					
					//$("#pre-load").hide();
				}else
				{
					$tr.children('td:eq(2)').children().children().val(response.descripcion);
					$tr.children('td:eq(4)').children().children().val(response.almacen);
					$tr.children('td:eq(6)').children().children().val(response.precio);
					$tr.children('td:eq(3)').children().children().prop('disabled',false);
					$tr.children('td:eq(4)').children().children().prop('disabled',false);
					$tr.find("#precio_unitario").prop('disabled',false);
					$tr.find("#total_tbl").prop('disabled',false);
					$tr.children('td:eq(8)').text(response.precio);
					$tr.children('td:eq(10)').text(response.stock);
					$("#pre-load").hide();
				}
			}//succes
		
		});	
	}
});

$(".cod").on('focusout',function(){
		if($(this).val()==0)
		{
			var $tr=$(this).parent().parent().parent();
			
			$tr.children('td:eq(1)').children().children().val('');
			$tr.children('td:eq(2)').children().children().val('');
			$tr.children('td:eq(3)').children().children().val('');
			$tr.children('td:eq(4)').children().children().val('');
			$tr.children('td:eq(5)').children().children().val('');
			$tr.children('td:eq(6)').children().children().val('');
			$tr.children('td:eq(8)').text('');
			$tr.children('td:eq(10)').text('');
			
			calcular_totales();	
			
			
		}else
		{		
			if($(".cant").val()==0)
			{
			}else
			{
				var $tr=$(this).parent().parent().parent();
				
				//activar los inout que correspondan
				$tr.children('td:eq(3)').children().children().prop('disabled',false);
				$tr.children('td:eq(4)').children().children().prop('disabled',false);
				$tr.find("#precio_unitario").prop('disabled',false);
				$tr.find("#total_tbl").prop('disabled',false);
				$tr.children('td:eq(3)').children().children().focus();
			}
		}
});

$(".cod").keypress(function(event) {
  if(event.which == 13) {
	  event.preventDefault(); 
		 //$(this).parent().parent().parent().children('td:eq(3)').children().children().focus();
  }
  if($(this).val()=="")
  {
	 //  $(this).parent().parent().parent().children('td:eq(2)').children().children().text('');
  }
});

	//FUNCION PARA LA CANTIDAD
$(".cant").on('focus',function(){
	
	//calculando el stock con todo lo demas
	var val_ctrl=$(this).val();
	var ctrl_stock = Number($(this).parent().parent().parent().children('td:eq(10)').text());
	var total_stock = Number(ctrl_stock - val_ctrl);
	if(total_stock<0)
	{
		$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-important" style="font-size: 100%;">El stock en bodega es de: '+ total_stock +'</span>');
	}else
	{
	$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-info" style="font-size: 100%;">El stock en bodega es de: '+ total_stock +'</span>');
	}
	
});
	
$(".cant").on('focusout',function(){
		
	//calculando el stock con todo lo demas
	var val_ctrl=$(this).val();
	var ctrl_stock = Number($(this).parent().parent().parent().children('td:eq(10)').text());
	var total_stock = Number(ctrl_stock - val_ctrl);
	
});


$(".cant").on('keyup',function(){
	//FUNCION DE LA SUMA
	if (!/^([0-9])*[.]?[0-9]*$/.test($(this).val()))
	{
		alert("ingresa una cantidad numerica");
		$(this).val('');
		$(this).focus();
	}else
	{
		if(isNaN($(this).val()))
		{
			alert("ingresa una cantidad numerica");
			$(this).val('');
			$(this).focus();
		}
		if($(this).val()==0)
		{
			var $tr=$(this).parent().parent().parent();
				
			$tr.children('td:eq(5)').children().children().prop('disabled',true);
			$tr.children('td:eq(7)').children().children().val('');
			
			
			calcular_totales();
			
			//calculando el stock con todo lo demas
			var val_ctrl=$(this).val();
			var ctrl_stock = Number($(this).parent().parent().parent().children('td:eq(10)').text());
			var total_stock = ctrl_stock - val_ctrl;
			if(total_stock<0)
			{
				$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-important" style="font-size: 100%;">El stock en bodega es de: '+ total_stock +'</span>');
			}else
			{
			$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-info" style="font-size: 100%;">El stock en bodega es de: '+ total_stock +'</span>');
			}
			//alert(stock_warning);
		
		}
		else
		{
			$(this).parent().parent().parent().children('td:eq(5)').children().children().prop('disabled',false);
			var v1=parseFloat($(this).parent().parent().parent().children('td:eq(6)').children().children().val());
			var v2=parseFloat($(this).parent().parent().parent().children('td:eq(3)').children().children().val());
			var resultado = (v1 * v2).toFixed();
			var resultado_iva = parseFloat((resultado * 1.19) - resultado);
			var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
			//alert(resultado_iva);
			//var resultado2 = (v1*v2);
			$(this).parent().parent().parent().children('td:eq(9)').text(resultado_total);
			$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
			
			calcular_totales();	
			
				//calculando el stock con todo lo demas
			var val_ctrl=$(this).val();
			var ctrl_stock = Number($(this).parent().parent().parent().children('td:eq(10)').text());
			var total_stock = ctrl_stock - val_ctrl;
			if(total_stock<0)
			{
				$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-important" style="font-size: 100%;">El stock en bodega es de: '+ total_stock +'</span>');
			}else
			{
				$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-info" style="font-size: 100%;">El stock en bodega es de: '+ total_stock +'</span>');
			}
			//alert(stock_warning);
		}
	}//cierre de la comprobacion del float
});

$(".cant").keypress(function(event) {
	if(event.which == 13) {
		event.preventDefault(); 
	   //FUNCION DE LA SUMA
		$(this).parent().parent().parent().children('td:eq(5)').children().children().prop('disabled',false);
		
		var v1=parseFloat($(this).parent().parent().parent().children('td:eq(6)').children().children().val());
		var v2=parseFloat($(this).parent().parent().parent().children('td:eq(3)').children().children().val());
		
		var resultado = (v1 * v2).toFixed();
		var resultado_iva = parseFloat((resultado * 1.19) - resultado);
		var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
		
		$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
		$(this).parent().parent().parent().children('td:eq(9)').text(resultado_total);
		$(this).parent().parent().parent().children('td:eq(5)').children().children().focus();
	
	
		calcular_totales();	

	}
	if($(this).val()=="")
	{
		
	}
});


	//FUNCION PARA LOS DESCUENTOS
	
	
$(".desc").keypress(function(event) {
  	if(event.which == 13) {
	event.preventDefault(); 
	//FUNCION DE LA SUMA
	if(isNaN($(this).val()))
	{
		alert("ingresa un porcentaje en numeros");
		$(this).val('');
		$(this).parent().parent().parent().children('td:eq(6)').children().children().val($(this).parent().parent().parent().children('td:eq(8)').text());
			//FUNCION 
	
		var v1=parseFloat($(this).parent().parent().parent().children('td:eq(8)').text());
		var v2=parseFloat($(this).parent().parent().parent().children('td:eq(3)').children().children().val());
		var resultado = (v1 * v2).toFixed();
		var resultado_iva = parseFloat((resultado * 1.19) - resultado);
		var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
		$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
		//FIN DE LA FUNCION
	
	
		calcular_totales();	

		$(this).focus();
	}
	if($(this).val()==0)
	{
		//$(this).parent().parent().parent().children('td:eq(7)').children().children().text('');
		$(this).parent().parent().parent().children('td:eq(6)').children().children().val($(this).parent().parent().parent().children('td:eq(8)').text());
		
			//FUNCION 
	
		var v1=parseFloat($(this).parent().parent().parent().children('td:eq(8)').text());
		var v2=parseFloat($(this).parent().parent().parent().children('td:eq(3)').children().children().val());
		var resultado = (v1 * v2).toFixed();
		var resultado_iva = parseFloat((resultado * 1.19) - resultado);
		var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
		$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
		//FIN DE LA FUNCION
	
	
		calcular_totales();	

		
		}
		else
		{
			var v11=parseFloat($(this).parent().parent().parent().children('td:eq(8)').text());
			var v22=parseFloat($(this).parent().parent().parent().children('td:eq(5)').children().children().val());
			var resultado = (v11 * v22)/100;
			var resultado = (v11 - resultado).toFixed(2);
			//var resultado2 = (v1*v2);
			$(this).parent().parent().parent().children('td:eq(6)').children().children().val(resultado);
			
			//FUNCION 
			
			var v1=parseFloat($(this).parent().parent().parent().children('td:eq(6)').children().children().val());
			var v2=parseFloat($(this).parent().parent().parent().children('td:eq(3)').children().children().val());
			var resultado = (v1 * v2).toFixed();
			var resultado_iva = parseFloat((resultado * 1.19) - resultado);
			var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
			$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());	
	
			calcular_totales();	

		}
	//cierre de la comprobacion del float
	}
});
	
	
	
	
$(".desc").on('keyup',function(){
	//FUNCION DE LA SUMA
	if (!/^([0-9])*[.]?[0-9]*$/.test($(this).val()))
	{
		alert("ingresa porcentaje numerico");
		$(this).val('');
		$(this).parent().parent().parent().children('td:eq(6)').children().children().val($(this).parent().parent().parent().children('td:eq(8)').text());
		$(this).focus();
	}else
	
	{
	if(isNaN($(this).val()))
	{
		alert("ingresa procentaje numerico");
		$(this).val('');
		$(this).parent().parent().parent().children('td:eq(6)').children().children().val($(this).parent().parent().parent().children('td:eq(8)').text());
		//FUNCION 
	
		var v1=parseFloat($(this).parent().parent().parent().children('td:eq(8)').text());
		var v2=parseFloat($(this).parent().parent().parent().children('td:eq(3)').children().children().val());
		var resultado = (v1 * v2).toFixed();
		var resultado_iva = parseFloat((resultado * 1.19) - resultado);
		var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
		$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
	//FIN DE LA FUNCION
	
	
		calcular_totales();

		$(this).focus();
	}
	if($(this).val()==0)
	{
		$(this).parent().parent().parent().children('td:eq(6)').children().children().val($(this).parent().parent().parent().children('td:eq(8)').text());
		
			//FUNCION 
	
		var v1=parseFloat($(this).parent().parent().parent().children('td:eq(8)').text());
		var v2=parseFloat($(this).parent().parent().parent().children('td:eq(3)').children().children().val());
		var resultado = (v1 * v2).toFixed();
		var resultado_iva = parseFloat((resultado * 1.19) - resultado);
		var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
		$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
		
	//FIN DE LA FUNCION
	
		calcular_totales()
	
	}
	else
	{
	var v11=parseFloat($(this).parent().parent().parent().children('td:eq(8)').text());
	var v22=parseFloat($(this).parent().parent().parent().children('td:eq(5)').children().children().val());
	var resultado = (v11 * v22)/100;
	var resultado = (v11 - resultado).toFixed(2);
	//var resultado2 = (v1*v2);
	$(this).parent().parent().parent().children('td:eq(6)').children().children().val(resultado);
	
	//FUNCION 
	
	var v1=parseFloat($(this).parent().parent().parent().children('td:eq(6)').children().children().val());
	var v2=parseFloat($(this).parent().parent().parent().children('td:eq(3)').children().children().val());
	var resultado = (v1 * v2).toFixed();
	var resultado_iva = parseFloat((resultado * 1.19) - resultado);
	var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
	$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
	
	calcular_totales();

	}
	
	}//cierre de la comprobacion del float
});

function calcular_totales() {
	
	//funcion para el total
		//var total_valor=parseFloat($(".prec").val());
		
		var total_direct = 0;
		$('.total').each(function () {
			if($(this).val()==0)
			{
			}else
			{
				//sumando=parseFloat($(this).text()).toFixed(2);
		
				total_direct += Number($(this).val());		
			}
		});
		//iva=(total_direct*19)/100;
		iva = total_direct - (total_direct / 1.19);
		neto = (total_direct - iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
	

}




$(".precio_unitario").on('keyup',function(){
	
		
			//alert($(this).val());
			var $TR=$(this).parent().parent().parent();
			
			var $cantidad=$TR.find('#cantidad').val();
			var $valor=$(this).val();
			var $total=$valor*$cantidad;
			
			var resultado = ($valor * $cantidad).toFixed();
			var resultado_iva = parseFloat((resultado * 1.19) - resultado);
			var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
	
			
			$TR.find('#total_tbl').val(resultado_total.toFixed());
			
			$TR.find('#preciounitario').text($valor);
			$TR.find('#preciototal').text(resultado_total.toFixed());
			
			calcular_totales();
		
	
});




//TRABAJAR CON EL BTN PARA GUARDAR LOS DATOS

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

      //funcion para capturar el valor

      function valores() {
            valor.val(Dato);
            //	valor2.val(Dato2);
            valor3.val(Dato3);
			
            $("#dialog_btn-codigo").dialog("close");
      }

      $(".btn-codigo").on('click', function() {

            var $tr=$(this).parent().parent().parent().parent().parent().parent().parent();
			
			valor = $(this).parent().parent().children("td:eq(0)").children();
            //valor=$(".cod_complete");
            //	valor2=$(this).parent().parent().parent().children("td:eq(2)").children().children();
            valor3 = $tr.children("td:eq(4)").children().children();
            //alert(valor3.val());
            $("#dialog_btn-codigo").dialog("open");

      });


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
                  listAction:   '../../crud/productos_sql.php?action=list',
                  createAction: '../../crud/productos_sql.php?action=create',
                  updateAction: '../../crud/productos_sql.php?action=update',
                  deleteAction: '../../crud/productos_sql.php?action=delete'
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
                                    Dato2 = "";
                                    Dato3 = datos.record.IDCellar;
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
                  UnidadMedida: {
                        title: 'Unidad',
                        width: '5%',
                        create: true,
                        options: '../../crud/productos_sql.php?action=unidad',
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
                        options: '../../crud/productos_sql.php?action=proveedores',
                        create: true,
                        edit: true,
                        list: false
                  },
                  CategoryProduct: {
                        title: 'CategoryProduct',
                        width: '20%',
                        options: '../../crud/productos_sql.php?action=CategoryProduct',
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



//*************************************************************************************
	
	//creando las funciones para ajax para evitar problemas
});//cierre del document ready