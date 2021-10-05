<?php include "header.php"; ?>
  <script type="text/javascript" src="js/nomina.js?n=<?= time() ?>"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-money fa-fw"></i> Registros de Nomina</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg nuevo" onclick="abrirNuevo()"><i class="fa fa-plus"></i></button> Agregar Registro de Nomina  
                        </div>
                        <!-- Modal nuevo -->
                        <div class="modal fade" id="nuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-money fa-fw"></i> Registro de Nomina</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formulario">
                                            <div class="col">
                                                <div class="panel panel-default">
                                                     <div class="panel-heading"> Nuevo Registro </div>
                                                    <div class="panel-body">
                                                      <div class="row">
                                                          <div class="col-lg-12" id="">
                                                              <form role="form">
                                                                  <div class="form-group">
                                                                      <div class="input-group date tiempo" data-date="" data-date-format="dd MM yyyy HH:mm:ss" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                          <input id="fecha" name="fecha" class="form-control" size="16" type="text" value="" placeholder="Fecha">
                                                                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                      </div>
                                                                  </div>
                                                                  <div class="form-group">
                                                                      <input id="valor" name="valor" class="form-control" value="" placeholder="Valor">
                                                                  </div>                                                         
                                                                  <div class="form-group">
                                                                      <textarea id="descripcion" name="descripcion" class="form-control" rows="3" placeholder="Descripción"></textarea>
                                                                  </div>
                                                                  <div class="form-group">
                                                                        <?php
                                                                            $con = start_connect();
                                                                            if( $con ){
                                                                              $query = " SELECT id_personal,nombre_personal FROM personal";
                                                                              $resultado = mysqli_query($con, $query);
                                                                        ?>
                                                                        <select id="empleado" name="empleado" class="form-control">
                                                                          <option value="NULL" disabled selected="true" >Seleccionar Empleado</option>
                                                                          <?php
                                                                              while( $row = mysqli_fetch_array( $resultado ) ){
                                                                                    echo '<option value="'.$row['id_personal'].'">'. utf8_encode($row['nombre_personal']) .'</option>';
                                                                                  }
                                                                              if( !close_bd($con) ){
                                                                                echo "Error al cerrar la BDD";
                                                                              }
                                                                            }
                                                                            else{
                                                                              echo "Error de conexión a la BDD:". mysqli_connect_error();
                                                                            }
                                                                          ?>
                                                                        </select>
                                                                  </div>


                                                                  <button type="button" onclick="guardarNuevo()" id="form-submit" class="btn btn-default pull-right ">Agregar</button>
                                                                  <div id="msgSubmit" class="h3 text-center hidden">Agregado!</div>
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
                              <table class="table table-striped table-bordered table-hover" id="tabla">
                                  <thead>
                                      <tr>
                                          <th>Empleado</th>
                                          <th>Fecha</th>
                                          <th>Valor</th>                                          
                                          <th>Descripción</th>
                                          <th class="editar">Editar</th>
                                          <th class="borrar">Borrar</th>
                                      </tr>
                                  </thead>
                                  <tbody id="body_nomina">
                                    <?php
                                      $con = start_connect();
                                        if( $con ){
                                          $query = " SELECT * FROM qryMvtoNomina ";
                                          $resultado = mysqli_query($con, $query);
                                          while( $row = mysqli_fetch_array($resultado) ) {  
                                          ?>
                                          <tr>
                                            <td><?php echo utf8_encode($row["nombre_personal"]) ?></td>
                                            <td><?php echo $row["fecha"] ?></td>
                                            <td> $ <?php echo $row["valor"] ?></td>
                                            <td><?php echo utf8_encode($row["descripcion"]) ?></td>
                                            <?php echo '<td class="center">
                                              <a onclick="editar(\''. $row["id_mvto_nomina"] .'\',\''. $row["fecha"] .'\',\''. $row["valor"] .'\',\''. utf8_encode($row["descripcion"]) .'\',\''. utf8_encode($row["nombre_personal"]) .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                            </td>
                                            <td class="center">
                                              <a href="javascript:borrar(\''. $row["id_mvto_nomina"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
                                            </td>
                                          </tr>';
                                          }
                                          if( !close_bd($con) ){
                                            echo "Error al cerrar la BDD";
                                          }
                                        }
                                        else{
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
            <!-- Modal editar -->
            <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-money fa-fw"></i> Costos indirectos</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                         <div class="panel-heading">  Editar Reg. Nomina </div>
                                        <div class="panel-body">
                                          <div class="row">
                                              <div class="col-lg-12" id="">
                                                  <form role="form">
                                                      <input type="hidden" id="edit_id" name="edit_id" >
                                                      <input type="hidden" id="edit_empleado" name="edit_empleado" >
                                                      <div class="form-group">
                                                          <input id="edit_nEmpleado" name="edit_nEmpleado" class="form-control" readonly>
                                                      </div> 
                                                      <div class="form-group">
                                                          <div class="input-group date tiempo" data-date="" data-date-format="dd MM yyyy HH:mm:ss" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                              <input id="edit_fecha" name="edit_fecha" class="form-control" size="16" type="text" value="" placeholder="Fecha">
                                                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                          </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <input id="edit_valor" name="edit_valor" class="form-control" placeholder="Valor">
                                                      </div>                                                      
                                                      <div class="form-group">
                                                          <textarea id="edit_descripcion" name="edit_descripcion" class="form-control" rows="3" placeholder="Descripción"></textarea>
                                                      </div>
                                                      <button type="button" onclick="guardarEdicion()" id="form-submit" class="btn btn-default pull-right ">Editar Registro</button>
                                                      <div id="msgSubmit" class="h3 text-center hidden">Agregado!</div>
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
