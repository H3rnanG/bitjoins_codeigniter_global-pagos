
function sumatotales(){

	var subtotal = 0;
	var fila = 1;

	if($('.fila-operacion').length >0){

		$('.fila-operacion').each(function(){
			var ft = parseFloat($(this).find('#iarttotal').val());
			subtotal = subtotal+ft;
			$(this).find('.iart').html(fila);
			fila++;
		});

		var igv = $('#igv').data('igv')
		var totigv = (subtotal * igv) / 100;
		var total = totigv+subtotal;

		$('#subtotal').val(subtotal);
		$('#igv').val(totigv);
		$('#total').val(total);

		$('.cotsubtotal').html(subtotal);
		$('.cotigv').html(totigv);
		$('.cottotal').html(total);

	} // fin if fila-operacion
}

function log(msj){
	console.log(msj);
}

$(document).ready(function(){
	
});

MyApp = {
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

	ImportarCatalogo : {
		init : function(){

			$('#frmimport').on( "submit", function( event ) {
				
				log('FRM-IMPORT');
				event.preventDefault();

				var campos = $(this).serialize(); 
				var urlDest = $(this).attr('action');
				
				log(urlDest);

				var divMsj = '#msjResultado';
				
				//$('#datos').val('');
				
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
						var objFilaOpe = $('.fila-operacion').last();

						if(nroFilasOpe == 1 && index == 1){

							objFilaOpe.find('.input-fila').val('');

							var swreg = fila.swreg;
							objFilaOpe.find('#swreg').val(swreg);

							if(swreg == '1'){
								objFilaOpe.addClass('bg-danger');
							}else{
								objFilaOpe.removeClass('bg-danger');
							}

							objFilaOpe.find('#tp').val(fila.tp);
							objFilaOpe.find('#id').val(fila.id);
							objFilaOpe.find('#sku').val(fila.sku);
							objFilaOpe.find('#nombre').val(fila.nombre);
							objFilaOpe.find('#categoria').val(fila.categoria);
							objFilaOpe.find('#modelo').val(fila.modelo);
							objFilaOpe.find('#marca').val(fila.marca);
							objFilaOpe.find('#producto_marca_id').val(fila.producto_marca_id);
							objFilaOpe.find('#categoria_id').val(fila.categoria_id);
							objFilaOpe.find('#descripcion').val(fila.descripcion);
							objFilaOpe.find('#descripcion_larga').val(fila.descripcion_larga);
							objFilaOpe.find('#alto').val(fila.alto);
							objFilaOpe.find('#ancho').val(fila.ancho);
							objFilaOpe.find('#largo').val(fila.largo);
							objFilaOpe.find('#peso').val(fila.peso);
							objFilaOpe.find('#garantia').val(fila.garantia);
							objFilaOpe.find('#accesorios').val(fila.accesorios);
							objFilaOpe.find('#precio').val(fila.precio);
							objFilaOpe.find('#stock').val(fila.stock);

							objFilaOpe.find('#talla').val(fila.talla);
							objFilaOpe.find('#color').val(fila.color);

						}else{
							var objFilaOpeClone = objFilaOpe.clone();
							objFilaOpeClone.find('.input-fila').val('');

							var swreg = fila.swreg;
							objFilaOpeClone.find('#swreg').val(swreg);

							if(swreg == '1'){
								objFilaOpeClone.addClass('bg-danger');
							}else{
								objFilaOpeClone.removeClass('bg-danger');
							}

							objFilaOpeClone.find('#tp').val(fila.tp);
							objFilaOpeClone.find('#id').val(fila.id);
							objFilaOpeClone.find('#sku').val(fila.sku);
							objFilaOpeClone.find('#nombre').val(fila.nombre);
							objFilaOpeClone.find('#categoria').val(fila.categoria);
							objFilaOpeClone.find('#modelo').val(fila.modelo);
							objFilaOpeClone.find('#marca').val(fila.marca);
							objFilaOpeClone.find('#producto_marca_id').val(fila.producto_marca_id);
							objFilaOpeClone.find('#categoria_id').val(fila.categoria_id);
							objFilaOpeClone.find('#descripcion').val(fila.descripcion);
							objFilaOpeClone.find('#descripcion_larga').val(fila.descripcion_larga);
							objFilaOpeClone.find('#alto').val(fila.alto);
							objFilaOpeClone.find('#ancho').val(fila.ancho);
							objFilaOpeClone.find('#largo').val(fila.largo);
							objFilaOpeClone.find('#peso').val(fila.peso);
							objFilaOpeClone.find('#garantia').val(fila.garantia);
							objFilaOpeClone.find('#accesorios').val(fila.accesorios);
							objFilaOpeClone.find('#precio').val(fila.precio);
							objFilaOpeClone.find('#stock').val(fila.stock);

							objFilaOpeClone.find('#talla').val(fila.talla);
							objFilaOpeClone.find('#color').val(fila.color);
							$('#lsope tbody').append(objFilaOpeClone);
						}

						$('#tabsdatos a:last').tab('show');
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
				});
				
			});



			$('.btn-grabar-datos').on('click',function(){
				var campos = $('form').serialize();
				var urlDest = $(this).data('action');
				var divMsj = '#msjResultado';
				var arrDatos = [];
				
				if($('.fila-operacion').length > 1){
					$('.fila-operacion').each(function( index ) {
						//log(index);
						
						item = {
								'id': $(this).find('#id').val(),
								'swreg': $(this).find('#swreg').val(),
								'tp': $(this).find('#tp').val(),
								'sku': $(this).find('#sku').val(),
								'nombre': $(this).find('#nombre').val(),
								'categoria_id': $(this).find('#categoria_id').val(),
								'modelo': $(this).find('#modelo').val(),
								'producto_marca_id': $(this).find('#producto_marca_id').val(),
								'descripcion': $(this).find('#descripcion').val(),
								'descripcion_larga': $(this).find('#descripcion_larga').val(),
								'alto': $(this).find('#alto').val(),
								'ancho': $(this).find('#ancho').val(),
								'largo': $(this).find('#largo').val(),
								'peso': $(this).find('#peso').val(),
								'garantia': $(this).find('#garantia').val(),
								'accesorios': $(this).find('#accesorios').val(),
								'precio': $(this).find('#precio').val(),
								'stock': $(this).find('#stock').val(),
								'color': $(this).find('#color').val(),
								'talla': $(this).find('#talla').val()
								};
						arrDatos.push(item);
						
					});
				} // if fila-operacion

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
				.done(function(data) {})
				.fail(function(data) {
					log("error");
					log(data);
					$(divMsj).html('ERROR: Consulte con el administrador de Sistemas.');
					$(divMsj).addClass('alert alert-danger');
				})
				.always(function(data) {
					log(data);
					$(divMsj).removeClass();
					$(divMsj).addClass('alert alert-success');
					$(divMsj).html(data);
					$('#datos').val('');
					$('#swreg').val('1');
				});
			});
			
			
		}
	}
	
}

MyApp.Main.init();



$(window).resize(function(){});
$(window).trigger('resize');

