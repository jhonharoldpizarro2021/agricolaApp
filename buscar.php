<?php
	include "functions.php";
	$conexion = start_connect();
	$consultaBusqueda = $_POST['textoBusqueda'];
	$idFinca = $_POST['finca'];
	$nFinca = $_POST['nFinca'];
	$idSuerte = $_POST['suerte'];
	$nSuerte = $_POST['nSuerte'];
	//Variable vacía (para evitar los E_NOTICE)
	$mensaje = "";
	$consulta = mysqli_query($conexion, "SELECT * FROM qr_produccion WHERE finca = '". $_POST["finca"] ."' AND  idUnidadAgricola = '". $_POST["suerte"] ."' AND codigoCorte = '". $_POST["textoBusqueda"] ."' 
	");
	//Obtiene la cantidad de filas que hay en la consulta
	$filas = mysqli_num_rows($consulta);
	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	if ($filas === 0) 
		{
			$mensaje2 = '
                    <p>El corte # '. $consultaBusqueda . ' ' .$nFinca. ' ' .$nSuerte. ' no existe. Por favor ingresar los datos para crearlo</p>
                    <div class="form-group">
                      <label for="area">Area</label>
                      <input id="area" name="area" class="form-control" placeholder="area" >
                    </div>
                    <div class="form-group">
                      <label for="descripcion">Descripcion</label>
                      <input id="descripcion" name="descripcion" class="form-control" placeholder="descripcion" >
                    </div>
                    <div class="form-group">
                        <label for="variedad">Variedad</label>
                        <input id="variedad" name="variedad" class="form-control" placeholder="variedad" >
                    </div>
                    <button type="button" onclick="nuevoResultadoProduccion()" id="form-submit" class="btn btn-default pull-right ">Crear</button>
                    <div id="msgSubmit" class="h3 text-center hidden">Creado!</div>
                  ';
		} 
	else if ($filas > 0)
		{
			$resultados = mysqli_fetch_array($consulta);
					$idProduccion = $resultados['idProduccion'];
					$suerte = $resultados['nombre_unidad_agricola'];
					$finca = $resultados['nombre_finca'];
					$descripcion = $resultados['descripcion'];
					$area = $resultados['area'];
					$variedad = $resultados['variedad'];
					//Output
					$mensaje .= '
				       	<div class="row" id="msj">
				       		<input type="hidden" value="'. $idProduccion .'" id="idProduccion" >
					       	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
		                        <div class="form-group">
		                        	<label for="area">Area:</label>
		                        	<input id="area" name="area" class="form-control" value="'.$area.'" >
		                        </div>
		                    </div>
		                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
		                        <div class="form-group">
		                        	<label for="descripcion">Descripción:</label>
		                        	<input id="descripcion" name="descripcion" class="form-control" value="'.$descripcion.'" >
		                        </div>
		                    </div>
		                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
		                        <div class="form-group">
		                        	<label for="variedad">Variedad:</label>
		                            <input id="variedad" name="variedad" class="form-control" value="'.$variedad.'" >
		                        </div>
		                    </div>
                      	</div>
					';
			echo $mensaje;
		}; //Fin else $filas
	//Devolvemos el mensaje que tomará jQuery
	echo $mensaje2;
?>
