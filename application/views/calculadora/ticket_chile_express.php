
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Ticket Chile Express </title>

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
            <form name="frm" id="frm" method="POST" target="_blank" action="<?php echo base_url('calculadora/ticketwestern') ?>">
            <div class="row">
                <div class="col-md-12">
                  <div class="widget-box">
                     <div class="widget-header">
                        <h4 class="widget-title smaller">
                          <i class="ace-icon fa fa-ticket"></i><span>Ticket de Transferencia</span>
                        </h4>
                     </div>
                     <div class="widget-body">
                        <div class="widget-main">

                          <div class="row">

                            <div class="col-sm-5">
                              <h3>Montos PDF</h3>
                              <div class="hr hr-dotted hr-16"></div>

                              <input type="hidden" id="ing_com" name="ing_com" value="<?php echo $cargo ?>" >

                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="input-group">
                                    <span class="input-group-addon">MONTO&nbsp;&nbsp;</span>
                                    <input class="form-control" type="text" id="ing_mnt" name="ing_mnt" autocomplete="off"> <!--  -->
                                    <span class="input-group-addon fdxklg1">CLP</span>
                                  </div>
                                </div>
                              </div>

                              <div class="space-6"></div>

                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="input-group">
                                    <span class="input-group-addon">TARIFA&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <input class="form-control" type="text" id="ing_tarifa" name="ing_tarifa" autocomplete="off" >
                                    <span class="input-group-addon fdxklg1">CLP</span>
                                  </div>
                                </div>
                              </div>
                              <div class="space-6"></div>

                              <div class="row">
                                <div class="col-sm-5">
                                  <div class="input-group">
                                    <span class="input-group-addon">% IVA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <input type="number" name="ing_iva" id="ing_iva" value="19"  readonly>
                                  </div>
                                </div>

                                <div class="col-sm-7">
                                  <div class="input-group">
                                    <span class="input-group-addon">T. IVA</span>
                                    <input class="form-control" type="number" id="ing_tiva" name="ing_tiva" readonly >
                                    <span class="input-group-addon fdxklg1">CLP</span>
                                  </div>
                                </div>
                              </div>

                              <div class="space-6"></div>

                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="input-group">
                                    <span class="input-group-addon">CARGO&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <input class="form-control" type="text" id="ing_cargo" name="ing_cargo" readonly >
                                    <span class="input-group-addon">CLP</span>
                                  </div>
                                </div>
                              </div>

                              <div class="space-6"></div>

                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="input-group">
                                    <span class="input-group-addon">UTILIDAD</span>
                                    <input class="form-control" type="text" id="ing_utilidad" name="ing_utilidad" readonly >
                                    <span class="input-group-addon">CLP</span>
                                  </div>
                                </div>
                              </div>

                              
                              <div class="space-6"></div>
                              <div class="row">
                                <div class="col-sm-12">
                                  <button type="button" id="btnrefresh" class="btn btn-primary btn-sm pull-right" > 
                                    <i class="fa fa-refresh"></i> CALCULAR
                                  </button>
                                </div>
                              </div>

                            </div>

                            <div class="col-sm-5">
                              <h3>Montos Modificados</h3>
                              <div class="hr hr-dotted hr-16"></div>
                              <input type="hidden" name="edt_pais" id="edt_pais" value="1">
                              <input type="hidden" name="edt_formato" id="edt_formato" value="<?php echo $formato; ?>">
                              
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="input-group">
                                    <span class="input-group-addon">MONTO&nbsp;&nbsp;</span>
                                    <input class="form-control" type="text" id="edt_mnt" name="edt_mnt" readonly >
                                    <span class="input-group-addon fdxklg1">CLP</span>
                                  </div>
                                  <input type="text" name="edt_mnt_transferencia" id="edt_mnt_transferencia" class="form-control" readonly >
                                </div>
                              </div>

                              <div class="space-6"></div>

                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="input-group">
                                    <span class="input-group-addon">TARIFA</span>
                                    <input class="form-control" type="text" id="edt_tarifa" name="edt_tarifa" readonly >
                                    <span class="input-group-addon fdxklg1">CLP</span>
                                  </div>
                                </div>
                              </div>
                              
                              <div class="space-6"></div>
                              
                              <div class="row">
                                <div class="col-sm-12">
                                  <div class="input-group">
                                    <span class="input-group-addon">REDONDEO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <input class="form-control" type="text" id="edt_tot" name="edt_tot" readonly >
                                    <span class="input-group-addon fdxklg10">CLP</span>
                                  </div>
                                </div>
                              </div>

                              <div class="space-6"></div>

                              <!--
                              <div class="row">
                                <div class="col-sm-6">
                                  <label><input type="radio" name="opt" id="opt" class="opt form-control cl1" value="1" checked> Formato 1</label>
                                </div>
                                <div class="col-sm-6">
                                  <label><input type="radio" name="opt" id="opt" class="opt form-control cl2" value="2"> Formato 2</label>
                                </div>
                              </div>
                              <div class="space-6"></div>

                              <div class="row">
                                <div class="col-sm-12">
                                  <label>
                                    <input type="checkbox" name="edt_print" id="edt_print" value="1"> Modificar el PDF completo.
                                  </label>
                                </div>
                              </div>
                              <div class="space-6"></div>
                              -->

                              <div class="row">
                                <div class="col-sm-12">
                                  <label for="adjticket">Adjuntar PDF</label>
                                  <input type="file" name="adjticket" id="my-file-input-1" class="file-adj" data-frm="#frm" data-action="<?php echo base_url('calculadora/upload_ticket'); ?>" data-carpeta="<?php echo base_url('uploads/') ?>" />
                                  <input type="hidden" name="adjunto" id="adjunto">
                                </div>
                              </div>

                              <div class="space-6"></div>

                              <div class="row">
                                <div class="col-sm-12">
                                  <button type="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-file-pdf-o"></i> PROCESAR</button>
                                </div>
                              </div>

                            </div>

                          </div><!-- / row -->

                        </div>
                     </div>
                   </div>
                </div>
            </div>
            <!-- /.row -->
            </form>
          </div><!-- /.page-content -->
        </div><!-- /.main-content -->

    </div><!-- /.main-container -->

    <script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo base_url('assets/admin/js/jquery.js')?>'>"+"<"+"/script>");
    var modulo = '.md-ticket';
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
    <script src="<?php echo base_url('assets/js/calculadora/app_numeroaletras.js')?>?v=<?php echo rand(1,999999); ?>"></script>

    <script type="text/javascript"> 
        ace.vars['base'] = '..'; 
        MyApp.ticketchileexpress.init();

    </script>

  </body>
</html>

