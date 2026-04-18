
function limpiar(idForm){
	$(idForm).find('input[type="password"]').val('');
	$(idForm).find('input[type="text"]').val('');
	$(idForm).find('input[type="email"]').val('');
	$(idForm).find('input[type="hidden"]').val('');
	$(idForm).find('textarea').val('');
	$(idForm).find('input[type="number"]').val('');
	$(idForm).find('').val();
	$(idForm).find('select').prop('selected', function() {
        return this.defaultSelected;
    });
}

function filtrar(idForm){
	var strFiltro = '';
	//console.log('ID: '+idForm);
	$(idForm+' .inpfiltro').each(function(i, e){
		var idCamp = $(this).attr('id');
		var valCamp = $(this).val();
		strFiltro= strFiltro+valCamp+'|';
	});
	var pos = strFiltro.length - 1;
	//console.log('FILTROS: '+strFiltro);
	strFiltro = strFiltro.substr(0, pos);
	return strFiltro;
}

function resetFiltros(idForm){
	
	$(idForm+' .inpfiltro').each(function(i, e){
		var idCamp = $(this).attr('id');
		//console.log('ID: '+idCamp);
		$(idForm).find('#'+idCamp).val($("#"+idCamp+" option:first").val());
	});

	var nroBtnDef = $('.btn-rpt-filtro').length;
	if(nroBtnDef){
		$('.btn-rpt-filtro').click();
	}
}

MyApp = {
	Main : {
		init : function()
		{
			//MyApp.loadTitles.init();
			if($(".chosen").length){
				$(".chosen").chosen();
			}

			$(document).find(modulo).addClass('active');

			$(function () {
  				$('[data-toggle="tooltip"]').tooltip();
			})

			$('#form').on('click','.btn-reiniciar', function(){
				$('#form').find('input[type="password"]').val('');
				$('#form').find('input[type="text"]').val('');
				$('#form').find('input[type="email"]').val('');
				$('#form').find('input[type="hidden"]').val('');
				$('#form').find('textarea').val('');
				$('#form').find('input[type="number"]').val('');
			});

			$('.btn-nuevo').on('click', function(e){
				e.preventDefault();
				var act = $(this).data('act');
				var idfrm = $(this).data('frm');
				limpiar(idfrm);

				//$('.editable-empty').addClass('editable-open'); 
				//$('.editable-empty').attr('style','display: none;');

				$('#avatar').click();
				$('#avatar2').click();
				$('#avatar3').click();

				$(idfrm).find('#act').val(act);
			});

			$('#reporte').on('click','.btn-eliminar', function(e){
				e.preventDefault()
				var id = $(this).data('id');
				var usu = $(this).data('usu');
				var act = $(this).data('act');
				var frm = $(this).data('frm');
				frm = $(frm);
				var urlAction = frm.attr('action');

				bootbox.confirm({
				    message: "<h4>¿Seguro que deseas eliminar el registro?</h4>",
				    buttons: {
				        confirm: {
				            label: 'SI',
				            className: 'btn-success'
				        },
				        cancel: {
				            label: 'NO',
				            className: 'btn-danger'
				        }
				    },
				    callback: function (result) {
				        if(result){
				        	$.ajax( {
								type: "POST",
								url: urlAction,
								data: {id:id, act:act},
								beforeSend: function( xhr ) {
						    		$('body').loading();
						  		}
							})
							.done(function(data) {
								json = data; 
								if(json.status){
									var strFiltro = filtrar('#frm_filtrar');
        							MyApp.rptload.init('#reporte',strFiltro);
								}else{
									bootbox.alert('<h4>'+json.mensaje+'</h4>');
								}
							})
							.fail(function(data) {
								//log('error');
								json = data; //jQuery.parseJSON(data);
						    	$('body').loading('stop');
							})
							.always(function(data) {
						    	$('body').loading('stop');
							});
				        }
				    }
				});
			});

			$('.btn-rpt-reset').on('click', function(e){
				e.preventDefault();
				resetFiltros('#frm_filtrar');
			});

		}
	},
	
	transferencias: {
		init: function(){
			
			$('.btn-rpt-filtro').on('click', function(){
				var tipodoc = $('#rpt_tipodoc').val();
				var fecha = $('#rpt_fechareg').val();
				var id=tipodoc+'|'+fecha;
				//console.log('FILTROS: '+id);
				MyApp.rptload.init('#reporte',id); 
			});

			function cboLoad(id, action, target){
				$.ajax({
					type: "POST",
					url: action,
					data: {id},
					beforeSend: function( xhr ) {
			    		$('body').loading();
			  		}
				})
				.done(function(data) {
					json = data;
					if(json)
					{
						var sw = json.status;
						if(sw){
							var datos = json.datos;
							$(target).empty();
							$.each(datos, function(i, f){
								$(target).append(new Option(f.value, f.data));
							});
						}else{
							$(target).append(new Option('Seleccionar', '0'));
							//bootbox.alert('<h4>'+json.msj+'</h4>');
						}
					}
				})
				.fail(function(data) {
					log('error');
					json = data; 
					bootbox.alert('<h4>ERROR: Al grabar los datos, contacte al administrador de sistemas.</h4>');
			    	$('body').loading('stop');
				})
				.always(function(data) {
			    	$('body').loading('stop');
				});
			} 

			$('.cbo-load').on('change', function(){
				var id = $(this).val();
				var action = $(this).data('action');
				var target = $(this).data('target');

				var idSelect = $(this).attr('id');
				if(idSelect == 'pais_id'){
					$('#estado_id').empty();
					$('#ciudad_id').empty();
				}else if(idSelect == 'estado_id'){
					$('#ciudad_id').empty();
				}

				cboLoad(id, action, target);
			});

			$("#frm").validate({
				// Specify validation rules
				rules: {
					tipo_documento: {
						required: true
					},
					documento: {
						required: true,
						maxlength: 15
					},
					nombre: {
						required: true,
						maxlength: 80
					},
					apellido_paterno: {
						required: true,
						maxlength: 80
					},
					fecha_nacimiento: {
						required: true,
						maxlength: 10
					},
					pais_nacimiento_id: {
						required: true,
					},
					direccion1: {
						required: true,
						maxlength: 200
					},
					pais_id: {
						required: true,
					},
					estado_id: {
						required: true,
					},
					ciudad_id: {
						required: true,
					},
					cod_telefono1: {
						required: true,
						maxlength: 5
					},
					num_telefono_1: {
						required: true,
						maxlength: 10
					},
					sw_tercera_persona: {
						required: true
					},
					sw_perexp_politicamente: {
						required: true
					},
					sw_datos_verificados: {
						required: true
					},

					estado: {
						required: true
					},
					fechareg: {
						required: true,
						maxlength: 10
					}
				},
				// Specify validation error messages
				messages: {
					tipo_documento: {
						required: "Ingrese un dato valido",
					},
					documento: {
						required: "Ingrese un dato valido",
						maxlength: "Supero el limite de caracteres permitidos"
					},
					nombre: {
						required: "Ingrese un dato valido",
						maxlength: "Supero el limite de caracteres permitidos"
					},
					apellido_paterno: {
						required: "Ingrese un dato valido",
						maxlength: "Supero el limite de caracteres permitidos"
					},
					fecha_nacimiento: {
						required: "Ingrese un dato valido",
						maxlength: "Supero el limite de caracteres permitidos"
					},
					pais_nacimiento_id: {
						required: "Ingrese un dato valido",
					},
					direccion1: {
						required: "Ingrese un dato valido",
						maxlength: "Supero el limite de caracteres permitidos"
					},
					pais_id: {
						required: "Ingrese un dato valido",
					},
					estado_id: {
						required: "Ingrese un dato valido",
					},
					ciudad_id: {
						required: "Ingrese un dato valido",
					},
					cod_telefono1: {
						required: "Ingrese un dato valido",
						maxlength: "Supero el limite de caracteres permitidos"
					},
					num_telefono_1: {
						required: "Ingrese un dato valido",
						maxlength: "Supero el limite de caracteres permitidos"
					},
					sw_tercera_persona: {
						required: "Ingrese un dato valido",
					},
					sw_perexp_politicamente: {
						required: "Ingrese un dato valido",
					},
					sw_datos_verificados: {
						required: "Ingrese un dato valido",
					},

					estado: {
						required: "Ingrese un dato valido",
					},
					fechareg: {
						required: "Ingrese un dato valido",
						maxlength: "Supero el limite de caracteres permitidos"
					},
				},
				// Make sure the form is submitted to the destination defined
				// in the "action" attribute of the form when valid
				submitHandler: function(form) {
					var action = $('#frm').attr('action');
					var datos = $('#frm').serialize();
					//var msj = '.msj'; submitAjax(action,datos,msj,true);

					$.ajax({
						type: "POST",
						url: action,
						data: datos,
						beforeSend: function( xhr ) {
				    		$('body').loading();
				  		}
					})
					.done(function(data) {
						json = data;
						if(json)
						{
							//$.each(json, function(i, f){$('#frm').find('#'+i).val(f);});
							var sw = json.status;
							if(sw){
								limpiar('#frm');
								var tab = $('#tab').val();
								var strFiltro = filtrar('#frm_filtrar');
        						MyApp.rptload.init('#reporte',strFiltro);
								$('#tabseccion li:eq(0) a').tab('show');

							}else{
								bootbox.alert('<h4>'+json.msj+'</h4>');
							}
						}
					})
					.fail(function(data) {
						log('error');
						json = data; 
						bootbox.alert('<h4>ERROR: Al grabar los datos, contacte al administrador de sistemas.</h4>');
				    	$('body').loading('stop');
					})
					.always(function(data) {
						var redirect = data.redirect;
				    	if(redirect){
				    		$(location).attr('href', redirect);
				    	}

				    	$('body').loading('stop');
					});
				} // fin submitHandler
			}); // fin frm validate

			
			$('#reporte').on('click','.btn-editar', function(e){
				e.preventDefault()

				var id = $(this).data('id');
				var act = $(this).data('act');
				var urlAction = $('#form').data('action');

				$.ajax({
					type: "POST",
					url: urlAction,
					data: {id:id, act:act},
					beforeSend: function( xhr ) {
			    		$('body').loading();
			  		}
				})
				.done(function(data) {
					$('#form').find('#act').val(act);
					json = data; 
					if(json)
					{
						var sw = json.status;
						if(sw){
							var datos = json.datos;
							$.each(datos, function( key, fila ){
								//console.log(key+' --- '+fila);
								$.each( fila, function( k, v ){
									var idInp = '#'+k;

									if(k == 'pais_id' || k == 'estado_id'){
										var id = v;
										var action = $(idInp).data('action');
										var target = $(idInp).data('target');
										//console.log(id+' - '+action+' - '+target);
										cboLoad(id, action, target);
									}else if(k == 'arch_dni1'){
										if(v){
											var idDiv = '#avatar';
											var carpeta = $(idDiv).data('carpeta');
											var pathImg = carpeta+'/'+v;
											//console.log(pathImg);
											$(idDiv).attr('src',pathImg);
										} // fin if
									}else if(k == 'arch_dni2'){
										if(v){
											var idDiv = '#avatar2';
											var carpeta = $(idDiv).data('carpeta');
											var pathImg = carpeta+'/'+v;
											//console.log(pathImg);
											$(idDiv).attr('src',pathImg);
										}
									}else if(k == 'arch_declaracion'){
										if(v){
											var idDiv = '#avatar3';
											var carpeta = $(idDiv).data('carpeta');
											var pathImg = carpeta+'/'+v;
											//console.log(pathImg);
											$(idDiv).attr('src',pathImg);
										} // fin if
									} // fin if

									$('#form').find(idInp).val(v);

								});
							});
						}else{
							bootbox.alert('<h4>'+json.msj+'</h4>');
						}
					}
				})
				.fail(function(data) {
					bootbox.alert('<h4>ERROR: Al grabar los datos, contacte al administrador de sistemas.</h4>');
			    	$('body').loading('stop');
				})
				.always(function(data) {
					json = data; //jQuery.parseJSON(data);
			    	$('#tabseccion li:eq(1) a').tab('show');
			    	$('body').loading('stop');
				});
			});

		}
	},

	rptload: {
		init : function(rpt, id){
			//log(urlAction);
			var iddefault = id;
			var urlAction = $(rpt).data('action');
			var dtmodal = $(rpt).DataTable();
			dtmodal.clear();

			dtmodal = $(rpt).DataTable({ 
				"scrollX": true,
				"scrollY": 400,
				"language": {
					"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
				},
			  "pageLength": 25,
              "processing": true, //Feature control the processing indicator.
              "serverSide": true, //Feature control DataTables' server-side processing mode.
              "destroy": true,
              "order": [], //Initial no order. [1,'desc']
              // Load data for the table's content from an Ajax source
              "ajax": {
              	"url": urlAction,
              	"type": "POST",
              	"data": function(d){
              		d.fil = iddefault;
              	}
              }
          });
		}
	},
	
}

MyApp.Main.init();

$(window).resize(function(){});
$(window).trigger('resize');

