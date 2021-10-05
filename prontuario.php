 <?php include "header.php"; ?>
  <script type="text/javascript" src="js/prontuario.js"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-binoculars fa-fw"></i> Prontuario</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg" data-toggle="modal" data-target="#nuevoResultadoProduccion"><i class="fa fa-plus"></i></button> Agregar Registro
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="nuevoResultadoProduccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-binoculars fa-fw"></i> Prontuario</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formulario">
                                            <div class="col-md-10">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Agregar Registro
                                                    </div>
                                                    <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12" id="formNueva">
                                                            <form id="unidades-agricolas" role="form">
                                                              <div class="row">
                                                                <div class="col-md-6">
                                                                  <div class="form-group">
                                                                      <?php
                                                                          $con = start_connect();
                                                                          if( $con )
                                                                          {
                                                                            $query = "SELECT id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre='0' ";
                                                                              $resultado = mysqli_query($con, $query);
                                                                      ?>
                                                                      <select id="finca" name="finca" class="form-control">
                                                                        <option value="NULL" disabled selected="true" >Finca</option>
                                                                        <?php
                                                                            while( $row = mysqli_fetch_array( $resultado ) )
                                                                                {
                                                                                  echo '<option value="'.$row['id_unidades_agricolas'].'">'.utf8_encode($row['nombre']).'</option>';
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
                                                                </div>
                                                                <div class="col-md-6">
                                                                  <div class="form-group"> 
                                                                      <select id="unidad_agricola" name="unidad_agricola" class="form-control">
                                                                        <option value="NULL" disabled selected="true" >Suerte</option>
                                                                      </select>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <div class="row">
                                                                <div class="col-md-6">
                                                                  <div class="form-group">
                                                                      <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                          <input id="fechaCosecha" name="fechaCosecha" class="form-control" size="16" type="text" value="" placeholder="Fecha de Cosecha">
                                                                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                      </div>
                                                                  </div>
                                                                </div>
                                                                <div class="col-md-6">                                                           
                                                                  <div class="form-group">
                                                                      <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                          <input id="fechaInicio" name="fechaInicio" class="form-control" size="16" type="text" value="" placeholder="Fecha Inicio">
                                                                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                      </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <div class="row">
                                                                <div class="col-md-6">
                                                                  <div class="form-group">
                                                                      <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                          <input id="fechaFin" name="fechaFin" class="form-control" size="16" type="text" value="" placeholder="Fecha Fin">
                                                                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                      </div>
                                                                  </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                  <div class="form-group">
                                                                      <input id="area" name="area" value="" class="form-control" placeholder="Area">
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              
                                                              
                                                              <div class="form-group">
                                                                    <textarea id="descripcion" name="descripcion"class="form-control" rows="3" placeholder="Descripci&oacute;n"></textarea>
                                                              </div>
                                                              <div class="row">
                                                                <div class="col-md-6">
                                                                  <div class="form-group">                                                                  
                                                                      <input id="codigoCorte" name="codigoCorte" class="form-control" placeholder="Corte #" >
                                                                  </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                  <div class="form-group">                                                                  
                                                                      <input id="variedad" name="variedad" class="form-control" placeholder="Variedad" >
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <div class="row">
                                                                <div class="col-md-6">
                                                                  <div class="form-group">
                                                                      <input id="edad" name="edad" value="" class="form-control" placeholder="Edad Corte">
                                                                  </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                  <div class="form-group">
                                                                      <input id="TCT" name="TCT" value="" class="form-control" placeholder="TCT">
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <div class="row">
                                                                <div class="col-md-6">
                                                                  <div class="form-group">
                                                                      <input id="TCH" name="TCH" value="" class="form-control" placeholder="TCH">
                                                                  </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                  <div class="form-group">
                                                                      <input id="TCHM" name="TCHM" value="" class="form-control" placeholder="TCHM">
                                                                  </div>
                                                                </div>
                                                              </div> 
                                                              <div class="form-group">
                                                                  <input id="rendimiento" name="rendimiento" value="" class="form-control" placeholder="Rendimiento">
                                                              </div>                                                              
                                                              <button type="button" onclick="nuevoResultadoProduccion()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
                                                              <div id="msgSubmit" class="h3 text-center hidden">Creado!</div>
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
                                <table class="table table-striped table-bordered table-hover " id="tabla_resultados">
                                    <thead>
                                        <tr>
                                            <th class="finca">Finca</th>
                                            <th class="suerte">Suerte</th>
                                            <th class="cosecha">Fecha Cosecha</th>
                                            <th class="inicio">Fecha Inicio</th>
                                            <th class="inicio">Fecha Fin</th>
                                            <th class="area">Area</th>
                                            <th class="corte">Corte #</th>
                                            <th class="variedad">Variedad</th>
                                            <th class="edad">Edad Corte</th>
                                            <th class="tct">TCT</th>
                                            <th class="tch">TCH</th>
                                            <th class="tchm">TCHM</th>
                                            <th class="rendimiento">RTO</th>
                                            <th class="">Observación</th>
                                            <th class="center borrar">Editar</th>
                                            <th class="center borrar">Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_produccion">
                                    <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = "SELECT * FROM qr_produccion WHERE fechaCosecha!='0000-00-00' ";
                                        $resultado = mysqli_query($con, $query);
                                        while( $row = mysqli_fetch_array( $resultado ) )
                                        {
                                        ?>
                                          <tr class="gradeX">
                                            <td><?php echo utf8_encode($row["nombre_finca"]) ?></td>
                                            <td><?php echo utf8_encode($row["nombre_unidad_agricola"]) ?></td>
                                            <td><?php echo $row["fechaCosecha"] ?></td>
                                            <td><?php echo $row["fechaInicio"] ?></td>
                                            <td><?php echo $row["fechaFin"] ?></td>
                                            <td><?php echo $row["area"] ?></td>                                            
                                            <td><?php echo $row["codigoCorte"] ?></td>
                                            <td><?php echo utf8_encode($row["variedad"]) ?></td>
                                            <td><?php echo $row["edad"] ?></td>
                                            <td><?php echo $row["TCT"] ?></td>
                                            <td><?php echo $row["TCH"] ?></td>
                                            <td><?php echo $row["TCHM"] ?></td>
                                            <td><?php echo $row["rendimiento"] ?></td>
                                            <td><?php echo utf8_encode($row["descripcion"]) ?></td>
                                            <?php echo '<td>
                                                <a onclick="editarResultadoProduccion(\''. $row["idProduccion"] .'\',\''. $row["finca"] .'\',\''. $row["idUnidadAgricola"] .'\',\''. utf8_encode($row["nombre_finca"]) .'\',\''. utf8_encode($row["nombre_unidad_agricola"]) .'\',\''. $row["fechaCosecha"] .'\',\''. $row["fechaInicio"] .'\',\''. $row["fechaFin"] .'\',\''. $row["area"] .'\',\''. utf8_encode(eregi_replace("[\n|\r|\n\r]", ' ',$row["descripcion"])) .'\',\''. $row["codigoCorte"] .'\',\''. utf8_encode($row["variedad"]) .'\',\''.$row["edad"] .'\',\''.$row["TCT"] .'\',\''.$row["TCH"] .'\',\''.$row["TCHM"] .'\',\''. $row["rendimiento"] .'\')"
                                                  aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                              </td>
                                              <td>
                                                <a href="javascript:borrarResultadoProduccion(\''. $row["idProduccion"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
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
            <div class="modal fade" id="editResultadoProduccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-binoculars fa-fw"></i> Prontuario</h4>
                        </div>
                        <div class="modal-body">
                                <div class="row row2 between" id="formulario">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Editar Registro
                                            </div>
                                            <div class="panel-body">
                                                <form id="unidades-agricolas" role="form">
                                                  <input type="hidden" id="edit_id" name="id" >
                                                      <div class="row">
                                                        <div class="col-md-12">
                                                          <div class="form-group">
                                                              <?php
                                                                  $con = start_connect();
                                                                  if( $con )
                                                                  {
                                                                    $query = "SELECT id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre IS NULL";
                                                                    $resultado = mysqli_query($con, $query);
                                                              ?>
                                                              <label for="finca">Finca</label>
                                                              <select id="edit_finca" name="finca" class="form-control">
                                                                <option value="NULL" disabled selected="true" >Finca</option>
                                                                <?php
                                                                    while( $row = mysqli_fetch_array( $resultado ) )
                                                                        {
                                                                          echo '<option value="'.$row['id_unidades_agricolas'].'">'.utf8_encode($row['nombre']).'</option>';
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
                                                        </div>
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                              <label for="edit_unidad_agricola">Suerte</label><select id="edit_unidad_agricola" name="unidad_agricola" class="form-control">
                                                                <option value="NULL" disabled selected="true" >Suerte</option>
                                                              </select>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="row">
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                              <label for="fechaCosecha">Fecha Cosecha</label>
                                                              <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                  <input id="edit_fechaCosecha" name="fechaCosecha" class="form-control" size="16" type="text" value="" placeholder="Fecha Cosecha">
                                                                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                              </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">                                                           
                                                          <div class="form-group">
                                                              <label for="fechaInicio">Fecha Inicio</label>
                                                              <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                  <input id="edit_fechaInicio" name="fechaInicio" class="form-control" size="16" type="text" value="" placeholder="Fecha Inicio">
                                                                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                              </div>
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="row">
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                              <label for="fechaFin">Fecha Fin</label>
                                                              <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                  <input id="edit_fechaFin" name="fechaFin" class="form-control" size="16" type="text" value="" placeholder="Fecha Fin">
                                                                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                              </div>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                          <label for="area">Area</label>
                                                              <input id="edit_area" name="area" value="" class="form-control" placeholder="Ingrese el Area">
                                                          </div>
                                                        </div>
                                                      </div>                                                     
                                                      <div class="form-group">
                                                      <label for="edit_descripcion">Descripci&oacute;n</label>
                                                        <textarea id="edit_descripcion" name="descripcion"class="form-control" rows="3" placeholder="Descripci&oacute;n"></textarea>
                                                      </div>
                                                      <div class="row">
                                                        <div class="col-md-6">
                                                          <div class="form-group"> 
                                                              <label for="corte">Corte #</label>
                                                              <input id="edit_codigoCorte" name="codigoCorte" class="form-control" placeholder="Corte #" >
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <div class="form-group">    
                                                              <label for="variedad">Variedad</label>                                                              
                                                              <input id="edit_variedad" name="variedad" class="form-control" placeholder="Variedad" >
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="row">
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                              <label for="edad">Edad Corte</label>
                                                              <input id="edit_edad" name="edad" value="" class="form-control" placeholder="Edad Corte">
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                              <label for="tct">TCT</label>
                                                              <input id="edit_TCT" name="TCT" value="" class="form-control" placeholder="TCT">
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="row">
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                              <label for="tch">TCH</label>
                                                              <input id="edit_TCH" name="TCH" value="" class="form-control" placeholder="TCH">
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                              <label for="tchm">TCHM</label>
                                                              <input id="edit_TCHM" name="TCHM" value="" class="form-control" placeholder="TCHM">
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <label for="rendimiento">Rendimiento</label>
                                                          <input id="edit_rendimiento" name="rendimiento" value="" class="form-control" placeholder="Rendimiento">
                                                      </div>
                                                      <button type="button" onclick="guardarEdicion()" id="form-submit" class="btn btn-default pull-right ">Actualizar</button>
                                                    <div id="msgSubmit" class="h3 text-center hidden">Actualizado!</div>
                                                </form>

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
