
<form name="frmdatos" id="frmdatos" method="post" action="<?php echo base_url('usuario/grbresetpass') ?>" >

	<div class="container">
		<br><br>
		<div class="row justify-content-md-center">
			<div class="col-sm-5">
				<h2>Ingrese su nuevo Password</h2>
				<hr>
				<p>Si no recuerdas tu Password, ingresa tu usuario y te enviaremos un link a tu correo para actualizar tus datos.</p>
				<br>
				<div class="msj"></div>
				<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>" >

				<div class="form-group row">
					<label class="col-md-12 control-label">Password</label>  
					<div class="col-md-12 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-key"></i></span>
							<input name="pass" id="pass" class="form-control" type="password" tabindex="1">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-12 control-label">Confirmar Password</label>  
					<div class="col-md-12 inputGroupContainer">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-key"></i></span>
							<input name="passconf" id="passconf" class="form-control" type="password" tabindex="2">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-sm-6">
						<input type="hidden" name="keyform" id="keyform" value="<?php echo $keyform; ?>">
						<button type="submit" tabindex="3" class="btn btn-danger"><i class="fa fa-send"></i> GRABAR</button>	
					</div>
				</div>
			</div>

		</div>
		
		<br><br>

    </div><!-- /.container -->

</form>
<!-- FIN SECCIÓN -->


	<?php echo $template_footer; ?>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	<script src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>

	<script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

	<script>
		MyApp.resetpassfrm.init();
	</script>

	</body>
</html>
