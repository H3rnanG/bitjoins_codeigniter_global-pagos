
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Transacciones - Western Union </title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/font-awesome.min.css') ?>" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-fonts.css') ?>" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/dropzone.css') ?>" />

    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/loading/jquery.loading.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/chosen.css') ?>" />

    <!-- ace settings handler -->
    <script src="<?php echo base_url('assets/admin/js/ace-extra.js') ?>"></script>

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-part2.css') ?>" />
    <![endif]-->

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-ie.css') ?>" />
    <![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('assets/admin/js/html5shiv.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/respond.js') ?>"></script>
    <![endif]-->
  </head>
  
  <body class="no-skin">

    <?php echo $tmp_header ?>


    <div class="main-container" id="main-container">
        
        <?php echo $tmp_nav; ?>

        <div class="main-content">

          <div class="page-content">

            <div class="row">
              <div class="col-xs-12">
                <h2 class="header smaller lighter orange">Ventas WU - Cajero</h2>
                <div class="sidebar h-sidebar navbar-collapse ace-save-state">
                 <ul id="tabseccion" class="nav nav-list" >
                   <li class="active">
                      <a href="#home" data-toggle="tab">
                        <i class="menu-icon fa fa-list"></i>
                        <span class="menu-text"> Transacciones </span>
                      </a>
                   </li>
                 </ul>

                 <div class="tab-content">
                   <div class="tab-pane in active" id="home">
                     <form name="frm" id="frm" method="POST" target="_blank" action="<?php echo base_url('admin/ticketwestern') ?>">
                      <input type="hidden" name="edt_mnt" id="edt_mnt">
                      <input type="hidden" name="edt_sbt" id="edt_sbt">
                      <input type="hidden" name="edt_tc" id="edt_tc">
                      <input type="hidden" name="edt_appago" id="edt_appago">
                      <input type="hidden" name="edt_formato" id="edt_formato">
                      <input type="hidden" name="adjunto" id="adjunto">
                      <input type="hidden" name="edt_print" id="edt_print">

                      <div class="row">

                        <div class="col-sm-3">
                          <label>Vendedor</label>
                          <select name="rp1_vendedor" id="rp1_vendedor" class="form-control">
                            <?php 
                            if($rs_usuarios){
                              foreach ($rs_usuarios as $k => $f) {
                              ?>
                                <option value="<?php echo $f['id']; ?>"><?php echo $f['usuario']; ?> - <?php echo $f['nombres']; ?></option>
                              <?php 
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-sm-2">
                          <label>País</label>
                          <select name="rp1_pais" id="rp1_pais" class="form-control">
                            <option value="">Todos</option>
                            <option value="<?php echo OTROS ?>">Otros</option>
                            <option value="<?php echo COLOMBIA ?>">Colombia</option>
                          </select>
                        </div>

                        <div class="col-sm-2">
                          <label>Fecha</label>
                          <input type="date" name="rp1_fecha" id="rp1_fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" >
                        </div>

                        <div class="col-sm-2">
                          <button type="button" class="btn btn-primary" id="btn-rp1" ><i class="fa fa-search"></i> Filtrar </button>
                        </div>
                      </div>
                      <br>
                      <table id="reporte" class="table table-bordered table-hover reporte" width="100%" data-action="<?php echo site_url('calculadora/ajax_vista_ventaswu')?>">
                        <thead>
                            <tr>
                                <!--<th></th>-->
                                <th>Item</th>
                                <th>Pais</th>
                                <th>Tienda</th>
                                <th>Usuario</th>
                                <th>Monto</th>
                                <th>Cargo</th>
                                <th>IVA</th>
                                <th>Sub. Total</th> <!-- 2 -->
                                <th>Total Ventas</th> <!-- 3 -->
                                <th>TC</th> <!-- 4 -->
                                <th>Aprox Pago</th> <!-- 4 -->
                                <th>Utilidad Vta</th> <!-- 4 -->
                                <th>Fecha</th> <!-- 4 -->
                                <th>Hora</th> <!-- 7 -->
                                <th>Formato</th> <!-- 7 -->
                                <th>Original</th> <!-- 7 -->
                                <th>Modificado</th> <!-- 7 -->
                            </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <th colspan="8" style="text-align:right">Total:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th colspan="5"></th>
                          </tr>
                        </tfoot>
                      </table>
                      </form>
                     </div><!-- / #home -->

                 </div><!-- / .tab-content -->
                </div><!-- / .sidebar -->

              </div><!-- /.col -->
            </div><!-- /.row -->
            
          </div><!-- /.page-content -->
        </div><!-- /.main-content -->

    </div><!-- /.main-container -->

    <script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo base_url('assets/admin/js/jquery.js')?>'>"+"<"+"/script>");
    var modulo = '.md-ventaswu';
    </script>

    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url('assets/admin/js/jquery.mobile.custom.js')?>'>"+"<"+"/script>");
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url('assets/admin/js/dataTables/jquery.dataTables.bootstrap.js') ?>"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

    <script src="<?php echo base_url('assets/admin/js/dataTables/jquery.dataTables.bootstrap.js') ?>"></script>

    <!--[if lte IE 8]>
      <script src="<?php echo base_url('assets/admin/js/excanvas.js')?>"></script>
    <![endif]-->

    <script src="<?php echo base_url('assets/admin/js/ace/elements.aside.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/js/ace/ace.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/js/ace-elements.js')?>"></script>
    
    <script src="<?php echo base_url('assets/admin/js/ace/ace.touch-drag.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/js/ace/ace.sidebar.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/js/ace/ace.sidebar-scroll-1.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/js/ace/ace.submenu-hover.js')?>"></script>

    <script src="<?php echo base_url('assets/admin/js/dropzone.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/app/js/loading/jquery.loading.min.js'); ?>"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/chosen.jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/app/js/external/loading/jquery.loading.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/app/js/bootbox.min.js'); ?>"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <script src="<?php echo base_url('assets/admin/app/js/librarie.js')?>"></script>
    <script src="<?php echo base_url('assets/js/calculadora/app_calculadora.js')?>?v=<?php echo rand(1,999999); ?>"></script>

    <script type="text/javascript"> 
        ace.vars['base'] = '..'; 
        MyApp.ventaswu_usuario.init();
    </script>

  </body>
</html>

