<div class="container">
    <br>
    <div class="row">
        <div class="col-sm-12">
        <div class="invoice-title clearfix">
          <h2>PERUBIKESHOP</h2><h3 class="pull-right">Orden # <?php echo $ventas['codigo'] ?></h3>
        </div>
        
        <div class="row">
          <div class="col-sm-6">
            <address>
              <strong>Facturación:</strong><br>
              <span><?php echo $ventas['facturacion-nombre'] ?> <?php echo $ventas['facturacion-apellido'] ?></span><br>
              <span>Dir. <?php echo $ventas['facturacion-direccion'] ?></span><br>
              <span>Ref. <?php echo $ventas['facturacion-referencia'] ?></span><br>
              <span><?php echo $ventas['facturacion-distrito'] ?></span>
            </address>
          </div>
          <div class="col-sm-6 text-right">
            <address>
              <strong>Envío:</strong><br>
              <span><?php echo $ventas['envio-nombre'] ?> <?php echo $ventas['facturacion-apellido'] ?></span><br>
              <span>Dir. <?php echo $ventas['envio-direccion'] ?></span><br>
              <span>Ref. <?php echo $ventas['envio-referencia'] ?></span><br>
              <span><?php echo $ventas['envio-distrito'] ?></span>
            </address>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <address>
              <strong><?php echo $ventas['tipopago'] ?>:</strong><br>
              <?php echo nl2br($ventas['tp_instrucciones']); ?>
            </address>
          </div>
          <div class="col-sm-6 text-right">
            <address>
              <strong>Fecha:</strong><br>
              <?php 
                $fechaReg = $ventas['fechareg'];
                $fecFormat = $this->utilitario->getFormatFecha($fechaReg);
                echo $fecFormat;

              ?><br><br>
            </address>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row">
      <div class="col-sm-12">

        <div class="card border-pb">
          <div class="card-header ">
            <h3 class="card-title"><strong>Detalle de la Orden</strong></h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                      <td><strong>#</strong></td>
                      <td><strong>Foto</strong></td>
                      <td><strong>Producto</strong></td>
                      <td class="text-center"><strong>Precio</strong></td>
                      <td class="text-center"><strong>Cant.</strong></td>
                      <td class="text-right"><strong>Totales</strong></td>
                    </tr>
                </thead>

                <?php 
                if($detalles){
                ?>
                <tbody>
                  <?php 
                  $i = 1;
                  foreach ($detalles as $fila) {
                  ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><img src="<?php echo base_url('assets/upload/catalogo/'.$fila->foto); ?>" class="rounded img-thumbnail" width="100"> </td>
                      <td><?php echo $fila->sku.' - '.$fila->producto ?></td>
                      <td class="text-center">S/ <?php echo $fila->precunit ?></td>
                      <td class="text-center"><?php echo $fila->cantidad ?></td>
                      <td class="text-right">S/ <?php echo $fila->total ?></td>
                    </tr>
                  <?php 
                    $i++;
                  } // fin detalles
                  ?>
                </tbody>
                <?php 
                } // fin detalles
                ?>

                <tfoot>
                  <tr>
                    <td class="thick-line"></td>
                    <td class="thick-line"></td>
                    <td class="thick-line"></td>
                    <td class="thick-line"></td>
                    <td class="thick-line text-center"><strong>Subtotal:</strong></td>
                    <td class="thick-line text-right">S/ <?php echo $ventas['costo-subtotal'] ?></td>
                  </tr>
                  <tr>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="thick-line"></td>
                    <td class="no-line text-center"><strong>Envío:</strong></td>
                    <td class="no-line text-right">S/ <?php echo $ventas['costo-envio'] ?></td>
                  </tr>
                  <!--
                  <tr>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line text-center"><strong>IGV</strong></td>
                    <td class="no-line text-right">S/ <?php //echo $ventas['costo-igv'] ?></td>
                  </tr>
                  -->
                  <tr>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line"></td>
                    <td class="no-line text-center"><strong>Total:</strong></td>
                    <td class="no-line text-right">S/ <?php echo $ventas['costo-total'] ?></td>
                  </tr>
                </tfoot>

              </table>
              <br><br>
              <a href="<?php echo base_url('catalogo') ?>" class="btn btn-pbk btn-block" >CONTINUAR COMPRANDO</a>

            </div>
          </div>
        </div>

        <br><br>

      </div>
    </div>
</div>


<?php echo $template_footer; ?>

  <script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
  
  <script src="<?php echo base_url('assets/js/jquery.flexslider-min.js') ?>"></script>

  <script src="<?php echo base_url('assets/js/jquery-ui.js') ?>"></script>

  <script src="<?php echo base_url('assets/js/function.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

  <script>
    //MyApp.catalogo.init();
    MyApp.carrito.init();
  </script>

  </body>
</html>