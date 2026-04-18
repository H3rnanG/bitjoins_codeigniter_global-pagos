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
	<script src="<?php echo base_url('assets/js/bootbox.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

	<script>
		//MyApp.login.init();
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
