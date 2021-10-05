<?php include "header.php"; ?>
  <script type="text/javascript" src="js/eps.js"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-ambulance fa-fw"></i> EPS </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg nuevaeps" data-toggle="modal" data-target="#nuevaEPS"><i class="fa fa-plus"></i></button> Agregar EPS  
                        </div>
                        <!-- Modal Nueva Medida-->
                        <div class="modal fade" id="nuevaEPS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-ambulance fa-fw"></i> EPS</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formularioTiempo">
                                            <div class="col">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Agregar EPS
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-lg-12" id="formNueva">
                                                                <form role="form" id="tiempo">
                                                                    <div class="form-group">
                                                                        <input id="descripcion" name="descripcion" value="" class="form-control" placeholder="Nombre">
                                                                    </div>
                                                                    <button type="button" onclick="nuevaEPS()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
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
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover " id="tabla_eps">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th class="borrar center">Editar</th>
                                            <th class="borrar center">Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_tiempo">
                                    <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = "SELECT * FROM eps
";
                                        $resultado = mysqli_query($con, $query);
                                        while( $row = mysqli_fetch_array($resultado) )
                                        {
                                        ?>
                                          <tr class="<?php echo $class ?> gradeX">
                                            <td><?php echo utf8_encode($row["nombre"]) ?></td>
                                            <?php echo '<td class="center">
                                              <a onclick="editarEPS(\''. $row["id_eps"] .'\',\''. utf8_encode($row["nombre"]) .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                              </td>
                                            <td class="center">
                                              <a href="javascript:borrarEPS(\''. $row["id_eps"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
                                              </td>
                                          </tr>';
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
            <!-- Modal -->
            <div class="modal fade" id="editEPS" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-ambulance fa-fw"></i> EPS</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formularioTiempo">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Editar EPS
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form role="form" id="tiempo">
                                                        <input type="hidden" id="edit_id" name="id" >
                                                        <div class="form-group">
                                                            <label for="nombre">Nombre:</label>
                                                            <input id="edit_descripcion" name="descripcion" class="form-control" placeholder="Nombre">
                                                        </div>
                                                        <button type="button" onclick="guardarEdicion()" id="form-submit" class="btn btn-default pull-right ">Actualizar</button>
                                                        <div id="msgSubmit" class="h3 text-center hidden">Actualizada!</div>
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
<?php include "footer.php";?>
