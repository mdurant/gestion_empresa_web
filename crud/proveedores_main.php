<?php
require_once("../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Maestro de Proveedores</title>
    <!-- bootstrap -->
    <script src="../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <link  href="../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
	<!-- jquery -->
	<script src="../scripts/jquery/jquery.js" type="text/javascript"></script>
    <script src="../scripts/jquery/jquery-ui.js" type="text/javascript"></script>
    <script src="../js/jquery.Rut.js" type="text/javascript"></script>
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

<h4>Maestro de Proveedores</h4>

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

				    <td><input type="text" id="proveedor" name="proveedor" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all"></td>
				</tr>
			    </tbody>
			</table>
		    </td>

		    <td width="20%" align="center">
			<table style="width:100%">
			    <tbody>
				<tr>
				    <td style="width: 170px; text-align: right">
					<h5>Incluir Inactivos</h5>
				    </td>

				    <td style="width: 50px; text-align: center"><input type="checkbox" name="chkinactivo" id="chkinactivo" value="1"></td>
				</tr>
			    </tbody>
			</table>
		    </td>

		    <td width="20%" align="center"><button style="height: 30px; width: 100px" aria-disabled="false" role="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="btnBUSCAR" type="submit"><span class="ui-button-text">Buscar</span></button></td>
		</tr>
	    </tbody>
	</table>
    </form>
</div>

<div style="height: 5px;width: 100%;"></div>

<div id="jt_proveedores" style="width:100%;"></div>

<div id="dlgELIMINAR" title="Eliminar">
    <p>Desea eliminar</p>
</div>


<style>

form.jtable-dialog-form { width:500px; }

</style>        
<script type="text/javascript">
	$(document).ready(function() {

	  $('#jt_proveedores').jtable({
		jqueryuiTheme: true,
		title: 'Listado',
		paging: true,
		pageSize: 10,
		sorting: true,
		defaultSorting: 'Suppliers ASC',
		selecting: true,
		multiselect: true,
		multiSorting: true,
		selectingCheckboxes: true,
		actions: {
		    listAction: 'proveedores_sql.php?action=list',
		    createAction: 'proveedores_sql.php?action=create',
		    updateAction: 'proveedores_sql.php?action=update',
		    deleteAction: 'proveedores_sql.php?action=delete'
		},
		toolbar: {
		    items: [{
			icon: '../toolbar-icon/delete.png',
			text: 'Eliminar',
			click: function() {

			    var $selectedRows = $('#jt_proveedores').jtable('selectedRows');

			    if ($selectedRows.length > 0) {
				$('#dlgELIMINAR').html(" <p>Desea eliminar " + $selectedRows.length + " registros</p>");
				$("#dlgELIMINAR").dialog("open");
			    } else {
				alert("Debe seleccionar registros para eliminar.");
			    }

			}
		    }]
		},
		fields: {
		    IDsuppliers: {
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
			title: 'Proveedor',
			width: '30%',
			list: true
		    },
		    CompanyName: {
			title: 'Nombre Empresa',
			width: '30%',
			list: true
		    },
		    ContactName: {
			title: 'Nombre Contacto',
			width: '60%',
			list: false
		    },
		    PhoneContact: {
			title: 'Teléfono Contacto',
			width: '20%',
			list: false
		    },
		    PhoneCompany: {
			title: 'Teléfono Empresa',
			width: '20%',
			list: true
		    },
		    EmailCompany: {
			title: 'Email Compañia',
			width: '20%',
			list: false
		    },
		    WebCompany: {
			title: 'Sitio Web',
			width: '20%',
			list: false
		    },
		    Address: {
			title: 'Dirección',
			width: '20%',
			list: false
		    },
		    AddressOffice: {
			title: 'Dirección Oficina',
			width: '20%',
			list: false
		    },
		    IDCity: {
			title: 'Comuna',
			width: '20%',
			options: 'proveedores_sql.php?action=comunas',
			list: false
		    },
		    Estado: {
			title: 'Estado',
			width: '30%',
			create: true,
			edit: true,
			options: {
			    'activo': 'activo',
			    'inactivo': 'inactivo'
			},
			list: true
		    }


		},
		formCreated: function(event, data) {
		    $("div[aria-describedby='ui-id-5']").css("top", "0px");
		    $("div[aria-describedby='ui-id-3']").css("top", "0px");
		    $("#ui-id-5, #ui-id-3").css('height', '350px').css('overflow-y', 'scroll').css('overflow-x', 'hidden');
		    $("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary');
		    $("#jtable-edit-form").attr('class', 'form-horizontal');
		    $("form input[type=text], form textarea, form select").attr('class', 'form-control input-sm ui-corner-all');


		    $("#Edit-rut").css('width', '150px');
		    $("#Edit-rut").attr('title', 'Ingrese rut válido');
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

		    	// validar campos

		    	$('#rEdit-rut').Rut({
				  on_error: function(){ alert('Rut incorrecto'); }
				});
		    data.form.find('input[name="RUT"]').addClass('validate[required]');
		    data.form.find('input[name="Suppliers"]').addClass('validate[required]');
		    data.form.find('input[name="CompanyName"]').addClass('validate[required]');
		    data.form.find('input[name="ContactName"]').addClass('validate[required]');
		    
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


	    $('#jt_proveedores').jtable('load');

	    $('#chkinactivo').on('change', function() {

		if (!this.checked) {
		    $('#chkinactivo').val("1");
		} else {
		    $('#chkinactivo').val("2");
		}
	    });

	    $('#btnBUSCAR').on('click', function(e) {
				e.preventDefault();
				$('#jt_proveedores').jtable('load', {
			    proveedor: $('#proveedor').val(),
			    chkinactivo: $('#chkinactivo').val()
				});
	    });

	    $("#Edit-RUT").Rut({
   			format_on: 'keyup'
			});

	    $("#dlgELIMINAR").dialog({
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
		    },
		    "Eliminar": function() {
			var $selectedRows = $('#jt_proveedores').jtable('selectedRows');
			$('#jt_proveedores').jtable('deleteRows', $selectedRows);
			$(this).dialog("close");
		    }
		}
	    });

	});
</script>




</body>
</html>