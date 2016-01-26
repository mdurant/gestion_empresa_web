// LA funcionalidad completa de gestion de compra

$(function(){
	
	$("#proyecto").select2();
	
    

      $(".btn-quitar").on('click', function(e) {
            e.preventDefault();

            var $TR=$(this).parent().parent();
            
            $TR.find('#cod_complete').val('').attr('value','').attr('disabled','disabled');
            $TR.find('#descri').val('').attr('value','').attr('disabled','disabled');
            $TR.find('#cantidad').val('').attr('disabled','disabled');
            $TR.find('#valor').val('').attr('disabled','disabled');

      });

   
	//$("#fcreacion").datepicker({});
	var creacion=$('#fecha_operacion').datepicker({dateFormat: 'dd-mm-yy'});
	creacion.on('changeDate', function(ev){
        // do what you want here
        creacion.datepicker('hide');
    });
	
	//trabajar con jtable
	
	$( "#dialog_btn-codigo" ).dialog({
              autoOpen: false,
			  width: 1300,
			  heigth: 700,
			  position:['middle',20],
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
					
        			$( this ).dialog( "close" );
                 
                }
			  }
          });
		
		//funcion para capturar el valor
		function valores()
		{
            valor.val(Dato);
            valor1.val(Dato2);
            valor3.val(Dato3);
            valor4.val(Dato4);
			valor5.val('');
			 $( "#dialog_btn-codigo" ).dialog( "close" );
		}
		
		$(".bsq").on('click',function(){
			
            var $tr=$(this).parent().parent().parent().parent().parent().parent().parent();
                
            valor = $tr.find("#cod_complete");
            valor1= $tr.find("#descri");
            valor3 = $tr.find("#bodega");
            valor4= $tr.find("#valor");
            valor5= $tr.find("#id_detalles");
            
            $("#dialog_btn-codigo").dialog("open");			
			
			
		});
			
			
			
			//*********************************************************************************************
			//******************************************************************************************
			
			$('#jt_servicios').jtable({
				jqueryuiTheme: true,
				title: 'Productos / Servicios',
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'IDProduct ASC',
				//selecting: true, //Enable selecting
            	//multiselect: true, //Allow multiple selecting
            	//selectingCheckboxes: true, //Show checkboxes on first column
            	//selectOnRowClick: true, //Enable this to only select using checkboxes
				actions: {
					listAction:		'productos_sql.php?action=list',
					createAction: 	'productos_sql.php?action=create',
					updateAction: 	'productos_sql.php?action=update',
					deleteAction: 	'productos_sql.php?action=delete'
				},
				fields: {
					 Capturar: {
				    title: '',
				    width: '2%',
				    sorting: false,
				    list: true,
					edit:false,
					create: false,
				    display: function (datos) {
					//Create an image that will be used to open child table
					var $img = $('<img src="../../toolbar-icon/abono.gif" style="cursor:pointer;" title="Capturar Producto / Servicio" />');
					$img.on("click",function () {
                            
                            
                                 
                  Dato=datos.record.CodeBar;
								  Dato2=datos.record.ProductName;
								  Dato3=datos.record.IDCellar;
								  Dato4=datos.record.UnitPrice;
								  valores();
								
   
                        });
                     return $img;
                        }
					 },
					IDProduct: {
						key: true,
						create: false,
						edit: false,
						list: false
					},
               		
          ProductName:
					{
						title: 'Servicio / Material',
						width: '20%',
						create: true,
						edit: true,
						list: true

					},
					CodeBar:
					{
						title: 'Código Servicio',
						width: '20%',
						create: true,
						edit: true,
						list: true

					},
					
          Estado:
          {
            title: 'Estado',
						width: '20%',
            options: {"inactivo":"inactivo","activo":"activo"},
						create: true,
						edit: true,
						list: false
                    
					
				},
                 
        });
			
				
			//Load person list from server
			$('#jt_servicios').jtable('load');
			
			//buscar por clientes
			 $('#btnBUSCAR').on('click',function(e) {
                    e.preventDefault();
                    $('#jt_servicios').jtable('load', {
                        nombreproducto: $('#nombre_ss').val(),
                        inactivo: $('#inactivo').val()
                    });
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