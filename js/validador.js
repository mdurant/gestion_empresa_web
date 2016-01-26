// JavaScript Document
$(document).ready(function () {

    // initialize tooltipster on text input elements
    $('#form input[type="text"]').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
	
	 $('#form input[type="text"]').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
		$.validator.addMethod("rut", function(value, element) {
  return this.optional(element) || $.Rut.validar(value);
}, "Este campo debe ser un rut valido.");	 
			 
			 $('#form').validate({
        errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            $(element).tooltipster('hide');
        }
			 });
			 
			 
			 //validar provincias
			 
			     // initialize tooltipster on text input elements
    $('#form_provincias input[type="text"]').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
	
	 $('#form_provincias select').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
		$.validator.addMethod("rut", function(value, element) {
  return this.optional(element) || $.Rut.validar(value);
}, "Este campo debe ser un rut valido.");	 
			 
			 $('#form_provincias').validate({
        errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            $(element).tooltipster('hide');
        }
			 });
			 
			 //validar paises
			 
			 $('#form_pais input[type="text"]').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
	
	 $('#form_pais select').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
		$.validator.addMethod("rut", function(value, element) {
  return this.optional(element) || $.Rut.validar(value);
}, "Este campo debe ser un rut valido.");	 
			 
			 $('#form_pais').validate({
        errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            $(element).tooltipster('hide');
        }
			 });
  
	//validar regiones
	
	 $('#form_region input[type="text"]').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
	
	 $('#form_region select').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
		$.validator.addMethod("rut", function(value, element) {
  return this.optional(element) || $.Rut.validar(value);
}, "Este campo debe ser un rut valido.");	 
			 
			 $('#form_region').validate({
        errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            $(element).tooltipster('hide');
        }
			 });
	
	//validar ciudades
	
	 $('#form_ciudad input[type="text"]').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
	
	 $('#form_ciudad select').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
		$.validator.addMethod("rut", function(value, element) {
  return this.optional(element) || $.Rut.validar(value);
}, "Este campo debe ser un rut valido.");	 
			 
			 $('#form_ciudad').validate({
        errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            $(element).tooltipster('hide');
        }
			 });
			 
			 //validar comunas
			 
			 
			 
	 $('#form_comunas input[type="text"]').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
	
	 $('#form_comunas select').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'right'
    });
		$.validator.addMethod("rut", function(value, element) {
  return this.optional(element) || $.Rut.validar(value);
}, "Este campo debe ser un rut valido.");	 
			 
			 $('#form_comunas').validate({
        errorPlacement: function (error, element) {
            $(element).tooltipster('update', $(error).text());
            $(element).tooltipster('show');
        },
        success: function (label, element) {
            $(element).tooltipster('hide');
        }
			 });
	

});