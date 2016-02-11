<?php
require_once("../validatesession_html.php");
//require_once("../conexion/conexion.php");
// require_once("../validatesession_json.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

require_once("select_movimientos_productos.php");

$tra=new select();
$res = $tra->code_autocomplete();

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Comportamiento de Productos</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">


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


</head>
<style>

form.jtable-dialog-form {
  width:300px;
}
#btn
{
	cursor: pointer;
}
.jtable-title-text{

 text-align: center;
 color: #428bca;
 font-weight: bolder;

}
.jtable-title{
	background-color:#356B36;
}

</style>
<body class="ui-widget">

<h4>Comportamiento de Productos</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="100%" cellspacing="2" cellpadding="4">
	    <tbody><tr>
		<td width="40%">
		    <table width="100%">
			<tbody><tr>
			    <td><h5 style="width:30px">Buscar </h5></td>
			    <td><input type="text" id="nombreproducto[]" value ="" name="nombreproducto" style="width:100%" placeholder="Nombre del Producto" class="form-control input-sm caja_cod cod typeahead cod_complete" data-provide="typeahead"></td>

			</tr>
		    </tbody>
		    </table>

		</td>

		<td width="20%" align="center">
	    <button style="height: 30px; width: 100px" aria-disabled="false" role="button"
		    class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary"
		    id="btnBUSCAR" type="submit">
	    <span class="ui-icon ui-icon-search"></span>
	    <span class="ui-button-text">Buscar</span>

		</button></td>

			<!-- <td><button type="button" class="btn btn-success" style="float:right;"><i class="fa fa-file-excel-o"></i>  Exportar Excel</button></td> -->
	    </tr>
	</tbody>
    </table>
    </form>
</div>
<div style="height: 5px;width: 100%;"></div>
<div class="row">
	<div class="col-md-6">
		<div id="jt_mov_productos"></div>
	</div>
	<div class="col-md-6">
		<div id="jt_mov_productos_salida"></div>
	</div>
</div>


<script type="text/javascript">

$(document).ready(function () {
	var availableTags = <?=json_encode($res);?>;
$(".cod_complete").autocomplete({
	source: availableTags
 	});



	//Jtable Entrada de Productos
	    $('#jt_mov_productos').jtable({
		    jqueryuiTheme: true,
		    title: 'Movimiento Entradas',
		    paging: true,
		    pageSize: 10,
		    sorting: true,
		    defaultSorting: 'id_ecompra ASC',
		    selecting: true, //Enable selecting
		    multiselect: true, //Allow multiple selecting
		    selectingCheckboxes: true, //Show checkboxes on first column
		    //selectOnRowClick: true, //Enable this to only select using checkboxes
		    toolbar: {
		    	items: [{
		    		icon :'excel.png',
		    		text : 'Exportar Excel',
		    		click : function(){
		    			document.location.href = 'movimientos_productos_sql.php?action=exportar-excel';
		    		}
		    	}]

		    },
		    actions: {
			    listAction:	  'movimientos_productos_sql.php?action=list'
		    },
		    fields: {
			    id_ecompra: {
				    key: true,
				    list: false
			    },
			    proveedor:
			    {
				    title: 'Proveedor',
				    width: '13%',
				    list: true

			    },
			    fecha_ingreso:
			    {
				    title: 'Fecha Ingreso',
				    width: '10%',
				    create: true,
				    type: 'date',
            displayFormat: 'dd-mm-yy'

			    },
			    folio_interno: {
				    title: 'Folio Interno',
				    width: '5%',
				    list: true

			    },
			    cantidad:{
						title: 'Entrada',
				    width: '3%',
				    list: true
			    },

					neto:{
						title: 'Valor Compra ($)',
				    width: '5%',
				    list: true
			    },



		    },


	    });

	  	//Jtable Salida Productos
	    $('#jt_mov_productos_salida').jtable({
		    jqueryuiTheme: true,
		    title: 'Movimiento Salidas',
		    paging: true,
		    pageSize: 10,
		    sorting: true,
		    defaultSorting: 'id_esolicitud ASC',
		    selecting: true, //Enable selecting
		    multiselect: true, //Allow multiple selecting
		    selectingCheckboxes: true, //Show checkboxes on first column
		    //selectOnRowClick: true, //Enable this to only select using checkboxes
		    toolbar: {

			  items: [{
		    		icon :'excel.png',
		    		text : 'Exportar Excel',
		    		click : function(){
		    			//alert ("holaaa");
		    			window.location = 'movimientos_productos_sql.php?action=exportar-excel';

		    		}
		    	}]
		    },
		    actions: {
			    listAction:	  'movimientos_productos_salida_sql.php?action=list'
		    },
		    fields: {
			    id_esolicitud: {
				    key: true,
				    list: false
			    },
			    nombre_proyecto:
			    {
				    title: 'Proyecto Asociado',
				    width: '20%',
				    list: true

			    },
			    fecha_sol:
			    {
				    title: 'Fecha Solicitud',
				    width: '10%',
				    create: true,
				    type: 'date',
            displayFormat: 'dd-mm-yy'

			    },
			    contador: {
				    title: 'Folio Interno',
				    width: '5%',
				    list: true

			    },
			    cantidad:{
						title: 'Salida',
				    width: '3%',
				    list: true
			    },

					Cliente:{
						title: 'Cliente',
				    width: '20%',
				    list: true
			    },



		    },


	    });

	    //load data master movimiento productos (entrada-salida)
	    $('#jt_mov_productos').jtable('load');
	    $('#jt_mov_productos_salida').jtable('load');

	    //buscar por clientes
	    $('#btnBUSCAR').on('click',function(e) {
		    e.preventDefault();
		 		// console.log($('.cod_complete').val())

	    $('#jt_mov_productos').jtable('load', {
			nombreproducto: $('.cod_complete').val()

		    });
	    $('#jt_mov_productos_salida').jtable('load', {
			nombreproducto: $('.cod_complete').val()

		    });
	    });

    });



</script>

</body>
</html>