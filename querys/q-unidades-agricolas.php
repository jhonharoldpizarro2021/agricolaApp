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
          if( $_POST["id_padre"] == "NULL")
          {
            $query = "INSERT INTO unidades_agricolas (nombre,codigo,descripcion_ampliada,area)
                      VALUES('". utf8_decode($_POST["nombre"]) ."','". $_POST["codigo"] ."','". utf8_decode($_POST["descp"]) ."','". utf8_decode($_POST["area"]) ."')";
          }else{
            $query = "INSERT INTO unidades_agricolas (nombre,id_padre,codigo,descripcion_ampliada,area)
                      VALUES('". utf8_decode($_POST["nombre"]) ."','". $_POST["id_padre"] ."','". $_POST["codigo"] ."','". utf8_decode($_POST["descp"]) ."','". utf8_decode($_POST["area"]) ."')";
          }
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
          if( empty($_POST["nombre"]) ||  empty($_POST["codigo"]) )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }else{
            if( $_POST["id_padre"] == "NULL")
            {
              $query = "UPDATE unidades_agricolas SET nombre='". utf8_decode($_POST["nombre"]) ."',codigo= '". $_POST["codigo"] ."',descripcion_ampliada='". utf8_decode($_POST["descp"])
                        ."',area='". utf8_decode($_POST["area"]) ."' WHERE id_unidades_agricolas='". $_POST["id"] ."'";
            }else{
              $query = "UPDATE unidades_agricolas SET nombre='". utf8_decode($_POST["nombre"]) ."',id_padre='". $_POST["id_padre"] ."',codigo= '". $_POST["codigo"] ."',
                        descripcion_ampliada='". utf8_decode($_POST["descp"]) ."',area='". utf8_decode($_POST["area"]) ."' WHERE id_unidades_agricolas='". $_POST["id"] ."'";
            }
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
          $query = "SELECT a.*, b.nombre AS nombre_padre FROM unidades_agricolas AS a
                    LEFT JOIN unidades_agricolas AS b ON a.id_padre=b.id_unidades_agricolas";
          $resultado = mysqli_query($con, $query);
          $unidades = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $unidades[] = array(
                                  "id" => $row["id_unidades_agricolas"],
                                  "nombre" => utf8_encode( $row["nombre"] ),
                                  "id_padre" => $row["id_padre"] == null ? '' : $row["id_padre"],
                                  "nombre_padre" => $row["nombre_padre"] == null ? '' : utf8_encode($row["nombre_padre"]),
                                  "codigo" => $row["codigo"],
                                  "descp" => utf8_encode( $row["descripcion_ampliada"] ),
                                  "area" => utf8_encode( $row["area"] )
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
       case '5':
        //Editar campo
        $query = "UPDATE unidades_agricolas SET ". $_POST["campo_query"] ."='". $_POST["valor_query"] ."' WHERE id_unidades_agricolas='". $_POST["id"] ."'";

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
      case '6':
        //Consultar lista Unidades
        $query = "SELECT id_unidades_agricolas, nombre FROM unidades_agricolas ORDER BY nombre ASC";
        $resultado = mysqli_query($con, $query);
        $unidades = array();
        while( $row = mysqli_fetch_array( $resultado ) )
        {
          $unidades[] = array(
                                "id" => $row["id_unidades_agricolas"],
                                "descripcion" => utf8_encode( $row["nombre"] ),
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
