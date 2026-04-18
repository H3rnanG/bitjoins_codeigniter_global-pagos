<!--
<div class="banner-interna">
	<img src="<?php //echo base_url('assets/images/banner/banner-compra.jpg') ?>" alt="Comprar Astropay" width="100%" >
</div>
-->

<form name="frm-compra" id="frm-compra" action="<?php echo base_url('comprar/grbcompra') ?>" data-acttc="<?php echo base_url('comprar/get_tc'); ?>" >
	<div class="container">
		<br><br>
		<div class="row">
			
			<div class="col-sm-12">
				<div class="progress prg-compra">
					<div class="progress-bar prg-compra-bar" role="progressbar" style="width: 30%; height: 5px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
				</div>

				<ul class="nav nav-justified nav-compra" role="tablist">
				  <li class="nav-item">
				    <a class="nav-link active" data-toggle="tab" href="#paso1" role="tab">1</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link mrauto" data-toggle="tab" href="#paso2" role="tab">2</a>
				  </li>
				  <li class="nav-item">
				    <a class="nav-link right" data-toggle="tab" href="#paso3" role="tab">3</a>
				  </li>
				</ul>
				<br>
				<div class="tab-content">
				  <div class="tab-pane fade show active" id="paso1" role="tabpanel">
				  	<h4 class="titulo-2">Seleccione una tarjeta</h4>

				  	<!--
				  	<div class="row justify-content-center">
				  		<div class="col-12 col-sm-12">
							<div class="row">
								<div class="col-sm-2 col-4">
									<div class="it-tarjeta btn-tarjeta" data-monto="25">
								  		<span class="lbl-tarjeta"><small>USD</small> 25</span>
								  		<img src="<?php echo base_url('assets/images/tarjetas/astropay-logo-white.7fb2ca11.svg') ?>" alt="Tarjeta 25">	
								  	</div>
								</div>
								<div class="col-sm-2 col-4">
									<div class="it-tarjeta btn-tarjeta" data-monto="50">
								  		<span class="lbl-tarjeta"><small>USD</small> 50</span>
								  		<img src="<?php echo base_url('assets/images/tarjetas/astropay-logo-white.7fb2ca11.svg') ?>" alt="Tarjeta 25">	
								  	</div>
								</div>
								<div class="col-sm-2 col-4">
									<div class="it-tarjeta btn-tarjeta" data-monto="100">
								  		<span class="lbl-tarjeta"><small>USD</small> 100</span>
								  		<img src="<?php echo base_url('assets/images/tarjetas/astropay-logo-white.7fb2ca11.svg') ?>" alt="Tarjeta 25">	
								  	</div>
								</div>

								<div class="col-sm-2 col-4">
									<div class="it-tarjeta btn-tarjeta" data-monto="200">
								  		<span class="lbl-tarjeta"><small>USD</small> 200</span>
								  		<img src="<?php echo base_url('assets/images/tarjetas/astropay-logo-white.7fb2ca11.svg') ?>" alt="Tarjeta 25">	
								  	</div>
								</div>
								<div class="col-sm-2 col-4">
									<div class="it-tarjeta btn-tarjeta" data-monto="500">
								  		<span class="lbl-tarjeta"><small>USD</small> 500</span>
								  		<img src="<?php echo base_url('assets/images/tarjetas/astropay-logo-white.7fb2ca11.svg') ?>" alt="Tarjeta 25">	
								  	</div>
								</div>
							</div> 
				  		</div>
				  	</div>
				  	<br>
				  	-->
				  	<div class="row justify-content-center">
						<div class="col-12 col-sm-8">
							<div class="form-group row caja-1">
							  <label for="monto_recarga" class="col-6 col-sm-2 col-form-label">Tarjetas disponibles en $</label>
							  <div class="col-6">
							  	<!--
							    <input type="number" name="monto_recarga" id="monto_recarga" class="form-control required" placeholder="100">
								-->
								<select name="monto_recarga" id="monto_recarga" class="form-control required">
									<option value="0">Seleccionar</option>
									<?php 
									if($rsTarjetas){
										foreach ($rsTarjetas as $key => $f){
										?>
											<option value="<?php echo $f['monto'] ?>"><?php echo $f['monto'] ?></option>
										<?php 
										} // fin foreach
									} // fin if $rsTarjetas
									?>
								</select>
							  </div>
							</div>

							<div class="form-group row caja-2">
							  <label for="tipo_cambio" class="col-6 col-sm-2 col-form-label">Tipo de Cambio</label>
							  <div class="col-6 col-sm-2">
							    <input type="number" name="tipo_cambio" id="tipo_cambio" class="form-control required" value="<?php echo $tc; ?>" readonly>
							  </div>
							  <div class="col-4 col-sm-2 sidebar-btnconvert">
							  	<button type="button" class="btn-cambio"><i class="fa fa-refresh"></i></button><br>
							  	<small>Click para Convertir</small><!-- btn-gettc -->
							  </div>
							  <div class="col-12 col-sm-4">
							  	<div class="input-group">
						        	<span class="input-group-addon"> CLP </span>
						  			<input type="number" name="monto_cambiado" id="monto_cambiado" class="form-control required" readonly>
						    	</div>
							  </div>
							</div>

							<div class="form-group row">
								<div class="col-12 col-sm-10">
									<input type="hidden" name="keyform" id="keyform" value="<?php echo $keyform ?>">
									<button type="button" class="btn btn-danger right btn-sgte" data-index="1">Siguiente <i class="fa fa-chevron-circle-right"></i></button>
									<button type="button" class="btn btn-inverse right btn-cambio"><i class="fa fa-refresh"></i> Calcular</button>
								</div>
							</div>
						</div>

						<div class="col-12 col-sm-4">
							<p class="info-msj">SOLO SE ACEPTARAN TRANSFERENCIAS DEL TITULAR DE LA CUENTA.</p>
							<p class="info-msj">SU ASTROPAY CARD SERA ENVIADA A SU CORREO O A SU BILLETERA ELECTRÓNICA (APP).</p>
							<p class="info-msj">RECIBIRÁS UN CORREO DE NOTIFICACIÓN DE COMPRA.</p>
						</div>
				  	</div>

				  </div>
				  <div class="tab-pane fade" id="paso2" role="tabpanel">
				  	<h4 class="titulo-2 center">Método de Pago</h4>

				  	<div class="row justify-content-center">

				  		<div class="col-12 col-sm-10">

				  			<div class="row justify-content-center">
							  <div class="col-6 col-md-2">
							  	<img class="card-img-top" src="<?php echo base_url('assets/images/logo-khipu.png') ?>" alt="KHIPU" >
							  	<br>
							  	<input type="radio" name="metodopago" id="metodopago" class="form-control chk-metodo-pago" checked value="1">
							  	<br>
							  </div>
							</div>

							<div class="row">
								<div class="col-sm-6">
									<p><u><strong>COMISIÓN KHIPU:</strong></u> <?php echo COMISION_KP ?> CLP</p>
									<ul>
										<li>khipu es la forma más simple, rápida y segura de pagar un producto o servicio: paga directamente desde tu cuenta bancaria.</li>
										<li>khipu es un sistema que simplifica las transferencias bancarias: usando el terminal de pagos, solo debes ingresar tus contraseñas y listo.</li>
										<li>También, puedes hacer una transferencia normal y khipu te enviará a ti y al cobrador los comprobantes de pago.</li>
									</ul>
									<p>
										khipu te protege de cometer errores en la transferencia y evita que tus tarjetas sean clonada y que tus contraseñas sean robadas. khipu es el método de pago que ofrece más seguro del mercado. Puedes conocer más visitando nuestra página <a href="https://cl.khipu.com/page/seguridad-para-el-pagador" target="_blank">Seguridad para el pagador</a>
									</p>
						  		</div>
						  		<div class="col-sm-6 sidebar-btnconvert">
						  			<div class="text-center">
										<iframe width="420" height="240" src="https://www.youtube.com/embed/DCji5TqmJGE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									</div>
						  		</div>
							</div>

				  		</div><!-- /col-sm-6 -->
				  	</div><!-- /row -->

					<div class="row caja-3 justify-content-center">
					  <div class="col-6 col-md-6 text-left">
							<button type="button" class="btn btn-inverse btn-regresa btn-sm" data-index="2"> VOLVER</button><br>
						</div>
						<div class="col-6 col-md-6 text-right">
					  		<button type="button" class="btn btn-danger right btn-sgte  btn-sm" data-index="2"> <i class="fa fa-send"></i> CONFIRMAR SOLICITUD</button><br>
						</div>
					</div>

				  </div>
				  <div class="tab-pane fade" id="paso3" role="tabpanel">
				  	<br>
				  	<div class="row ">
				  		<div class="col-sm-8 center">
				  			<p class="titulo-2 center msj-confirmacion">Los datos de su solicitud fueron enviados a su correo, así como
los datos de Información de pago para la transferencia bancaria. Una vez confirmada su transferencia el saldo se le abonara a través
de la aplicación móvil.</p>
							<br>
							<div class="row caja-1 justify-content-center">
							  <div class="col-md-4 label">Nro de Operación</div>
							  <div class="col-md-5 info info-nroope"></div>
							</div>

							<div class="row caja-2 justify-content-center">
							  <div class="col-md-4 label">Monto en Dolares</div>
							  <div class="col-md-5 info info-cantdolares"></div>
							</div>

							<div class="row caja-2 justify-content-center">
							  <div class="col-md-4 label">Monto en Pesos</div>
							  <div class="col-md-5 info info-cantpesos"></div>
							</div>

							<div class="row caja-1 justify-content-center">
							  <div class="col-md-4 label">Comisión <span class="info-empresa"></span></div>
							  <div class="col-md-5 info info-comision"></div>
							</div>

							<div class="row caja-1 justify-content-center">
							  <div class="col-md-4 label">Servicio de Cambio ($<?php echo number_format(COMISION_AP, 2, '.', ',').' USD'; ?>)</div>
							  <div class="col-md-5 info info-servcambio"></div>
							</div>

							<div class="row caja-3 justify-content-center">
							  <div class="col-md-4 label">Total a Pagar</div>
							  <div class="col-md-5 info info-totaloperacion"></div>
							</div>

							<br>
							<div class="row justify-content-center">
								<div class="col-6 col-md-4">
									<a href="<?php echo base_url('comprar'); ?>" class="btn btn-inverse btn-sm" >VOLVER A COMPRAR</a>
								</div>
								<div class="col-6 col-md-4">
									<a href="#" class="btn btn-danger btn-pasarela btn-sm" data-action="" >CONFIRMAR COMPRA</a>
								</div>
							</div>
				  		</div>

				  		<div class="col-12 col-sm-4">
							<p class="info-msj">SOLO SE ACEPTARAN TRANSFERENCIAS DEL TITULAR DE LA CUENTA.</p>
							<p class="info-msj">SU ASTROPAY CARD SERA ENVIADA A SU CORREO O A SU BILLETERA ELECTRÓNICA (APP).</p>
							<p class="info-msj">RECIBIRÁS UN CORREO DE NOTIFICACIÓN DE COMPRA.</p>
						</div>

				  	</div>
				  	<br>
				  </div>
				</div>
			</div>

		</div>
		<br><br>
	</div>
</form>

	<?php echo $template_footer; ?>
	
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	<script src="<?php echo base_url('assets/js/bootbox.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.loading.min.js') ?>"></script>

	<script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

	<script>
	MyApp.compra.init();
	</script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '662604004208715');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=662604004208715&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-172858986-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-172858986-1');
</script>


	</body>
</html>