<?php include "header.php"; ?>
  <script type="text/javascript" src="js/labores.js"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-calendar fa-fw"></i> Labores</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg nuevalabor" onclick="abrirNuevaLabor()"><i class="fa fa-plus"></i></button> Agregar Nueva Labor
                        </div>
                        <!-- Modal Nueva Labor-->
                        <div class="modal fade" id="nuevaLabor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-calendar fa-fw"></i>  Labores</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formularioLabores">
                                            <div class="col">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Agregar Labor
                                                    </div>
                                                    <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12" id="formNueva">
                                                            <form role="form" id="labores">
                                                                <div class="form-group">
                                                                    <input id="descripcion_corta" name="descripcion_corta" value="" class="form-control" placeholder="Nombre">
                                                                </div>
                                                                <div class="form-group">
                                                                  <select id="id_labor_procedente" name="id_labor_procedente" class="form-control">
                                                                    <option value="NULL" disabled="disable" selected="true" >Labor Precedente</option>
                                                                    <option value="NULL" >Ninguna</option>
                                                                  </select>
                                                                </div>

                                                                <div class="form-group">
                                                                  <select id="id_labor_posterior" name="id_labor_posterior" class="form-control">
                                                                     <option value="NULL" disabled selected="true" >Labor Posterior</option>
                                                                     <option value="NULL"  >Ninguna</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <?php
                                                                        $con = start_connect();
                                                                        if( $con )
                                                                        {
                                                                          $query = "SELECT * FROM  unidades_tiempo_medida";
                                                                          $resultado = mysqli_query($con, $query);
                                                                    ?>
                                                                    <select id="unidades_tiempo" name="unidades_tiempo" class="form-control">
                                                                      <option value="NULL" disabled selected="true" >Unidad de Tiempo</option>
                                                                      <?php
                                                                          while( $row = mysqli_fetch_array( $resultado ) )
                                                                              {
                                                                                echo '<option value="'.$row['id_unidades_tiempo_medida'].'">'. utf8_encode($row['descripcion']).'</option>';
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
                                                                <div class="form-group">
                                                                    <input id="cantidad_tiempo" name="cantidad_tiempo" class="form-control" placeholder="Cantidad">
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea id="descripcion_ampliada" name="descripcion_ampliada" class="form-control" rows="3" placeholder="Descripción Ampliada"></textarea>
                                                                </div>
                                                                <button type="button" onclick="nuevaLabor()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
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
                        <!-- Modal Nueva Medida-->
                        <div class="modal fade" id="nuevaMedida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-calendar fa-fw"></i> Labores</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formularioLabores">
                                            <div class="col">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Editar Labor
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-lg-12" id="formNueva">
                                                                <form role="form" id="labores">
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
                                <table class="table table-striped table-bordered table-hover " id="tabla_labores">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Labor Precedente</th>
                                            <th>Labor Posterior</th>
                                            <th>Tiempo</th>
                                            <th class="center">Descripcion</th>
                                            <th class="editar center">Editar</th>
                                            <th class="editar center">Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_labores">
                                    <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = "SELECT * FROM qr_labores";
                                        $resultado = mysqli_query($con, $query);
                                        while( $row = mysqli_fetch_array($resultado) )
                                        {
                                        ?>
                                          <tr class="<?php echo $class ?> gradeX">
                                            <td><?php echo utf8_encode($row["descripcion_corta"]) ?></td>
                                            <td><?php echo utf8_encode($row["desc_corta_labor_procedente"]) ?></td>
                                            <td><?php echo utf8_encode($row["desc_corta_labor_posterior"]) ?></td>
                                            <td><?php echo $row["cantidad_tiempo"] .' ' .  utf8_encode($row["unidad_medida"]) ?></td>

                                            <td><?php echo utf8_encode(eregi_replace("[\n|\r|\n\r]", '<br>',$row["descripcion_ampliada"])) ?></td>
                                            <?php echo '<td class="center">
                                              <a onclick="editarLabor(\''. utf8_encode($row["id_labores"]) .'\',\''. utf8_encode($row["descripcion_corta"]) .'\',\''. $row["id_labor_procedente"] .'\',\''. $row["id_labor_posterior"] .'\',\''. $row["id_unidades_tiempo_medida"] .'\',\''. $row["cantidad_tiempo"] .'\',\''. utf8_encode(eregi_replace("[\n|\r|\n\r]", "\\n",$row["descripcion_ampliada"])) .'\')" <button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                              </td>
                                            <td class="center">
                                              <a href="javascript:borrarLabor(\''. $row["id_labores"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
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
            <div class="modal fade" id="editLabor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"> <i class="fa fa-calendar fa-fw"></i> Labores</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formularioLabores">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Editar Labor
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form role="form" id="labores">
                                                        <input type="hidden" id="edit_id_labores" name="id_labores" >
                                                        <div class="form-group">
                                                            <label for="nombre">Nombre:</label>
                                                            <input id="edit_descripcion_corta" name="descripcion_corta" class="form-control" placeholder="Nombre">
                                                        </div>
                                                        <div class="form-group">
                                                          <label for="nombre">Labor Procedente:</label>
                                                          <select id="edit_id_labor_procedente" name="id_labor_procedente" class="form-control">
                                                            <option value="NULL" selected="true" >Seleccione</option>
                                                            <option value="NULL" >Ninguna</option>                                                          
                                                          </select>
                                                        </div>
                                                        <div class="form-group">
                                                          <label for="nombre">Labor Posterior:</label>
                                                           <select id="edit_id_labor_posterior" name="edit_id_labor_posterior" class="form-control">
                                                            <option value="NULL" selected="true" >Seleccione</option>
                                                            <option value="NULL" >Ninguna</option> 
                                                          </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <?php
                                                                $con = start_connect();
                                                                if( $con )
                                                                {
                                                                  $query = "SELECT id_unidades_tiempo_medida,descripcion FROM  unidades_tiempo_medida";
                                                                  $resultado = mysqli_query($con, $query);
                                                            ?>
                                                            <label for="nombre">Unidad Medida Tiempo:</label>
                                                            <select id="edit_unidades_tiempo" name="unidades_tiempo" class="form-control">
                                                              <option value="NULL" selected="true" >Seleccione</option>
                                                              <?php
                                                                  while( $row = mysqli_fetch_array( $resultado ) )
                                                                      {
                                                                        echo '<option value="'.$row['id_unidades_tiempo_medida'].'">'. utf8_encode($row['descripcion']).'</option>';
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
                                                        <div class="form-group">
                                                            <label for="nombre">Cantidad de Tiempo:</label>
                                                            <input id="edit_cantidad_tiempo" name="cantidad_tiempo" class="form-control" placeholder="Cantidad de tiempo">
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea id="edit_descripcion_ampliada" name="descripcion_ampliada" class="form-control" rows="3" placeholder="Descripción Ampliada"></textarea>
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
