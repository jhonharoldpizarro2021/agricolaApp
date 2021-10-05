<?php include "header.php"; ?>
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>
<script type="text/javascript" src="js/tct_vs_corte.js?n=<?= time() ?>"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <div id="page-wrapper">
    <!-- row -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><i class="fa fa-eyedropper fa-fw"></i> Informe Toneladas Caña -vs- Corte</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <!-- Modal Nueva Medida-->
    <div class="modal fade" id="informeFinca" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-plus"></i></button>
                  <h4 class="modal-title" id="myModalLabel"><i class="fa fa-eyedropper fa-fw"></i> Informe Toneladas Caña -vs- Corte </h4>
                </div>
                <div class="modal-body">
                    <div class="row row2 between" id="formularioTiempo">
                        <div class="col">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Generar Informe por Finca
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12" id="formNueva">
                                            <form role="form" id="registroPluviometria">
                                                <div class="form-group">
                                                    <?php
                                                        $con = start_connect();
                                                        if( $con )
                                                        {
                                                            $query = " SELECT * FROM unidades_agricolas WHERE id_padre='0' ";
                                                            $resultado = mysqli_query($con, $query);
                                                    ?>
                                                    <select id="finca" name="finca" class="form-control">
                                                      <option value="NULL" disabled selected="true" >Seleccionar Finca</option>
                                                      <?php
                                                          while( $row = mysqli_fetch_array( $resultado ) )
                                                              {
                                                                echo '<option value="'.$row['id_unidades_agricolas'].'">'. utf8_encode($row['nombre']) .'</option>';
                                                              }
                                                          if( !close_bd($con) )
                                                          {
                                                            echo "Error al cerrar la BDD";
                                                          }
                                                        }else{
                                                          echo "Error de conexión a la BDD:". mysqli_connect_error();
                                                        }
                                                      ?>
                                                    </select>
                                                </div>                                                                
                                                <button type="button" onclick="informeFinca()" id="form-submit" class="btn btn-default pull-right ">Generar</button>
                                                <div id="msgSubmit" class="h3 text-center hidden">Creada!</div>
                                            </form>
                                        </div>
                                        <!-- /.col-lg-12 (nested) -->
                                    </div>
                                    <!-- /.row (nested) -->
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- row -->
    <div class="row" id="datos">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                  <div class="row">
                    <div class="col-md-6">
                      <button type="button" class="btn btn-default btn-circle btn-lg informeFinca" data-toggle="modal" data-target="#informeFinca"><i class="fa fa-plus"></i></button> <h4> Generar Informe por Finca</h4>
                    </div>
                    <!-- <div class="col-md-6">
                      <button type="button" class="btn btn-default btn-circle btn-lg informeFecha" data-toggle="modal" data-target="#informeFecha"><i class="fa fa-plus"></i></button> <h4> Generar Informe por Fecha</h4>
                    </div> -->
                  </div>                          
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                  <!-- /.panel-heading -->
                  <div id="morris-area-chart">
                      
                  </div>
                  <!-- /.panel-body -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <!-- Modal Sppinner -->
    <div class="modal fade" id="modalSpinner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: rgba(255,255,255,0.8)">
      <div class="load">
        <div class="gear one">
          <svg id="blue" viewbox="0 0 100 100" fill="#80B419">
            <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>
          </svg>
        </div>
        <div class="gear two">
          <svg id="pink" viewbox="0 0 100 100" fill="sienna">
            <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>
          </svg>
        </div>
        <div class="gear three">
          <svg id="yellow" viewbox="0 0 100 100" fill="#6B8E23">
            <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>
          </svg>
        </div>
        <div class="lil-circle"></div>
        <!-- <svg class="blur-circle">
          <filter id="blur">
            <fegaussianblur in="SourceGraphic" stddeviation="13"></fegaussianblur>
          </filter>
          <circle cx="70" cy="70" r="66" fill="transparent" stroke="rgba(255,255,255,0.1)" stroke-width="40" filter="url(#blur)"></circle>
        </svg> -->
      </div>
      <div class="text"><h2>Buscando....</h2></div>
      <!-- /.modal-dialog -->
    </div>
    <!-- / Modal Spinner --> 
<?php include "footer.php";?>
