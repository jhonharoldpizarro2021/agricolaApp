<?php include "header.php"; ?>
  <script type="text/javascript" src="js/planificacion-cosechas.js"></script>
  
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg" data-toggle="modal" data-target="#nuevoCorte"><i class="fa fa-plus"></i></button> Agregar Corte
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="nuevoCorte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="width: 700px!important;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formulario">
                                            <div class="col">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Agregar Corte
                                                    </div>
                                                    <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12" id="formNuevoEmpleado">
                                                            <form role="form">
                                                              <div class="row">
                                                                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                                                                  <div class="form-group">
                                                                        <?php
                                                                            $con = start_connect();
                                                                            if( $con )
                                                                            {
                                                                              $query = "SELECT id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre='0' ";
                                                                              $resultado = mysqli_query($con, $query);
                                                                        ?>
                                                                        <label for="finca">Finca:</label>
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
                                                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                                                  <div class="form-group">
                                                                    <label for="unidad_agricola">Suerte:</label>
                                                                    <select id="unidad_agricola" name="unidad_agricola" class="form-control">
                                                                      <option value="NULL" disabled selected="true" >Suerte</option>
                                                                    </select>
                                                                  </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                                                                  <div class="form-group">
                                                                      <label for="corte">Corte #:</label>
                                                                      <input id="corte"  name="corte" class="form-control corte" placeholder="Corte #" maxlength="30" autocomplete="off" >
                                                                      <!-- <p class="help-block">Example block-level help text here.</p> -->
                                                                  </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                	<button type="button" onclick="buscar()" id="form-submit" class="btn btn-default pull-right buscar">Crear</button>
                                                                </div>
                                                              </div>                                                             
                                                              <div id="resultadoBusqueda">
                                                              </div>
                                                              <div class="row" id="complemento">
                                                                <div class="col-md-12">
                                                                  <div class="form-group">
                                                                    <?php
                                                                      $con = start_connect();
                                                                      if( $con )
                                                                      {
                                                                        $query = "SELECT id_labores,descripcion_corta FROM  qr_labores";
                                                                        $resultado = mysqli_query($con, $query);
                                                                    ?>
                                                                    <label for="labor">Labor:</label>
                                                                    <select id="labor" name="labor" class="form-control">
                                                                      <option value="NULL" disabled selected="true" >Agregar Labor</option>
                                                                      <?php
                                                                          while( $row = mysqli_fetch_array( $resultado ) )
                                                                              {
                                                                                echo '<option value="'.$row['id_labores'].'">'.utf8_encode($row['descripcion_corta']).'</option>';
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
                                                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                                                  <div class="form-group">
                                                                    <label for="fecha_inicio">Fecha de Inicio:</label>
                                                                    <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                        <input id="fecha_inicio" name="fecha_inicio" class="form-control" size="16" type="text" value="" placeholder="Fecha Inicio">
                                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                                                  <div class="form-group">
                                                                    <label for="fecha_fin">Fecha Fin:</label>
                                                                    <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                        <input id="fecha_fin" name="fecha_fin" class="form-control" size="16" type="text" value="" placeholder="Fecha Fin">
                                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                <button type="button" onclick="nuevoCorte()" id="form-submit" class="btn btn-default pull-right ">Agregar Labor</button>
                                                                </div>
                                                                <div id="msgSubmit" class="h3 text-center hidden">Creada!</div>
                                                              </div>
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
                                <table class="table table-striped table-bordered table-hover " id="tabla_planificacion">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="finca"> Finca</th>
                                            <th rowspan="2" class="suerte"> Suerte</th>
                                            <th rowspan="2" class="corte"> Corte #</th>
                                            <th rowspan="2" class="inicio"> Fecha Inicio</th>
                                            <th rowspan="2" class="area"> &Aacute;rea</th>
                                            <th rowspan="2" class="variedad"> Variedad</th>
                                            <th rowspan="2" class="bservacion"> Observaci&oacute;n</th>
                                            <th rowspan="2" class="borrar"> Editar</th>
                                            <th colspan="2" class="labores"> Labores</th>
                                            <th rowspan="2" class="fin"> Finalizar Cosecha</th>
                                        </tr>
                                        <tr>
                                            <th class="editar ver">Ver</th>
                                            <th class="editar agregar">Agregar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_planificacion">
                                     <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = " SELECT * FROM qr_produccion WHERE fechaCosecha = '0000-00-00' ";
                                        $resultado = mysqli_query($con, $query);

                                        while( $row = mysqli_fetch_array( $resultado ) )
                                        {
                                        ?>
                                          <tr class="gradeX">
                                            <td><?php echo utf8_encode($row["nombre_finca"])?></td>
                                            <td><?php echo utf8_encode($row["nombre_unidad_agricola"]) ?></td>
                                            <td><?php echo $row["codigoCorte"] ?></td>
                                            <td><?php echo $row["fechaInicio"] ?></td>
                                            <td><?php echo $row["area"] ?> has</td>
                                            <td><?php echo $row["variedad"] ?></td>
                                            <td><?php echo utf8_encode($row["descripcion"]) ?></td>
                                            <td><?php echo 
                                                '<center><a onclick="editarCorte(\''. $row["idProduccion"] .'\',\''. $row["finca"] .'\',\''. $row["idUnidadAgricola"] .'\',\''. utf8_encode($row["nombre_finca"]) .'\',\''. utf8_encode($row["nombre_unidad_agricola"]) .'\',\''. $row["fechaCosecha"] .'\',\''. $row["fechaInicio"] .'\',\''. $row["fechaFin"] .'\',\''. $row["area"] .'\',\''. utf8_encode(eregi_replace("[\n|\r|\n\r]", ' ',$row["descripcion"])) .'\',\''. $row["codigoCorte"] .'\',\''. utf8_encode($row["variedad"]) .'\',\''.$row["edad"] .'\',\''.$row["TCT"] .'\',\''.$row["TCH"] .'\',\''.$row["TCHM"] .'\',\''. $row["rendimiento"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></center>' ?>
                                            </td>
											                      <td class="center"><?php echo '
                                                <center><a onclick="seguimientoLabores(\''. $row["idProduccion"] .'\',\''. $row["finca"] .'\',\''. $row["idUnidadAgricola"] .'\',\''. $row["codigoCorte"] .'\',\''. utf8_encode($row["nombre_unidad_agricola"]) .'\',\''. utf8_encode($row["nombre_finca"]) .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a></center> ' ?>
                                            </td>
                                            <td class="center"><?php echo '
                                                <center><a onclick="nuevaLaborSeguimiento(\''. $row["idProduccion"] .'\',\''. $row["finca"] .'\',\''. $row["idUnidadAgricola"] .'\',\''. $row["codigoCorte"] .'\',\''. utf8_encode($row["nombre_unidad_agricola"]) .'\',\''. utf8_encode($row["nombre_finca"]) .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-plus"></i></button></a></center>' ?>
                                            </td>
                                            <td class="center"><?php echo '
                                                <center><a onclick="finalizarCosecha(\''. $row["idProduccion"] .'\',\''. $row["finca"] .'\',\''. $row["idUnidadAgricola"] .'\',\''. utf8_encode($row["nombre_finca"]) .'\',\''. utf8_encode($row["nombre_unidad_agricola"]) .'\',\''. $row["fechaCosecha"] .'\',\''. $row["fechaInicio"] .'\',\''. $row["fechaFin"] .'\',\''. $row["area"] .'\',\''. utf8_encode(eregi_replace("[\n|\r|\n\r]", ' ',$row["descripcion"])) .'\',\''. $row["codigoCorte"] .'\',\''. utf8_encode($row["variedad"]) .'\',\''.$row["edad"] .'\',\''.$row["TCT"] .'\',\''.$row["TCH"] .'\',\''.$row["TCHM"] .'\',\''. $row["rendimiento"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-unlock-alt"></i></button></a></center>' ?>
                                            </td>
                                          </tr>
                                        <?php
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

<!-- MODALES  -->
            <!-- Modal nuevaLaborSeguimiento -->
            <div class="modal fade" id="nuevaLaborSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                         <div class="panel-heading">
                                            Agregar Labor al Corte # <strong><em><i id="numero_corte">#</i> <i id="nombre_suerte">S</i> <i></i> <i id="nombre_finca">F</i></em></strong>
                                        </div>
                                        <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12" id="">
                                                <form role="form">
                                                    <div class="row" style="display:none;">
                                                      <div class="col-md-6">
                                                        <div class="form-group" >
                                                          <input type="hidden" id="id" name="id" >
                                                          <input type="hidden" id="labor_finca" name="labor_finca" >
                                                        </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                              <?php
                                                                  $con = start_connect();
                                                                  if( $con )
                                                                  {
                                                                    $query = "SELECT id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre IS NOT NULL";
                                                                    $resultado = mysqli_query($con, $query);
                                                              ?>
                                                              <select id="labor_suerte"  disabled name="suerte" class="form-control" >
                                                                <option value="NULL"  selected="true" >Suerte</option>
                                                                <?php
                                                                    while( $row = mysqli_fetch_array( $resultado ) )
                                                                        {
                                                                          echo '<option  value="'.$row['id_unidades_agricolas'].'">'.utf8_encode($row['nombre']).'</option>';
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
                                                    </div>
                                                    <div class="row" style="display:none;">
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input  type="hidden" id="labor_corte"  name="corte" class="form-control " placeholder="Corte #" maxlength="30" disabled>
                                                        </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="hidden"  id="labor_area"  name="area" class="form-control " placeholder="Area" autocomplete="off" disabled >
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row" style="display:none;">
                                                      <div class="col-md-6">
                                                        <div class="form-group">

                                                                <textarea id="labor_descripcion" name="descripcion" class="form-control" rows="3" placeholder="Descripcion" disabled></textarea>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="variedad">Variedad</label>
                                                                <input id="labor_variedad"  name="variedad" class="form-control " placeholder="Variedad" disabled>
                                                            </div>
                                                      </div>
                                                    </div>
                                                    <div class="form-group">
                                                          <?php
                                                              $con = start_connect();
                                                              if( $con )
                                                              {
                                                                $query = "SELECT id_labores,descripcion_corta FROM  qr_labores";
                                                                $resultado = mysqli_query($con, $query);
                                                          ?>
                                                          <label for="variedad">Agregar Labor</label>
                                                          <select id="labor2" name="labor2" class="form-control">
                                                            <option value="NULL" disabled selected="true" >Seleccionar Labor </option>
                                                            <?php
                                                                while( $row = mysqli_fetch_array( $resultado ) )
                                                                    {
                                                                      echo '<option value="'.$row['id_labores'].'">'.utf8_encode($row['descripcion_corta']).'</option>';
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
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                          <div class="form-group">
                                                                <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                    <input id="inicio_labor" name="inicio_labor" class="form-control" size="16" type="text" value="" placeholder="Fecha Inicio">
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                                <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                    <input id="fin_labor" name="fin_labor" class="form-control" size="16" type="text" value="" placeholder="Fecha Fin">
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                </div>
                                                            </div>
                                                      </div>
                                                    </div>
                                                    <button type="button" onclick="guardarNuevaLaborSeguimiento()" id="form-submit" class="btn btn-default pull-right ">Agregar Labor</button>
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
            <!-- Modal Ver Labores del Corte-->
            <div class="modal fade" id="seguimientoLabores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row" id="formulario">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Labores del Corte: <strong><em> <i id="corte_sg">#</i> <i id="suerte_sg">Suerte</i><i style="display: none;" id="idSuerte_sg">ID Suerte</i> <i></i> <i id="finca_sg">Finca</i><i style="display: none;" id="idFinca_sg">ID Suerte</i><i style="display: none;" id="idProduccion_sg">ID Produccion</i></em></strong><!--  id= <i id="id_sg"></i> -->
                                        </div>
                                        <!-- /.panel-heading -->
                                      <div class="panel-body">
                                          <div class="dataTable_wrapper table-responsive">
                                              <table class="table table-striped table-bordered table-hover " id="tabla_seguimientoLabores">
                                                  <thead>
                                                      <tr>
                                                          <th rowspan="2">Labor</th>
                                                          <th rowspan="2">Fecha Inicio</th>
                                                          <th rowspan="2">Fecha Fin</th>
                                                          <th rowspan="2">Editar</th>
                                                          <th rowspan="2">Borrar</th>
                                                          <th colspan="2" class="maquinaria">Maquinaria</th>
                                                          <th colspan="2" class="insumos">Insumos</th>
                                                          <th colspan="2" class="costos">Costos Directos</th>
                                                          <th colspan="2" class="novedades">Novedades</th>
                                                      </tr>
                                                      <tr>
                                                          <th>Ver</th>
                                                          <th>Agregar</th>
                                                          <th>Ver</th>
                                                          <th>Agregar</th>
                                                          <th>Ver</th>
                                                          <th>Agregar</th>
                                                          <th>Ver</th>
                                                          <th>Agregar</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="body_personal">
                                                        <tr class="gradeX">
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                        </tr>
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
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- Modal editarLaborSeguimiento -->
            <div class="modal fade" id="editarLaborSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                         <div class="panel-heading">
                                            Editar Labor <i id="edit_nombre_labor">L</i> del Corte # <i id="edit_numero_corte">C</i> <i id="edit_nombre_suerte">S</i>  <i id="edit_nombre_finca">F</i></em></strong>
                                        </div>
                                        <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12" id="">
                                                <form role="form">
                                                    <div class="row" style="display:none;">
                                                      <div class="col-md-6">
                                                        <div class="form-group" >
                                                          <input type="hidden" id="edit_id" name="idSeguimiento" >
                                                          <input type="hidden" id="edit_produccion" name="idProduccion" >
                                                          <input type="hidden" id="edit_labor_finca" name="edit_labor_finca">
                                                          <input type="hidden" id="edit_labor_suerte" name="edit_labor_suerte">
                                                        </div>
                                                      </div>

                                                    </div>
                                                    <div class="row" style="display:none;">
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input  type="hidden" id="edit_labor_corte"  name="corte" class="form-control " placeholder="Corte #" maxlength="30" disabled>
                                                        </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="hidden"  id="edit_labor_area"  name="area" class="form-control " placeholder="Area" autocomplete="off" disabled >
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="row" style="display:none;">
                                                      <div class="col-md-6">
                                                        <div class="form-group">

                                                                <textarea id="edit_labor_descripcion" name="descripcion" class="form-control" rows="3" placeholder="Descripcion" disabled></textarea>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="variedad">Variedad</label>
                                                                <input id="edit_labor_variedad"  name="variedad" class="form-control " placeholder="Variedad" disabled>
                                                            </div>
                                                      </div>
                                                    </div>
                                                    <div class="form-group">
                                                          <?php
                                                              $con = start_connect();
                                                              if( $con )
                                                              {
                                                                $query = "SELECT id_labores,descripcion_corta FROM  qr_labores";
                                                                $resultado = mysqli_query($con, $query);
                                                          ?>
                                                          <label for="variedad">Agregar Labor</label>
                                                          <select id="edit_labor2" name="labor2" class="form-control">
                                                            <option value="NULL" disabled selected="true" >Seleccionar Labor </option>
                                                            <?php
                                                                while( $row = mysqli_fetch_array( $resultado ) )
                                                                    {
                                                                      echo '<option value="'.$row['id_labores'].'">'.$row['descripcion_corta'].'</option>';
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
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                          <div class="form-group">
                                                                <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                    <input id="edit_inicio_labor" name="inicio_labor" class="form-control" size="16" type="text" value="" placeholder="Fecha Inicio">
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                </div>
                                                            </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                        <div class="form-group">
                                                                <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                    <input id="edit_fin_labor" name="fin_labor" class="form-control" size="16" type="text" value="" placeholder="Fecha Fin">
                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                </div>
                                                            </div>
                                                      </div>
                                                    </div>
                                                    <button type="button" onclick="guardarEdicionLabor()" id="form-submit" class="btn btn-default pull-right ">Actualizar</button>
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

            <!-- Modal nuevaMaquinaSeguimiento -->
            <div class="modal fade" id="nuevaMaquinaSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                         <div class="panel-heading">
                                            Agregar Maquina/Herramienta a la <strong><em>Labor <i id="m_labor">L</i> del Corte # <i id="m_corte">C</i> <i id="m_suerte">S</i>  <i id="m_finca">F</i></em></strong>
                                        </div>
                                        <div class="panel-body">
                                          <div class="row">
                                              <div class="col-lg-12" id="">
                                                  <form role="form">
                                                      <div class="row" style="display:none;">
                                                        <div class="col-md-6">
                                                          <div class="form-group" >
                                                            <input type="hidden" id="seguimientoM" name="seguimientoM" >
                                                            <?php
                                                                $con = start_connect();
                                                                if( $con )
                                                                {
                                                                  $query = "SELECT  id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre IS NULL";
                                                                  $resultado = mysqli_query($con, $query);
                                                            ?>
                                                            <select id="maquina_finca"  disabled name="finca" class="form-control">
                                                              <option value="NULL"  selected="true" >Maquina/Herramienta</option>
                                                              <?php
                                                                  while( $row = mysqli_fetch_array( $resultado ) )
                                                                      {
                                                                        echo '<option  value="'.$row['  id_unidades_agricolas'].'">'.$row['nombre'].'</option>';
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
                                                                <?php
                                                                    $con = start_connect();
                                                                    if( $con )
                                                                    {
                                                                      $query = "SELECT id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre IS NOT NULL";
                                                                      $resultado = mysqli_query($con, $query);
                                                                ?>
                                                                <select id="maquina_suerte"  disabled name="suerte" class="form-control" >
                                                                  <option value="NULL"  selected="true" >Suerte</option>
                                                                  <?php
                                                                      while( $row = mysqli_fetch_array( $resultado ) )
                                                                          {
                                                                            echo '<option  value="'.$row['id_unidades_agricolas'].'">'.$row['nombre'].'</option>';
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
                                                      </div>
                                                      <div class="row" style="display:none;">
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                              <input  type="hidden" id="maquina_corte"  name="corte" class="form-control " placeholder="Corte #" maxlength="30" disabled>
                                                          </div>
                                                          <div class="form-group">
                                                              <input  type="hidden" id="laborM"  name="laborM" class="form-control " placeholder="Corte #" maxlength="30" disabled>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select id="tipo"  disabled name="tipo" class="form-control">
                                                              <option value="1"  selected="true" >Maquina/Herramienta</option>
                                                            </select>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <?php
                                                              $con = start_connect();
                                                              if( $con )
                                                              {
                                                                $query = "SELECT id_maquinas_herramientas,nombre FROM maquinas_herramientas";
                                                                $resultado = mysqli_query($con, $query);
                                                          ?>
                                                          <label for="variedad">Agregar Maquina/Herramienta</label>
                                                          <select id="maquinaHerramienta" name="maquinaHerramienta" class="form-control">
                                                            <option value="NULL" disabled selected="true" >Seleccionar Maquina/Herramienta</option>
                                                            <?php
                                                                while( $row = mysqli_fetch_array( $resultado ) )
                                                                    {
                                                                      echo '<option value="'.$row['id_maquinas_herramientas'].'">'.$row['nombre'].'</option>';
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
                                                        <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                            <input id="fecha" name="fecha" class="form-control" size="16" type="text" value="" placeholder="Fecha">
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <textarea id="comentario" name="comentario" class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                      </div>
                                                      <button type="button" onclick="guardarNuevaMaquinaSeguimiento()" id="form-submit" class="btn btn-default pull-right ">Agregar Maquina</button>
                                                      <div id="msgSubmit" class="h3 text-center hidden">Agregada!</div>
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
            <!-- Modal Ver Maquinaria de la Labor-->
            <div class="modal fade" id="maquinaSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Maquinaria signada a la <strong><em>Labor <i id="vm_labor">L</i> del Corte #<i id="vm_corte">C</i> <i id="vm_suerte">S</i>  <i id="vm_finca">F</i></em></strong><!--  id= <i id="id_sg"></i> -->
                                        </div>
                                        <!-- /.panel-heading -->
                                      <div class="panel-body">
                                          <div class="dataTable_wrapper table-responsive">
                                              <table class="table table-striped table-bordered table-hover" id="tabla_maquinaHerramientaLabor">
                                                  <thead>
                                                      <tr>
                                                          <th>Maquina</th>
                                                          <th>Comentario</th>
                                                          <th>Fecha</th>
                                                          <th>Editar</th>
                                                          <th>Borrar</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="body_insumos_seguimiento">

                                                        <tr>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                        </tr>

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
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- Modal editarMaquinaSeguimiento -->
            <div class="modal fade" id="editarMaquinaSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                         <div class="panel-heading">
                                            Editar Maquina/Herramienta de la <strong><em>Labor <i id="edit_m_labor">L</i> del Corte # <i id="edit_m_corte">C</i> <i id="edit_m_suerte">S</i>  <i id="edit_m_finca">F</i></em></strong>
                                        </div>
                                        <div class="panel-body">
                                          <div class="row">
                                              <div class="col-lg-12" id="">
                                                  <form role="form">
                                                      <div class="row" style="display:none;">
                                                        <div class="col-md-6">
                                                          <div class="form-group" >
                                                            <input type="hidden" id="edit_idDetalle" name="edit_idDetalle" >
                                                            <input type="hidden" id="edit_tipo"  name="edit_tipo" >
                                                            <input type="hidden" id="edit_maquinaHerramienta"  name="edit_maquinaHerramienta" >
                                                            <input type="hidden" id="edit_seguimientoM" name="edit_seguimientoM" >
                                                            <input type="hidden" id="edit_laborM"  name="edit_laborM" >
                                                            <input type="hidden" id="edit_maquina_finca" name="edit_maquina_finca" >
                                                            <input type="hidden" id="edit_maquina_suerte" name="edit_maquina_suerte" >
                                                            <input type="hidden" id="edit_maquina_corte"  name="edit_maquina_corte">
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="edit_fecha">Fecha:</label>
                                                        <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                            <input id="edit_fecha" name="edit_fecha" class="form-control" type="text">
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <label for="edit_comentario">Comentario:</label>
                                                          <textarea id="edit_comentario" name="edit_comentario" class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                      </div>
                                                      <button type="button" onclick="guardarEdicionMaquinaSeguimiento()" id="form-submit" class="btn btn-default pull-right ">Editar Maquina</button>
                                                      <div id="msgSubmit" class="h3 text-center hidden">Editada!</div>
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

            <!-- Modal nuevoInsumoSeguimiento -->
            <div class="modal fade" id="nuevoInsumoSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                         <div class="panel-heading">
                                            Agregar Insumo a la <strong><em>Labor <i id="i_labor">L</i> del Corte #<i id="i_corte">C</i> <i id="i_suerte">S</i>  <i id="i_finca">F</i></em></strong>
                                        </div>
                                        <div class="panel-body">
                                          <div class="row">
                                              <div class="col-lg-12" id="">
                                                  <form role="form">
                                                      <div class="row" style="display:none;">
                                                        <div class="col-md-6">
                                                          <div class="form-group" >
                                                            <input type="hidden" id="seguimientoI" name="seguimientoI" >
                                                            <?php
                                                                $con = start_connect();
                                                                if( $con )
                                                                {
                                                                  $query = "SELECT  id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre IS NULL";
                                                                  $resultado = mysqli_query($con, $query);
                                                            ?>
                                                            <select id="maquina_finca"  disabled name="finca" class="form-control">
                                                              <option value="NULL"  selected="true" >Maquina/Herramienta</option>
                                                              <?php
                                                                  while( $row = mysqli_fetch_array( $resultado ) )
                                                                      {
                                                                        echo '<option  value="'.$row['  id_unidades_agricolas'].'">'.$row['nombre'].'</option>';
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
                                                                <?php
                                                                    $con = start_connect();
                                                                    if( $con )
                                                                    {
                                                                      $query = "SELECT id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre IS NOT NULL";
                                                                      $resultado = mysqli_query($con, $query);
                                                                ?>
                                                                <select id="maquina_suerte"  disabled name="suerte" class="form-control" >
                                                                  <option value="NULL"  selected="true" >Suerte</option>
                                                                  <?php
                                                                      while( $row = mysqli_fetch_array( $resultado ) )
                                                                          {
                                                                            echo '<option  value="'.$row['id_unidades_agricolas'].'">'.$row['nombre'].'</option>';
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
                                                      </div>
                                                      <div class="row" style="display:none;">
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                              <input  type="hidden" id="maquina_corte"  name="corte" class="form-control " placeholder="Corte #" maxlength="30" disabled>
                                                          </div>
                                                          <div class="form-group">
                                                              <input  type="hidden" id="laborI"  name="laborI" class="form-control " placeholder="Corte #" maxlength="30" disabled>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select id="tipoI"  disabled name="tipoI" class="form-control">
                                                              <option value="2"  selected="true" >Insumo</option>
                                                            </select>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                        <!-- <input type="hidden" id="labor" name="labor" > -->
                                                          <?php
                                                              $con = start_connect();
                                                              if( $con )
                                                              {
                                                                $query = "SELECT id_insumos,descripcion FROM insumos";
                                                                $resultado = mysqli_query($con, $query);
                                                          ?>
                                                          <label for="variedad">Agregar Insumo</label>
                                                          <select id="insumo" name="insumo" class="form-control">
                                                            <option value="NULL" disabled selected="true" >Seleccionar Insumo</option>
                                                            <?php
                                                                while( $row = mysqli_fetch_array( $resultado ) )
                                                                    {
                                                                      echo '<option value="'.$row['id_insumos'].'">'.utf8_encode($row['descripcion']).'</option>';
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
                                                      <div class="form-group" >
                                                        <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                          <input id="fechaI" name="fechaI" class="form-control" size="16" type="text" value="" placeholder="Fecha">
                                                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <textarea id="comentarioI" name="comentarioI" class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                      </div>
                                                      <button type="button" onclick="guardarNuevoInsumoSeguimiento()" id="form-submit" class="btn btn-default pull-right ">Agregar Insumo</button>
                                                      <div id="msgSubmit" class="h3 text-center hidden">Agregada!</div>
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
            <!-- Modal Ver Insumo de la Labor-->
            <div class="modal fade" id="insumoSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Insumos signados a la <strong><em>Labor <i id="vm_labor_i">L</i> del Corte #<i id="vm_corte_i">C</i> <i id="vm_suerte_i">S</i>  <i id="vm_finca_i">F</i></em></strong><!--  id= <i id="id_sg"></i> -->
                                        </div>
                                        <!-- /.panel-heading -->
                                      <div class="panel-body">
                                          <div class="dataTable_wrapper table-responsive">
                                              <table class="table table-striped table-bordered table-hover" id="tabla_insumoLabor">
                                                  <thead>
                                                      <tr>
                                                          <th>Insumo</th>
                                                          <th>Comentario</th>
                                                          <th>Fecha</th>
                                                          <th>Editar</th>
                                                          <th>Borrar</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="body_insumos_seguimiento">

                                                        <tr class="gradeX">
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                        </tr>

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
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- Modal editarInsumoSeguimiento -->
            <div class="modal fade" id="editarInsumoSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                         <div class="panel-heading">
                                            Editar Insumo a la <strong><em>Labor <i id="edit_i_labor">L</i> del Corte #<i id="edit_i_corte">C</i> <i id="edit_i_suerte">S</i>  <i id="edit_i_finca">F</i></em></strong>
                                        </div>
                                        <div class="panel-body">
                                          <div class="row">
                                              <div class="col-lg-12" id="">
                                                  <form role="form">
                                                      <div class="row" style="display:none;">
                                                        <div class="col-md-6">
                                                          <div class="form-group" >
                                                            <input type="hidden" id="edit_idDetalleI" name="edit_idDetalleI" >
                                                            <input type="hidden" id="edit_tipoI"  name="edit_tipoI" >
                                                            <input type="hidden" id="edit_insumo"  name="edit_insumo" >
                                                            <input type="hidden" id="edit_seguimientoI" name="edit_seguimientoI" >
                                                            <input type="hidden" id="edit_laborI"  name="edit_laborI" >
                                                            <input type="hidden" id="edit_maquina_fincaI" name="edit_maquina_fincaI" >
                                                            <input type="hidden" id="edit_maquina_suerteI" name="edit_maquina_suerteI" >
                                                            <input type="hidden" id="edit_maquina_corteI"  name="edit_maquina_corteI">
                                                          </div>
                                                        </div>
                                                      </div>
                                                      <div class="form-group" >
                                                        <label for="edit_fechaI">Fecha:</label>
                                                        <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                          <input id="edit_fechaI" name="edit_fechaI" class="form-control" size="16" type="text"  >
                                                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <label for="edit_comentarioI">Comentario:</label>
                                                          <textarea id="edit_comentarioI" name="edit_comentarioI" class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                      </div>
                                                      <button type="button" onclick="guardarEdicionInsumoSeguimiento()" id="form-submit" class="btn btn-default pull-right ">Editar Insumo</button>
                                                      <div id="msgSubmit" class="h3 text-center hidden">Editado!</div>
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

            <!-- Modal nuevoGastoSeguimiento -->
            <div class="modal fade" id="nuevoGastoSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                         <div class="panel-heading">
                                            Agregar Gasto a la <strong><em>Labor <i id="g_labor">L</i> del Corte #<i id="g_corte">C</i> <i id="g_suerte">S</i>  <i id="g_finca">F</i></em></strong>
                                        </div>
                                        <div class="panel-body">
                                          <div class="row">
                                              <div class="col-lg-12" id="">
                                                  <form role="form">
                                                      <div class="row" style="display:none;">
                                                        <div class="col-md-6">
                                                          <div class="form-group" >
                                                            <input type="hidden" id="seguimientoG" name="seguimientoG" >
                                                            <?php
                                                                $con = start_connect();
                                                                if( $con )
                                                                {
                                                                  $query = "SELECT  id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre IS NULL";
                                                                  $resultado = mysqli_query($con, $query);
                                                            ?>
                                                            <select id="maquina_finca"  disabled name="finca" class="form-control">
                                                              <option value="NULL"  selected="true" >Maquina/Herramienta</option>
                                                              <?php
                                                                  while( $row = mysqli_fetch_array( $resultado ) )
                                                                      {
                                                                        echo '<option  value="'.$row['  id_unidades_agricolas'].'">'.$row['nombre'].'</option>';
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
                                                                <?php
                                                                    $con = start_connect();
                                                                    if( $con )
                                                                    {
                                                                      $query = "SELECT id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre IS NOT NULL";
                                                                      $resultado = mysqli_query($con, $query);
                                                                ?>
                                                                <select id="maquina_suerte"  disabled name="suerte" class="form-control" >
                                                                  <option value="NULL"  selected="true" >Suerte</option>
                                                                  <?php
                                                                      while( $row = mysqli_fetch_array( $resultado ) )
                                                                          {
                                                                            echo '<option  value="'.$row['id_unidades_agricolas'].'">'.$row['nombre'].'</option>';
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
                                                      </div>
                                                      <div class="row" style="display:none;">
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                              <input  type="hidden" id="maquina_corte"  name="corte" class="form-control " placeholder="Corte #" maxlength="30" disabled>
                                                          </div>
                                                          <div class="form-group">
                                                              <input  type="hidden" id="laborG"  name="laborG" class="form-control " placeholder="Corte #" maxlength="30" disabled>
                                                          </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select id="tipoG"  disabled name="tipoG" class="form-control">
                                                              <option value="3"  selected="true" >Gasto</option>
                                                            </select>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <!-- <input type="hidden" id="labor" name="labor" > -->
                                                            <?php
                                                                $con = start_connect();
                                                                if( $con )
                                                                {
                                                                  $query = " SELECT idCostos,descripcion FROM costos WHERE tipo='1' ";
                                                                  $resultado = mysqli_query($con, $query);
                                                            ?>
                                                            <label for="gasto">Agregar Gasto</label>
                                                            <select id="gastoG" name="gastoG" class="form-control">
                                                              <option value="NULL" disabled selected="true" >Seleccionar Gasto</option>
                                                              <?php
                                                                  while( $row = mysqli_fetch_array( $resultado ) )
                                                                      {
                                                                        echo '<option value="'.$row['idCostos'].'">'.$row['descripcion'].'</option>';
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
                                                          <input id="valorG" name="valorG" class="form-control" value="" placeholder="Valor del Gasto">
                                                      </div>
                                                      <div class="form-group">
                                                          <div class="input-group date tiempo" data-date="" data-date-format="dd MM yyyy HH:mm:ss" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                              <input id="fechaG" name="fechaG" class="form-control" size="16" type="text" value="" placeholder="Fecha">
                                                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                          </div>
                                                      </div>

                                                      <div class="form-group">
                                                          <textarea id="comentarioG" name="comentarioG" class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                      </div>
                                                      <button type="button" onclick="guardarNuevoGastoSeguimiento()" id="form-submit" class="btn btn-default pull-right ">Agregar Gasto</button>
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
            <!-- Modal Ver Gasto de la Labor-->
            <div class="modal fade" id="gastoSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Costos Directos signados a la <strong><em>Labor <i id="vm_labor_g">L</i> del Corte #<i id="vm_corte_g">C</i> <i id="vm_suerte_g">S</i>  <i id="vm_finca_g">F</i></em></strong><!--  id= <i id="id_sg"></i> -->
                                        </div>
                                        <!-- /.panel-heading -->
                                      <div class="panel-body">
                                          <div class="dataTable_wrapper table-responsive">
                                              <table class="table table-striped table-bordered table-hover" id="tabla_gastoLabor">
                                                  <thead>
                                                      <tr>
                                                          <th>Costo Indirecto</th>
                                                          <th>Valor</th>
                                                          <th>Comentario</th>
                                                          <th>Fecha</th>
                                                          <th>Editar</th>
                                                          <th>Borrar</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="body_insumos_seguimiento">

                                                        <tr class="gradeX">
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                        </tr>

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
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- Modal editarGastoSeguimiento -->
            <div class="modal fade" id="editarGastoSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                         <div class="panel-heading">
                                            Editar Gasto a la <strong><em>Labor <i id="edit_g_labor">L</i> del Corte #<i id="edit_g_corte">C</i> <i id="edit_g_suerte">S</i>  <i id="edit_g_finca">F</i></em></strong>
                                        </div>
                                        <div class="panel-body">
                                          <div class="row">
                                              <div class="col-lg-12" id="">
                                                  <form role="form">
                                                    <div class="row" style="display:none;">
                                                      <div class="col-md-6">
                                                        <div class="form-group" >
                                                          <input type="hidden" id="edit_idDetalleG" name="edit_idDetalleG" >
                                                          <input type="hidden" id="edit_tipoG"  name="edit_tipoG" >
                                                          <input type="hidden" id="edit_gastoG"  name="edit_gastoG" >
                                                          <input type="hidden" id="edit_seguimientoG" name="edit_seguimientoG" >
                                                          <input type="hidden" id="edit_laborG"  name="edit_laborG" >
                                                          <input type="hidden" id="edit_maquina_fincaG" name="edit_maquina_fincaG" >
                                                          <input type="hidden" id="edit_maquina_suerteG" name="edit_maquina_suerteG" >
                                                          <input type="hidden" id="edit_maquina_corteG"  name="edit_maquina_corteG">
                                                        </div>
                                                      </div>
                                                    </div>                                                  
                                                      <div class="form-group">
                                                          <label for="edit_valorG">Valor:</label>
                                                          <input id="edit_valorG" name="edit_valorG" class="form-control">
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="edit_fechaG">Fecha:</label>
                                                        <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                          <input id="edit_fechaG" name="edit_fechaG" class="form-control" size="16" type="text"  >
                                                          <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <label for="edit_comentarioG">Comentarios:</label>
                                                          <textarea id="edit_comentarioG" name="edit_comentarioG" class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                      </div>
                                                      <button type="button" onclick="guardarEdicionGastoSeguimiento()" id="form-submit" class="btn btn-default pull-right ">Editar Gasto</button>
                                                      <div id="msgSubmit" class="h3 text-center hidden">Editado!</div>
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


            <!-- Modal nuevaNovedadSeguimiento -->
            <div class="modal fade" id="nuevaNovedadSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                         <div class="panel-heading">
                                            Agregar Novedad a la <strong><em>Labor <i id="n_labor">L</i> del COrte #<i id="n_corte">#</i> <i id="n_suerte">S</i>  <i id="n_finca">F</i></em></strong>
                                        </div>
                                        <div class="panel-body">
                                          <div class="row">
                                              <div class="col-lg-12" id="">
                                                  <form role="form">
                                                      <div class="row" style="display:none;">
                                                        <div class="col-md-6">
                                                          <div class="form-group" >
                                                            <input type="hidden" id="seguimientoN" name="seguimientoN" >
                                                            <?php
                                                                $con = start_connect();
                                                                if( $con )
                                                                {
                                                                  $query = "SELECT  id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre IS NULL";
                                                                  $resultado = mysqli_query($con, $query);
                                                            ?>
                                                            <select id="maquina_finca"  disabled name="finca" class="form-control">
                                                              <option value="NULL"  selected="true" >Maquina/Herramienta</option>
                                                              <?php
                                                                  while( $row = mysqli_fetch_array( $resultado ) )
                                                                      {
                                                                        echo '<option  value="'.$row['  id_unidades_agricolas'].'">'.$row['nombre'].'</option>';
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
                                                                <?php
                                                                    $con = start_connect();
                                                                    if( $con )
                                                                    {
                                                                      $query = "SELECT id_unidades_agricolas,nombre FROM  unidades_agricolas WHERE id_padre IS NOT NULL";
                                                                      $resultado = mysqli_query($con, $query);
                                                                ?>
                                                                <select id="maquina_suerte"  disabled name="suerte" class="form-control" >
                                                                  <option value="NULL"  selected="true" >Suerte</option>
                                                                  <?php
                                                                      while( $row = mysqli_fetch_array( $resultado ) )
                                                                          {
                                                                            echo '<option  value="'.$row['id_unidades_agricolas'].'">'.$row['nombre'].'</option>';
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
                                                      </div>
                                                      <div class="row" style="display:none;">
                                                        <div class="col-md-6">
                                                          <div class="form-group">
                                                              <input  type="hidden" id="maquina_corte"  name="corte" class="form-control " placeholder="Corte #" maxlength="30" disabled>
                                                          </div>
                                                          <div class="form-group">
                                                              <input  type="hidden" id="laborN"  name="laborN" class="form-control " placeholder="Corte #" maxlength="30" disabled>
                                                          </div>                                                          
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select id="tipoN"  disabled name="tipoN" class="form-control">
                                                              <option value="4"  selected="true" >Novedad</option>
                                                            </select>
                                                        </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <div class="input-group date tiempo" data-date="" data-date-format="dd MM yyyy HH:mm:ss" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                              <input id="fechaN" name="fechaN" class="form-control" size="16" type="text" value="" placeholder="Fecha">
                                                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                          </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <textarea id="comentarioN" name="comentarioN" class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                      </div>
                                                      <button type="button" onclick="guardarNuevaNovedadSeguimiento()" id="form-submit" class="btn btn-default pull-right ">Agregar Novedad</button>
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
            <!-- Modal Ver Novedad de la Labor-->
            <div class="modal fade" id="novedadSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Novedades signados a la <strong><em>Labor <i id="vm_labor_n">L</i> del Corte <i id="vm_corte_n">#</i> <i id="vm_suerte_n">S</i>  <i id="vm_finca_n">F</i></em></strong><!--  id= <i id="id_sg"></i> -->
                                        </div>
                                        <!-- /.panel-heading -->
                                      <div class="panel-body">
                                          <div class="dataTable_wrapper table-responsive">
                                              <table class="table table-striped table-bordered table-hover" id="tabla_novedadLabor">
                                                  <thead>
                                                      <tr>
                                                          <th>Novedad</th>
                                                          <th>Fecha</th>
                                                          <th>Editar</th>
                                                          <th>Borrar</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="body_insumos_seguimiento">

                                                        <tr class="gradeX">
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                        </tr>

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
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <!-- Modal editarNovedadSeguimiento -->
            <div class="modal fade" id="editarNovedadSeguimiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pie-chart fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                         <div class="panel-heading">
                                            Editar Novedad a la <strong><em>Labor <i id="edit_n_labor">L</i> del COrte #<i id="edit_n_corte">#</i> <i id="edit_n_suerte">S</i>  <i id="edit_n_finca">F</i></em></strong>
                                        </div>
                                        <div class="panel-body">
                                          <div class="row">
                                              <div class="col-lg-12" id="">
                                                  <form role="form">
                                                    <div class="row" style="display:none;">
                                                      <div class="col-md-6">
                                                        <div class="form-group" >
                                                          <input type="hidden" id="edit_idDetalleN" name="edit_idDetalleN" >
                                                          <input type="hidden" id="edit_tipoN"  name="edit_tipoN" >
                                                          <input type="hidden" id="edit_seguimientoN" name="edit_seguimientoN" >
                                                          <input type="hidden" id="edit_laborN"  name="edit_laborN" >
                                                          <input type="hidden" id="edit_maquina_fincaN" name="edit_maquina_fincaN" >
                                                          <input type="hidden" id="edit_maquina_suerteN" name="edit_maquina_suerteN" >
                                                          <input type="hidden" id="edit_maquina_corteN"  name="edit_maquina_corteN">
                                                        </div>
                                                      </div>
                                                    </div> 

                                                      <div class="form-group">
                                                          <div class="input-group date tiempo" data-date="" data-date-format="dd MM yyyy HH:mm:ss" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                              <input id="edit_fechaN" name="edit_fechaN" class="form-control" size="16" type="text" value="" placeholder="Fecha">
                                                              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                          </div>
                                                      </div>
                                                      <div class="form-group">
                                                          <textarea id="edit_comentarioN" name="edit_comentarioN" class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                      </div>
                                                      <button type="button" onclick="guardarEdicionNovedadSeguimiento()" id="form-submit" class="btn btn-default pull-right ">Editar Novedad</button>
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


            <!-- Modal -->
            <div class="modal fade" id="editCorte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-binoculars fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
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
                                                  <div class="col-md-6">
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
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="edit_unidad_agricola">Suerte</label><select id="edit_unidad_agricola" name="unidad_agricola" class="form-control">
                                                          <option value="NULL" disabled selected="true" >Suerte</option>
                                                        </select>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-2">
                                                    <div class="form-group"> 
                                                        <label for="corte">Corte #</label>
                                                        <input id="edit_codigoCorte" name="codigoCorte" class="form-control" placeholder="Corte #" >
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">

                                                  <div class="col-md-3">                                                           
                                                    <div class="form-group">
                                                        <label for="fechaInicio">Fecha Inicio</label>
                                                        <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                            <input id="edit_fechaInicio" name="fechaInicio" class="form-control" size="16" type="text" value="" placeholder="Fecha Inicio">
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="fechaFin">Fecha Fin</label>
                                                        <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                            <input id="edit_fechaFin" name="fechaFin" class="form-control" size="16" type="text" value="" placeholder="Fecha Fin">
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <div class="form-group">
                                                    <label for="area">Area</label>
                                                        <input id="edit_area" name="area" value="" class="form-control" placeholder="Ingrese el Area">
                                                    </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <div class="form-group">    
                                                        <label for="variedad">Variedad</label>                                                              
                                                        <input id="edit_variedad" name="variedad" class="form-control" placeholder="Variedad" >
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  
                                                  
                                                </div>                                                     
                                                <div class="form-group">
                                                <label for="edit_descripcion">Descripci&oacute;n</label>
                                                  <textarea id="edit_descripcion" name="descripcion"class="form-control" rows="3" placeholder="Descripci&oacute;n"></textarea>
                                                </div>
                                                
                                                <button type="button" onclick="guardarEdicionCorte()" id="form-submit" class="btn btn-default pull-right ">Actualizar</button>
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
            <!-- Modal -->
            <div class="modal fade" id="finCorte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-binoculars fa-fw"></i> Planificaci&oacute;n de Cosechas</h4>
                        </div>
                        <div class="modal-body">
                          <div class="row row2 between" id="formulario">
                              <div class="col-md-12">
                                  <div class="panel panel-default">
                                      <div class="panel-heading">
                                          Finalizar Corte
                                      </div>
                                      <div class="panel-body">
                                          <form id="unidades-agricolas" role="form">
                                            <input type="hidden" id="fin_id" name="id" >
                                                <div class="row">
                                                  <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="finca">Finca</label>
                                                        <select id="fin_finca" name="fin_finca" class="form-control" readonly>
                                                          <option value=""  selected="true" ></option>
                                                        </select>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="fin_unidad_agricola">Suerte</label>
                                                        <select id="fin_unidad_agricola" name="unidad_agricola" class="form-control" readonly>
                                                          <option value=""  selected="true" ></option>
                                                        </select>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-2">
                                                    <div class="form-group"> 
                                                        <label for="corte">Corte #</label>
                                                        <input id="fin_codigoCorte" name="fin_codigoCorte" class="form-control" readonly >
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                  <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="area">Area</label>
                                                        <input id="fin_area" name="area" value="" class="form-control" readonly>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <div class="form-group">    
                                                        <label for="variedad">Variedad</label>                                                              
                                                        <input id="fin_variedad" name="variedad" class="form-control" readonly>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-3">                                                           
                                                    <div class="form-group">
                                                        <label for="fechaInicio">Fecha Inicio</label>
                                                        <input id="fin_fechaInicio" name="fechaInicio" class="form-control" size="16" type="text" readonly>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-3">
                                                    <div class="form-group">
                                                      <label for="fechaFin">Fecha Fin</label>
                                                      <input id="fin_fechaFin" name="fechaFin" class="form-control" size="16" type="text" value="" readonly>
                                                    </div>
                                                  </div>


                                                </div>
                                                <div class="form-group">
                                                <label for="fin_descripcion">Descripci&oacute;n</label>
                                                  <textarea id="fin_descripcion" name="descripcion"class="form-control" rows="3" readonly></textarea>
                                                </div>

                                                <div class="row">
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="fechaCosecha">Fecha Cosecha</label>
                                                        <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                            <input id="fin_fechaCosecha" name="fechaCosecha" class="form-control" size="16" type="text" value="" placeholder="Fecha Cosecha">
                                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                        </div>
                                                    </div>
                                                  </div>

                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="edad">Edad Corte</label>
                                                        <input id="fin_edad" name="edad" value="" class="form-control" placeholder="Edad Corte">
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="tct">TCT</label>
                                                        <input id="fin_TCT" name="TCT" value="" class="form-control" placeholder="TCT">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="tch">TCH</label>
                                                        <input id="fin_TCH" name="TCH" value="" class="form-control" placeholder="TCH">
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="tchm">TCHM</label>
                                                        <input id="fin_TCHM" name="TCHM" value="" class="form-control" placeholder="TCHM">
                                                    </div>
                                                  </div>
                                                  <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="rendimiento">Rendimiento</label>
                                                    <input id="fin_rendimiento" name="rendimiento" value="" class="form-control" placeholder="Rendimiento">
                                                    </div>
                                                  </div>
                                                </div>
                                                <button type="button" onclick="guardarFin()" id="form-submit" class="btn btn-default pull-right ">Actualizar</button>
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
