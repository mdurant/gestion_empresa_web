<?php
require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

    if (empty($_SESSION["COM_FECHABUSQUEDA1"])) { $_SESSION["COM_FECHABUSQUEDA1"] = date("d-m-Y");  }
    if (empty($_SESSION["COM_FECHABUSQUEDA2"])) { $_SESSION["COM_FECHABUSQUEDA2"] = date("d-m-Y");  }

$IDEmpresas = $_SESSION['SESS_EMPRESA_ID']; //$_GET['IDEmpresa'];

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
    <script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript"></script>
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
  
<h4>Factura de Compras</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="65%" cellspacing="2" cellpadding="4">
	    <tbody><tr>
		<td width="60%">
		    <table width="100%">
			<tbody><tr>
			    <td><h5 style="width:30px">Buscar </h5></td>
			    <td><input type="text" id="rutcliente" name="rutcliente" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
			</tr>
		    </tbody></table>
		    
		</td>
		<td width="20%" align="center">
		    
		    <table style="width:330px">
			<tbody><tr>
			      <td style="width: 50px;text-align: center"><h5 style="width:50px">Desde</h5></td>
			      <td><input class="form-control input-sm ui-corner-all " type="text" name="inicio" id="inicio" /></td>
			      <td style="width: 50px;text-align: center"><h5 style="width:50px">Hasta</h5></td>
			      <td><input class="form-control input-sm ui-corner-all " type="text" name="fin" id="fin" /></td>
			</tr>
		    </tbody></table>
		    
		</td>
		<td width="20%" align="center">
		    <button style="height: 30px; width: 100px" aria-disabled="false" role="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="btnBUSCAR" type="submit">
		    <span class="ui-icon ui-icon-search"></span>
		    <span class="ui-button-text">Buscar</span>

		</button></td>
	    </tr>
	</tbody>
    </table>
    </form>
</div>
<div style="height: 5px;width: 100%;"></div>


<div id="jt_compras" style="width: 100%;"></div>

        
	<script type="text/javascript">
		 $('#inicio').attr('value', '<?php echo $_SESSION["COM_FECHABUSQUEDA1"]; ?>');
		 $('#fin').attr('value', '<?php echo $_SESSION["COM_FECHABUSQUEDA2"]; ?>');

		$("#inicio").datepicker({
		dateFormat: 'dd-mm-yy'
		});
		$("#fin").datepicker({
		dateFormat: 'dd-mm-yy'
		});
		$(document).ready(function () {
		  
		    //Prepare jTable
			$('#jt_compras').jtable({
				jqueryuiTheme: true,
				title: 'Listado',
				paging: true,
				pageSize: 10,
				sorting: true,
				openChildAsAccordion: true, //Enable this line to show child tabes as accordion style
				defaultSorting: 'id_ecompra ASC',
				selecting: true, //Enable selecting
				multiselect: false, //Allow multiple selecting
				selectingCheckboxes: false, //Show checkboxes on first column
				//selectOnRowClick: true, //Enable this to only select using checkboxes
				toolbar: {
					  items: [{
					  icon: '../../toolbar-icon/ot.png',
					  text: 'Ingresar Nueva Compra',
					  click: function () {
									  
										 window.location = 'compra_main.php?IDEmpresa='+'<?=$IDEmpresas?>';
										
									}
								}]
							},
				actions: {
					listAction:'comprasql_sql.php?action=list'
				},
				fields: {
					id_ecompra: {
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
					    
					    $('#jt_compras').jtable('openChildTable',
						    $img.closest('tr'),
						    {
							title: 'Detalle:',
							paging: true,
							pageSize: 10,
							sorting: false,
							selecting: true,
							defaultSorting: 'id_ecompra ASC',
							actions: {
							    listAction: 'compradet_sql.php?action=list&IDPerfil='+ datos.record.id_ecompra,
							},
							fields: {
							    id_ecompra: {
								type: 'hidden',
								defaultValue: datos.record.id_ecompra
							    },
							    id_compra: {
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
							    codigo: {
								title: 'Codigo',
								width: '10%',
								create: true,
								edit: true,
								list: true
							    },
							    descripcion: {
								title: 'Producto',
								width: '10%',
								create: true,
								edit: true,
								list: true
							    },
							    Descripcion: {
								title: 'Bodega',
								width: '10%',
								create: true,
								edit: false,
								list: true
							    },
								precio_compra: {
								title: 'Precio Compra ($)',
								width: '10%',
								create: true,
								edit: false,
								list: true
							    },
								precio_venta: {
								title: 'Precio Venta ($)',
								width: '10%',
								create: true,
								edit: false,
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
                    folio_compra:
					{
						title: 'Folio (Interno)',
						width: '5%',
						create: true,
						edit: false,
						list: true

					},
                    fecha_ingreso:
                    {
                        title: 'Fecha de Ingreso',
                        width: '5%',
                        type: 'date',
                        displayFormat: 'dd-mm-yy',
                        edit:false,
                        list: true
                    },
                    RazonSocial: {
						title: 'Empresa',
						width: '10%',
						list: true
					},
					Suppliers: {
						title: 'Proveedor',
						width: '10%',
						list: true
					},
					total: {
						title: 'Total $',
						width: '5%',
						list: true
					},
                    PDF: {
						title: '',
						width: '2%',
						sorting: false,
						edit: false,
						create: false,
						display: function (datos) {
							//Create an image that will be used to open child table
							var $img = $('<center><button title="Ver Documento" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../../toolbar-icon/pdf.gif" style="cursor:pointer;" title="" /></button></center>');
							 return $img;
						}
                    }
                    
					
					
				},
                //cuando se cierra el dialog
                 formClosed: function(event, data) {
                        $('#jt_compras').jtable('load');
                 }

        });
			
				
			//Load person list from server
			$('#jt_compras').jtable('load');
			
			//buscar por clientes
			 $('#btnBUSCAR').on('click',function(e) {
                    e.preventDefault();
                    $('#jt_compras').jtable('load', {
                        proveedores: $('#proveedores').val(),
                        inicio:$('#inicio').val(),
                        fin:$("#fin").val(),
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
 


 		                       
		});
        
        
      
	</script>



</body>
</html>
