
function log(msj){
	console.log(msj);
} 

function addZero(i) {
    if (i < 10) {
        i = '0' + i;
    }
    return i;
}

function hoyFecha(){
    var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth()+1;
        var yyyy = hoy.getFullYear();
        
        dd = addZero(dd);
        mm = addZero(mm);
 
        return yyyy+'-'+mm+'-'+dd;
}

function invertir(cadena) {
  var x = cadena.length;
  var cadenaInvertida = "";
 
  while (x>=0) {
    cadenaInvertida = cadenaInvertida + cadena.charAt(x);
    x--;
  }
  return cadenaInvertida;
}

function setCharAt(str,index,chr) {
    if(index > str.length-1) return str;
    return str.substr(0,index) + chr + str.substr(index+1);
}

function cargaDatoArr(arrayDatos,divContenedor){

	//log('arrayDatos');
	//log(arrayDatos);
	var form = divContenedor==null?$(document):$(divContenedor);
	if(!$.isEmptyObject(arrayDatos)){

		$.each(arrayDatos, function( index, value ) {
			//log(index+' - '+value);
			var campo = form.find('#'+index);
			if(campo.is('select')){
				if(value){
					campo.val(value);
				}
			}else if(campo.is('textarea')){
				//log(index+' - '+value);
				if(value){
					campo.text(value);	
				}
			}else{
				//log(index+' - '+value);
				if(value){
					campo.attr('value',value);	
				}
				
			}
		});
	}
}

function cargaHtml(arrayDatos){
	//log('arrayDatos');
	//log(arrayDatos);
	var form = $(document);
	if(!$.isEmptyObject(arrayDatos)){

		$.each(arrayDatos, function( index, value ) {
			//log(index+' - '+value);
			var campo = form.find('#'+index);
			campo.html(value);
		});
	}
}

function cargaDatosMultiArr(arrayDatos){
	//log('arrayDatos');
	//log(arrayDatos);
	var form = $('form');
	if(!$.isEmptyObject(arrayDatos)){
		$.each(arrayDatos, function( it, fila ) {
			//log(fila);
			$.each(fila, function( index, value ) {
				//log(index+' - '+value);
				var campo = $(document).find('#'+index);
				if(campo.is('select')){
					campo.val(value);
				}else if(campo.is('textarea')){
					//log(index+' - '+value);
					campo.text(value);
				}else{
					//log(index+' - '+value);
					campo.attr('value',value);
				}
			});	
		});
	}
}

function submitAjax(url, datos,divMsj){
	//log(url+' - '+datos+' - '+divMsj);
	
	var json = ''; var redirect = '';
	//log('SUBMITAJAX');
	$.ajax( {
		type: "POST",
		url: url,
		data: datos,
		beforeSend: function( xhr ) {
    		$(divMsj).addClass('alert');
    		$(divMsj).addClass('alert-warning');
    		$(divMsj).html('Cargando...');
  		}
	})
	.done(function(data) {
		$(divMsj).attr('class','');
		if(data.length > 0)
		{
			json = data; //jQuery.parseJSON(data);
			
			if(json.status == 'error'){
				
				$(divMsj).html(json.mensaje);
				$(divMsj).addClass('alert');
		  		$(divMsj).addClass('alert-danger');

			}else{
				$(divMsj).addClass('alert');
		  		$(divMsj).addClass('alert-success');
				redirect = json.redirect;
			}
		}
	})
	.fail(function(data) {
		log('error');
		log(data);
		json = data; //jQuery.parseJSON(data);

		$(divMsj).css('display','block');
    	$(divMsj).html(json.mensaje);
	})
	.always(function(data) {
		log(data);
		json = data; //jQuery.parseJSON(data);
    	$(divMsj).html(json.mensaje);
    	
    	redirect = json.redirect;
    	if(redirect.length > 0){
    		window.location.href = json.redirect;
    		//$(location).attr('href', json.redirect);
    	}
	});
}

function submitCbo(url, datos, objcbo){
	//log(url+' - '+datos);
	var json = ''; var redirect = '';
	//log('DATOS -> '+datos);
	$.ajax( {
		type: "POST",
		url: url,
		data: {id: datos},
		beforeSend: function( xhr ) {
    		//$(divMsj).css('display','block');
    		//$(divMsj).html('Cargando...');
  		}
	})
	.done(function(data) {
		//log('done: '+data);
	})
	.fail(function(data) {
		log("error "+data);
		objcbo.val('');
		/*
		json = jQuery.parseJSON(data);
		$(divMsj).css('display','block');
    	$(divMsj).html(json.mensaje);
    	*/
	})
	.always(function(data) {
		//log("complete "+data);
		json = jQuery.parseJSON(data);
    	$.each(json, function(i,fila){
    		//console.log(fila);
    		objcbo.append($('<option>', { value: fila.tipo, text : fila.tipo }));
    	});
	});
}


