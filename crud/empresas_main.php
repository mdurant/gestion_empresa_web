<?php
require_once("../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Maestro de Empresas</title>

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

<h4>Maestro de Empresas</h4>

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

				    <td><input type="text" id="empresa" name="empresa" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all"></td>
				</tr>
			    </tbody>
			</table>
		    </td>

		    <td width="20%" align="center">
			<table style="width:130px">
			    <tbody>
				<tr>
				    <td>
					<h5>Incluir Inactivos</h5>
				    </td>

				    <td><input type="checkbox" style="vertical-align: middle;" value="1" name="chkinactivo" id="chkinactivo"></td>
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

<div id="jt_empresas" style="width: 100%;"></div>

<div id="dlgELIMINAR" title="Eliminar"><p>Desea eliminar</p></div>

<style>

form.jtable-dialog-form { width:500px; }

</style>        
<script type="text/javascript">

	$(document).ready(function() {

	    $('#jt_empresas').jtable({
		jqueryuiTheme: true,
		title: 'Listado',
		paging: true,
		pageSize: 10,
		sorting: true,
		defaultSorting: 'RazonSocial ASC',
		selecting: true,
		multiselect: true,
		multiSorting: true,
		selectingCheckboxes: true,
		actions: {
		    listAction: 'empresas_sql.php?action=list',
		    createAction: 'empresas_sql.php?action=create',
		    updateAction: 'empresas_sql.php?action=update',
		    deleteAction: 'empresas_sql.php?action=delete'
		},
		toolbar: {
		    items: [{
			icon: '../toolbar-icon/delete.png',
			text: 'Eliminar',
			click: function() {

			    var $selectedRows = $('#jt_empresas').jtable('selectedRows');

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
		    IDEmpresa: {
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
		    RazonSocial: {
			title: 'Razon Social',
			width: '30%',
			list: true
		    },
		    Giro: {
			title: 'Giro',
			width: '30%',
			type: 'textarea',
			list: true
		    },
		    Domicilio: {
			title: 'Domicilio',
			width: '60%',
			list: true
		    },
		    IDcomuna: {
			title: 'Comuna',
			width: '20%',
			options: 'empresas_sql.php?action=comunas',
			list: true
		    },
		    Telefono1: {
			title: 'Telefono 1',
			width: '20%',
			list: true
		    },
		    Telefono2: {
			title: 'Telefono 2',
			width: '20%',
			list: false
		    },
		    EmailEmpresa: {
			title: 'Email Empresa',
			width: '20%',
			list: false
		    },
		    WebEmpresa: {
			title: 'Web',
			width: '20%',
			list: false
		    },
		    RUT_Representante: {
			title: 'RUT Rep.',
			width: '20%',
			list: false
		    },
		    Representante: {
			title: 'Representante',
			width: '20%',
			list: false
		    },
		    EmailRepresentante: {
			title: 'Email Representante',
			width: '20%',
			list: false
		    },
		    Descripcion: {
			title: 'Descripcion',
			width: '20%',
			list: false,
			type: 'textarea'
		    },
		    Estado: {
			title: 'Estado',
			width: '30%',
			create: true,
			edit: true,
			options: {
			    'activo': 'Activo',
			    'inactivo': 'Inactivo'
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
		    $("input[type=text], textarea").attr('class', 'form-control input-sm ui-corner-all');
		    $("select[name=Estado]").attr("class", "form-control input-sm ui-corner-all");
		    $("select[name=IDcomuna]").attr("class", "form-control input-sm ui-corner-all");
		    $("#Edit-RUT").css('width', '150px');
		    $("#Edit-RUT").attr('title', 'Ingrese rut valido');

		    $("#Edit-RazonSocial").css('width', '250px');
		    $("#Edit-RazonSocial").attr('title', 'Ingrese razon social');


		}
	    });


	    $('#jt_empresas').jtable('load');


	    $('#chkinactivo').on('change', function() {

		if (!this.checked) {
		    $('#chkinactivo').val("1");
		} else {
		    $('#chkinactivo').val("2");
		}
	    });

	    $('#btnBUSCAR').on('click', function(e) {
		e.preventDefault();

		$('#jt_empresas').jtable('load', {
		    empresa: $('#empresa').val(),
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
			var $selectedRows = $('#jt_empresas').jtable('selectedRows');
			$('#jt_empresas').jtable('deleteRows', $selectedRows);
			$(this).dialog("close");
		    }
		}
	    });

	});
</script>




</body>
</html>