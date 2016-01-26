<?php
	
require_once("../validatesession_html.php");





$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Usuarios</title>

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

<h4>Maestro de Usuarios</h4>

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

				    <td><input type="text" id="nombreusuario" name="nombreusuario" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all"></td>
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

<div id="jt_usuarios" style="width: 100%;"></div>

<div style="height: 5px;width: 100%;"></div>
<div style="width: 100%;">
	<table  class="jtable ui-widget-content" width="100%">
		<tbody >
			<tr id="tr_perfiles"></tr>
		</tbody>
	</table>
</div>


        
<script type="text/javascript">
	$(document).ready(function() {
	    //Prepare jTable
	    $('#jt_usuarios').jtable({
			jqueryuiTheme: true,
			title: 'Listado',
			paging: true,
			pageSize: 10,
			sorting: true,
			openChildAsAccordion: true,
			//Enable this line to show child tabes as accordion style
			defaultSorting: 'IDUser ASC',
			selecting: true,
			//Enable selecting
			multiselect: false,
			//Allow multiple selecting
			selectingCheckboxes: false,
			//Show checkboxes on first column
			//selectOnRowClick: true, //Enable this to only select using checkboxes
		/*toolbar: {
							items: [{
							icon: '../toolbar-icon/delete.png',
							text: 'Eliminar',
							click: function () {
									  
									var $selectedRows = $('#jt_usuarios').jtable('selectedRows');
							  
									 if ($selectedRows.length > 0) {
										 $('#dialog').html(" <p>Desea eliminar "+$selectedRows.length+" registros</p>");
										 $( "#dialog" ).dialog( "open" );
									 }
									 else
									 {
									 alert("Debe seleccionar registros para eliminar.");
				 
									 }
									
							}
							}]
						},*/
			actions: {
				listAction: 'usuarios_sql.php?action=list',
				createAction: 'usuarios_sql.php?action=create',
				updateAction: 'usuarios_sql.php?action=update',
				deleteAction: 'usuarios_sql.php?action=delete'
			},
			fields: {
				IDUser: {
				key: true,
				create: false,
				edit: false,
				list: false
	
				},
				Username: {
				title: 'Usuario',
				width: '30%',
				sorting: false,
				edit: true,
				create: true,
	
	
				},
				Email: {
				title: 'Email',
				width: '20%',
				create: true,
				edit: true,
				list: true,
	
				},
				Name: {
				title: 'Nombre',
				width: '30%',
				create: true,
	
				edit: true,
				list: true
	
				},
				Estado: {
					title: 'Estado',
					width: '10%',
					create: true,
					options: {
						"activo": "activo",
						"inactivo": "inactivo"
					},
					edit: true,
					list: true
				}
	
			},
			
			recordsLoaded: function(event, data) {
				
			},
			
			formCreated: function(event, data) {
				//$("div[aria-describedby='ui-id-5']").css("top", "0px");
				//$("div[aria-describedby='ui-id-3']").css("top", "0px");
				
				$(".ui-dialog").css("top", "0px");
				
				
				$("#ui-id-5, #ui-id-3").css('height', '300px').css('overflow-y', 'scroll').css('overflow-x', 'hidden');
				$("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary');
				$("#jtable-edit-form").attr('class', 'form-horizontal');
				$("form input, form select").attr('class', 'form-control input-sm ui-corner-all');
	
			},
			selectionChanged: function(event, data) {
	
					//Get all selected rows
					
					
					var record;
					var $selectedRows = $(this).jtable('selectedRows');
					
	
					if ($selectedRows.length > 0) {
						record = $selectedRows.data('record');
						
						$('#jt_usuarios').jtable('openChildTable', $("#tr_perfiles"), {
							title: 'Usuario: ' + record.Username,
							paging: true,
							tableId: 'jt_usuarios_perfiles',
							pageSize: 10,
							sorting: true,
							selecting: true,
							multiselect: false,
							showCloseButton: false,
							defaultSorting: 'IDModulo ASC',
							actions: {
								listAction: 'usuariosperfiles_sql.php?action=list&IDUsuario=' + record.IDUser,
								deleteAction: 'usuariosperfiles_sql.php?action=delete',
								updateAction: 'usuariosperfiles_sql.php?action=update',
								createAction: 'usuariosperfiles_sql.php?action=create',
							},
							fields: {
							IDUsuariosPerfil: {
								key: true,
								create: false,
								edit: false,
								list: false
							},
							IDUsuario: {
								type: 'hidden',
								defaultValue: record.IDUser
							},
							IDPerfil: {
								title: 'Perfil',
								width: '30%',
								create: true,
								options: 'usuariosperfiles_sql.php?action=perfiles',
								edit: true,
								list: true
		
							},
							sucursal: {
								title: 'Sucursal',
								width: '30%',
								create: false,
								edit: false,
								list: true
							},
							Password: {
								title: 'Password',
								width: '30%',
								create: true,
								edit: true,
								list: false,
								type: 'password'
							}
		
							},
	
							formCreated: function(event, data) {
		
								$(".ui-dialog").css("top", "0px");
								$("#ui-id-5, #ui-id-3").css('height', '300px').css('overflow-y', 'scroll').css('overflow-x', 'hidden');
								$("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary');
								$("form input, form select").attr('class', 'form-control input-sm ui-corner-all');
							
							
		
							}
						},
						function(data) { //opened handler
							data.childTable.jtable('load');
						});
						
					} else {
						
						$('#jt_usuarios_perfiles').parent().parent().css('display','none');
						
						return;
					}			
				
				
	
			   
			
			}
	    },
		function(data) { //opened handler
						console.log(data);
		});


	    //Load person list from server
	    $('#jt_usuarios').jtable('load');




	    //buscar por clientes
	    $('#btnBUSCAR').on('click', function(e) {
		e.preventDefault();
		$('#jt_usuarios').jtable('load', {
		    nombreusuario: $('#nombreusuario').val(),
		    inactivo: $('#chkinactivo').val()
		});
	    });



	    //Initialize validation logic when a form is created

		
		
		






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