
const DEFTIPOTC = 1;
const TM_USD = 'USD';
const TM_CLP = 'CLP';

function getGridSize() {
    return (window.innerWidth < 600) ? 2 :
           (window.innerWidth < 900) ? 3 : 4;
}

var flexslider = { vars:{} };

$(document).ready(function(){
	
});

function limpiar(frm){
	$('input[type=text]', frm).each(function (i) {
		$(this).val("");
	});

	$('input[type=email]', frm).each(function(i){
		$(this).val("");
	});

	$('textarea', frm).each(function(i){
		$(this).val("");
	});
}

function contacto(form, divMsj, ruta){
	var campos = $(form).serialize();
	var noErrores = 0;

	grecaptcha.ready(function() {
      grecaptcha.execute('6LeV480ZAAAAAH15AZpw7tRYqoKBxjabT5QwvEuk', {action: 'submit'}).then(function(token) {

          // Add your logic to submit to your backend server here.
          $.post( 
			ruta, 
			campos,
			function( data ) {
				if(data.rspt=='1')
				{
					$('.msjFrmContacto').addClass('alert alert-success');
					$('.msjFrmContacto').html(data.msj);
					setTimeout("$('.msjFrmContacto').removeClass('alert alert-success'); $('.msjFrmContacto').html(''); $('.error').remove();", 5000);
					limpiar(form);
				}else{
					$('.msjFrmContacto').addClass('alert alert-danger');
					$('.msjFrmContacto').html('ERROR: Debe revisar los datos ingresados en el formulario.');
					setTimeout("$('.msjFrmContacto').removeClass('alert alert-danger'); $('.msjFrmContacto').html(''); $('.error').remove();", 5000);
					//var msj = $('.msj-error').html();
				}
			}
		); 

      });
    });
}

function redireccion(url){
	$(location).attr('href', url);
}

function submitAjax(url, datos ,divMsj, swredirec){
	//log(url+' - '+datos+' - '+divMsj+' - '+swredirec);
	$('.lblError').remove();
	var sw = typeof(swredirec)==='undefined'? false:swredirec;
	
	var objBtn = $('button');
	var objMsj = $(divMsj);

	var resultado = '';
	var json = ''; var redirect = '';

	$.ajax( {
		type: "POST",
		url: url,
		data: datos,
		beforeSend: function( xhr ) {
			var objMsj = $(divMsj);
			objBtn.find('i').attr('class','fa fa-refresh fa-spin fa-fw');
			objBtn.prop('disabled',true);
    		objMsj.addClass('alert alert-warning');
    		objMsj.html('Cargando...');
  		}
	})
	.done(function(json) {
		log('done: ');
		var objMsj = $(divMsj);
		objMsj.removeClass();

		if(json.estado == '2'){
			objMsj.addClass('alert alert-danger');
			objBtn.prop('disabled',false);
			objBtn.find('i').attr('class','fa fa-send');
		}else{
			objMsj.addClass('alert alert-success');	
		}
		
    	objMsj.html(json.msj); //json.msj - 'Los datos fueron enviados con exito!.'

	})
	.fail(function(data) {
		//log("error");
		log(data);
		var objMsj = $(divMsj);
		objMsj.html('ERROR: Consulte con el administrador de Sistemas.');
		objMsj.addClass('alert alert-danger');
		objBtn.find('i').attr('class','fa fa-send');
		objBtn.prop('disabled',false);

	})
	.always(function(json) {
		//log(json);
		//log( "complete: "+json.redirec+" - "+sw);
		var objMsj = $(divMsj);
		//if(json.status == '2'){
			objBtn.find('i').attr('class','fa fa-send');
			objBtn.prop('disabled',false);
		//}

		if (typeof(json.redirec) !== "undefined")
		{
			var redirect = json.redirec;
		}else{
			var redirect = '';
		}

    	if(sw == true)
    	{
    		bootbox.confirm({
			    message: "<h4>"+json.msj+"</h4>",
			    buttons: {
			        confirm: {
			        	className: 'btn-success',
			            label: '<i class="fa fa-check"></i> OK'
			        }
			    },
			    callback: function () {
			        if(redirect.length > 0){
	    				redireccion(redirect);
    				}
			    }
			});
    	}else{
    		
    		setTimeout("var objMsj = $(divMsj); objMsj.hide('slow');",3500 );
    		if(redirect.length > 0){
				redireccion(redirect);
			}
    	}
    	
	});
	return resultado;
}


var $window = $(window), flexslider = { vars:{} };

// tiny helper function to add breakpoints
function getGridSize() {
	return (window.innerWidth < 600) ? 2 :
       (window.innerWidth < 900) ? 3 : 4;
}

function log(msj){
	console.log(msj);
} 

var urlActionKP = '';
function redirectKP(){
	window.location.href = urlActionKP;
}

MyApp = {
	Main : {
		init : function()
		{
  			$('[data-toggle="tooltip"]').tooltip();
  			//$('.navbar-toggler-icon').append('<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>');	
		}
	},

	validatoken : {
		init : function(){

			$('.btn-sendtoken').on('click', function(e){
				e.preventDefault();
				var action = $(this).data('action');
				var celular = $('#celular').val();
				var datos = {celular};
				var msj = '';
				submitAjax(action,datos,msj,true);
			});

			$("#frm-token").validate({
				// Specify validation rules
				rules: {
					celular: {
							required: true,
							minlength: 9,
							maxlength: 12,
					},
					token: {
							required: true,
							minlength: 6,
							maxlength: 6
					}
				},
				// Specify validation error messages
				messages: {
					celular: {
						required: "Debe ingresar su # de Celular",
						minlength: "Debe contener minimo 9 digitos",
						digits: true,
						maxlength: "Alcanzo el limite de caracteres"
					},
					token: {
						required: "Debe ingresar el token",
						minlength: "Debe contener minimo 6 digitos",
						digits: true,
						maxlength: "Alcanzo el limite de caracteres"
					},
				},
				// Make sure the form is submitted to the destination defined
				// in the "action" attribute of the form when valid
				submitHandler: function(form) {
					
					var action = $('#frm-token').attr('action');
					var datos = $('#frm-token').serialize();
					var msj = '';

					grecaptcha.ready(function() {
  						grecaptcha.execute('6LeV480ZAAAAAH15AZpw7tRYqoKBxjabT5QwvEuk', {action: 'submit'}).then(function(token) {
  							
  							submitAjax(action,datos,msj,true);

  						}); // fin grecaptcha.execute
					}); /// fin grecaptcha.ready

				}
			});
		}
	},

	compra : {
		init : function(){

			$('.btn-tarjeta').on('click', function(){
				
				$('#monto_recarga').val('');
				$('#monto_cambiado').val('');
				var monto_tarjeta = parseFloat($(this).data('monto'));
				var tc = parseFloat($('#tipo_cambio').val());
				var cambio = monto_tarjeta * tc;

				$('#monto_cambiado').val(cambio); //.toFixed(2)
				$('#monto_recarga').val(monto_tarjeta); //.toFixed(2)
				$('#monto_recarga').focus();

			});

			$('.btn-cambio').on('click', function(){
				var tc = parseFloat($('#tipo_cambio').val());
				var recarga = parseFloat($('#monto_recarga').val());
				var cambio = tc * recarga;

				var infousd = recarga; //.toFixed(2)
				var infoclp = cambio; //.toFixed(2)

				$('#monto_cambiado').val(infoclp)
				$('.info-usd').html(infousd);
				$('.info-clp').html(infoclp);
			});

			$('.cbo-card-clp').on('change', function(){
				var tc = parseFloat($('#tipo_cambio').val());
				var recarga = parseFloat($('#monto_cambiado').val());
				var cambio = recarga / tc;
				cambio = Math.floor(cambio);

				var infousd = recarga; //.toFixed(2)
				var infoclp = cambio; //.toFixed(2)

				$('#monto_recarga').val(infoclp)
				$('.info-usd').html(infousd);
				$('.info-clp').html(infoclp);
			});

			$('.nav-compra a').click(function (e) {
			  e.preventDefault();
			  return false;
			  //$(this).tab('show');
			});

			$('.btn-regresa').on('click', function(e){
				e.preventDefault();
				$('.nav-compra li:eq(0) a').tab('show');
			});

			function limpiaErrores(){
				setTimeout("$('.frm-error').remove();", 3000);
			}

			$('.btn-sgte').on('click', function(){
				var idx = $(this).data('index');
				var sgtIndex = idx + 1;
				var noErrores = 0; 
				
				$('.btn-cambio').click();

				var tc = parseFloat($('#tipo_cambio').val());
				var usd = parseFloat($('#monto_recarga').val());
				var clp = parseFloat($('#monto_cambiado').val());
				var metodopago = $('#metodopago:checked').val();

				if(usd>0){

					if(idx){
						if(idx == 1){
							var ncapa = '#paso'+idx;
							$(ncapa+" .required").each(function( index ) {
								//console.log( index + ": " + $( this ).text() );
								var txt = $(this).val();
								if(txt.length == 0){
									noErrores++;
									obj = $(this);
									obj.addClass('form-control-warning');
									obj.parent().after('<br><div class="form-control-feedback frm-error">El campo no puede quedar vacío.</div>');
								}
							});

							limpiaErrores();

							if(noErrores == 0){
								$('.progress-bar').css('width','60%');
								$('.progress-bar').attr('aria-valuenow',60);
								var idxPrev = idx - 1;
								$('.nav-compra li:eq('+idxPrev+') a').addClass('check');

								$('.nav-compra li:eq('+idx+') a').tab('show');
							}
						}else if(idx == 2){

							var urlAction = $('form').attr('action');
							var objBtn = $(this);
							var keyform = $('#keyform').val();
							
							$.ajax( {
								type: "POST",
								url: urlAction,
								data: {tipocambio:tc,monto_usd:usd,monto_clp:clp,metodopago:metodopago,keyform:keyform},
								beforeSend: function( xhr ) {
									objBtn.find('i').attr('class','fa fa-refresh fa-spin fa-fw');
									objBtn.prop('disabled',true);
						  		}
							})
							.done(function(json) {

								if(json.estado == '1'){
									$('#monto_recarga').val('');
									$('#monto_cambiado').val('');
								}else{
									objBtn.prop('disabled',false);
									objBtn.find('i').attr('class','fa fa-send');
								}

								var datos = json.datos;
								if(datos){
									$('.info-nroope').html(datos.nroope);
									$('.info-cantdolares').html(datos.monto_usd);
									$('.info-cantpesos').html(datos.monto_clp);
									$('.info-comision').html(datos.comision);
									$('.info-servcambio').html(datos.servcambio);
									$('.info-empresa').html(datos.empresa);

									var tpPago = $('#metodopago').val();

									if(tpPago == 2){
										$('.btn-pasarela').hide();
									}else{
										$('.btn-pasarela').show();
									}

									$('.info-totaloperacion').html(datos.totaloperacion);
								}

								$('.msj-confirmacion').html(json.msj);

							})
							.fail(function(data) {
								objBtn.find('i').attr('class','fa fa-send');
								objBtn.prop('disabled',false);

							})
							.always(function(json) {
								$('.progress-bar').css('width','100%');
								$('.progress-bar').attr('aria-valuenow',100);
								var idxPrev = idx - 1;
								$('.nav-compra li:eq('+idxPrev+') a').addClass('check');
						    	$('.nav-compra li:eq('+idx+') a').tab('show');

						    	if (metodopago == 1){
									urlActionKP = json.redirec;
									//console.log(json);
									$('.btn-pasarela').attr('data-action',urlActionKP);
									//setTimeout("redirectKP();", 5000);
								}else{
									$('.sw-metodo-pago').show();
								}
							});
							
						}
					}

				}else{
					bootbox.alert("<h4>El monto de la tarjeta debe ser superior a Cero.</h4>");
				} // fin if usd
			});

			$('.btn-pasarela').on('click', function(e){
				e.preventDefault();
				urlActionKP = $(this).data('action');
				window.location.href = urlActionKP;
			});

			function getCambio(){
				var action = $('#frm-compra').data('acttc');

				$.ajax( {
					type: "POST",
					url: action,
					beforeSend: function( xhr ) {
						$('body').loading();
			  		}
				})
				.done(function(json) {
					console.log(json);
					if(json.status == '1'){
						var datos = json.datos;
						$('#tipo_cambio').val(datos);
						//console.log('DATOS: '+datos);
					}else{
						bootbox.alert('<h4>'+json.msj+'</h4>');	
					}
				})
				.fail(function(json) {
					$('body').loading('stop');
					bootbox.alert('<h4>'+json.msj+'</h4>');	
				})
				.always(function(json) {
					$('body').loading('stop');
				});
			}

			$('.btn-gettc').on('click', function(e){
				e.preventDefault();
				getCambio();
			});

			getCambio();

		}
	},

	login : {
		init : function(){

			$("#frmdatos").validate({
				// Specify validation rules
				rules: {
					usuario: {
							required: true,
							maxlength: 80,
							email: true
					},
					pass: {
							required: true,
							minlength: 6,
							maxlength: 12
					}
				},
				// Specify validation error messages
				messages: {
						usuario: "Debe ingresar su Email",
						pass: "Debe revisar el Password ingresado",
						},
				// Make sure the form is submitted to the destination defined
				// in the "action" attribute of the form when valid
				submitHandler: function(form) {
					
					var action = $('form').attr('action');
					var datos = $('form').serialize();
					//submitAjax(action,datos,msj,true);

					grecaptcha.ready(function() {
  						grecaptcha.execute('6LeV480ZAAAAAH15AZpw7tRYqoKBxjabT5QwvEuk', {action: 'submit'}).then(function(token) {
  							
  							$.ajax({
								type: "POST",
								url: action,
								data: datos,
								beforeSend: function( xhr ) {
									$('body').loading();
						  		}
							})
							.done(function(json) {
								if(json.estado == '0'){  // TOKEN DE SEGURIDAD EXPIRADO
									bootbox.alert(json.msj);
								}else if(json.estado == '2'){ // USUARIO INVALIDO
									//bootbox.alert(json.msj);
									var html = $('#errorusuario').html();
									var dialog = bootbox.dialog({
									    title: 'Usuario incorrecto',
									    message: html,
									    size: 'large',
									    buttons: {
									        cancel: {
									            label: "OK",
									            className: 'btn-danger',
									            callback: function(){
									                //console.log('Custom cancel clicked');
									            }
									        }
									    }
									});
								}else if(json.estado == '3'){ // FALTA CONFIRMAR EL CORREO
									
									//bootbox.alert(json.msj);
									var html = $('#usurionoactivo').html();
									var dialog = bootbox.dialog({
									    title: 'Usuario no activo',
									    message: html,
									    size: 'large',
									    buttons: {
									        cancel: {
									            label: "OK",
									            className: 'btn-danger',
									            callback: function(){
									                //console.log('Custom cancel clicked');
									            }
									        }
									    }
									});
								}else if(json.estado == '4'){ // PASSWORD INCORRECTO
									//bootbox.alert(json.msj);
									var html = $('#errorpassword').html();
									var dialog = bootbox.dialog({
									    title: 'Password incorrecto',
									    message: html,
									    size: 'large',
									    buttons: {
									        cancel: {
									            label: "OK",
									            className: 'btn-danger',
									            callback: function(){
									                //console.log('Custom cancel clicked');
									            }
									        }
									    }
									});
								}else{
									var frm = '#'+$('form').attr('id');
									limpiar(frm);
									window.location.replace(json.redirec);
									//redireccion(json.redirec);
								}
							})
							.fail(function(data) {
								$('body').loading('stop');
								bootbox.alert("ERROR: Hubo un error al procesar los datos, Consulte con el administrador de Sistemas.");
							})
							.always(function(json) {
						    	$('body').loading('stop');
							});

  						}); // fin grecaptcha.execute
					}); /// fin grecaptcha.ready

				}
			});
		}
	},

	updatepass : {
		init : function(){

			$("#frmdatos").validate({
				// Specify validation rules
				rules: {
					usuario: {
							required: true,
							maxlength: 80,
							email: true
					}
				},
				// Specify validation error messages
				messages: {
						usuario: "Debe ingresar su Email",
						},
				// Make sure the form is submitted to the destination defined
				// in the "action" attribute of the form when valid
				submitHandler: function(form) {
					
					var action = $('form').attr('action');
					var datos = $('form').serialize();
					var msj = '.msj';
					submitAjax(action,datos,msj,true);
					var frm = '#'+$('form').attr('id');
					limpiar(frm);
				}
			});
		}
	},

	resetpassfrm : {
		init : function(){

			$("#frmdatos").validate({
				// Specify validation rules
				rules: {
					pass: {
							required: true,
							minlength: 6,
							maxlength: 12
					},
					passconf: {
							minlength: 6,
							maxlength: 12,
							equalTo: "#pass"
					}
				},
				// Specify validation error messages
				messages: {
						pass: "Debe ingresar su nuevo Password",
						passconf: "Los datos ingresados no coinciden",
						},
				// Make sure the form is submitted to the destination defined
				// in the "action" attribute of the form when valid
				submitHandler: function(form) {
					
					var action = $('form').attr('action');
					var datos = $('form').serialize();
					var msj = '.msj';
					submitAjax(action,datos,msj,true);
					var frm = '#'+$('form').attr('id');
					limpiar(frm);
				}
			});
		}
	},

	registro : {
		init : function(){

			/*$('#celular').usPhoneFormat({
                format: 'xxx-xxx-xxx',
            });

            $('#nrowsp').usPhoneFormat({
                format: 'xxx-xxx-xxx',
            });*/
			
			$("#frmdatos").validate({
				rules: {
					nombres: {
						required: true,
						maxlength: 150
					},
					apellidos: {
						required: true,
						maxlength: 150
					},
					usuario: {
							required: true,
							maxlength: 120,
							// Specify that email should be validated
							// by the built-in "email" rule
							email: true
					},
					confusuario:{
						required: true,
						maxlength: 120,
						email: true,
						equalTo: "#usuario"
					},
					celular: {
							required: true,
							minlength: 9,
							maxlength: 9,
					},
					nrowsp: {
							required: true,
							minlength: 9,
							maxlength: 9,
					},
					pass: {
							required: true,
							minlength: 6,
							maxlength: 12
					},
					passconf: {
							minlength: 6,
							maxlength: 12,
							equalTo: "#pass"
					},
					documento: {
						required: true,
						minlength: 8,
						maxlength: 20
					},
					chktermino: {
						required: true
					}
				},
				// Specify validation error messages
				messages: 
				{
					nombres: {
						required: "Debe ingresar sus Nombres",
					},
					apellidos: {
						required: "Debe ingresar sus Apellidos",
					},
					celular: {
						required: "Debe ingresar su # de Celular",
						minlength: "Debe contener minimo 9 digitos",
						digits: true,
						maxlength: "Alcanzo el limite de caracteres"
					},
					nrowsp: {
						required: "Debe ingresar su # de WhatsApp",
						minlength: "Debe contener minimo 9 digitos",
						digits: true,
						maxlength: "Alcanzo el limite de caracteres"
					},
					usuario: {
						required: "Debe ingresar su Email",
						maxlength: "Alcanzo el limite de caracteres",
						email: "El formato ingresado no coincide",
					},
					confusuario: {
						required: "Debe ingresar su Email",
						maxlength: "Alcanzo el limite de caracteres",
						email: "El formato ingresado no coincide",
						equalTo: "El Usuario ingresado debe coincidir"
					},
					pass: {
						required: "Debe revisar el Password ingresado",
						minlength: "Debe contener minimo 6 digitos",
					},
					passconf: {
						required: "Debe revisar que sea identico al Password ingresado",
						minlength: "Debe contener minimo 6 digitos",
						equalTo: "El password ingresado debe coincidir"
					},
					documento: {
						required: "Debe ingresar su Documento",
						minlength: "Debe contener minimo 8 digitos",
						maxlength: "Alcanzo el limite de caracteres"
					},
					chktermino: {
						required: "Debe leer y aceptar los terminos y condiciones."
					},
				},
				// Make sure the form is submitted to the destination defined
				// in the "action" attribute of the form when valid
				submitHandler: function(form) {
					var sw = true;
					var celular = $('#celular').val(); var nrowsp = $('#nrowsp').val();
					console.log('inicio de cel: '+celular.substr(0,1));
					if(celular.substr(0,1) !== '9'){
						$('#celular').after('<label class="error" id="celular-error" >El número ingresado es incorrecto</label>');
						sw = false;
					}

					if(nrowsp.substr(0,1) !== '9'){
						$('#nrowsp').after('<label class="error" id="nrowsp-error" >El número ingresado es incorrecto</label>');
						sw = false;
					}

					if(sw){
						var action = $('form').attr('action');
						var datos = $('form').serialize();
						var msj = '.msj';
						grecaptcha.ready(function() {
      						grecaptcha.execute('6LeV480ZAAAAAH15AZpw7tRYqoKBxjabT5QwvEuk', {action: 'submit'}).then(function(token) {
      							submitAjax(action,datos,msj,false);
      						});
    					});
					}
				}
			});

			$(".btn-terminos").on('click', function(){
				$('#chktermino').prop('checked', true);
				$('#myModalTerminos').modal('hide');
			});
		}
	},

	confirmaregistro : {
		init : function(){

			$(".btn-terminos").on('click', function(){
				$('#chktermino').prop('checked', true);
				$('#myModalTerminos').modal('hide');
			});

			$("#frmdatos").validate({
				// Specify validation rules
				rules: {
					// The key name on the left side is the name attribute
					// of an input field. Validation rules are defined
					// on the right side
					direccion: {
						required: true,
						maxlength: 220
					},
					distrito: {
						required: true,
						maxlength: 150
					},
					telefono: {
							required: true,
							minlength: 9,
							maxlength: 9,
					},
					celular: {
							required: true,
							minlength: 9,
							maxlength: 9,
					},
					nacionalidad: {
						required: true,
						maxlength: 100
					},
					documento: {
							required: true,
							minlength: 8,
							maxlength: 15
					},
					chktermino: {
						required: true
					}
				},
				// Specify validation error messages
				messages: {
						direccion: "<br>Debe ingresar su Dirección",
						distrito: "<br>Debe ingresar su Distrtio y Provincia",
						telefono: "<br>Debe ingresar su Nro de Teléfono Fijo",
						celular: "<br>Debe ingresar su Nro de Celular",
						nacionalidad: "Debe ingresar su Nacionalidad",
						documento: "<br>Debe ingresar su Nro de Documento",
						chktermino: "Debe leer y aceptar los terminos y condiciones.",
						/*dni1: "Debe adjuntar la foto del frente de su documento de identidad<br>",
						dni2: "Debe adjuntar la foto de la parte posterior de su documento de identidad<br>"*/
						},
				// Make sure the form is submitted to the destination defined
				// in the "action" attribute of the form when valid
				submitHandler: function(form) {
					var action = $('form').attr('action');
					var datos = $('form').serialize();
					var msj = '.msj';
					submitAjax(action,datos,msj,true);
					var frm = '#'+$('form').attr('id');
					limpiar(frm);
				}
			});
		}
	},

	contacto : {
		init : function(ruta){

			$("#frmContacto").validate({
				// Specify validation rules
				rules: {
				// The key name on the left side is the name attribute
				// of an input field. Validation rules are defined
				// on the right side
				nombre: {
					required: true,
					maxlength: 120
				},
				fono: {
					required: true,
					maxlength: 20,
					number: true
				},
				correo: {
						required: true,
						maxlength: 120,
						// Specify that email should be validated
						// by the built-in "email" rule
						email: true
					}
				},
				// Specify validation error messages
				messages: {
					nombre: "Debe ingresar sus nombres",
					correo: "Debe ingresar su Email",
					fono: "Debe ingresar su Nro. de Teléfono"
					},
				// Make sure the form is submitted to the destination defined
				// in the "action" attribute of the form when valid
				submitHandler: function(form) {
					var frm = '#frmContacto';
					var msj = '.msjFrmContacto';
					contacto(frm,msj,ruta);
				}
			});
		}	
	},

	loadHome : {
		init : function()
		{
			/*$('.flexslider').flexslider({
		        animation: "slide",
		        animationLoop: true,
		        directionNav: false,
		        controlNav: true,
		        slideshowSpeed: 4000,
		        start: function(slider){
		          //$('.banners').removeClass('loading');
		        }
		    });*/

		    /*function getCambio(){
				var action = $('.sidebar-frm-tipocambio').data('acttc');

				$.ajax( {
					type: "POST",
					url: action,
					beforeSend: function( xhr ) {
						$('body').loading();
			  		}
				})
				.done(function(json) {
					console.log(json);
					if(json.status == '1'){
						var datos = json.datos;
						$('#tipo_cambio').val(datos);
						$('#apcftc').val(1);
						//console.log('DATOS: '+datos);
					}else{
						bootbox.alert('<h4>'+json.msj+'</h4>');	
					}
				})
				.fail(function(json) {
					$('body').loading('stop');
					bootbox.alert('<h4>'+json.msj+'</h4>');	
				})
				.always(function(json) {
					$('body').loading('stop');
				});
			}

			getCambio();*/

		    $(document).ready(function() {
    	
				$('.sld-galeria').owlCarousel({
					loop: true,
					margin: 5,
					responsiveClass: true,
					autoplay: true,
					dots: false,
					nav: false,
					responsive: {
					  0: {
					    items: 1,
					  },
					  600: {
					    items: 1,
					  },
					  1000: {
					    items: 1,
					    loop: true,
					  }
					}
				});
				

				$('.sld-text').owlCarousel({
					loop: true,
					margin: 5,
					responsiveClass: true,
					autoplay: true,
					dots: false,
					nav: false,
					responsive: {
					  0: {
					    items: 1,
					  },
					  600: {
					    items: 1,
					  },
					  1000: {
					    items: 1,
					    loop: true,
					  }
					}
				});
				
		    });

		    $('#apcftc').val(DEFTIPOTC);

		    function cotizar(mnt, inp){
		    	//var usd = parseFloat($('#apcusd').val());
		    	var mnt = parseFloat(mnt);
		    	var tc = parseFloat($('#apctc').val());
		    	var cnv = 0;

		    	var inp1 = '#apcusd';
		    	var inp2 = '#apcclp';

		    	var ftc = $('#apcftc').val();
		    	//console.log('DATO: '+ftc+' - '+mnt);

		    	if(mnt > 0 && tc > 0){
			    	if(ftc == 1 && inp == 1){
			    		cnv = parseFloat(mnt * tc);
			    		$(inp2).val(cnv.toFixed(0));
			    	}else if(ftc == 1 && inp == 2){
			    		cnv = parseFloat(mnt / tc);
			    		$(inp1).val(cnv.toFixed(0));
			    	}else if(ftc == 2 && inp == 1){
			    		cnv = parseFloat(mnt / tc);
			    		$(inp2).val(cnv.toFixed(0));
			    	}else if(ftc == 2 && inp == 2){
			    		cnv = parseFloat(mnt * tc);
			    		$(inp1).val(cnv.toFixed(0));
			    	}
		    	}// fin if mnt 
		    }

		    $('#apcusd').on('input', function(){
		    	var mnt = $(this).val();
		    	cotizar(mnt, 1);
		    });

		    $('#apcclp').on('input', function(){
		    	var mnt = $(this).val();
		    	cotizar(mnt, 2);
		    });

		    $('.btn-tc-refresh').on('click',function(){
		    	//cotizar();
		    	var ftc = $('#apcftc').val();
		    	//console.log('FORMA TC: '+ftc);

		    	if(ftc == 1){
		    		$('#apcftc').val(2);
		    		$('.mnd_ing').html(TM_CLP);
		    		$('.mnd_cnv').html(TM_USD);
		    	}else if(ftc == 2){
		    		$('#apcftc').val(1);
		    		$('.mnd_ing').html(TM_USD);
		    		$('.mnd_cnv').html(TM_CLP);
		    		//var mnt = $('#apcusd').val();
		    		//cotizar(mnt);	
		    	}
		    	var mnt = $('#apcusd').val();
		    	cotizar(mnt, 1);
		    });
		} 
	}

}

$(window).resize(function(){

	var gridSize = getGridSize();
    flexslider.vars.minItems = gridSize;
    flexslider.vars.maxItems = gridSize;

});

MyApp.Main.init();

$(window).trigger('resize');
