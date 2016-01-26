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
    <script src="../../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript"></script>
    <link  href="../../scripts/jquery/themes/<?=$ACTUAL_THEME?>/jquery-ui.css" rel="stylesheet" type="text/css" />
		
    <!-- jtable -->
    <script src="../../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
    <script src="../../scripts/jtable/jquery.jtable.es.js" type="text/javascript"></script>
    <link  href="../../scripts/jtable/themes/<?=$JTABLE_THEME?>" rel="stylesheet" type="text/css" />
    
    <!-- jquery.validationEngine -->
    <script src="../../scripts/jquery/validate/jquery.validationEngine.js" type="text/javascript" ></script>
    <script src="../../scripts/jquery/validate/jquery.validationEngine-es.js" type="text/javascript"></script>
    <link  href="../../scripts/jquery/validate/validationEngine.jquery.css" rel="stylesheet" type="text/css" />

    

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

<h4>Seguimiento Simple</h4>

<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px">
  <form style="margin: 0px;">
    <table width="65%" cellspacing="2" cellpadding="4">
      <tbody>
	<tr>
	  <td width="40%">
	    <table width="100%">
	      <tbody>
		<tr>
		  <td>
		    <h5>Busqueda:</h5>
		  </td>

		  <td><input type="text" id="rutcliente" name="rutcliente" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all"></td>
		</tr>
	      </tbody>
	    </table>
	  </td>

	  <td width="20%" align="center">
	    <table style="width:300px">
	      <tbody>
		<tr>
		  <td style="width: 50px;text-align: center">
		    <h5 style="width:50px">Desde</h5>
		  </td>

		  <td><input class="form-control input-sm ui-corner-all" type="text" name="inicio" id="inicio"></td>

		  <td style="width: 50px;text-align: center">
		    <h5 style="width:50px">Hasta</h5>
		  </td>

		  <td><input class="form-control input-sm ui-corner-all" type="text" name="fin" id="fin"></td>
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

<div id="jt_cotizacion" style="width: 100%;"></div>


        
<script type="text/javascript">
 		$(document).ready(function() {

		  var msg = {
		    deleteConfirmation: 'Realmente desea Anular esta cotizacion',
		    deleteText: 'Anular',
		    save: 'Facturar',
		    editRecord: 'Facturar Cotizacion',

		  };
		  //Prepare jTable
		  $('#jt_cotizacion').jtable({
		    messages: msg,
		    jqueryuiTheme: true,
		    title: 'Listado',
		    paging: true,
		    pageSize: 10,
		    sorting: true,
		    openChildAsAccordion: true,
		    //Enable this line to show child tabes as accordion style
		    defaultSorting: 'IdECotizacion ASC',
		    selecting: false,
		    //Enable selecting
		    multiselect: false,
		    //Allow multiple selecting
		    selectingCheckboxes: false,
		    //Show checkboxes on first column
		    //selectOnRowClick: true, //Enable this to only select using checkboxes
		    actions: {
		      listAction: 'seguimiento_cotizacionsql_sql.php?action=list'
		    },
		    fields: {
		      IdECotizacion: {
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
			display: function(datos) {
			  //Create an image that will be used to open child table
			  var $img = $('<img src="../../toolbar-icon/candado.png" title="Editar Permisos" />');
			  //Open child table when user clicks the image
			  $img.click(function() {

			    //aqui***************

			    $('#jt_cotizacion').jtable('openChildTable', $img.closest('tr'), {
			      title: 'Detalle de Cotizaci&oacute;n:',
			      paging: true,
			      pageSize: 10,
			      sorting: false,
			      defaultSorting: 'IdDCotizacion ASC',
			      actions: {
				listAction: 'seguimiento_cotizaciondet_sql.php?action=list&IDPerfil=' + datos.record.Contador,
			      },
			      fields: {
				IdECotizacion: {
				  type: 'hidden',
				  defaultValue: datos.record.Contador
				},
				IdDCotizacion: {
				  key: true,
				  create: false,
				  edit: false,
				  list: false
				},
				Descripcion: {
				  title: 'Producto/Servicio',
				  width: '30%',
				  create: true,
				  edit: true,
				  list: true
				},
				Cantidad: {
				  title: 'Cantidad',
				  width: '30%',
				  create: true,
				  edit: true,
				  list: true
				},
				Neto: {
				  title: 'Valor Neto($)',
				  width: '30%',
				  create: true,
				  edit: true,
				  list: true
				},
				Descuento: {
				  title: 'Descuento',
				  width: '20%',
				  create: true,
				  edit: false,
				  list: false
				}
			      }
			    }, function(data) { //opened handler
			      data.childTable.jtable('load');
			      hello = data.childTable;
			      return hello;
			    });
			  });
			  //Return image to show on the person row
			  return $img;
			}
		      },
		      rut: {
			title: 'Rut',
			width: '10%',
			create: true,
			edit: false,
			list: true

		      },
		      Accion: {
			title: 'Para Facturar',
			width: '20%',
			edit: true,
			input: function(data) {
			  return '<p>Seleccione Facturarada</p>';
			},
			list: false

		      },
		      RazonSocial: {
			title: 'Razon Social',
			width: '20%',
			create: true,
			edit: false,
			list: true

		      },
		      Contador: {
			title: 'Numero',
			width: '10%',
			create: true,
			edit: false,
			list: true
		      },
		      Total: {
			title: 'Total $',
			width: '10%',
			create: true,
			edit: false,
			list: true
		      },
		      FechaCreacion: {
			title: 'Fecha de Creaci&oacute;n',
			width: '10%',
			type: 'date',
			displayFormat: 'dd-mm-yy',
			edit: false,
			list: true
		      },
		      FechaTermino: {
			title: 'Fecha de Termino',
			width: '10%',
			type: 'date',
			displayFormat: 'dd-mm-yy',
			edit: false,
			list: true
		      },
		      Estado: {
			title: 'Estado',
			width: '5%',
			create: true,
			options: {
			  "Facturada": "Facturar",
			  "activo": "activo",
			  "inactivo": "inactivo",
			  "OTC": "OTC"
			},
			edit: true,
			list: true
		      },
		      PDF: {
			title: '',
			width: '2%',
			sorting: false,
			edit: false,
			create: false,
			display: function(datos) {
			  //Create an image that will be used to open child table
			  var $img = $('<img src="../../toolbar-icon/pdf.gif" title="Exportar a PDF" />');
			  return $img;
			}
		      }


		    },
		    //cuando se cierra el dialog
		    formClosed: function(event, data) {
		      $('#jt_cotizacion').jtable('load');
		    }

		  });


		  //Load person list from server
		  $('#jt_cotizacion').jtable('load');

		  //buscar por clientes
		  $('#btnBUSCAR').on('click', function(e) {
		    e.preventDefault();
		    $('#jt_cotizacion').jtable('load', {
		      rutcliente: $('#rutcliente').val(),
		      inicio: $('#inicio').val(),
		      fin: $("#fin").val()

		    });
		  });
		  //eliminar
		  // $('#DeleteAllButton').click(function () {
		  //         var $selectedRows = $('#PeopleTableContainer').jtable('selectedRows');
		  //         $('#PeopleTableContainer').jtable('deleteRows', $selectedRows);
		  //     });




		  //Initialize validation logic when a form is created


		  $("#inicio").datepicker({
		    dateFormat: 'dd-mm-yy'
		  });
		  $("#fin").datepicker({
		    dateFormat: 'dd-mm-yy'
		  });




		  $("#dialog").dialog({
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

			$(this).dialog("close");
		      },
		      "Generar": function() {


			$.ajax({

			  async: true,
			  cache: false,
			  type: "GET",
			  dataType: "json",
			  //url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
			  url: "seguimiento_cotizacionsql_sql.php?action=ot&dat=" + Dato,
			  beforeSend: function() {},

			  success: function(response) {
			    // alert(response);
			    $('#jt_cotizacion').jtable('load');
			    $("#dialog").dialog("close");
			  }

			});



		      }
		    }
		  });






		  $("#dialog2").dialog({
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

			$(this).dialog("close");
		      },
		      "Generar": function() {


			$.ajax({

			  async: true,
			  type: "GET",
			  dataType: "json",
			  //url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
			  url: "seguimiento_cotizacionsql_sql.php?action=update&dato=" + Dat,
			  success: function(response) {
			    //  alert(response);
			    $('#jt_cotizacion').jtable('load');
			    $("#dialog2").dialog("close");
			  }

			});



		      }
		    }
		  });

		});
</script>

	<div id="dialog" title="OT">
  <p>Generar Orden de Trabajo</p>
</div>

	<div id="dialog2" title="Facturar">
  <p>Generar Factura</p>
</div>

</body>
</html>