// Guia Jose Mancilla Desarrollador


$(function(){

$(document).keypress(function(event){

    if (event.keyCode == 10 || event.keyCode == 13)  {
        event.preventDefault();
    }
});
//TRABAJAR CON EL BTN PARA GUARDAR LOS DATOS

	$("#btn-cotizacion").on('click',function(event){
		 event.preventDefault();
		 
			var datasrl =$("#form_tbl").serialize();
			$.ajax({
			
			async:true,
			cache:false,
			type:"POST",
			dataType:"json",
			url:"insert_compra_sql.php",
			data:datasrl,
			success: function(response){
				
				
				alert("Registro insertado!");
				window.location = 'compracrud_main.php';
				
			}
			
			});

	});
	
	//json para el calculo de los productos
	




//*************************************************************************************
	
	//creando las funciones para ajax para evitar problemas
});//cierre del document ready