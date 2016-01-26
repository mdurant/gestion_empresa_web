// Guia Jose Mancilla Desarrollador


$(function(){
/*$(".cod").on('keyup',function(){
	
	$(this).parent().parent().parent().children('td:eq(2)').children().children().text('Holapos');
	});*/
	
	//FUNCION PARA CODIGO
	
$(".cod").on('keyup',function(){
	if($(this).val()==0)
	{
		$(this).parent().parent().parent().children('td:eq(1)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(2)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(3)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(4)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(5)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(6)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(7)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(8)').text('');
		$(this).parent().parent().parent().children('td:eq(10)').text('');
		
		$("#tbl_foot tr td:eq(0)").children().html('<span  id="pre-load" style="display:none;">&nbsp;&nbsp;Procesando....&nbsp;&nbsp;<img src="../../img/loadingAnimation.gif"/></span>');
		
		
		
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
		
		//desactivo los input al perder los datos
		$(this).parent().parent().parent().children('td:eq(3)').children().children().prop('disabled',true);
		$(this).parent().parent().parent().children('td:eq(4)').children().children().prop('disabled',true);
		$(this).parent().parent().parent().children('td:eq(5)').children().children().prop('disabled',true);
		$("#pre-load").hide();
	}else
	{
		$("#tbl_foot tr td:eq(0)").children().html('<span  id="pre-load" style="display:none;">&nbsp;&nbsp;Procesando....&nbsp;&nbsp;<img src="../../img/loadingAnimation.gif"/></span>');
		
		$("#bsq").val($(this).val());
		var estoy = $(this);
		var datasrl =$("#form_tbl").serialize();
			$.ajax({
			
			async:true,
			cache:false,
			type:"POST",
			dataType:"json",
			//url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
			url:"cotizacion_json.php",
			data:datasrl,
			beforeSend: function () {
				$("#pre-load").show();
           },
			
			success: function(response){
				//alert("se insertaron los datos correctamente");
				if(response=="nada")
				{
				estoy.parent().parent().parent().children('td:eq(2)').children().children().val('');
				estoy.parent().parent().parent().children('td:eq(3)').children().children().val('');
				estoy.parent().parent().parent().children('td:eq(4)').children().children().val('');
				estoy.parent().parent().parent().children('td:eq(5)').children().children().val('');
				estoy.parent().parent().parent().children('td:eq(6)').children().children().val('');
				estoy.parent().parent().parent().children('td:eq(7)').children().children().val('');
				estoy.parent().parent().parent().children('td:eq(8)').text('');
				estoy.parent().parent().parent().children('td:eq(10)').text('');
				
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
		//$("#pre-load").hide();
				}else
				{
				estoy.parent().parent().parent().children('td:eq(2)').children().children().val(response.descripcion);
				estoy.parent().parent().parent().children('td:eq(4)').children().children().val(response.almacen);
				estoy.parent().parent().parent().children('td:eq(8)').text(response.precio);
				estoy.parent().parent().parent().children('td:eq(6)').children().children().val(response.precio);
				estoy.parent().parent().parent().children('td:eq(10)').text(response.stock);
				estoy.parent().parent().parent().children('td:eq(3)').children().children().prop('disabled',false);
				estoy.parent().parent().parent().children('td:eq(4)').children().children().prop('disabled',false);
				$("#pre-load").hide();
				}
			}//succes
			
			});	
	}
	});
$(".cod").on('focusout',function(){
		if($(this).val()==0)
		{
		$(this).parent().parent().parent().children('td:eq(1)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(2)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(3)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(4)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(5)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(6)').children().children().val('');
		$(this).parent().parent().parent().children('td:eq(8)').text('');
		$(this).parent().parent().parent().children('td:eq(10)').text('');
		
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
		
		
		}else
		{		
		if($(".cant").val()==0)
		{
		}else
		{
		//activar los inout que correspondan
		$(this).parent().parent().parent().children('td:eq(3)').children().children().prop('disabled',false);
		$(this).parent().parent().parent().children('td:eq(4)').children().children().prop('disabled',false);
		$(this).parent().parent().parent().children('td:eq(3)').children().children().focus();
		}
		}
	});
$(".cod").keypress(function(e) {
  if(e.which == 13) {
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
			$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-important">El stock en bodega es de: '+ total_stock +'</span>');
		}else
		{
		$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-info">El stock en bodega es de: '+ total_stock +'</span>');
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
		$(this).parent().parent().parent().children('td:eq(5)').children().children().prop('disabled',true);
		$(this).parent().parent().parent().children('td:eq(7)').children().children().val('');
		
		
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
		
		//calculando el stock con todo lo demas
		var val_ctrl=$(this).val();
		var ctrl_stock = Number($(this).parent().parent().parent().children('td:eq(10)').text());
		var total_stock = ctrl_stock - val_ctrl;
		if(total_stock<0)
		{
			$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-important">El stock en bodega es de: '+ total_stock +'</span>');
		}else
		{
		$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-info">El stock en bodega es de: '+ total_stock +'</span>');
		}
		//alert(stock_warning);
	
	}
	else
	{
	$(this).parent().parent().parent().children('td:eq(5)').children().children().prop('disabled',false);
	var v1=parseFloat($(this).parent().parent().parent().children('td:eq(6)').children().children().val());
	var v2=parseFloat($(this).parent().parent().parent().children('td:eq(3)').children().children().val());
	var resultado = (v1 * v2).toFixed();
	var resultado_iva = parseFloat((resultado*19)/100);
	var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
	//alert(resultado_iva);
	//var resultado2 = (v1*v2);
	$(this).parent().parent().parent().children('td:eq(9)').text(resultado_total);
	$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
	
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
		
			//calculando el stock con todo lo demas
		var val_ctrl=$(this).val();
		var ctrl_stock = Number($(this).parent().parent().parent().children('td:eq(10)').text());
		var total_stock = ctrl_stock - val_ctrl;
		if(total_stock<0)
		{
			$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-important">El stock en bodega es de: '+ total_stock +'</span>');
		}else
		{
		$("#tbl_foot tr td:eq(0)").children().html('<span class="label label-info">El stock en bodega es de: '+ total_stock +'</span>');
		}
		//alert(stock_warning);
	}
	}//cierre de la comprobacion del float
	});
$(".cant").keypress(function(e) {
  if(e.which == 13) {
	    event.preventDefault(); 
   //FUNCION DE LA SUMA
   $(this).parent().parent().parent().children('td:eq(5)').children().children().prop('disabled',false);
   	var v1=parseFloat($(this).parent().parent().parent().children('td:eq(6)').children().children().val());
	var v2=parseFloat($(this).parent().parent().parent().children('td:eq(3)').children().children().val());
	var resultado = (v1 * v2).toFixed();
	var resultado_iva = parseFloat((resultado*19)/100);
	var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
	$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
	$(this).parent().parent().parent().children('td:eq(9)').text(resultado_total);
	$(this).parent().parent().parent().children('td:eq(5)').children().children().focus();
	
	
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
  }
  if($(this).val()=="")
  {
	  
  }
});


	//FUNCION PARA LOS DESCUENTOS
	
	
	$(".desc").keypress(function(e) {
  	if(e.which == 13) {
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
		var resultado_iva = parseFloat((resultado*19)/100);
		var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
		$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
	//FIN DE LA FUNCION
	
	
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
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
		var resultado_iva = parseFloat((resultado*19)/100);
		var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
		$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
	//FIN DE LA FUNCION
	
	
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
	$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
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
	var resultado_iva = parseFloat((resultado*19)/100);
	var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
	$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());	
	
	
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
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
		var resultado_iva = parseFloat((resultado*19)/100);
		var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
		$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
	//FIN DE LA FUNCION
	
	
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
	
		$(this).focus();
	}
	if($(this).val()==0)
	{
		$(this).parent().parent().parent().children('td:eq(6)').children().children().val($(this).parent().parent().parent().children('td:eq(8)').text());
		
			//FUNCION 
	
		var v1=parseFloat($(this).parent().parent().parent().children('td:eq(8)').text());
		var v2=parseFloat($(this).parent().parent().parent().children('td:eq(3)').children().children().val());
		var resultado = (v1 * v2).toFixed();
		var resultado_iva = parseFloat((resultado*19)/100);
		var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
		$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
		
	//FIN DE LA FUNCION
	
	
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
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
	var resultado_iva = parseFloat((resultado*19)/100);
	var resultado_total = parseFloat(parseFloat(resultado_iva) + parseFloat(resultado));
	$(this).parent().parent().parent().children('td:eq(7)').children().children().val(resultado_total.toFixed());
	
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
		iva=(total_direct*19)/100;
		neto =(total_direct-iva);
	/*	var iva = parseFloat(total_direct)*0.19;
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>&nbsp;&nbsp;'+neto+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>&nbsp;&nbsp;'+iva+'</center>');*/
		$("#tbl_foot tr td:eq(3)").html('<center><small><strong>Total:</strong></small>  '+total_direct+'</center>');
		$("#tbl_foot tr td:eq(2)").html('<center><small><strong>Iva:</strong></small>  '+iva.toFixed()+'</center>');
		$("#tbl_foot tr td:eq(1)").html('<center><small><strong>Neto:</strong></small>  '+neto.toFixed()+'</center>');
	}
	
	}//cierre de la comprobacion del float
	});


//TRABAJAR CON EL BTN PARA GUARDAR LOS DATOS

	$("#btn-cotizacion").on('click',function(e){
		 event.preventDefault();
		 if($(".cod").val()==0 || $("#scliente").val()==0 || $("#tempresa").val()==0)
		 {
			 alert("Rellena los campos necesarios");
		 }
		 else
		 {
			$(".act").prop("disabled",false); 
		//trabajo con el ajax
			 //para guardar el valor del neto
		 var neto1=$("#tbl_foot tr td:eq(1)").children().text().replace("Neto:","");
		var neto2=neto1.replace(/\s/g,"");
		$("#neto").val(neto2);
		var neto3=Number($("#neto").val());
		$("#neto").val(neto3);
		//para guardar el valor del iva
		var iva1=$("#tbl_foot tr td:eq(2)").children().text().replace("Iva:","");
		var iva2=iva1.replace(/\s/g,"");
		$("#iva").val(iva2);
		var iva3=Number($("#iva").val());
		$("#iva").val(iva3);
		//para guardar el valor del total
		var total1=$("#tbl_foot tr td:eq(3)").children().text().replace("Total:","");
		var total2=total1.replace(/\s/g,"");
		$("#total").val(total2);
		var total3=Number($("#total").val());
		$("#total").val(total3);
		var valores="valgo";
		if(valores=="valgo")
		{
			var datasrl =$("#form_tbl").serialize();
			$.ajax({
			
			async:true,
			cache:false,
			type:"POST",
			dataType:"json",
	//url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/insert_cotizacion_sql.php",
			url:"insert_cotizacion_sql.php",
			data:datasrl,
			beforeSend: function () {
				$("#pre-load").show();
           },
			
			success: function(response){
				alert("Cotizacion Creada y generada");
		$(".act").prop("disabled",true); 	
			location.reload();
				
			}
			
			});
		}
		
		 }//cierre del else del if de la validacion de los datos necesarios 
	});




//*************************************************************************************
	
	//creando las funciones para ajax para evitar problemas
});//cierre del document ready