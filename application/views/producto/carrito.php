
<div class="container">
	
	<div class="row">
		<div class="col-sm-12 sidebar-carrito">
			<table id="cart" class="table table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th style="width:50%">Producto</th>
						<th style="width:10%">Precio</th>
						<th style="width:8%">Cantidad</th>
						<th style="width:22%" class="text-center">Subtotal</th>
						<th style="width:10%"></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$datos = $carrito['carrito'];
					if(count($datos) > 0){
						foreach ($datos as $key => $fila) {
					?>
						<tr class="fila<?php echo $fila['id'] ?>">
							<td data-th="Product">
								<div class="row">
									<div class="col-sm-3 hidden-xs">
										<img src="<?php echo base_url('assets/upload/catalogo/'.$fila['foto']); ?>" alt="<?php echo $fila['producto'] ?>" class="img-thumbnail" />
									</div>
									<div class="col-sm-9">
										<p class="nomargin"><?php echo $fila['sku'] ?> - <?php echo $fila['producto'] ?></p>
									</div>
								</div>
							</td>
							<td data-th="Price">S/ <?php echo $fila['precio'] ?></td>
							<td data-th="Quantity">
								<input type="number" class="form-control text-center input-cantidad" value="<?php echo $fila['cantidad'] ?>">
							</td>
							<td data-th="Subtotal" class="text-center">S/ <?php echo $fila['total'] ?></td>
							<td class="actions" data-th="">
								<button class="btn btn-success btn-sm btn-actualiza" data-id="<?php echo $fila['id'] ?>" data-action="<?php echo base_url('ajax/editcart') ?>"><i class="fa fa-refresh"></i></button>
								<button class="btn btn-danger btn-sm btn-eliminar" data-id="<?php echo $fila['id'] ?>" data-action="<?php echo base_url('ajax/delcart') ?>"><i class="fa fa-trash-o"></i></button>							
							</td>
						</tr>
					<?php 
						} // fin foreach
					} // fin if
					?>
					<!-- other list items here -->
					
				</tbody>
				<tfoot>
					<?php 
					$total = $carrito['total'];
					?>
					<tr>
						<td>
							<a href="<?php echo base_url('catalogo') ?>" class="btn btn-comprar left"><i class="fa fa-angle-left"></i> Continuar comprando</a>
						</td>
						<td colspan="2" class="hidden-xs"></td>
						<td class="hidden-xs text-center"><strong>Total S/ <?php echo number_format($total,2,'.',''); ?></strong></td>
						<td><a href="<?php echo base_url('carrito/compra') ?>" class="btn btn-pbk btn-block"> Comprar ahora <i class="fa fa-angle-right"></i></a></td>
					</tr>
				</tfoot>
			</table>

		</div>

		<!--<div class="col-sm-2 sidebar-resumen">

		</div> / catalogo -->

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
    MyApp.carrito.init();
    MyApp.carrito.cesta();
  </script>

  </body>
</html>