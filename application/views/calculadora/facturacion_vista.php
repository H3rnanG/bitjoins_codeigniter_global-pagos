
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Ticket Western Union </title>

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

                <h2 class="header smaller lighter orange">Pendientes de Facturación</h2>

                <div class="sidebar h-sidebar navbar-collapse ace-save-state">

                 <ul id="tabseccion" class="nav nav-list" >
                   <li class="active">
                      <a href="#home" data-toggle="tab">
                        <i class="menu-icon fa fa-file-text-o"></i>
                        <span class="menu-text"> Transacciones </span>
                      </a>
                   </li>
                 
                 </ul>

                 <div class="tab-content">
                   <div class="tab-pane in active" id="home">
                    <div class="row">
                      <label class="col-sm-1">Total: </label>
                      <div class="col-sm-2">
                        <input type="hidden" name="idordenes" id="idordenes">
                        <input type="text" name="monto_facts" id="monto_facts" class="form-control" value="0" readonly >
                      </div>
                      <div class="col-sm-2">
                        <button type="button" class="btn btn-primary btn-facturar" data-act="<?php echo base_url('calculadora/grabar_facturacion') ?>">
                          <i class="ace-icon fa fa-usd"></i>
                          Facturar
                        </button>
                      </div>

                    </div>
                    <div class="space-6"></div>

                    <div class="space-6"></div>
                    <table id="reporte_fact" class="table table-bordered table-hover reporte" width="100%" data-action="<?php echo site_url('calculadora/ajax_vista_facturacion')?>">
                      <thead>
                          <tr>
                              <th></th>
                              <th>Item</th>
                              <th>Usuario</th>
                              <th>Fecha / Hora</th> 
                              <th>Monto</th>
                          </tr>
                      </thead>
                    </table>
                   </div>

                 </div><!-- / tab-content -->

                </div>

              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.page-content -->
        </div><!-- /.main-content -->

    </div><!-- /.main-container -->

    <script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo base_url('assets/admin/js/jquery.js')?>'>"+"<"+"/script>");
    var modulo = '.md-facturacion';
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
        var id = '';
        MyApp.rptload.init('#reporte_fact',id); 
        MyApp.facturacion.init();
    </script>

  </body>
</html>

