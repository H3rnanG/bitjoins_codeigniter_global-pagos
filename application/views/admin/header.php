<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default navbar-collapse">

  <div class="navbar-container" id="navbar-container">
    <!-- #section:basics/sidebar.mobile.toggle -->
    <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
      <span class="sr-only">Toggle sidebar</span>

      <span class="icon-bar"></span>

      <span class="icon-bar"></span>

      <span class="icon-bar"></span>
    </button>

    <!-- /section:basics/sidebar.mobile.toggle -->
    <div class="navbar-header pull-left">
      <!-- #section:basics/navbar.layout.brand -->
      <a href="#" class="navbar-brand">
        <small>ADMINISTRADOR</small>
      </a>

      <!-- /section:basics/navbar.layout.brand -->

      <!-- #section:basics/navbar.toggle -->

      <!-- /section:basics/navbar.toggle -->
    </div>

    <!-- #section:basics/navbar.dropdown -->
    <div class="navbar-buttons navbar-header pull-right" role="navigation">

        <ul class="ace ace-nav">
            <li class="light-blue">
                <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                    <img class="nav-user-photo" src="<?php echo base_url('assets/admin/avatars/avatar2.png') ?>" alt="Perfil" />
                    <span class="user-info">
                      <small>Bienvenido,</small> <?php echo $usuario; ?>
                    </span>
                    <i class="ace-icon fa fa-caret-down"></i>
                </a>
                
                <ul class="user-menu dropdown-menu dropdown-menu-right dropdown-yellow dropdown-caret dropdown-close">
                    <li><a href="#"><i class="ace-icon fa fa-cog"></i> Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url('login/logout') ?>"><i class="ace-icon fa fa-power-off"></i> Cerrar Sessión</a></li>
                </ul>
            </li>

        </ul>
    </div><!-- / navbar-buttons -->

    <!-- /section:basics/navbar.dropdown -->
  </div><!-- /.navbar-container -->
</div>
<!-- /section:basics/navbar.layout -->