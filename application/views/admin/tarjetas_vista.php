
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Administrador - Tarjetas </title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/font-awesome.min.css') ?>?v=<?php echo rand(0,99999) ?>" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-fonts.css') ?>" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace.css') ?>" />
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

                <h2 class="header smaller lighter orange">Inventario de tarjetas</h2>

                <div class="sidebar h-sidebar navbar-collapse ace-save-state">

                 <ul id="tabseccion" class="nav nav-list" >
                   <li class="active">
                      <a href="#home" data-toggle="tab">
                        <i class="menu-icon fa fa-credit-card-alt"></i>
                        <span class="menu-text"> Tarjetas </span>
                      </a>
                   </li>
                   
                   <li>
                      <a href="#form" data-toggle="tab">
                        <i class="menu-icon fa fa-wpforms"></i>
                        <span class="menu-text"> Datos </span>
                      </a>
                   </li>

                   <li>
                      <a href="#importar" data-toggle="tab">
                        <i class="menu-icon fa fa-file-excel-o"></i>
                        <span class="menu-text"> Importar </span>
                      </a>
                   </li>
                 
                 </ul>

                 <div class="tab-content">
                   <div class="tab-pane in active" id="home">
                    
                    <form id="frm_filtrar" method="post" class="form-inline">

                      <div class="form-group">
                          <label>Tarjeta de: </label>
                          <input type="number" name="rpt_tarjeta_mnt" id="rpt_tarjeta_mnt" class="form-control inpfiltro">
                      </div>

                      <div class="form-group">
                          <label>Estado: </label>
                          <select name="rpt_estado" id="rpt_estado" class="form-control inpfiltro">
                            <option value="">Todos</option>
                            <option value="1">Disponible</option>
                            <option value="2">Comprado</option>
                          </select>
                      </div>

                      <div class="form-group">
                          <button type="button" class="btn btn-sm btn-rpt-filtro" ><i class="fa fa-filter"></i> Filtrar</button>
                      </div>

                      <div class="form-group">
                          <button type="button" class="btn btn-sm btn-inverse btn-rpt-reset" ><i class="fa fa-eraser"></i> Reinicar</button>
                      </div>

                      <div class="form-group">
                          <button type="button" class="btn btn-sm btn-success btn-inventario" data-action="<?php echo base_url('tarjeta/alerta_inventario') ?>" >
                            <i class="fa fa-paper-plane"></i> Inventario Tarjetas </button>
                      </div>
                    </form>
                    <br>
                    <table id="reporte" class="table table-bordered table-hover reporte" width="100%" data-action="<?php echo site_url('admin/ajax_vista_tarjetas')?>">
                      <thead>
                          <tr>
                              <th></th>
                              <th>Item</th>
                              <th>ST</th>
                              <th>Foto</th>
                              <th>N° Tarjeta</th>
                              <th>Monto</th> <!-- 2 -->
                              <th>Fecha Reg.</th> <!-- 3 -->
                              <th>Hora Reg.</th> <!-- 3 -->
                              <th>Usuario</th>
                              <th>N° Operación</th>
                              <th>Fecha Conf.</th> <!-- 4 -->
                              <th>Hora Conf.</th> <!-- 5 -->
                          </tr>
                      </thead>
                    </table>

                   </div><!-- /home -->

                   <div class="tab-pane" id="form" data-action="<?php echo base_url('admin/get_tarjetas') ?>">
                    
                    <div class="row">
                      <div class="col-md-12">

                          <div class="row">
                            <div id="msj"></div>
                          </div>

                          <div class="col-md-6">
                            <form name="frm" id="frm" method="post" class="frmreg" action="<?php echo base_url('admin/grabar_tarjetas'); ?>" >

                            <div class="row">
                              <div class="col-sm-3" >
                                <label><span class="red">*</span> Monto</label>
                                <input type="hidden" name="id" id="id" class="camp_id">
                                <input type="hidden" name="foto" id="foto" class="camp_foto">
                                <input type="number" name="monto" id="monto" class="form-control camp_monto">
                              </div>  
                              <div class="col-sm-3" >
                                <label>N° Tarjeta</label>
                                <input type="text" name="digitos" id="digitos" class="form-control camp_digitos" >
                              </div>  
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-sm-3" >
                                <label>Fecha Reg</label>
                                <input type="date" name="fechareg" id="fechareg" class="form-control camp_fechareg" readonly>
                              </div>  
                              <div class="col-sm-3" >
                                <label>Hora Reg</label>
                                <input type="text" name="horareg" id="horareg" class="form-control camp_horareg" readonly>
                              </div>  

                              <div class="col-sm-3" >
                                <label>Fecha Compra</label>
                                <input type="date" name="fechacomp" id="fechacomp" class="form-control camp_fechacomp" readonly>
                              </div>  
                              <div class="col-sm-3" >
                                <label>Hora Compra</label>
                                <input type="text" name="horacomp" id="horacomp" class="form-control camp_horacomp" readonly>
                              </div>  
                            </div>
                            <br>
                            <div class="clearfix form-actions">
                              <button type="submit" id="save" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Grabar Datos</button>
                              <button type="button" id="button" class="btn btn-inverse btn-volver"><i class="fa fa-eraser"></i> Volver</button>
                            </div>

                            </form>
                          </div><!-- /col-md-8 fin -->

                          <div class="col-md-4">
                            <div class="row">
                              <div class="col-sm-10">
                                <p><i>Click en la imagen para adjuntar.</i></p>
                                <span class="profile-picture avat1" data-action="<?php echo base_url('admin/uploadtc') ?>" >
                                  <img data-pk="1" src="<?php echo base_url('assets/images/tarjetas/tarjeta-xxx.jpg') ?>" data-carpeta="<?php echo base_url('assets/upload/temptc/') ?>" alt="TARJETA" class="img-responsive" id="avatar" data-default="<?php echo base_url('assets/images/tarjetas/tarjeta-xxx.jpg') ?>" />
                                </span>
                              </div>
                            </div>
                            <br>
                          </div><!-- /col-md-4 -->

                      </div><!-- /col-md-12 -->
                    </div><!-- /row -->

                   </div><!-- /form -->

                   <div class="tab-pane" id="importar">
                      
                      <h1>Importar Excel </h1>
                      <?php
                      echo form_open_multipart('tarjeta/import');
                      echo form_upload('file');
                      echo '<br/>';
                      echo form_submit(null, 'Upload');
                      echo form_close();
                      ?>

                   </div><!-- /importar -->

                 </div><!-- /tab-content -->

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

      var modulo = '.md-tarjetas';
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
    <!--<script src="<?php echo base_url('assets/admin/app/js/bootbox.min.js'); ?>"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>


    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.2/dist/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/admin/js/chosen.jquery.min.js') ?>"></script>

    <script src="<?php echo base_url('assets/js/ace/bootstrap-editable.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/ace/ace-editable.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.gritter/js/jquery.gritter.js'); ?>"></script>
    
    <script src="<?php echo base_url('assets/admin/app/js/librarie.js')?>"></script>
    <script src="<?php echo base_url('assets/admin/app/js/app.js'); ?>?v=<?php echo rand(0,9999999); ?>"></script>

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

          $('#avatar').editable({
            type: 'image',
            name: 'avatar',
            value: null,
            onblur: 'ignore',
            image: {
              //specify ace file input plugin's options here
              btn_choose: 'Tarjeta',
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

                //console.log('URL: '+avatar+' - '+sts+' - '+url);
                if(sts == 'done') 
                {
                  $.gritter.removeAll();
                  $('.editableform-loading').remove();
                  $('#avatar').attr('src', url); //.get(0).src = url; 
                  $('#avatar').attr('class', 'img-responsive');
                  $('#foto').val(nomb);
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

          $('#avatar').on('hidden', function(e, reason) {
            console.log('OCULTAR');
              if(reason === 'save' || reason === 'cancel') {
                  //auto-open next editable
                  $(this).closest('tr').next().find('.editable').editable('show');
              } 
          });
          
          /*$(document).on('click','.editable-cancel', function(){
            $('.editableform-loading').remove();
            $('.editable-inline').remove();
            $form = '';
            $('#avatar').show();
            $('#avatar').class('img-responsive editable editable-click editable-empty');
          });*/
          
          //let's display edit mode by default?
          /*$('.editable-cancel').editable('show').on('hidden', function(e, reason) {
            if(reason == 'onblur') {
              $('#avatar').editable('show');
              return;
            }
            $('#avatar').off('hidden');
          })*/
          
          
        }catch(e) {}
        
      });

      if(location.protocol == 'file:') alert("For uploading to server, you should access this page using 'http' protocal, i.e. via a webserver.");
    </script>

    <script type="text/javascript"> 
        ace.vars['base'] = '..'; 

        $(document).ready(function(){
          MyApp.maestros.init();
          MyApp.tarjetas.init();
        });

    </script>

  </body>
</html>

