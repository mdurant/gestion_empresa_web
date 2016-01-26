<?php
require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

$id_user=$_SESSION['SESS_USER_ID'];//$_GET["ID_USER"];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Vistos Buenos Ordenes de Trabajo</title>

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

form.jtable-dialog-form {
  width:450px;
}
#btn
{
	cursor: pointer;
}



</style>
<body class="ui-widget">
<h4>Vistos Buenos Ordenes de Trabajo</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="85%" cellspacing="2" cellpadding="4">
	    <tbody><tr>
		<td width="40%">
		    <table width="100%">
			<tbody><tr>
			    <td><h5>Buscar</h5></td>
			    <td><input type="text" id="ordenes" name="ordenes" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
			</tr>
		    </tbody></table>
		</td>
		<td width="20%">
		    <table width="100%">
			<tbody><tr>
			    <td style="width: 110px; text-align: right"><h5 >Incluir Inactivos </h5></td>
			    <td style="width: 50px; text-align: center">
				  <input type="checkbox" id="inactivo" name="inactivo" value="1"/></td>
			</tr>
		    </tbody></table>
		</td>
		<td width="20%" align="center">
		    <button style="height: 30px; width: 100px" aria-disabled="false" role="button"
			    class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary"
			    id="btnBUSCAR" type="submit">
		    <span class="ui-icon ui-icon-search"></span>
		    <span class="ui-button-text">Buscar</span>
		</button></td>
	    </tr>
	</tbody>
    </table>
    </form>
</div>
<div style="height: 5px;width: 100%;"></div>


<div id="jt_ordenes" style="width: 100%;"></div>

        
	<script type="text/javascript">

		$(document).ready(function () {
		  
		    //Prepare jTable
			$('#jt_ordenes').jtable({
				jqueryuiTheme: true,
    			title: 'Listado',
    			paging: true,
    			pageSize: 10,
    			sorting: true,
    			openChildAsAccordion: true, //Enable this line to show child tabes as accordion style
				defaultSorting: 'id_orden ASC',
				selecting: false, //Enable selecting
            	multiselect: false, //Allow multiple selecting
            	selectingCheckboxes: false, //Show checkboxes on first column
            	//selectOnRowClick: true, //Enable this to only select using checkboxes
				actions: {
					listAction:'vbuenosql_sql.php?action=list'
				},
				fields: {
					id_orden: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					contador:
					{
						title: 'Número',
						width: '10%',
						create: true,
						edit: true,
						list: true

					},
					folio:
					    {
						title: 'Folio',
						width: '5%',
						create: false,
						edit:false,
						list: true
					    },
					 Cliente:
					    {
						title: 'Cliente',
						width: '15%',
						create: true,
						edit:true,
						list: true
					    },
					 vbueno1:
					      {
					      title: '1° Aprobación',
					      width: '10%',
					      create: true,
					      options:{"Aprobada":"Aprobada","Cancelada":"Cancelada"},
					      edit:true,
					      list: true
					  },
					usuario_1:
					{
						title:'Usuario',
						options:'vbuenosql_sql.php?action=Nombre',
						create: false,
						update: false,
						list: true
					},
					 vbueno2:
					    {
						title: '2° Aprobación',
						width: '10%',
						create: true,
						options:{"Aprobada":"Aprobada","Cancelada":"Cancelada"},
						edit:true,
						list: true
					    },
					usuario_2:
					{
						title:'Usuario',
						create: false,
						options:'vbuenosql_sql.php?action=Nombre',
						update: false,
						list: true
					},
					 vbueno3:
						{
						title: '3° Aprobación',
						width: '10%',
						create: true,
						options:{"Aprobada":"Aprobada","Cancelada":"Cancelada"},
						edit:true,
						list: true
						},
						usuario3:
					{
						title:'Usuario',
						create: false,
						options:'vbuenosql_sql.php?action=Nombre',
						update: false,
						list: true
					},
					VB1: {
						title: '',
						width: '1%',
						sorting: false,
						edit: false,
						create: false,
						display: function (datoss) {
						//Create an image that will be used to open child table
						var $img1 = $('<center><img src="../../toolbar-icon/uno.png" style="cursor:pointer;" title="Primer VB" /></center>');
					
						$img1.on("click",function(){
							id_vb1=datoss.record.id_orden;
							$("#vb1").val(datoss.record.vbueno1);
							
							$("#dialog1").dialog("open");
							
							});
						  return $img1;
						  }
					      },
					 VB2: {
						title: '',
						width: '1%',
						sorting: false,
						edit: false,
						create: false,
						display: function (datosss) {
						//Create an image that will be used to open child table
						var $img2 = $('<center><img src="../../toolbar-icon/dos.png" style="cursor:pointer;" title="Segundo VB" /></center>');
					
						$img2.on("click",function(){
							id_vb2=datosss.record.id_orden;
							$("#vb2").val(datosss.record.vbueno2);
							$("#dialog2").dialog("open");

							});
					      return $img2;
						 }
					     },
					 VB3: {
						title: '',
						width: '1%',
						sorting: false,
						edit: false,
						create: false,
						display: function (datossss) {
					      //Create an image that will be used to open child table
					      var $img3 = $('<center><img src="../../toolbar-icon/tres.png" style="cursor:pointer;" title="Tercer VB" /></center>');
					
						$img3.on("click",function(){
							id_vb3=datossss.record.id_orden;
							$("#vb3").val(datossss.record.vbueno3);
							$( "#pasa" ).dialog("open");
						//	$("#dialog3").dialog("open");

							});
						return $img3;
						   }
					       },
					  /*
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
                    */
					
					
				},
                //cuando se cierra el dialog
                 formClosed: function(event, data) {
                        $('#jt_ordenes').jtable('load');
                 }

        });
			
				
			//Load person list from server
			$('#jt_ordenes').jtable('load');
			
			//buscar por clientes
			 $('#btnBUSCAR').on('click',function(e) {
                    e.preventDefault();
                    $('#jt_ordenes').jtable('load', {
                        ordenes: $('#ordenes').val(),
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
	//control para los cambios de estados de las OT
						
	 $( "#dialog1" ).dialog({
	  autoOpen: false,
	  show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      },
      modal: true,
      buttons: {
        "Cancelar": function() {
		  vb1=$("#vb1").val("");
          $( this ).dialog( "close" );
        },
        "Aceptar": function() {
			  vb1=$("#vb1").val();
              vu="<?php echo $id_user ?>";
              $.ajax({
			
			async:true,
			type:"GET",
			dataType:"json",
//url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
			url:"vbuenosql_sql.php?action=vbueno1&id_vb="+id_vb1+"&vb1="+vb1+"&user="+vu,
			success: function(response){
			   //  alert(response);
			     $('#jt_ordenes').jtable('load');
                 $("#dialog1").dialog( "close" );
             }
             
        });
             
             
             
        }
      }
    });
	
	
	//visto bueno dos
	
	 $( "#dialog2" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      },
      modal: true,
      buttons: {
        "Cancelar": function() {
		  vb2=$("#vb2").val("");
          $( this ).dialog( "close" );
        },
        "Aceptar": function() {
			  vb2=$("#vb2").val();
              vu2="<?php echo $id_user ?>";
              $.ajax({
			
			async:true,
			type:"GET",
			dataType:"json",
//url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
			url:"vbuenosql_sql.php?action=vbueno2&id_vb="+id_vb2+"&vb2="+vb2+"&user2="+vu2,
			success: function(response){
			   //  alert(response);
			     $('#jt_ordenes').jtable('load');
                 $("#dialog2").dialog( "close" );
             }
             
        });
             
             
             
        }
      }
    });

		//visto bueno tres
		
		 $( "#dialog3" ).dialog({
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      },
      modal: true,
      buttons: {
        "Cancelar": function() {
		  vb3=$("#vb3").val("");
          $( this ).dialog( "close" );
        },
        "Aceptar": function() {
			  vb3=$("#vb3").val();
              vu3="<?php echo $id_user ?>";
              $.ajax({
			
			async:true,
			type:"GET",
			dataType:"json",
//url:"http://localhost/formularios_contacto/developer/developer-tormesol/crud/gestion_cotizacion/cotizacion_json.php",
			url:"vbuenosql_sql.php?action=vbueno3&id_vb="+id_vb3+"&vb3="+vb3+"&user3="+vu3,
			success: function(response){
			   //  alert(response);
			     $('#jt_ordenes').jtable('load');
                 $("#dialog3").dialog( "close" );
             }
             
        });
             
             
             
        }
      }
    });

			//subir imagen atravez del dialogo 4
			
			 $( "#pasa" ).dialog({
      autoOpen: false,
	  width: 500,
	  height: 250,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      },
      modal: true,
      buttons: {
        "Ingresar": function() {
            if($("#clav").val()!=$("#genero").text())
            {
                alert("Escribe bien");
            }else
            {
                 $( this ).dialog( "close" );
                 $("#dialog3").dialog("open");
            }
         
        }
      }
    });
 		                       
		});
        
		
		
		//ahora el control para el guardado de imagenes
		
		 var options = { 
    beforeSend: function() 
    {
    },
    uploadProgress: function(event, position, total, percentComplete) 
    {
    },
    success: function() 
    {
		 
    },
    complete: function(response) 
    {
        $("#dialog4").dialog("close");
		$("#img1").resetForm();
		$('#jt_ordenes').jtable('load');
    },
    error: function()
    {
        alert("ERROR: unable to upload files");
 
    }
 
  }; 
 
     $("#img1").ajaxForm(options);
        
      
</script>

	<div id="dialog1" title="OT">
			<center><select name="vb1" id="vb1" class="form-control input-sm ui-corner-all">
            	<option value="">--Seleecióne Estado--</option>
                <option value="Aprobada">Aprobada</option>
                <option value="Cancelada">Cancelada</option>
            </select></center>
	</div>
    
    <div id="dialog2" title="OT">
			<center><select name="vb2" id="vb2" class="form-control input-sm ui-corner-all">
            	<option value="">--Seleecióne Estado--</option>
                <option value="Aprobada">Aprobada</option>
                <option value="Cancelada">Cancelada</option>
            </select></center>
	</div>
    
    <?php
    function generateRandomString($length = 7) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++)
    {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
    }
    ?>
    
    <div id="pasa" title="Autentificacion">
        <center><h3 id="genero"><?php echo generateRandomString();?></h3></center>
        <center><label>Escriba la clave solicitada</label><br /></center>
        <center><input type="text" id="clav" name="clav" value=""  class="form-control input-sm ui-corner-all"/></center>
    </div>
    
    <div id="dialog3" title="OT">
		    <center><select name="vb3" id="vb3"  class="form-control input-sm ui-corner-all">
            	<option value="">--Seleecióne Estado--</option>
                <option value="Aprobada">Aprobada</option>
                <option value="Cancelada">Cancelada</option>
            </select></center>
	</div>
    

</body>
</html>