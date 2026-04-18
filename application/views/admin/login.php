<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

?>


<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Administrador - Login </title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <script src="https://kit.fontawesome.com/87d13c53ed.js" crossorigin="anonymous"></script>

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-fonts.css') ?>" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace.css') ?>?v=1" />

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-part2.css') ?>" />
    <![endif]-->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-rtl.css') ?>" />

    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/app.css') ?>" />

    <link rel="stylesheet" href="<?php echo base_url('assets/admin/app/css/loading/jquery.loading.min.css'); ?>">

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/ace-ie.css') ?>" />
    <![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="<?php echo base_url('assets/admin/js/html5shiv.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/respond.js') ?>"></script>
    <![endif]-->

  </head>

  <body class="login-layout">

    <div class="main-container">
      <div class="main-content">
        <div class="space"></div>
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="login-container">
              <div class="center">
                <img src="<?php echo base_url('assets/images/isotipo-apc.jpg') ?>" width="80">
              </div>

              <div class="space-6"></div>

              <div class="position-relative">
                
                <div id="login-box" class="login-box visible widget-box no-border">
                  <div class="widget-body">
                    <div class="widget-main">
                      
                      <div id="error"></div>

                      <h4 class="header orange lighter bigger">
                        <i class="ace-icon fa fa-coffee orange"></i>
                        Introduzca su información
                      </h4>

                      <div class="space-6"></div>

                      <form name="sigin" id="sigin" method="post" action="<?php echo base_url('login/loguear') ?>" role="form" >
                        <fieldset>
                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="email" name="email" id="email" class="form-control" placeholder="Usuario" maxlength="100" />
                              <i class="ace-icon fa fa-user"></i>
                            </span>
                          </label>

                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" maxlength="100" />
                              <i class="ace-icon fa fa-lock"></i>
                            </span>
                          </label>

                          <div class="space"></div>

                          <div class="clearfix">
                            <label class="inline">
                              <input type="checkbox" class="ace" />
                              <span class="lbl"> Recordar usuario</span>
                            </label>

                            <button type="submit" id="bt-sigin" nform="#sigin" class="width-35 pull-right btn btn-sm btn-primary">
                              <i class="ace-icon fa fa-key"></i>
                              <span class="bigger-110">Login</span>
                            </button>
                          </div>

                          <div class="space-4"></div>
                        </fieldset>
                      </form>

                    </div><!-- /.widget-main -->

                    <div class="toolbar clearfix">
                      <br>
                      <p class="center"><a href="" class="forgot-password-link"><?php echo date('Y') ?></a></p>
                      <!--
                      <div>
                        <a href="#" data-target="#forgot-box" class="forgot-password-link">
                          <i class="ace-icon fa fa-arrow-left"></i>
                          ¿Resetear Password?
                        </a>
                      </div>
                      -->

                      <!--<div>
                        <a href="#" data-target="#signup-box" class="user-signup-link">
                          I want to register
                          <i class="ace-icon fa fa-arrow-right"></i>
                        </a>
                      </div>-->
                    </div>
                  </div><!-- /.widget-body -->
                </div><!-- /.login-box -->

                <div id="forgot-box" class="forgot-box widget-box no-border">
                  <div class="widget-body">
                    <div class="widget-main">
                      <h4 class="header red lighter bigger">
                        <i class="ace-icon fa fa-key"></i>
                        Acceso
                      </h4>

                      <div class="space-6"></div>
                      <p>
                        Ingresa el codigo de acceso que enviamos a tu correo.
                      </p>

                      <form id="frmtoken" name="frmtoken" method="post" action="<?php echo base_url('login/acceso') ?>" autocomplete="off">
                        <div id="errorForgot"></div>
                        <fieldset>
                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="text" id="code" name="code" class="form-control" placeholder="Codigo de Acceso" maxlength="6" />
                              <i class="ace-icon fa fa-hashtag"></i>
                            </span>
                          </label>

                          <div class="clearfix">
                            <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                              <i class="ace-icon fa fa-lightbulb-o"></i>
                              <span class="bigger-110">Enviar!</span>
                            </button>
                          </div>
                        </fieldset>
                      </form>
                    </div><!-- /.widget-main -->

                    <div class="toolbar center">
                      <a href="#" data-target="#login-box" class="back-to-login-link">
                        Volver al login
                        <i class="ace-icon fa fa-arrow-right"></i>
                      </a>
                    </div>
                  </div><!-- /.widget-body -->
                </div><!-- /.forgot-box -->

              </div><!-- /.position-relative -->
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script type="text/javascript">
      window.jQuery || document.write("<script src='<?php echo base_url('assets/admin/js/jquery.js'); ?>'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script type="text/javascript">
     window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
    </script>
    <![endif]-->
    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url('assets/admin/js/jquery.mobile.custom.js'); ?>'>"+"<"+"/script>");
    </script>

    <script src="http://www.google.com/recaptcha/api.js?render=6LeV480ZAAAAAH15AZpw7tRYqoKBxjabT5QwvEuk"></script>

    <script src="<?php echo base_url('assets/admin/app/js/external/loading/jquery.loading.min.js'); ?>"></script>

    <script src='<?php echo base_url('assets/admin/app/js/librarie.js'); ?>?v=<?php echo rand(1,9999999) ?>'></script>
    <script src='<?php echo base_url('assets/admin/app/js/login.js'); ?>?v=<?php echo rand(1,9999999) ?>'></script>

    <script type="text/javascript">
      MyApp.login.init('bt-sigin');
    </script>
  </body>
</html>


