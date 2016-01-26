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
<body>

<h3>Gestion de Inventario</h3>
<div style="width: 1200px; background-color: transparent; font-family: lucida sans unicide, tahoma; font-size: 12px;">
    <form style="margin: 0px">
            <table style="margin: 0px; heigth:50px">
            <tr>
            <td><p style="demoHeaders">Busqueda:</p></td>
            <td><input style="ui-corner-all" type="text" name="inventario" id="inventario" /></td>
            <td>&nbsp;</td>
            <td><p style="demoHeaders">Incluir Inactivos</p></td>
            <td><input type="checkbox" id="inactivo" name="inactivo" value="1"/></td>
            <td>&nbsp;</td>
            <td>
            <button type="submit" id="btnBUSCAR" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false">
            <span class="ui-icon ui-icon-search"></span>
            <span class="ui-button-text">Buscar</span>
            </button>
            </td>
            </tr>
            </table>
   		  
        
             
    </form>
</div>


 
<div id="jt_inventario" style="width: 1200px;"></div>

        
	<script type="text/javascript">

		$(document).ready(function () {
		  
		    //Prepare jTable
			$('#jt_inventario').jtable({
				jqueryuiTheme: true,
    			title: 'Gesti&oacute;n de inventario',
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
					listAction:		'vistainventariosql_sql.php?action=list'
					
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
					   
					    $('#jt_inventario').jtable('openChildTable',
						    $img.closest('tr'),
						    {
							title: 'Detalle:',
							paging: true,
							pageSize: 10,
							sorting: false,
							defaultSorting: 'id_dinventario ASC',
							actions: {
							    listAction: 'vistainventariodet_sql.php?action=list&IDPerfil='+ datos.record.id_inventario+'&valido='+datos.record.id_aa
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
								title: 'Bodega Inventariada',
								width: '10%',
								options:'vistainventariosql_sql.php?action=Descripcion',
								create: true,
								edit: false,
								list: true
							    },
							    debe: {
								title: 'Debe',
								width: '10%',
								create: true,
								edit: true,
								list: true
							    },
							    haber: {
								title: 'Haber',
								width: '10%',
								create: true,
								edit: true,
								list: true
							    },
							    saldo: {
								title: 'Saldo',
								width: '10%',
								create: true,
								edit: true,
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
                        title: 'Bodega Inventariada',
						width: '20%',
                        options:'vistainventariosql_sql.php?action=Descripcion',
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
							
							window.location="../../reportes/archivo.php";
							});
                     return $img;
                        }
                    }
                    
					
					
				},
                //cuando se cierra el dialog
                 formClosed: function(event, data) {
                        $('#jt_inventario').jtable('load');
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

 		                       
		});
        
        
      
	</script>



</body>
</html>