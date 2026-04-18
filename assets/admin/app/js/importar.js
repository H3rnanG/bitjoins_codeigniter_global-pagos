
function log(msj){
	console.log(msj);
}

$(document).ready(function(){
	
});

MyAppImp = {
	Main : {
		init : function()
		{
			
			
			$('.btnanular').on('click',function(event){
				var urlDest = $(this).attr('data-action');
				var ids = ''; var campos = '';
				var seleccionados = $('input:checked').length;
				if(seleccionados == 0){
					bootbox.alert("Debe seleccionar al menos 1 fila para procesar la operación.");
				}else{

					bootbox.confirm("¿Seguro que desea anular/eliminar los items seleccionados?", function(result) {
  						if(result){
  							$('input:checked').each(function() {
		    					log($(this).attr('value'));
		    					ids+= $(this).attr('value')+',';
							});
							ids = ids.substring(0,(ids.length-1));

							campos = {id:ids};
							var result = deleteAjax(urlDest,campos,'#msjResultado');
  						}
					}); 
				}
				
				event.preventDefault();
			});

			$('.btncancelar').on('click',function(){
				var url = $(this).attr('data-url');
				$(location).attr('href', url);
			});

			$('.btn-reset').on('click',function(){
				$('.form-control').each(function(i,o){
					$(this).val('');
				});
				$('form').submit();
			});


			$('#deletefila').on('click',function(){

				bootbox.confirm("¿Seguro deseas eliminar las filas seleccionadas?", function(result) {
					if(result){
						$('.chk-fila').each(function(){
							var nroCheck = $('.chk-fila').length;
							if($(this).prop( "checked" )){
								if(nroCheck == 1){
									var fila = $(this).parent().parent().parent();	
									fila.find('.input-fila').val('');
								}else{
									$(this).parent().parent().parent().remove();	
								}
							}
						});
					}
				});
			});

		}
	},

	ImportRutas : {
		init : function(){

			$('#frmimport').on( "submit", function( event ) {
				
				//log('FRM-IMPORT');
				event.preventDefault();

				var campos = $(this).serialize(); 
				var urlDest = $(this).attr('action');
				
				//log(urlDest);

				var divMsj = '#msjResultado';
				
				$('.chk-fila').each(function(){
					var nroCheck = $('.chk-fila').length;
						if(nroCheck == 1){
							var fila = $(this).parent().parent().parent();	
							fila.find('.input-fila').val('');
						}else{
							$(this).parent().parent().parent().remove();	
						}
				});

			  	$.ajax( {
					type: "POST",
					url: urlDest,
					data: campos,
					beforeSend: function( xhr ) {
			    		$(divMsj).addClass('alert alert-warning');
			    		$(divMsj).html('Cargando...');
			  		}
				})
				.done(function(data) {
					log( "done" );
					log(data);
					
					//json = jQuery.parseJSON(data);
					$(divMsj).removeClass();

					$.each(data, function( index, fila ) {
						//log(index+' -> '+fila.sectorista_id);
						var nroFilasOpe = $('.fila-operacion').length;
						if(nroFilasOpe == 1 && index == 1){
							var objFilaOpe = $('.fila-operacion').last();
						}else{
							var objFilaOpe = $('.fila-operacion').last().clone();
						}

						objFilaOpe.find('.input-fila').val('');
						var swreg = fila.swreg;
						objFilaOpe.find('#swreg').val(swreg);
						if(swreg == '1'){
							objFilaOpe.addClass('bg-danger');
						}else{
							objFilaOpe.removeClass('bg-danger');
						}

						objFilaOpe.find('#col1').val(fila.col1);
						objFilaOpe.find('#col2').val(fila.col2);
						objFilaOpe.find('#col3').val(fila.col3);
						objFilaOpe.find('#col4').val(fila.col4);
						objFilaOpe.find('#col5').val(fila.col5);

						objFilaOpe.find('#col6').val(fila.col6);
						objFilaOpe.find('#col7').val(fila.col7);
						objFilaOpe.find('#col8').val(fila.col8);
						objFilaOpe.find('#col9').val(fila.col9);
						objFilaOpe.find('#col10').val(fila.col10);

						objFilaOpe.find('#col11').val(fila.col11);
						objFilaOpe.find('#col12').val(fila.col12);
						objFilaOpe.find('#col13').val(fila.col13);
						objFilaOpe.find('#col14').val(fila.col14);
						objFilaOpe.find('#col15').val(fila.col15);

						objFilaOpe.find('#col16').val(fila.col16);
						objFilaOpe.find('#col17').val(fila.col17);
						objFilaOpe.find('#col18').val(fila.col18);
						objFilaOpe.find('#col19').val(fila.col19);
						objFilaOpe.find('#col20').val(fila.col20);

						objFilaOpe.find('#col21').val(fila.col21);
						objFilaOpe.find('#col22').val(fila.col22);
						objFilaOpe.find('#col23').val(fila.col23);
						objFilaOpe.find('#col24').val(fila.col24);
						objFilaOpe.find('#col25').val(fila.col25);

						objFilaOpe.find('#col26').val(fila.col26);
						objFilaOpe.find('#col27').val(fila.col27);
						objFilaOpe.find('#col28').val(fila.col28);
						objFilaOpe.find('#col29').val(fila.col29);
						objFilaOpe.find('#col30').val(fila.col30);

						objFilaOpe.find('#col31').val(fila.col31);
						objFilaOpe.find('#col32').val(fila.col32);
						objFilaOpe.find('#col33').val(fila.col33);
						objFilaOpe.find('#col34').val(fila.col34);
						objFilaOpe.find('#col35').val(fila.col35);
						
						objFilaOpe.find('#col36').val(fila.col36);

						$('#lsope tbody').append(objFilaOpe);

						$('#tabseccion a:last').tab('show');
					});
					$(divMsj).addClass('alert alert-success');
					$(divMsj).html('Datos Cargados');
				})
				.fail(function(data) {
					log("error");
					log(data);
					$(divMsj).html('ERROR: Consulte con el administrador de Sistemas.');
					$(divMsj).addClass('alert alert-danger');
				})
				.always(function(data) {
					log('always');	    
					log(data);
				});
			});


			$('.btn-grabar-datos').on('click',function(){
				var campos = $('form').serialize();
				var urlDest = $(this).data('action');
				var divMsj = '#msjResultado';
				var arrDatos = [];
				
				//if($('.fila-operacion').length > 1){
					$('.fila-operacion').each(function( index ) {
						//log(index);
						var col1 = $(this).find('#col1').val();

						if(col1.length > 0){

							item = {
								'swreg': $(this).find('#swreg').val(),
								'col1': $(this).find('#col1').val(),
								'col2': $(this).find('#col2').val(),
								'col3': $(this).find('#col3').val(),
								'col4': $(this).find('#col4').val(),
								'col5': $(this).find('#col5').val(),
								'col6': $(this).find('#col6').val(),
								'col7': $(this).find('#col7').val(),
								'col8': $(this).find('#col8').val(),
								'col9': $(this).find('#col9').val(),
								'col10': $(this).find('#col10').val(),
								'col11': $(this).find('#col11').val(),
								'col12': $(this).find('#col12').val(),
								'col13': $(this).find('#col13').val(),
								'col14': $(this).find('#col14').val(),
								'col15': $(this).find('#col15').val(),
								'col16': $(this).find('#col16').val(),
								'col17': $(this).find('#col17').val(),
								'col18': $(this).find('#col18').val(),
								'col19': $(this).find('#col19').val(),
								'col20': $(this).find('#col20').val(),
								'col21': $(this).find('#col21').val(),
								'col22': $(this).find('#col22').val(),
								'col23': $(this).find('#col23').val(),
								'col24': $(this).find('#col24').val(),
								'col25': $(this).find('#col25').val(),
								'col26': $(this).find('#col26').val(),
								'col27': $(this).find('#col27').val(),
								'col28': $(this).find('#col28').val(),
								'col29': $(this).find('#col29').val(),
								'col30': $(this).find('#col30').val(),
								'col31': $(this).find('#col31').val(),
								'col32': $(this).find('#col32').val(),
								'col33': $(this).find('#col33').val(),
								'col34': $(this).find('#col34').val(),
								'col35': $(this).find('#col35').val(),
								'col36': $(this).find('#col36').val(),
								};
							arrDatos.push(item);

						} // fin if col1.lenth
						
					});
				//} // if fila-operacion

				arrDatos = JSON.stringify(arrDatos);

				$.ajax( {
					type: "POST",
					url: urlDest,
					//dataType:'json',
					data: {datos:arrDatos},
					beforeSend: function( xhr ) {
			    		$(divMsj).addClass('alert alert-warning');
			    		$(divMsj).html('Cargando...');
			  		}
				})
				.done(function(data) {

				})
				.fail(function(data) {
					log("error");
					log(data);
					$(divMsj).html('ERROR: Consulte con el administrador de Sistemas.');
					$(divMsj).addClass('alert alert-danger');
				})
				.always(function(data) {
					
					var json = data;

					$(divMsj).removeClass();
					$(divMsj).addClass('alert alert-success');
					$(divMsj).html(json.msj);

					log(json.datos);

					$('#datos').val('');
					$('#swreg').val('1');
				});
			});
					
		}
	},

	ImportFCLGastos : {
		init : function(){

			$('#frmimport').on( "submit", function( event ) {
				
				//log('FRM-IMPORT');
				event.preventDefault();

				var campos = $(this).serialize(); 
				var urlDest = $(this).attr('action');
				
				//log(urlDest);

				var divMsj = '#msjResultado';
				
				$('.chk-fila').each(function(){
					var nroCheck = $('.chk-fila').length;
						if(nroCheck == 1){
							var fila = $(this).parent().parent().parent();	
							fila.find('.input-fila').val('');
						}else{
							$(this).parent().parent().parent().remove();	
						}
				});

			  	$.ajax( {
					type: "POST",
					url: urlDest,
					data: campos,
					beforeSend: function( xhr ) {
			    		$(divMsj).addClass('alert alert-warning');
			    		$(divMsj).html('Cargando...');
			  		}
				})
				.done(function(data) {
					log( "done" );
					log(data);
					
					//json = jQuery.parseJSON(data);
					$(divMsj).removeClass();

					$.each(data, function( index, fila ) {
						//log(index+' -> '+fila.sectorista_id);
						var nroFilasOpe = $('.fila-operacion').length;
						if(nroFilasOpe == 1 && index == 1){
							var objFilaOpe = $('.fila-operacion').last();
						}else{
							var objFilaOpe = $('.fila-operacion').last().clone();
						}

						objFilaOpe.find('.input-fila').val('');
						var swreg = fila.swreg;
						objFilaOpe.find('#swreg').val(swreg);
						if(swreg == '1'){
							objFilaOpe.addClass('bg-danger');
						}else{
							objFilaOpe.removeClass('bg-danger');
						}

						objFilaOpe.find('#col1').val(fila.col1);
						objFilaOpe.find('#col2').val(fila.col2);
						objFilaOpe.find('#col3').val(fila.col3);
						objFilaOpe.find('#col4').val(fila.col4);
						objFilaOpe.find('#col5').val(fila.col5);

						objFilaOpe.find('#col6').val(fila.col6);
						objFilaOpe.find('#col7').val(fila.col7);
						objFilaOpe.find('#col8').val(fila.col8);
						objFilaOpe.find('#col9').val(fila.col9);
						objFilaOpe.find('#col10').val(fila.col10);

						objFilaOpe.find('#col11').val(fila.col11);
						objFilaOpe.find('#col12').val(fila.col12);
						objFilaOpe.find('#col13').val(fila.col13);
						objFilaOpe.find('#col14').val(fila.col14);
						objFilaOpe.find('#col15').val(fila.col15);

						objFilaOpe.find('#col16').val(fila.col16);
						objFilaOpe.find('#col17').val(fila.col17);
						objFilaOpe.find('#col18').val(fila.col18);
						objFilaOpe.find('#col19').val(fila.col19);
						objFilaOpe.find('#col20').val(fila.col20);

						objFilaOpe.find('#col21').val(fila.col21);
						objFilaOpe.find('#col22').val(fila.col22);
						objFilaOpe.find('#col23').val(fila.col23);
						objFilaOpe.find('#col24').val(fila.col24);
						objFilaOpe.find('#col25').val(fila.col25);

						objFilaOpe.find('#col26').val(fila.col26);
						objFilaOpe.find('#col27').val(fila.col27);
						objFilaOpe.find('#col28').val(fila.col28);
						objFilaOpe.find('#col29').val(fila.col29);
						objFilaOpe.find('#col30').val(fila.col30);

						$('#lsope tbody').append(objFilaOpe);

						$('#tabseccion a:last').tab('show');
					});
					$(divMsj).addClass('alert alert-success');
					$(divMsj).html('Datos Cargados');
				})
				.fail(function(data) {
					log("error");
					log(data);
					$(divMsj).html('ERROR: Consulte con el administrador de Sistemas.');
					$(divMsj).addClass('alert alert-danger');
				})
				.always(function(data) {
					log('always');	    
					log(data);
				});
			});


			$('.btn-grabar-datos').on('click',function(){
				var campos = $('form').serialize();
				var urlDest = $(this).data('action');
				var divMsj = '#msjResultado';
				var arrDatos = [];
				
				//if($('.fila-operacion').length > 1){
					$('.fila-operacion').each(function( index ) {
						//log(index);
						var col1 = $(this).find('#col1').val();
						if(col1.length > 0){
							item = {
									'swreg': $(this).find('#swreg').val(),
									'col1': $(this).find('#col1').val(),
									'col2': $(this).find('#col2').val(),
									'col3': $(this).find('#col3').val(),
									'col4': $(this).find('#col4').val(),
									'col5': $(this).find('#col5').val(),
									'col6': $(this).find('#col6').val(),
									'col7': $(this).find('#col7').val(),
									'col8': $(this).find('#col8').val(),
									'col9': $(this).find('#col9').val(),
									'col10': $(this).find('#col10').val(),
									'col11': $(this).find('#col11').val(),
									'col12': $(this).find('#col12').val(),
									'col13': $(this).find('#col13').val(),
									'col14': $(this).find('#col14').val(),
									'col15': $(this).find('#col15').val(),
									'col16': parseFloat($(this).find('#col16').val()),
									'col17': parseFloat($(this).find('#col17').val()),
									'col18': parseFloat($(this).find('#col18').val()),
									'col19': parseFloat($(this).find('#col19').val()),
									'col20': parseFloat($(this).find('#col20').val()),
									'col21': parseFloat($(this).find('#col21').val()),
									'col22': parseFloat($(this).find('#col22').val()),
									'col23': parseFloat($(this).find('#col23').val()),
									'col24': parseFloat($(this).find('#col24').val()),
									'col25': parseFloat($(this).find('#col25').val()),
									'col26': parseFloat($(this).find('#col26').val()),
									'col27': parseFloat($(this).find('#col27').val()),
									'col28': $(this).find('#col28').val(),
									'col29': $(this).find('#col29').val(),
									'col30': $(this).find('#col30').val()
									};
							arrDatos.push(item);
						} // fin if(col1.length > 0)
					});
				//} // if fila-operacion

				arrDatos = JSON.stringify(arrDatos);

				$.ajax( {
					type: "POST",
					url: urlDest,
					//dataType:'json',
					data: {datos:arrDatos},
					beforeSend: function( xhr ) {
			    		$(divMsj).addClass('alert alert-warning');
			    		$(divMsj).html('Cargando...');
			  		}
				})
				.done(function(data) {

				})
				.fail(function(data) {
					log("error");
					log(data);
					$(divMsj).html('ERROR: Consulte con el administrador de Sistemas.');
					$(divMsj).addClass('alert alert-danger');
				})
				.always(function(data) {
					
					var json = data;

					$(divMsj).removeClass();
					$(divMsj).addClass('alert alert-success');
					$(divMsj).html(json.msj);

					log(json.datos);

					$('#datos').val('');
					$('#swreg').val('1');
				});
			});
					
		}
	},

	ImportFCLFletes : {
		init : function(){

			$('#frmimport').on( "submit", function( event ) {
				
				//log('FRM-IMPORT');
				event.preventDefault();

				var campos = $(this).serialize(); 
				var urlDest = $(this).attr('action');
				
				//log(urlDest);

				var divMsj = '#msjResultado';
				
				$('.chk-fila').each(function(){
					var nroCheck = $('.chk-fila').length;
						if(nroCheck == 1){
							var fila = $(this).parent().parent().parent();	
							fila.find('.input-fila').val('');
						}else{
							$(this).parent().parent().parent().remove();	
						}
				});

			  	$.ajax( {
					type: "POST",
					url: urlDest,
					data: campos,
					beforeSend: function( xhr ) {
			    		$(divMsj).addClass('alert alert-warning');
			    		$(divMsj).html('Cargando...');
			  		}
				})
				.done(function(data) {
					log( "done" );
					log(data);
					
					//json = jQuery.parseJSON(data);
					$(divMsj).removeClass();

					$.each(data, function( index, fila ) {
						//log(index+' -> '+fila.sectorista_id);
						var nroFilasOpe = $('.fila-operacion').length;
						if(nroFilasOpe == 1 && index == 1){
							var objFilaOpe = $('.fila-operacion').last();
						}else{
							var objFilaOpe = $('.fila-operacion').last().clone();
						}

						objFilaOpe.find('.input-fila').val('');
						var swreg = fila.swreg;
						objFilaOpe.find('#swreg').val(swreg);
						if(swreg == '1'){
							objFilaOpe.addClass('bg-danger');
						}else{
							objFilaOpe.removeClass('bg-danger');
						}

						objFilaOpe.find('#col1').val(fila.col1);
						objFilaOpe.find('#col2').val(fila.col2);
						objFilaOpe.find('#col3').val(fila.col3);
						objFilaOpe.find('#col4').val(fila.col4);
						objFilaOpe.find('#col5').val(fila.col5);

						objFilaOpe.find('#col6').val(fila.col6);
						objFilaOpe.find('#col7').val(fila.col7);
						objFilaOpe.find('#col8').val(fila.col8);
						objFilaOpe.find('#col9').val(fila.col9);
						objFilaOpe.find('#col10').val(fila.col10);

						objFilaOpe.find('#col11').val(fila.col11);
						objFilaOpe.find('#col12').val(fila.col12);
						objFilaOpe.find('#col13').val(fila.col13);
						objFilaOpe.find('#col14').val(fila.col14);
						objFilaOpe.find('#col15').val(fila.col15);

						objFilaOpe.find('#col16').val(fila.col16);
						objFilaOpe.find('#col17').val(fila.col17);
						objFilaOpe.find('#col18').val(fila.col18);
						objFilaOpe.find('#col19').val(fila.col19);
						objFilaOpe.find('#col20').val(fila.col20);

						objFilaOpe.find('#col21').val(fila.col21);
						objFilaOpe.find('#col22').val(fila.col22);
						objFilaOpe.find('#col23').val(fila.col23);
						objFilaOpe.find('#col24').val(fila.col24);
						objFilaOpe.find('#col25').val(fila.col25);

						objFilaOpe.find('#col26').val(fila.col26);
						objFilaOpe.find('#col27').val(fila.col27);
						objFilaOpe.find('#col28').val(fila.col28);
						objFilaOpe.find('#col29').val(fila.col29);
						objFilaOpe.find('#col30').val(fila.col30);

						objFilaOpe.find('#col31').val(fila.col31);
						objFilaOpe.find('#col32').val(fila.col32);
						objFilaOpe.find('#col33').val(fila.col33);
						objFilaOpe.find('#col34').val(fila.col34);
						objFilaOpe.find('#col35').val(fila.col35);
						
						objFilaOpe.find('#col36').val(fila.col36);

						$('#lsope tbody').append(objFilaOpe);

						$('#tabseccion a:last').tab('show');
					});
					$(divMsj).addClass('alert alert-success');
					$(divMsj).html('Datos Cargados');
				})
				.fail(function(data) {
					log("error");
					log(data);
					$(divMsj).html('ERROR: Consulte con el administrador de Sistemas.');
					$(divMsj).addClass('alert alert-danger');
				})
				.always(function(data) {
					log('always');	    
					log(data);
				});
			});


			$('.btn-grabar-datos').on('click',function(){
				var campos = $('form').serialize();
				var urlDest = $(this).data('action');
				var divMsj = '#msjResultado';
				var arrDatos = [];
				
				//if($('.fila-operacion').length > 1){
					$('.fila-operacion').each(function( index ) {
						//log(index);
						var col1 = $(this).find('#col1').val();
						if(col1.length > 0){

							item = {
									'swreg': $(this).find('#swreg').val(),
									'col1': $(this).find('#col1').val(),
									'col2': $(this).find('#col2').val(),
									'col3': $(this).find('#col3').val(),
									'col4': $(this).find('#col4').val(),
									'col5': $(this).find('#col5').val(),
									'col6': $(this).find('#col6').val(),
									'col7': $(this).find('#col7').val(),
									'col8': $(this).find('#col8').val(),
									'col9': $(this).find('#col9').val(),
									'col10': $(this).find('#col10').val(),
									'col11': $(this).find('#col11').val(),
									'col12': $(this).find('#col12').val(),
									'col13': $(this).find('#col13').val(),
									'col14': $(this).find('#col14').val(),
									'col15': $(this).find('#col15').val(),
									'col16': $(this).find('#col16').val(),
									'col17': $(this).find('#col17').val(),
									'col18': $(this).find('#col18').val(),
									'col19': $(this).find('#col19').val(),
									'col20': $(this).find('#col20').val(),
									'col21': $(this).find('#col21').val(),
									'col22': $(this).find('#col22').val(),
									'col23': $(this).find('#col23').val(),
									'col24': $(this).find('#col24').val(),
									'col25': $(this).find('#col25').val(),
									'col26': $(this).find('#col26').val(),
									'col27': $(this).find('#col27').val(),
									'col28': $(this).find('#col28').val(),
									'col29': $(this).find('#col29').val(),
									'col30': $(this).find('#col30').val(),
									'col31': $(this).find('#col31').val(),
									'col32': $(this).find('#col32').val(),
									'col33': $(this).find('#col33').val(),
									'col34': $(this).find('#col34').val(),
									'col35': $(this).find('#col35').val(),
									'col36': $(this).find('#col36').val(),
									};
							arrDatos.push(item);
						}//fin if col1.length
						
					});
				//} // if fila-operacion

				arrDatos = JSON.stringify(arrDatos);

				$.ajax( {
					type: "POST",
					url: urlDest,
					//dataType:'json',
					data: {datos:arrDatos},
					beforeSend: function( xhr ) {
			    		$(divMsj).addClass('alert alert-warning');
			    		$(divMsj).html('Cargando...');
			  		}
				})
				.done(function(data) {

				})
				.fail(function(data) {
					log("error");
					log(data);
					$(divMsj).html('ERROR: Consulte con el administrador de Sistemas.');
					$(divMsj).addClass('alert alert-danger');
				})
				.always(function(data) {
					
					var json = data;

					$(divMsj).removeClass();
					$(divMsj).addClass('alert alert-success');
					$(divMsj).html(json.msj);

					log(json.datos);

					$('#datos').val('');
					$('#swreg').val('1');
				});
			});
					
		}
	}
}

MyAppImp.Main.init();



$(window).resize(function(){});
$(window).trigger('resize');

