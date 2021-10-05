<?php
	include "functions.php";
	$conexion = start_connect();
	$id_finca = $_POST['id_finca'];
	$result = $conexion->query(" SELECT id_estaciones_pluviometria,descripcion FROM estaciones_pluviometria WHERE unidades_agricolas_id_unidades_agricolas = ".$id_finca." ORDER BY descripcion ASC ");
	$html = '<option value="NULL" disabled selected="true" >Seleccione la Estaci&oacute;n</option>';
	if ($result->num_rows > 0) {
	    while ($row = $result->fetch_assoc()) {                
	        $html .= '<option value="'.$row['id_estaciones_pluviometria'].'">'. utf8_encode($row['descripcion']) .'</option>';
	    }
	}
	echo $html;
?>