
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Administrador - Cajeros WU </title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/font-awesome.min.css') ?>?v=<?php echo rand(0,99999) ?>" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-fonts.css') ?>" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace.css') ?>?v=<?php echo rand(0,99999) ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/chosen.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/colorbox.css') ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.css" />

    <!-- custom styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/theme.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/loading/jquery.loading.min.css'); ?>">
    <link class="include" rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/app/css/jqplot/jquery.jqplot.min.css') ?>" />

    <!-- ace settings handler -->
    <script src="<?php echo base_url('assets/admin/js/ace-extra.js') ?>"></script>

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-part2.css') ?>" />
    <![endif]-->

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-ie.css') ?>" />
    <![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <script src="<?php echo base_url('assets/js/modernizr.js'); ?>"></script> 

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

                <h2 class="header smaller lighter orange">Cajeros</h2>

                <div class="sidebar h-sidebar navbar-collapse ace-save-state">

                 <ul id="tabseccion" class="nav nav-list" >
                   <li class="active">
                      <a href="#home" data-toggle="tab">
                        <i class="menu-icon fa fa-university"></i>
                        <span class="menu-text"> Tiendas </span>
                      </a>
                   </li>
                   
                   <li>
                      <a href="#form" data-toggle="tab">
                        <i class="menu-icon fa fa-wpforms"></i>
                        <span class="menu-text"> Datos </span>
                      </a>
                   </li>
                 
                 </ul>

                 <div class="tab-content">
                   <div class="tab-pane in active" id="home">
                     
                    <table id="reporte" class="table table-bordered table-hover reporte" width="100%" data-action="<?php echo site_url('admin/ajax_vista_tienda')?>">
                      <thead>
                          <tr>
                              <th></th>
                              <th>Item</th>
                              <th>ST</th>
                              <th>Nombres</th>
                              <th>Dirección</th>
                          </tr>
                      </thead>
                    </table>

                   </div>

                   <div class="tab-pane" id="form" data-action="<?php echo base_url('admin/get_tienda') ?>">
                    
                    <div class="row">
                      <div class="col-md-12">

                          <div class="row">
                            <div id="msj"></div>
                          </div>

                          <div class="col-md-8">
                            <form name="frm" id="frm" method="post" class="frmreg" action="<?php echo base_url('admin/grabar_tienda'); ?>" >
                              <input type="hidden" name="id" id="id">

                            <div class="row">
                              <div class="col-sm-6" >
                                <label>Nombres</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" >
                              </div>  
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-sm-6" >
                                <label>Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" >
                              </div>  
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-sm-3" >
                                <label>Estado</label>
                                <select name="estado" id="estado" class="form-control">
                                  <option value="<?php echo ON; ?>">ACTIVO</option>
                                  <option value="<?php echo OFF; ?>">INACTIVO</option>
                                </select>
                              </div>  
                            </div>
                            <br>
                            <div class="clearfix form-actions">
                              <button type="submit" id="save" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Grabar Datos</button>

                              <button type="button" id="button" class="btn btn-inverse btn-reiniciar"><i class="fa fa-eraser"></i> Nuevo</button>
                            </div>

                            </form>
                          </div><!-- /col-md-8 fin -->

                      </div>
                    </div>

                   </div>
                 </div>

                </div>

              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.page-content -->
        </div><!-- /.main-content -->

    </div><!-- /.main-container -->




    <script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo base_url('assets/admin/js/jquery.js')?>'>"+"<"+"/script>");
    </script>

    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url('assets/admin/js/jquery.mobile.custom.js')?>'>"+"<"+"/script>");

      var modulo = '.md-tienda';
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

    <script src="<?php echo base_url('assets/admin/js/jquery.colorbox.js')?>"></script>

    <script src="<?php echo base_url('assets/admin/app/js/external/loading/jquery.loading.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/app/js/bootbox.min.js'); ?>"></script>

    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/chosen.jquery.min.js') ?>"></script>

    <script src="<?php echo base_url('assets/js/ace/bootstrap-editable.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/ace/ace-editable.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.gritter/js/jquery.gritter.js'); ?>"></script>
    
    <script src="<?php echo base_url('assets/admin/app/js/librarie.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/app/js/app.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

    <script type="text/javascript"> 
        ace.vars['base'] = '..'; 
        $(document).ready(function(){
          MyApp.maestros.init();
          //MyApp.usuarios.init();
        });

    </script>

  </body>
</html>

