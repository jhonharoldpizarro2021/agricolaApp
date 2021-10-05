<?php include "header.php"; ?>
  <script type="text/javascript" src="js/personal.js"></script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-users fa-fw"></i> Personal</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="btn btn-default btn-circle btn-lg" onclick="abrirNuevo()"><i class="fa fa-plus"></i></button> Agregar Empleado
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="nuevoEmpleado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title" id="myModalLabel"><i class="fa fa-users fa-fw"></i> Personal</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row row2 between" id="formulario">
                                            <div class="col">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        Agregar Empleado
                                                    </div>
                                                    <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-lg-12" id="formNuevoEmpleado">
                                                            <form role="form">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input id="doc" name="doc" class="form-control" placeholder="Documento Identidad">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                                <input id="fecha_nac" name="fecha_nac" class="form-control" size="30" type="text" value="" placeholder="Fecha de Nacimiento">
                                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                            </div>
                                                                            <input type="hidden" id="dtp_input2" value="" />
                                                                        </div>
                                                                    </div>                                            
                                                                </div>
                                                                <div class="form-group">
                                                                    <input id="nombre" name="nombre" class="form-control" placeholder="Nombres y Apellidos">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input id="dir" name="dir" class="form-control" placeholder="Dirección ">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                       <div class="form-group">
                                                                            <input id="tel" name="tel" class="form-control" placeholder="Teléfono">
                                                                        </div> 
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input id="cel" name="cel" class="form-control" placeholder="Celular">
                                                                    </div>
                                                                    </div>                                            
                                                                </div>
                                                                <div class="form-group">
                                                                    <input id="email" name="email" type="email" class="form-control" placeholder="Correo Electrónico">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <select id="eps" name="eps" class="form-control">
                                                                              <option value="null"> EPS </option>
                                                                            </select>                                                                           
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <select id="arl" name="arl" class="form-control">
                                                                              <option value="null"> ARL </option>
                                                                            </select>                                                                           
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <select id="pension" name="pension" class="form-control">
                                                                              <option value="null"> Pensi&oacute;n </option>
                                                                            </select>                                                                           
                                                                        </div>
                                                                    </div>                                            
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                                <input id="fecha_ingreso" name="fecha_ingreso" class="form-control" size="30" type="text" value="" placeholder="Fecha de Ingreso">
                                                                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                            </div>
                                                                            <input type="hidden" id="dtp_input2" value="" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        
                                                                    </div>                                            
                                                                </div>  
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <select id="estado_civil" name="estado_civil" class="form-control">
                                                                                <option value="" disabled selected >Estado Civil</option>
                                                                                <option value="Soltero">Soltero</option>
                                                                                <option value="Casado">Casado</option>
                                                                                <option value="Unión Libre">Unión Libre</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input type="number" id="hijos" name="hijos" class="form-control" placeholder="Nro. de Hijos">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input id="cuenta" name="cuenta" class="form-control" placeholder="Cuenta Nro.">
                                                                        </div>
                                                                    </div>                                              
                                                                </div>                                                              
                                                                <button type="button" onclick="nuevoPersonal()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
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
                                <table class="table table-striped table-bordered table-hover " id="tabla_personal">
                                    <thead>
                                        <tr>
                                            <th class="nombre">Nombre</th>
                                            <th class="hideColum">Documento</th>
                                            <th class="fcompra hideColum">Fecha Nacimiento</th>
                                            <th class="">Dirección</th>
                                            <th class="">Teléfono</th>
                                            <th class="">Celular</th> 
                                            <th class="hideColum">Correo Electronico</th> 
                                            <th class="fcompra hideColum">Fecha Ingreso</th> 
                                            <th class="hideColum">Estado Civil</th> 
                                            <th class="hideColum"># Hijos</th> 
                                            <th class="hideColum">EPS</th> 
                                            <th class="hideColum">ARL</th>
                                            <th class="hideColum">Pension</th>
                                            <th class="hideColum">Cuenta Nro.</th>                                              
                                            <th class="editar center">Editar</th>
                                            <th class="borrar center">Borrar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_personal">
                                     <?php
                                      $con = start_connect();
                                      if( $con )
                                      {
                                        $query = "SELECT * FROM qr_personal";
                                        $resultado = mysqli_query($con, $query);

                                        while( $row = mysqli_fetch_array( $resultado ) )
                                        {
                                        ?>
                                          <tr class="">
                                            <td ><?php echo utf8_encode($row["nombre_personal"]) ?></td>
                                            <td class="hideColum"><?php echo $row["cc"] ?></td>
                                            <td class="hideColum"><?php echo $row["fecha_nacimiento"] ?></td>
                                            <td><?php echo utf8_encode($row["direccion"]) ?></td>
                                            <td><?php echo $row["telefono"] ?></td>
                                            <td><?php echo $row["celular"] ?></td> 
                                            <td class="hideColum"><?php echo $row["email"] ?></td>
                                            <td class="hideColum"><?php echo $row["fecha_ingreso"] ?></td>
                                            <td class="hideColum"><?php echo $row["estado_civil"] ?></td>
                                            <td class="hideColum"><?php echo $row["nro_hijos"] ?></td>
                                            <td class="hideColum"><?php echo utf8_encode($row["nombre_eps"]) ?></td>
                                            <td class="hideColum"><?php echo utf8_encode($row["nombre_arl"]) ?></td>
                                            <td class="hideColum"><?php echo utf8_encode($row["nombre_pension"]) ?></td>
                                            <td class="hideColum"><?php echo $row["cuenta"] ?></td>
                                            <?php echo '<td class="editar center"> 
                                                <a onclick="editarEmpleado(\''. $row["id_personal"] .'\',\''. $row["cc"] .'\',\''. $row["fecha_nacimiento"] .'\',\''. utf8_encode($row["nombre_personal"]) .'\',\''. utf8_encode($row["direccion"]) .'\',\''. $row["telefono"] .'\',\''. $row["celular"] .'\',\''. $row["email"] .'\',\''. $row["id_eps"] .'\',\''. $row["id_arl"].'\',\''. $row["id_pension"] .'\',\''. $row["fecha_ingreso"] .'\',\''. $row["estado_civil"] .'\',\''. $row["nro_hijos"] .'\',\''. $row["cuenta"] .'\')"
                                                aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>
                                            </td>
                                            <td class="editar center">
                                              <a href="javascript:borrarEmpleado(\''. $row["id_personal"] .'\')" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>
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
            <div class="modal fade" id="editPersonal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-users fa-fw"></i> Personal</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row row2 between" id="formulario">
                                <div class="col">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Editar Empleado
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form role="form">
                                                        <input type="hidden" id="edit_id_personal" name="id_personal" >
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="doc">Documento Identidad</label>
                                                                <div class="form-group">
                                                                    <input id="edit_doc" name="doc" class="form-control" placeholder="Documento Identidad">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="fecha_nac">Fecha Nacimiento</label>
                                                                    <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                        <input id="edit_fecha_nac" name="fecha_nac" class="form-control" size="30" type="text" value="" placeholder="Fecha de Nacimiento">
                                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                    </div>
                                                                    <input type="hidden" id="dtp_input2" value="" />
                                                                </div>
                                                            </div>                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nombre">Nombre</label>
                                                            <input id="edit_nombre" name="nombre" class="form-control" placeholder="Nombres y Apellidos">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="dir">Dirección</label>
                                                            <input id="edit_dir" name="dir" class="form-control" placeholder="Dirección ">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                               <div class="form-group">
                                                                    <label for="tel">Teléfono</label>
                                                                    <input id="edit_tel" name="tel" class="form-control" placeholder="Teléfono">
                                                                </div> 
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="cel">Celular</label>
                                                                    <input id="edit_cel" name="cel" class="form-control" placeholder="Celular">
                                                            </div>
                                                            </div>                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Correo Electrónico</label>
                                                            <input id="edit_email" name="email" type="email" class="form-control" placeholder="Correo Electrónico">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <?php
                                                                        $con = start_connect();
                                                                        if( $con )
                                                                        {
                                                                          $query = "SELECT * FROM eps";
                                                                          $resultado = mysqli_query($con, $query);
                                                                    ?>
                                                                    <label for="eps">EPS</label>
                                                                    <select id="edit_eps" name="eps" class="form-control">
                                                                      <option value="NULL" selected="true" >EPS</option>
                                                                      <?php
                                                                          while( $row = mysqli_fetch_array( $resultado ) )
                                                                              {
                                                                                echo '<option value="'.$row['id_eps'].'">'.utf8_encode($row['nombre']).'</option>';
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
                                                                    <?php
                                                                        $con = start_connect();
                                                                        if( $con )
                                                                        {
                                                                          $query = "SELECT * FROM arl";
                                                                          $resultado = mysqli_query($con, $query);
                                                                    ?>
                                                                    <label for="arl">ARL</label>
                                                                    <select id="edit_arl" name="arl" class="form-control">
                                                                      <option value="NULL" selected="true" >ARL</option>
                                                                      <?php
                                                                          while( $row = mysqli_fetch_array( $resultado ) )
                                                                              {
                                                                                echo '<option value="'.$row['id_arl'].'">'.utf8_encode($row['nombre']).'</option>';
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
                                                                  <?php
                                                                      $con = start_connect();
                                                                      if( $con )
                                                                      {
                                                                        $query = "SELECT * FROM pension";
                                                                        $resultado = mysqli_query($con, $query);
                                                                  ?>
                                                                  <label for="edit_pension">Pension</label>
                                                                  <select id="edit_pension" name="edit_pension" class="form-control">
                                                                    <option value="NULL" selected="true" >Pensiones</option>
                                                                    <?php
                                                                        while( $row = mysqli_fetch_array( $resultado ) )
                                                                            {
                                                                              echo '<option value="'.$row['id_pension'].'">'.utf8_encode($row['nombre']).'</option>';
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
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="fecha_ingreso">Fecha Ingreso</label>
                                                                    <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                        <input id="edit_fecha_ingreso" name="fecha_ingreso" class="form-control" size="30" type="text" value="" placeholder="Fecha de Ingreso">
                                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                    </div>
                                                                    <input type="hidden" id="dtp_input2" value="" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                
                                                            </div>                                            
                                                        </div>  
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="estado_civil">Estado Civil</label>
                                                                    <select id="edit_estado_civil" name="estado_civil" class="form-control">
                                                                        <option value="" disabled selected >Estado Civil</option>
                                                                        <option value="Soltero">Soltero</option>
                                                                        <option value="Casado">Casado</option>
                                                                        <option value="union-libre">Union Libre</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="hijos">Hijos</label>
                                                                    <input type="number" id="edit_hijos" name="hijos" class="form-control" placeholder="Nro. de Hijos">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="cuenta">Cuenta</label>
                                                                    <input id="edit_cuenta" name="cuenta" class="form-control" placeholder="Cuenta Nro.">
                                                                </div>
                                                            </div>                                             
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

  <!-- Modal Sppinner -->
  <div class="modal fade" id="modalSpinner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="demo">
      <svg class="loader">
        <filter id="blur">
          <fegaussianblur in="SourceGraphic" stddeviation="2"></fegaussianblur>
        </filter>
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#F4F519" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-2">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#DE2FFF" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-3">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#FF5932" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-4">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#E97E42" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-5">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="white" stroke-width="6" stroke-linecap="round" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-6">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#00DCA3" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-7">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="purple" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
      <svg class="loader loader-8">
        <circle cx="75" cy="75" r="60" fill="transparent" stroke="#AAEA33" stroke-width="6" stroke-linecap="round" stroke-dasharray="385" stroke-dashoffset="385" filter="url(#blur)"></circle>
      </svg>
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- / Modal Spinner -->
<?php include "footer.php";?>
