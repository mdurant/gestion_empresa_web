// JavaScript Document
// Main CRUD Productos
// Gestión Tormesol
// Fullcode Ltda.
// Unidad Desarrollos


$(function(){
	rec();
    
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
			url:"/developer-tormesol/crud/clientes/clientes_json.php",
			data:datasrl,
			beforeSend: function () {
       //     $("#loader").show();
           },
			
			success: function(response){
				// alert("se Insertaron los datos correctamente");
				// $("#contenido").empty();	
				//alert("hola");
				$("#contenido").html(response);			
			//	$("#loader").hide();
			
			/*
			'$rut', '$cliente', '$empresa', '$domicilioe', '$domiciliod', '$telefono', '$web', '$emailempresa', '$giro', '$contacto', '$telefonocontacto', '$emailcontacto', '$twitter','$pais','$region','$provincia','$ciudad','$comuna','$formapago','activo'
			*/
			
				$('#mdl').modal('hide');
				$("#rut").val('');
				$("#cliente").val('');
				$("#empresa").val('');
				$("#domicilioe").val('');
				$("#domiciliod").val('');
				$("#telefono").val('');
				$("#web").val('');
				$("#emailempresa").val('');
				$("#giro").val('');
				$("#contacto").val('');
				$("#telefonocontacto").val('');
				$("#emailcontacto").val('');
				$("#twitter").val('');
				$("#pais").val('');
				$("#region").val('');
				$("#provincia").val('');
				$("#ciudad").val('');
				$("#comuna").val('');
				$("#formapago").val('');
				$("#estado_0").val('');
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
		
	$('.sel').change(function(){
    if($(this).is(":checked")) {
		/*
			'$rut', '$cliente', '$empresa', '$domicilioe', '$domiciliod', '$telefono', '$web', '$emailempresa', '$giro', '$contacto', '$telefonocontacto', '$emailcontacto', '$twitter','$pais','$region','$provincia','$ciudad','$comuna','$formapago','activo'
			*/
		
        $(this).parent().parent().parent().addClass("info");
		$("#rut").val($(this).parent().parent().parent().children('td:eq(1)').text());
		$("#cliente").val($(this).parent().parent().parent().children('td:eq(2)').text());
		$("#empresa").val($(this).parent().parent().parent().children('td:eq(3)').text());
		$("#domicilioe").val($(this).parent().parent().parent().children('td:eq(4)').text());
		$("#domiciliod").val($(this).parent().parent().parent().children('td:eq(5)').text());
		$("#telefono").val($(this).parent().parent().parent().children('td:eq(6)').text());
		$("#web").val($(this).parent().parent().parent().children('td:eq(7)').text());
		$("#emailempresa").val($(this).parent().parent().parent().children('td:eq(8)').text());
		$("#giro").val($(this).parent().parent().parent().children('td:eq(9)').text());
		$("#contacto").val($(this).parent().parent().parent().children('td:eq(10)').text());
		$("#telefonocontacto").val($(this).parent().parent().parent().children('td:eq(11)').text());
		$("#emailcontacto").val($(this).parent().parent().parent().children('td:eq(12)').text());
		$("#twitter").val($(this).parent().parent().parent().children('td:eq(13)').text());
		$("#pais").val($(this).parent().parent().parent().children('td:eq(14)').text());
		$("#region").val($(this).parent().parent().parent().children('td:eq(15)').text());
		$("#provincia").val($(this).parent().parent().parent().children('td:eq(16)').text());
		$("#ciudad").val($(this).parent().parent().parent().children('td:eq(17)').text());
		$("#comuna").val($(this).parent().parent().parent().children('td:eq(18)').text());
		$("#formapago").val($(this).parent().parent().parent().children('td:eq(19)').text());
		$("#estado_0").val($(this).parent().parent().parent().children('td:eq(20)').text());
		
    } else {
        $(this).parent().parent().parent().removeClass("info");
		$("#tdo").prop("checked", false);
		$("#rut").val('');
				$("#cliente").val('');
				$("#empresa").val('');
				$("#domicilioe").val('');
				$("#domiciliod").val('');
				$("#telefono").val('');
				$("#web").val('');
				$("#emailempresa").val('');
				$("#giro").val('');
				$("#contacto").val('');
				$("#telefonocontacto").val('');
				$("#emailcontacto").val('');
				$("#twitter").val('');
				$("#pais").val('');
				$("#region").val('');
				$("#provincia").val('');
				$("#ciudad").val('');
				$("#comuna").val('');
				$("#formapago").val('');
				$("#estado_0").val('');
    }
	});
	
	
	//esta funcion se crea para despues del ajax siga funcionando por alguna razon cuando se cargaba no funcionaba
	function rec(){
	//SELECCIONAR SEGUN EL CHECKBOX DE LA TABLA ID TBL
	$("#tbl td").on('click',function() {
		var checkbox = $(':checkbox', $(this).parent()).get(0);
		var checked = checkbox.checked;
		if (checked == false)
		{ 
		checkbox.checked = true;
		$(this).parent().addClass("info");
		$("#cliente").val($(this).parent().children('td:eq(1)').text());
		$("#rut").val($(this).parent().children('td:eq(2)').text());
		$("#comuna").val($(this).parent().children('td:eq(3)').text());
		$("#estado_0").val($(this).parent().children('td:eq(4)').text());
		//funcion a usar para eliminar cuando se envia el formulario
		//termino de la funcion
		}
		else 
		{
		checkbox.checked = false;
		$(this).parent().removeClass("info");
		$("#tdo").prop("checked", false);
		$("#cliente").val('');
		$("#rut").val('');
		$("#comuna").val('');
		$("#estado_0").val('');
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
            alert('Has seleccionado: '+selected);  
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
			$("#cliente").val('');
			$("#rut").val('');
			$("#comuna").val('');
			$("#estado_0").val('');
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
		
		if($("#cliente").val()=="" || isNaN($("#id_oculto").val()))
		{
			alert("Seleccione un registro a modificar");
			$("#cliente").val('');
			$("#rut").val('');
			$("#comuna").val('');
			$("#estado_0").val('');
			$(".sel").prop("checked", false);
			$('#tbl tr').removeClass("info");
		}
		else
		{
		
		$('#mdl').modal('show');
		$("#proceso").val('modificar');
		$("#titulo").html('Modificar Datos Cliente<button type="button" class="close" id="equis" data-dismiss="modal" aria-hidden="true">×</button>');
		}
		});
		
		
		
		//BTN INGRESAR
	$("#ingresar").on('click',function(){
				$("#titulo").html('Ingresar Datos Cliente<button type="button" class="close" id="equis" data-dismiss="modal" aria-hidden="true">×</button>');
				$("#proceso").val('ingresar');
				$("#id_oculto").val('');
				$("#rut").val('');
				$("#cliente").val('');
				$("#empresa").val('');
				$("#domicilioe").val('');
				$("#domiciliod").val('');
				$("#telefono").val('');
				$("#web").val('');
				$("#emailempresa").val('');
				$("#giro").val('');
				$("#contacto").val('');
				$("#telefonocontacto").val('');
				$("#emailcontacto").val('');
				$("#twitter").val('');
				$("#pais").val('');
				$("#region").val('');
				$("#provincia").val('');
				$("#ciudad").val('');
				$("#comuna").val('');
				$("#formapago").val('');
				$("#estado").val('');
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
			url:"/developer-tormesol/crud/clientes/clientes_json.php",
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
			url:"/developer-tormesol/crud/clientes/clientes_json.php",
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
