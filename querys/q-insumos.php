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
          $query = "INSERT INTO insumos (descripcion,fecha_compra,comentarios,unidades_medida_id_unidades_medida,proveedor_id_proveedor) 
                    VALUES('". utf8_decode($_POST["descripcion"]) ."','". $_POST["fecha_compra"] ."','". utf8_decode($_POST["comentarios"]) ."','". $_POST["unidades_medida_id_unidades_medida"] ."','". $_POST["proveedor_id_proveedor"] ."')";
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
          if( empty($_POST["descripcion"]) ||  empty($_POST["fecha_compra"]) )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }else{
            $query = "UPDATE insumos SET descripcion='". utf8_decode($_POST["descripcion"]) ."',fecha_compra= '". $_POST["fecha_compra"] ."',comentarios='". utf8_decode($_POST["comentarios"]) ."',unidades_medida_id_unidades_medida='". $_POST["unidades_m"] ."',proveedor_id_proveedor='". $_POST["id_proveedor"] ."'WHERE id_insumos='". $_POST["id_insumos"] ."'";
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
          $query = "DELETE FROM insumos WHERE id_insumos='". $_POST["id_insumos"] ."'";
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
          $query = "SELECT * FROM qr_insumos";
          $resultado = mysqli_query($con, $query);
          $insumos = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $insumos[] = array(
                                  "id_insumos" => $row["id_insumos"],
                                  "descripcion" => utf8_encode($row["descripcion"]),
                                  "nombre_proveedor" => utf8_encode($row["nombre_proveedor"]),
                                  "desc_unidades_medida" => utf8_encode($row["desc_unidad_medida"]),
                                  "fecha_compra" => $row["fecha_compra"],
                                  "comentarios" => utf8_encode($row["comentarios"]),
                                  "unidades_m" => $row["id_unidad_medida"],
                                  "id_proveedor" => $row["id_proveedor"]
                                );
          }

          if( count($insumos) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["insumos"] = $insumos;
          }else{
            $retorno["estado"] = "EMPTY";
          }
        break;
      case "5":
          $query = "UPDATE insumos SET ". $_POST["campo_query"] ."='". $_POST["valor_query"] ."' WHERE id_insumos='". $_POST["id"] ."'";

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
      case "6":
          // para seguir la seccuencia de los otros archivos se deja este en blanco debido a que la consulta que habia aqui no sirve.
        break;
      case '7':
          //Consultar todos
          $query = "SELECT * FROM proveedor";
          $resultado = mysqli_query($con, $query);
          $insumos = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $insumos[] = array(
                                  "id" => $row["id_proveedor"],
                                  "nombre" => utf8_decode($row["nombre"]),
                                );
          }

          if( count($insumos) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["insumos"] = $insumos;
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
