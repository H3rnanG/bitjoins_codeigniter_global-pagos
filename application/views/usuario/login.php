<!--
<div class="banner-interna">
	<img src="<?php echo base_url('assets/images/banner/banner-registrarse.jpg') ?>" alt="Contacto Astropay" width="100%" >
</div>

 SECCIÓN -->
<form name="frmdatos" id="frmdatos" method="post" action="<?php echo base_url('usuario/loguear') ?>" >

	<div class="container">
		<br><br>
		<div class="row">
			<div class="col-sm-6">
				<h2>Inicio de Sesión</h2>
				<hr>
				<div class="msj"></div>
				<br>
				<div class="form-group row">
					<label class="col-md-12 control-label">E-Mail (Usuario)</label>  
					<div class="col-md-12">
						<div class="input-group">
						    <div class="input-group-prepend">
							    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
						  	</div>
						  	<input name="usuario" id="usuario" placeholder="E-Mail" class="form-control"  type="text" tabindex="1">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-12 control-label">Password</label>  
					<div class="col-md-12">
						<div class="input-group">
						    <div class="input-group-prepend">
							    <span class="input-group-text"><i class="fa fa-key"></i></span>
						  	</div>
						  	<input name="pass" id="pass" class="form-control" type="password" tabindex="2">
						</div>
					</div>
				</div>

				<div class="form-group row">
					<div class="col-sm-12">
						<input type="hidden" name="keyform" id="keyform" value="<?php echo $keyform; ?>">
						<button type="submit" class="btn btn-danger" tabindex="3"><i class="fa fa-send"></i> ENVIAR</button>	
						<a href="<?php echo base_url('usuario/resetpass'); ?>" class="btn btn-inverse">¿Olvidaste tu contraseña?</a>
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<h2>Registro de Usuario</h2>
				<hr>
				<br>
				<p>Si aun no estas registrado con nosotros, puedes ir a la sección de registro para registrar tus datos y así poder acceder a comprar.</p>
				<a href="<?php echo base_url('usuario'); ?>" class="btn btn-danger link-form right"> <i class="fa fa-user"></i> Registro de Usuario</a>
			</div>

		</div>
		
		<br><br>

    </div><!-- /.container -->
</form>
<!-- FIN SECCIÓN -->

<div id="usurionoactivo" class="none">
	<div class="row">
		<div class="col-12 msj">
			<p>Su usuario aun no ha sido <u>activado</u>, siga los pasos aqui abajo para activarlo. También nos puede contactar a través del <strong>WhatsApp al Nro. <a href="http://bit.ly/AstroPaycardCL" target="_blank"> <i class="fa fa-whatsapp"></i> +56 930173871</a></strong></p>
		</div>
	</div>
	<div class="row">
		<div class="col-3">
			<p><img src="<?php echo base_url('assets/images/login/bandeja-entrada.jpg') ?>" class="img-fluid" ></p>
			<h4>PASO 1</h4>
			<p>Ingrese a su Bandeja de Entrada y ubique el correo con asunto <strong>"AstroPay Card - Confirmación de Email"</strong>. </p>
		</div>
		<div class="col-3">
			<p><img src="<?php echo base_url('assets/images/login/activa-correo.jpg') ?>" class="img-fluid" ></p>
			<h4>PASO 2</h4>
			<p>Dentro del correo ubique el boton de activación <strong>CONFIRMAR AQUÍ</strong>, dele click para activar su usuario. </p>
		</div>
		<div class="col-3">
			<p><img src="<?php echo base_url('assets/images/login/registro-datos.jpg') ?>" class="img-fluid" ></p>
			<h4>PASO 3</h4>
			<p>Al confirmar su correo debe completar los datos del formulario para su perfil con información veraz.</p>
		</div>
		<div class="col-3">
			<p><img src="<?php echo base_url('assets/images/login/acceso-login.jpg') ?>" class="img-fluid" ></p>
			<h4>PASO 4</h4>
			<p>Ingrese su usuario y password en los campos requeridos ingrese: <a href="<?php echo base_url('usuario/login') ?>">Click Aquí</a>. </p>
		</div>
	</div>
</div>

<div id="errorpassword" class="none">
	<div class="row">
		<div class="col-5">
			<img src="<?php echo base_url('assets/images/login/password-error.jpg') ?>" class="img-fluid" >
		</div>
		<div class="col-7">
			<h4>El password ingresado es incorrecto por favor vuelva a intentarlo, si no lo recuerda puede resetear su Password dando <a href="<?php echo base_url('usuario/resetpass') ?>"> click aquí</a>.</h4>
		</div>
	</div>
</div>

<div id="errorusuario" class="none">
	<div class="row">
		<div class="col-5">
			<img src="<?php echo base_url('assets/images/login/usuario-error.jpg') ?>" class="img-fluid" >
		</div>
		<div class="col-7">
			<h4>El usuario ingresado es incorrecto por favor vuelva a intentarlo, si aun no se a registrado puede realizarlo dando <a href="<?php echo base_url('usuario') ?>"> click aquí</a>.</h4>
		</div>
	</div>
</div>

	<?php echo $template_footer; ?>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<script src="https://www.google.com/recaptcha/api.js?render=6LeV480ZAAAAAH15AZpw7tRYqoKBxjabT5QwvEuk"></script>
	
	<script src="<?php echo base_url('assets/js/jquery.loading.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/bootbox.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.validate.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

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

	<script>
		MyApp.login.init();
	</script>


	</body>
</html>
