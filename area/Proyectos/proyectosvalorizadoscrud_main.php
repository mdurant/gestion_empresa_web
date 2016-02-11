<?php
require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

$IDEmpresas = $_SESSION['SESS_EMPRESA_ID']; //$_GET['IDEmpresa'];

require_once("lista_proyectos_valorizados.php");

$tra=new select();
$res = $tra->code_autocomplete();

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Proyectos Valorizados</title>

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

#btn
{
	cursor: pointer;
}



</style>
<body class="ui-widget">


<h4>Proyectos Valorizados</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="65%" cellspacing="2" cellpadding="4">
	    <tbody><tr>
		<td width="60%">
		    <table width="100%">
			   <tbody>
          <tr>
  			    <td><h5 style="width:30px">Buscar </h5></td>
  			    <td><input type="text" id="proyecto_valorizado[]" name="proyecto_valorizado" style="width:100%" placeholder="Nombre del Proyecto" class="form-control input-sm ui-corner-all cod typeahead cod_complete" data-provide="typeahead"></td>
			     </tr>
		      </tbody>
        </table>

		</td>
		<td width="20%" align="center">

		    <table style="width:285px;">
			<tbody>
      <tr>
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


<div id="jt_proyectos_valorizados" style="width: 100%;"></div>


<script type="text/javascript">

		$(document).ready(function () {
      var availableTags = <?=json_encode($res);?>;
    $(".cod_complete").autocomplete({
      source: availableTags
    });

			//Prepare jTable
			$('#jt_proyectos_valorizados').jtable({
				jqueryuiTheme: true,
				title: 'Listado Proyectos Valorizados',
				paging: true,
				pageSize: 10,
				sorting: true,
				openChildAsAccordion: true,
				//Enable this line to show child tabes as accordion style
				defaultSorting: 'id_proyecto ASC',
				selecting: true,
				//Enable selecting
				multiselect: false,
				//Allow multiple selecting
				selectingCheckboxes: false,
				//Show checkboxes on first column
				//selectOnRowClick: true, //Enable this to only select using checkboxes
				toolbar: {

				},
				actions: {
					listAction:   'proyectosvalorizadossql_sql.php?action=list'
				},
				fields:
        {
					id_proyecto: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
          PDF: {
            title: '',
            width: '1%',
            sorting: false,
            edit: false,
            create: false,
            display: function(datos) {
            //Create an image that will be used to open child table
            var $img = $('<center><button title="Ver Reporte" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../../toolbar-icon/pdf.gif" style="cursor:pointer;" title="Ver Reporte" /></button></center>');
            $img.on("click", function()
            {
              //alert(datos.record.id_orden);
              window.location = "../../reportes/ordentrabajo.php?id_orden=" + datos.record.id_proyecto;
            });
            return $img;
            }
          },

					nombre_proyecto: {
						title: 'Nombre Proyecto',
						width: '30%',
						create: false,
						edit: false,
						list: true

					},
					fecha_inicio: {
						title: 'Fecha Inicio',
						width: '7%',
						create: false,
						edit: false,
						list: true
					},
					fecha_compromiso: {
						title: 'Fecha Fin',
						width: '7%',
						create: false,
						edit: false,
						list: true
					},
					Estado: {
						title: 'Estado',
						width: '5%',
						create: false,
						edit: false,
						list: true
					}

				},  // end Filed

				//cuando se cierra el dialog
				formClosed: function(event, data) {
					$('#jt_proyectos_valorizados').jtable('load');
				},

				recordsLoaded: function() {
					$(".jtable-toolbar").attr("id", "");
				}


			});


			//Load person list from server
			$('#jt_proyectos_valorizados').jtable('load');

			//buscar por clientes
			$('#btnBUSCAR').on('click', function(e) {
				e.preventDefault();

			$('#jt_proyectos_valorizados').jtable('load', {
				proyecto_valorizado: $('.cod_complete').val()

			});

       $('#jt_proyectos_valorizados').jtable('load', {
        proyecto_valorizado: $('.cod_complete').val()

      });

      });
			//Initialize validation logic when a form is created

			$("#inicio").datepicker({
				dateFormat: 'dd-mm-yy'
			});
			$("#fin").datepicker({
				dateFormat: 'dd-mm-yy'
			});

		});


</script>

</body>
</html>