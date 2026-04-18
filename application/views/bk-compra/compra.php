<!--
<div class="banner-interna">
	<img src="<?php //echo base_url('assets/images/banner/banner-compra.jpg') ?>" alt="Comprar Astropay" width="100%" >
</div>

-->

<form name="frm-compra" id="frm-compra" action="<?php echo base_url('comprar/grbcompra') ?>">
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
				  	<br>

				  	<h4 class="titulo-2">Seleccione una tarjeta</h4>

				  	<div class="row justify-content-center">
				  		<div class="col-sm-8">
				  			<div class="card-group">
							  <div class="card it-tarjeta">
							  	<img class="card-img-top btn-tarjeta" src="<?php echo base_url('assets/images/tarjetas/tarjeta-25.jpg') ?>" alt="Tarjeta 25" data-monto="25">
							  </div>

							  <div class="card it-tarjeta">
							    <img class="card-img-top btn-tarjeta" src="<?php echo base_url('assets/images/tarjetas/tarjeta-50.jpg') ?>" alt="Tarjeta 50" data-monto="50">
							  </div>

							  <div class="card it-tarjeta">
							    <img class="card-img-top btn-tarjeta" src="<?php echo base_url('assets/images/tarjetas/tarjeta-100.jpg') ?>" alt="Tarjeta 100" data-monto="100">
							  </div>
							 
							</div>	
				  		</div>
				  	</div>

				  	<div class="row justify-content-center">
				  		<div class="col-sm-8">

				  			<div class="card-group">
							  <div class="card it-tarjeta">
							  	<img class="card-img-top btn-tarjeta" src="<?php echo base_url('assets/images/tarjetas/tarjeta-200.jpg') ?>" alt="Tarjeta 200" data-monto="200">
							  </div>

							  <div class="card it-tarjeta">
							    <img class="card-img-top btn-tarjeta" src="<?php echo base_url('assets/images/tarjetas/tarjeta-500.jpg') ?>" alt="Tarjeta 500" data-monto="500">
							  </div>

							  <div class="card it-tarjeta">
							    <img class="card-img-top btn-tarjeta" src="<?php echo base_url('assets/images/tarjetas/tarjeta-xxx.jpg') ?>" alt="Tarjeta Personalizada"  data-monto="">
							    <span class="center">Personaliza el monto de tu tarjeta.</span>
							  </div>
							</div>	
							<br><br>
							<div class="clearfix">
								<div class="form-group row caja-1">
								  <label for="monto_recarga" class="col-2 col-form-label">Ingresa el monto</label>
								  <div class="col-8">
								    <input type="number" name="monto_recarga" id="monto_recarga" class="form-control required" placeholder="100">
								  </div>
								</div>

								<div class="form-group row caja-2">
								  <label for="tipo_cambio" class="col-2 col-form-label">Tipo de Cambio</label>
								  <div class="col-2">
								    <input type="number" name="tipo_cambio" id="tipo_cambio" class="form-control required" value="<?php echo $tc; ?>" readonly>
								  </div>
								  <div class="col-2">
								  	<button type="button" class="btn-cambio"><i class="fa fa-refresh"></i></button><br>
								  	<small>Click para Convertir</small>
								  </div>
								  <div class="col-2">
								    <input type="number" name="monto_cambiado" id="monto_cambiado" class="form-control required" readonly>
								  </div>
								  <div class="col-2">
								  	<div class="etiqueta-mon">CLP</div>
								  </div>
								</div>

								<div class="form-group row">
									<div class="col-10">
										<input type="hidden" name="keyform" id="keyform" value="<?php echo $keyform ?>">
										<button type="button" class="btn btn-danger right btn-sgte" data-index="1">Siguiente <i class="fa fa-chevron-circle-right"></i></button>
									</div>
								</div>
							</div>
				  		</div>
				  	</div>

				  </div>
				  <div class="tab-pane fade" id="paso2" role="tabpanel">
				  	<br>
				  	<h4 class="titulo-2 center">Información de pago</h4>
				  	<!--
				  		<div class="row caja-3 justify-content-center">
					  <div class="col-md-3 label">RUC</div>
					  <div class="col-md-6 info">20603044275 </div>
					</div>
					-->
					<div class="row justify-content-center">
					  <div class="col-md-4">
					  	<img class="card-img-top" src="<?php echo base_url('assets/images/logo-banco-de-chile.jpg') ?>" alt="BANCO CHILE">
					  </div>
					</div>
					<div class="row caja-1 justify-content-center">
					  <div class="col-md-3 label">Banco</div>
					  <div class="col-md-6 info">BANCO CHILE</div>
					</div>

					<div class="row caja-1 justify-content-center">
					  <div class="col-md-3 label">Producto</div>
					  <div class="col-md-6 info">CUENTA CORRIENTE </div>
					</div>
					<div class="row caja-2 justify-content-center">
					  <div class="col-md-3 label">Nro. Cuenta</div>
					  <div class="col-md-6 info">800-15017-01 </div>
					</div>
					<div class="row caja-2 justify-content-center">
					  <div class="col-md-3 label">RUT</div>
					  <div class="col-md-6 info">76.217.027-2 </div>
					</div>
					<div class="row caja-2 justify-content-center">
					  <div class="col-md-3 label">Nombre</div>
					  <div class="col-md-6 info">Terrel Y Compania Limitada </div>
					</div>
					<div class="row caja-1 justify-content-center">
					  <div class="col-md-3 label">Correo</div>
					  <div class="col-md-6 info">soporte@astropaycard.cl</div>
					</div>
					<div class="row caja-2 justify-content-center">
					  <div class="col-md-3 label">Asunto</div>
					  <div class="col-md-6 info">Confirmo compra AstroPay card USD <span class="info-usd">0.00</span></div>
					</div>
					<div class="row caja-3 justify-content-center">
					  <div class="col-md-3 label">Monto</div>
					  <div class="col-md-6 info">CLP <span class="info-clp">0.00</span> </div>
					</div>

					<div class="row caja-3 justify-content-center">
					  <div class="col-md-4">
					  	<button type="button" class="btn btn-danger right btn-sgte" data-index="2"> <i class="fa fa-send"></i> CONFIRMAR SOLICITUD DE COMPRA</button>
					  </div>
					</div>

				  </div>
				  <div class="tab-pane fade" id="paso3" role="tabpanel">
				  	<br>
				  	<div class="row  justify-content-center">
				  		<div class="col-sm-8 center">
				  			<p class="titulo-2 center msj-confirmacion">Los datos de su solicitud fueron enviados a su correo, así como
los datos de Información de pago para la transferencia bancaria. Una vez confirmada su transferencia el saldo se le abonara a través
de la aplicación móvil.</p>
					  		<div class="row caja-1 justify-content-center">
							  <div class="col-md-3 label">Nro de Operación</div>
							  <div class="col-md-4 info info-nroope"></div>
							</div>
							<br>
							<div class="row justify-content-center">
								<div class="col-md-4">
									<a href="<?php echo base_url('comprar'); ?>" class="btn btn-danger" >VOLVER A COMPRAR</a>
								</div>
							</div>
				  		</div>
				  	</div>
				  	<br>
				  </div>
				</div>

				<br>
				<div class="row justify-content-center">
					<div class="col-8">
						<p class="info-msj">SOLO SE ACEPTARAN TRANSFERENCIAS DEL TITULAR DE LA CUENTA.</p>
						<p class="info-msj">SU ASTROPAY CARD SERA ENVIADA A SU CORREO O A SU BILLETERA ELECTRÓNICA (APP).</p>
						<p class="info-msj">RECIBIRÁS UN CORREO DE NOTIFICACIÓN DE COMPRA.</p>
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

	<script src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>

	<script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

	<script>
	MyApp.compra.init();
	</script>

	</body>
</html>