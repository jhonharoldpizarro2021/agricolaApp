<?php include "header.php"; ?>
<script type="text/javascript" src="js/geolocalizacion.js?n=<?= time() ?>"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-location-arrow fa-fw"></i> Geolocalizacion </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Informe de Consumos  
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body mapa">
                            <div id="content_mapa" style="width:100%;height:100%;"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
<?php include "footer.php";?>
