<?php include "header.php"; ?>
  <script type="text/javascript" src="js/insumos.js?n=<?= time() ?>"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-plug fa-fw"></i> Insumos</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg" data-toggle="modal" data-target="#nuevoInsumo"><i class="fa fa-plus"></i></button> Agregar Nuevo Insumo
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="nuevoInsumo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plug fa-fw"></i> Insumos</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formulario">
                                            <div class="col">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Agregar Insumo
                                                    </div>
                                                    <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12" id="formNuevoInsumo">
                                                            <form role="form">
                                                                <div class="form-group">
                                                                    <input id="descripcion" name="descripcion" class="form-control" placeholder="Nombre">
                                                                </div>
                                                                <div class="form-group">
                                                                    <?php
                                                                        $con = start_connect();
                                                                        if( $con )
                                                                        {
                                                                          $query = "SELECT * FROM  proveedor";
                                                                          $resultado = mysqli_query($con, $query);
                                                                    ?>
                                                                    <select id="proveedor_id_proveedor" name="proveedor_id_proveedor" class="form-control">
                                                                      <option value="NULL" disabled selected="true" >Proveedor</option>
                                                                      <?php
                                                                          while( $row = mysqli_fetch_array( $resultado ) )
                                                                              {
                                                                                echo '<option value="'.$row['id_proveedor'].'">'.utf8_encode($row['nombre']).'</option>';
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
                                                                    <?php
                                                                        $con = start_connect();
                                                                        if( $con )
                                                                        {
                                                                          $query = "SELECT * FROM  unidades_medida";
                                                                          $resultado = mysqli_query($con, $query);
                                                                    ?>
                                                                    <select id="unidades_medida_id_unidades_medida" name="unidades_medida_id_unidades_medida" class="form-control">
                                                                      <option value="NULL" disabled selected="true" >Unidad de Medida</option>
                                                                      <?php
                                                                          while( $row = mysqli_fetch_array( $resultado ) )
                                                                              {
                                                                                echo '<option value="'.$row['id_unidades_medida'].'">'.utf8_encode($row['descripcion']).'</option>';
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
                                                                        <input id="fecha_compra" name="fecha_compra" class="form-control" size="16" type="text" value="" placeholder="Última Compra">
                                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea id="descripcion_ampliada" name="descripcion_ampliada"class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                                </div>                                                                
                                                                <button type="button" onclick="nuevoInsumo()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
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
                                <table class="table table-striped table-bordered table-hover " id="tabla_insumos">
                                    <thead>
                                        <tr>
                                            <th class="nombre">Nombre</th>
                                            <th class="nombre">Proveedor</th>
                                            <th class="fcompra">Unidad de Medida</th>
                                            <th class="fcompra">Última Compra</th>
                                            <th class="hideColum">Comentario</th>
                                            <th class="editar center ">Ver</th>                                            
                                            <th class="borrar center">Editar</th>
                                            <th class="borrar center">Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_insumos">
                                     <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = "SELECT * FROM qr_insumos";
                                        $resultado = mysqli_query($con, $query);

                                        while( $row = mysqli_fetch_array( $resultado ) )
                                        {
                                        ?>
                                          <tr class="gradeX">
                                            <td><?php echo utf8_encode($row["descripcion"]) ?></td>
                                            <td ><?php echo utf8_encode($row["nombre_proveedor"]) ?></td>
                                            <td><?php echo utf8_encode($row["desc_unidad_medida"])?></td>
                                            <td ><?php echo $row["fecha_compra"] ?></td>
                                            <td class="hideColum"><?php echo utf8_encode(eregi_replace("[\n|\r|\n\r]", '<br>',$row["comentarios"])) ?></td>
                                            <?php echo '<td class="center">
                                                <a onclick="verInsumo(\''. $row["id_insumos"] .'\',\''. utf8_encode($row["descripcion"]) .'\',\''. $row["id_proveedor"] .'\',\''. $row["id_unidad_medida"] .'\',\''. $row["fecha_compra"] .'\',\''.utf8_encode(eregi_replace("[\n|\r|\n\r]", "\\n",$row["comentarios"])) .'\')"
                                                aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a>
                                            </td>
                                            <td class="center">
                                                <a onclick="editarInsumo(\''. $row["id_insumos"] .'\',\''. utf8_encode($row["descripcion"]) .'\',\''. $row["id_proveedor"] .'\',\''. $row["id_unidad_medida"] .'\',\''. $row["fecha_compra"] .'\',\''.utf8_encode(eregi_replace("[\n|\r|\n\r]", "\\n",$row["comentarios"])) .'\')"
                                                aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                            </td>
                                            <td class="center">
                                              <a href="javascript:borrarInsumo(\''. $row["id_insumos"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
                                            </td>' ?>
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
            <!-- Modal -->
            <div class="modal fade" id="editInsumos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plug fa-fw"></i> Insumos</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                           Editar Insumo
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form role="form">
                                                        <input type="hidden" id="edit_id_insumos" name="id_insumos" >
                                                        <div class="form-group">
                                                            <label for="descripcion">Nombre:</label>
                                                            <input id="edit_descripcion" name="descripcion" class="form-control" placeholder="Nombre">
                                                        </div>
                                                        <div class="form-group">
                                                            <?php
                                                                $con = start_connect();
                                                                if( $con )
                                                                {
                                                                  $query = "SELECT id_proveedor,nombre FROM  proveedor";
                                                                  $resultado = mysqli_query($con, $query);
                                                            ?>
                                                            <label for="proveedor_id_proveedor">Proveedor:</label>
                                                            <select id="edit_proveedor_id_proveedor" name="proveedor_id_proveedor" class="form-control">
                                                              <option value="NULL" disabled selected="true" >Proveedor</option>
                                                              <?php
                                                                  while( $row = mysqli_fetch_array( $resultado ) )
                                                                      {
                                                                        echo '<option value="'.$row['id_proveedor'].'">'.utf8_encode($row['nombre']).'</option>';
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
                                                            <?php
                                                                $con = start_connect();
                                                                if( $con )
                                                                {
                                                                  $query = "SELECT id_unidades_medida,descripcion FROM unidades_medida";
                                                                  $resultado = mysqli_query($con, $query);
                                                            ?>
                                                            <label for="edit_unidades_m">Tiempo / Medida:</label>
                                                            <select id="edit_unidades_m" name="unidades_m" class="form-control">
                                                              <option value="NULL" disabled selected="true" >Tiempo / Medida</option>
                                                              <?php
                                                                  while( $row = mysqli_fetch_array( $resultado ) )
                                                                      {
                                                                        echo '<option value="'.$row['id_unidades_medida'].'">'.utf8_encode($row['descripcion']).'</option>';
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
                                                          <label for="edit_fecha_compra">Última Compra:</label>
                                                            <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                <input id="edit_fecha_compra" name="fecha_compra" class="form-control" size="16" type="text" value="" placeholder="Última Compra">
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="edit_comentarios">Comentarios:</label>
                                                            <textarea id="edit_comentarios" name="edit_comentarios" class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                        </div>
                                                        
                                                        <button type="button" onclick="guardarEdicion()" id="form-submit" class="btn btn-default pull-right ">Actualizar</button>
                                                        <div id="msgSubmit" class="h3 text-center hidden">Actualizacion Completa!</div>
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
            <!-- Modal ver-->
            <div class="modal fade" id="verInsumo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-wrench fa-fw"></i> Insumos </h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Ver Insumo 
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div id="consulta">
                                                        <div class="panel panel-warning">
                                                            <div class="panel-heading segLab">
                                                                <div class="row" >
                                                                    <div class="col-sm-12 col-md-12 ">
                                                                        <div class="row show-grid">
                                                                            <div class="col-md-12"> 
                                                                                <div class="nom"><i>Nombre: </i></div>
                                                                                <div class="data"><h4><span id="ver_nombre"></span></h4></div>
                                                                                <span id="ver_id" style="display: none;"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-12 ">
                                                                        <div class="row show-grid">
                                                                            <div class="col-md-12"> 
                                                                                <div class="nom"><i>Proveedor: </i></div>
                                                                                <div class="data"><h4><span id="ver_proveedor"></span></h4></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-12 ">
                                                                        <div class="row show-grid">
                                                                            <div class="col-md-12"> 
                                                                                <div class="nom"><i>Unidad de Medida: </i></div>
                                                                                <div class="data"><h4><span id="ver_unidades"></span></h4></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12 ">
                                                                        <div class="row show-grid">
                                                                            <div class="col-md-12"> 
                                                                                <div class="nom"><i>&Uacute;ltima Compra: </i></div>
                                                                                <div class="data"><h4><span id="ver_fcompra"></span></h4></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-12 ">
                                                                        <div class="row show-grid">
                                                                            <div class="col-md-12">
                                                                                <div class="nom"><i>Comentario: </i></div>
                                                                                <div class="data"><h4><span id="ver_comentario"></span></h4></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- /.panel -->
                                                    </div>
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
            <!-- /.modal ver-->             
<?php include "footer.php";?>
