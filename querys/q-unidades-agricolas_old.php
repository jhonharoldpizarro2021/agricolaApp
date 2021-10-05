<?php
  session_start();
  ob_start();
$retorno = array();
if( $_POST )
{
  include "../functions.php";
  $con = start_connect();
  if( $con )
  {
    switch ( $_POST["opcion"])
    {
      case '1': //Insertar
          $query = "INSERT INTO unidades_agricolas (nombre,id_padre,codigo,descripcion_ampliada,area)
                    VALUES('". utf8_decode($_POST["nombre"]) ."','". $_POST["id_padre"] ."','". $_POST["codigo"] ."','". utf8_decode($_POST["descp"]) ."','". $_POST["area"] ."')";
          $resultado = mysqli_query($con, $query);
            if( $resultado ) //Se realizó el registro
            {
              $retorno["estado"] = "OK";
            }else //Error al actualizar
            {
              $retorno["estado"] = "ERROR";
              $retorno["msg"] = mysqli_error($con);
            }
        break;
      case '2': //Actualizar
          if( empty($_POST["nombre"]) || empty($_POST["id_padre"]) || empty($_POST["codigo"]) || empty($_POST["descp"]) || empty($_POST["area"]) || empty($_POST["id"])  )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }else{
            $query = "UPDATE unidades_agricolas SET nombre='". utf8_decode($_POST["nombre"]) ."',codigo= '". $_POST["codigo"] ."',id_padre='". $_POST["id_padre"] ."',
                      descripcion_ampliada='". utf8_decode($_POST["descp"]) ."',area='". $_POST["area"] ."' WHERE id_unidades_agricolas='". $_POST["id"] ."'";
            $resultado = mysqli_query($con, $query);
            if( $resultado ) //Se realizó el registro
            {
              $retorno["estado"] = "OK";
            }else //Error al actualizar
            {
              $retorno["estado"] = "ERROR";
              $retorno["msg"] = mysqli_error($con);
            }
          }
        break;
      case '3':
          //Borrar
          $query = "DELETE FROM unidades_agricolas WHERE id_unidades_agricolas='". $_POST["id"] ."'";
          $resultado = mysqli_query($con, $query);
          if( $resultado ) //Se realizó el registro
          {
            $retorno["estado"] = "OK";
          }else //Error al actualizar
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = mysqli_error($con);
          }
        break;
      case '4':
          //Consultar todos
          $query = "SELECT * FROM unidades_agricolas";
          $resultado = mysqli_query($con, $query);
          $unidades = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $unidades[] = array(
                                  "id" => $row["id_unidades_agricolas"],
                                  "nombre" => utf8_encode($row["nombre"]),
                                  "id_padre" => $row["id_padre"],
                                  "codigo" => $row["codigo"],
                                  "descp" => utf8_encode($row["descripcion_ampliada"]),
                                  "area" => $row["area"]
                                );
          }

          if( count($unidades) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["unidades"] = $unidades;
          }else{
            $retorno["estado"] = "EMPTY";
          }
      break;
      default:
        # code...
        break;
    }
    if( !close_bd($con) )
    {
      $retorno["msg"] = "Error al cerrar la conexión a la BDD";
    }
  }else
  {
    $retorno["estado"] = "ERROR";
    $retorno["msg"] = "Error de conexión a la BDD:". mysqli_connect_error();
  }
}else
{
  $retorno["estado"] = "ERROR";
  $retorno["msg"] = "Parámetros no encontrados";
}
echo json_encode( $retorno );

?>
