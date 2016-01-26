<?php
require_once("../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Proyectos</title>

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
<style>

</style>
<body class="ui-widget">

<h4>Gesti&#243;n de Proyectos</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="65%" cellspacing="2" cellpadding="4">
	    <tbody><tr>
		<td width="60%">
		    <table width="100%">
			<tbody><tr>
			    <td><h5 style="width:30px">Buscar </h5></td>
			    <td><input type="text" id="proyecto" name="proyecto" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
			</tr>
		    </tbody></table>
		    
		</td>
		<td width="20%" align="center">
		<table style="width: 130px;">
		<tbody>
		<tr>
		<td>
		<h5>Incluir Inactivos</h5>
		</td>
		<td>
		<input type="checkbox" style="vertical-align: middle;" value="1" name="chkinactivo" id="chkinactivo"/>
		</td>
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

		</button></td>
	    </tr>
	</tbody>
    </table>
    </form>
</div>
 <div style="height: 5px;width: 100%;"></div>

<div id="jt_proyectos" style="width: 100%;"></div>
        
    <script type="text/javascript">
		$(document).ready(function() {
		    //Prepare jTable
		    $('#jt_proyectos').jtable({
			jqueryuiTheme: true,
			title: 'Listado',
			paging: true,
			pageSize: 10,
			sorting: true,
			defaultSorting: 'nombre_proyecto ASC',
			selecting: true,
			//Enable selecting
			multiselect: true,
			//Allow multiple selecting
			multiSorting: true,
			selectingCheckboxes: true,
			//Show checkboxes on first column
			//selectOnRowClick: true, //Enable this to only select using checkboxes
			actions: {
			    listAction: 'proyectos_sql.php?action=list',
			    createAction: 'proyectos_sql.php?action=create',
			    updateAction: 'proyectos_sql.php?action=update',
			    deleteAction: 'proyectos_sql.php?action=delete'
			},
			toolbar: {
			    hoverAnimation: true,
			    //Enable/disable small animation on mouse hover to a toolbar item.
			    hoverAnimationDuration: 20,
			    //Duration of the hover animation.
			    hoverAnimationEasing: undefined,
			    //Easing of the hover animation. Uses jQuery's default animation ('swing') if set to undefined.
			    items: [{
				icon: '../toolbar-icon/delete.png',
				text: 'Eliminar',
				click: function() {

				    var $selectedRows = $('#jt_proyectos').jtable('selectedRows');
				    $('#jt_proyectos').jtable('deleteRows', $selectedRows);

				}
			    }]
			},
			fields: {
			    id_proyecto: {
				key: true,
				create: false,
				edit: false,
				list: false
			    },
			    nombre_proyecto: {
				title: 'Proyecto',
				width: '25%'
			    },
			    id_cliente: {
				title: 'Cliente',
				width: '20%',
				options: 'proyectos_sql.php?action=clientes',
				list: true
			    },
			    fecha_inicio:{
				title:'Fecha Inicio',
				width:'15%',
				type:'date',
				displayFormat:'dd-mm-yy',
	    			list: true,
				inputClass: 'validate[required,custom[date]]'
			    },
			    
			    fecha_compromiso:{
				title:'Fecha Compromiso',
				width:'15%',
				type:'date',
				displayFormat:'dd-mm-yy',
	    			list: true
			    },
			    Estado:{
				title:'Estado',
				width:'15%',
				create:'false',
				edit:'true',
				list: true,
				options:{
				    'activo': 'Activo',
				    'inactivo': 'Inactivo'
				}
				
				
				
			    }
			    

			},
			formCreated: function(event, data) {
			    $("div[aria-describedby='ui-id-5']").css("top", "0px");
			    $("div[aria-describedby='ui-id-3']").css("top", "0px");
			    $("#ui-id-5, #ui-id-3").css('height', '250px').css('overflow-y', 'scroll').css('overflow-x', 'hidden');
			    $("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary');
			    $("#jtable-edit-form").attr('class', 'form-horizontal');
			    $("select[name=id_cliente]").attr("class", "form-control input-sm ui-corner-all");
			    $("input[type=text], textarea").attr('class', 'form-control input-sm ui-corner-all');
			    data.form.find('input[name="nombre_proyecto"]').addClass('validate[required]');
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


		    //Load person list from server
		    $('#jt_proyectos').jtable('load');
		    //Re-load records when user click 'load records' button.
		    $('#btnBUSCAR').click(function(e) {
			e.preventDefault();
			$('#jt_proyectos').jtable('load', {
			    proyecto: $('#proyecto').val(),
			    inactivo: $('#chkinactivo').val()
			    
			});
		    });
		    //eliminar
		    $('#DeleteAllButton').click(function() {
			var $selectedRows = $('#jt_proyectos').jtable('selectedRows');
			$('#jt_proyectos').jtable('deleteRows', $selectedRows);
		    });
		    
		    $('#chkinactivo').on('change', function() {
		    // From the other examples
		    if (!this.checked) {
		      $('#chkinactivo').val("1");
		    } else {
		      $('#chkinactivo').val("2");
		    }
		  });
		    
		    

		});
    </script>
</body>
</html>
