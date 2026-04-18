
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Transferencias - <?php echo $titulo_pag; ?> </title>

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
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/chosen.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/colorbox.css') ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.css" />

    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/loading/jquery.loading.min.css'); ?>">
    

    <link rel="stylesheet" href="<?php echo base_url('assets/css/app.css') ?>" />

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

                <h2 class="header smaller blue"><?php echo $titulo_pag; ?></h2>

                <div class="sidebar h-sidebar navbar-collapse ace-save-state">

                 <ul id="tabseccion" class="nav nav-list" >
                   <li class="active">
                      <a href="#home" data-toggle="tab">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text"> Vista </span>
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

                    <form id="frm_filtrar" method="post" class="form-inline">

                      <div class="form-group">
                          <label>Tipo Doc: </label>
                          <select name="rpt_tipodoc" id="rpt_tipodoc" class="form-control inpfiltro">
                            <option value="">Todos</option>
                            <?php 
                            if($arrayTipoDoc){
                              foreach ($arrayTipoDoc as $key => $val) {
                              ?>
                              <option value="<?php echo $key ?>"><?php echo $val ?></option>
                              <?php 
                              } // fin foreach
                            } // fin if 
                            ?>
                          </select>
                      </div>

                      <div class="form-group">
                          <label>Fecha Reg: </label>
                          <input type="date" name="rpt_fechareg" id="rpt_fechareg" class="form-control inpfiltro">
                      </div>

                      <div class="form-group">
                          <button type="button" class="btn btn-sm btn-rpt-filtro" ><i class="fa fa-filter"></i> Filtrar</button>
                      </div>

                      <div class="form-group">
                          <button type="button" class="btn btn-sm btn-inverse btn-rpt-reset" ><i class="fa fa-eraser"></i> Reinicar</button>
                      </div>
                    </form>
                    <br>
                    <table id="reporte" class="table table-bordered table-hover reporte" width="100%" data-action="<?php echo site_url($controlador.'/listar')?>">
                      <thead>
                          <tr>
                              <th></th>
                              <th>Item</th>
                              <th></th>
                              <th>Nº Doc</th>
                              <th>Nombres</th>
                              <th>Apellidos</th>
                              <th>E-mail</th>
                              <th>Genero</th>
                          </tr>
                      </thead>
                    </table>

                   </div>

                   <div class="tab-pane" id="form" data-action="<?php echo base_url($controlador.'/get') ?>">
                    
                    <div class="row">
                      <div class="col-md-12">

                          <div class="col-md-8">
                            <form name="frm" id="frm" method="post" class="frmreg" action="<?php echo base_url($controlador.'/action'); ?>" >
                              <input type="hidden" name="act" id="act" value="<?php echo ACT_INSERT ?>" data-def="<?php echo ACT_INSERT ?>"> 
                              <input type="hidden" name="id" id="id">
                              <input type="hidden" name="config_ubigeo_id" id="config_ubigeo_id" value="<?php echo PAISEMISION; ?>" data-def="<?php echo PAISEMISION; ?>">

                              <input type="hidden" name="arch_dni1" id="arch_dni1">
                              <input type="hidden" name="arch_dni2" id="arch_dni2">
                              <input type="hidden" name="arch_declaracion" id="arch_declaracion">

                              <h3 class="row header smaller lighter red">
                                <i class="fa fa-address-card"></i> DOCUMENTO DE IDENTIFICACIÓN
                              </h3>

                              <div class="row">
                                
                                <div class="col-sm-3" >
                                  <label><span class="error">*</span> Tipo Doc</label>
                                  <select name="tipo_documento" id="tipo_documento" class="form-control">
                                    <?php 
                                    if($arrayTipoDoc){
                                      foreach ($arrayTipoDoc as $key => $val) {
                                      ?>
                                      <option value="<?php echo $key ?>"><?php echo $val ?></option>
                                      <?php 
                                      } // fin foreach
                                    } // fin if 
                                    ?>
                                  </select>
                                </div>  
                                <div class="col-sm-3" >
                                  <label><span class="error">*</span> Nº Doc</label>
                                  <input type="text" name="documento" id="documento" class="form-control" maxlength="15">
                                </div>

                                <div class="col-sm-3" >
                                  <label>Fecha Emisión</label>
                                  <input type="date" name="fecha_emision" id="fecha_emision" class="form-control" >
                                </div>

                                <div class="col-sm-3" >
                                  <label>Fecha Caducidad</label>
                                  <input type="date" name="fecha_caducidad" id="fecha_caducidad" class="form-control" >
                                </div>

                              </div>
                              <br>
                              <h3 class="row header smaller lighter red">
                                <i class="fa fa-user"></i> DATOS PERSONALES
                              </h3>
                              <div class="row">
                                <div class="col-sm-3" >
                                  <label><span class="error">*</span> Nombre</label>
                                  <input type="text" name="nombre" id="nombre" class="form-control" maxlength="80">
                                </div>
                                <div class="col-sm-3" >
                                  <label>Segundo Nombre</label>
                                  <input type="text" name="nombre2" id="nombre2" class="form-control" maxlength="80">
                                </div>
                                <div class="col-sm-3" >
                                  <label><span class="error">*</span> Apellido</label>
                                  <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" maxlength="80">
                                </div>
                                <div class="col-sm-3" >
                                  <label>Segundo Apellido</label>
                                  <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" maxlength="80">
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-sm-3" >
                                  <label><span class="error">*</span> Fecha Nacimiento</label>
                                  <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control">
                                </div>
                                <div class="col-sm-5" >
                                  <label><span class="error">*</span> País Nacimiento</label>
                                  <select name="pais_nacimiento_id" id="pais_nacimiento_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <?php 
                                    if($rsUbigeo){
                                      foreach ($rsUbigeo as $key => $f) {
                                      ?>
                                      <option value="<?php echo $f['data'] ?>"><?php echo $f['value'] ?></option>
                                      <?php 
                                      } // fin foreach
                                    } // fin if 
                                    ?>
                                  </select>
                                </div>  
                                <div class="col-sm-4" >
                                  <label>Nacionalidad</label>
                                  <select name="nacionalidad_id" id="nacionalidad_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <?php 
                                    if($rsUbigeo){
                                      foreach ($rsUbigeo as $key => $f) {
                                      ?>
                                      <option value="<?php echo $f['data'] ?>"><?php echo $f['value'] ?></option>
                                      <?php 
                                      } // fin foreach
                                    } // fin if 
                                    ?>
                                  </select>
                                </div>  
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-sm-4" >
                                  <label>E-mail</label>
                                  <input type="text" name="email" id="email" class="form-control" maxlength="150">
                                </div>
                                <div class="col-sm-4" >
                                  <label>Género</label>
                                  <select name="genero" id="genero" class="form-control">
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                  </select>
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-sm-12">
                                  <label>Comentarios</label>
                                  <textarea name="comentarios" id="comentarios" class="form-control"></textarea>
                                </div>
                              </div>
                              <br>
                              <h3 class="row header smaller lighter red">
                                <i class="fa fa-map-marker"></i> DIRECCIÓN
                              </h3>
                              <div class="row">
                                <div class="col-sm-6">
                                  <label><span class="error">*</span> Dirección</label>
                                  <input type="text" name="direccion1" id="direccion1" class="form-control" maxlength="200">
                                </div>
                                <div class="col-sm-6">
                                  <label>Dirección 2</label>
                                  <input type="text" name="direccion2" id="direccion2" class="form-control" maxlength="200">
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-sm-6" >
                                  <label><span class="error">*</span> País</label>
                                  <select name="pais_id" id="pais_id" class="form-control cbo-load" data-target="#estado_id" data-action="<?php echo base_url('clientes/get_ubigeo_cbo') ?>">
                                    <option value="">Seleccionar</option>
                                    <?php 
                                    if($rsUbigeo){
                                      foreach ($rsUbigeo as $key => $f) {
                                      ?>
                                      <option value="<?php echo $f['data'] ?>"><?php echo $f['value'] ?></option>
                                      <?php 
                                      } // fin foreach
                                    } // fin if 
                                    ?>
                                  </select>
                                </div>  
                                <div class="col-sm-6" >
                                  <label><span class="error">*</span> Estado</label>
                                  <select name="estado_id" id="estado_id" class="form-control cbo-load" data-target="#ciudad_id" data-action="<?php echo base_url('clientes/get_ubigeo_cbo') ?>">
                                    <option value="">Seleccionar</option>
                                  </select>
                                </div>  
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-sm-6" >
                                  <label><span class="error">*</span> Ciudad</label>
                                  <select name="ciudad_id" id="ciudad_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                  </select>
                                </div>  
                                <div class="col-sm-3">
                                  <label>Código postal</label>
                                  <input type="text" name="codigo_postal" id="codigo_postal" class="form-control" maxlength="10">
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-sm-6">
                                  <label><span class="error">*</span> Código teléfono 1</label>
                                  <input type="text" name="cod_telefono1" id="cod_telefono1" class="form-control" maxlength="5">
                                </div>
                                <div class="col-sm-6">
                                  <label><span class="error">*</span> Número telefono 1</label>
                                  <input type="text" name="num_telefono_1" id="num_telefono_1" class="form-control" maxlength="10">
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-sm-6">
                                  <label>Código teléfono 2</label>
                                  <input type="text" name="cod_telefono2" id="cod_telefono2" class="form-control" maxlength="5">
                                </div>
                                <div class="col-sm-6">
                                  <label>Número telefono 2</label>
                                  <input type="text" name="num_telefono_2" id="num_telefono_2" class="form-control" maxlength="10">
                                </div>
                              </div>
                              <br>
                              <h3 class="row header smaller lighter red">
                                <i class="fa fa-user-plus"></i> ENVÍO EN NOMBRE DE UNA TERCERA PERSONA
                              </h3>
                              <div class="row">
                                <div class="col-sm-6">
                                  <label><span class="error">*</span> ¿Envía el dinero en nombre de una tercera persona?</label>
                                  <select name="sw_tercera_persona" id="sw_tercera_persona" class="form-control">
                                    <option value="2">NO</option>
                                    <option value="1">SI</option>
                                  </select>
                                </div>
                                <div class="col-sm-6">
                                  <label>¿Transacción sospechosa o inusual?</label>
                                  <select name="sw_trans_sospechosa" id="sw_trans_sospechosa" class="form-control">
                                    <option value="2">NO</option>
                                    <option value="1">SI</option>
                                  </select>
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-sm-6">
                                  <label><span class="error">*</span> ¿Es una persona expuesta políticamente?</label>
                                  <select name="sw_perexp_politicamente" id="sw_perexp_politicamente" class="form-control">
                                    <option value="2">NO</option>
                                    <option value="1">SI</option>
                                  </select>
                                </div>
                              </div>
                              <h3 class="row header smaller lighter red">
                                <i class="fa fa-info-circle"></i> INFORMACIÓN ADICIONAL
                              </h3>
                              <div class="row">
                                <div class="col-sm-6">
                                  <label>Ocupación</label>
                                  <select name="ocupacion_id" id="ocupacion_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <?php 
                                    if($rsOcupacion){
                                      foreach ($rsOcupacion as $key => $f) {
                                      ?>
                                      <option value="<?php echo $f['data'] ?>"><?php echo $f['value'] ?></option>
                                      <?php 
                                      } // fin foreach
                                    } // fin if 
                                    ?>
                                  </select>
                                </div>
                                <div class="col-sm-6">
                                  <label>Nivel de posición de empleo</label>
                                  <select name="posicion_empleo_id" id="posicion_empleo_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <?php 
                                    if($rsPosEmpleo){
                                      foreach ($rsPosEmpleo as $key => $f) {
                                      ?>
                                      <option value="<?php echo $f['data'] ?>"><?php echo $f['value'] ?></option>
                                      <?php 
                                      } // fin foreach
                                    } // fin if 
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-sm-6">
                                  <label>Relación con el beneficiario</label>
                                  <select name="relacion_beneficiario_id" id="relacion_beneficiario_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <?php 
                                    if($rsBeneficiario){
                                      foreach ($rsBeneficiario as $key => $f) {
                                      ?>
                                      <option value="<?php echo $f['data'] ?>"><?php echo $f['value'] ?></option>
                                      <?php 
                                      } // fin foreach
                                    } // fin if 
                                    ?>
                                  </select>
                                </div>
                                <div class="col-sm-6">
                                  <label>Motivo de la transacción</label>
                                  <select name="motivo_transaccion_id" id="motivo_transaccion_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <?php 
                                    if($rsMotivTransac){
                                      foreach ($rsMotivTransac as $key => $f) {
                                      ?>
                                      <option value="<?php echo $f['data'] ?>"><?php echo $f['value'] ?></option>
                                      <?php 
                                      } // fin foreach
                                    } // fin if 
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <h3 class="row header smaller lighter red">
                                <i class="fa fa-file-text"></i> DATOS DE LOS RECURSOS
                              </h3>
                              <div class="row">
                                <div class="col-sm-6">
                                  <label>Origen de los fondos</label>
                                  <select name="origen_fondos_id" id="origen_fondos_id" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <?php 
                                    if($rsOriFondos){
                                      foreach ($rsOriFondos as $key => $f) {
                                      ?>
                                      <option value="<?php echo $f['data'] ?>"><?php echo $f['value'] ?></option>
                                      <?php 
                                      } // fin foreach
                                    } // fin if 
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <br>
                              <div class="row">
                                <div class="col-sm-12">
                                  <label>
                                    <span class="error">*</span> El agente verificó los datos del cliente y la credencial proporcionada 
                                  </label>
                                  <select name="sw_datos_verificados" id="sw_datos_verificados" class="form-control">
                                    <option value="">Seleccionar</option>
                                    <option value="1">SI</option>
                                    <option value="2">NO</option>
                                  </select>
                                </div>
                              </div>

                              <br>
                              <div class="row">
                                <div class="col-sm-3" >
                                  <label><span class="error">*</span> Fecha Reg.</label>
                                  <input type="date" name="fechareg" id="fechareg" class="form-control required" value="<?php echo date('Y-m-d'); ?>" placeholder="Fecha Reg." >
                                </div>
                                <div class="col-sm-3" >
                                  <label><span class="error">*</span> Estado</label>
                                  <select name="estado" id="estado" class="form-control">
                                    <option value="<?php echo ON; ?>">ACTIVO</option>
                                    <option value="<?php echo OFF; ?>">INACTIVO</option>
                                  </select>
                                </div>  
                              </div>
                              <br>
                              <div class="clearfix form-actions">
                                <button type="button" id="button" class="btn btn-inverse btn-nuevo" data-frm="#frm" data-act="<?php echo ACT_INSERT ?>"><i class="fa fa-eraser"></i> Nuevo</button>
                                <button type="submit" id="save" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Grabar Datos</button>
                              </div>
                            </form>
                          </div><!-- /col-md-8 fin -->

                          <div class="col-md-4">
                            
                            <div class="row">
                              <div class="col-sm-12">
                                <p><i>Click en la imagen para adjuntar su <u>documento.</u></i></p>
                                <span class="profile-picture avat1" data-action="<?php echo base_url('clientes/upload') ?>" >
                                  <img data-pk="11" src="<?php echo base_url('assets/admin/app/images/cedula-cara.jpg') ?>" data-carpeta="<?php echo base_url('assets/upload/transferencia') ?>" alt="FRONTAL - DNI" class="img-responsive" id="avatar" data-default="<?php echo base_url('assets/admin/app/images/cedula-cara.jpg') ?>" />
                                </span>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-sm-12">
                                <p><i>Click en la imagen para adjuntar su <u>documento.</u></i></p>
                                <span class="profile-picture avat2" data-action="<?php echo base_url('clientes/upload') ?>" >
                                  <img data-pk="12" src="<?php echo base_url('assets/admin/app/images/cedula-posterior.jpg') ?>" data-carpeta="<?php echo base_url('assets/upload/transferencia') ?>"  alt="POSTERIOR - DNI" class="img-responsive" id="avatar2" data-default="<?php echo base_url('assets/admin/app/images/cedula-posterior.jpg') ?>" />
                                </span>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-sm-12">
                                <p><i>Click en la imagen para adjuntar su <u> declaración de fondos.</u></i></p>
                                <span class="profile-picture avat3" data-action="<?php echo base_url('clientes/upload') ?>" >
                                  <img data-pk="13" src="<?php echo base_url('assets/admin/app/images/formato.png') ?>" data-carpeta="<?php echo base_url('assets/upload/transferencia') ?>"  alt="DECLARACIÓN DE FONDOS" class="img-responsive" id="avatar3" data-default="<?php echo base_url('assets/admin/app/images/formato.png') ?>" />
                                </span>
                              </div>
                            </div>

                          </div><!-- /col-md-4 -->

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
  var modulo = '.md-transfcli';
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

  <script src="<?php echo base_url('assets/admin/js/jquery.colorbox.js')?>"></script>

  <script src="<?php echo base_url('assets/admin/app/js/external/loading/jquery.loading.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/admin/app/js/bootbox.min.js'); ?>"></script>

  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/admin/js/chosen.jquery.min.js') ?>"></script>
  
  <script src="<?php echo base_url('assets/js/ace/bootstrap-editable.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/ace/ace-editable.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/jquery.gritter/js/jquery.gritter.js'); ?>"></script>
  
  <script src="<?php echo base_url('assets/admin/app/js/jquery.validate.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/admin/app/js/librarie.js')?>"></script>

  <script src="<?php echo base_url('assets/js/transferencias/app_transferencias.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

  <script type="text/javascript">
      jQuery(function($) {
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.loading = "<div class='editableform-loading'><i class='ace-icon fa fa-spinner fa-spin fa-2x light-blue'></i></div>";
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-danger editable-submit"><i class="ace-icon fa fa-check"></i> Adjuntar Archivo</button><button type="button" class="btn editable-cancel"><i class="ace-icon fa fa-times"></i> Cancelar</button>';    


        try {//ie8 throws some harmless exceptions, so let's catch'em

          //first let's add a fake appendChild method for Image element for browsers that have a problem with this
          //because editable plugin calls appendChild, and it causes errors on IE
          try {
            document.createElement('IMG').appendChild(document.createElement('B'));
          } catch(e) {
            Image.prototype.appendChild = function(el){}
          }

          var last_gritter; 
          var urlAction = $('.avat1').data('action');
          var urlAction2 = $('.avat2').data('action');
          var urlAction3 = $('.avat3').data('action');

          $('#avatar').editable({
            type: 'image',
            name: 'avatar',
            value: null,
            onblur: 'ignore',
            image: {
              //specify ace file input plugin's options here
              btn_choose: 'Cara Frontal del DNI',
              droppable: true,
              maxSize: 310000,//~100Kb
              //and a few extra ones here
              name: 'avatar',//put the field name here as well, will be used inside the custom plugin
              on_error : function(error_type) {//on_error function will be called when the selected file has a problem
                if(last_gritter) $.gritter.remove(last_gritter);
                if(error_type == 1) {//file format error
                  last_gritter = $.gritter.add({
                    title: 'El archivo no es una imagen!',
                    text: 'Por favor, elija una imagen jpg | gif | png!',
                    class_name: 'gritter-error gritter-center'
                  });
                } else if(error_type == 2) {//file size rror
                  last_gritter = $.gritter.add({
                    title: 'Archivo demasiado grande!',
                    text: 'El tamaño de la imagen no debe exceder los 300Kb!',
                    class_name: 'gritter-error gritter-center'
                  });
                }
                else {//other error
                }
              },
              on_success : function() {
                $.gritter.removeAll();
              }
            },
            url: function(params) {
              // ***UPDATE AVATAR HERE*** //
              var submit_url = urlAction; //'file-upload.php';//please modify submit_url accordingly
              var deferred = null;
              var avatar = '#avatar';

              //if value is empty (""), it means no valid files were selected
              //but it may still be submitted by x-editable plugin
              //because "" (empty string) is different from previous non-empty value whatever it was
              //so we return just here to prevent problems
              var value = $(avatar).next().find('input[type=hidden]:eq(0)').val();
              if(!value || value.length == 0) {
                deferred = new $.Deferred
                deferred.resolve();
                return deferred.promise();
              }

              var $form = $(avatar).next().find('.editableform:eq(0)')
              var file_input = $form.find('input[type=file]:eq(0)');
              var pk = $(avatar).attr('data-pk');//primary key to be sent to server

              var ie_timeout = null


              if( "FormData" in window ) {
                var formData_object = new FormData();//create empty FormData object
                
                //serialize our form (which excludes file inputs)
                $.each($form.serializeArray(), function(i, item) {
                  //add them one by one to our FormData 
                  formData_object.append(item.name, item.value);              
                });
                //and then add files
                $form.find('input[type=file]').each(function(){
                  var field_name = $(this).attr('name');
                  var files = $(this).data('ace_input_files');
                  if(files && files.length > 0) {
                    formData_object.append(field_name, files[0]);
                  }
                });

                //append primary key to our formData
                formData_object.append('pk', pk);

                deferred = $.ajax({
                      url: submit_url,
                       type: 'POST',
                  processData: false,//important
                  contentType: false,//important
                     dataType: 'json',//server response type
                       data: formData_object
                })
              }
              else {
                deferred = new $.Deferred

                var temporary_iframe_id = 'temporary-iframe-'+(new Date()).getTime()+'-'+(parseInt(Math.random()*1000));
                var temp_iframe = 
                    $('<iframe id="'+temporary_iframe_id+'" name="'+temporary_iframe_id+'" \
                    frameborder="0" width="0" height="0" src="about:blank"\
                    style="position:absolute; z-index:-1; visibility: hidden;"></iframe>')
                    .insertAfter($form);
                    
                $form.append('<input type="hidden" name="temporary-iframe-id" value="'+temporary_iframe_id+'" />');
                
                //append primary key (pk) to our form
                $('<input type="hidden" name="pk" />').val(pk).appendTo($form);
                
                temp_iframe.data('deferrer' , deferred);
                //we save the deferred object to the iframe and in our server side response
                //we use "temporary-iframe-id" to access iframe and its deferred object

                $form.attr({
                      action: submit_url,
                      method: 'POST',
                     enctype: 'multipart/form-data',
                      target: temporary_iframe_id //important
                });

                $form.get(0).submit();

                //if we don't receive any response after 30 seconds, declare it as failed!
                ie_timeout = setTimeout(function(){
                  ie_timeout = null;
                  temp_iframe.attr('src', 'about:blank').remove();
                  deferred.reject({'status':'fail', 'message':'Timeout!'});
                } , 30000);
              }


              //deferred callbacks, triggered by both ajax and iframe solution
              deferred
              .done(function(result) {//success
                var url = result['url'];//the `result` is formatted by your serve+r side response and is arbitrary
                var msj = result['msg'];
                var sts = result['status'];
                var nomb = result['nombre'];

                console.log('URL: '+avatar+' - '+sts+' - '+url);
                if(sts == 'done') 
                {
                  $.gritter.removeAll();
                  $('.editableform-loading').remove();
                  $('#avatar').attr('src', url); //.get(0).src = url; 
                  $('#avatar').attr('class', 'img-responsive');
                  $('#arch_dni1').val(nomb);
                  $('#avatar').show();
                }else{
                  alert('Error al subir el archivo.'); //res.message
                }
              })
              .fail(function(result) {//failure
                alert("There was an error");
              })
              .always(function() {//called on both success and failure
                if(ie_timeout) clearTimeout(ie_timeout)
                ie_timeout = null;  
              });

              return deferred.promise();
              // ***END OF UPDATE AVATAR HERE*** //
            },
              
            success: function(response, newValue) {
            }
          });


          $('#avatar2').editable({
            type: 'image',
            name: 'avatar2',
            value: null,
            onblur: 'ignore',
            image: {
              //specify ace file input plugin's options here
              btn_choose: 'Cara Posterior del DNI',
              droppable: true,
              maxSize: 310000,//~100Kb
              //and a few extra ones here
              name: 'avatar',//put the field name here as well, will be used inside the custom plugin
              on_error : function(error_type) {//on_error function will be called when the selected file has a problem
                if(last_gritter) $.gritter.remove(last_gritter);
                if(error_type == 1) {//file format error
                  last_gritter = $.gritter.add({
                    title: 'El archivo no es una imagen!',
                    text: 'Por favor, elija una imagen jpg | gif | png!',
                    class_name: 'gritter-error gritter-center'
                  });
                } else if(error_type == 2) {//file size rror
                  last_gritter = $.gritter.add({
                    title: 'Archivo demasiado grande!',
                    text: 'El tamaño de la imagen no debe exceder los 300Kb!',
                    class_name: 'gritter-error gritter-center'
                  });
                }
                else {//other error
                }
              },
              on_success : function() {
                $.gritter.removeAll();
              }
            },
            url: function(params) {
              // ***UPDATE AVATAR HERE*** //
              var submit_url = urlAction; //'file-upload.php';//please modify submit_url accordingly
              var deferred = null;
              var avatar = '#avatar2';

              //if value is empty (""), it means no valid files were selected
              //but it may still be submitted by x-editable plugin
              //because "" (empty string) is different from previous non-empty value whatever it was
              //so we return just here to prevent problems
              var value = $(avatar).next().find('input[type=hidden]:eq(0)').val();
              if(!value || value.length == 0) {
                deferred = new $.Deferred
                deferred.resolve();
                return deferred.promise();
              }

              var $form = $(avatar).next().find('.editableform:eq(0)')
              var file_input = $form.find('input[type=file]:eq(0)');
              var pk = $(avatar).attr('data-pk');//primary key to be sent to server

              var ie_timeout = null


              if( "FormData" in window ) {
                var formData_object = new FormData();//create empty FormData object
                
                //serialize our form (which excludes file inputs)
                $.each($form.serializeArray(), function(i, item) {
                  //add them one by one to our FormData 
                  formData_object.append(item.name, item.value);              
                });
                //and then add files
                $form.find('input[type=file]').each(function(){
                  var field_name = $(this).attr('name');
                  var files = $(this).data('ace_input_files');
                  if(files && files.length > 0) {
                    formData_object.append(field_name, files[0]);
                  }
                });

                //append primary key to our formData
                formData_object.append('pk', pk);

                deferred = $.ajax({
                      url: submit_url,
                       type: 'POST',
                  processData: false,//important
                  contentType: false,//important
                     dataType: 'json',//server response type
                       data: formData_object
                })
              }
              else {
                deferred = new $.Deferred

                var temporary_iframe_id = 'temporary-iframe-'+(new Date()).getTime()+'-'+(parseInt(Math.random()*1000));
                var temp_iframe = 
                    $('<iframe id="'+temporary_iframe_id+'" name="'+temporary_iframe_id+'" \
                    frameborder="0" width="0" height="0" src="about:blank"\
                    style="position:absolute; z-index:-1; visibility: hidden;"></iframe>')
                    .insertAfter($form);
                    
                $form.append('<input type="hidden" name="temporary-iframe-id" value="'+temporary_iframe_id+'" />');
                
                //append primary key (pk) to our form
                $('<input type="hidden" name="pk" />').val(pk).appendTo($form);
                
                temp_iframe.data('deferrer' , deferred);
                //we save the deferred object to the iframe and in our server side response
                //we use "temporary-iframe-id" to access iframe and its deferred object

                $form.attr({
                      action: submit_url,
                      method: 'POST',
                     enctype: 'multipart/form-data',
                      target: temporary_iframe_id //important
                });

                $form.get(0).submit();

                //if we don't receive any response after 30 seconds, declare it as failed!
                ie_timeout = setTimeout(function(){
                  ie_timeout = null;
                  temp_iframe.attr('src', 'about:blank').remove();
                  deferred.reject({'status':'fail', 'message':'Timeout!'});
                } , 30000);
              }


              //deferred callbacks, triggered by both ajax and iframe solution
              deferred
              .done(function(result) {//success
                var url = result['url'];//the `result` is formatted by your serve+r side response and is arbitrary
                var msj = result['msg'];
                var sts = result['status'];
                var nomb = result['nombre'];

                console.log('URL: '+avatar+' - '+sts+' - '+url);
                if(sts == 'done') 
                {
                  $.gritter.removeAll();
                  $('.editableform-loading').remove();
                  $('#avatar2').attr('src', url); //.get(0).src = url; 
                  $('#avatar2').attr('class', 'img-responsive');
                  $('#arch_dni2').val(nomb);
                  $('#avatar2').show();
                }else{
                  alert('Error al subir el archivo.'); //res.message
                }
              })
              .fail(function(result) {//failure
                alert("There was an error");
              })
              .always(function() {//called on both success and failure
                if(ie_timeout) clearTimeout(ie_timeout)
                ie_timeout = null;  
              });

              return deferred.promise();
              // ***END OF UPDATE AVATAR HERE*** //
            },
              
            success: function(response, newValue) {
            }
          });

          
          $('#avatar3').editable({
            type: 'image',
            name: 'avatar3',
            value: null,
            onblur: 'ignore',
            image: {
              //specify ace file input plugin's options here
              btn_choose: 'Declaración de Fondos',
              droppable: true,
              maxSize: 310000,//~100Kb
              //and a few extra ones here
              name: 'avatar',//put the field name here as well, will be used inside the custom plugin
              on_error : function(error_type) {//on_error function will be called when the selected file has a problem
                if(last_gritter) $.gritter.remove(last_gritter);
                if(error_type == 1) {//file format error
                  last_gritter = $.gritter.add({
                    title: 'El archivo no es una imagen!',
                    text: 'Por favor, elija una imagen jpg | gif | png!',
                    class_name: 'gritter-error gritter-center'
                  });
                } else if(error_type == 2) {//file size rror
                  last_gritter = $.gritter.add({
                    title: 'Archivo demasiado grande!',
                    text: 'El tamaño de la imagen no debe exceder los 300Kb!',
                    class_name: 'gritter-error gritter-center'
                  });
                }
                else {//other error
                }
              },
              on_success : function() {
                $.gritter.removeAll();
              }
            },
            url: function(params) {
              // ***UPDATE AVATAR HERE*** //
              var submit_url = urlAction; //'file-upload.php';//please modify submit_url accordingly
              var deferred = null;
              var avatar = '#avatar3';

              //if value is empty (""), it means no valid files were selected
              //but it may still be submitted by x-editable plugin
              //because "" (empty string) is different from previous non-empty value whatever it was
              //so we return just here to prevent problems
              var value = $(avatar).next().find('input[type=hidden]:eq(0)').val();
              if(!value || value.length == 0) {
                deferred = new $.Deferred
                deferred.resolve();
                return deferred.promise();
              }

              var $form = $(avatar).next().find('.editableform:eq(0)')
              var file_input = $form.find('input[type=file]:eq(0)');
              var pk = $(avatar).attr('data-pk');//primary key to be sent to server

              var ie_timeout = null


              if( "FormData" in window ) {
                var formData_object = new FormData();//create empty FormData object
                
                //serialize our form (which excludes file inputs)
                $.each($form.serializeArray(), function(i, item) {
                  //add them one by one to our FormData 
                  formData_object.append(item.name, item.value);              
                });
                //and then add files
                $form.find('input[type=file]').each(function(){
                  var field_name = $(this).attr('name');
                  var files = $(this).data('ace_input_files');
                  if(files && files.length > 0) {
                    formData_object.append(field_name, files[0]);
                  }
                });

                //append primary key to our formData
                formData_object.append('pk', pk);

                deferred = $.ajax({
                      url: submit_url,
                       type: 'POST',
                  processData: false,//important
                  contentType: false,//important
                     dataType: 'json',//server response type
                       data: formData_object
                })
              }
              else {
                deferred = new $.Deferred

                var temporary_iframe_id = 'temporary-iframe-'+(new Date()).getTime()+'-'+(parseInt(Math.random()*1000));
                var temp_iframe = 
                    $('<iframe id="'+temporary_iframe_id+'" name="'+temporary_iframe_id+'" \
                    frameborder="0" width="0" height="0" src="about:blank"\
                    style="position:absolute; z-index:-1; visibility: hidden;"></iframe>')
                    .insertAfter($form);
                    
                $form.append('<input type="hidden" name="temporary-iframe-id" value="'+temporary_iframe_id+'" />');
                
                //append primary key (pk) to our form
                $('<input type="hidden" name="pk" />').val(pk).appendTo($form);
                
                temp_iframe.data('deferrer' , deferred);
                //we save the deferred object to the iframe and in our server side response
                //we use "temporary-iframe-id" to access iframe and its deferred object

                $form.attr({
                      action: submit_url,
                      method: 'POST',
                     enctype: 'multipart/form-data',
                      target: temporary_iframe_id //important
                });

                $form.get(0).submit();

                //if we don't receive any response after 30 seconds, declare it as failed!
                ie_timeout = setTimeout(function(){
                  ie_timeout = null;
                  temp_iframe.attr('src', 'about:blank').remove();
                  deferred.reject({'status':'fail', 'message':'Timeout!'});
                } , 30000);
              }


              //deferred callbacks, triggered by both ajax and iframe solution
              deferred
              .done(function(result) {//success
                var url = result['url'];//the `result` is formatted by your serve+r side response and is arbitrary
                var msj = result['msg'];
                var sts = result['status'];
                var nomb = result['nombre'];

                if(sts == 'done') 
                {
                  //console.log('URL3 : '+avatar+' - '+sts+' - '+url);
                  
                  $.gritter.removeAll();
                  $('.editableform-loading').remove();
                  $('#avatar3').attr('src', url); //.get(0).src = url; 
                  $('#avatar3').attr('class', 'img-responsive');
                  $('#arch_declaracion').val(nomb);
                  $('#avatar3').show();

                }else{
                  alert('Error al subir el archivo.'); //res.message
                }
              })
              .fail(function(result) {//failure
                alert("There was an error");
              })
              .always(function() {//called on both success and failure
                if(ie_timeout) clearTimeout(ie_timeout)
                ie_timeout = null;  
              });

              return deferred.promise();
              // ***END OF UPDATE AVATAR HERE*** //
            },
              
            success: function(response, newValue) {
            }
          });
          
          /**
          //let's display edit mode by default?
          $('#avatar').editable('show').on('hidden', function(e, reason) {
            if(reason == 'onblur') {
              $('#avatar').editable('show');
              return;
            }
            $('#avatar').off('hidden');
          })
          */
          
        }catch(e) {}
        
      });

      if(location.protocol == 'file:') alert("For uploading to server, you should access this page using 'http' protocal, i.e. via a webserver.");
    </script>

  <script type="text/javascript"> 
      ace.vars['base'] = '..'; 
      $(document).ready(function(){
        var id = '';
        MyApp.rptload.init('#reporte',id); 
        MyApp.transferencias.init();
      });
  </script>

  </body>
</html>

