<?php
require_once("../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

    $desde=date('d-m-Y',strtotime('-30 day')); 
    $hasta=date("d-m-Y");  

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Reporte Pagos x Rango Fechas</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <script src="../scripts/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    <link  href="../scripts/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- jquery -->
    <script src="../scripts/jquery/jquery.js" type="text/javascript"></script>
    <script src="../scripts/jquery/jquery-ui.js" type="text/javascript"></script>
    <link  href="../scripts/jquery/themes/<?=$ACTUAL_THEME?>/jquery-ui.css" rel="stylesheet" type="text/css" />

    <!-- jtable -->
    <script src="../scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
    <script src="../scripts/jtable/jquery.jtable.es.js" type="text/javascript"></script>
    <script src="../scripts/jquery/jquery-ui.datepicker-es.js" type="text/javascript"></script>
    <link  href="../scripts/jtable/themes/<?=$JTABLE_THEME?>" rel="stylesheet" type="text/css" />

</head>

<body class="ui-widget">

<h4>Reporte Pagos x Rango Fechas</h4>

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
            <td style="width: 50px;text-align: center"><h5 style="width:50px">Desde</h5></td>
                  <td><input type="text" id="inicio" name="inicio" class="form-control input-sm ui-corner-all  hasDatepicker" value="<?=$desde?>"></td>
                  <td style="width: 50px;text-align: center"><h5 style="width:50px">Hasta</h5></td>
                  <td><input type="text" id="fin" name="fin" class="form-control input-sm ui-corner-all  hasDatepicker" value="<?=$hasta?>"></td>
                  <td align="center">
                  <button type="submit" id="btnHOY" class="ui-button ui-widget ui-state-default ui-corner-all" role="button" aria-disabled="false" style="height: 30px; width: 40px">Hoy
                  </button>
            </td>

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


<div id="jt_pago_rango_fechas" style="width: 100%;">
  
</div>

<script type="text/javascript">

    $("#inicio").datepicker({
      dateFormat: 'dd-mm-yy'
    });
    $("#fin").datepicker({
      dateFormat: 'dd-mm-yy'
    });

       

  $(document).ready(function() {

   $("#inicio").datepicker({
  dateFormat: 'dd-mm-yy'
  });
  $("#fin").datepicker({
    dateFormat: 'dd-mm-yy'
  });


      $('#jt_pago_rango_fechas').jtable({
    jqueryuiTheme: true,
    title: 'Listado General',
    paging: true,
    pageSize: 10,
    sorting: true,
    defaultSorting: 'id_compromiso_proveedores ASC',
    selecting: true,
    multiselect: true,
    selectingCheckboxes: true,
    actions: {
        listAction: 'pagos_rango_fechas_sql.php?action=list'      
    },
   
    fields: {
        id_compromiso_proveedores: {
      key: true,
      create: false,
      edit: false,
      list: false
        },

        folio_factura: {
      title: 'Folio Factura',
      width: '10%',
      list: true

        },

        Suppliers: {
      title: 'Proveedores',
      width: '30%',
      list: true
        },    

        total: {
      title: 'Total Factura',
      width: '10%',
      list: true
        },  

        estadocontable: {
      title: 'Tipo Operación',
      width: '10%',
      list: true
        },

        fecha_compromiso: {
      title: 'Fecha Compromiso',
      width: '10%',
      list: true,
      type:'date',
      displayFormat: 'dd-mm-yy'
      
        },


        Es:{
      title: 'Pago',
      width: '1%',
      sorting: false,
      edit: false,
      create: false,
      list: true,
        display: function(datos) {

                //Create an image that will be used to open child table
          if(datos.record.estadocontable == "PENDIENTE PAGO")
            {
            
              var $img = $('<center><button title="Estado de Pago" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../toolbar-icon/Rojo.png" style="cursor:pointer;" title="" /></button></center>');
                    
              return $img;
            }else
            {
              var $img = $('<center><button title="Estado de Pago" class="btn btn-default btn-sm ui-corner-all" type="button" ><img src="../toolbar-icon/Verde.jpg" style="cursor:pointer;" title="" /></button></center>');

              $img.on("click", function()
             {

              });
              return $img;
                }

              return $img;
                
                }
            },
            
    },
    
    formCreated: function(event, data) {

       
      
    },

    recordsLoaded: function(event, data) {

      
          $('#jt_pago_rango_fechas tbody tr').each(function()
          {
            if($(this).find('td:eq(4)').text()=="PENDIENTE PAGO")
            {
              $(this).css("background", "#F2DEDE");
            }else{

            }
          });
      },


      });

        
      $('#jt_pago_rango_fechas').jtable('load', undefined, function(){    

          
          $('#jt_pago_rango_fechas tbody tr').each(function()
          {
            if($(this).find('td:eq(6)').text()=="PENDIENTE PAGO")
            {
              $(this).css("background", "#F2DEDE");
            }else{

            }
          });
          
          
    });

    
      
      $('#btnBUSCAR').on('click', function(e) {
    e.preventDefault();

      $('#jt_pago_rango_fechas').jtable('load', {
          bsqrut: $('#bsqrut').val()
      }, function(){
        $('#jt_pago_rango_fechas tbody tr').each(function()
          {
            if($(this).find('td:eq(5)').text()=="PENDIENTE PAGO")
            {
              $(this).css("background", "#F2DEDE");
            }else{

            }
          });
          
      });
      });




      $("#documentar").dialog({
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
        $("#cantidad_cheques").val(1);
        totsum = 0;
        $("#jt_pago_rango_fechas").find(".jtable-selecting-column > input").prop("checked", false);
        $("#jt_pago_rango_fechas tr").removeClass("jtable-row-selected ui-state-highlight");
        $("#cheques").html("");
        $("#voucher").html("");
        $("#cheques").append('<label>Fecha de Pago Cheque 1 : </label><input type="text" class="form-control" id="c1"/>');
        $("#voucher").append('<label>Comprobante 1 : </label><input type="text" class="form-control" id="v1"/>');
        $( "#c1").datepicker({dateFormat: 'dd-mm-yy'});
        },
        "Documentar": function() {
        var $selectedRows = $('#jt_pago_rango_fechas').jtable('selectedRows');



        fechaCompromiso = "";
        codigoVoucher ="";
        
        var cantChe2 = parseInt($("#cantidad_cheques").val()) + parseInt(1);
          for(var i=1;i<cantChe2;i++)
        {
          
            fechaCompromiso += $("#c"+i).val()+',';
            codigoVoucher += $("#v"+i).val()+',';
            
          
        }

        idEcompra = "";
        montoCuota = parseInt(totsum) / parseInt($("#cantidad_cheques").val()).toFixed(0);
        tipo_compromiso = $("#tipo_documento").val();
        IDsuppliers = "";
        IDUser = <?=$_SESSION['SESS_USER_ID']?>;
        TotalCheques = $("#cantidad_cheques").val();
        

        $selectedRows.each(function () {
          var record = $(this).data('record');          
          idEcompra+= record.id_ecompra+",";
          IDsuppliers += record.IDsuppliers+",";
        });


        $.ajax({
            cache: false,
            type: "POST",
            url: "./check_proveedores_sql.php?action=documentar",
            data: {"idEcompra" : idEcompra, "fechaCompromiso": fechaCompromiso, "IDsuppliers" : IDsuppliers, "montoCuota": montoCuota, "tipo_compromiso": tipo_compromiso, "IDUser": IDUser, "TotalCheques": TotalCheques,"codigoVoucher":codigoVoucher},
              success: function(data){
              //  alert(data.codigoVoucher);
              $('#jt_pago_rango_fechas').jtable('load');
              $('#jt_pago_rango_fechas tbody tr').each(function()
              {
                if($(this).find('td:eq(5)').text()=="PENDIENTE PAGO")
                {
                  $(this).css("background", "#F2DEDE");
                }else{

                }
              });
          
              //muestra la query en pantalla
              //alert(data);

                }
        });
        $(this).dialog("close");
        $("#cantidad_cheques").val(1);
        totsum = 0;
        }
    }
      });

      $("#error").dialog({
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
        "Cerrar": function() {
      $(this).dialog("close");
        }       
    }
      });


      $("#cantidad_cheques").on("change", function(){
        $('#valorCheque').html("");
        $('#valorCheque').append(Moneda((totsum / $(this).val()).toFixed(0)).toString());

        alert("Los cheques son de : $ "+Moneda((totsum / $(this).val()).toFixed(0)));
        
        $("#cheques").html("");
        $("#voucher").html("");
        var cantChe = parseInt($(this).val()) + parseInt(1);
        for(var i=1;i<cantChe;i++)
        {         
          $("#cheques").append("<label>Fecha de Pago Cheque "+i+" : </label><input type='text' class='form-control' id='c"+i+"' /><br>");
          $("#voucher").append("<label>Comprobante "+i+" : </label><input type='text' class='form-control' id='v"+i+"' /><br>");

          $( "#c"+i).datepicker({dateFormat: 'dd-mm-yy'});
        }
      });

      $( "#c1").datepicker({dateFormat: 'dd-mm-yy'});


                   

      

    

  });
</script>




</body>
</html>