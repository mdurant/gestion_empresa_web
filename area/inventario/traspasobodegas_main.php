<?php
require_once("../../validatesession_html.php");

$ACTUAL_THEME=$_SESSION['SESS_ACTUAL_THEME'];
$JTABLE_THEME=$_SESSION['SESS_JTABLE_THEME'];

require_once("../../conexion/funciones.php");
$res=new funciones();
$tra=$res->cargaAlmacen();


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"/>
<title>Traspaso desde Bodegas</title>

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

    <!-- jquery-barcode -->
	<script type="text/javascript" src="../../js/jquery-barcode.js"></script>
    

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
  
<h4>Traspaso desde Bodegas</h4>
<div class="ui-widget-content ui-corner-all" style="width: 100%; height: 45px ">
    <form style="margin: 0px">
    <table width="85%" cellspacing="2" cellpadding="4">
	    <tbody><tr>
		<td width="40%">
		    <table width="100%">
			<tbody><tr>
			    <td><h5>Buscar</h5></td>
			    <td><input type="text" id="nombreproducto" name="nombreproducto" style="width:100%" placeholder="" class="form-control input-sm ui-corner-all "></td>
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
  
  
 
<div id="jt_productos" style="width: 100%;"></div>

        
	<script type="text/javascript">

		$(document).ready(function () {
		    //Prepare jTable
			$('#jt_productos').jtable({
				jqueryuiTheme: true,
				title: 'Traspaso de Productos Bodegas',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'id_productos ASC',
				selecting: true, //Enable selecting
            	multiselect: true, //Allow multiple selecting
            	selectingCheckboxes: true, //Show checkboxes on first column
            	//selectOnRowClick: true, //Enable this to only select using checkboxes
				actions: {
					listAction:		'traspasobodegas_sql.php?action=list'
				},
				fields: {
					id_productos: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
					ProductName:
					{
						title: 'Nombre Producto',
						width: '20%',
						create: true,
						edit: true,
						list: true

					},
                    stock: {
						title: 'Stock',
						width: '20%',
						create: true,
						edit: true,
						list: true
					},
					id_bodega:
                    {
                        title: 'Bodega',
						width: '20%',
                        options:'traspasobodegas_sql.php?action=Nombre',
						list: true
                    },
                    descripcion: {
						title: 'Descripción',
						width: '20%',
						create: true,
						edit: false,
						list: true
					},
					id_product:
					{
						title:"",
						list: false,
						create: false,
						edit:false
					},
					precio_compra:
					{
						title:"",
						list: false,
						create: false,
						edit:false
					},
					precio_venta:
					{
						title:"",
						list: false,
						create: false,
						edit:false
					},
					Traspaso: {
				    title: '',
				    width: '1%',
				    sorting: false,
				    edit: false,
				    create: false,
				    display: function (datos) {
					//Create an image that will be used to open child table
					var $img = $('<center><img src="../../toolbar-icon/abono.gif" style="cursor:pointer;" title="Traspaso" /></center>');
					
						$img.on("click",function(){
							
							id_pro=datos.record.id_productos;
							pro_name=datos.record.ProductName;	
							otro_id=datos.record.id_product;
							descripcione=datos.record.descripcion;
							compra=datos.record.precio_compra;
							venta=datos.record.precio_venta;					
							
							$("#dialog").dialog("open");
							});
                     return $img;
                        }
                    },
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
					
				}
			
        });
			
				
			//Load person list from server
			$('#jt_productos').jtable('load');
			
			//buscar por clientes
			 $('#btnBUSCAR').on('click',function(e) {
                    e.preventDefault();
                    $('#jt_productos').jtable('load', {
                        nombreproducto: $('#nombreproducto').val(),
                        inactivo: $('#inactivo').val()
                    });
        });
			//eliminar
			 // $('#DeleteAllButton').click(function () {
    //         var $selectedRows = $('#PeopleTableContainer').jtable('selectedRows');
    //         $('#PeopleTableContainer').jtable('deleteRows', $selectedRows);
    //     });
		

	

		//Initialize validation logic when a form is created
           
 		 $( "#dialog" ).dialog({
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
        			$("#cantidad").val("");
					$("#bodegas").val("");
                  $( this ).dialog( "close" );
                },
                "Traspasar": function() {
					alamcens=$("#bodegas").val();
					canti=$("#cantidad").val();
            		  $.ajax({
			
						async:true,
						type:"GET",
						dataType:"json",
						url:"traspasobodegas_sql.php?action=update&id_prod="+id_pro+"&pro_name="+pro_name+"&almacen="+alamcens+"&canti="+canti+"&otro="+otro_id+"&descripcione="+descripcione+"&compra="+compra+"&venta="+venta,
						success: function(response){
						   //  alert(response);
							   	$('#jt_productos').jtable('load');
                      			$("#dialog").dialog( "close" );
								$("#cantidad").val("");
					$("#bodegas").val("");
						 }
					});
				}
			  }
			  
          });
    
         
   
 
 $('#inactivo').on('change', function() { 
    // From the other examples
    if (!this.checked) {
         $('#inactivo').val("1");
    }else
    {
        $('#inactivo').val("2");
    }
});

        
 		                       
		});
        
        
      
	</script>

	<div id="dialog" title="Traspasar Productos">
  		<table>
        	<tr>
            	<td><label>Cantidad:</label></td>
                <td><input type="text" name="cantidad" id="cantidad" value="" class="form-control input-sm ui-corner-all"/></td>
            </tr>
            <tr>
            	<td><label>Bodega:</label></td>
                <td><select name="bodegas" id="bodegas" class="form-control input-sm ui-corner-all">
                	<option value="">--Seleccione--</option>
                    <?php
					for($i=0;$i<sizeof($tra);$i++)
					{
					?>
                    <option value="<?=$tra[$i]["IdAlmacen"]?>"><?=$tra[$i]["Descripcion"]?></option>
                    <?php
					}
					?>
                </select></td>
            </tr>
        </table>
</div>

<div id="dialog2">
		
</div>

</body>
</html>