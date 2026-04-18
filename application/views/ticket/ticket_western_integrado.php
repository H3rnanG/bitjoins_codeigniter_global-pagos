
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

            <h2 class="header smaller blue">CALCULADORA WU</h2>

            <div class="row">
              <div class="col-sm-12" >

                <div class="sidebar h-sidebar navbar-collapse ace-save-state">
                  <ul id="tabseccion" class="nav nav-list" >
                   <li class="active">
                      <a href="#home" data-toggle="tab">
                        <i class="menu-icon fa fa-th-list"></i>
                        <span class="menu-text"> Otros </span>
                      </a>
                   </li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane in active" id="home">
                      
                      <form name="frm" id="frm" method="POST" target="_blank" action="<?php echo base_url('wuticket/ticketwestern_integrado') ?>">
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

                                          <input type="hidden" name="ing_pais" id="ing_pais">

                                          <!--
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">Transferir a</span>
                                                <select id="ing_pais" name="ing_pais" class="form-control" >
                                                  <option value="1">OTROS</option>
                                                  <option value="2">COLOMBIA</option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="space-6"></div>
                                        -->

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
                                                <span class="input-group-addon">CARGO&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <input class="form-control" type="text" id="ing_crg" name="ing_crg" autocomplete="off" >
                                                <span class="input-group-addon fdxklg1">CLP</span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="space-6"></div>

                                          <input type="hidden" id="ing_tipo" name="ing_tipo" value="1" >
                                          <input type="hidden" id="ing_com" name="ing_com" >

                                          <div class="row">
                                            <div class="col-sm-5">
                                              <div class="input-group">
                                                <span class="input-group-addon">% IVA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <input type="number" name="ing_iva" id="ing_iva" value="19" readonly>
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

                                          <!--
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">CARGO 2</span>
                                                <input class="form-control" type="text" id="ing_crg_2" name="ing_crg_2" autocomplete="off" >
                                                <input type="hidden" id="ing_tiva_2" name="ing_tiva_2">
                                                <span class="input-group-addon fdxklg1">CLP</span>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="space-6"></div>
                                          
                                          -->
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">TOTAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <input class="form-control" type="text" id="ing_tot" name="ing_tot" >
                                                <span class="input-group-addon">CLP</span>
                                              </div>
                                            </div>
                                          </div>
                                          

                                          <div class="hr hr-dotted hr-16"></div>
                                          <div class="space-6"></div>
                                          <div class="row">
                                            <!--
                                            <div class="col-sm-6">
                                              <div class="input-group">
                                                <span class="input-group-addon">TC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <input class="form-control" type="number" step="any" id="ing_tc" name="ing_tc" >
                                              </div>
                                            </div>
                                            -->
                                            <div class="col-sm-3">
                                              <div class="input-group">
                                              <button type="button" id="btnrefresh" class="btn btn-primary btn-sm pull-right" > 
                                                <i class="fa fa-refresh"></i> CALCULAR
                                              </button>
                                              </div>
                                            </div>
                                            <!--
                                            <div class="col-sm-6">
                                              <div class="input-group">
                                                <span class="input-group-addon">TC ACT.</span>
                                                <input class="form-control" type="number" step="any" id="ing_tcact" name="ing_tcact" >
                                              </div>
                                            </div>
                                            -->
                                            <input class="form-control" type="hidden" step="any" id="ing_dct" name="ing_dct" value="<?php echo $dscto; ?>" >
                                          </div>
                                          <div class="space-6"></div>

                                          <!--
                                          <div class="row">
                                            <div class="col-sm-9">
                                              <div class="input-group">
                                                <span class="input-group-addon">M. APROX PAGO</span>
                                                <input class="form-control" type="text" step="any" id="ing_appago" name="ing_appago" >
                                              </div>
                                            </div>
                                          </div>
                                          -->

                                        </div>

                                        <div class="col-sm-4">
                                          <h3>Montos Ticket</h3>
                                          <div class="hr hr-dotted hr-16"></div>

                                          <input type="hidden" name="ori_pais" id="ori_pais" value="1">
                                          <input type="hidden" name="ori_mnt" id="ori_mnt">
                                          <input type="hidden" name="ori_crg2" id="ori_crg_2">
                                          <input type="hidden" name="ori_tipo" id="ori_tipo">
                                          <input type="hidden" name="ori_com" id="ori_com">
                                          <input type="hidden" name="ori_iva" id="ori_iva">
                                          
                                          <input type="hidden" name="ori_tiva" id="ori_tiva_2">
                                          <input type="hidden" name="ori_dct" id="ori_dct">
                                          <input type="hidden" name="ori_tc" id="ori_tc">
                                          <input type="hidden" name="ori_tcact" id="ori_tcact">
                                          <input type="hidden" name="ori_appago" id="ori_appago">

                                          <input type="hidden" name="edt_tc" id="edt_tc" >
                                          <input type="hidden" name="edt_appago" id="edt_appago" >

                                          
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">MONTO&nbsp;&nbsp;</span>
                                                <input class="form-control" type="text" id="edt_mnt" name="edt_mnt" readonly >
                                                <span class="input-group-addon fdxklg1">CLP</span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="space-6"></div>

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">CARGO&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <input class="form-control" type="text" id="edt_crg" name="edt_crg" readonly >
                                                <span class="input-group-addon fdxklg10">CLP</span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="space-6"></div>

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">IVA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <!--<input type="hidden" name="ori_tiva" id="ori_tiva">-->
                                                <input class="form-control" type="text" id="ori_tiva" name="ori_tiva" readonly >
                                                <span class="input-group-addon fdxklg10">CLP</span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="space-6"></div>

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">SUB. TOT</span>
                                                <input class="form-control" type="text" id="edt_sbt" name="edt_sbt" readonly >
                                                <span class="input-group-addon fdxklg1">CLP</span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="space-6"></div>
                                          
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">TOTAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <input class="form-control" type="text" id="edt_tot" name="edt_tot" readonly >
                                                <span class="input-group-addon fdxklg10">CLP</span>
                                              </div>
                                            </div>
                                          </div>

                                          <!--
                                          <div class="space-6"></div>

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">T.C.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <input class="form-control" type="text" id="edt_tc" name="edt_tc" readonly >
                                              </div>
                                            </div>
                                          </div>

                                          <div class="space-6"></div>

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">M. APROX PAGO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <input class="form-control" type="text" id="edt_appago" name="edt_appago" readonly >
                                              </div>
                                            </div>
                                          </div>
                                          -->

                                          <div class="space-6"></div>

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <label for="adjticket">Adjuntar PDF</label>
                                              <input type="file" name="adjticket" id="my-file-input-1" class="file-adj" data-frm="#frm" data-action="<?php echo base_url('calculadora/upload_ticket'); ?>" data-carpeta="<?php echo base_url('uploads/') ?>" />
                                              <input type="hidden" name="adjunto" id="adjunto">
                                            </div>
                                          </div>

                                          <div class="space-6"></div>

                                          <div class="row">
                                            <input type="hidden" name="edt_formato" id="edt_formato" value="<?php echo $formato; ?>">
                                            <div class="col-sm-3">
                                              <label><input type="radio" name="opt" id="opt" class="opt form-control cl1" value="1" checked> Formato 1</label>
                                            </div>
                                            <div class="col-sm-3">
                                              <label><input type="radio" name="opt" id="opt" class="opt form-control cl2" value="2"> Formato 2</label>
                                            </div>
                                            <div class="col-sm-3">
                                              <label><input type="radio" name="opt" id="opt" class="opt form-control cl3" value="3"> Formato 3</label>
                                            </div>
                                            <div class="col-sm-3">
                                              <label><input type="radio" name="opt" id="opt" class="opt form-control cl3" value="4"> Formato 4</label>
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

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <button type="button" id="btn-procesar" class="btn btn-primary btn-sm pull-right"><i class="fa fa-file-pdf-o"></i> PROCESAR</button>
                                            </div>
                                          </div>

                                        </div>

                                        <div class="col-sm-3 text-center">
                                          <div class="space-6"></div>
                                          <img src="<?php echo base_url('assets/images/calculadora/logo-wester-union.jpg') ?>" class="img-responsive" >
                                          <div class="space-6"></div>
                                          <h3>Monto a Facturar</h3>
                                          <div class="hr hr-dotted hr-16"></div>
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <input class="form-control" type="text" id="utilidad" name="utilidad" readonly >
                                                <span class="input-group-addon fdxklg1">CLP</span>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="space-6"></div>
                                          <div class="row">
                                            <div class="col-sm-12">
                                              <label>Nro. Boleta</label>
                                              <input class="form-control" type="text" id="nroboleta" name="nroboleta" >
                                              <!--
                                              <br>
                                              <button type="button" class="btn btn-app btn-primary btn-facturar">
                                                <i class="ace-icon fa fa-usd bigger-230"></i>
                                                Facturar
                                              </button>
                                              -->
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

                    </div><!-- /home -->
                    
                  </div><!-- /tab-content -->

                </div><!-- /sidebar -->
                
              </div><!-- / col-sm-12 -->
            </div><!-- / row -->

          </div><!-- /.page-content -->
        </div><!-- /.main-content -->

    </div><!-- /.main-container -->

    <script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo base_url('assets/admin/js/jquery.js')?>'>"+"<"+"/script>");
    var modulo = '.md-wuticket';
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
    <script src="<?php echo base_url('assets/js/calculadora/app_wuticket.js')?>?v=<?php echo rand(1,999999); ?>"></script>

    <script type="text/javascript"> 
        ace.vars['base'] = '..'; 
        var rg1_1 = '<?php echo $rg1_1 ?>';
        var rg1_2 = '<?php echo $rg1_2 ?>';
        var rg2_1 = '<?php echo $rg2_1 ?>';
        var rg2_2 = '<?php echo $rg2_2 ?>';
        var v_nro_rut = '<?php echo $v_nro_rut ?>';
        MyApp.ticketwestern_integrado.init('<?php echo $cargo ?>');
    </script>

  </body>
</html>

