
<div class="sidebar-info">
  <div class="container">
    <nav class="navbar navbar-expand-lg">
      <div class="collapse navbar-collapse" id="navSecond"></div>
      <ul class="navbar-nav mr-auto float-right navbar-usuario navbar-login">
        <li class="nav-item">
          <a class="nav-link" href="#">Bienvenido <?php echo $nombres; ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url('usuario/logout') ?>">Cerrar Sessión</a>
        </li>
        <li class="nav-item">
          <img src="<?php echo base_url('assets/images/bandera-pais.png') ?>" alt="CHILE" width="30" >
        </li>
      </ul>
    </nav>
  </div>
</div>


<div class="bgnav">

  <div class="container">

    <nav class="navbar navbar-expand-lg">
      <a class="navbar-brand" href="<?php echo base_url(); ?>"> <img src="<?php echo base_url('assets/images/logo-distribuidor-astropay-chile.png') ?>" class="img-fluid"> </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navMain">
        <ul class="navbar-nav float-right nav-web">
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo base_url('home') ?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('nosotros') ?>">Nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('comprar') ?>">Comprar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('contacto') ?>">Contacto</a>
          </li>
        </ul>
      </div>
    </nav>

  </div>

</div>