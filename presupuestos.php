<?php include "header.php";?>   
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Presupuestos</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            PRESUPUESTOS
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form">                                        
                                        <div class="row">
                                           <div class="col-lg-5">
                                                <div class="form-group">
                                                    <!-- <label>Codigo</label>  -->
                                                    <input class="form-control" placeholder="Código" >
                                                    <!-- <p class="help-block">Example block-level help text here.</p> -->
                                                </div>
                                                <div class="form-group">
                                                    <?php
                                                        $con = start_connect();
                                                        if( $con )
                                                        {
                                                          $query = "SELECT id_unidades_agricolas,nombre FROM  unidades_agricolas";
                                                          $resultado = mysqli_query($con, $query);
                                                    ?>
                                                    <select id="unidades_agricolas" name="unidades_agricolas" class="form-control">
                                                      <option value="NULL" disabled selected="true" >Unidad Agricola</option>
                                                      <?php
                                                          while( $row = mysqli_fetch_array( $resultado ) )
                                                              {
                                                                echo '<option value="'.$row['id_unidades_agricolas'].'">'.$row['nombre'].'</option>';
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
                                                      $query = "SELECT id_labores,descripcion_corta FROM  labores";
                                                      $resultado = mysqli_query($con, $query);
                                                ?>
                                                <select id="unidades_agricolas" name="unidades_agricolas" class="form-control">
                                                  <option value="NULL" disabled selected="true" >Labor a Realizar</option>
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
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="6" placeholder="Comentarios"></textarea>
                                                </div>                                            
                                            </div> 
                                        </div>
                                        <div class="row container text-center">
                                            <button type="submit" class="btn btn-default">FINALIZAR LABOR</button>    
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DataTables Advanced Tables
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover " id="tabla">
                                    <thead>
                                        <tr>
                                            <th>Labor</th>
                                            <th>Fecha de Inicio</th>
                                            <th>último status</th>
                                            <th>Terminado?</th>
                                            <th>Maquinaria</th>
                                            <th>Insumos</th>
                                            <th>Costos Ind.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class=" gradeX">
                                            <td>Despaje </td>
                                            <td>15-04-2016</td>
                                            <td>Realizada</td>
                                            <td class="center">4</td>
                                            <td class="center">Ver</td>
                                            <td class="center">Ver</td>
                                            <td class="center">Ver</td>
                                        </tr>
                                        <tr class=" gradeX">
                                            <td>Subsuelo </td>
                                            <td>15-05-2016</td>
                                            <td>En Curso</td>
                                            <td class="center">4</td>
                                            <td class="center">Ver</td>
                                            <td class="center">Ver</td>
                                            <td class="center">Ver</td>
                                        </tr>
                                        <tr class=" gradeX">
                                            <td>Cincel </td>
                                            <td>15-06-2016</td>
                                            <td>En espera de l</td>
                                            <td class="center">4</td>
                                            <td class="center">Ver</td>
                                            <td class="center">Ver</td>
                                            <td class="center">Ver</td>
                                        </tr>
                                        <tr class=" gradeX">
                                            <td>Resiembra </td>
                                            <td>15-07-2016</td>
                                            <td>Sin Novedad</td>
                                            <td class="center">4</td>
                                            <td class="center">Ver</td>
                                            <td class="center">Ver</td>
                                            <td class="center">Ver</td>
                                        </tr>
                                        <tr class=" gradeX">
                                            <td>Geolocalizacion </td>
                                            <td>15-04-2016</td>
                                            <td>Realizada</td>
                                            <td class="center">4</td>
                                            <td class="center">Ver</td>
                                            <td class="center">Ver</td>
                                            <td class="center">Ver</td>
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
            <!-- /.row -->            
<?php include "footer.php";?>              