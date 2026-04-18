
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Administrador - Ventas WU </title>

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
                <h2 class="header smaller lighter orange">Ventas Wester Union</h2>
                <div class="sidebar h-sidebar navbar-collapse ace-save-state">
                 <ul id="tabseccion" class="nav nav-list" >
                   <li class="active">
                      <a href="#home" data-toggle="tab">
                        <i class="menu-icon fa fa-list"></i>
                        <span class="menu-text"> Transacciones </span>
                      </a>
                   </li>

                   <li>
                      <a href="#rpt2" data-toggle="tab">
                        <i class="menu-icon fa fa-university"></i>
                        <span class="menu-text"> Tiendas </span>
                      </a>
                   </li>

                   <li>
                      <a href="#rpt3" data-toggle="tab">
                        <i class="menu-icon fa fa-users"></i>
                        <span class="menu-text"> Cajeros </span>
                      </a>
                   </li>

                   <li>
                      <a href="#detalle" data-toggle="tab">
                        <i class="menu-icon fa fa-ticket"></i>
                        <span class="menu-text"> Transacción </span>
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
                          <label>Cajero</label>
                          <select name="rp1_vendedor" id="rp1_vendedor" class="form-control">
                            <option value="">Todos</option>
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
                      <table id="reporte" class="table table-bordered table-hover reporte" width="100%" data-action="<?php echo site_url('admin/ajax_vista_ventaswu')?>">
                        <thead>
                            <tr>
                                <th></th>
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
                                <th>Nro Boleta</th> <!-- 7 -->
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
                            <th colspan="6"></th>
                          </tr>
                        </tfoot>
                      </table>
                      </form>
                    </div><!-- / #home -->

                     <div class="tab-pane" id="rpt2">
                     <form name="frm2" id="frm2" method="POST">
                      <div class="row">
                        <div class="col-sm-2">
                          <label>Tienda</label>
                          <select name="rp2_tienda" id="rp2_tienda" class="form-control">
                            <option value="">Todos</option>
                            <?php 
                            if($rs_tiendas){
                              foreach ($rs_tiendas as $k => $f) {
                              ?>
                                <option value="<?php echo $f['id']; ?>"><?php echo $f['nombre']; ?></option>
                              <?php 
                              }
                            }
                            ?>
                          </select>
                        </div>

                        <div class="col-sm-2">
                          <label>Fecha</label>
                          <input type="date" name="rp2_fecha" id="rp2_fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>" >
                        </div>

                        <div class="col-sm-2">
                          <button type="button" class="btn btn-primary" id="btn-rp2" ><i class="fa fa-search"></i> Filtrar </button>
                        </div>
                      </div>
                      <br>
                      <table id="rpt_locales" class="table table-bordered table-hover reporte" width="100%" data-action="<?php echo site_url('admin/ajax_vista_ventas_tienda')?>">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Local</th>
                                <th>V.T. Otros</th>
                                <th>Uti. Otros</th>
                                <th>V.T. Colombia</th>
                                <th>Uti. Colombia</th>
                                <th>Venta Total</th>
                                <th>Uti. Total</th>
                            </tr>
                        </thead>
                      </table>
                      </form>
                     </div><!-- / #rpt2 -->

                     <div class="tab-pane" id="rpt3">
                     <form name="frm3" id="frm3" method="POST">
                      <div class="row">
                        <div class="col-sm-3">
                          <label>Cajero</label>
                          <select name="rp3_vendedor" id="rp3_vendedor" class="form-control">
                            <option value="">Todos</option>
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
                          <label>Tienda</label>
                          <select name="rp3_tienda" id="rp3_tienda" class="form-control">
                            <option value="">Todos</option>
                            <?php 
                            if($rs_tiendas){
                              foreach ($rs_tiendas as $k => $f) {
                              ?>
                                <option value="<?php echo $f['id']; ?>"><?php echo $f['nombre']; ?></option>
                              <?php 
                              }
                            }
                            ?>
                          </select>
                        </div>

                        <div class="col-sm-2">
                          <label>Fecha</label>
                          <input type="date" name="rp3_fecha" id="rp3_fecha" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>

                        <div class="col-sm-2">
                          <button type="button" class="btn btn-primary" id="btn-rp3" ><i class="fa fa-search"></i> Filtrar </button>
                        </div>
                      </div>
                      <br>
                      <table id="rpt_usuarios" class="table table-bordered table-hover reporte" width="100%" data-action="<?php echo site_url('admin/ajax_vista_ventas_usuario')?>">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Usuario</th>
                                <th>Local</th>
                                <th>V.T. Otros</th>
                                <th>Uti. Otros</th>
                                <th>V.T. Colombia</th>
                                <th>Uti. Colombia</th>
                            </tr>
                        </thead>
                        <!--
                        <tfoot>
                            <tr>
                                <th colspan="3" style="text-align:right">Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                        -->
                      </table>
                      </form>
                  </div><!-- / #rpt3 -->

                  <div class="tab-pane" id="detalle" >
                    
                    <form name="frmtran" id="frmtran" method="POST" target="_blank" action="<?php echo base_url('calculadora/') ?>">

                      <div class="row">
                        <div class="col-sm-3">
                          <label>Cajero</label>
                          <select name="calculadora_login_id" id="calculadora_login_id" class="form-control" disabled>
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
                          <label>Tienda</label>
                          <select name="calculadora_tienda_id" id="calculadora_tienda_id" class="form-control" disabled>
                            <?php 
                            if($rs_tiendas){
                              foreach ($rs_tiendas as $k => $f) {
                              ?>
                                <option value="<?php echo $f['id']; ?>"><?php echo $f['nombre']; ?></option>
                              <?php 
                              }
                            }
                            ?>
                          </select>
                        </div>

                        <div class="col-sm-2">
                          <label>Fecha</label>
                          <input type="date" name="fecha" id="fecha" class="form-control" readonly >
                        </div>

                        <div class="col-sm-2">
                          <label>Hora</label>
                          <input type="text" name="hora" id="hora" class="form-control" readonly >
                        </div>
                      </div>
                      <div class="space-6"></div>

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
                                          <h3>Montos Ingresados</h3>
                                          <div class="hr hr-dotted hr-16"></div>

                                          <input type="hidden" name="id" name="id">
                                          <input type="hidden" id="ing_tipo" name="ing_tipo" value="1" >
                                          <input type="hidden" id="ing_com" name="ing_com" value="" >

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">Transferir a</span>
                                                <select id="pais" name="pais" class="form-control" disabled >
                                                  <option value="1">OTROS</option>
                                                  <option value="2">COLOMBIA</option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="space-6"></div>

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">MONTO&nbsp;&nbsp;</span>
                                                <input class="form-control" type="text" id="ing_mnt" name="ing_mnt" autocomplete="off" readonly> <!--  -->
                                                <span class="input-group-addon fdxklg1">CLP</span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="space-6"></div>

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">CARGO 1</span>
                                                <input class="form-control" type="text" id="ing_crg" name="ing_crg" autocomplete="off" readonly >
                                                <span class="input-group-addon fdxklg1">CLP</span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="space-6"></div>

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

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">CARGO 2</span>
                                                <input class="form-control" type="text" id="ing_crg_2" name="ing_crg_2" autocomplete="off" readonly >
                                                <input type="hidden" id="ing_tiva_2" name="ing_tiva_2">
                                                <span class="input-group-addon fdxklg1">CLP</span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="space-6"></div>

                                          <div class="row">
                                            <div class="col-sm-12">
                                              <div class="input-group">
                                                <span class="input-group-addon">TOTAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <input class="form-control" type="text" id="ing_tot" name="ing_tot" readonly >
                                                <span class="input-group-addon">CLP</span>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="hr hr-dotted hr-16"></div>

                                          <div class="row">
                                            <div class="col-sm-6">
                                              <div class="input-group">
                                                <span class="input-group-addon">TC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                <input class="form-control" type="number" step="any" id="ing_tc" name="ing_tc" readonly >
                                              </div>
                                            </div>
                                            <div class="col-sm-6">
                                              <div class="input-group">
                                                <span class="input-group-addon">TC ACT.</span>
                                                <input class="form-control" type="number" step="any" id="ing_tcact" name="ing_tcact" readonly >
                                              </div>
                                            </div>
                                            <input class="form-control" type="hidden" step="any" id="ing_dct" name="ing_dct" value="" >
                                          </div>

                                          <div class="space-6"></div>

                                          <div class="row">
                                            <div class="col-sm-9">
                                              <div class="input-group">
                                                <span class="input-group-addon">M. APROX PAGO</span>
                                                <input class="form-control" type="text" step="any" id="ing_appago" name="ing_appago" readonly >
                                              </div>
                                            </div>
                                          </div>
                                        </div><!-- /col-sm-5 -->

                                        <div class="col-sm-4">
                                          <h3>Montos Modificados</h3>
                                          <div class="hr hr-dotted hr-16"></div>
                                          
                                          <div class="space-6"></div>

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
                                        </div><!-- /col-sm-4 -->

                                        <div class="col-sm-3 text-center">
                                          <div class="space-6"></div>
                                          <img src="<?php echo base_url('assets/images/calculadora/logo-wester-union.jpg') ?>" class="img-responsive" >
                                          <div class="space-6"></div>
                                          <h3>Utilidad</h3>
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
                                            </div>
                                          </div>
                                        </div><!-- /col-sm-3 -->

                                      </div><!-- / row -->
                                    
                                  </div><!-- /widget-main -->
                               </div>
                            </div>
                          </div>
                      </div>
                      <!-- /.row -->
                    </form>
                  </div><!-- /detalle -->

                 </div><!-- / .tab-content -->
                </div><!-- / .sidebar -->

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

      var modulo = '.md-ventaswu';
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    
    <script src="<?php echo base_url('assets/admin/app/js/librarie.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/app/js/app.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

    <script type="text/javascript"> 
        ace.vars['base'] = '..'; 
        $(document).ready(function(){
          //MyApp.maestros.init();
          var vendedor = $('#rp1_vendedor').val();
          var pais = $('#rp1_pais').val();
          var fecha = $('#rp1_fecha').val();
          var id=vendedor+'|'+pais+'|'+fecha;
          MyApp.rptload.init('#reporte',id); 
          MyApp.ventaswu.init();
        });

    </script>

  </body>
</html>

