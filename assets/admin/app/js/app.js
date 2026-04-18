
const ST_ACTIVO = '1';
const ST_INACTIVO = '2';
const TC_IMPEXCEL = 2;

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

			$('#reporte').on('click','.btn-eliminar', function(e){
				e.preventDefault()
				var id = $(this).data('id');
				var usu = $(this).data('usu');
				var urlAction = $(this).data('act');

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
								data: {id:id},
								beforeSend: function( xhr ) {
						    		$('body').loading();
						  		}
							})
							.done(function(data) {
								json = data; 
								if(json)
								{
									if(json.status){
										bootbox.alert('<h4>'+json.mensaje+'</h4>');
									}
								}
							})
							.fail(function(data) {
								//log('error');
								json = data; //jQuery.parseJSON(data);
						    	$('body').loading('stop');
							})
							.always(function(data) {
								json = data; //jQuery.parseJSON(data);
								var reporte = $('.reporte').DataTable();
								reporte.ajax.reload();
						    	$('body').loading('stop');
							});
				        }
				    }
				});
			});
		}
	},

	ventaswu : {
		init: function(){

			$('#reporte').on('click','.btn-detalle-venta', function(e){
				e.preventDefault()
				var id = $(this).data('id');
				var urlAction = $(this).data('act');

				$.ajax( {
					type: "POST",
					url: urlAction,
					data: {id:id},
					beforeSend: function( xhr ) {
			    		$('body').loading();
			  		}
				})
				.done(function(data) {
					json = data; 
					if(json)
					{
						//var id = parseFloat($('#frm').find('#id').val());
						var pref = '.camp_';

						$.each( json, function( key, fila ){
							log('fila: '); log(fila);
							$.each( fila, function( k, v ){
								log(k+' - '+v);
								var cls = pref+k;
								
								if(k == 'id'){
									$('#frmtran').find('#id').val(v);
								}else if(k== 'edt_tc' || k=='pais' || k=='ing_tc' || k=='ing_tcact' || k=='ing_iva' || k=='calculadora_login_id' || k=='calculadora_tienda_id' || k=='fecha' || k=='hora' || k=='nroboleta'){
									$('#frmtran').find('#'+k).val(v);

								}else{
									$('#frmtran').find('#'+k).val(numeral(v).format('0,0'));
								}
							});
						});
					}
				})
				.fail(function(data) {
					log('error');
					json = data; //jQuery.parseJSON(data);
			    	//$(divMsj).html(json.mensaje);
			    	$('body').loading('stop');
				})
				.always(function(data) {
					json = data; //jQuery.parseJSON(data);
			    	
			    	$('#tabseccion li:eq(3) a').tab('show');
			    	//$('#tabdet li:eq(0) a').tab('show');
			    	$('body').loading('stop');
				});
			});


			$('#reporte').on('click','.btn-eliminar-tra', function(e){
				e.preventDefault()
				var id = $(this).data('id');
				var usu = $(this).data('usu');
				var urlAction = $(this).data('act');

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
								data: {id:id},
								beforeSend: function( xhr ) {
						    		$('body').loading();
						  		}
							})
							.done(function(data) {
								json = data; 
								if(json)
								{
									if(json.status){
										bootbox.alert('<h4>'+json.mensaje+'</h4>');
									}
								}
							})
							.fail(function(data) {
								//log('error');
								json = data; //jQuery.parseJSON(data);
						    	$('body').loading('stop');
							})
							.always(function(data) {
								json = data; //jQuery.parseJSON(data);
								var vendedor = $('#rp1_vendedor').val();
								var pais = $('#rp1_pais').val();
								var fecha = $('#rp1_fecha').val();
								var id=vendedor+'|'+pais+'|'+fecha;
								MyApp.rptload.init('#reporte',id); 
						    	$('body').loading('stop');
							});
				        }
				    }
				});
			});

			$('#reporte').on('click', '.btn-pdf', function(e){
				e.preventDefault();
				var mnt = $(this).data('mnt');
				var sbt = $(this).data('sbt');
				var tc = $(this).data('tc');
				var appago = $(this).data('appago');
				var adjunto = $(this).data('adjunto');
				var formato = $(this).data('formato');
				var print = $(this).data('print');

				console.log(mnt+' - '+sbt+' - '+tc);
				$('#edt_mnt').val(mnt);
				$('#edt_sbt').val(sbt);
				$('#edt_tc').val(tc);
				$('#edt_appago').val(appago);
				$('#edt_formato').val(formato);
				$('#adjunto').val(adjunto);
				$('#edt_print').val(print);
				$("#frm").submit();
			});

			/*$('#tabseccion a').click(function (e) {
				e.preventDefault();
				var idtab = $(this).attr('href');
				//log('ID: '+idtab);
				//$(this).tab('show');
				if(idtab == '#home'){
					var vendedor = $('#rp1_vendedor').val();
					var pais = $('#rp1_pais').val();
					var fecha = $('#rp1_fecha').val();
					var id=vendedor+'|'+pais+'|'+fecha;
					MyApp.rptload.init('#reporte',id); 
				}else if(idtab == '#rpt2'){
					var tienda = $('#rp2_tienda').val();
					var fecha = $('#rp2_fecha').val();
					var id=tienda+'|'+fecha;
					MyApp.rptload.init('#rpt_locales',id); 
				}else if(idtab == '#rpt3'){
					var vendedor = $('#rp3_vendedor').val();
					var tienda = $('#rp3_tienda').val();
					var fecha = $('#rp3_fecha').val();
					var id=vendedor+'|'+tienda+'|'+fecha;
					MyApp.rptload.init('#rpt_usuarios',id); 
				}
			});
			*/

			$('#btn-rp1').on('click', function(){
				var vendedor = $('#rp1_vendedor').val();
				var pais = $('#rp1_pais').val();
				var fecha = $('#rp1_fecha').val();
				var id=vendedor+'|'+pais+'|'+fecha;
				MyApp.rptload.init('#reporte',id); 
			});

			$('#btn-rp2').on('click', function(){
				var tienda = $('#rp2_tienda').val();
				var fecha = $('#rp2_fecha').val();
				var id=tienda+'|'+fecha;
				MyApp.rptload.init('#rpt_locales',id); 
			});

			$('#btn-rp3').on('click', function(){
				console.log('BTN RP3');
				var vendedor = $('#rp3_vendedor').val();
				var tienda = $('#rp3_tienda').val();
				var fecha = $('#rp3_fecha').val();
				var id=vendedor+'|'+tienda+'|'+fecha;
				MyApp.rptload.init('#rpt_usuarios',id); 
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

			//if(iddefault.length > 0){
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
	              },
	              "footerCallback": function ( row, data, start, end, display ) {
			            var api = this.api(), data;
			 			var idrpt = $(this).attr('id');
			 			//console.log($(this).attr('id')); console.log(data);
			            if(data){
			            	if(idrpt == 'rpt_locales'){
			            		var vt_otros = 0; var uti_otros = 0; var vt_colom = 0;
			            		$.each(data, function(i, f){
			            			//console.log(f);
			            			vt_otros = vt_otros + parseFloat(f[2]);
			            			uti_otros = uti_otros + parseFloat(f[3]);
			            			vt_colom = vt_colom + parseFloat(f[4]);
			            		});	
			            		vt_otros = numeral(vt_otros).format('0,0');
			            		uti_otros = numeral(uti_otros).format('0,0');
			            		vt_colom = numeral(vt_colom).format('0,0');
			            		$( api.column(2).footer() ).html('CLP '+vt_otros);
			            		$( api.column(3).footer() ).html('CLP '+uti_otros);
			            		$( api.column(4).footer() ).html('CLP '+vt_colom);
			            	}

			            	if(idrpt == 'rpt_usuarios'){
			            		var vt_otros = 0; var uti_otros = 0; var vt_colom = 0; uti_colom = 0;
			            		$.each(data, function(i, f){
			            			//console.log(f);
			            			var dato = f[3]?parseFloat(f[3]):0;
			            			vt_otros = vt_otros + dato;
			            			var dato = f[4]?parseFloat(f[4]):0;
			            			uti_otros = uti_otros + dato;
			            			var dato = f[5]?parseFloat(f[5]):0;
			            			vt_colom = vt_colom + dato;
			            			var dato = f[6]?parseFloat(f[6]):0;
			            			uti_colom = uti_colom + dato;
			            		});	
			            		vt_otros = numeral(vt_otros).format('0,0');
			            		uti_otros = numeral(uti_otros).format('0,0');
			            		vt_colom = numeral(vt_colom).format('0,0');
			            		uti_colom = numeral(uti_colom).format('0,0');
			            		$( api.column(3).footer() ).html('CLP '+vt_otros);
			            		$( api.column(4).footer() ).html('CLP '+uti_otros);
			            		$( api.column(5).footer() ).html('CLP '+vt_colom);
			            		$( api.column(6).footer() ).html('CLP '+uti_colom);
			            	}

			            	if(idrpt == 'reporte'){
			            		var total = 0; var utilidad = 0;
			            		$.each(data, function(i, f){
			            			//console.log('datos: ');
			            			//console.log(f);
			            			var dato = f[9].replace(',','');
			            			dato = dato?parseFloat(dato):0;
			            			total = total + dato;
			            			dato = f[12]; //.replace(',','')
			            			dato = dato?parseFloat(dato):0;
			            			utilidad = utilidad + dato;
			            		});	
			            		total = numeral(total).format('0,0');
			            		utilidad = numeral(utilidad).format('0,0.00');
			            		$(api.column(9).footer()).html('CLP '+total);
			            		$(api.column(12).footer()).html('CLP '+utilidad);
			            	}
			            } // fin if data
			      }
	          });
			//} 
		}
	},

	recargas : {
		init: function(){
			$('.btn-rpt-filtro').on('click', function(){
				//var mnt = $('#rpt_tarjeta_mnt').val();
				var id = filtrar('#frm_filtrar'); //mnt+'|';
				console.log('FILTROS: '+id);
				MyApp.rptload.init('#reporte',id); 
			});

			$('.btn-rpt-reset').on('click', function(e){
				e.preventDefault();
				resetFiltros('#frm_filtrar');
			});

			$('.btn-vtn-filtro').on('click', function(){
				//var mnt = $('#rpt_tarjeta_mnt').val();
				var filtro = filtrar('#frm_ventas'); //mnt+'|';
				//console.log('FILTROS: '+filtro);
				//MyApp.rptload.init('#gridventas',id); 
				rptventa(filtro);
			});

			function rptventa(filtro){
				var iddefault = filtro;
				var urlAction = $('#gridventas').data('action');
				//console.log('URL: '+urlAction);
				$('#gridventas').DataTable({ 
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
		              },
		              "footerCallback": function ( row, data, start, end, display ) {
			            var api = this.api(), data;
			 			var idrpt = $(this).attr('id');
			 			//console.log($(this).attr('id')); console.log(data);
			            if(data){
			            	var dolares = 0; var clp = 0; 
		            		$.each(data, function(i, f){
		            			//console.log(f);
		            			var dato = f[1]?parseFloat(f[1]):0;
		            			dolares = dolares + dato;
		            			var dato = f[2]?parseFloat(f[2]):0;
		            			clp = clp + dato;
		            			
		            		});	
		            		console.log(dolares+' / '+clp);
		            		dolares = numeral(dolares).format('0,0');
		            		clp = numeral(clp).format('0,0');
		            		$( api.column(1).footer() ).html('$ '+dolares);
		            		$( api.column(2).footer() ).html('CLP '+clp);
			            }
			          },
		        });
			}

			var filtro = filtrar('#frm_ventas');
			rptventa(filtro);

		}
	},

	tarjetas : {
		init: function(){

			$('.btn-inventario').on('click', function(e){
				e.preventDefault();
				var urlAction = $(this).data('action');
				
				$.ajax( {
					type: "POST",
					url: urlAction,
					data: {},
					beforeSend: function( xhr ) {
			    		$('body').loading();
			  		}
				})
				.done(function(data) {
					json = data;
					if(json == 'Enviado')
					{
						bootbox.alert('<h4>El inventario fue enviado a su email.</h4>');
					}else{
						bootbox.alert('<h4>ERROR: No se pudo generar el inventario.</h4>');
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
			});

			//valida
			$("#frmtoken").submit(function( event ) {
				event.preventDefault();
				var campos = $(this).serialize(); 
				var action = $(this).attr('action'); 
				limpiar('#frm_tarjeta');

				grecaptcha.ready(function() {
      				grecaptcha.execute('6LeV480ZAAAAAH15AZpw7tRYqoKBxjabT5QwvEuk', {action: 'submit'}).then(function(token) {
						carga_tarjeta(action, campos);
			  		});
    			});
			});

			function carga_tarjeta(action, campos){
				$.ajax({
					type: "POST",
					url: action,
					data: campos,
					beforeSend: function( xhr ) {
			    		$('body').loading();
			  		}
				})
				.done(function(json) {
					if(json.status == '1')
					{
						var datos = json.datos;
						$('#digitos').val(datos.nmt);
						$('#cvv').val(datos.nmc);
						$('#exp').val(datos.exp);
						$('#monto').val(datos.monto);
						$('#login-box').removeClass('visible');//hide others
		        		$('#forgot-box').addClass('visible');//show target
					}else{
						//bootbox.alert('<h4>Error en el codigo de acceso vuelva a intentarlo.</h4>');
					}
				})
				.fail(function(data) {
			    	$('body').loading('stop');
				})
				.always(function(data) {
					json = data; //jQuery.parseJSON(data);
			    	$('body').loading('stop');
				});
			}

			// fin valida


			$('.btn-rpt-filtro').on('click', function(){
				var id = filtrar('#frm_filtrar'); 
				MyApp.rptload.init('#reporte',id); 
			});

			$('.btn-rpt-reset').on('click', function(e){
				e.preventDefault();
				resetFiltros('#frm_filtrar');
			});

			$('#reporte').on('click', '.btn-enviar-tarjeta', function(e){
				e.preventDefault();
				var st = $(this).data('st');
				var id = $(this).data('id');
				var tp = $(this).data('tp');
				var action = $(this).data('act');

				var table = $('#reporte').DataTable();
				var tr = $(this).closest('tr');
		        var row = table.row(tr);
		        var dtFila = row.data();
		        var digitos = dtFila[4];

		        if(tp == TC_IMPEXCEL){

		        	if(st == ST_ACTIVO){
						bootbox.prompt({
						    title: "Ingrese el email para enviar la tarjeta: "+digitos,
						    inputType: 'email',
						    callback: function (email) {
						        if(email){
						        	$.ajax( {
										type: "POST",
										url: action,
										data: {id:id,email:email},
										beforeSend: function( xhr ) {
								    		$('body').loading();
								  		}
									})
									.done(function(data) {
										json = data; 
										if(json)
										{
											bootbox.alert('<h4>'+json.msj+'</h4>');
										}
									})
									.fail(function(data) {
								    	$('body').loading('stop');
									})
									.always(function(data) {
										json = data; //jQuery.parseJSON(data);
										var reporte = $('#reporte').DataTable();
										reporte.ajax.reload();
								    	$('body').loading('stop');
									});
						        } // fin if result
						    }
						});
					}else{
						bootbox.alert('<h4>La tarjeta '+digitos+' ya fue utilizada, no se puede enviar.</h4>');
					} // fin if st

		        }else{
		        	bootbox.alert('<h4>La tarjeta '+digitos+' es tipo imagen, no esta soportada para el envio.</h4>');
		        } // fin if tp

			});

			$('#reporte').on('click','.btn-detalle-tarjeta', function(e){
				e.preventDefault()
				var id = $(this).data('id');
				var urlAction = $('#form').data('action');
				$.ajax( {
					type: "POST",
					url: urlAction,
					data: {id:id},
					beforeSend: function( xhr ) {
			    		$('body').loading();
			  		}
				})
				.done(function(data) {
					json = data; 
					if(json)
					{
						var id = parseFloat($('#form').find('#id').val());
						var pref = '.camp_';

						$.each( json, function( key, fila ){
							$.each( fila, function( k, v ){
								var cls = pref+k;
								
								if(k == 'foto'){
									if(v){
										var carpeta = $('#form').find('#avatar').data('carpeta');
										var urlpath = carpeta+v;
									}else{
										var urlpath = $('#form').find('#avatar').data('default');
									}
									$('#form').find('#avatar').attr('src', urlpath);
									$('#form').find(cls).val(v);
								}else{
									log('Clase: '+cls);
									$('#form').find(cls).val(v);
								}
							});
						});
					}
				})
				.fail(function(data) {
					log('error');
					json = data; //jQuery.parseJSON(data);
			    	//$(divMsj).html(json.mensaje);
			    	$('body').loading('stop');
				})
				.always(function(data) {
					json = data; //jQuery.parseJSON(data);
			    	
			    	$('#tabseccion li:eq(1) a').tab('show');
			    	$('#tabdet li:eq(0) a').tab('show');
			    	$('body').loading('stop');
				});
			});
		}
	},

	usuarios : {
		init: function()
		{

			$('#reporte').on('click','.btn-pass', function(e){
				e.preventDefault();
				var id = $(this).data('id');
				var usu = $(this).data('usu');
				bootbox.alert('<h4>El <u>password</u> del usurio ('+usu+') es: <strong>'+id+'</strong></h4>');
			});

			$('#reporte').on('click','.btn-detalle-usu', function(e){
				e.preventDefault()
				var id = $(this).data('id');
				var urlAction = $('#form').data('action');
				//urlAction = urlAction+'/'+id;

				$.ajax( {
					type: "POST",
					url: urlAction,
					data: {id:id},
					beforeSend: function( xhr ) {
			    		$('body').loading();
			  		}
				})
				.done(function(data) {
					json = data; 
					if(json)
					{
						var id = parseFloat($('#form').find('#id').val());
						var pref = '.camp_';

						$('.avat1').find('.editable-open').show();
						$('.avat1').find('.editableform').remove();
						$('.avat2').find('.editable-open').show();
						$('.avat2').find('.editableform').remove();
						$('.avat3').find('.editable-open').show();
						$('.avat3').find('.editableform').remove();

						$.each( json, function( key, fila ){
							$.each( fila, function( k, v ){
								var cls = pref+k;
								if(k == 'ID'){
									$('#form').find('#id').val(v);
								}else if(k == 'dni1'){
									if(v){
										var carpeta = $('#form').find('#avatar').data('carpeta');
										var urlpath = carpeta+v;
									}else{
										var urlpath = $('#form').find('#avatar').data('default');
									}
									$('#form').find('#avatar').attr('src', urlpath);
									$('#form').find(cls).val(v);
								}else if(k == 'dni2'){
									if(v){
										var carpeta = $('#form').find('#avatar2').data('carpeta');
										var urlpath = carpeta+v;
									}else{
										var urlpath = $('#form').find('#avatar2').data('default');
									}
									$('#form').find('#avatar2').attr('src', urlpath);
									$('#form').find(cls).val(v);
								}else if(k == 'reciboservicio'){
									if(v){
										var carpeta = $('#form').find('#avatar3').data('carpeta');
										var urlpath = carpeta+v;
									}else{
										var urlpath = $('#form').find('#avatar3').data('default');
									}
									$('#form').find('#avatar3').attr('src', urlpath);
									$('#form').find(cls).val(v);
								}else{
									$('#form').find(cls).val(v);
								}
							});
						});
					}
				})
				.fail(function(data) {
					log('error');
					json = data; //jQuery.parseJSON(data);
			    	//$(divMsj).html(json.mensaje);
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

	maestros: {
		init : function(){

			$('.btn-volver').on('click', function(e){
				$('#tabseccion li:eq(0) a').tab('show');
			});

			$('#form').on('submit', function(e){
				e.preventDefault();
				var sw = true; var lbl = ''; 
				$('.required').each(function(i, ele){
					var id = $(this).attr('id');
					var v =  $(this).val();
					lbl = $(this).attr('placeholder');

					if(v == ''){
						sw = false;
						return false;
					}	
				});

				if(sw === false){
					bootbox.alert("<h4>Debe seleccionar un "+lbl+' </h4>');
				}else{
					var urlAction = $('#frm').attr('action');
					var frmData = $('#frm').serialize();
					
					$.ajax( {
						type: "POST",
						url: urlAction,
						data: frmData,
						beforeSend: function( xhr ) {
				    		$('body').loading();
				  		}
					})
					.done(function(data) {
						json = data;
						if(json)
						{
							if(json){
								$.each(json, function(i, f){
									$('#frm').find('#'+i).val(f);
								});
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

						if(data){
							var redirect = data.redirect;
							if(redirect){
								//redirect(redirect);
								window.location = redirect;
							}else{
								limpiar('#frm');
								$('#tabseccion li:eq(0) a').tab('show');
						    	var reporte = $('.reporte').DataTable();
								reporte.ajax.reload();	
							}
						}else{
							limpiar('#frm');
							$('#tabseccion li:eq(0) a').tab('show');
					    	var reporte = $('.reporte').DataTable();
							reporte.ajax.reload();
						}

				    	$('body').loading('stop');
					});
				}
				return sw;
			});

			var urlAction = $('#reporte').data('action');
			var rpt = $('#reporte').DataTable({   /// IMPORTACIONES CULMINADOS
              "scrollX": true,
              "scrollY": 400,
              "language": {
                  "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
              },
              "pageLength": 25,
              "processing": true, //Feature control the processing indicator.
              "serverSide": true, //Feature control DataTables' server-side processing mode.
              "order": [], //Initial no order. [1,'desc']
              // Load data for the table's content from an Ajax source
              "ajax": {
                  "url": urlAction,
                  "type": "POST"
              }
          	});

          	$('#reporte').on('click','.btn-detalle', function(e){
				e.preventDefault()
				var id = $(this).data('id');
				var urlAction = $('#form').data('action');

				$.ajax( {
					type: "POST",
					url: urlAction,
					data: {id:id},
					beforeSend: function( xhr ) {
			    		$('body').loading();
			  		}
				})
				.done(function(data) {
					json = data; 
					if(json)
					{
						var id = parseFloat($('#form').find('#id').val());
						var pref = '.camp_';

						$.each( json, function( key, fila ){
							//log('fila: '); log(fila);
							$.each( fila, function( k, v ){
								//log(pref+' - '+k);
								var cls = pref+k;
								
								if(key == 'ID'){
									$('#form').find('#id').val(v);
								}else{
									log('Clase: '+cls);
									$('#form').find(cls).val(v);
								}
							});
						});
					}
				})
				.fail(function(data) {
					log('error');
					json = data; //jQuery.parseJSON(data);
			    	//$(divMsj).html(json.mensaje);
			    	$('body').loading('stop');
				})
				.always(function(data) {
					json = data; //jQuery.parseJSON(data);
			    	
			    	$('#tabseccion li:eq(1) a').tab('show');
			    	$('#tabdet li:eq(0) a').tab('show');
			    	$('body').loading('stop');
				});
			});

			$('#reporte').on('click','.btn-editar', function(e){
				e.preventDefault()
				var id = $(this).data('id');
				var urlAction = $('#form').data('action');
				console.log(urlAction+' -> '+id);
				
				$.ajax({
					type: "POST",
					url: urlAction,
					data: {id:id},
					beforeSend: function( xhr ) {
			    		$('body').loading();
			  		}
				})
				.done(function(data) {
					json = data; 
					if(json)
					{
						var id = parseFloat($('#form').find('#id').val());

						var pref = '.prof-';
						$.each( json, function( key, fila ){
							console.log(key+' --- '+fila);
							if(key == 'ID'){
								$('#form').find('#id').val(fila);
							}else if(key == 'contenido'){
								$('#form').find('#'+key).val(fila);
								//editor.setData(fila);
							}else{
								$('#form').find('#'+key).val(fila);
							}
						});

						$(".chosen").trigger("chosen:updated");
					}
				})
				.fail(function(data) {
					log('error');
					json = data; //jQuery.parseJSON(data);
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

	frmmodales: {
		init : function(urlAction){
			//log(urlAction);
			if(dtmodal != null){
				dtmodal.destroy();	
			}

			var dtmodal = $('#rptmodal').DataTable({   /// 
              "scrollX": true,
              "language": {
                  "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
              },
              "processing": true, //Feature control the processing indicator.
              "serverSide": true, //Feature control DataTables' server-side processing mode.
              "destroy": true,
              "order": [], //Initial no order. [1,'desc']
              // Load data for the table's content from an Ajax source
              "ajax": {
                  "url": urlAction,
                  "type": "POST"
              }
          	});

          	$('#rptmodal_filter').find('input').focus();
			
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

