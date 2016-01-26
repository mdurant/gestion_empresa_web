<?php
require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

    if (empty($_SESSION["INV_FECHABUSQUEDA1"])) { $_SESSION["INV_FECHABUSQUEDA1"] = date("d-m-Y");  }
    if (empty($_SESSION["INV_FECHABUSQUEDA2"])) { $_SESSION["INV_FECHABUSQUEDA2"] = date("d-m-Y");  }

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

    

</head>
<style>

form.jtable-dialog-form {
  width:350px;
}
#btn
{
	cursor: pointer;
}



</style>
<body class="ui-widget">

<h4>Inventario</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="85%" cellspacing="2" cellpadding="4">
	    <tbody><tr>
		<td width="40%">
		    <table width="100%">
			<tbody><tr>
			    <td><h5>Buscar</h5></td>
			    <td><input type="text" id="inventario" name="inventario" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
			</tr>
		    </tbody></table>
		</td>
		<td width="20%" align="center">
		    <table style="width:285px">
			<tbody><tr>
			      <td style="width: 50px;text-align: center"><h5 style="width:50px">Desde</h5></td>
			      <td><input class="form-control input-sm ui-corner-all " type="text" name="inicio" id="inicio" /></td>
			      <td style="width: 50px;text-align: center"><h5 style="width:50px">Hasta</h5></td>
			      <td><input class="form-control input-sm ui-corner-all " type="text" name="fin" id="fin" /></td>
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



 
<div id="jt_inventario" style="width: 100%;"></div>

        
	<script type="text/javascript">
	      $('#inicio').attr('value', '<?php echo $_SESSION["INV_FECHABUSQUEDA1"]; ?>');
	      $('#fin').attr('value', '<?php echo $_SESSION["INV_FECHABUSQUEDA2"]; ?>');

	      $("#inicio").datepicker({
	      dateFormat: 'dd-mm-yy'
		});
	      $("#fin").datepicker({
	       dateFormat: 'dd-mm-yy'
		});
	      $(document).ready(function () {
		  
		    //Prepare jTable
			$('#jt_inventario').jtable({
				jqueryuiTheme: true,
    			title: 'Listado',
    			paging: true,
    			pageSize: 10,
    			sorting: true,
    			openChildAsAccordion: true, //Enable this line to show child tabes as accordion style
				defaultSorting: 'id_inventario ASC',
				selecting: false, //Enable selecting
            	multiselect: false, //Allow multiple selecting
            	selectingCheckboxes: false, //Show checkboxes on first column
            	//selectOnRowClick: true, //Enable this to only select using checkboxes
				actions: {
					listAction:	'inventariosql_sql.php?action=list',
					createAction: 	'inventariosql_sql.php?action=create',
					updateAction: 	'inventariosql_sql.php?action=update',
					deleteAction: 	'inventariosql_sql.php?action=delete'
					
				},
		fields: {
					id_inventario: {
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
					var $img = $('<img src="../../toolbar-icon/candado.png" />');
					//Open child table when user clicks the image
					$img.click(function () {
					    
					    //aqui***************
                        $("#ast").val(datos.record.id_inventario);
                        
					   
					    $('#jt_inventario').jtable('openChildTable',
						    $img.closest('tr'),
						    {
							  title: 'Detalle:',
							  paging: true,
							  pageSize: 10,
							  sorting: false,
							  defaultSorting: 'id_dinventario ASC',
							  actions: {
								  listAction: 'inventariodet_sql.php?action=list&IDPerfil='+ datos.record.id_inventario+'&valido='+datos.record.id_bodega,
								  updateAction: 	'inventariodet_sql.php?action=update'
							  },
							  fields: {
								  id_inventario: {
								  type: 'hidden',
								  defaultValue: datos.record.id_inventario
								  },
								  id_dinventario: {
								  key: true,
								  create: false,
								  edit: false,
								  list: false
								  },
								  ProductName:
								  {
									  title: 'Producto',
									  width: "10%",
									  list: true,
									  edit: false
								  },
								  id_bodega: {
								  title: 'Bodega',
								  width: '10%',
								  options:'inventariosql_sql.php?action=Descripcion',
								  create: true,
								  edit: false,
								  list: true
								  },
								  UnitsInStock: {
								  title: 'Stock por Sistema',
								  width: '10%',
								  create: false,
								  edit: false,
								  list: false
								  },
								  existencia: {
								  title: 'Existencia',
								  width: '10%',
								  create: true,
								  edit: true,
								  list: true
								  }
  
							  },
							  recordsLoaded: function (event, data) {
							  },
							  formCreated: function (event, data) {
							   
								   $("#ui-id-5, #ui-id-3").css('height','250px')
											  .css('overflow-y','scroll')
											  .css('overflow-x','hidden');
								   $("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class','btn btn-primary');
								   $("form input, form select").attr('class','form-control input-sm ui-corner-all');
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
                    dia:
					{
						title: 'Dia Inventario',
						width: '20%',
						type: 'date',
                    	displayFormat: 'dd-mm-yy',
						create: false,
						edit: false,
						list: true

					},
                    estado_act:
                    {
                        list:false,
                        create: false,
                        edit: false
                    },
                    hora:
                    {
                        title: 'Hora  Inventario',
                        width: '20%',
						create: false,
                        edit:false,
                        list: true
                    },
					 id_bodega:
                    {
                        title: 'Bodega',
						width: '20%',
                        options:'inventariosql_sql.php?action=Descripcion',
						create: true,
						edit: true,
						list: true
                    },
					 responsable:
                    {
                        title: 'Responsable',
                        width: '20%',
						create: true,
                        edit: true,
                        list: true
                    },
					 estado:
                    {
                        title: 'Estado',
                        width: '20%',
						create: true,
						options:{"activo":"Activo","inactivo":"Inactivo"},
                        edit:false,
                        list: true
                    },
                     ActualizarStock: {
							title: '',
							width: '1%',
							sorting: false,
							edit: false,
							create: false,
							display: function (datos) {
							//Create an image that will be used to open child table
							var $img = $('<center><img src="../../toolbar-icon/abono.gif" style="cursor:pointer;" title="Actualizar Stock" /></center>');
								$img.on("click",function(){
								//aqui***************
								if(datos.record.estado_act=="actualizado")
								{
									alert("Este Inventario Ya fue usado para actualizar Stock")
								}else
								{
									$("#ast2").val(datos.record.id_bodega);
								$("#ast").val(datos.record.id_inventario);
									$("#dialog").dialog("open");
									
															
								}
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
						  var $img = $('<center><img src="../../toolbar-icon/pdf.gif" style="cursor:pointer;" title="Exportar a PDF" /></center>');
						  
							  $img.on("click",function(){
								  
								  window.location = "../../reportes/toma_inventario.php?id_reporte=" + datos.record.id_inventario ,'_blank';
								  });
						   return $img;
							  }
                    }
                    
					
					
		},
                //cuando se cierra el dialog
                 formClosed: function(event, data) {
                        $('#jt_inventario').jtable('load');
                 },
				 formCreated: function (event, data) {
				  
					  $("#ui-id-5, #ui-id-3").css('height','250px')
								 .css('overflow-y','scroll')
								 .css('overflow-x','hidden');
					  $("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class','btn btn-primary');
					  $("form input, form select").attr('class','form-control input-sm ui-corner-all');
				  }

		 

		 
        });
			
				
			//Load person list from server
			$('#jt_inventario').jtable('load');
			
			//buscar por clientes
			 $('#btnBUSCAR').on('click',function(e) {
                    e.preventDefault();
                    $('#jt_inventario').jtable('load', {
                        ordenes: $('#inventario').val(),
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

                
        
        
        //el dialogo para la actualizacion de los productos
        
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
        "Actualizar": function() {
              at=$("#ast").val();
              at2=$("#ast2").val();
              $.ajax({
			
			async:true,
			cache:false,
			type:"GET",
			dataType:"json",
			//url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
			url:"inventariodet_sql.php?action=actualizar&dat="+at+"&dat2="+at2,
			beforeSend: function () {
           },
			
			success: function(response){
			    // alert(response);
			     $('#jt_inventario').jtable('load');
                 $("#dialog").dialog( "close" );
             }
             
        });
             
             
             
        }
      }
    });





 		                       
		});

        
        
      
	</script>

	<div id="dialog" title="Stock">
  <p>Se Actualizara el stock</p>
  <input type="hidden" id="ast"/>
  <input type="hidden" id="ast2"/>
</div>

</body>
</html>