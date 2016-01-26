<?php
require_once("../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Trabajadores</title>

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

	<!-- personales -->
	<script type="text/javascript" src="../js/select2.js"></script>
	<link   type="text/css"        href="../css/select2.css" rel="stylesheet" />

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
<body class="ui-widget">
<h4>Ficha Trabajadores</h4>

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

		  <td><input type="text" id="nombretrabajador" name="nombretrabajador" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all"></td>
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

<div id="jt_trabajadores" style="width: 100%;"></div>


        
<script type="text/javascript">
    $(document).ready(function() {
      //Prepare jTable
      $('#jt_trabajadores').jtable({
	jqueryuiTheme: true,
	title: 'Listado',
	paging: true,
	pageSize: 10,
	sorting: true,
	defaultSorting: 'id_trabajador ASC',
	selecting: true,
	//Enable selecting
	multiselect: true,
	//Allow multiple selecting
	selectingCheckboxes: true,
	//Show checkboxes on first column
	//selectOnRowClick: true, //Enable this to only select using checkboxes
	toolbar: {
	  items: [{
	    icon: '../toolbar-icon/delete.png',
	    text: 'Eliminar',
	    click: function() {

	      var $selectedRows = $('#jt_trabajadores').jtable('selectedRows');

	      if ($selectedRows.length > 0) {
		$('#dialog').html(" <p>Desea eliminar " + $selectedRows.length + " registros</p>");
		$("#dialog").dialog("open");
	      } else {
		alert("Debe seleccionar registros para eliminar.");

	      }

	    }
	  }]
	},
	actions: {
	  listAction: 'trabajadores_sql.php?action=list',
	  createAction: 'trabajadores_sql.php?action=create',
	  updateAction: 'trabajadores_sql.php?action=update',
	  deleteAction: 'trabajadores_sql.php?action=delete'
	},
	fields: {
	
	id_trabajador: {
	    key: true,
	    create: false,
	    edit: false,
	    list: false
	  },
	rut_trabajador: {
	    title: 'Cédula Identidad',
	    width: '20%',
	    create: true,
	    edit: true,
	    list: true

	  },
	nombres: {
	    title: 'Nombres',
	    width: '20%',
	    create: true,
	    edit: true,
	    list: true

	  },
	
	apellidop: {
	    title: 'Apellido Paterno',
	    width: '20%',
	    create: true,
	    edit: true,
	    list: true

	  },
	apellidom: {
	    title: 'Apellido Materno',
	    width: '20%',
	    create: true,
	    edit: true,
	    list: true

	  },
	edad: {
	    title: 'Edad',
	    width: '5%',
	    create: true,
	    edit: true,
	    list: false

	  },
	fecha_nacimiento: {
	    title: 'Fecha Nacimiento',
	    width: '20%',
	    create: true,
	    edit: true,
	    list: false
	  },
	direccion: {
	    title: 'Domicilio',
	    width: '20%',
	    create: true,
	    edit: true,
	    list: false
	  },
	telefono_fijo: {
	    title: 'Teléfono Fijo',
	    width: '20%',
	    create: true,
	    edit: true,
	    list: false
	  },

	telefono_movil: {
	    title: 'Celular',
	    width: '20%',
	    create: true,
	    edit: true,
	    list: false
	  },

	email: {
	    title: 'Correo Electrónico',
	    width: '20%',
	    create: true,
	    edit: true,
	    list: false

	  },
	id_salud: {
	    title: 'Previsión',
	    width: '15%',
	    options: 'trabajadores_sql.php?action=salud',
	    list: false,
	    create: true,
	    edit: true
         },
	id_afp: {
	    title: 'A.F.P.',
	    width: '15%',
	    options: 'trabajadores_sql.php?action=afp',
	    list: false,
	    create: true,
	    edit: true
	   },
	id_estudios: {
	    title: 'Nivel Estudios',
	    width: '15%',
	    options: 'trabajadores_sql.php?action=estudios',
	    list: false,
	    create: true,
	    edit: true
	  },
	id_civil: {
	    title: 'Estado Civil',
	    width: '15%',
	    options: 'trabajadores_sql.php?action=civil',
		list: false,
		create: true,
	    edit: true
		},
	id_ciudad: {
		title: 'Ciudad',
		width: '15%',
		options: 'trabajadores_sql.php?action=ciudad',
		list: false,
		create: true,
	    edit: true
		},
	id_region: {
		title: 'Región',
		width: '15%',
		options: 'trabajadores_sql.php?action=region',
		list: false,
		create: true,
	    edit: true
		},
	id_pais: {
		title: 'Pais',
		width: '15%',
		options: 'trabajadores_sql.php?action=pais',
		list: false,
		create: true,
	    edit: true
		},

	estado: {
	    title: 'Estado',
	    width: '20%',
	    options: {
		  "activo": "activo",
	      "inactivo": "inactivo"
	    },
	    create: true,
	    edit: true,
	    list: false
	  }

	},
	formCreated: function(event, data) {
	  $("div[aria-describedby='ui-id-5']").css("top", "0px");
	  $("div[aria-describedby='ui-id-3']").css("top", "0px");
	  $("#ui-id-5, #ui-id-3").css('height', '650px').css('overflow-y', 'scroll').css('overflow-x', 'hidden');
	  $("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary  ui-corner-all');
	  $("#jtable-edit-form").attr('class', 'form-horizontal');
	  $("input[type=text], textarea").attr('class', 'form-control input-sm ui-corner-all');
	  $("select[name=Estado]").attr("class", "form-control input-sm ui-corner-all");

		//$("#Edit-id_salud").select2();

	 // $("select[name=id_salud]").attr("class", "select2()");
	  
	  $("#Edit-rut_trabajador").css('width', '600px', 'left','450px');
	  
	}

      });


      //Load person list from server
      $('#jt_trabajadores').jtable('load');

      //buscar por clientes
      $('#btnBUSCAR').on('click', function(e) {
	e.preventDefault();
	$('#jt_trabajadores').jtable('load', {
	  nombretrabajador: $('#nombretrabajador').val(),
	  inactivo: $('#chkinactivo').val()
	});
      });
      //eliminar
      // $('#DeleteAllButton').click(function () {
      //         var $selectedRows = $('#PeopleTableContainer').jtable('selectedRows');
      //         $('#PeopleTableContainer').jtable('deleteRows', $selectedRows);
      //     });




      //Initialize validation logic when a form is created

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
	  "Eliminar": function() {
	    var $selectedRows = $('#jt_trabajadores').jtable('selectedRows');
	    $('#jt_trabajadores').jtable('deleteRows', $selectedRows);
	    $(this).dialog("close");
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

<div id="dialog" title="Basic dialog">
  <p>Desea eliminar</p>
</div>

</body>
</html>