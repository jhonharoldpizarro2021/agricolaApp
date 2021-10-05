<?php include "header.php"; ?>
  <script type="text/javascript" src="js/cat_gastos_costos.js"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-ticket fa-fw"></i> Categorias Gastos/Costos Indirectos</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg nuevacat" data-toggle="modal" data-target="#nuevaCat"><i class="fa fa-plus"></i></button> Agregar Categoria de Gasto/Costo  
                        </div>
                        <!-- Modal Nueva Medida-->
                        <div class="modal fade" id="nuevaCat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-ticket fa-fw"></i> Categorias de Gastos/Costos</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formularioCat">
                                            <div class="col">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Agregar Categoria de Gasto/Costo
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-lg-12" id="formNueva">
                                                                <form role="form" id="tiempo">
                                                                    <div class="form-group">
                                                                        <select id="tipo" name="tipo" class="form-control">
                                                                            <option value="NULL" disabled selected >Tipo</option>
                                                                            <option value="1">Gasto</option>
                                                                            <option value="2">Costo Indirecto</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea id="descripcion" name="descripcion" class="form-control" rows="3" placeholder="Descripcion"></textarea>
                                                                    </div>
                                                                    <button type="button" onclick="nuevaCat()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
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
                                <table class="table table-striped table-bordered table-hover " id="tabla_Cat">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Descripci&oacute;n</th>
                                            <th class="center">Editar</th>
                                            <th class="center">Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_cat">
                                    <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = "SELECT * FROM qr_categorias_gastos_ci";
                                        $resultado = mysqli_query($con, $query);
                                        while( $row = mysqli_fetch_array($resultado) )
                                        {
                                        ?>
                                          <tr class="gradeX">
                                            <td><?php echo utf8_encode($row["nombre_tipo"]) ?></td>
                                            <td><?php echo utf8_encode(eregi_replace("[\n|\r|\n\r]", '<br>',$row["descripcion"])) ?></td>
                                            <?php echo '<td class="center">
                                              <a onclick="editarCat(\''. $row["idCategoria"] .'\',\''. utf8_encode($row["tipo"]) .'\',\''. utf8_encode(eregi_replace("[\n|\r|\n\r]", "\\n",$row["descripcion"])) .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                            </td>
                                            <td class="center">
                                              <a href="javascript:borrarCat(\''. $row["idCategoria"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
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
            <div class="modal fade" id="editCat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-ticket fa-fw"></i> ARL</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formularioTiempo">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Editar Categoria
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12" id="formNueva">
                                                    <form role="form" id="tiempo">
                                                        <input type="hidden" id="edit_id" name="id" >
                                                        <div class="form-group">
                                                            <select id="edit_tipo" name="tipo" class="form-control">
                                                                <option value="NULL" disabled selected >Tipo</option>
                                                                <option value="1">Gasto</option>
                                                                <option value="2">Costo Indirecto</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea id="edit_descripcion" name="descripcion" class="form-control" rows="3" placeholder="Descripcion"></textarea>
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
