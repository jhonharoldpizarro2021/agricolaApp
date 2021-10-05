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
          $query = "INSERT INTO categorias_gastos_ci (tipo,descripcion)
                    VALUES('". $_POST["tipo"] ."','". utf8_decode($_POST["descripcion"]) ."')";
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
          if( empty($_POST["tipo"]) || empty($_POST["descripcion"]) )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }else{
            $query = "UPDATE categorias_gastos_ci SET tipo=?, descripcion=? WHERE idCategoria=?";
            $st = $con->prepare($query); //Statement
            if( $st )
            {
              $tipo = $_POST["tipo"];
              $desc = utf8_decode( $_POST["descripcion"] );
              $id = $_POST["id_Cat"];

              $param = $st->bind_param("isi", $tipo, $desc, $id);
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
          $query = "DELETE FROM categorias_gastos_ci WHERE idCategoria='". $_POST["id"] ."'";
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
          $query = "SELECT * FROM qr_categorias_gastos_ci";
          $resultado = mysqli_query($con, $query);
          $cat = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $cat[] = array(
                                  "id_cat" => $row["idCategoria"],
                                  "tipo" => $row["tipo"],
                                  "nombre_tipo" => utf8_encode($row["nombre_tipo"]),
                                  "descripcion" => utf8_encode($row["descripcion"])
                                );
          }
          if( count($cat) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["cat"] = $cat;
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
