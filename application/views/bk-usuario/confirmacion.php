<!--
<div class="banner-interna">
	<img src="<?php echo base_url('assets/images/banner/banner-standar.jpg') ?>" alt="Contacto Astropay" width="100%" >
</div>

 SECCIÓN -->


	<div class="container">
		<br><br>
		<div class="jumbotron">
		  <h3 class="display-4">¡Tu cuenta ha sido activada exitósamente!</h3>
		  <p class="lead">El email <strong><?php echo $usuario ?></strong> ha sido confirmado exitosamente.</p>
		  <hr class="my-4">
		  <p></p>
		  <p class="lead">
		    <a href="<?php echo base_url('usuario/login'); ?>" class="btn btn-danger link-form right"> <i class="fa fa-user"></i> Iniciar Sesión</a>
		  </p>
		</div>
		<br><br>

    </div><!-- /.container -->

<!-- FIN SECCIÓN -->


	<?php echo $template_footer; ?>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	<script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

	<script>
		//MyApp.login.init();
	</script>

	</body>
</html>
