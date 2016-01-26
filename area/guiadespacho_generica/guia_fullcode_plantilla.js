// Guia Jose Mancilla Desarrollador


$(function(){
//
//$(document).keypress(function(event){
//
//    if (event.keyCode == 10 || event.keyCode == 13)  {
//        event.preventDefault();
//    }
//});

//TRABAJAR CON EL BTN PARA GUARDAR LOS DATOS

	$("#btn-plantilla").on('click',function(event){
		 event.preventDefault();
		 
			var datasrl =$("#form_tbl").serialize();
			$.ajax({
			
			async:true,
			cache:false,
			type:"POST",
			dataType:"json",
			url:"insert_eplantillaot_sql.php",
			data:datasrl,
			success: function(response){
				alert("Se Ingreso Correctamente");
				window.location = 'plantillacrud_main.php';
				
			}
			
			});

	});
	
	//json para el calculo de los productos
	
	$("#btn-plantillae").on('click',function(event){
		 event.preventDefault();
		 
			var datasrl =$("#form_tbl").serialize();
			$.ajax({
			
			async:true,
			cache:false,
			type:"POST",
			dataType:"json",
			url:"edit_eplantillaot_sql.php",
			data:datasrl,
			success: function(response){
				//alert(response);
				alert("Se Edito Correctamente");
				window.location = 'plantillacrud_main.php';
				
			}
			
			});

	});
	


//*************************************************************************************
	
	//creando las funciones para ajax para evitar problemas
});//cierre del document ready