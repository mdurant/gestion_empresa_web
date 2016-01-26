<?php


require_once("../validatesession_html.php");
require_once("../conexion/funciones.php");


$tra=new funciones();

$res3=$tra->cta_cte();


$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Cheklist Pago Proveedores Masivo</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <!-- bootstrap -->
    <script src="../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <link  href="../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />

	<!-- jquery -->
	<script src="../scripts/jquery/jquery.js" type="text/javascript"></script>
    <script src="../scripts/jquery/jquery-ui.js" type="text/javascript"></script>
    <link  href="../scripts/jquery/themes/<?=$ACTUAL_THEME?>/jquery-ui.css" rel="stylesheet" type="text/css" />
		
    <!-- jtable -->
	<script src="../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
    <script src="../scripts/jtable/jquery.jtable.es.js" type="text/javascript"></script>
    <link  href="../scripts/jtable/themes/<?=$JTABLE_THEME?>" rel="stylesheet" type="text/css" />
    
    <!-- jquery.validationEngine -->
	<script src="../scripts/jquery/validate/jquery.validationEngine.js" type="text/javascript" ></script>
    <script src="../scripts/jquery/validate/jquery.validationEngine-es.js" type="text/javascript"></script>
    <link  href="../scripts/jquery/validate/validationEngine.jquery.css" rel="stylesheet" type="text/css" />

</head>

<body class="ui-widget">

<h4>Cheklist Pago Proveedores Masivo</h4>

<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px">
    <form style="margin: 0px">
	<table width="65%" cellspacing="2" cellpadding="4">
	    <tbody>
		<tr>
		    <td width="60%">
			<table width="100%">
			    <tbody>
				<tr>
				    <td>
					<h5 style="width:30px">Buscar</h5>
				    </td>

				    <td><input type="text" id="bsqrut" name="bsqrut" style="width:100%" placeholder="Buscar por RUT o Nombre Proveedor" class="form-control input-sm ui-corner-all"></td>
				</tr>
			    </tbody>
			</table>
		    </td>

		    
		    <td width="20%" align="center">
			<button style="height: 30px; width: 100px" aria-disabled="false" role="button"
				class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary"
				id="btnBUSCAR" type="submit">
		    <span class="ui-icon ui-icon-search"></span>
		    <span class="ui-button-text">Buscar</span>
			</button>
		    </td>
		</tr>
	    </tbody>
	</table>
    </form>
</div>

<div style="height: 5px;width: 100%;"></div>

<div id="jt_pago_proveedores" style="width: 100%;"></div>

<div id="documentar" title="Documentar">
    <p class="prov"></p>
    <label>Pagos asociados a cuenta de <strong>BANCO CHILE</strong></label>
    <label>Cantidad Cheques: </label>
    <select name="cantidad_cheques" class="form-control" id="cantidad_cheques">
    	<option value="0">Seleccionar Cantidad</option>
    	<option value="1">1</option>
    	<option value="2">2</option>
    	<option value="3">3</option>
    	<option value="4">4</option>
    	<option value="5">5</option>
    	<option value="6">6</option>
    	<option value="7">7</option>
    	<option value="8">8</option>
    	<option value="9">9</option>
    	<option value="10">10</option>
    	<option value="11">11</option>
    	<option value="12">12</option>    	
    </select><br>
    <label>Valor por cada Cheque: </label>
    <label id="valorCheque" class="form-control"></label><br>
    <label>Valor Ultimo Cheque: </label>
    <label id="UvalorCheque" class="form-control"></label><br>
    <div id="contiene">
		
			
			
			<select name="banco" style="display:none;" class="form-control" id="b0">
					<option value="0">--Seleccionar--</option>
					<?php
					for($e=0;$e<sizeof($res3);$e++)
					{
					?>
					<option value="<?=$res3[$e]["id_ctacte"]?>"><?=$res3[$e]["numero_cta"]?> - <?=$res3[$e]["nombre_banco"]?></option>
					<?php
					}
					?>
			</select><br>
		
	<div>
	

</div>

<div id="error" title="Documentar">

</div>


<style>

form.jtable-dialog-form 
{ 
	width:500px; top:0px;
}

</style>        
<script type="text/javascript">

	$(document).ready(function() {


		//variable verificadora
		verificar = true;
		Estado2 = true;

	    $('#jt_pago_proveedores').jtable({
		jqueryuiTheme: true,
		title: 'Listado General',
		paging: true,
		pageSize: 10,
		sorting: true,
		defaultSorting: 'RUT ASC',
		selecting: true,
		multiselect: true,
		selectingCheckboxes: true,
		actions: {
		    listAction: 'check_proveedores_sql.php?action=list'		   
		},
		toolbar: {
		    items: [{
			icon: '../toolbar-icon/pago.gif',
			text: 'Documentar Cheques',
			click: function() {

			    var $selectedRows = $('#jt_pago_proveedores').jtable('selectedRows');
			    $selectedRows.each(function () {

        		if($(this).data('record')[7]=="PAGADO")
        		{
        			$('#error').html("");
        			$('#error').append(" <p>Solo seleccionar con estado Pendiente Pago </p>");
			    	$("#error").dialog("open");
			    	Estado2 = false;
			    	return false;
        		}else{
        			Estado2 = true;
        		}

			    });
			    // console.log($selectedRows);

			    if ($selectedRows.length > 0) {
			    	if(Estado2==false)
			    	{

			    	}else{
			    		if(verificar==true)
				    	{
				    		$('.prov').html("");
				    		$('#valorCheque').html("");
							$('.prov').append("Total de facturas Seleccionadas <strong>" + $selectedRows.length + "</strong>");
							$('#valorCheque').append(Moneda(totsum.toString()));
							$('.prov').append("<br>Valor Total Facturas <strong> $ " + Moneda(totsum.toString()) + "</strong>");
							
							$("#documentar").dialog("open");
				    	}else{
				    		$('#error').html("");
							$('#error').append(" <p>Debes Seleccionar el mismo proveedor</p>");
				    		$("#error").dialog("open");
				    	}
			    	}
			    	
			   
			    } else {
					alert("Debe seleccionar alguna factura.");
			    }

			}
		    }]
		},
		fields: {
		    id_ecompra: {
			key: true,
			create: false,
			edit: false,
			list: false
		    },
		    RUT: {
			title: 'Rut',
			width: '10%',
			list: true

		    },
		    Suppliers: {
			title: 'Proveedores',
			width: '20%',
			list: true
		    },		    
		    total: {
			title: 'Total',
			width: '30%',
			list: true
		    },
		    contador: {
			title: 'Contador',
			width: '20%',
			list: true
		    },
		    estadocontable:{
                title: 'Estado',
                width: '15%',
                create: true,
                edit: true,
                list: true
            },
            EC:{
               title: 'EC',
                width: '1%',
                sorting: false,
                edit: false,
                create: false,
                list: true,
                display: function(datos) {

                //Create an image that will be used to open child table
                if(datos.record.estadocontable == "PENDIENTE PAGO")
                {
                	                	
                    var $img = $('<center><button title="EC" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../toolbar-icon/Rojo.png" style="cursor:pointer;" title="" /></button></center>');
                    
                    return $img;
                }else
                {



                    var $img = $('<center><button title="EC" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../toolbar-icon/Verde.jpg" style="cursor:pointer;" title="" /></button></center>');

                    $img.on("click", function()
                    {

                    });
                    return $img;
                }

                return $img;
                
                }
            },
            folio_factura: {
			title: 'Factura',
			width: '20%',
			list: false,
		    },
            
		    IDsuppliers: {
			title: 'IDsuppliers',
			width: '10%',
			list: false
		    },
			

		},
		selectionChanged: function () {
                //Get all selected rows
                var $selectedRows = $('#jt_pago_proveedores').jtable('selectedRows');

                
 				
                $('#SelectedRowList').empty();
                cont = 0;
                rutp = 0;
                totsum = 0;

                 if ($selectedRows.length > 0) {	                    
                    
                    $selectedRows.each(function () {


                   	

                    	var record = $(this).data('record');

                    	totsum = parseInt(record.total) + parseInt(totsum); 
                    	$('.total_suma').text(totsum);

                        
                        if(cont==0)
                        {
                        	rutp = record.RUT;
                        	verificar = true;
                        }else if(rutp != record.RUT)
                        {                        	
                        	verificar = false;
                        	return false;
                        }else{
                        	verificar = true;
                        }

                        cont++;
            		});
                }
        },
		formCreated: function(event, data) {

		    $(".ui-dialog").css("top", "0px");
		    
		    $("#ui-id-5, #ui-id-3").css('height', '350px').css('top', '0px').css('overflow-y', 'scroll').css('overflow-x', 'hidden');
		    $("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary ui-corner-all');

		    $("form input, form textarea, form select").attr('class', 'form-control input-sm ui-corner-all');


		    $("#Edit-rut").css('width', '150px').attr('title', 'Ingrese rut valido');

		    $("#Edit-Cliente").css('width', '250px');

		    $("#Edit-Empresa").css('width', '250px');

		    $("#Edit-DomicilioEmpresa").css('width', '350px');

		    $("#Edit-DomicilioDespacho").css('width', '350px');

		    $("#Edit-Telefono").css('width', '200px');

		    $("#Edit-Web").css('width', '250px');

		    $("#Edit-EmailContacto").css('width', '250px');

		    $("#Edit-TelefonoContacto").css('width', '250px');

		    $("#Edit-Contacto").css('width', '250px');

		    $("#Edit-Giro").css('width', '400px');

		    $("#Edit-TwitterContacto").css('width', '250px');

		    $("#Edit-IDComuna").css('width', '250px');

		    $("#Edit-IDFormaPago").css('width', '250px');


		   
		    
		},

		recordsLoaded: function(event, data) {

			function Moneda(entrada){
					var num = entrada.replace(/\./g,"");
					if(!isNaN(num)){
					num = num.toString().split("").reverse().join("").replace(/(?=\d*\.?)(\d{3})/g,"$1.");
					num = num.split("").reverse().join("").replace(/^[\.]/,"");
					entrada = num;
					}else{
					entrada = input.value.replace(/[^\d\.]*/g,"");
					}
					return entrada;
				}			
	        
	        $(".jtable-main-container tr").find("td:eq(3)").each(function () {
					    $(this).text(Moneda($(this).text()));
			});




            	$('#jt_pago_proveedores tbody tr').each(function()
			    {
			    	if($(this).find('td:eq(5)').text()=="PENDIENTE PAGO")
			    	{
			    		$(this).css("background", "#F2DEDE");
			    	}else{

			    	}
			    });
    	},


	    });

		
	    $('#jt_pago_proveedores').jtable('load', undefined, function(){    

	    		
	    		$('#jt_pago_proveedores tbody tr').each(function()
			    {
			    	if($(this).find('td:eq(5)').text()=="PENDIENTE PAGO")
			    	{
			    		$(this).css("background", "#F2DEDE");
			    	}else{

			    	}
			    });
	    		
				/*
	    		$(".jtable-main-container tr").find("td:last").each(function () {
					    $(this).text(Moneda($(this).text()));
				});
*/

	    
    			
		});

		
		
	    function Moneda(entrada){
					var num = entrada.replace(/\./g,"");
					if(!isNaN(num)){
					num = num.toString().split("").reverse().join("").replace(/(?=\d*\.?)(\d{3})/g,"$1.");
					num = num.split("").reverse().join("").replace(/^[\.]/,"");
					entrada = num;
					}else{
					entrada = input.value.replace(/[^\d\.]*/g,"");
					}
					return entrada;
				}			


	    
	    $('#btnBUSCAR').on('click', function(e) {
		e.preventDefault();

			$('#jt_pago_proveedores').jtable('load', {
			    bsqrut: $('#bsqrut').val()
			}, function(){
				$('#jt_pago_proveedores tbody tr').each(function()
			    {
			    	if($(this).find('td:eq(5)').text()=="PENDIENTE PAGO")
			    	{
			    		$(this).css("background", "#F2DEDE");
			    	}else{

			    	}
			    });
	    		
			});
	    });




	    $("#documentar").dialog({
		autoOpen: false,
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
				$(this).dialog("close");
				$("#cantidad_cheques").val(1);
				totsum = 0;
				$("#jt_pago_proveedores").find(".jtable-selecting-column > input").prop("checked", false);
				$("#jt_pago_proveedores tr").removeClass("jtable-row-selected ui-state-highlight");
				
				$("#voucher").html("");
				
				$( "#c1").datepicker({dateFormat: 'dd-mm-yy'});

				$('.el').remove();

		    },
		    "Documentar": function() {
		    	idEcompra = "";
				var $selectedRows = $('#jt_pago_proveedores').jtable('selectedRows');

				TotalCheques 	= $("#cantidad_cheques").val();
				var cantChe2 = parseInt($("#cantidad_cheques").val()) + parseInt(1);

				$selectedRows.each(function () {
					var record = $(this).data('record');					
					idEcompra+= record.id_ecompra+",";
					IDsuppliers = record.IDsuppliers;
				});


				for(var i=1;i<cantChe2;i++)
				{
						//Cantidad de cuotas y valores de ellas
						
						montoCuota 		= Math.floor(totsum / $("#cantidad_cheques").val());
						ultimo_monto 	= totsum - (Math.floor(totsum / $("#cantidad_cheques").val()) * (parseInt($("#cantidad_cheques").val()) - 1));
						TotalCheques 	= $("#cantidad_cheques").val();
						IDUser 			= <?=$_SESSION['SESS_USER_ID']?>;

						tipo_doc = $("#tipo_documento"+i).val();


						cant_cuot = (parseInt($("#cantidad_cheques").val()) - 1);

						if(cant_cuot == $("#cantidad_cheques").val())
						{
									if(tipo_doc=="Efectivo")
									{

										var parametros = {

											"id_compra" : idEcompra,
											"numero_cuota" : i,
											"monto_cuota" : ultimo_monto,
											"monto_abono" : 0,
											"monto_final" : ultimo_monto,
											"tipo_compromiso" : tipo_doc,
											"estado" : "PENDIENTE PAGO",
											"fecha_pago" : $("#c"+i).val(),
											"id_proveedor" : IDsuppliers,
											"id_usuario"	: IDUser,
											"voucher" : "",
											"id_banco" : ""
										}




										$.ajax({
											  cache: false,
											  type: "POST",
											  url: "./check_proveedores_sql.php?action=documentar",
											  data: parametros,
										      success: function(data){
										      
									          }
										});
									}else
									{



										var parametros1 = {

											"id_compra" : idEcompra,
											"numero_cuota" : i,
											"monto_cuota" : ultimo_monto,
											"monto_abono" : 0,
											"monto_final" : ultimo_monto,
											"tipo_compromiso" : tipo_doc,
											"estado" : "PENDIENTE PAGO",
											"fecha_pago" : $("#c"+i).val(),
											"id_proveedor" : IDsuppliers,
											"id_usuario"	: IDUser,
											"voucher" : $("#v"+i).val(),
											"id_banco" : $("#b"+i).val()


											
										}



										$.ajax({
											  cache: false,
											  type: "POST",
											  url: "./check_proveedores_sql.php?action=documentar",
											  data: parametros1,
										      success: function(data){
										      
									          }
										});
									}
						}else
						{
									if(tipo_doc=="Efectivo")
									{

										var parametros = {

											"id_compra" : idEcompra,
											"numero_cuota" : i,
											"monto_cuota" : montoCuota,
											"monto_abono" : 0,
											"monto_final" : montoCuota,
											"tipo_compromiso" : tipo_doc,
											"estado" : "PENDIENTE PAGO",
											"fecha_pago" : $("#c"+i).val(),
											"id_proveedor" : IDsuppliers,
											"id_usuario"	: IDUser,
											"voucher" : "",
											"id_banco" : ""
										}




										$.ajax({
											  cache: false,
											  type: "POST",
											  url: "./check_proveedores_sql.php?action=documentar",
											  data: parametros,
										      success: function(data){
										      
									          }
										});
									}else
									{



										var parametros1 = {

											"id_compra" : idEcompra,
											"numero_cuota" : i,
											"monto_cuota" : montoCuota,
											"monto_abono" : 0,
											"monto_final" : montoCuota,
											"tipo_compromiso" : tipo_doc,
											"estado" : "PENDIENTE PAGO",
											"fecha_pago" : $("#c"+i).val(),
											"id_proveedor" : IDsuppliers,
											"id_usuario"	: IDUser,
											"voucher" : $("#v"+i).val(),
											"id_banco" : $("#b"+i).val()


											
										}



										$.ajax({
											  cache: false,
											  type: "POST",
											  url: "./check_proveedores_sql.php?action=documentar",
											  data: parametros1,
										      success: function(data){
										      
									          }
										});
									}
						}
						



				}

				





				//codigoVoucher += $("#v"+i).val()+',';

				

				// fechaCompromiso = "";
				// codigoVoucher ="";
				
				// var cantChe2 = parseInt($("#cantidad_cheques").val()) + parseInt(1);
	   //  		for(var i=1;i<cantChe2;i++)
				// {
					
				// 		fechaCompromiso += $("#c"+i).val()+',';
				// 		codigoVoucher += $("#v"+i).val()+',';
						
					
				// }

				// idEcompra = "";
				
				// tipo_compromiso = $("#tipo_documento").val();
				// IDsuppliers = "";
				// 
				


				

				//calcular las cuotas totales

				

				


				
				// $(this).dialog("close");
				// $("#cantidad_cheques").val(1);
				// totsum = 0;
				// window.location = "./check_proveedores.php";
		    }
		}
	    });

	    $("#error").dialog({
		autoOpen: false,
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



	    function cambio()
	    {
	    	$(".tpdocu").on("change", function(){

	    		var mielemento = $(this).attr("id").replace("tipo_documento","");
	    		if($(this).val()=="Efectivo")
	    		{
	    			$("#cheques"+mielemento).html("");
	    			$("#cheques"+mielemento).append('<label>Fecha de Pago Cheque '+mielemento+' : </label><input type="text" class="form-control" id="c'+mielemento+'"/></div>');
	    			$( "#c"+mielemento).datepicker({dateFormat: 'dd-mm-yy'});
	    		}else
	    		{
	    			$("#cheques"+mielemento).html("");
	    			$("#cheques"+mielemento).append('<label>Fecha de Pago Cheque '+mielemento+' : </label><input type="text" class="form-control" id="c'+mielemento+'"/></div><br><div id="voucher"><label>Comprobante '+mielemento+' : </label><input type="text" class="form-control" id="v'+mielemento+'"/></div><br><label>Banco y Cuenta Corriente '+mielemento+': </label>');
	    			$( "#b0" ).clone().appendTo( "#cheques"+mielemento ).css("display", "inline").attr("id", "b"+mielemento);
	    			$( "#c"+mielemento).datepicker({dateFormat: 'dd-mm-yy'});
	    		}

	    	});
	    }
               


	    $("#cantidad_cheques").on("change", function(){

	    	$('#valorCheque').html("");
	    	$('#UvalorCheque').html("");

	    	$('.el').remove();
	    	$('#valorCheque').append(Moneda(Math.floor(totsum / $(this).val()).toString()));

	    	ultimo_cheque = totsum - (Math.floor(totsum / $(this).val()) * (parseInt($(this).val()) -1));

	    	$('#UvalorCheque').append(Moneda(ultimo_cheque.toString()));

	    	

	    	$("#repite1").css("display", "none");	
	    	
	    	
	    	var cantChe = parseInt($(this).val()) + parseInt(1);

	    	for(var i=1;i<cantChe;i++)
	    	{	

	    		$("#contiene").append('<div id="repite'+i+'" class="el"><br><br><label>Compromiso Numero '+i+': </label><br><br><label>Tipo de Compromiso '+i+': </label><select name="tipo_documento" class="form-control tpdocu" id="tipo_documento'+i+'"><option value="Documento">Documento</option><option value="Efectivo">Efectivo</option><option value="Transferencia">Transferencia</option></select><br><div id="cheques'+i+'"></div></div>');
	    			    		
	    	}

	    	cambio();


	    });

	    $( "#c1").datepicker({dateFormat: 'dd-mm-yy'});


	     	 
	    
	    

		

	});
</script>




</body>
</html>