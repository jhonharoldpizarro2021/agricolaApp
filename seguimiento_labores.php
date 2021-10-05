<?php include "header.php"; ?>
  	<script type="text/javascript" src="js/seguimiento_labores.js?n=<?= time() ?>"></script>
  	<script type="text/javascript" src="js/geolocalizacion.js?n=<?= time() ?>"></script>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><i class="fa fa-eye fa-fw"></i> Seguimiento de Labores</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" id="datos">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <ul id="suertes">
                            	<?php
                                  $con = start_connect();
                                  if( $con )
                                  {
							        //Consultar 
							        $query = "SELECT * FROM qryFincasSeguimiento ORDER BY 'finca', 'idUnidadAgricola'";
                                    $resultado = mysqli_query($con, $query);
                                    while( $row = mysqli_fetch_array($resultado) ) 
                                    {
	                            		$idFinca = $row["id_finca"];
	                            		$idSuerte = $row["id_unidad_agricola"];
	                            		$nFinca = $row["nombre_finca"];
	                            		$nSuerte = $row["nombre_unidad_agricola"];
                                		?>
	                                    <li class="lista" >
	                                    	<a class="enlace"  onclick="corteActual( '<?= $idFinca?>','<?= $idSuerte?>','<?= $nFinca?>','<?= $nSuerte?>' )">
	                                    		<i class="fa fa-eye"></i>
	                                    	</a>
	                                    	<a class="enlace"  onclick="corteActual( '<?= $idFinca?>','<?= $idSuerte?>','<?= $nFinca?>','<?= $nSuerte?>' )"> <?= $nFinca?> / <?= $nSuerte?>
	                                    	</a>
	                                    </li>
	                            		<?php
                                    }
                                    if( !close_bd($con) )
                                    {
                                      echo "Error al cerrar la BDD";
                                    }
                                  }
                                  else{
                                    echo "Error de conexión a la BDD:". mysqli_connect_error();
                                  }
                                ?>
                            </ul>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="display: none;">
                            <div id="consulta">
								<div class="panel panel-warning">
			                        <div class="panel-heading segLab">
			                            <div class="row" >
			                                <div class="col-sm-12 col-md-12 col-lg-6">
			                                	<div class="row show-grid">
			                                		<div class="col-md-12">	
			                                			<div class="nom"><i>Finca: </i></div>
				                                		<div class="data"><h4><span id="finca"></span> &nbsp;&nbsp;&nbsp;</h4></div>
				                                		<span id="idFinca" style="display: none;"></span>
			                                		</div>
			                                	</div>
			                                </div>
			                                <div class="col-sm-12 col-md-12 col-lg-6">
			                                	<div class="row show-grid">
			                                		<div class="col-md-12">	
			                                			<div class="nom"><i>Unidad Agricola: </i></div>
				                                		<div class="data"><h4><span id="suerte"></span></h4></div>
				                                		<span id="idSuerte" style="display: none;"></span>
			                                		</div>
			                                	</div>
			                                </div>
			                            </div>
			                            <div class="row">
			                                <div class="col-sm-12 col-md-6 col-lg-3">
			                                	<div class="row show-grid">
			                                		<div class="col-md-12">	
			                                			<div class="nom"><i>Cosecha Actual: </i></div>
				                                		<div class="data"><h4><span id="corteActual"></span></h4></div>
			                                		</div>
			                                	</div>
			                                </div>
			                                <div class="col-sm-12 col-md-6 col-lg-3">
			                                	<div class="row show-grid">
			                                		<div class="col-md-12">	
			                                			<div class="nom"><i>Edad: </i></div>
				                                		<div class="data"><h4><span id="edadActual"></span></h4></div>
			                                		</div>
			                                	</div>
			                                </div>
			                                <div class="col-sm-12 col-md-6 col-lg-3">
			                                	<div class="row show-grid">
			                                		<div class="col-md-12">	
			                                			<div class="nom"><i>&Aacute;rea: </i></div>
				                                		<div class="data"><h4><span id="areaActual"></span><span id="has"></span></h4></div>
			                                		</div>
			                                	</div>
			                                </div>

			                                <div class="col-sm-12 col-md-6 col-lg-3">
			                                	<div class="row show-grid">
			                                		<span id="idProduccion" style="display: none;"></span>
			                                		<span id="idProduccionActual" style="display: none;"></span>
			                                		<div class="col-md-12">
			                                			<div class="nom"><i>Mapa: </i></div>
				                                		<div class="data"><h4><span id="geolocalizacion"></span></h4></div>
			                                		</div>
			                                	</div>
			                                </div>
			                                <div class="col-sm-12 col-md-6 col-lg-3">
			                                	<div class="row show-grid">
			                                		<span id="idProduccion" style="display: none;"></span>
			                                		<span id="idProduccionActual" style="display: none;"></span>
			                                		<div class="col-md-12">
			                                			<div class="nom"><i>Curvas de Nivel: </i></div>
				                                		<div class="data"><h4><span id="curvasNivel"></span></h4></div>
			                                		</div>
			                                	</div>
			                                </div>
			                                <div class="col-sm-12 col-md-6 col-lg-3">
			                                	<div class="row show-grid">
			                                		<div class="col-md-12">
			                                			<div class="nom"><i>Zona Agroecológica: </i></div>
				                                		<div class="data"><h4><span id="zonaAgro"></span></h4></div>
			                                		</div>
			                                	</div>
			                                </div>
			                                <div class="col-sm-12 col-md-6 col-lg-3">
			                                	<div class="row show-grid">
			                                		<span id="idProduccion" style="display: none;"></span>
			                                		<span id="idProduccionActual" style="display: none;"></span>
			                                		<div class="col-md-12">
			                                			<div class="nom"><i>Corte Anterior: </i></div>
				                                		<div class="data"><h4><span id="corte"></span></h4></div>
			                                		</div>
			                                	</div>
			                                </div>
			                                <div class="col-sm-12 col-md-6 col-lg-3">
			                                	<div class="row show-grid">
			                                		<div class="col-md-12">
			                                			<div class="nom"><i>Fecha Cosecha: </i></div>
				                                		<div class="data"><h4><span id="fechaCosecha"></span></h4></div>
			                                		</div>
			                                	</div>
			                                </div>

			                                <div class="col-xs-6 col-md-6 col-lg-4">
			                                	<div class="row show-grid">
	                                			<div class="col-md-12">
			                                	<div class="nom"><i>Variedad: </i></div>
			                                	<div class="data"><h4><span id="variedad"></span></h4></div>
			                                	</div>
			                                	</div>
			                                </div>
			                                <div class="col-xs-6 col-md-6 col-lg-4">
				                                <div class="row show-grid">
		                                		<div class="col-md-12">
			                                	<div class="nom"><i>Edad: </i></div>
			                                	<div class="data"><h4><span id="edad"></span></h4></div>
			                                	</div>
			                                	</div>
			                                </div>
			                                <div class="col-xs-6 col-md-6 col-lg-4">
			                                	<div class="row show-grid">
		                                		<div class="col-md-12">
			                                	<div class="nom"><i>TCT: </i></div>
			                                	<div class="data"><h4><span id="tct"></span></h4></div>
			                                	</div>
			                                	</div>
			                                </div>
			                                <div class="col-xs-6 col-md-6 col-lg-4">
			                                	<div class="row show-grid">
		                                		<div class="col-md-12">
			                                	<div class="nom"><i>TCH: </i></div>
			                                	<div class="data"><h4><span id="tch"></span></h4></div>
			                                	</div>
			                                	</div>
			                                </div>
			                                <div class="col-xs-6 col-md-6 col-lg-4">
			                                	<div class="row show-grid">
		                                		<div class="col-md-12">
			                                	<div class="nom"><i>TCHM:</i> </div>
			                                	<div class="data"><h4><span id="tchm"></span></h4></div>
			                                	</div>
			                                	</div>
			                                </div>
			                                <div class="col-xs-6 col-md-6 col-lg-4">
			                                	<div class="row show-grid">
		                                		<div class="col-md-12">
			                                	<div class="nom"><i>Rendimiento:</i></div>
			                                	<div class="data"><h4><span id="rendimiento"></span></h4></div>
			                                	</div>
			                                	</div>
			                                </div>

			                                <div class="col-md-12">
			                                	<div class="row">
					                                <div class="col-xs-12 col-md-6">
					                                	<div class="row show-grid">
			                                			<div class="col-md-12">
					                                	<div class="nom"><i>COSTOS DIRECTOS POR HECTAREA: </i></div>
					                                	<div class="data"><h4><span id="costosDirectos"></span></h4></div>
					                                	</div>
					                                	</div>
					                                </div>
					                                <div class="col-xs-12 col-md-6">
						                                <div class="row show-grid">
				                                		<div class="col-md-12">
					                                	<div class="nom"><i>COSTOS INDIRECTOS POR HECTAREA: </i></div>
					                                	<div class="data"><h4><span id="costosIndirectos"></span></h4></div>
					                                	</div>
					                                	</div>
					                                </div>
					                                <div class="col-xs-12 col-md-12">
					                                	<div class="row show-grid">
				                                		<div class="col-md-12">
					                                	<div class="nom"><i>COSTOS TOTALES POR HECTAREA: </i></div>
					                                	<div class="data"><h4><span id="costosTotales"></span></h4></div>
					                                	</div>
					                                	</div>
					                                </div>
					                            </div>
			                                </div>
			                            </div>
			                        </div>
			                        <!-- /.panel-heading -->
			                        <div class="panel-body" id="datosCorteAnterior">
			                        	<div class="panel-group" id="accordion">
			                        	</div>
			                       </div>
			                        <!-- /.panel-body -->
			                    </div>
			                    <!-- /.panel -->
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->



            <!-- Modal Geolocalizacion-->
            <div class="modal fade" id="mygeolocalizacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><i class="fa fa-wrench fa-fw"></i> Geolocalizacion</h4>
                        </div>
                        <div class="modal-body">
                            <div class="mapa">
	                            <div id="content_mapa" style="width:100%;height:100%;"></div>
	                        </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

  <!-- Modal Sppinner -->
  <div class="modal fade" id="modalSpinner" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="background: rgba(255,255,255,0.8)">
    <div class="load">
	  <div class="gear one">
	    <svg id="blue" viewbox="0 0 100 100" fill="#80B419">
	      <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>
	    </svg>
	  </div>
	  <div class="gear two">
	    <svg id="pink" viewbox="0 0 100 100" fill="sienna">
	      <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>
	    </svg>
	  </div>
	  <div class="gear three">
	    <svg id="yellow" viewbox="0 0 100 100" fill="#6B8E23">
	      <path d="M97.6,55.7V44.3l-13.6-2.9c-0.8-3.3-2.1-6.4-3.9-9.3l7.6-11.7l-8-8L67.9,20c-2.9-1.7-6-3.1-9.3-3.9L55.7,2.4H44.3l-2.9,13.6      c-3.3,0.8-6.4,2.1-9.3,3.9l-11.7-7.6l-8,8L20,32.1c-1.7,2.9-3.1,6-3.9,9.3L2.4,44.3v11.4l13.6,2.9c0.8,3.3,2.1,6.4,3.9,9.3      l-7.6,11.7l8,8L32.1,80c2.9,1.7,6,3.1,9.3,3.9l2.9,13.6h11.4l2.9-13.6c3.3-0.8,6.4-2.1,9.3-3.9l11.7,7.6l8-8L80,67.9      c1.7-2.9,3.1-6,3.9-9.3L97.6,55.7z M50,65.6c-8.7,0-15.6-7-15.6-15.6s7-15.6,15.6-15.6s15.6,7,15.6,15.6S58.7,65.6,50,65.6z"></path>
	    </svg>
	  </div>
	  <div class="lil-circle"></div>
	  <!-- <svg class="blur-circle">
	    <filter id="blur">
	      <fegaussianblur in="SourceGraphic" stddeviation="13"></fegaussianblur>
	    </filter>
	    <circle cx="70" cy="70" r="66" fill="transparent" stroke="rgba(255,255,255,0.1)" stroke-width="40" filter="url(#blur)"></circle>
	  </svg> -->
	</div>
	<div class="text"><h2>Buscando....</h2></div>
    <!-- /.modal-dialog -->
  </div>
  <!-- / Modal Spinner --> 



<?php include "footer.php";?>
