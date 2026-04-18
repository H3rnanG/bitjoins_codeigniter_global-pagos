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

var fdx_zona = '';
var dhl_zona = '';

function validaUsuaurio(id) {
	// Lista de IDs válidos
	const idsValidos = [
		118375568,   //HUMBERTO
		948919528,  //ANGIE
		27090421,   //PAOLA
		147352281,  //JAVIER
		217016551,  //FRANCISCO
		216390350,   //ELIZABET
		987045553,   //CARLA
		940461085,  //CATIA
		216390351,  //CESAR
		938785612,  //NIRVANA
	];

	// Retorna true si el ID existe en la lista, de lo contrario false
	return idsValidos.includes(Number(id));
}

/*function calcularUtilidad(monto) {
	if (monto >= 0 && monto <= 10000) return 100;
	if (monto > 10000 && monto <= 20000) return 200;
	if (monto > 20000 && monto <= 30000) return 300;
	if (monto > 30000 && monto <= 40000) return 400;
	if (monto > 40000 && monto <= 50000) return 500;
	if (monto > 50000 && monto <= 60000) return 600;
	if (monto > 60000 && monto <= 70000) return 700;
	if (monto > 70000 && monto <= 80000) return 800;
	if (monto > 80000 && monto <= 90000) return 900;
	if (monto > 90000 && monto <= 100000) return 1000;

	if (monto > 100000 && monto <= 200000) return 1500;
	if (monto > 200000 && monto <= 300000) return 2000;
	if (monto > 300000 && monto <= 400000) return 2500;
	if (monto > 400000 && monto <= 500000) return 3000;
	if (monto > 500000 && monto <= 600000) return 3500;
	if (monto > 700000 && monto <= 800000) return 4000;
	if (monto > 800000 && monto <= 900000) return 4500;
	if (monto > 900000 && monto <= 1000000) return 5000;

	if (monto > 1000000) return 5000;

	// Si no cae en ningún rango válido
	return 1;
}*/

function calcularUtilidad(monto) {
  // Definimos los rangos en un array: [limiteSuperior, valorAsignado]
  const rangos = [
    [10000, 100],
    [20000, 200],
    [30000, 300],
    [40000, 400],
    [50000, 500],
    [60000, 600],
    [70000, 700],
    [80000, 800],
    [90000, 900],
    [100000, 1000],
    [200000, 1500],
    [300000, 2000],
    [400000, 2500],
    [500000, 3000],
    [600000, 3500],
    [800000, 4000],
    [900000, 4500],
    [1000000, 5000]
  ];

  // Buscar el primer rango que cumpla con el monto
  for (let [limite, valor] of rangos) {
    if (monto <= limite) {
      return valor;
    }
  }

  // 🔥 Si supera 1 millón, aplicar la regla dinámica
  let base = 5000;
  let extraBloques = Math.floor((monto - 1000000) / 100000);
  return base + (extraBloques * 1000);
} //fin calcularUtilidad

MyApp = {
	Main : {
		init : function()
		{
			//MyApp.loadTitles.init();
			if($(".chosen").length){
				$(".chosen").chosen();
			}

			//$(document).find(modulo).addClass('active');

			$(function () {
  				//$('[data-toggle="tooltip"]').tooltip();
			})

			$('#form').on('click','.btn-reiniciar', function(){
				$('#form').find('input[type="password"]').val('');
				$('#form').find('input[type="text"]').val('');
				$('#form').find('input[type="email"]').val('');
				$('#form').find('input[type="hidden"]').val('');
				$('#form').find('textarea').val('');
				$('#form').find('input[type="number"]').val('');
			});
		}
	},

	ticketchileexpress : {
		init : function(){

			function descomponeTarifa(){
				var ing_mnt = $('#ing_mnt').val();
				var ing_tarifa = $('#ing_tarifa').val();

				if(ing_mnt && ing_tarifa){
					var ing_iva = parseFloat($('#ing_iva').val());
					var ing_tiva = parseFloat(ing_tarifa * ((ing_iva/100)+1));
					var ing_cargo =  parseFloat(ing_tarifa - ing_iva);

					$('#ing_tiva').val(ing_tiva.toFixed(2));
					$('#ing_cargo').val(ing_cargo.toFixed(2));

					var ing_com = parseFloat($('#ing_com').val())/100;
					var ing_utilidad = parseFloat(ing_cargo * ing_com);
					$('#ing_utilidad').val(ing_utilidad.toFixed(2));

				} // fin ing_mnt
			}

			$('#ing_mnt').on('change', function(){
				descomponeTarifa();
			});

			$('#ing_tarifa').on('change', function(){
				descomponeTarifa();
			});

			$('#btnrefresh').on('click', function(){
				var ing_mnt = parseFloat($('#ing_mnt').val());
				var ing_utilidad = parseFloat($('#ing_utilidad').val());
				var edt_mnt = ing_mnt + ing_utilidad;
				var edt_tarifa = parseFloat($('#ing_tarifa').val());

				$('#edt_mnt').val(edt_mnt);
				$('#edt_tarifa').val(edt_tarifa);

				var letras = numeroALetras(edt_mnt, {
				          plural: 'CLP',
				          singular: 'CLP',
				          centPlural: '',
				          centSingular: 'CLP'
				        });
				$('#edt_mnt_transferencia').val(letras)
			});

		}
	},

	ticket_morepayment : {	
		init: function(){

			var frmt = $('#edt_formato').val();
			$('.cl'+frmt).prop('checked', true);

			function calculaIVA(){
				var crg = numeral($('#ing_crg').val());
				crg = crg.value();
				var iva = $('#ing_iva').val();
				iva = iva / 100;
				var t_iva = crg * iva;
				t_iva = parseFloat(t_iva);
				$('#ing_tiva').val(t_iva.toFixed(2));
			}

			$('#ing_crg').on('input', function(){
				calculaIVA();
			});

			$('#ing_crg').on('change', function(){
				var val = numeral($(this).val());
				$(this).val(val.format('0,0.00'));
			});

			$('#ing_iva').on('input', function(){
				calculaIVA();
			});

			$('.opt').on('click', function(){
				var op = $(this).val();
				$('#edt_formato').val(op);
			});

			function calculo_tc_dct(){
				var tc = parseFloat($('#ing_tc').val());
				var dct = parseFloat($('#ing_dct').val()) / 100;
				var monto = numeral($('#ing_mnt').val());
				monto = monto.value();

				if(tc && dct){

					if(monto <= 99000){
						dct = 0.05;
					}

					var tcact = parseFloat(tc - dct);
					$('#ing_tcact').val(tcact.toFixed(8));
					if(monto){
						var appago = monto * tcact;
						appago = numeral(appago);
						$('#ing_appago').val(appago.format('0,0.00'));
					}else{
						var appago = parseFloat($(this).val()); 
						if(appago){
							//var tcact = $('#ing_tcact').val();
							var monto = Math.ceil(appago / tcact); 
							monto = numeral(monto);
							$('#ing_mnt').val(monto.format('0,0.00'));
						} // fin appago
					}
				}
			}

			$('#ing_mnt').on('input', function(){
				$('#ing_tot').val('');
				var pais = $('#ing_pais').val();
				if(pais == 2){
					calculo_tc_dct();
				}
			});

			$('#ing_mnt').on('change', function(){
				var val = $(this).val();
				$(this).val(numeral(val).format('0,0.00'));
			});

			$('#ing_tc').on('input', function(){
				calculo_tc_dct();
			});

			$('#ing_dct').on('input', function(){
				calculo_tc_dct();
			});

			$('#ing_appago').on('input', function(){
				var appago = $(this).val(); 
				var tcact = $('#ing_tcact').val();
				var monto = Math.ceil(appago / tcact); 
				monto = numeral(monto);
				$('#ing_mnt').val(monto.format('0,0.00'));
			});

			$('#ing_appago').on('change', function(){
				var appago = numeral($(this).val());
				$(this).val(appago.format('0,0.00'));
			});

			$('#btnrefresh').on('click', function(){
				
				var monto = numeral($('#ing_mnt').val());
				var cargo = numeral($('#ing_crg').val());
				var tiva = numeral($('#ing_tiva').val());
				monto = parseFloat(monto.value());
				cargo = parseFloat(cargo.value());
				tiva = parseFloat(tiva.value());

				console.log('btnrefresh --> ');
				console.log(monto+' - '+cargo+' - '+tiva);

				var cargo2 = parseFloat(numeral($('#ing_crg_2').val()).value());
				var tiva2 = parseFloat($('#ing_tiva_2').val());

				var c1 = cargo + tiva;
				var c2 = cargo2 + tiva2;
				var diferencia = 0;
				//if(c1 > c2){

				diferencia = (parseFloat(c1) - parseFloat(c2)) + 1;

				console.log('c1: '+c1);
				console.log('c2: '+c2);
				console.log('DIFERENCIA: '+diferencia);
				

				var comi = parseFloat($('#ing_com').val());
				comi = comi / 100;
				var utilidad = parseFloat(cargo * comi);

				var tipo = $('#ing_tipo').val();
				var pais = $('#ing_pais').val();

				$('#edt_mnt').val(''); 
				$('#edt_sbt').val('');
				$('#edt_tot').val('');
				$('#edt_tc').val('');
				$('#edt_appago').val('');
				$('#utilidad').val('');
				
				
				$('#ori_mnt').val($('#ing_mnt').val());
				$('#ori_pais').val($('#ing_pais').val());
				$('#ori_crg').val($('#ing_crg').val());
				$('#ori_crg_2').val($('#ing_crg_2').val());
				$('#ori_tipo').val($('#ing_tipo').val());
				$('#ori_com').val($('#ing_com').val());
				$('#ori_iva').val($('#ing_iva').val());
				$('#ori_tiva').val($('#ing_tiva').val());
				$('#ori_tiva_2').val($('#ing_tiva_2').val());
				$('#ori_dct').val($('#ing_dct').val());
				$('#ori_tc').val($('#ing_tc').val());

				$('#ori_tcact').val($('#ing_tcact').val());
				$('#ori_appago').val($('#ing_appago').val());

				//if(pais == 1){  // OTROS
					
				//VALIDACION USUARIOS ELIZABET Y CALCULO DE UTILIDAD
				let swUser = validaUsuaurio(v_nro_rut);
				if(swUser == true){
					utilidad = calcularUtilidad(monto);
					//console.log('Calcula Utilidad - ELZ: '+utilidad);
				}else{
					if(monto > 1000){
						utilidad = v_utility_min
					}
				}

				if(monto && cargo){
					var totales = 0;

					utilidad = Math.ceil(utilidad);
					$('#utilidad').val(numeral(utilidad).format('0,0'));

					if(tipo == 1){ // VARIABLE
						//monto = monto + utilidad;
						totales = monto + utilidad + cargo + tiva;
					}else if(tipo == 2){ // FIJO
						monto = monto - utilidad;
						totales = monto;
					}

					var toting = $('#ing_tot').val();
					toting = parseFloat(toting);

					if(diferencia > 0){
						monto = monto + diferencia;
						if(toting <= 0){
							totales = totales + diferencia;	
						}
					}
					
					monto = Math.round(monto);
					totales = Math.round(totales);
					$('#edt_mnt').val(numeral(monto).format('0,0')); 
					$('#edt_sbt').val(numeral(totales).format('0,0')); 
					$('#edt_tot').val(numeral(totales).format('0,0'));

				}else{
					bootbox.alert('<h4>Debe ingresar el monto y cargo para realizar el calculo de los montos a modificar en el PDF.</h4>');
				} // fin if montos

				
				//} // fin if pais
			});

			$('#btn-procesar').on('click', function(){
				var utilidad = numeral($('#utilidad').val()).value();
				var adjunto = $('#adjunto').val();
				var monto = numeral($('#edt_mnt').val()).value();
				if(utilidad <= 0){
					bootbox.alert('<h4>La utilidad no puede ser menor o igual a 0 verifique los montos ingresados.</h4>');
				}else if(monto <= 0){
					bootbox.alert('<h4>El monto ingresado no es correcto, verifique la información ingresada.</h4>');
				}else if(adjunto.length == 0){
					bootbox.alert('<h4>No se a registrado ningun PDF.</h4>');
				}else{
					$("#frm").submit();
				}
			});

			$('#ing_tot').on('input', function(){

				var monto = $(this).val(); //$('#ing_mnt').val();
				var ing_tiva = $('#ing_tiva').val();
				var ing_com = $('#ing_com').val();
				var ing_crg = numeral($('#ing_crg').val());
				ing_crg = ing_crg.value();

				var por_com = ing_com / 100;
				var comision = ing_crg * por_com;
				var tot_dsc = 0; 
				
				if(ing_crg){
					console.log('Cargo: '+ing_crg+' | '+'IVA:'+ing_tiva+' | Comision:'+comision);

					tot_dsc = Math.ceil(parseFloat(ing_crg) + parseFloat(ing_tiva) + parseFloat(comision));
					var int_tot = numeral($(this).val()); 
					int_tot = int_tot.value(); // Math.ceil(
					monto = int_tot - tot_dsc;
					$('#ing_mnt').val(numeral(monto).format('0,0.00'));
				}
			});

			$('#ing_tot').on('change', function(){
				var int_tot = numeral($(this).val());
				$(this).val(int_tot.format('0,0.00'));
			});

			$('#my-file-input-1').ace_file_input({
    			denyExt:  ['exe', 'php', 'jpg', 'jpeg', 'png', 'js', 'doc', 'ppt', 'docx', 'pptx'],
    			allowExt: ['pdf']
			});

			$('.file-adj').on('change', function(e, info) { // #my-file-input
				var urlAction = $(this).data('action');
				var nomform = $(this).data('frm'); //'#frmflete'
				var myform = $(nomform); 

    			bootbox.confirm({
				    message: "<h4>¿Esta seguro de adjuntar el archivo?<h4>",
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
							var fd = new FormData(); 
				        	myform.find('input[type=file]').each(function(){
								var field_name = $(this).attr('name');
								var files = $(this).data('ace_input_files');
								if(files && files.length > 0) {
									for(var f = 0; f < files.length; f++) {
										fd.append(field_name, files[f]);
									}
								}
							});

							deferred = $.ajax({
								url: urlAction,
								type: 'POST',
								beforeSend: function( xhr ) {
    								$('body').loading();
  								},
								processData: false,//important
								contentType: false,//important
								dataType: 'json', //server response type
								data: fd
			                })
			                .done(function(data) {
			                	json = data;
			                	//log(json);
			                	if(json){
			                		myform.find('.btn-download').remove();
			                		myform.find('#adjunto').val(json.nombre);
			                		//myform.find('#adjunto').after('<a href="'+json.url+'" target="_blank" class="btn-download" download="contrato-descargado" >Descargar Formato</a>');
			                	}
			                })
			                .fail(function(data){
			                	log(data);
			                	$('body').loading('stop');
			                })
			                .always(function(data){
			                	$('body').loading('stop');
			                });
				        }else{
				        	$(this).empty();
				        }
				    }
				});
			});

		}
	}, //fin ticket more payment
	
	ticketwestern_colombia : {	
		init: function(){

			function calculaTotal(){
				var monto = numeral($('#co_ing_mnt').val()).value();
				var cargo = numeral($('#co_ing_crg').val()).value();
				var tiva = numeral($('#co_ing_tiva').val()).value();
				var total = monto + cargo + tiva;
				$('#co_ing_tot').val(numeral(total).format('0,0.00'));
			}

			function calculaIVA(){
				var crg = numeral($('#co_ing_crg_2').val());
				crg = crg.value();
				var iva = $('#co_ing_iva').val();
				iva = iva / 100;
				var t_iva = crg * iva;
				t_iva = parseFloat(t_iva);
				$('#co_ing_tiva').val(t_iva.toFixed(2));
			}

			function calculaUtilidad(){
				var cargo = numeral($('#co_ing_crg').val()).value();
				var comi = parseFloat($('#co_ing_com').val());
				comi = comi / 100;
				var utilidad = parseFloat(cargo * comi);
				var cargo2 = parseFloat(cargo + utilidad);
				//var tcargo = numeral(cargo2).format('0,0.00');
				$('#co_utilidad').val(numeral(utilidad).format('0,0.00'));
				$('#co_ing_crg_2').val(numeral(cargo2).format('0,0.00')); //cargo2.toFixed(2)
			}

			$('#co_ing_crg').on('input', function(){
				calculaUtilidad();
				calculaIVA();
				calculaTotal();
			});

			$('#co_ing_crg').on('change', function(){
				var val = numeral($(this).val());
				$(this).val(val.format('0,0.00'));
			});

			$('.co_opt').on('click', function(){
				var op = $(this).val();
				$('#edt_formato').val(op);
			});

			$('#co_ing_mnt').on('change', function(){
				var val = $(this).val();
				$(this).val(numeral(val).format('0,0.00'));
			});


			$('#co_btnrefresh').on('click', function(e){
				e.preventDefault();

				var monto = numeral($('#co_ing_mnt').val());
				var cargo = numeral($('#co_ing_crg_2').val());
				var tiva = numeral($('#co_ing_tiva').val());
				var tot = numeral($('#co_ing_tot').val());



				monto = parseFloat(monto.value());
				cargo = parseFloat(cargo.value());
				tiva = parseFloat(tiva.value());
				tot = parseFloat(tot.value());

				$('#co_edt_mnt').val(monto);
				$('#co_edt_cargo').val(cargo);
				$('#co_edt_iva').val(tiva);
				$('#co_edt_sbt').val(tot);
				$('#co_edt_tot').val(tot);
			});

			$('#co_btn-procesar').on('click', function(){
				var utilidad = numeral($('#co_utilidad').val()).value();
				var adjunto = $('#adjunto').val();
				var monto = numeral($('#edt_mnt').val()).value();
				if(utilidad <= 0){
					bootbox.alert('<h4>La utilidad no puede ser menor o igual a 0 verifique los montos ingresados.</h4>');
				}else if(monto <= 0){
					bootbox.alert('<h4>El monto ingresado no es correcto, verifique la información ingresada.</h4>');
				}else if(adjunto.length == 0){
					bootbox.alert('<h4>No se a registrado ningun PDF.</h4>');
				}else{
					$("#frm").submit();
				}
			});

			$('#co_my-file-input-1').ace_file_input({
    			denyExt:  ['exe', 'php', 'jpg', 'jpeg', 'png', 'js', 'doc', 'ppt', 'docx', 'pptx'],
    			allowExt: ['pdf']
			});

			$('.co_file-adj').on('change', function(e, info) { // #my-file-input
				var urlAction = $(this).data('action');
				var nomform = $(this).data('frm'); //'#frmflete'
				var myform = $(nomform); 

    			bootbox.confirm({
				    message: "<h4>¿Esta seguro de adjuntar el archivo?<h4>",
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
							var fd = new FormData(); 
				        	myform.find('input[type=file]').each(function(){
								var field_name = $(this).attr('name');
								var files = $(this).data('ace_input_files');
								if(files && files.length > 0) {
									for(var f = 0; f < files.length; f++) {
										fd.append(field_name, files[f]);
									}
								}
							});

							deferred = $.ajax({
								url: urlAction,
								type: 'POST',
								beforeSend: function( xhr ) {
    								$('body').loading();
  								},
								processData: false,//important
								contentType: false,//important
								dataType: 'json', //server response type
								data: fd
			                })
			                .done(function(data) {
			                	json = data;
			                	//log(json);
			                	if(json){
			                		myform.find('.btn-download').remove();
			                		myform.find('#adjunto').val(json.nombre);
			                		//myform.find('#adjunto').after('<a href="'+json.url+'" target="_blank" class="btn-download" download="contrato-descargado" >Descargar Formato</a>');
			                	}
			                })
			                .fail(function(data){
			                	log(data);
			                	$('body').loading('stop');
			                })
			                .always(function(data){
			                	$('body').loading('stop');
			                });
				        }else{
				        	$(this).empty();
				        }
				    }
				});
			});

		}
	},

	ticketwestern_integrado : {
		init: function()
		{
			
			var frmt = $('#edt_formato').val();
			$('.cl'+frmt).prop('checked', true);

			function calculaIVA(){
				var crg = numeral($('#ing_crg').val());
				crg = crg.value();
				var iva = $('#ing_iva').val();
				iva = iva / 100;
				var t_iva = crg * iva;
				t_iva = parseFloat(t_iva);
				$('#ing_tiva').val(t_iva.toFixed(2));
			}

			$('#ing_crg').on('input', function(){
				calculaIVA();
			});

			$('#ing_crg').on('change', function(){
				var val = numeral($(this).val());
				$(this).val(val.format('0,0.00'));
			});

			/*************/

			function calculaIVA_2(){
				var crg = numeral($('#ing_crg_2').val());
				crg = crg.value();
				var iva = $('#ing_iva').val();
				iva = iva / 100;
				var t_iva = crg * iva;
				t_iva = parseFloat(t_iva);
				$('#ing_tiva_2').val(t_iva.toFixed(2));
			}

			$('#ing_crg_2').on('input', function(){
				calculaIVA_2();
			});

			$('#ing_crg_2').on('change', function(){
				var val = numeral($(this).val());
				$(this).val(val.format('0,0.00'));
			});

			/************/

			$('#ing_iva').on('input', function(){
				calculaIVA();
			});

			$('.opt').on('click', function(){
				var op = $(this).val();
				$('#edt_formato').val(op);
			});

			$('#ing_pais').on('change', function(){
				var sw = $(this).val();
				var monto = numeral($('#ing_mnt').val());
				monto = monto.value();
				//console.log('EVENTO CHANGE:'+sw);
				if(sw == 2){ // COLOMBIA
					$('#ing_tc').prop('readonly', false);
					$('#ing_dct').prop('readonly', false);
					$('#ing_tcact').prop('readonly', false);
					$('#ing_appago').prop('readonly', false);
					$('#ing_com').prop('readonly', true);
					//$('#ing_tipo').prop('disabled', true);

					$('#ing_tot').prop('readonly', true);
					$('#ing_tot').val('');	

					if(monto){
						calculo_tc_dct();
					}
					//$('#ing_tipo').val(1);
				}else{
					$('#ing_tc').prop('readonly', true);
					$('#ing_dct').prop('readonly', true);
					$('#ing_tcact').prop('readonly', true);
					$('#ing_appago').prop('readonly', true);
					$('#ing_com').prop('readonly', false);
					//$('#ing_tipo').prop('disabled', false);
					
					$('#ing_tot').prop('readonly', false);

					$('#ing_tc').val('');
					$('#ing_tcact').val('');
					$('#ing_appago').val('');
				}
			});

			function calculo_tc_dct(){
				var tc = parseFloat($('#ing_tc').val());
				var dct = parseFloat($('#ing_dct').val()) / 100;
				var monto = numeral($('#ing_mnt').val());
				monto = monto.value();

				if(tc && dct){

					if(monto <= 99000){
						dct = 0.05;
					}

					var tcact = parseFloat(tc - dct);
					$('#ing_tcact').val(tcact.toFixed(8));
					if(monto){
						var appago = monto * tcact;
						appago = numeral(appago);
						$('#ing_appago').val(appago.format('0,0.00'));
					}else{
						var appago = parseFloat($(this).val()); 
						if(appago){
							//var tcact = $('#ing_tcact').val();
							var monto = Math.ceil(appago / tcact); 
							monto = numeral(monto);
							$('#ing_mnt').val(monto.format('0,0.00'));
						} // fin appago
					}
				}
			}

			$('#ing_mnt').on('input', function(){
				$('#ing_tot').val('');
				var pais = $('#ing_pais').val();
				if(pais == 2){
					calculo_tc_dct();
				}
			});

			$('#ing_mnt').on('change', function(){
				var val = $(this).val();
				$(this).val(numeral(val).format('0,0.00'));
			});

			$('#ing_tc').on('input', function(){
				calculo_tc_dct();
			});

			$('#ing_dct').on('input', function(){
				calculo_tc_dct();
			});

			$('#ing_appago').on('input', function(){
				var appago = $(this).val(); 
				var tcact = $('#ing_tcact').val();
				var monto = Math.ceil(appago / tcact); 
				monto = numeral(monto);
				$('#ing_mnt').val(monto.format('0,0.00'));
			});

			$('#ing_appago').on('change', function(){
				var appago = numeral($(this).val());
				$(this).val(appago.format('0,0.00'));
			});

			$('#btnrefresh').on('click', function(){
				
				var monto = numeral($('#ing_mnt').val());
				var cargo = numeral($('#ing_crg').val());
				var tiva = numeral($('#ing_tiva').val());
				monto = parseFloat(monto.value());
				cargo = parseFloat(cargo.value());
				tiva = parseFloat(tiva.value());

				console.log('btnrefresh --> ');
				console.log(monto+' - '+cargo+' - '+tiva);

				var cargo2 = parseFloat(numeral($('#ing_crg_2').val()).value());
				var tiva2 = parseFloat($('#ing_tiva_2').val());

				var c1 = cargo + tiva;
				var c2 = cargo2 + tiva2;
				var diferencia = 0;
				//if(c1 > c2){

					diferencia = (parseFloat(c1) - parseFloat(c2)) + 1;

					console.log('c1: '+c1);
					console.log('c2: '+c2);
					console.log('DIFERENCIA: '+diferencia);
					

					var comi = parseFloat($('#ing_com').val());
					comi = comi / 100;
					var utilidad = parseFloat(cargo * comi);

					var tipo = $('#ing_tipo').val();
					var pais = $('#ing_pais').val();

					$('#edt_mnt').val(''); 
					$('#edt_sbt').val('');
					$('#edt_tot').val('');
					$('#edt_tc').val('');
					$('#edt_appago').val('');
					$('#utilidad').val('');
					
					
					$('#ori_mnt').val($('#ing_mnt').val());
					$('#ori_pais').val($('#ing_pais').val());
					$('#ori_crg').val($('#ing_crg').val());
					$('#ori_crg_2').val($('#ing_crg_2').val());
					$('#ori_tipo').val($('#ing_tipo').val());
					$('#ori_com').val($('#ing_com').val());
					$('#ori_iva').val($('#ing_iva').val());
					$('#ori_tiva').val($('#ing_tiva').val());
					$('#ori_tiva_2').val($('#ing_tiva_2').val());
					$('#ori_dct').val($('#ing_dct').val());
					$('#ori_tc').val($('#ing_tc').val());

					$('#ori_tcact').val($('#ing_tcact').val());
					$('#ori_appago').val($('#ing_appago').val());

					if(pais == 1){  // OTROS
						
						//VALIDACION USUARIOS ELIZABET Y CALCULO DE UTILIDAD
						let swUser = validaUsuaurio(v_nro_rut);
						if(swUser == true){
							utilidad = calcularUtilidad(monto);
							//console.log('Calcula Utilidad - ELZ: '+utilidad);
						}else{
							if(monto > 1000){
								utilidad = v_utility_min
							}
						}

						if(monto && cargo){
							var totales = 0;

							utilidad = Math.ceil(utilidad);
							$('#utilidad').val(numeral(utilidad).format('0,0'));

							if(tipo == 1){ // VARIABLE
								//monto = monto + utilidad;
								totales = monto + utilidad + cargo + tiva;
							}else if(tipo == 2){ // FIJO
								monto = monto - utilidad;
								totales = monto;
							}

							var toting = $('#ing_tot').val();
							toting = parseFloat(toting);

							if(diferencia > 0){
								monto = monto + diferencia;
								if(toting <= 0){
									totales = totales + diferencia;	
								}
							}
							
							monto = Math.round(monto);
							totales = Math.round(totales);
							$('#edt_mnt').val(numeral(monto).format('0,0')); 
							$('#edt_sbt').val(numeral(totales).format('0,0')); 
							$('#edt_tot').val(numeral(totales).format('0,0'));

						}else{
							bootbox.alert('<h4>Debe ingresar el monto y cargo para realizar el calculo de los montos a modificar en el PDF.</h4>');
						} // fin if montos

					}else if(pais == 2){ // COLOMBIA

						var tcori = parseFloat($('#ing_tc').val());
						var tcact = $('#ing_tcact').val();
						var appago = numeral($('#ing_appago').val());

						appago = appago.value();
						if(monto && tcact){

							monto = Math.round(monto);
							var tot = monto + cargo + tiva;

							if(diferencia > 0){ // old si diferencia > 0 / c1 > 0 && c2 > 0
								monto = monto + diferencia;
								//tot = tot + diferencia;
							}
							tot = Math.round(tot);

							$('#edt_mnt').val(numeral(monto).format('0,0'));
							$('#edt_sbt').val(numeral(tot).format('0,0'));
							$('#edt_tot').val(numeral(tot).format('0,0'));

							$('#edt_tc').val(tcact);
							appago_upt = appago/tcact; // * monto
							appago_ori = appago/tcori; // * monto
							appago = Math.round(appago);

							utilidad = appago_upt - appago_ori;
							utilidad = Math.ceil(utilidad);
							$('#utilidad').val(numeral(utilidad).format('0,0'));

							appago = appago.toFixed(2);
							$('#edt_appago').val(numeral(appago).format('0,0'));

						}else{
							bootbox.alert('<h4>Debe ingresar el monto y la tasa de cambio para realizar el calculo de los montos a modificar en el PDF.</h4>');
						} // fin if monto
					} // fin if pais
			});

			$('#btn-procesar').on('click', function(){
				var utilidad = numeral($('#utilidad').val()).value();
				var adjunto = $('#adjunto').val();
				var monto = numeral($('#edt_mnt').val()).value();
				if(utilidad <= 0){
					bootbox.alert('<h4>La utilidad no puede ser menor o igual a 0 verifique los montos ingresados.</h4>');
				}else if(monto <= 0){
					bootbox.alert('<h4>El monto ingresado no es correcto, verifique la información ingresada.</h4>');
				}else if(adjunto.length == 0){
					bootbox.alert('<h4>No se a registrado ningun PDF.</h4>');
				}else{
					$("#frm").submit();
				}
			});

			$('#ing_tot').on('input', function(){

				var monto = $(this).val(); //$('#ing_mnt').val();
				var ing_tiva = $('#ing_tiva').val();
				var ing_com = $('#ing_com').val();
				var ing_crg = numeral($('#ing_crg').val());
				ing_crg = ing_crg.value();

				var por_com = ing_com / 100;
				var comision = ing_crg * por_com;
				var tot_dsc = 0; 
				
				if(ing_crg){
					console.log('Cargo: '+ing_crg+' | '+'IVA:'+ing_tiva+' | Comision:'+comision);

					tot_dsc = Math.ceil(parseFloat(ing_crg) + parseFloat(ing_tiva) + parseFloat(comision));
					var int_tot = numeral($(this).val()); 
					int_tot = int_tot.value(); // Math.ceil(
					monto = int_tot - tot_dsc;
					$('#ing_mnt').val(numeral(monto).format('0,0.00'));
				}
			});

			$('#ing_tot').on('change', function(){
				var int_tot = numeral($(this).val());
				$(this).val(int_tot.format('0,0.00'));
			});

			$('#my-file-input-1').ace_file_input({
    			denyExt:  ['exe', 'php', 'jpg', 'jpeg', 'png', 'js', 'doc', 'ppt', 'docx', 'pptx'],
    			allowExt: ['pdf']
			});

			$('.file-adj').on('change', function(e, info) { // #my-file-input
				var urlAction = $(this).data('action');
				var nomform = $(this).data('frm'); //'#frmflete'
				var myform = $(nomform); 

    			bootbox.confirm({
				    message: "<h4>¿Esta seguro de adjuntar el archivo?<h4>",
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
							var fd = new FormData(); 
				        	myform.find('input[type=file]').each(function(){
								var field_name = $(this).attr('name');
								var files = $(this).data('ace_input_files');
								if(files && files.length > 0) {
									for(var f = 0; f < files.length; f++) {
										fd.append(field_name, files[f]);
									}
								}
							});

							deferred = $.ajax({
								url: urlAction,
								type: 'POST',
								beforeSend: function( xhr ) {
    								$('body').loading();
  								},
								processData: false,//important
								contentType: false,//important
								dataType: 'json', //server response type
								data: fd
			                })
			                .done(function(data) {
			                	json = data;
			                	//log(json);
			                	if(json){
			                		myform.find('.btn-download').remove();
			                		myform.find('#adjunto').val(json.nombre);
			                		//myform.find('#adjunto').after('<a href="'+json.url+'" target="_blank" class="btn-download" download="contrato-descargado" >Descargar Formato</a>');
			                	}
			                })
			                .fail(function(data){
			                	log(data);
			                	$('body').loading('stop');
			                })
			                .always(function(data){
			                	$('body').loading('stop');
			                });
				        }else{
				        	$(this).empty();
				        }
				    }
				});
			});

		}
	},

	facturacion : {
		init: function()
		{

			$('#reporte_fact').on('click','.chkfact', function(){
				var sw = $(this).prop('checked');
				var id = $(this).val();
				var celda = $(this).parent();
				var uti = celda.find('.chkuti').val();
				var total = $('#monto_facts').val();
				var ids = $('#idordenes').val();
				//console.log('Datos: '+id+' - '+uti);
				if(sw){
					total = parseFloat(total) + parseFloat(uti);
					ids = ids+id+'-';
				}else{	
					if(total){
						total = parseFloat(total) - parseFloat(uti);
						str = id+'-';
						ids.replace(str,'');
					} // fin total 
				}
				//console.log('TOtales: '+total+' | '+ids);
				$('#monto_facts').val(total);
				$('#idordenes').val(ids);
			});

			$('.btn-facturar').on('click', function(){
				var utilidad = parseFloat($('#monto_facts').val());
				if(utilidad <= 0){
					bootbox.alert('<h4>La utilidad no puede ser menor o igual a 0 verifique los montos ingresados.</h4>');
				}else{
					bootbox.prompt({
					    title: "Debe ingresar el Nro. de Boleta con el que se facturo las transacciones seleccionadas.",
					    inputType: 'number',
					    callback: function (result) {
					    	console.log(result);
					        if(result){
					        	var idordenes = $('#idordenes').val();
					        	idordenes = idordenes.substr(0,idordenes.length -1);
					        	var nroboleta = result;
								var urlAction = $('.btn-facturar').data('act');

								console.log(urlAction);

								$.ajax( {
									type: "POST",
									url: urlAction,
									data: {idordenes, nroboleta},
									beforeSend: function( xhr ) {
							    		$('body').loading();
							  		}
								})
								.done(function(data){
									json = data; 
									$('#idordenes').val('');
									$('#monto_facts').val('0');
									$('.chkfact').prop('checked',false);
									MyApp.rptload.init('#reporte_fact',''); 
								})
								.fail(function(data) {
									json = data; 
							    	$('body').loading('stop');
								})
								.always(function(data) {
									json = data; //jQuery.parseJSON(data);
							    	$('body').loading('stop');
								});
					        } // fin if 
					    }
					});
				}
			});
		}
	},

	acceso : {
		init: function()
		{
		
			/*
			$("#pais").chosen();

			$('#pais').on('changed', function(){
				limpiarFDX();
				limpiarDHL();
			});
			*/
			

			function limpiarFDX(){
				$('#cotifedex').val('');
				$('#cotifedex10').val('');
				$('#cotifedex20').val('');
				$('.fdxklg1').html('KL');
			}

			function limpiarDHL(){
				$('#cotidhl').val('');
				$('#cotidhl10').val('');
				$('#cotidhl20').val('');
				$('.dhlklg1').html('KL');
			}

			$('#btnfedex').on('click', function(){

				var pais = $('#pais').val();
				var peso = parseFloat($('#peso').val());
				var zona = $( "#pais option:selected" ).data('fdx');
				var action = $(this).data('act');

				if(pais.length > 0 || peso <= 0){
					$.ajax( {
						type: "POST",
						url: action,
						data: {pais,zona,peso},
						beforeSend: function( xhr ) {
							limpiarFDX();
							$('body').loading();
				  		}
					})
					.done(function(json) {

						if(json.status == true){
							$('#cotifedex').val(json.cotizacion);
							$('#cotifedex10').val(json.cotizacion10);
							$('#cotifedex20').val(json.cotizacion20);
							$('.fdxklg1').html(json.peso+'KL');
						}else{
							bootbox.alert('<h4>'+json.mensaje+'</h4>');
						}

					})
					.fail(function(data) {
						bootbox.alert('<h4>Error al cotizar, contacte al administrador de sistemas.</h4>');
						$('body').loading('stop');
					})
					.always(function(json) {
						$('body').loading('stop');
					});
				}else{
					if(pais.length == 0){
						bootbox.alert('<h4>Verifique el PAIS ingresado.</h4>');
					}else{
						if(peso <= 0){
							bootbox.alert('<h4>Verifique el PESO ingresado, no puede ser menor a 0.</h4>');
						}
					}
					
				} // fin if 

			});

			$('#btndhl').on('click', function(){
				var pais = $('#pais').val();
				var peso = $('#peso').val();
				var zona = $( "#pais option:selected" ).data('dhl');
				var tipo = $('#tipo').val();
				var action = $(this).data('act');

				console.log(tipo+' -- '+peso);
				if(tipo==2 && peso>2){
					bootbox.alert('<h4>Un SOBRE no puede ser superior 2KL.</h4>');
				}else{

					if(pais.length > 0 || peso <= 0){
						$.ajax( {
							type: "POST",
							url: action,
							data: {pais,zona,peso,tipo},
							beforeSend: function( xhr ) {
								limpiarDHL();
								$('body').loading();
					  		}
						})
						.done(function(json) {

							if(json.status == true){
								$('#cotidhl').val(json.cotizacion);
								$('#cotidhl10').val(json.cotizacion10);
								$('#cotidhl20').val(json.cotizacion20);
								$('.dhlklg1').html(json.peso+'KL');
							}else{
								bootbox.alert('<h4>'+json.mensaje+'</h4>');
							}
						})
						.fail(function(data) {
							bootbox.alert('<h4>Error al cotizar, contacte al administrador de sistemas.</h4>');
							$('body').loading('stop');
						})
						.always(function(json) {
							$('body').loading('stop');
						});
					}else{
						if(pais.length == 0){
							bootbox.alert('<h4>Verifique el PAIS ingresado.</h4>');
						}else{
							if(peso <= 0){
								bootbox.alert('<h4>Verifique el PESO ingresado, no puede ser menor a 0.</h4>');
							}
						}
					} // fin if 
				} // fiin if tipo

			});


			


			/*
			$('#bt-sigin').on('click', function() {

				//alert('INGRESO');

				var campos = $('#sigin').serialize(); 
				var urlDest = $('#sigin').attr('action');

				$.ajax( {
					type: "POST",
					url: urlDest,
					data: campos,
					beforeSend: function( xhr ) {
			    		$('body').loading();
			  		}
				})
				.done(function(data){
					json = data; 
					let estado = json.status;
					let tk =  json.cd;
					let redirect = json.redirect;
					$('body').loading('stop');

					console.log('ESTADO--->>> '+estado);
					console.log(json);

					if(estado === true){
						console.log('TOKEN: '+tk);
						bootbox.prompt({
						    title: json.mensaje,
						    inputType: 'number',
						    callback: function (result) {
						    	
						        if(result == tk){
						        	window.location.href = redirect;
						        } // fin if 
						    }
						});

					}else{
						bootbox.alert('<h3>'+json.mensaje+'</h3>');
					}
				})
				.fail(function(data) {
					json = data; 
			    	$('body').loading('stop');
				})
				.always(function(data) {
					json = data; //jQuery.parseJSON(data);
			    	$('body').loading('stop');
				});

			});

			*/

		}
	},

	ventaswu : {
		init: function(){
			console.log('VENTAS WU');
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
				
				var vendedor = $('#rp3_vendedor').val();
				var tienda = $('#rp3_tienda').val();
				var fecha = $('#rp3_fecha').val();
				var id=vendedor+'|'+tienda+'|'+fecha;
				MyApp.rptload.init('#rpt_usuarios',id); 
			});

		}
	},

	ventaswu_usuario : {
		init: function(){
			//console.log('VENTAS WU');
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

			$('#btn-rp1').on('click', function(){
				var vendedor = $('#rp1_vendedor').val();
				var pais = $('#rp1_pais').val();
				var fecha = $('#rp1_fecha').val();
				var id=vendedor+'|'+pais+'|'+fecha;
				console.log('IDS: '+id);
				MyApp.rptload.init('#reporte',id); 
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
			            	/*
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
			            	*/

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
	
}

MyApp.Main.init();

$(window).resize(function(){});
$(window).trigger('resize');

