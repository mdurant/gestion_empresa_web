<?php
require_once("../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Gestion interna</title>
    
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
	<!--<script src="../scripts/jtable/extensions/jquery.jtable.editinline.js" type="text/javascript"></script>
	<script src="../scripts/jtable/extensions/jquery.jtable.toolbarsearch.js" type="text/javascript"></script>-->
	<link  href="../scripts/jtable/themes/<?=$JTABLE_THEME?>" rel="stylesheet" type="text/css" />
    
    <!-- jquery.validationEngine -->
    <!--<script src="../../scripts/jquery/validate/jquery.validationEngine.js" type="text/javascript" ></script>
    <script src="../../scripts/jquery/validate/jquery.validationEngine-es.js" type="text/javascript"></script>
    <link  href="../../scripts/jquery/validate/validationEngine.jquery.css" rel="stylesheet" type="text/css" />-->


</head>
  
<body class="ui-widget">

<h4>Perfiles</h4>

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

				    <td><input type="text" id="nombreperfil" name="nombreperfil" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all"></td>
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

		    <td width="20%" align="center">
				<button style="height: 30px; width: 100px" aria-disabled="false" role="button"
												   class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="btnBUSCAR" type="submit">
											<span class="ui-button-text">Buscar</span>
			</button>
			</td>
		</tr>
	    </tbody>
	</table>
    </form>
</div>

<div style="height: 5px;width: 100%;"></div>

<div id="jt_perfil" style="width: 100%;"></div>


<div style="height: 5px;width: 100%;"></div>
<div id="divPERMISOBUSCAR" class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px; display: none">
    <form style="margin: 0px">
	<table width="40%" cellspacing="2" cellpadding="4">
	    <tbody>
		<tr>
		    <td width="40%">
			<table width="100%">
			    <tbody>
				<tr>
				    <td>
					<h5 style="width:25px">Buscar </h5>
				    </td>

				    <td><input type="text" id="txtPERMISOBUSCAR" name="txtPERMISOBUSCAR" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all"></td>
				</tr>
			    </tbody>
			</table>
		    </td>
		    <td width="20%" align="center">
				<button style="height: 30px; width: 100px" aria-disabled="false" role="button"
												   class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="btnPERMISOBUSCAR" type="submit">
											<span class="ui-button-text">Buscar</span></button>
			</td>
		</tr>
	    </tbody>
	</table>
    </form>
</div>

<div style="width: 100%;">
	<table class="jtable ui-widget-content" width="100%">
		<tbody>
			<tr id="tr_permisos">
				
			</tr>
		</tbody>
	</table>
</div>

        
<script type="text/javascript">

	$(document).ready(function() {
	    //Prepare jTable
	    $('#jt_perfil').jtable({
		jqueryuiTheme: true,
		title: 'Listado',
		paging: true,
		pageSize: 10,
		sorting: true,
		openChildAsAccordion: true,
		//Enable this line to show child tabes as accordion style
		defaultSorting: 'IDPerfil ASC',
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
							  
						    var $selectedRows = $('#jt_perfil').jtable('selectedRows');
				      
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
		    listAction: 'perfiles_sql.php?action=list',
		    createAction: 'perfiles_sql.php?action=create',
		    updateAction: 'perfiles_sql.php?action=update',
		    deleteAction: 'perfiles_sql.php?action=delete'
		},
		fields: {
		    IDPerfil: {
			key: true,
			create: false,
			edit: false,
			list: false

		    },
		    Nombre: {
			title: 'Nombre',
			width: '20%',
			create: true,
			edit: true,
			list: true,

		    },
		    IDSucursal: {
			title: 'Sucursal',
			width: '20%',
			create: true,
			options: function (data) {
				data.clearCache();
				return 'perfiles_sql.php?action=sucursal';
			},
			edit: true,
			list: true

		    },
		    Estado: {
			title: 'Estado',
			width: '20%',
			create: true,
			options: {
				"activo": "activo",
			    "inactivo": "inactivo"
			    
			},
			edit: true,
			list: true
		    }

		},
		formCreated: function(event, data) {

		    $(".ui-dialog").css("top", "0px");
		    $("#ui-id-5, #ui-id-3").css('height', '200px').css('overflow-y', 'scroll').css('overflow-x', 'hidden');
		    $("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary');
		    $("#jtable-edit-form").attr('class', 'form-horizontal');
		    $("form input, form select").attr('class', 'form-control input-sm ui-corner-all');
			
		},
		selectionChanged: function(event, data) {

				
				var record;
                var $selectedRows = $(this).jtable('selectedRows');
				
				//alert($selectedRows.length);
				
                if ($selectedRows.length > 0) {
					
					
					record = $selectedRows.data('record');
					
					$('#jt_perfil').jtable('openChildTable', $("#tr_permisos"), {
						title: 'Perfil: ' + record.Nombre,
						tableId: 'jt_perfil_permisos',
						paging: true,
						pageSize: 10,
						sorting: true,
						selecting: true,
						showCloseButton: false,
						//editinline:{enable:true},
						//toolbarsearch:true,
						multiselect: false,
						defaultSorting: 'IDModulo ASC',
						actions: {
							listAction: 'perfilespermisos_sql.php?action=list&IDPerfil=' + record.IDPerfil,
							deleteAction: 'perfilespermisos_sql.php?action=delete',
							updateAction: 'perfilespermisos_sql.php?action=update',
							createAction: 'perfilespermisos_sql.php?action=create',
						},
						fields: {
							IDPerfil: {
								type: 'hidden',
								defaultValue: record.IDPerfil
							},
							IDPerfilesPermisos: {
								key: true,
								create: false,
								edit: false,
								list: false
							},
							IDModulo: {
								title: 'Modulo',
								width: '30%',
								create: true,
								options: function (data) {
									data.clearCache();
									return 'perfilespermisos_sql.php?action=modulos&IDPerfil=' + record.IDPerfil;
								},
								edit: true,
								list: false
							},
							modulo: {
								title: 'Modulo',
								width: '30%',
								create: false,
								edit: false,
								list: true
							},
							Item: {
								title: 'Item',
								width: '30%',
								create: true,
								edit: true,
								list: true
							},
							Valor: {
								title: 'Valor',
								width: '20%',
								type: 'radiobutton',
								options: [
									{ Value: '0', DisplayText: 'NO' },
									{ Value: '1', DisplayText: 'SI' }
								],
								create: true,
								edit: true,
								list: true
							}
						},
						formSubmitting: function(event, data) {
							
							
							
						},
						formCreated: function(event, data) {
	
							$(".ui-dialog").css("top", "0px");
							$("#ui-id-5, #ui-id-3").css('height', '300px').css('overflow-y', 'scroll').css('overflow-x', 'hidden');
							$("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary');
							$("form input, form select").attr('class', 'form-control input-sm ui-corner-all');
							$("form input[type=radio]").attr('class', '');
							
							//$(this).load();
	
						}
					},
					function(data) { //opened handler
						$('#divPERMISOBUSCAR').css('display','block');
						
						data.childTable.jtable('load');
						//$(".jtable-close-button").remove();
						
					});					
					
					
					
					

                } else {
					
					$('#jt_perfil_permisos').parent().parent().css('display','none');
					//$("#tr_permisos").parent().find(".jtable-child-row").css('display','none');
					$('#divPERMISOBUSCAR').css('display','none');
					
					return;
                }
				
				
				
		}
	    });


	    //Load person list from server
	    $('#jt_perfil').jtable('load');





	    $('#btnBUSCAR').on('click', function(e) {
			e.preventDefault();
			$('#jt_perfil').jtable('load', {
				nombreperfil: $('#nombreperfil').val(),
				inactivo: $('#chkinactivo').val()
			});
	    });

	    $('#btnPERMISOBUSCAR').on('click', function(e) {
			e.preventDefault();
			$('#jt_perfil_permisos').parent().parent().jtable('load', {
				txtPERMISOBUSCAR: $('#txtPERMISOBUSCAR').val()
			});
	    });

	    //Initialize validation logic when a form is created

	    $("#dialog").dialog({
		autoOpen: false,
		show: {
		    effect: "fade",
		    duration: 200
		},
		hide: {
		    effect: "fade",
		    duration: 200
		},
		modal: true,
		buttons: {
		    "Cancelar": function() {
			$(this).dialog("close");
		    },
		    "Buscar": function() {
			hello.jtable('load', {
			    Item: $('#bsq_child').val()
			});
			$("#dialog").dialog("close");
			$("#bsq_child").val("");
		    }
		}
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

<div id="dialog" title="Busqueda">
    <br />
  <center><label>Item</label>
  <input type="text" name="bsq_child" id="bsq_child" /></center>
</div>

</body>
</html>