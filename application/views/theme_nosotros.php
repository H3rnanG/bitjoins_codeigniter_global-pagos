
<div class="banner-interna">
	<img src="<?php echo base_url('assets/images/astropaynosotros.jpg') ?>" alt="Contacto Astropay" width="100%" >
</div>

<!-- SECCIÓN -->
<form name="frmContacto" id="frmContacto" method="post" >
	<div class="container contenido border-content">	

		<div class="row">
			
			<div class="col-sm-12">
				<br><h1 class="titulo-1">¿Interesado en contactarnos?</h1>
	      	</div>
		</div>

		<div class="row">
	    	
			<div class="col-sm-6">
				<p>AstroPay card es la la tarjeta virtual pre-paga más popular para realizar depósitos y retiros. Es aceptada en cientos de sitios online en todo el mundo. Es elegida por los usuarios por ser instantánea, flexible en sus límites, confidencial y segura. AstroPay card está disponible en varias monedas, entre ellas: EUR, USD, GBP, BRL, RMB, JPY, TRY, INR, THB, ARS.</p>
			</div>

			<div class="col-sm-6">
				<div class="center">
					<img src="<?php echo base_url('assets/images/img-relevante-v2.jpg') ?>" >
				</div>
			</div>

		</div>

	</div>
</form>
<!-- FIN SECCIÓN -->


	<?php echo $template_footer; ?>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

	<script src="<?php echo base_url('assets/js/jquery-ui.js') ?>"></script>
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


	</body>
</html>
