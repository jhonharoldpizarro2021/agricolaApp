<?php include "header.php"; ?>
  <script type="text/javascript" src="js/registro_pluviometria.js?n=<?= time() ?>"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-tint fa-fw"></i> Registro de Pluviometr&iacute;a</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- Modal Nueva Medida-->
            <div class="modal fade" id="nuevoRegistroPluviometria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-tint fa-fw"></i> Registro de Pluviometr&iacute;a</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formularioTiempo">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Agregar Estaci&oacute; Pluviometr&iacute;a
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
                                                        <div class="form-group">
                                                            <select id="estaciones" name="estaciones" class="form-control">
                                                              <option value="NULL" disabled selected="true" >Seleccionar Estaci&oacute;n</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fecha">Fecha:</label>
                                                            <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                <input id="fecha" name="fecha" class="form-control" size="16" type="text" value="" placeholder="Fecha Inicio">
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                            </div>                                                                        
                                                        </div>
                                                        <div class="form-group">
                                                            <input id="medicion" name="medicion" value="" class="form-control" placeholder="Valor Medici&oacute;n">                                                                         
                                                        </div>                                                                 
                                                        <button type="button" onclick="nuevoRegistroPluviometria()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
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
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg nuevoRegistroPluviometria" data-toggle="modal" data-target="#nuevoRegistroPluviometria"><i class="fa fa-plus"></i></button> Agregar Pluviometr&iacute;a  
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover " id="tabla_pluviometria">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Vr.Medici&oacute;n</th>
                                            <th>Estaci&oacute;n Pluviometr&iacute;a</th>
                                            <th>Finca</th>                                            
                                            <th class="editar center">Editar</th>
                                            <th class="borrar center">Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_pluviometria">
                                    <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = " SELECT * FROM qr_movimiento_pluviometria ";
                                        $resultado = mysqli_query($con, $query);
                                        while( $row = mysqli_fetch_array($resultado) )
                                        {
                                        ?>
                                          <tr>
                                            <td><?php echo $row["fecha"] ?></td>
                                            <td><?php echo $row["valor_medicion"] ?></td>
                                            <td><?php echo utf8_encode($row["descripcion"]) ?></td>
                                            <td><?php echo utf8_encode($row["unidad_agricola"]) ?></td>
                                            <?php echo '<td class="center">
                                              <a onclick="editarRegistroPluviometria(\''. $row["id_movimiento_pluviometria"] .'\',\''. $row["fecha"] .'\',\''. $row["valor_medicion"] .'\',\''. $row["idUnidadAgricola"] .'\',\''. $row["estaciones_pluviometria_id_estaciones_pluviometria"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                            </td>
                                            <td class="center">
                                              <a href="javascript:borrarRegistroPluviometria(\''. $row["id_movimiento_pluviometria"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
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
            <div class="modal fade" id="editRegistroPluviometria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-tint fa-fw"></i> Registro de Pluviometr&iacute;a</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formularioTiempo">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Editar Estaci&oacute;n Pluviometr&iacute;a
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form role="form" id="tiempo">
                                                        <input type="hidden" id="edit_id" name="edit_id" >
                                                         <div class="form-group">
                                                            <select id="edit_finca" name="edit_finca" class="form-control" readonly>
                                                              <option value="" selected="true" ></option>
                                                            </select>
                                                          </div>
                                                          <div class="form-group">
                                                            <select id="edit_estaciones" name="edit_estaciones" class="form-control" readonly>
                                                              <option value="" selected="true" ></option>
                                                            </select>
                                                         </div>
                                                        <div class="form-group">
                                                            <label for="edit_fecha">Fecha:</label>
                                                            <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                <input id="edit_fecha" name="edit_fecha" class="form-control" size="16" type="text" value="">
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <input id="edit_medicion" name="edit_medicion" value="" class="form-control" >
                                                             
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
