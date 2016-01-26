<?php
require_once("../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Gestión Compra de Combustible</title>


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

    <!-- jquery-barcode -->
	<script type="text/javascript" src="../js/jquery-barcode.js"></script>
    

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
<body  class="ui-widget">


<h4>Gestión Compra de Combustible</h4>
    
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">

    <form style="margin: 0px">
	
	
    <table width="65%" cellspacing="2" cellpadding="4">
	    <tbody><tr>
		<td width="60%">
		    <table width="100%">
			<tbody><tr>
			    <td><h5 style="width:30px">Buscar </h5></td>
			    <td><input type="text" id="proveedor" name="proveedor" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
			</tr>
		    </tbody></table>
		    
		</td>
		<td width="20%" align="center">
		    
		    <table style="width:130px">
			<tbody><tr>
			    <td><h5>Incluir Inactivos </h5></td>
			    <td><input type="checkbox" style="vertical-align: middle;" value="1" name="chkinactivo" id="chkinactivo"></td>
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


<div id="jt_combustible" style="width: 100%;"></div>

        
<script type="text/javascript">
		$(document).ready(function() {
		  //Prepare jTable
		  $('#jt_combustible').jtable({
			jqueryuiTheme: true,
			title: 'Listado',
			paging: true,
			pageSize: 10,
			sorting: true,
			defaultSorting: 'id_compra_combustible ASC',
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

				  var $selectedRows = $('#jt_combustible').jtable('selectedRows');

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
			  listAction: 'combustible_sql.php?action=list',
			  createAction: 'combustible_sql.php?action=create',
			  updateAction: 'combustible_sql.php?action=update',
			  deleteAction: 'combustible_sql.php?action=delete'
			},
			fields: {
			  id_compra_combustible: {
				key: true,
				create: false,
				edit: false,
				list: false
			  },
			  
			 numero_documento: {
				title: 'Nº Docto.',
				width: '8%',
				create: true,
				edit: true,	
				list: true

			  },
			  tipo_documento: {
				title: 'Tipo ',
				width: '10%',
				create: true,
				edit: true,
				list: true,
				options: {
			    'GUIA DESPACHO': 'GUIA DESPACHO',
			    'FACTURA': 'FACTURA'
				}

			  },
			  id_proveedor: {
				title: 'Proveedor',
				width: '8%',
				create: true,
				options: 'combustible_sql.php?action=proveedor',
				edit: true,
				list: true
	
			  },
			  id_empresa: {
				title: 'Empresa',
				width: '10%',
				create: true,
				options: 'combustible_sql.php?action=empresa',
				edit: true,
				list: true
	
			  },
			  fecha_emision: {
				title: 'Fecha Emisión',
				width: '10%',
				type:'date',
				displayformat:'dd-mm-yy',
				create: true,
				edit: true,
				list: true
			  },
			  glosa: {
				title: 'Descipción',
				width: '20%',
				create: true,
				edit: true,
				list: false
			  },
			forma_pago: {
				title: 'Forma Pago',
				width: '10%',
				create: true,
				options: 'combustible_sql.php?action=forma_pago',
				edit: true,
				list: true
	
			  },
			  neto: {
				title: 'Total Neto',
				width: '10%',
				create: true,
				edit: true,
				list: true
			},
			  excento: {
				title: 'Total Excento',
				width: '10%',
				create: true,
				edit: true,
				list: true
			  },
			  impuesto_especifico: {
				title: 'Impuesto Específico',
				width: '13%',
				create: true,
				edit: true,
				list: true
			  },
			  iva: {
				title: 'I.V.A.',
				width: '10%',
				create: true,
				edit: true,
				list: true
			  },
			  total: {
				title: 'Total $',
				width: '10%',
				create: true,
				edit: true,
				list: true
			  },


			},
			formCreated: function(event, data) {

			  $("div[aria-describedby='ui-id-5']").css("top", "0px");
			  $("div[aria-describedby='ui-id-3']").css("top", "0px");

			  $("#ui-id-5, #ui-id-3").css('height', '350px').css("width", "580px").css('overflow-y', 'scroll').css('overflow-x', 'hidden');
			  $("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary');
			  $("form input[type=text], form textarea, form select").attr('class', 'form-control input-sm ui-corner-all');

			  function clearCanvas() {
				var canvas = $('#miscCanvas').get(0);
				var ctx = canvas.getContext('2d');
				ctx.lineWidth = 0;
				// ctx.lineCap = 'butt';
				ctx.fillStyle = '#ffffff';
				ctx.strokeStyle = '#ffffff';
				ctx.clearRect(0, 0, canvas.width, canvas.height);
				ctx.strokeRect(0, 0, canvas.width, canvas.height);
			  }
			  $("input[name='CodeBar']").on("keyup", function() {
				clearCanvas();
				// $("#miscCanvas").empty();
				$("#miscCanvas").barcode($("input[name='CodeBar']").val(), "code93", {
				  output: "canvas"
				});
				//$("#miscCanvas").barcode($("#valores").val(), "code93");  
			  });
			  $("#miscCanvas").barcode($("input[name='CodeBar']").val(), "code93", {
				output: "canvas"
			  });

			  function download() {
				var dt = canvas.toDataURL();
				this.href = dt;
			  }

			  var canvas = document.getElementById('miscCanvas');
			  document.getElementById('download').addEventListener('click', download, false);

			  //validacion
			  data.form.find('input[name="CodeBar"]').addClass('validate[required]');
			  data.form.find('input[name="ProductName"]').addClass('validate[required]');
			  data.form.find('input[name="UnidadMedida"]').addClass('validate[required]');
			  data.form.find('input[name="IDCellar"]').addClass('validate[required]');
			  data.form.find('input[name="Description"]').addClass('validate[required]');
			  data.form.find('input[name="Suppliers"]').addClass('validate[required]');
			  data.form.find('input[name="CategoryProduct"]').addClass('validate[required]');
			  data.form.find('input[name="Nombre"]').addClass('validate[required]');
			  data.form.validationEngine();
			},
			//Validate form when it is being submitted
			formSubmitting: function(event, data) {
			  return data.form.validationEngine('validate');
			},
			//Dispose validation logic when form is closed
			formClosed: function(event, data) {
			  data.form.validationEngine('hide');
			  data.form.validationEngine('detach');
			},

			recordsLoaded: function(event, data) {

                function Moneda(entrada){
                    var num = entrada.replace(/\./g,"");
                    if(!isNaN(num)){
                    num = num.toString().split("").reverse().join("").replace(/(?=\d*\.?)(\d{3})/g,"$1.");
                    num = num.split("").reverse().join("").replace(/^[\.]/,"");
                    entrada = num;
                    }else{
                    entrada = input.value.replace(/[^\d\.]*/g,"");
                    }
                    return entrada;
                }

            $(".jtable-main-container tr").find("td:eq(7)").each(function () {
                        $(this).text(Moneda($(this).text()));
            });
            $(".jtable-main-container tr").find("td:eq(8)").each(function () {
                        $(this).text(Moneda($(this).text()));
            });
            $(".jtable-main-container tr").find("td:eq(9)").each(function () {
                        $(this).text(Moneda($(this).text()));
            });
            $(".jtable-main-container tr").find("td:eq(10)").each(function () {
                        $(this).text(Moneda($(this).text()));
            });
            $(".jtable-main-container tr").find("td:eq(11)").each(function () {
                        $(this).text(Moneda($(this).text()));
            });
        },


              });


		  //Load person list from server
		  $('#jt_combustible').jtable('load');

		  //buscar por clientes
		  $('#btnBUSCAR').on('click', function(e) {
			e.preventDefault();
			$('#jt_combustible').jtable('load', {
			  nombreproducto: $('#nombreproducto').val(),
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
				var $selectedRows = $('#jt_combustible').jtable('selectedRows');
				$('#jt_combustible').jtable('deleteRows', $selectedRows);
				$(this).dialog("close");
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

		  //subir imagen atravez del dialogo 4

		  $("#pop_img").dialog({
			autoOpen: false,
			width: 500,
			height: 250,
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
			  }
			}
		  });

		});

		//ahora el control para el guardado de imagenes

		var options = {
		  beforeSend: function() {},
		  uploadProgress: function(event, position, total, percentComplete) {},
		  success: function() {

		  },
		  complete: function(response) {
			$("#pop_img").dialog("close");
			$("#img1").resetForm();
			$('#jt_ordenes').jtable('load');
		  },
		  error: function() {
			alert("ERROR: unable to upload files");

		  }

		};

		$("#img1").ajaxForm(options);

</script>

<div id="dialog" title="Basic dialog">
  <p>Desea eliminar</p> </div>
  
  <div id="dialog2">
  <div id="jt_prueba" style="width: 1200px;"></div>
</div>
  
<div id="pop_img" title="Subir Imagen">
    <center>
      <form name="img1" id="img1" action="upload.php" method="post" enctype="multipart/form-data">
    
            <input type="hidden" id="id_1" name="id_1" value=""/>
            <br/>
            <p>Subir Imagen de Respaldo</p>
            <input type="file" id="fila1" name="fila1" title="Seleccione un archivo" /><br/><br/>
            <button type="submit" name="btn_imagen" id="imagen">Guardar Imagen</button>
            
            </form></center>
	</div>

		
</body>
</html>