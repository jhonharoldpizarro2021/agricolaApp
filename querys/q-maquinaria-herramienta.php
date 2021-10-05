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
          $query = "INSERT INTO maquinas_herramientas (nombre,fecha_compra,codigo,lapso_mantenimiento,unidades_tiempo_medida_id_unidades_tiempo_medida,fecha_ultimo_mantenimiento,comentario,proveedor_id_proveedor)
                      VALUES('". utf8_decode($_POST["nombre"]) ."','". $_POST["fecha_compra"] ."','". $_POST["codigo"] ."','". $_POST["lapso_mantenimiento"] ."','". $_POST["unidades_t"] ."','". $_POST["fecha_ultimo_mantenimiento"] ."','". utf8_decode($_POST["comentario"]) ."','". $_POST["proveedor_id_proveedor"] ."')";
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
          if( empty($_POST["nombre"]) ||  empty($_POST["fecha_compra"]) )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }else{
            if( $_POST["unidades_t_m"] == "NULL")
            {
              $query = "UPDATE maquinas_herramientas SET nombre='". utf8_decode($_POST["nombre"]) ."',fecha_compra= '". $_POST["fecha_compra"] ."',codigo='". $_POST["codigo"] ."',lapso_mantenimiento='". $_POST["lapso_mantenimiento"] ."',fecha_ultimo_mantenimiento='". $_POST["fecha_ultimo_mantenimiento"] ."',comentario='". utf8_decode($_POST["comentario"]) ."',proveedor_id_proveedor='". $_POST["proveedor_id_proveedor"] ."' WHERE id_maquinas_herramientas='". $_POST["id"] ."'";
            }else{
              $query = "UPDATE maquinas_herramientas SET nombre='". utf8_decode($_POST["nombre"]) ."',fecha_compra= '". $_POST["fecha_compra"] ."',codigo='". $_POST["codigo"] ."',lapso_mantenimiento='". $_POST["lapso_mantenimiento"] ."',unidades_tiempo_medida_id_unidades_tiempo_medida='". $_POST["unidades_t_m"] ."',fecha_ultimo_mantenimiento='". $_POST["fecha_ultimo_mantenimiento"] ."',comentario='". utf8_decode($_POST["comentario"]) ."',proveedor_id_proveedor='". $_POST["proveedor_id_proveedor"] ."' WHERE id_maquinas_herramientas='". $_POST["id"] ."'";
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
          $query = "DELETE FROM maquinas_herramientas WHERE id_maquinas_herramientas='". $_POST["id"] ."'";
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
          $query = "SELECT * FROM qr_maquinas_herramientas";
          $resultado = mysqli_query($con, $query);
          $maquinas = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $maquinas[] = array(
                                  "id" => $row["id_maquinas_herramientas"],
                                  "nombre" => utf8_encode($row["nombre"]),
                                  "fecha_compra" => $row["fecha_compra"],
                                  "codigo" => $row["codigo"],
                                  "lapso_mantenimiento" => $row["lapso_mantenimiento"],
                                  "id_unidades_t_m" => $row["unidades_tiempo_medida_id_unidades_tiempo_medida"],
                                  "fecha_ultimo_mantenimiento" => $row["fecha_ultimo_mantenimiento"],
                                  "comentario" => utf8_encode($row["comentario"]),
                                  "id_proveedor" => $row["proveedor_id_proveedor"],  
                                  "unidades_t_m" => utf8_encode($row["desc_unidad_tiempo"]),                                
                                  "nombre_proveedor" => utf8_encode($row["nombre_proveedor"])
                                );
          }
          if( count($maquinas) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["maquinas"] = $maquinas;
          }else{
            $retorno["estado"] = "EMPTY";
          }
        break;
      case "5":
          $query = "UPDATE maquinas_herramientas SET ". $_POST["campo_query"] ."='". $_POST["valor_query"] ."' WHERE id_maquinas_herramientas='". $_POST["id"] ."'";

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
          $maquinas = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $maquinas[] = array(
                                  "id" => $row["id_proveedor"],
                                  "nombre" => utf8_decode($row["nombre"]),
                                );
          }

          if( count($maquinas) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["maquinas"] = $maquinas;
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
