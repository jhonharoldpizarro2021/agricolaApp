<?php
	include "functions.php";
	$conexion = start_connect();
	$id_padre = $_POST['id_padre'];
	$result = $conexion->query("SELECT id_unidades_agricolas,nombre FROM unidades_agricolas WHERE id_padre = ".$id_padre." ORDER BY nombre ASC");
	$html = '<option value="NULL" disabled selected="true" >Seleccione la Suerte</option>';
	if ($result->num_rows > 0) {
	    while ($row = $result->fetch_assoc()) {                
	        $html .= '<option value="'.$row['id_unidades_agricolas'].'">'.$row['nombre'].'</option>';
	    }
	}
	echo $html;
?>