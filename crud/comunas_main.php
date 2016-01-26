<?php
require_once("../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Comunas</title>

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

<h4>Comunas</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="65%" cellspacing="2" cellpadding="4">
	    <tbody><tr>
		<td width="60%">
		    <table width="100%">
			<tbody><tr>
			    <td><h5 style="width:30px">Buscar </h5></td>
			    <td><input type="text" id="name" name="name" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
			</tr>
		    </tbody></table>
		    
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

<div id="PeopleTableContainer" style="width: 100%;"></div>
        
    <script type="text/javascript">
		$(document).ready(function() {
		    //Prepare jTable
		    $('#PeopleTableContainer').jtable({
			jqueryuiTheme: true,
			title: 'Listado',
			paging: true,
			pageSize: 10,
			sorting: true,
			defaultSorting: 'Comuna ASC',
			selecting: true,
			//Enable selecting
			multiselect: true,
			//Allow multiple selecting
			multiSorting: true,
			selectingCheckboxes: true,
			//Show checkboxes on first column
			//selectOnRowClick: true, //Enable this to only select using checkboxes
			actions: {
			    listAction: 'comunas_sql.php?action=list',
			    createAction: 'comunas_sql.php?action=create',
			    updateAction: 'comunas_sql.php?action=update',
			    deleteAction: 'comunas_sql.php?action=delete'
			},
			toolbar: {
			    hoverAnimation: true,
			    //Enable/disable small animation on mouse hover to a toolbar item.
			    hoverAnimationDuration: 60,
			    //Duration of the hover animation.
			    hoverAnimationEasing: undefined,
			    //Easing of the hover animation. Uses jQuery's default animation ('swing') if set to undefined.
			    items: [{
				icon: '../toolbar-icon/delete.png',
				text: 'Eliminar',
				click: function() {

				    var $selectedRows = $('#PeopleTableContainer').jtable('selectedRows');
				    $('#PeopleTableContainer').jtable('deleteRows', $selectedRows);

				}
			    }]
			},
			fields: {
			    IDComuna: {
				key: true,
				create: false,
				edit: false,
				list: false
			    },
			    Comuna: {
				title: 'Comuna',
				width: '20%'
			    },
			    IDProvincia: {
				title: 'Provincia',
				width: '20%',
				options: 'comunas_sql.php?action=provincias',
				list: true
			    }

			},
			formCreated: function(event, data) {
			    $("div[aria-describedby='ui-id-5']").css("top", "0px");
			    $("div[aria-describedby='ui-id-3']").css("top", "0px");
			    $("#ui-id-5, #ui-id-3").css('height', '250px').css('overflow-y', 'scroll').css('overflow-x', 'hidden');
			    $("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary');
			    $("#jtable-edit-form").attr('class', 'form-horizontal');
			    $("select[name=IDProvincia]").attr("class", "form-control input-sm ui-corner-all");
			    $("input[type=text], textarea").attr('class', 'form-control input-sm ui-corner-all');
			    data.form.find('input[name="Comuna"]').addClass('validate[required]');
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
		    $('#PeopleTableContainer').jtable('load');
		    //Re-load records when user click 'load records' button.
		    $('#btnBUSCAR').click(function(e) {
			e.preventDefault();
			$('#PeopleTableContainer').jtable('load', {
			    name: $('#name').val()
			});
		    });
		    //eliminar
		    $('#DeleteAllButton').click(function() {
			var $selectedRows = $('#PeopleTableContainer').jtable('selectedRows');
			$('#PeopleTableContainer').jtable('deleteRows', $selectedRows);
		    });

		});
    </script>
</body>
</html>
