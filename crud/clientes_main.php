<?php
require_once("../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Maestro de Clientes</title>
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

<h4>Maestro de Clientes</h4>

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

				    <td><input type="text" id="cliente" name="cliente" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all"></td>
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

<div id="jt_clientes" style="width: 100%;"></div>

<div id="dlgELIMINAR" title="Eliminar">
    <p>Desea eliminar</p>
</div>


<style>

form.jtable-dialog-form { width:500px; top:0px}

</style>        
<script type="text/javascript">

	$(document).ready(function() {

	    $('#jt_clientes').jtable({
		jqueryuiTheme: true,
		title: 'Listado General',
		paging: true,
		pageSize: 10,
		sorting: true,
		defaultSorting: 'Cliente ASC',
		selecting: true,
		multiselect: true,
		multiSorting: true,
		selectingCheckboxes: true,
		actions: {
		    listAction: 'clientes_sql.php?action=list',
		    createAction: 'clientes_sql.php?action=create',
		    updateAction: 'clientes_sql.php?action=update',
		    deleteAction: 'clientes_sql.php?action=delete'
		},
		toolbar: {
		    items: [{
			icon: '../toolbar-icon/delete.png',
			text: 'Eliminar',
			click: function() {

			    var $selectedRows = $('#jt_clientes').jtable('selectedRows');

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
		    IDCliente: {
			key: true,
			create: false,
			edit: false,
			list: false
		    },
		    rut: {
			title: 'Rut',
			width: '10%',
			list: true

		    },
		    Cliente: {
			title: 'Cliente',
			width: '30%',
			list: true
		    },
		    Empresa: {
			title: 'Empresa',
			width: '30%',
			list: true
		    },
		    DomicilioEmpresa: {
			title: 'Domicilio Empresa',
			width: '60%',
			list: false
		    },
		    DomicilioDespacho: {
			title: 'Domicilio Despacho',
			width: '20%',
			list: false
		    },
		    Telefono: {
			title: 'Telefono',
			width: '20%',
			list: false
		    },
		    Web: {
			title: 'Web',
			width: '20%',
			list: false
		    },
		    EmailContacto: {
			title: 'Email Contacto',
			width: '20%',
			list: false
		    },
		    TelefonoContacto: {
			title: 'Telefono Contacto',
			width: '20%',
			list: false
		    },
		    Contacto: {
			title: 'Contacto',
			width: '20%',
			list: true
		    },
		    EmailEmpresa: {
			title: 'Email Empresa',
			width: '20%',
			list: false
		    },
		    Giro: {
			title: 'Giro',
			width: '20%',
			list: false,
			type: 'textarea'
		    },
		    TwitterContacto: {
			title: 'Twitter Contacto',
			width: '20%',
			list: false
		    },
		    IDComuna: {
			title: 'Comuna',
			width: '35%',
			options: 'clientes_sql.php?action=comunas',
			list: true
		    },
		    IDFormaPago: {
			title: 'Forma Pago',
			width: '20%',
			options: 'clientes_sql.php?action=FormaPago',
			list: false
		    },
		    Estado: {
			title: 'Estado',
			width: '30%',
			create: false,
			edit: true,
			options: {
			    'activo': 'Activo',
			    'inactivo': 'Inactivo'
			},
			list: true
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

		}
	    });


	    $('#jt_clientes').jtable('load');


	    $('#chkinactivo').on('change', function() {

		if (!this.checked) {
		    $('#chkinactivo').val("1");
		} else {
		    $('#chkinactivo').val("2");
		}
	    });

	    $('#btnBUSCAR').on('click', function(e) {
		e.preventDefault();

		$('#jt_clientes').jtable('load', {
		    cliente: $('#cliente').val(),
		    chkinactivo: $('#chkinactivo').val()
		})
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
			var $selectedRows = $('#jt_clientes').jtable('selectedRows');
			$('#jt_clientes').jtable('deleteRows', $selectedRows);
			$(this).dialog("close");
		    }
		}
	    });

	});
</script>




</body>
</html>