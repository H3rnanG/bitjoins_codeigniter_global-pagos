
<form name="form-producto" id="form-producto" action="<?php echo base_url('ajax/addcart') ?>" >
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
					<li class="breadcrumb-item active"><?php echo $producto['sku'].' - '.$producto['nombre']; ?></li>
				</ol>
			</div>
		</div>
		
		<div class="row">

			<div class="col-sm-5">
				<div class="flexslider">
					<ul class="slides">
						<?php 
						if($fotos){
							?>
							<input type="hidden" name="foto" id="foto" class="required foto" value="<?php echo $producto['foto'] ?>">
							<?php 
							foreach ($fotos as $key => $fila) {
							?>
								<li data-thumb="<?php echo base_url('assets/upload/catalogo/'.$fila->foto) ?>" class="img-zoom">
									<img src="<?php echo base_url('assets/upload/catalogo/'.$fila->foto) ?>" alt="<?php echo $producto['sku'].$producto['nombre']; ?>" class="zoom">
								</li>
							<?php 
							}
						}
						?>
					</ul>
				</div>
				<br><br>
			</div>

			<?php 
			$modelo = $producto['modelo'];
			?>
			<div class="col-sm-4">
				<h1 class="proddet-titulo">
					<?php echo $producto['nombre'] ?> <br>
					<?php if(strlen($modelo) > 0) {?><small>(<?php echo $modelo; ?>)</small><?php } //fin if modelo ?>
				</h1>
				<h5>COD: <?php echo $producto['sku']; ?></h5>
				<p><?php echo $producto['descripcion'] ?></p>

				<strong>Características:</strong>
				<p><?php echo $producto['descripcion_larga'] ?></p>

				<strong>Accesorios:</strong>
				<p><?php echo $producto['accesorios'] ?></p>

				<p class="proddet-precio">S/ <?php echo number_format($producto['precio'],2,'.',''); ?> <small class="text-muted">incluido IGV.</small> </p>

				<div class="frm-opciones clearfix">
					<?php 
					if($colores){
						echo '<p><strong>Colores: </strong><span class="opcolor"></span> <input type="hidden" name="color" id="color" class="attributo required" maxlength="20"></p>';
						echo '<div class="sdbcolores"><ul class="lstcolores">';
						$it = 1;
						foreach ($colores as $key => $fila) {
						?>
							<li>
								<a data-img="<?php echo $fila->foto ?>" href="#" style="background-color:<?php echo $fila->dato ?>" data-eti="<?php echo $fila->etiqueta ?>" data-it="<?php echo $key; ?>"></a>
							</li>
						<?php 
						$it++;
						}
						echo '</ul></div>';
					}
					?>
				</div>
				<br>

				<div class="frm-opciones clearfix">
					<?php 
					if($talla){
						echo '<p><strong>Tallas: </strong><span class="opcion"></span> </p>';
						echo '<div class="sdbcolores">';
						?>
						<select name="talla" id="talla" class="form-control required attributo">
							<option value="">Seleccionar</option>
							<?php 
							$it = 1;
							foreach ($talla as $key => $fila) {
							?>
								<option value="<?php echo $fila->etiqueta ?>"><?php echo $fila->etiqueta ?></option>
							<?php 
							$it++;
							}
							?>
						</select>
						<?php
						echo '</ul></div>';
					}
					?>
				</div>
				<br>

				<div class="frm-producto clearfix">
					<div class="form-group row">
						<div class="col-sm-6">
							<input type="hidden" name="id" id="id" value="<?php echo $producto['id'] ?>">

							<button type="button" class="btn btn-pbk btn-block btn-prod-add" data-id="<?php echo $producto['id'] ?>" data-action="<?php echo base_url('ajax/addcart') ?>">
								<i class="fa fa-cart-plus" aria-hidden="true"></i> Agregar
							</button>
						</div>
						<label for="cantidad" class="col-sm-2 col-form-label">Cantidad</label>
						<div class="col-sm-3">
							<input type="number" class="form-control text-center input-cantidad" id="cantidad" name="cantidad" value="1" maxlength="3">
						</div>
					</div>
				</div>
				

			</div><!-- / catalogo -->

			<div class="col-sm-3 border border-top-0 border-right-0 border-bottom-0">

				<br>
				<div class="text-center">
					<img src="<?php echo base_url('assets/upload/marca/').$producto['logo'] ?>" alt="marca" class="img-fluid" >
				</div>
				
				<hr>
				<h3>Relacionados</h3>
				<hr>

			</div>

		</div><!-- / fin row -->

		<br><br>
	</div>
</form>

  <?php echo $template_footer; ?>

  <script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  
  <script src="<?php echo base_url('assets/js/jquery.flexslider-min.js') ?>"></script>

  <script src="<?php echo base_url('assets/js/jquery-ui.js') ?>"></script>

  <script src="<?php echo base_url('assets/js/zoom/jquery.zoom.min.js') ?>"></script>

  <script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

  <script>
    MyApp.producto.init();
    MyApp.carrito.init();
  </script>

  </body>
</html>