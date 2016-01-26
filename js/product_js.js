// Crud 
$(function(){
	rec();

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
    
	$.ajaxSetup({cache: false});
	
	//TRABAJANDO CON LOS CHECKBOX VALIDAR LA SELECCION Y PASAR VALORES AL ARRAY DE LA SELECCION
	//BTN GUARDAR
	$("#guardar").on('click',function(){
		var datasrl =$("#formulario").serialize();
			$.ajax({
			
			async:true,
			cache:false,
			type:"POST",
			dataType:"json",
			url:"/developer-tormesol/crud/productos/product_json.php",
			data:datasrl,
			beforeSend: function () {
            $("#loader").show();
           },
			
			success: function(response){
				//alert("se insertaron los datos correctamente");
				$("#contenido").empty();	
				$("#contenido").html(response);			
				$("#loader").hide();
				$('#mdl').modal('hide');
				$("#codebar").val('');
				$("#nombreproducto").val('');
				$("#provee").val('');
				$("#categoria").val('');
				$("#almacen").val('');
				$("#QuantityPerUnit").val('');
				$("#preciocompra").val('');
				$("#preciounitario").val('');
				$("#stock").val('');
				$("#descripcion").val('');
				$("#unidad").val('');
				clearCanvas(); 
				// $("#marca").val('');
				rec();

				}
			
			});
		
		});
		
	
	//SELECCIONAR TODO SEGUN ID TDO DEL CHECKBOX PRINCIPAL
	$("#tdo").on('click',function() {
		
			$(".sel").prop("checked", true);
			$('#tbl tr').addClass("info");
		
	});
	$("#tdo").on('click',function(){
		if($(this).is(":checked")) 
		{
			//No hacer nada
		}
		else
		{
			$(".sel").prop("checked", false);
			$('#tbl tr').removeClass("info");
		}
		});
		
	// $('.sel').change(function(){
	// 	// alert();
 //    if($(this).is(":checked")) {
 //        $(this).parent().parent().parent().addClass("info");
 //        clearCanvas();
 //        $("#miscCanvas").barcode($("#codebar").val(), "code93",{output:"canvas"}); 
	// 	$("#codebar").val($(this).parent().parent().parent().children('td:eq(1)').text());
	// 			$("#nombreproducto").val($(this).parent().parent().parent().children('td:eq(2)').text());
	// 			$("#provee").val($(this).parent().parent().parent().children('td:eq(3)').text());
	// 			$("#categoria").val($(this).parent().parent().parent().children('td:eq(4)').text());
	// 			$("#almacen").val($(this).parent().parent().parent().children('td:eq(5)').text());
	// 			$("#QuantityPerUnit").val($(this).parent().parent().parent().children('td:eq(6)').text());
	// 			$("#preciocompra").val($(this).parent().parent().parent().children('td:eq(7)').text());
	// 			$("#preciounitario").val($(this).parent().parent().parent().children('td:eq(8)').text());
	// 			$("#stock").val($(this).parent().parent().parent().children('td:eq(9)').text());
	// 			$("#descripcion").val($(this).parent().parent().parent().children('td:eq(10)').text());
	// 			$("#unidad").val($(this).parent().parent().parent().children('td:eq(11)').text());
 //    } else {
 //        $(this).parent().parent().parent().removeClass("info");
	// 	$("#tdo").prop("checked", false);
	// 	$("#codebar").val('');
	// 			$("#nombreproducto").val('');
	// 			$("#provee").val('');
	// 			$("#categoria").val('');
	// 			$("#almacen").val('');
	// 			$("#QuantityPerUnit").val('');
	// 			$("#preciocompra").val('');
	// 			$("#preciounitario").val('');
	// 			$("#stock").val('');
	// 			$("#descripcion").val('');
	// 			$("#unidad").val('');
	// 			clearCanvas(); 
 //    }
	// });
	
	
	//esta funcion se crea para despues del ajax siga funcionando por alguna razon cuando se cargaba no funcionaba
	function rec(){
	//SELECCIONAR SEGUN EL CHECKBOX DE LA TABLA ID TBL
	$("#tbl td").on('click',function() {
		var checkbox = $(':checkbox', $(this).parent()).get(0);
		var checked = checkbox.checked;
		if (checked == false)
		{ 
		checkbox.checked = true;
		clearCanvas(); 
		$(this).parent().addClass("info");
		$("#codebar").val($(this).parent().children('td:eq(1)').text());
				$("#nombreproducto").val($(this).parent().children('td:eq(2)').text());
				$("#provee").val($(this).parent().children('td:eq(3)').text());
				$("#categoria").val($(this).parent().children('td:eq(4)').text());
				$("#almacen").val($(this).parent().children('td:eq(5)').text());
				$("#QuantityPerUnit").val($(this).parent().children('td:eq(6)').text());
				$("#preciocompra").val($(this).parent().children('td:eq(7)').text());
				$("#preciounitario").val($(this).parent().children('td:eq(8)').text());
				$("#stock").val($(this).parent().children('td:eq(9)').text());
				$("#descripcion").val($(this).parent().children('td:eq(10)').text());
				$("#unidad").val($(this).parent().children('td:eq(11)').text());
		$("#miscCanvas").barcode($("#codebar").val(), "code93",{output:"canvas"});
		//funcion a usar para eliminar cuando se envia el formulario
		//termino de la funcion
		}
		else 
		{
		checkbox.checked = false;
		$(this).parent().removeClass("info");
		$("#tdo").prop("checked", false);
		$("#codebar").val('');
				$("#nombreproducto").val('');
				$("#provee").val('');
				$("#categoria").val('');
				$("#almacen").val('');
				$("#QuantityPerUnit").val('');
				$("#preciocompra").val('');
				$("#preciounitario").val('');
				$("#stock").val('');
				$("#descripcion").val('');
				$("#unidad").val('');
				clearCanvas(); 
		}
	});
	

	$('.sel').change(function(){
		// alert();
    if($(this).is(":checked")) {
        $(this).parent().parent().parent().addClass("info");
        clearCanvas();
        $("#miscCanvas").barcode($("#codebar").val(), "code93",{output:"canvas"}); 
		$("#codebar").val($(this).parent().parent().parent().children('td:eq(1)').text());
				$("#nombreproducto").val($(this).parent().parent().parent().children('td:eq(2)').text());
				$("#provee").val($(this).parent().parent().parent().children('td:eq(3)').text());
				$("#categoria").val($(this).parent().parent().parent().children('td:eq(4)').text());
				$("#almacen").val($(this).parent().parent().parent().children('td:eq(5)').text());
				$("#QuantityPerUnit").val($(this).parent().parent().parent().children('td:eq(6)').text());
				$("#preciocompra").val($(this).parent().parent().parent().children('td:eq(7)').text());
				$("#preciounitario").val($(this).parent().parent().parent().children('td:eq(8)').text());
				$("#stock").val($(this).parent().parent().parent().children('td:eq(9)').text());
				$("#descripcion").val($(this).parent().parent().parent().children('td:eq(10)').text());
				$("#unidad").val($(this).parent().parent().parent().children('td:eq(11)').text());
		$("#miscCanvas").barcode($("#codebar").val(), "code93",{output:"canvas"});
    } else {
        $(this).parent().parent().parent().removeClass("info");
		$("#tdo").prop("checked", false);
		$("#codebar").val('');
				$("#nombreproducto").val('');
				$("#provee").val('');
				$("#categoria").val('');
				$("#almacen").val('');
				$("#QuantityPerUnit").val('');
				$("#preciocompra").val('');
				$("#preciounitario").val('');
				$("#stock").val('');
				$("#descripcion").val('');
				$("#unidad").val('');
				clearCanvas(); 
    }
	});

	}//cierre de la funcion
	
			//aqui esta la funcion para el array de la seleccion para despues entregar el valor
		$("#eliminar").on('click',function(){
				  var selected = '';    
        $('#tbl tr input[type=checkbox]').each(function(){
            if (this.checked) {
                selected += $(this).val()+',';
            }
        }); 
        if (selected != '') {
			$('#mdl_confirm').modal('show');
			$("#proceso").val('eliminar');
           // alert('Has seleccionado: '+selected);  
			$("#id_oculto").val(selected);
			//$(".sel").prop("checked", false);
			//$('#tbl tr').removeClass("info");
		}
        else{
            alert('Debes seleccionar al menos una opción.');

        return false;
		}
		});
			//******************************************************************************
	
	
	//TRABAJANDO CON EL MODAL DE BOOTSTRAP PARA SEGUIR EL MISMO SENTIDO
	$("#cerrar").on('click',function(){
		
		
		var selected = '';    
        $('#tbl tr input[type=checkbox]').each(function(){
            if (this.checked) {
                selected += $(this).val()+' ';
            }
        }); 
		if(selected != '')
		{
			$('#mdl').modal('hide');
		}
		else
		{
			$('#mdl').modal('hide');
			$("#codebar").val('');
				$("#nombreproducto").val('');
				$("#provee").val('');
				$("#categoria").val('');
				$("#almacen").val('');
				$("#QuantityPerUnit").val('');
				$("#preciocompra").val('');
				$("#preciounitario").val('');
				$("#stock").val('');
				$("#descripcion").val('');
				$("#unidad").val('');
			clearCanvas(); 
		}
		/*$("#auto").val('');
		$("#marca").val('');
		$(".sel").prop("checked", false);
		$('#tbl tr').removeClass("info");*/
	
		});
		
		
		//BTN MODIFICAR
	$("#modificar").on('click',function(){
		 var selected = '';    
        $('#tbl tr input[type=checkbox]').each(function(){
            if (this.checked) {
                selected += $(this).val()+' ';
            }
        }); 
		$("#id_oculto").val(selected);
		
		if($("#codebar").val()=="" || isNaN($("#id_oculto").val()))
		{
			alert("Seleccione un registro a modificar");
			$("#codebar").val('');
				$("#nombreproducto").val('');
				$("#provee").val('');
				$("#categoria").val('');
				$("#almacen").val('');
				$("#QuantityPerUnit").val('');
				$("#preciocompra").val('');
				$("#preciounitario").val('');
				$("#stock").val('');
				$("#descripcion").val('');
				$("#unidad").val('');
				clearCanvas(); 
			$(".sel").prop("checked", false);
			$('#tbl tr').removeClass("info");
		}
		else
		{
		
		$('#mdl').modal('show');
		$("#proceso").val('modificar');
		$("#titulo").html('Modificar Datos<button type="button" class="close" id="equis" data-dismiss="modal" aria-hidden="true">×</button>');
		}
		});
		
		
		
		//BTN INGRESAR
	$("#ingresar").on('click',function(){
		$("#titulo").html('Ingresar Datos<button type="button" class="close" id="equis" data-dismiss="modal" aria-hidden="true">×</button>');
		$("#proceso").val('ingresar');
		$("#id_oculto").val('');
		$("#codebar").val('');
				$("#nombreproducto").val('');
				$("#provee").val('');
				$("#categoria").val('');
				$("#almacen").val('');
				$("#QuantityPerUnit").val('');
				$("#preciocompra").val('');
				$("#preciounitario").val('');
				$("#stock").val('');
				$("#descripcion").val('');
				$("#unidad").val('');
				clearCanvas(); 
		$(".sel").prop("checked", false);
		$('#tbl tr').removeClass("info");
		
		});

	//TRABAJANDO CON EL MODAL DE CONFIRMACION
	$("#cerrar2").on('click',function(){
		
		$("#mdl_confirm").modal('hide');
		
		});
		
		
		$("#eliminar2").on('click',function(){
			
			var datasrl =$("#formulario").serialize();
			$.ajax({
			
			async:true,
			cache:false,
			type:"POST",
			dataType:"json",
			url:"/developer-tormesol/crud/productos/product_json.php",
			data:datasrl,
			beforeSend: function () {
            $("#loader2").show();
           },
			
			success: function(response){
				//alert("se insertaron los datos correctamente");
				$("#contenido").empty();	
				$("#contenido").html(response);			
				$("#loader2").hide();
				$('#mdl_confirm').modal('hide');
				rec();

				}
			
			});
			
			});
		
		
		//CUANDO SE NECESITE CARGAR DATOS EN VENTANA MODAL
		/*$('#ventana_modal').on('hidden', function() 
		{
			 $(this).removeData('modal');
		});*/
		//*************************************************
		
		
		//******************************************************************************
		$("#secciones").on('keyup',function(){
			
			$("#bsq").val($("#secciones").val());
			$("#bsq2").val($("#opt-busqueda").val());
			$("#proceso").val('buscar');
			var datasrl =$("#formulario").serialize();
			$.ajax({
			
			async:true,
			cache:false,
			type:"POST",
			dataType:"json",
			url:"/developer-tormesol/crud/productos/product_json.php",
			data:datasrl,
			beforeSend: function () {
            $("#loader3").show();
           },
			
			success: function(response){
				//alert("se insertaron los datos correctamente");
				$("#contenido").empty();	
				$("#contenido").html(response);			
				$("#loader3").hide();
				rec();

				}
			
			});
			
			
		});
		$("#opt-busqueda").on('change',function(){
			
			$("#secciones").val('');
			$("#bsq").val('');
			});
		//******************************************************************************
	
});//CIERRE DE LA FUNCION PRINCIPAL DE COMIENZO DEL JQUERY
