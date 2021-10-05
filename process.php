<?php
// include("connect.php");
// if($_GET['id_maquinas_herramientas'] and $_GET['nombre'])
// {
// 	$id_maquinas_herramientas = $_GET['id_maquinas_herramientas'];
// 	$nombre = $_GET['nombre'];
// 	if(mysql_query("UPDATE information SET nombre='$data' WHERE id_maquinas_herramientas='$id_maquinas_herramientas'"))
// 	echo 'success';
// }
//
	include("functions.php");
	$con = start_connect();

	if( $con )
  {
		$id = $_GET['id_maquinas_herramientas'];
		$data = $_GET['nombre'];
    $query = "UPDATE maquinas_herramientas SET nombre='$data' WHERE id_maquinas_herramientas='$id'";
    $resultado = mysqli_query($con, $query);

    if($_GET['id_maquinas_herramientas'] and $_GET['nombre'])
		{
			if(mysqli_query($con, $query))
			echo 'success';
		}

    if( !close_bd($con) )
    {
      echo "Error al cerrar la BDD";
    }
  }else{
    echo "Error de conexión a la BDD:". mysqli_connect_error();
	}


 ?>
