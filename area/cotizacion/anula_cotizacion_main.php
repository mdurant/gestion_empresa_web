<?php

$ACTUAL_THEME="redmond";
$JTABLE_THEME="jqueryui/jtable_jqueryui.css";
//$JTABLE_THEME="lightcolor/blue/jtable.css";

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Gestion interna</title>

	<!-- jquery -->
	<script src="../../scripts/jquery/jquery.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../js/jquery-barcode.js"></script>
    <script src="../../scripts/jquery/jquery-ui.js" type="text/javascript"></script>
    <link  href="../../scripts/jquery/themes/<?=$ACTUAL_THEME?>/jquery-ui.css" rel="stylesheet" type="text/css" />
	<link  href="../../scripts/jquery/themes/<?=$ACTUAL_THEME?>/jquery-ui.theme.css" rel="stylesheet" type="text/css" />
	
    <!-- jtable -->
	<script src="../../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
    <script src="../../scripts/jtable/jquery.jtable.es.js" type="text/javascript"></script>
    <link  href="../../scripts/jtable/themes/<?=$JTABLE_THEME?>" rel="stylesheet" type="text/css" />
    
    <!-- jquery.validationEngine -->
	<script src="../../scripts/jquery/validate/jquery.validationEngine.js" type="text/javascript" ></script>
    <script src="../../scripts/jquery/validate/jquery.validationEngine-es.js" type="text/javascript"></script>
    <link  href="../../scripts/jquery/validate/validationEngine.jquery.css" rel="stylesheet" type="text/css" />

<script>
$(function(){
    $("#miscCanvas").barcode("Hola", "code93",{output:"canvas"}); 
})
</script>
</head>
<style>

form.jtable-dialog-form {
  width:300px;
}
#btn
{
	cursor: pointer;
}



</style>
<body>


<div class="ui-tabs-panel ui-widget-content" style="width: 1200px;">
    <form style="margin: 0px">
            <table style="margin: 0px; heigth:50px">
            <tr>
            <td><p style="demoHeaders"> Cliente</p></td>
            <td><input style="ui-corner-all" type="text" name="cliente" id="cliente" /></td>
            <td >
            <button type="submit" id="btnBUSCAR" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
            <span class="ui-icon ui-icon-search"></span>
            <span class="ui-button-text">Buscar</span>
            </button>
            </td>
            </tr>
            </table>
   		  
        
             
    </form>
</div>


 
<div id="jt_anulacotizacion" style="width: 1200px;"></div>

        
	<script type="text/javascript">

		$(document).ready(function () {
		    //Prepare jTable
			$('#jt_anulacotizacion').jtable({
				jqueryuiTheme: true,
				title: 'Cotizacion',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'IdECotizacion ASC',
				selecting: true, //Enable selecting
            	multiselect: true, //Allow multiple selecting
            	selectingCheckboxes: true, //Show checkboxes on first column
            	//selectOnRowClick: true, //Enable this to only select using checkboxes
            	toolbar: {
						    items: [{
						        icon: '../../toolbar-icon/delete.png',
						        text: 'Eliminar',
						        click: function () {
						          
                                       var $selectedRows = $('#jt_anulacotizacion').jtable('selectedRows');
                         
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
						},
				actions: {
					listAction:		'anula_cotizacion_sql.php?action=list',
					updateAction: 	'anula_cotizacion_sql.php?action=update',
					deleteAction: 	'anula_cotizacion_sql.php?action=delete'
				},
				fields: {
					IdECotizacion: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					 Phones: {
                    title: '',
                    width: '2%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function () {
                        //Create an image that will be used to open child table
                        var $img = $('<img src="../../toolbar-icon/delete.png" id="btn" title="Edit phone numbers" />');
                        //Open child table when user clicks the image
                        $img.on("click",function () {
                            
                            
                                    $( "#dialog" ).dialog( "open" );
                            
                            
                           
                        });
                        //Return image to show on the person row
                        return $img;
                    }
                },
                Phones2: {
                    title: '',
                    width: '2%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function () {
                        //Create an image that will be used to open child table
                        var $img = $('<img src="../../toolbar-icon/delete.png" id="btn2" title="Edit phone numbers" />');
                        //Open child table when user clicks the image
                        $img.on("click",function () {
                           $( "#dialog2" ).dialog( "open" );
                        });
                        //Return image to show on the person row
                        return $img;
                    }
                },
               Name: {
                        title: 'Name',
                        width: '20%',
                        list: false,
                        input: function () {
                               return '<a id="download" class="btn btn-primary" download="barcode.png"><canvas id="miscCanvas" width:200px; style="border:1px solid #ffffff;"></canvas></a>';
                        }
                    },
                    codigo:
					{
						title: 'codigo',
						width: '20%',
						create: false,
						edit: true,
						list: false

					},
					Estado:
					{
						title: 'Estado',
						width: '20%',
						create: false,
						edit: true,
						options: {'activo':'Activo','Cancelada u Obsoleta':'Cancelada u Obsoleta'},
						list: true

					},
					Cliente:
					{
						title: 'Cliente',
						width: '20%',
						create: false,
						edit: false,
						list: true
					},
					FechaCreacion: {
						title: 'Fecha Creacion',
						width: '20%',
						 type: 'date',
						 displayFormat: 'dd-mm-yy',
						create: false,
						edit: false,
						list: true
					},
					FechaTermino:
					{
						title: 'Fecha Termino',
						width: '20%',
						 type: 'date',
						displayFormat: 'dd-mm-yy',
						create: false,
						edit: true,
						list: true
					},
					motivo:
					{
						title: 'Motivo',
						width: '20%',
						create: false,
						edit: true,
						list: false,
						type: 'textarea'
					}
					
					
				},
                 formCreated: function (event, data) {
                function clearCanvas(){
                        var canvas = $('#miscCanvas').get(0);
                        var ctx = canvas.getContext('2d');
                        ctx.lineWidth = 0;
                        // ctx.lineCap = 'butt';
                        ctx.fillStyle = '#ffffff';
                        ctx.strokeStyle  = '#ffffff';
                        ctx.clearRect (0, 0, canvas.width, canvas.height);
                        ctx.strokeRect (0, 0, canvas.width, canvas.height);
                      }
            		$("input[name='codigo']").on("keyup",function(){
            				//alert("hay mierda rechasada");
            				//alert("ajsojsaojsa");
            				clearCanvas();
            				// $("#miscCanvas").empty();
            			$("#miscCanvas").barcode($("input[name='codigo']").val(), "code93",{output:"canvas"});  
            			//$("#miscCanvas").barcode($("#valores").val(), "code93");  
            		});
                $("#miscCanvas").barcode($("input[name='codigo']").val(), "code93",{output:"canvas"}); 
                
                  	function download() {
                    var dt = canvas.toDataURL();
                    this.href = dt;
                    }
                    
                    var canvas = document.getElementById('miscCanvas');
                    document.getElementById('download').addEventListener('click', download, false);
            },

				//selectrows
				selectionChanged: function () {

            }
        });
			
				
			//Load person list from server
			$('#jt_anulacotizacion').jtable('load');
			
			//buscar por clientes
			 $('#buscando').on('click',function(e) {
            e.preventDefault();
            $('#jt_anulacotizacion').jtable('load', {
                cliente: $('#cliente').val()
            });
        });
			//eliminar
			 // $('#DeleteAllButton').click(function () {
    //         var $selectedRows = $('#PeopleTableContainer').jtable('selectedRows');
    //         $('#PeopleTableContainer').jtable('deleteRows', $selectedRows);
    //     });
		

	$('#jt_prueba').jtable({
				jqueryuiTheme: true,
				title: 'Cotizacion',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'IdECotizacion ASC',
				selecting: true, //Enable selecting
            	multiselect: true, //Allow multiple selecting
            	selectingCheckboxes: true, //Show checkboxes on first column
            	//selectOnRowClick: true, //Enable this to only select using checkboxes
            	toolbar: {
						    items: [{
						        icon: '../../toolbar-icon/delete.png',
						        text: 'Eliminar Multiple',
						        click: function () {
						          
                                     
						             $( "#dialog" ).dialog( "open" );
						        }
						    }]
						},
				actions: {
					listAction:		'anula_cotizacion_sql.php?action=list',
					updateAction: 	'anula_cotizacion_sql.php?action=update',
					deleteAction: 	'anula_cotizacion_sql.php?action=delete'
				},
				fields: {
					IdECotizacion: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					 Phones: {
                    title: '',
                    width: '2%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function () {
                        //Create an image that will be used to open child table
                        var $img = $('<img src="scripts/jtable/themes/lightcolor/add.png" id="btn" title="Edit phone numbers" />');
                        //Open child table when user clicks the image
                        $img.on("click",function () {
                           $( "#dialog" ).dialog( "open" );
                        });
                        //Return image to show on the person row
                        return $img;
                    }
                },
                Phones2: {
                    title: '',
                    width: '2%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function () {
                        //Create an image that will be used to open child table
                        var $img = $('<img src="scripts/jtable/themes/lightcolor/add.png" id="btn2" title="Edit phone numbers" />');
                        //Open child table when user clicks the image
                        $img.on("click",function () {
                           $( "#dialog2" ).dialog( "open" );
                        });
                        //Return image to show on the person row
                        return $img;
                    }
                },
					Estado:
					{
						title: 'Estado',
						width: '20%',
						create: false,
						edit: true,
						options: {'activo':'Activo','Cancelada u Obsoleta':'Cancelada u Obsoleta'},
						list: true

					},
					Cliente:
					{
						title: 'Cliente',
						width: '20%',
						create: false,
						edit: false,
						list: true
					},
					FechaCreacion: {
						title: 'Fecha Creacion',
						width: '20%',
						 type: 'date',
						 displayFormat: 'dd-mm-yy',
						create: false,
						edit: false,
						list: true
					},
					FechaTermino:
					{
						title: 'Fecha Termino',
						width: '20%',
						 type: 'date',
						displayFormat: 'dd-mm-yy',
						create: false,
						edit: true,
						list: true
					},
					motivo:
					{
						title: 'Motivo',
						width: '20%',
						create: false,
						edit: true,
						list: false,
						type: 'textarea'
					}
					
					
				},
              

				//selectrows
				selectionChanged: function () {
                //Get all selected rows
                var $selectedRows = $('#jt_prueba').jtable('selectedRows');
 
                $('#SelectedRowList').empty();
                if ($selectedRows.length > 0) {
                        $('#dialog').html(" <p>Desea eliminar "+$selectedRows.length+" registros</p>");
                }
            }
        });
			
				
			//Load person list from server
			$('#jt_prueba').jtable('load');


		//Initialize validation logic when a form is created
           
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
        "Eliminar": function() {
		var $selectedRows = $('#jt_anulacotizacion').jtable('selectedRows');
       	$('#jt_anulacotizacion').jtable('deleteRows', $selectedRows);
          $( this ).dialog( "close" );
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
      }
    });
 

        
 		                       
		});
        
        
      
	</script>

	<div id="dialog" title="Basic dialog">
  <p>Desea eliminar</p>
</div>

<div id="dialog2">
<div id="jt_prueba" style="width: 1200px;"></div>
</div>

</body>
</html>