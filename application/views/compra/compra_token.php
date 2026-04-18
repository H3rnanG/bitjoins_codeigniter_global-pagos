<!--
<div class="banner-interna">
	<img src="<?php //echo base_url('assets/images/banner/banner-compra.jpg') ?>" alt="Comprar Astropay" width="100%" >
</div>

-->

<form name="frm-token" id="frm-token" action="<?php echo base_url('usuario/validatoken') ?>" autocomplete="off" method="post" >
	<div class="container">
		<br><br>
		<h4 class="titulo-2">Solo falta un paso para que puedas comprar con AstroPay card.</h4>
	  	<p>Ingrese el código que enviamos a su <u>número de celular</u>, para validar tus datos ingresados.</p>

	  	<div class="row">
			<div class="col-sm-6">
				<label class="control-label"><strong>Celular</strong></label>  
				<div class="input-group">
				    <div class="input-group-prepend">
					    <span class="input-group-text"><i class="fa fa-mobile"></i></span>
				  	</div>
				  	<input name="celular" id="celular" class="form-control"  type="text" tabindex="1" value="<?php echo $celular ?>">
				</div>
				<div class="space"></div>
				<span>Reenviar código al número de celular <a href="#" class="btn-sendtoken" data-action="<?php echo base_url('usuario/generatoken'); ?>" >Click Aquí</a>. <br>
					<u>Recuerde que el número que ingrese quedara asociado a su usuario.</u></span>
			</div>

			<div class="col-sm-6">
				<label class="control-label"><strong>Código de confirmación</strong></label>  
				<div class="input-group">
				    <div class="input-group-prepend">
					    <span class="input-group-text"><i class="fa fa-hashtag"></i></span>
				  	</div>
				  	<input name="token" id="token" class="form-control"  type="text" tabindex="2">
				</div>
			</div>
		</div>
		<div class="space"></div>

		<div class="row">
			<div class="col-sm-12 center">
				<button type="submit" class="btn btn-danger btn-token">Enviar <i class="fa fa-chevron-circle-right"></i></button>
			</div>
		</div>


		<br><br>
	</div>
</form>

	<?php echo $template_footer; ?>
	
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<script src="https://www.google.com/recaptcha/api.js?render=6LeV480ZAAAAAH15AZpw7tRYqoKBxjabT5QwvEuk"></script>

	<script src="<?php echo base_url('assets/js/bootbox.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.loading.min.js') ?>"></script>

	<script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

	<script>
	MyApp.validatoken.init();
	</script>

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