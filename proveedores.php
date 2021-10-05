<?php include "header.php"; ?>
  <script type="text/javascript" src="js/proveedores.js"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-truck fa-fw"></i> Proveedores </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg nuevaunidad" data-toggle="modal" data-target="#nuevoProveedor"><i class="fa fa-plus"></i></button> Agregar Proveedor  
                        </div>
                        <!-- Modal Nueva Medida-->
                        <div class="modal fade" id="nuevoProveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-truck fa-fw"></i> Proveedores</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formulariProveedores">
                                            <div class="col">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                         Agregar Proveedor 
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-lg-12" id="formProvee">
                                                                <form role="form" id="proveedores">
                                                                    <div class="form-group">
                                                                        <input id="nombre" name="nombre" value="" class="form-control" placeholder="Nombre">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input id="nit" name="nit" value="" class="form-control" placeholder="NIT">
                                                                    </div>  
                                                                    <div class="form-group">
                                                                        <input id="direccion" name="direccion" value="" class="form-control" placeholder="Dirección">
                                                                    </div>      
                                                                    <div class="form-group">
                                                                        <input id="telefono" name="telefono" value="" class="form-control" placeholder="Teléfono">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="email" id="email" name="email" value="" class="form-control" placeholder="Correo Electrónico">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <textarea id="comentarios" name="comentarios" class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                                                    </div>
                                                                    <button type="button" onclick="nuevoProveedor()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
                                                                    <div id="msgSubmit" class="h3 text-center hidden">Cread0!</div>
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
                                <table class="table table-striped table-bordered table-hover " id="tabla_proveedor">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th class="nit">NIT</th>
                                            <th>Dirección</th>
                                            <th>Teléfono</th>
                                            <th class="w11">Correo Electronico</th>
                                            <th>Comentarios</th>
                                            <th class="editar center">Editar</th>
                                            <th class="editar center">Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_proveedores">
                                    <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = "SELECT * FROM proveedor";
                                        $resultado = mysqli_query($con, $query);
                                        while( $row = mysqli_fetch_array($resultado) )
                                        {
                                        ?>
                                          <tr class="<?php echo $class ?> gradeX">
                                            <td><?php echo utf8_encode($row["nombre"]) ?></td>
                                            <td><?php echo $row["nit"] ?></td>
                                            <td><?php echo $row["direccion"] ?></td>
                                            <td><?php echo $row["telefono"] ?></td>
                                            <td><?php echo utf8_encode($row["email"]) ?></td>
                                            <td><?php echo utf8_encode(eregi_replace("[\n|\r|\n\r]", '<br>',$row["comentarios"])) ?></td>
                                            <?php echo '<td class="center">
                                              <a onclick="editarProveedor(\''. $row["id_proveedor"] .'\',\''. utf8_encode($row["nombre"]) .'\',\''. $row["nit"] .'\',\''. $row["direccion"] .'\',\''. $row["telefono"] .'\',\''. $row["email"] .'\',\''. utf8_encode(eregi_replace("[\n|\r|\n\r]", "\\n",$row["comentarios"])) .'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                              </td>
                                            <td class="center">
                                              <a href="javascript:borrarProveedor(\''. $row["id_proveedor"] .'\')" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
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
            <div class="modal fade" id="editProveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-truck fa-fw"></i> Proveedores</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formularioMedida">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Editar Proveedor 
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form role="form" id="medida">
                                                        <input type="hidden" id="edit_id_proveedor" name="id_proveedor" >
                                                        <div class="form-group">
                                                            <label for="nombre">Nombre:</label>
                                                            <input id="edit_nombre" name="nombre" class="form-control" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nit">NIT:</label>
                                                            <input id="edit_nit" name="nit" value="" class="form-control" >
                                                        </div>  
                                                        <div class="form-group">
                                                            <label for="direccion">Dirección:</label>
                                                            <input id="edit_direccion" name="direccion" value="" class="form-control">
                                                        </div>  
                                                        <div class="form-group">
                                                            <label for="telefono">Teléfono:</label>
                                                            <input id="edit_telefono" name="telefono" value="" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Correo Electrónico:</label>
                                                            <input type="email" id="edit_email" name="email" value="" class="form-control" >
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea id="edit_comentarios" name="comentarios" class="form-control" rows="3" placeholder="Comentarios"></textarea>
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
