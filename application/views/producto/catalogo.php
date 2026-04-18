
<div class="container">
	
	<div class="row">
		<div class="col-sm-3 sidebar-atributos">
			<h2>Categoría: <small><?php echo $titCatalogo ?></small></h2>
			<hr class="border-hr">

			<?php 
			if($rsCategorias){
			?>
			<ul class="opCategorias">
				<?php 
				foreach ($rsCategorias as $f) {
				?>
					<li><a href="<?php echo base_url('catalogo/index/'.$f->nombre) ?>"><?php echo $f->nombre ?></a></li>
				<?php 
				} // fin foreach
				?>
			</ul>
			<?php
			} // rsCategorias
			?>
			<br>
			<hr class="">
			<div class="prod-nav clearfix">
				<ul class="opAtributos" id="colores" data-action="<?php echo base_url('ajax/getatributo/'.COLORES); ?>"></ul>	
			</div>
			<br>
			<hr class="">
			<div class="prod-nav clearfix">
				<ul class="opAtributos" id="tallas" data-action="<?php echo base_url('ajax/getatributo/'.TALLAS); ?>"></ul>
			</div>
			

		</div>

		<div class="col-sm-9 catalogo">
			<h2><?php echo $titCatalogo ?></h2>
			<hr class="border-hr">
			<img src="<?php echo base_url('assets/upload/banners/banner-catalogo.jpg') ?>" class="img-fluid">
			<hr class="border-hr">
			<ul class="prod-grid clearfix">

				<?php 
				if(count($rsdatos) > 0){
					$f = 1;
					foreach ($rsdatos as $key => $fila) {
						//if($f == 1){ echo '<div class="row">'; } 
					?>
						<li>
							<div class="prod-item" data-item="<?php echo $fila->id ?>">
								<a href="<?php echo base_url('producto/'.$fila->urlkey) ?>">
									<div class="prod-galeria" data-slide="<?php echo $fila->id ?>">
										<img src="<?php echo base_url('assets/upload/catalogo/'.$fila->foto) ?>" alt="<?php echo $fila->nombre ?>" class="">
									</div>
								</a>

								<div class="prod-info">
									<a href="<?php echo base_url('producto/'.$fila->urlkey) ?>" class="prod-titulo" >
										<?php echo $fila->nombre ?> <small>(Cod: <?php echo $fila->sku ?>)</small>
									</a>
									<em class="prod-precio">Precio: S/ <?php echo $fila->precio ?></em>
								</div> <!-- cd-item-info -->

								<div class="prod-nav prod-nav-<?php echo $fila->id ?> clearfix">
									<ol></ol>
								</div>

								<div class="sdb-action clearfix">
									<a href="<?php echo base_url('producto/'.$fila->urlkey) ?>" class="btn-prod-mas"><i class="fa fa-plus-square"></i> Ver mas</a>
									<!--<button class="add-to-cart right " data-id="<?php //echo $fila->id ?>" data-action="<?php //echo base_url('ajax/addcart') ?>"><i class="fa fa-cart-plus" aria-hidden="true"></i></button>-->
								</div>
							</div> <!-- .prod-item -->
						</li>
				<?php 
					} // fin foreach
				} // fin if
				?>
				<!-- other list items here -->
			</ul> <!-- .prod-grid -->

			<?php 
			if($paginas){
			?>
				<div class="clearfix paginacion">
					<div class="paginas">
						<?php echo $paginas; ?>	
					</div>
				</div>
			<?php 
			} // fin if paginas
			?>
		</div><!-- / catalogo -->

	</div><!-- / fin row -->
</div>

<?php echo $template_footer; ?>

  <script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  
  <script src="<?php echo base_url('assets/js/jquery.flexslider-min.js') ?>"></script>

  <script src="<?php echo base_url('assets/js/jquery-ui.js') ?>"></script>

  <script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

  <script>
    var repoImg = '<?php echo base_url('assets/upload/catalogo') ?>';

    MyApp.catalogo.init('<?php echo base_url('ajax/getcolores') ?>');
    MyApp.carrito.init();
  </script>

  </body>
</html>