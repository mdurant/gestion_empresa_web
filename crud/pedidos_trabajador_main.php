<?php


require_once("../validatesession_html.php");


$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Insumos / Materiales Solicitados x Trabajador</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

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

<body class="ui-widget">

<h4>Insumos / Materiales Solicitados x Trabajador</h4>

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

            <td><input type="text" id="bsqrut" name="bsqrut" style="width:100%" placeholder="Buscar por RUT o Nombre Trabajor" class="form-control input-sm ui-corner-all"></td>
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
      </button>
        </td>
    </tr>
      </tbody>
  </table>
    </form>
</div>

<div style="height: 5px;width: 100%;"></div>

<div id="jt_pedidos_trabajador" style="width: 100%;"></div>



<style>

form.jtable-dialog-form 
{

  width:500px; 
  top:0px; 
}
</style>

<script type="text/javascript">

$(document).ready(function () {

  $('#jt_pedidos_trabajador').jtable({

    jqueryuiTheme: true,
    title: 'Listado General',
    paging: true,
    pageSize: 10,
    sorting: true,
    defaultSorting: 'id_operario',
    selecting: false,
    multiselect: true,
    selectingCheckboxes: true,
    actions: {
        listAction: 'pedidos_trabajador_sql.php?action=list'      
    },

     fields: {

        id_operario:{
          key: true,
          create: false,
          edit: false,
          list: false
        },
        operario:{
          title: 'Trabajador',
          width: '40%',
          list: true
        },
        cantidad:{
          title: 'Nº Solicitudes',
          width: '10%',
          list: true
        },
        estado:{
          title: 'Estado',
          width: '10%',
          list: true
        },

        pdf: {
          title: '',
          width: '1%',
          sorting: false,
          edit: false,
          create: false,
          display: function(datos) {
            //Create an image that will be used to open child table
            var $img = $('<center><button title="Ver Documento" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../toolbar-icon/pdf.gif" style="cursor:pointer;" title="" /></button></center>');
            $img.on("click", function()
            {
            //alert(datos.record.id_orden);
            window.open("../reportes/detalle_pedidos_trabajador.php?id_operario=" + datos.record.id_operario);
            });
            return $img;
            }
          }


     } //campos


  }); // jtable


$("#btnBuscar").on('click', function (e) {

  e.preventDefault();

});


$('#jt_pedidos_trabajador').jtable('load', {
          bsqrut: $('#bsqrut').val()
      
  });


});
  
</script>
</body>
</html>