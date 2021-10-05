<?php include "header.php"; ?>
  <script type="text/javascript" src="js/maquinaria-herramienta.js?n=<?= time() ?>"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-wrench fa-fw"></i> Maquinaria - Herramientas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg" data-toggle="modal" data-target="#nuevaMaquina"><i class="fa fa-plus"></i></button> Agregar Maquina ó Herramienta
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="nuevaMaquina" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-wrench fa-fw"></i> Maquinas - Herramientas</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formulario">
                                            <div class="col">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Agregar Maquina ó Herramienta
                                                    </div>
                                                    <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12" id="formNuevaMaquina">
                                                            <form role="form">
                                                                <div class="form-group">
                                                                    <input id="nombre" name="nombre" class="form-control" placeholder="Nombre">
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                        <input id="fecha_compra" name="fecha_compra" class="form-control" size="16" type="text" value="" placeholder="Fecha de Compra">
                                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                            		<input id="codigo" name="codigo" class="form-control" value="" placeholder="Codigo"/>
                                                        		</div>
                                                                <div class="form-group">
                                                                    <input id="lapso_mantenimiento" name="lapso_mantenimiento" class="form-control" value="" placeholder="Lapso de Mantenimiento"/>
                                                                </div>
                                                                <div class="form-group">
                                                                    <?php
                                                                        $con = start_connect();
                                                                        if( $con )
                                                                        {
                                                                          $query = "SELECT id_unidades_tiempo_medida,descripcion FROM unidades_tiempo_medida";
                                                                          $resultado = mysqli_query($con, $query);
                                                                    ?>
                                                                    <select id="unidades_t" name="unidades_t" class="form-control">
                                                                      <option value="NULL" disabled selected="true" >Tiempo</option>
                                                                      <?php
                                                                          while( $row = mysqli_fetch_array( $resultado ) )
                                                                              {
                                                                                echo '<option value="'.$row['id_unidades_tiempo_medida'].'">'.utf8_encode($row['descripcion']).'</option>';
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
                                                                        <input id="fecha_ultimo_mantenimiento" name="fecha_ultimo_mantenimiento" class="form-control" size="16" type="text" value="" placeholder="ultimo mantenimiento">
                                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea id="comentario" name="comentario"class="form-control" rows="3" placeholder="Comentarios"></textarea>
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
                                                                                echo '<option value="'.$row['id_proveedor'].'">'.utf8_encode ($row['nombre']).'</option>';
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
                                                                <button type="button" onclick="nuevaMaquina()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
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
                                <table class="table table-striped table-bordered table-hover " id="tabla_maquinas">
                                    <thead>
                                        <tr>
                                            <th class="nombre">Nombre</th>
                                            <th class="fcompra">Fecha Compra</th>
                                            <th class="codigo center">Codigo</th>
                                            <th class="fcompra hideColum ">Lapso de Mantenimiento</th>
                                            <th class="fcompra hideColum ">Último Mantenimiento</th>
                                            <th class="hideColum">Comentario</th>
                                            <th class="inicio hideColum ">Proveedor</th>
                                            <th class="editar center ">Ver</th>
                                            <th class="borrar center ">Editar</th>
                                            <th class="borrar center ">Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_herramientas">
                                     <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = "SELECT * FROM qr_maquinas_herramientas";
                                        $resultado = mysqli_query($con, $query);

                                        while( $row = mysqli_fetch_array( $resultado ) )
                                        {
                                        ?>
                                          <tr class="gradeX">
                                            <td><?php echo utf8_encode($row["nombre"]) ?></td>
                                            <td ><?php echo $row["fecha_compra"] ?></td>
                                            <td ><?php echo $row["codigo"] ?></td>
                                            <td class="hideColum"><?php echo $row["lapso_mantenimiento"] . ' ' . utf8_encode($row["desc_unidad_tiempo"]) ?></td>
                                            <td class="hideColum"><?php echo $row["fecha_ultimo_mantenimiento"] ?></td>
                                            <td class="hideColum"><?php echo utf8_encode(eregi_replace("[\n|\r|\n\r]", '<br>',$row["comentario"])) ?></td>
                                            <td class="hideColum"><?php echo utf8_encode($row["nombre_proveedor"]) ?></td>
                                            <?php echo '<td class="center">
                                                <a onclick="verMaquina(\''. $row["id_maquinas_herramientas"] .'\',\''. utf8_encode($row["nombre"]) .'\',\''. $row["fecha_compra"] .'\',\''. $row["codigo"] .'\',\''. $row["lapso_mantenimiento"] .'\',\''. $row["unidades_tiempo_medida_id_unidades_tiempo_medida"] .'\',\''. $row["fecha_ultimo_mantenimiento"] .'\',\''.utf8_encode(eregi_replace("[\n|\r|\n\r]", "\\n",$row["comentario"])) .'\',\''. utf8_encode($row["nombre_proveedor"]) .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a>
                                            </td>
                                            <td class="center">
                                                <a onclick="editarMaquina(\''. $row["id_maquinas_herramientas"] .'\',\''. utf8_encode($row["nombre"]) .'\',\''. $row["fecha_compra"] .'\',\''. $row["codigo"] .'\',\''. $row["lapso_mantenimiento"] .'\',\''. $row["unidades_tiempo_medida_id_unidades_tiempo_medida"] .'\',\''. $row["fecha_ultimo_mantenimiento"] .'\',\''.utf8_encode(eregi_replace("[\n|\r|\n\r]", "\\n",$row["comentario"])) .'\',\''. $row["proveedor_id_proveedor"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                            </td>
                                            <td class="center">
                                              <a href="javascript:borrarMaquina(\''. $row["id_maquinas_herramientas"] .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
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
            <div class="modal fade" id="editMaquina" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-wrench fa-fw"></i> Maquinas ó Herramientas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Editar Maquina ó Herramienta
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form role="form">
                                                        <input type="hidden" id="edit_id_maquina" name="id" >
                                                        <div class="form-group">
                                                            <label for="nombre">Nombre:</label>
                                                            <input id="edit_nombre" name="nombre" class="form-control" placeholder="Nombre">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="fecha_compra">Fecha de Compra:</label>
                                                            <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-lunidades_t_mink-format="yyyy-mm-dd">
                                                                <input id="edit_fecha_compra" name="fecha_compra" class="form-control" size="16" type="text" value="" placeholder="Fecha de Compra">
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="codigo">Codigo:</label>
                                                            <input id="edit_codigo" name="codigo" class="form-control" value="" placeholder="Codigo"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="lapso_mantenimiento">Lapso de Mantenimiento:</label>
                                                            <input id="edit_lapso_mantenimiento" name="lapso_mantenimiento" class="form-control" value="" placeholder="Lapso de Mantenimiento"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="unidades_t_m">Tiempo / Medida</label>
                                                            <?php
                                                                $con = start_connect();
                                                                if( $con )
                                                                {
                                                                  $query = "SELECT * FROM unidades_tiempo_medida";
                                                                  $resultado = mysqli_query($con, $query);
                                                            ?>
                                                            <select id="edit_unidades_t_m" name="unidades_t_m" class="form-control">
                                                               <option selected value="NULL">Seleccione</option>
																<?php
	                                                                  while( $row = mysqli_fetch_array( $resultado ) )
	                                                                      {
	                                                                        echo '<option value="'.$row['id_unidades_tiempo_medida'].'">'.utf8_encode($row['descripcion']).'</option>';
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
                                                            <label for="fecha_ultimo_mantenimiento">Último Mantenimiento:</label>
                                                            <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                <input id="edit_fecha_ultimo_mantenimiento" name="fecha_ultimo_mantenimiento" class="form-control" size="16" type="text" value="" placeholder="ultimo mantenimiento">
                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="comentario">Comentario:</label>
                                                            <textarea id="edit_comentario" name="comentario"class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="proveedor_id_proveedor">Proveedor:</label>
                                                            <?php
                                                                $con = start_connect();
                                                                if( $con )
                                                                {
                                                                  $query = "SELECT * FROM  proveedor";
                                                                  $resultado = mysqli_query($con, $query);
                                                            ?>
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
                                                        <button type="button" onclick="guardarEdicion()" id="form-submit" class="btn btn-default pull-right ">Actualizar</button>
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
            <!-- Modal ver-->
            <div class="modal fade" id="verMaquina" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-wrench fa-fw"></i> Maquinas ó Herramientas</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Ver Maquina ó Herramienta
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
                                                                                <span id="ver_id_maquina" style="display: none;"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-12 ">
                                                                        <div class="row show-grid">
                                                                            <div class="col-md-12"> 
                                                                                <div class="nom"><i>Fecha de Compra: </i></div>
                                                                                <div class="data"><h4><span id="ver_fecha_compra"></span></h4></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <div class="row show-grid">
                                                                            <div class="col-md-12"> 
                                                                                <div class="nom"><i>Codigo: </i></div>
                                                                                <div class="data"><h4><span id="ver_codigo"></span></h4></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-12 ">
                                                                        <div class="row show-grid">
                                                                            <div class="col-md-12"> 
                                                                                <div class="nom"><i>Lapso de Mantenimiento: </i></div>
                                                                                <div class="data"><h4><span id="ver_lapso_mantenimiento"></span></h4></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-12 ">
                                                                        <div class="row show-grid">
                                                                            <div class="col-md-12"> 
                                                                                <div class="nom"><i>Tiempo / Medida </i></div>
                                                                                <div class="data"><h4><span id="ver_unidades_t_m"></span><span id="has"></span></h4></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-md-12 ">
                                                                        <div class="row show-grid">
                                                                            <div class="col-md-12">
                                                                                <div class="nom"><i>Último Mantenimiento: </i></div>
                                                                                <div class="data"><h4><span id="ver_fecha_ultimo_mantenimiento"></span></h4></div>
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
