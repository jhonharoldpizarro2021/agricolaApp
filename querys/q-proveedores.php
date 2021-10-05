<?php
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
          $query = "INSERT INTO proveedor (nombre,nit,direccion,telefono,email,comentarios)
                      VALUES('". utf8_decode($_POST["nombre"]) ."','". $_POST["nit"] ."','". utf8_decode($_POST["direccion"]) ."','". $_POST["telefono"] ."','". $_POST["email"] ."','". utf8_decode($_POST["comentarios"]) ."')";
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
          if( empty($_POST["nombre"]) || empty($_POST["nit"])  || empty($_POST["telefono"]))
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }else{
            $query = "UPDATE proveedor SET nombre=?, nit =?, direccion=?, telefono=?, email=?, comentarios=? WHERE id_proveedor=?";
            $st = $con->prepare($query); //Statement
            if( $st )
            {
              $nombre = utf8_decode( $_POST["nombre"] );
              $nit = $_POST["nit"];
              $direccion = $_POST["direccion"] == "NULL" ? null : utf8_decode( $_POST["direccion"]);
              $telefono = $_POST["telefono"] == "NULL" ? null : $_POST["telefono"];
              $email = $_POST["email"];
              $comentarios = utf8_decode($_POST["comentarios"]);
              $id = $_POST["id_proveedor"];

              $param = $st->bind_param("ssssssi", $nombre, $nit, $direccion, $telefono, $email, $comentarios, $id);
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
          $query = "DELETE FROM proveedor WHERE id_proveedor='". $_POST["id_proveedor"] ."'";
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
          $query = "SELECT * FROM proveedor";
          $resultado = mysqli_query($con, $query);
          $proveedores = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $proveedores[] = array(
                                  "id_proveedor" => $row["id_proveedor"],
                                  "nombre" => utf8_encode( $row["nombre"] ),
                                  "nit" => $row["nit"],
                                  "direccion" => utf8_encode( $row["direccion"]),
                                  "telefono" => $row["telefono"],
                                  "email" => $row["email"],
                                  "comentarios" => utf8_encode($row["comentarios"])
                                );
          }

          if( count($proveedores) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["proveedores"] = $proveedores;
          }else{
            $retorno["estado"] = "EMPTY";
          }
        break;
      case '5':
        //Editar campo
        $query = "UPDATE proveedor SET ". $_POST["campo_query"] ."='". $_POST["valor_query"] ."' WHERE id_proveedor='". $_POST["id"] ."'";

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
