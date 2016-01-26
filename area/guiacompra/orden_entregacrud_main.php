<?php
require_once("../../validatesession_html.php");
require_once("../../conexion/conexion.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

$id_orden = $_GET['id_orden'];

$sql=<<<QUERY
		SELECT
		eorden.contador,
		DATE_FORMAT(eorden.fecha_entrega,'%d-%m-%Y') as fecha_entrega,
		customers.Cliente
		FROM eorden
		INNER JOIN customers ON eorden.id_cliente = customers.IDCliente
        WHERE
		eorden.id_orden=$id_orden;
QUERY;

$msgerror="";
try
{  $result = mysql_query($sql,conectar::con());	} 
catch(Exception $ex){	$result=0; $msgerror=$ex;}

$vRESP=$result;
if ($result)
{ 	$vRESP="OK"; $vMENSAJE = "ordenes :: buscar :: OK!";	}
else
{	$vRESP="ERROR"; $vMENSAJE = "ordenes :: buscar :: SQLERROR -> $msgerror ".$fin."-> $sql";};

//die($vRESP." -> ".$sql);


if ($vRESP="OK"){
	
	$rows = array();
	while($row = mysql_fetch_array($result)) { $rows[] = $row; }
	
}else{
	die($vRESP." -> ".$vMENSAJE);
}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Gestion de Ordenes de Trabajo</title>

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
<h4>Entrega de Productos</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="100%" cellspacing="2" cellpadding="4">
	    <tbody>
			<tr>
				<td width="5%"><h5>Folio O.T.</h5></td>
				<td width="10%"><input type="text" value="<?=$rows[0]["contador"]?>" id="txtFOLIOOT" name="txtFOLIOOT" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all " disabled></td>
				<td width="5%" align="center"><h5>Cliente</h5></td>
				<td width="20%"><input type="text" value="<?=$rows[0]["Cliente"]?>" id="txtCLIENTE" name="txtCLIENTE" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all " disabled></td>
				<td width="8%" align="center"><h5>Fecha Entrega</h5></td>
				<td width="10%"><input type="text" value="<?=$rows[0]["fecha_entrega"]?>" id="txtFECHAENTREGA" name="txtFECHAENTREGA" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all " disabled></td>
			</tr>
		</tbody>
    </table>
    </form>
</div>
<div style="height: 5px;width: 100%;"></div>


<div id="jt_ordenesdet" style="width: 100%;"></div>
<div id="jt_ordenesdet_entrega" style="width: 100%;"></div>

<div id="pie">
			
	<table border="0" class="table table-condensed table-bordered" cellspacing="2">
		<tr>
			<td width="100%" align="left"><button type="button" class="btn btn-default" name="btn-volver" id="btn-volver"  value="">Volver</button></td>
		</tr>

	</table>


	</div>       
<script type="text/javascript">
	
		var record="";
	
		$(document).ready(function() {

			$("#btn-volver").on("click", function() {
	  
				window.location="ordencrud_main.php";
			});
	  
			$('#jt_ordenesdet').jtable({
				jqueryuiTheme: true,
				title: 'Productos de la O.T.',
				paging: true,
				pageSize: 5,
				sorting: true,
				openChildAsAccordion: true,
				selecting: true,
				multiselect: false,
				selectingCheckboxes: false,		
				defaultSorting: 'id_dorden ASC',
				actions: {
					listAction: 'ordendet_sql.php?action=list&id_orden=<?=$id_orden?>',
				},
				fields: {
					id_orden: {
						type: 'hidden'
					},
					id_dorden: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					posicion: {
						title: 'Posición',
						width: "5%",
						list: true
					},
					Codigo: {
						title: 'Código',
						width: '7%',
						create: true,
						edit: true,
						list: true
					},
					descripcion: {
						title: 'Descripción',
						width: '42%',
						create: true,
						edit: true,
						list: true
					},
					cantidad: {
						title: 'Cantidad',
						width: '8%',
						create: true,
						edit: false,
						list: true
					},
					entregado: {
						title: 'Entregado',
						width: '8%',
						create: false,
						edit: false,
						list: true
					},
					Descripcion: {
						title: 'Almacen',
						width: '20%',
						list: true
					}
				},

				selectionChanged: function(event, data) {
					
					var $selectedRows = $('#jt_ordenesdet').jtable('selectedRows');
					$selectedRows.each(function () {
						record = $(this).data('record');
					});
					
					$('#jt_ordenesdet_entrega').jtable('load',{
						
						IDPerfil:record.id_dorden,
						Codigo:record.Codigo
						
					});
	
				}

			});
			$('#jt_ordenesdet').jtable('load');

			$('#jt_ordenesdet_entrega').jtable({
				jqueryuiTheme: true,
				title: 'Productos Entregados',
				paging: true,
				pageSize: 5,
				sorting: true,
				openChildAsAccordion: true,
				selecting: true,
				multiselect: false,
				selectingCheckboxes: false,		
				defaultSorting: 'id_entrega ASC',
				actions: {
					listAction: 'ordenstocksql_sql.php?action=list', //&IDPerfil=' + datos.record.id_dorden,
					createAction: 'ordenstocksql_sql.php?action=create' //&Codigo=' + datos.record.Codigo

				},
				fields: {
					id_dorden: {
						type: 'hidden'
					},
					Codigo: {
						type: 'hidden'
					},
					entregado: {
						type: 'hidden'
					},
					cantidad: {
						type: 'hidden'
					},
					id_entrega: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					responsable_entrega: {
						title: 'Responsable Entrega',
						width: '7%',
						create: true,
						edit: true,
						list: true
					},
					receptor: {
						title: 'Receptor Materiales',
						width: '7%',
						create: true,
						edit: true,
						list: true
					},
					cantidad_entrega: {
						title: 'Cantidad',
						width: '10%',
						create: true,
						edit: true,
						list: true
					},
					fecha_entrega: {
						title: 'Fecha Entrega',
						width: '10%',
						type: 'date',
						displayFormat: 'dd-mm-yy',
						create: false,
						edit: false,
						list: true
					},
					total_suma: {
						create: false,
						edit: false,
						list: true
					}
				},
				formCreated: function(event, data) {
		
					$(".ui-dialog").css("top", "0px");
					$("#ui-id-5, #ui-id-3").css('height', '350px').css('overflow-y', 'scroll').css('overflow-x', 'hidden');
					$("#EditDialogSaveButton, #AddRecordDialogSaveButton").attr('class', 'btn btn-primary ui-corner-all');
		
					$("form input, form textarea, form select").attr('class', 'form-control input-sm ui-corner-all');
		
		
					$("#Edit-id_dorden").attr('value', record.id_dorden);
					$("#Edit-Codigo").attr('value', record.Codigo);
					$("#Edit-entregado").attr('value', record.entregado);
					$("#Edit-cantidad").attr('value', record.cantidad);
										

					
				},
				formSubmitting: function(event, data) {
					
					var $entregado=$("#Edit-entregado").attr('value');
					var $cantidad=$("#Edit-cantidad").attr('value');
					var $cantidad_entrega=data.form.find('input[name="cantidad_entrega"]');
					
					alert($entregado);
					alert($cantidad);
					alert($cantidad_entrega);
					
					
					
					if ($cantidad_entrega>($cantidad-$entregado)) {
						
						alert('La cantidad a entregar no debe superar los '+($cantidad-$entregado)+' productos.');
					
						//code
					}
					
				},
				//cuando se cierra el dialog
				formClosed: function(event, data) {
					$('#jt_ordenesdet_entrega').jtable('load',{
						
						IDPerfil:record.id_dorden,
						Codigo:record.Codigo
						
					});
                    $('#jt_ordenesdet').jtable('load');
				}

			});

			$('#jt_ordenesdet_entrega').jtable('load',{
						
				IDPerfil:0,
				Codigo:''
						
			});

	});
		
</script>

</body>
</html>