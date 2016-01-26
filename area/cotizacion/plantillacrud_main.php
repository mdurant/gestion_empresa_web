<?php
require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

if (empty($_SESSION["COT_FECHABUSQUEDA1"])) { $_SESSION["COT_FECHABUSQUEDA1"] = date("d-m-Y");  }
    if (empty($_SESSION["COT_FECHABUSQUEDA2"])) { $_SESSION["COT_FECHABUSQUEDA2"] = date("d-m-Y");  }

$IDEmpresas = $_GET['IDEmpresa'];



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
    <script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript"></script>
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

<h4>Plantilla cotizaciones</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="85%" cellspacing="2" cellpadding="4">
	    <tbody><tr>
		<td width="40%">
		    <table width="100%">
			<tbody><tr>
			    <td><h5>Buscar</h5></td>
			    <td><input type="text" id="nombre" name="nombre" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
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
<div id="jt_plantilla" style="width: 100%;"></div>

        
	<script type="text/javascript">
	      
		$(document).ready(function () {
		  
             var msg = {
				deleteConfirmation: 'Realmente desea Eliminar esta Plantilla',
				deleteText: 'Eliminar',
				save: 'Guardar',
				editRecord: 'Editar Plantilla Cotizacion',
            };
		    //Prepare jTable
			$('#jt_plantilla').jtable({
                messages: msg,
				jqueryuiTheme: true,
    			title: 'Listado',
    			paging: true,
    			pageSize: 10,
    			sorting: true,
    			openChildAsAccordion: true, //Enable this line to show child tabes as accordion style
				defaultSorting: 'id_eplantilla_cot ASC',
				selecting: true, //Enable selecting
            	multiselect: false, //Allow multiple selecting
            	selectingCheckboxes: false, //Show checkboxes on first column
            	//selectOnRowClick: true, //Enable this to only select using checkboxes
                toolbar: {
						    items: [{
						        icon: '../../toolbar-icon/ot.png',
						        text: 'Crear Nueva Plantilla',
						        click: function () {
						          
                                     window.location = 'plantilla_main.php';
			             			
						        }
						    }]
						},
				actions: {
					listAction:	'plantillasql_sql.php?action=list',
					deleteAction:'plantillasql_sql.php?action=delete'
				},
				fields: {
					id_eplantilla_cot: {
						key: true,
						create: false,
						edit: false,
						list: false,
					},
					llave: {
						title: '',
						width: '2%',
						sorting: false,
						edit: false,
						create: false,
						display: function (datos) {
						//Create an image that will be used to open child table
						var $img = $('<img src="../../toolbar-icon/candado.png" title="Editar Permisos" />');
						//Open child table when user clicks the image
						$img.click(function () {
							
							//aqui***************
							
							$('#jt_plantilla').jtable('openChildTable',
								$img.closest('tr'),
								{
								title: 'Detalle de Cotizaci&oacute;n:',
								paging: true,
								pageSize: 10,
								sorting: false,
								defaultSorting: 'id_dplantilla_cot ASC',
								actions: {
									listAction: 'plantilladet_sql.php?action=list&IDPerfil='+ datos.record.id_eplantilla_cot,
								},
								fields: {
									id_eplantilla_cot: {
									type: 'hidden',
									defaultValue: datos.record.id_eplantilla_cot
									},
									id_dplantilla_cot: {
									key: true,
									create: false,
									edit: false,
									list: false
									},
									codigo: {
									title: 'Codigo',
									width: '30%',
									create: true,
									edit: true,
									list: true
									},
									descripcion: {
									title: 'Descripcion',
									width: '30%',
									create: true,
									edit: true,
									list: true
									},
									cantidad: {
									title: 'Cantidad',
									width: '30%',
									create: true,
									edit: true,
									list: true
									},
									descuento: {
									title: 'Descuento',
									width: '20%',
									create: true,
									edit: false,
									list: false
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
					nombre: {
						title: 'Nombre',
						width: '5%',
						list: true
					},  
                    descripcion: {
						title: 'Descripcion',
						width: '5%',
						list: true
					},                
                    estado: {
						title: 'Estado',
						width: '5%',
						create: true,
                        options: {"activo":"activo","inactivo":"inactivo"},
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
						  var $img = $('<center><img src="../../toolbar-icon/editar.png" style="cursor:pointer;" title="Edicion" /></center>');					
							  $img.on("click",function(){
								  
								  window.location="plantilla_main.php?id_plantilla_cotizacion="+datos.record.id_eplantilla_cot;
								  
								  });
							  return $img;
							  }
                    },
					PDF: {
						  title: '',
						  width: '1%',
						  sorting: false,
						  edit: false,
						  create: false,
						  display: function (datos) {
						  //Create an image that will be used to open child table
						  var $img = $('<img src="../../toolbar-icon/pdf.gif" title="Exportar a PDF" />');
						   return $img;
							  }
                    }                    
					
					
				},selectionChanged: function (data) {
                //Get all selected rows
                var valido="<?php echo $_GET["seleccion"]; ?>";
                if(valido==1){
                var $selectedRows = $('#jt_plantilla').jtable('selectedRows');                        
                        $selectedRows.each(function () {
                        var record = $(this).data('record');
                        $("#valor1").val(record.nombre);
                        $("#valor2").val(record.id_eplantilla_cot);
                    });
                }
                    },
                //cuando se cierra el dialog
                 formClosed: function(event, data) {
                      $('#jt_cotizacion').jtable('load');
                 }

        });
			
				
			//Load person list from server
			$('#jt_plantilla').jtable('load');
			
			//buscar por clientes
			 $('#btnBUSCAR').on('click',function(e) {
                    e.preventDefault();
                    $('#jt_plantilla').jtable('load', {
                        nombre: $('#nombre').val(),
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

	  $( "#dialog" ).dialog({
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
	  
				$( this ).dialog( "close" );
			  },
			  "Generar": function() {
					
					
					$.ajax({
				  
				  async:true,
				  cache:false,
				  type:"GET",
				  dataType:"json",
				  //url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
				  url:"plantillasql_sql.php?action=ot&dat="+Dato,
				  beforeSend: function () {
				 },
				  
				  success: function(response){
					  // alert(response);
					   $('#jt_plantilla').jtable('load');
					   $("#dialog").dialog( "close" );
				   }
				   
			  });
				   
				   
				   
			  }
			}
		  });
    
    
    
    
    
    
		  $( "#dialog2" ).dialog({
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
		  
					$( this ).dialog( "close" );
				  },
				  "Generar": function() {
						
						
						$.ajax({
					  
					  async:true,
					  type:"GET",
					  dataType:"json",
					  //url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
					  url:"cotizacionsql_sql.php?action=update&dato="+Dat,
					  success: function(response){
						 //  alert(response);
						   $('#jt_cotizacion').jtable('load');
						   $("#dialog2").dialog( "close" );
					   }
					   
				  });
					   
					   
					   
				  }
				}
			  });
		  

 		                       
  });
        
		  		$(".jtable-delete-command-button").on('click', function(e) { 

					  alert('eliminar');
		
				});        
      
</script>

    <input type="hidden" id="valor1" />
    <input type="hidden" id="valor2" />
    
	<div id="dialog" title="OT">
	  <p>Generar Orden de Trabajo</p>
	</div>

	<div id="dialog2" title="Facturar">
	  <p>Generar Factura</p>
	</div>

</body>
</html>