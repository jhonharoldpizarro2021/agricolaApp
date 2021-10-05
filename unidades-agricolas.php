<?php include "header.php"; ?>
  <script type="text/javascript" src="js/unidades_agricolas.js"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-road fa-fw"></i> Unidades Agricolas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg" onclick="abrirNuevaUnidad()"><i class="fa fa-plus"></i></button> Agregar Unidad Agricola
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="nuevaUnidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-road fa-fw"></i> Unidades Agricolas</h4>
                                    </div>
                                    <div class="modal-body">
            							            <div class="row row2 between" id="formulario">
            							                <div class="col">
            							                    <div class="panel panel-default">
            							                        <div class="panel-heading">
            							                            Agregar Unidad Agricola
            							                        </div>
            							                        <div class="panel-body">
          							                            <div class="row">
          							                                <div class="col-lg-12" id="formNueva">
          					                                			<form id="unidades-agricolas" role="form">
    						                                            <div class="form-group">
    						                                                <!-- <label>Codigo</label>  -->
    						                                                <input id="codigo" name="codigo" value="" class="form-control" placeholder="Código Unidad Agricola">
    						                                                <!-- <p class="help-block">Example block-level help text here.</p> -->
    						                                            </div>
    						                                            <div class="form-group">
    						                                                <input id="nombre" name="nombre" value="" class="form-control" placeholder="Nombre">
    						                                            </div>
                                                            <div class="form-group">
                                                                <select id="id_padre" name="id_padre" class="form-control">
                                                                  <option value="NULL" disabled="disable" selected="true" >Pertenece a</option>
                                                                  <option value="NULL" >Ninguna</option>
                                                                </select>
                                                            </div>
    						                                            <div class="form-group">
    						                                                <textarea id="descripcion" name="descripcion_ampliada" value="" class="form-control" rows="3" placeholder="Descripción Ampliada"></textarea>
    						                                            </div>
    						                                            <div class="form-group">
    						                                                <input id="area" name="area" value="" class="form-control" placeholder="Área">
    						                                            </div>
    							                                        <button type="button" onclick="nuevaUnidad()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
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
                                <table class="table table-striped table-bordered table-hover " id="tabla_unidades">
                                    <thead>
                                        <tr>
                                            <th class="editar">Codigo</th>
                                            <th>Suerte</th>
                                            <th>Finca</th>
                                            <th>Descripcion</th>
                                            <th>Area</th>
                                            <th class="editar center">Editar</th>
                                            <th class="editar center">Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_unidades">
                                    <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = "SELECT a.*, b.nombre AS nombre_padre FROM unidades_agricolas AS a
                                                  LEFT JOIN unidades_agricolas AS b ON a.id_padre=b.id_unidades_agricolas";
                                        $resultado = mysqli_query($con, $query);
                                        while( $row = mysqli_fetch_array( $resultado ) )
                                        {
                                        ?>
                                          <tr class="gradeX">
                                            <td><?php echo $row["codigo"] ?></td>
                                            <td><?php echo utf8_encode($row["nombre"]) ?></td>
                                            <td ><?php echo utf8_encode($row["nombre_padre"]) ?></td>
                                            <td ><?php echo utf8_encode(eregi_replace("[\n|\r|\n\r]", '<br>',$row["descripcion_ampliada"])) ?></td>
                                            <td><?php echo $row["area"] ?></td>
                                            <?php echo '<td>
                                                <a onclick="editarUnidad(\''. $row["id_unidades_agricolas"] .'\',\''. utf8_encode($row["nombre"]) .'\',\''. $row["codigo"] .'\',\''. $row["id_padre"] .'\',\''. utf8_encode(eregi_replace("[\n|\r|\n\r]", "\\n",$row["descripcion_ampliada"])) .'\',\''. utf8_encode($row["area"]) .'\')"
                                                  aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                              </td>
                                              <td>
                                                <a href="javascript:borrarUnidad(\''. $row["id_unidades_agricolas"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
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
            <div class="modal fade" id="editUnidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-road fa-fw"></i> Unidades Agricolas</h4>
                        </div>
                        <div class="modal-body">
      				            <div class="row row2 between" id="formulario">
      				                <div class="col">
      				                    <div class="panel panel-default">
      				                        <div class="panel-heading">
      				                            Editar Unidad Agricola
      				                        </div>
      				                        <div class="panel-body">
      				                            <div class="row">
      				                                <div class="col-lg-12">
      				                                    <form id="unidades-agricolas" role="form">
                                                      <input type="hidden" id="edit_id_unidad" name="id" value="">
                                                      <div class="form-group">
                                                          <label for="codigo">Codigo:</label>
      				                                            <input id="edit_codigo" name="codigo" value="" class="form-control"  title="Codigo Unidad Agricola">
      				                                        </div>
      				                                        <div class="form-group">
                                                              <label for="nombre">Nombre:</label>
      				                                            <input id="edit_nombre" name="nombre" value="" class="form-control" title="Nombre Unidad Agricola">
      				                                        </div>
                                                      <div class="form-group">

                                                          <label for="id_padre">Pertenece a:</label>
                                                          <select id="edit_id_padre" name="id_padre" class="form-control">
                                                              <option value="NULL" selected="true">Seleccionar</option>
                                                              <option value="NULL" >Ninguna</option>
                                                          </select>
                                                      </div>
      				                                        <div class="form-group">
                                                                  <label for="descripcion_ampliada">Descripción:</label>
      				                                            <textarea id="edit_descripcion" name="descripcion_ampliada" value="" class="form-control" rows="3" title="Descripción Ampliada"></textarea>
      				                                        </div>
      				                                        <div class="form-group">
                                                                  <label for="area">Area:</label>
      				                                            <input id="edit_area" name="area" value="" class="form-control" title="Área">
      				                                        </div>
      				                                        <button type="button" onclick="guardarEdicion()" id="form-submit" class="btn btn-default pull-right ">Actualizar</button>
      				                                        <div id="msgSubmit" class="h3 text-center hidden">Actualizado!</div>
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
