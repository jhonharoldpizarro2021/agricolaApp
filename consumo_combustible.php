<?php include "header.php"; ?>
<script type="text/javascript" src="js/combustible.js"></script>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-battery-full fa-fw"></i> Consumos de Combustible </h1>
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
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover " id="tabla_eps">
                                    <thead>
                                        <tr>
                                            <th>Maquina</th>
                                            <th>Litros / Galones</th>
                                            <th>Fecha (Mes-Año)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_tiempo">
                                    <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = "SELECT * FROM qryConsumoCombustible ORDER BY fecha_hora DESC ";
                                        $resultado = mysqli_query($con, $query);
                                        while( $row = mysqli_fetch_array($resultado) )
                                        {
                                        ?>
                                          <tr class="<?php echo $class ?> gradeX">
                                            <td><?php echo utf8_encode($row["nombre"]) ?></td>
                                            <td><?php echo $row["litros"] ?> / <?php echo $row["galones"]  ?></td>
                                            <td><?php echo $row["fecha_hora"] ?></td>
                                          </tr>
                                        <?php ;
                                        }
                                        if( !close_bd($con) )
                                        {
                                          echo "Error al cerrar la BDD";
                                        }
                                      }else{
                                        echo "Error de conexión a la BDD:". mysqli_connect_error();
                                      }
                                    ?>
                                  </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
<?php include "footer.php";?>
