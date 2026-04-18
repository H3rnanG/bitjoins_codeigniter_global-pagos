
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Calculadora FDX </title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/font-awesome.min.css') ?>" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-fonts.css') ?>" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace.css') ?>?v=<?php echo rand(0,9999999) ?>" />

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
                <div class="col-md-12">
                  <div class="widget-box">
                     <div class="widget-header">
                        <h4 class="widget-title smaller">
                          <i class="ace-icon fa fa-calculator"></i><span>Calculadora</span>
                        </h4>
                     </div>
                     <div class="widget-body">
                        <div class="widget-main">

                          <div class="row">

                            <div class="col-sm-5">
                              
                              <div class="row">

                                <div class="col-sm-9">
                                  <label for="pais">PAÍS</label>
                                  <select id="pais" name="pais" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <?php 
                                    if($rsPais){
                                      foreach ($rsPais as $key => $fp) {
                                        echo '<option value="'.$fp['id'].'" data-fdx="'.$fp['zona_fdx_ie'].'" data-dhl="'.$fp['zona_dhl_ie'].'" >'.$fp['nombre'].'</option>';
                                      } // foreach
                                    } // if
                                    ?>
                                  </select>
                                </div>

                                <div class="col-sm-3">
                                  <label for="peso">PESO</label>
                                  <input type="number" id="peso" name="peso" class="form-control" step="0.5" autocomplete="off" value="1">
                                </div>
                              </div>
                              <div class="space-6"></div>
                              <div class="row">
                                <div class="col-sm-12">
                                  <button type="button" id="btnfedex" class="btn btn-primary pull-right" data-act="<?php echo base_url('calculadora/get_fdx') ?>"> 
                                    <i class="fa fa-calculator"></i> COTIZAR
                                  </button>
                                </div>
                              </div>

                              <div class="hr hr-dotted hr-16"></div>    

                              <div class="row">
                                <div class="col-sm-8">
                                  <div class="input-group">
                                    <span class="input-group-addon">CLP</span>
                                    <input class="form-control" type="text" id="cotifedex" name="cotifedex" readonly >
                                    <span class="input-group-addon fdxklg1">1KL</span>
                                  </div>
                                </div>
                              </div>
                              
                              <div class="space-6"></div>
                              
                              <div class="row">
                                <div class="col-sm-8">
                                  <div class="input-group">
                                    <span class="input-group-addon">CLP</span>
                                    <input class="form-control" type="text" id="cotifedex10" name="cotifedex10" readonly >
                                    <span class="input-group-addon fdxklg10">10KL</span>
                                  </div>
                                </div>
                              </div>
                              
                              <div class="space-6"></div>

                              <div class="row">
                                <div class="col-sm-8">
                                  <div class="input-group">
                                    <span class="input-group-addon">CLP</span>
                                    <input class="form-control" type="text" id="cotifedex20" name="cotifedex20" readonly >
                                    <span class="input-group-addon fdxklg20">20KL</span>
                                  </div>
                                </div>
                              </div>

                              <div class="space-6"></div>

                            </div>

                            <div class="col-sm-3 text-center">
                              <div class="space-6"></div>
                              <img src="<?php echo base_url('assets/images/calculadora/fedex-logo.jpg') ?>" class="img-responsive" >
                              <div class="space-6"></div>
                            </div>
                          </div>

                        </div>
                     </div>
                   </div>
                </div>
            </div>
            <!-- /.row -->


          </div><!-- /.page-content -->
        </div><!-- /.main-content -->

    </div><!-- /.main-container -->

    <script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo base_url('assets/admin/js/jquery.js')?>'>"+"<"+"/script>");
    var modulo = '.md-calc1';
    </script>

    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url('assets/admin/js/jquery.mobile.custom.js')?>'>"+"<"+"/script>");
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!--[if lte IE 8]>
      <script src="<?php echo base_url('assets/admin/js/excanvas.js')?>"></script>
    <![endif]-->

    <script src="<?php echo base_url('assets/admin/js/ace/elements.aside.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/js/ace/ace.js')?>"></script>
    
    <script src="<?php echo base_url('assets/admin/js/ace/ace.touch-drag.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/js/ace/ace.sidebar.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/js/ace/ace.sidebar-scroll-1.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/js/ace/ace.submenu-hover.js')?>"></script>

    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/chosen.jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/app/js/external/loading/jquery.loading.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/app/js/bootbox.min.js'); ?>"></script>

    <script src="<?php echo base_url('assets/admin/app/js/librarie.js')?>"></script>
    <script src="<?php echo base_url('assets/js/calculadora/app_calculadora.js')?>"></script>

    <script type="text/javascript"> 
        ace.vars['base'] = '..'; 
        MyApp.acceso.init();
    </script>

  </body>
</html>

