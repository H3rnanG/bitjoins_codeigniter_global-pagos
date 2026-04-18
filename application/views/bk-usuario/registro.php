<!--
<div class="banner-interna">
	<img src="<?php echo base_url('assets/images/banner/banner-registrarse.jpg') ?>" alt="Contacto Astropay" width="100%" >
</div>

 SECCIÓN -->
	<div class="container">

		<div class="msj"></div>
		<!-- Text input-->
		<br>
		<h2>Información de Inicio de Sesión</h2>
		<form name="frmdatos" id="frmdatos" method="post" action="<?php echo base_url('usuario/registro') ?>" >
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="col-md-12 control-label">E-Mail (Usuario)</label>  
				    <div class="col-md-12 inputGroupContainer">
					    <div class="input-group">
					        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
					  		<input name="usuario" id="usuario" placeholder="E-Mail" class="form-control"  type="text" tabindex="1">
					    </div>
				  	</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="col-md-12 control-label">Nombres</label>  
				    <div class="col-md-12 inputGroupContainer">
					    <div class="input-group">
					        <span class="input-group-addon"><i class="fa fa-user"></i></span>
					  		<input name="nombres" id="nombres" placeholder="Nombres" class="form-control"  type="text" tabindex="2">
					    </div>
				  	</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label class="col-md-12 control-label">Apellidos</label>  
				    <div class="col-md-12 inputGroupContainer">
					    <div class="input-group">
					        <span class="input-group-addon"><i class="fa fa-user"></i></span>
					  		<input name="apellidos" id="apellidos" placeholder="Apellidos" class="form-control"  type="text" tabindex="3">
					    </div>
				  	</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label class="col-md-12 control-label">Password</label>  
					<div class="col-md-12 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-key"></i></span>
							<input name="pass" id="pass" class="form-control" type="password" tabindex="4">
						</div>
					</div>
				</div>

			</div>

			<div class="col-sm-6">
				<div class="form-group">
					<label class="col-md-12 control-label">Confirmar Password</label>  
					<div class="col-md-12 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-key"></i></span>
							<input name="passconf" id="passconf" class="form-control" type="password" tabindex="5">
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-6">
						<input type="hidden" name="keyform" id="keyform" value="<?php echo $keyform; ?>">
						<button type="submit" class="btn btn-danger"><i class="fa fa-send" tabindex="6"></i> REGISTRATE</button>
					</div>
				</div>

			</div>

		</div>

		
		
		<br><br>

    </div><!-- /.container -->


<!-- FIN SECCIÓN -->


	<?php echo $template_footer; ?>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	<script src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>

	<script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

	<script>
		MyApp.registro.init();
	</script>


	</body>
</html>
