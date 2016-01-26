<?php
require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Gestion interna</title>

    <!-- bootstrap -->
    <script src="../../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <link  href="../../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
	<!-- jquery -->
	<script src="../../scripts/jquery/jquery.js" type="text/javascript"></script>
    <script src="../../scripts/jquery/jquery-ui.js" type="text/javascript"></script>
    <link  href="../../scripts/jquery/themes/<?=$ACTUAL_THEME?>/jquery-ui.css" rel="stylesheet" type="text/css" />
		
    <!-- jtable -->
	<script src="../../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
    <script src="../../scripts/jtable/jquery.jtable.es.js" type="text/javascript"></script>
    <link  href="../../scripts/jtable/themes/<?=$JTABLE_THEME?>" rel="stylesheet" type="text/css" />
    
    <!-- jquery.validationEngine -->
	<!--<script src="../../scripts/jquery/validate/jquery.validationEngine.js" type="text/javascript" ></script>
    <script src="../../scripts/jquery/validate/jquery.validationEngine-es.js" type="text/javascript"></script>
    <link  href="../../scripts/jquery/validate/validationEngine.jquery.css" rel="stylesheet" type="text/css" />-->

    

</head>
<style>

form.jtable-dialog-form {
  width:450px;
}
#btn
{
	cursor: pointer;
}



</style>
<body class="ui-widget">
<h4>Gestion de Plantilla OT</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="85%" cellspacing="2" cellpadding="4">
	    <tbody><tr>
		<td width="40%">
		    <table width="100%">
			<tbody><tr>
			    <td><h5>Buscar</h5></td>
			    <td><input type="text" id="plantillas" name="plantillas" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
			</tr>
		    </tbody></table>
		</td>
		<td width="20%">
		    <table width="100%">
			<tbody><tr>
			    <td style="width: 110px; text-align: right"><h5 >Incluir Inactivos </h5></td>
			    <td style="width: 50px; text-align: center">
				  <input type="checkbox" id="inactivo" name="inactivo" value="1"/></td>
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


 
<div id="jt_plantillaot" style="width: 100%;"></div>

        
	<script type="text/javascript">

		$(document).ready(function () {
		  
		    //Prepare jTable
			$('#jt_plantillaot').jtable({
				jqueryuiTheme: true,
    			title: 'Gesti&oacute;n de Plantillas',
    			paging: true,
    			pageSize: 10,
    			sorting: true,
    			openChildAsAccordion: true, //Enable this line to show child tabes as accordion style
				defaultSorting: 'id_plantillaot ASC',
				selecting: false, //Enable selecting
            	multiselect: false, //Allow multiple selecting
            	selectingCheckboxes: false, //Show checkboxes on first column
            	//selectOnRowClick: true, //Enable this to only select using checkboxes
                toolbar: {
						    items: [{
						        icon: '../../toolbar-icon/ot.png',
						        text: 'Ingresar Nueva Plantilla',
						        click: function () {
						          
                                     window.location = 'plantilla_main.php';
			             			
						        }
						    }]
						},
				actions: {
					listAction:		'plantillasql_sql.php?action=list',
					deleteAction: 	'plantillasql_sql.php?action=delete'
				},
				fields: {
					id_plantillaot: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
                    Detalle: {
				    title: '',
				    width: '2%',
				    sorting: false,
				    edit: false,
				    create: false,
				    display: function (datos) {
					//Create an image that will be used to open child table
					var $img = $('<center><button title="Detalle" class="btn btn-default btn-sm ui-corner-all" type="button" ><span class="glyphicon glyphicon-list"></span></button></center>');
					//Open child table when user clicks the image
					$img.click(function () {
					    
					    //aqui***************
					    
					    $('#jt_plantillaot').jtable('openChildTable',
						    $img.closest('tr'),
						    {
							title: 'Detalle:',
							paging: true,
							pageSize: 10,
							sorting: false,
							defaultSorting: 'id_dplantillaot ASC',
							actions: {
							    listAction: 'plantilladet_sql.php?action=list&IDPerfil='+ datos.record.id_plantillaot,
							},
							fields: {
							    id_plantillaot: {
								type: 'hidden',
								defaultValue: datos.record.id_plantillaot
							    },
							    id_dplantillaot: {
								key: true,
								create: false,
								edit: false,
								list: false
							    },
                                posicion:
                                {
                                title: 'Posici\u00f3n',
                                width: "10%",
                                list: true
                                },
							    Codigo: {
								title: 'Codigo',
								width: '10%',
								create: true,
								edit: true,
								list: true
							    },
							    descripcion: {
								title: 'Descripcion',
								width: '10%',
								create: true,
								edit: true,
								list: true
							    },
							    cantidad: {
								title: 'Cantidad',
								width: '10%',
								create: true,
								edit: false,
								list: true
							    },
								id_almacen:
								{
									title: 'Almacen',
									width: '20%',
									options:'plantilladet_sql.php?action=Descripcion',
									list: true
								}
							}
						    },
						    function (data) { //opened handler
							data.childTable.jtable('load');
							hello = data.childTable;
							return hello;
						    });
					    });
								    //Return image to show on the person row
					    return $img;
					}
				},
                    nombre:
					{
						title: 'Nombre Plantilla',
						width: '20%',
						create: true,
						edit: true,
						list: true

					},
                    descripcion:
                    {
                        title: 'Descripcion Plantilla',
                        width: '20%',
						create: true,
                        edit:true,
                        list: true
                    },
					Edicion: {
						  title: '',
						  width: '1%',
						  sorting: false,
						  edit: false,
						  create: false,
						  display: function (datos) {
						  //Create an image that will be used to open child table
						  var $img = $('<center><button title="Modificar" class="btn btn-default btn-sm ui-corner-all" type="button" ><span class="glyphicon glyphicon-pencil"></span></button></center>');					
							  $img.on("click",function(){
								  
								  window.location="plantilla_main.php?id_plantilla="+datos.record.id_plantillaot;
								  
								  });
						   return $img;
							  }
                    },
		    /*
                    PDF: {
				    title: '',
				    width: '1%',
				    sorting: false,
				    edit: false,
				    create: false,
				    display: function (datos) {
					//Create an image that will be used to open child table
					var $img = $('<center><img src="../../toolbar-icon/pdf.gif" title="Exportar a PDF" /></center>');
                     return $img;
                        }
                    }
                    */
                    
					
					
				},
                //cuando se cierra el dialog
              /*
                 formClosed: function(event, data) {
                        $('#jt_plantillaot').jtable('load');
                 } */

        });
			
				
			//Load person list from server
			$('#jt_plantillaot').jtable('load');
			
			//buscar por clientes
			 $('#btnBUSCAR').on('click',function(e) {
                    e.preventDefault();
                    $('#jt_plantillaot').jtable('load', {
                        plantillas: $('#plantillas').val(),
                        inactivo: $('#inactivo').val()
                    });
        });
			//eliminar
			 // $('#DeleteAllButton').click(function () {
    //         var $selectedRows = $('#PeopleTableContainer').jtable('selectedRows');
    //         $('#PeopleTableContainer').jtable('deleteRows', $selectedRows);
    //     });
		

	

		//Initialize validation logic when a form is created
    
   $("#inicio").datepicker({dateFormat: 'dd-mm-yy'});
   $("#fin").datepicker({dateFormat: 'dd-mm-yy'});
 
 $('#inactivo').on('change', function() { 
    // From the other examples
    if (!this.checked) {
         $('#inactivo').val("1");
    }else
    {
        $('#inactivo').val("2");
    }
});

 		                       
		});
        
        
      
	</script>



</body>
</html>