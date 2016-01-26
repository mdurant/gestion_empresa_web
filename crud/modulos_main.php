<?php
require_once("../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Modulos</title>

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

<h4>Maestro de Modulos</h4>

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

				    <td><input type="text" id="modulo" name="modulo" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all"></td>
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

<div id="jt_modulos" style="width: 100%;"></div>

<div id="dlgELIMINAR" title="Eliminar">
    <p>Desea eliminar</p>
</div>

       
<script type="text/javascript">
	$(document).ready(function() {

		$('#jt_modulos').jtable({
			jqueryuiTheme: true,
			title: 'Listado',
			paging: true,
			pageSize: 10,
			sorting: true,
			defaultSorting: 'modulo ASC',
			selecting: true,
			multiselect: false,
			multiSorting: true,
			selectingCheckboxes: false,
			actions: {
				listAction: 'modulos_sql.php?action=list',
				createAction: 'modulos_sql.php?action=create',
				updateAction: 'modulos_sql.php?action=update',
				deleteAction: 'modulos_sql.php?action=delete'
			},
			toolbar: {
				items: [{
					icon: '../toolbar-icon/delete.png',
					text: 'Eliminar',
					click: function() {

						var $selectedRows = $('#jt_modulos').jtable('selectedRows');

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
				IDmodulo: {
					key: true,
					create: false,
					edit: false,
					list: false
				},
				modulo: {
					title: 'Modulo',
					width: '10%',
					list: true

				},
				descripcion: {
					title: 'Descripci\u00f3n',
					width: '30%',
					type: 'textarea',
					list: true
				}


			},
			formCreated: function(event, data) {


				$("div[aria-describedby='ui-id-5']").css("top", "0px");
				$("div[aria-describedby='ui-id-3']").css("top", "0px");

				$("#ui-id-5, #ui-id-3").css('height', '200px').css('overflow-y', 'scroll').css('overflow-x', 'hidden');
				$("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary');
				$("#jtable-edit-form").attr('class', 'form-horizontal');
				$("input[type=text], textarea").attr('class', 'form-control input-sm ui-corner-all');
				$("#Edit-modulo").css('width', '200px');
				$("#Edit-modulo").attr('title', '');
				$("#Edit-descripcion").css('width', '350px');


			}
		});


		$('#jt_modulos').jtable('load');

		$('#btnBUSCAR').on('click', function(e) {
			e.preventDefault();
			$('#jt_modulos').jtable('load', {
				modulo: $('#modulo').val()
			});
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
					var $selectedRows = $('#jt_modulos').jtable('selectedRows');
					$('#jt_modulos').jtable('deleteRows', $selectedRows);
					$(this).dialog("close");
				}
			}
		});

	});
</script>




</body>
</html>