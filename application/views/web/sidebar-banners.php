<div class="banners">
    <div class="wrapper">
        <div class="sld-banners text-white"> <!-- container -->
            <div class="row no-gutters">
                <div class="col-md-9">
                    <div class="sld-galeria owl-carousel owl-theme">
                        <div class="item">
                          <img src="<?php echo base_url('assets/images/banner-home/opti/BANNER01.jpg') ?>" class="img-fluid" >
                        </div>
                        <div class="item">
                          <img src="<?php echo base_url('assets/images/banner-home/opti/BANNER02.jpg') ?>" class="img-fluid" >
                        </div>
                        <div class="item">
                          <img src="<?php echo base_url('assets/images/banner-home/opti/BANNER03.jpg') ?>" class="img-fluid" >
                        </div>
                        <div class="item">
                          <img src="<?php echo base_url('assets/images/banner-home/opti/BANNER04.jpg') ?>" class="img-fluid" >
                        </div>
                        <div class="item">
                          <img src="<?php echo base_url('assets/images/banner-home/opti/BANNER05.jpg') ?>" class="img-fluid" >
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    
                    <aside class="sidebar-frm-tipocambio">
                        <!--<div class="container">-->
                            <h3 class="text-center" >Cotiza Tu AstroPay card</h3>
                            <div class="row no-gutters justify-content-center">
                                <div class="col-md-8 col-xs-12">
                                    <p class="titulo-3 center">Tipo de Cambio</p>
                                    <div class="row no-gutters justify-content-center">
                                        <div class="col-8">
                                            <input type="number" name="apctc" id="apctc" class="form-control input-tc only" value="<?php echo $tc ?>" disabled >
                                        </div>
                                        <div class="col-4">
                                            <div class="etiqueta_moneda">CLP</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row no-gutters justify-content-center">
                                <div class="col-md-8 col-xs-12">
                                    <p class="titulo-3 center">Monto de tu Tarjeta</p>
                                    <div class="row no-gutters  justify-content-center">
                                        <div class="col-8">
                                            <input type="number" name="apcusd" id="apcusd" class="form-control input-tc">
                                        </div>
                                        <div class="col-4">
                                            <div class="etiqueta_moneda">USD</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row no-gutters justify-content-center">
                                <div class="col-md-8 col-xs-12">
                                    <p class="titulo-3 center">Cambio en Pesos</p>
                                    <div class="row no-gutters justify-content-center">
                                        <div class="col-8">
                                            <input type="number" name="apcclp" id="apcclp" class="form-control input-tc">
                                        </div>
                                        <div class="col-4">
                                            <div class="etiqueta_moneda">CLP</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row no-gutters justify-content-center">
                                <div class="col-md-8 col-xs-12 text-center">
                                    <button type="button" class="btn btn-danger btn-tc-refresh"><i class="fa fa-refresh"></i> Cotizar </button>
                                </div>
                            </div>
                        <!--</div>-->
                    </aside>

                </div><!-- / col-md-3 -->

            </div>
        </div>
    </div>
</div>

