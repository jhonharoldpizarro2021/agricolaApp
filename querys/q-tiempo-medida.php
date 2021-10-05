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
      case '1': //Agregar nueva Unidad de Medida
          $query = "INSERT INTO unidades_tiempo_medida (descripcion)
                      VALUES('". utf8_decode($_POST["descripcion"]) ."')";
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
          if( empty($_POST["descripcion"]) )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }else{
            $query = "UPDATE unidades_tiempo_medida SET descripcion=? WHERE id_unidades_tiempo_medida=?";
            $st = $con->prepare($query); //Statement
            if( $st )
            {
              $desc = utf8_decode( $_POST["descripcion"] );
              $id = $_POST["id_unidades_tiempo_medida"];

              $param = $st->bind_param("si", $desc, $id);
              if( $param )
              {
                if( $st->execute() ) //Se realizó la actualización
                {
                  $retorno["estado"] = "OK";
                }else{
                  $retorno["estado"] = "ERROR";
                  $retorno["msg"] = "Error al ejecutar la sentencia:". $st->errno .":". $st->error;
                }
              }else{
                $retorno["estado"] = "ERROR";
                $retorno["msg"] = "Error al vincular los parametros:". $st->errno .":". $st->error;
              }
              //Cerrar sentencia
              $st->close();
            }else{
              $retorno["estado"] = "ERROR";
              $retorno["msg"] = "Error al preparar la sentencia:". mysqli_connect_error();
            }
          }
        break;
      case '3':
          //Borrar
          $query = "DELETE FROM unidades_tiempo_medida WHERE id_unidades_tiempo_medida='". $_POST["id_unidades_tiempo_medida"] ."'";
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
          $query = "SELECT * FROM unidades_tiempo_medida";
          $resultado = mysqli_query($con, $query);
          $tiempo = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $tiempo[] = array(
                                  "id_unidades_tiempo_medida" => $row["id_unidades_tiempo_medida"],
                                  "descripcion" => utf8_encode( $row["descripcion"] )
                                );
          }
          if( count($tiempo) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["tiempo"] = $tiempo;
          }else{
            $retorno["estado"] = "EMPTY";
          }
        break;
      case '5':
        //Editar campo
        $query = "UPDATE unidades_tiempo_medida SET ". $_POST["campo_query"] ."='". $_POST["valor_query"] ."' WHERE id_unidades_tiempo_medida='". $_POST["id"] ."'";

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
