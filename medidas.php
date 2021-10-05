<?php include "header.php"; ?>
  <script type="text/javascript" src="js/medidas.js"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-exchange fa-fw"></i> Unidades de Medida </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg nuevaunidad" data-toggle="modal" data-target="#nuevaMedida"><i class="fa fa-plus"></i></button> Agregar Unidad de Medida  
                        </div>
                        <!-- Modal Nueva Medida-->
                        <div class="modal fade" id="nuevaMedida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-exchange fa-fw"></i> Unidades de Medida </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formularioMedidas">
                                            <div class="col">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Agregar Unidad de Medida 
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-lg-12" id="formNueva">
                                                                <form role="form" id="medidas">
                                                                    <div class="form-group">
                                                                        <input id="descripcion" name="descripcion" value="" class="form-control" placeholder="Nombre">
                                                                    </div>
                                                                    <button type="button" onclick="nuevaMedida()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
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
                                <table class="table table-striped table-bordered table-hover " id="tabla_medida">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th class="borrar center">Editar</th>
                                            <th class="borrar center">Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_medida">
                                    <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = "SELECT * FROM unidades_medida
";
                                        $resultado = mysqli_query($con, $query);
                                        while( $row = mysqli_fetch_array($resultado) )
                                        {
                                        ?>
                                          <tr class="<?php echo $class ?> gradeX">
                                            <td><?php echo utf8_encode($row["descripcion"]) ?></td>
                                            <?php echo '<td class="center">
                                              <a onclick="editarMedida(\''. $row["id_unidades_medida"] .'\',\''. utf8_encode($row["descripcion"]) .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                            </td>
                                            <td class="center">
                                              <a href="javascript:borrarMedida(\''. $row["id_unidades_medida"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
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
            <div class="modal fade" id="editMedida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-exchange fa-fw"></i> Unidades de Medida</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formularioMedida">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Editar Unidad de Medida 
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form role="form" id="medida">
                                                        <input type="hidden" id="edit_id_unidades_medida" name="id_unidades_medida" >
                                                        <div class="form-group">
                                                            <label for="descripcion">Nombre:</label>
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
