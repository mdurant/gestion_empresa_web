// FULLCODE Ltda.

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

   // $("#tbl_foot tr td:eq(1)").html('<center><small><strong>Total Neto:</strong></small>  '+neto.toFixed()+'</center>');
    
}


$(function() {





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
			
            $tr.find("#total_tbl").val('');
			
            calcular_total();

		}
		else
		{
            var $tr=$(this).parent().parent().parent();
            
			var v1=parseFloat($tr.find("#valor").val());
			var v2=parseFloat($tr.find("#cantidades").val());
            
			var resultado = (v1 * v2).toFixed();

            $tr.find("#total_tbl").val(resultado);
            $tr.find("#preciototal").text(resultado);

            calcular_total();

		}
	}
});

$(".cant").keypress(function(event) {
	if(event.which == 13) {
		event.preventDefault();
        

        var $tr=$(this).parent().parent().parent();
        
        var v1=parseFloat($tr.find("#valor").val());
        var v2=parseFloat($tr.find("#cantidades").val());

		var resultado = (v1 * v2).toFixed();

        $tr.find("#total_tbl").val(resultado);
        $tr.find("#preciototal").text(resultado);

        calcular_total();

    }
	if($(this).val()=="")
	{
		
	}
});

    //TRABAJAR CON EL BTN PARA GUARDAR LOS DATOS

    $("#Ingresars").on('click', function(event) {
        event.preventDefault();

        
         var datasrl = $("#form_tbl").serialize();
            $.ajax({

                async: true,
                cache: false,
                type: "POST",
                dataType: "json",
                url: "insert_solicitudes_sql.php",
                data: datasrl,
                success: function(response) {
                   // alert("Solicitud Interna creada correctamente!");
                    alert(response);
                    window.location = 'solicitudescrud_main.php';

                }

            });



    });

    //TRABAJAR CON EL BTN PARA GUARDAR LOS DATOS

    $("#Editars").on('click', function(event) {
        event.preventDefault();

        var datasrl = $("#form_tbl").serialize();
        $.ajax({

            async: true,
            cache: false,
            type: "POST",
            dataType: "json",
            url: "editar_orden_sql.php",
            data: datasrl,
            success: function(response) {
                //alert("Se Edito Correctamente");
                //alert(response);
                alert("O.T. actualizada correctamente!");
                window.location = 'ordencrud_main.php';

            }

        });

    });

    //post misma pagina con jquery probando para la edicion

    
    function Right(str, n){
        if (n <= 0)
           return "";
        else if (n > String(str).length)
           return str;
        else {
           var iLen = String(str).length;
           return String(str).substring(iLen, iLen - n);
        }
    }    
        
    $("#bsq_pla").on('click', function(event) {
        event.preventDefault();



        $("input#cod_complete").val("");
        $("input#descri").val("");
        $("input#cantidades").val("");
        $("select#bodega").val("0");
        $("input#valor").val("");
        $("input#total_tbl").val("");
        $("input#id_detalles").val("");

        
        
        var datasrl = $("#form_tbl").serialize();
        $.ajax({

            async: true,
            cache: false,
            type: "POST",
            dataType: "json",
            url: "cargar_plantilla.php",
            data: datasrl,
            success: function(response) {

                $.each(response, function(key, value) {
                    

                    if (key == "total") {

                    } else {
                        
                        $num=Right(key,1);

                        
                        var $Codigo="Codigo"+$num;
                        var $descripcion="descripcion"+$num;
                        var $almacen="almacen"+$num;
                        var $cantidad="cantidad"+$num;
                        var $valor="valor"+$num;
                        var $total_tbl="total_tbl"+$num;
                        

                        if (key==$Codigo) {
                            
                            //alert($Codigo+":"+value);
                            $("input#cod_complete").eq($num).val(value);
                            
                        }else if (key==$descripcion) {
                            
                            //alert($descripcion+":"+value);
                            $("textarea#descri").eq($num).val(value);
                            
                        }else if (key==$almacen) {
                            
                            //alert($almacen+":"+value);
                            $("select#bodega").eq($num).val(value);
                            
                        }else if (key==$cantidad) {
                            
                            //alert($cantidad+":"+value);
                            $("input#cantidades").eq($num).val(value);
                        
                        }else if (key==$valor) {
                            
                            //alert($valor+":"+value);
                            $("input#valor").eq($num).val(value);
                        
                        }else if (key==$total_tbl) {
                            
                            //alert($valor+":"+value);
                            $("input#total_tbl").eq($num).val(value);
                        
                        }

                    }

                });
                
                calcular_total();


            }

        });

    });
    
    
    
/*
    $(document).keypress(function(event){

         if (event.keyCode == 10 || event.keyCode == 13)  {
             //event.preventDefault();
             //alert($("#tbl_bod tbody tr td:eq(2)").children().children().eq(2).val());
             //alert($("table#tbl_bod tr td").eq(2).children().children().eq(1).val());
             //alert($("input#cod_complete").eq(2).val());
         }
     });
*/

//*************************************************************************************
    
    //creando las funciones para ajax para evitar problemas
});//cierre del document ready*/