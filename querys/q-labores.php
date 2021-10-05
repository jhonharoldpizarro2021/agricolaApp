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
          if( empty($_POST["descripcion_corta"]) || empty($_POST["id_labor_procedente"]) || empty($_POST["id_labor_posterior"]) || empty($_POST["cantidad_tiempo"]) || empty($_POST["unidades_tiempo"]) )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }else{
            $query = "INSERT INTO labores (descripcion_corta, descripcion_ampliada, id_labor_procedente, id_labor_posterior, cantidad_tiempo, unidades_tiempo_medida_id_unidades_tiempo_medida) VALUES(?,?,?,?,?,?)";
            $st = $con->prepare($query); //Statement
            if( $st )
            {
              $desc = utf8_decode( $_POST["descripcion_corta"] );
              $desc_amplia = utf8_decode( $_POST["descripcion_ampliada"] );
              $id_procedente = $_POST["id_labor_procedente"] == "NULL" ? null : $_POST["id_labor_procedente"];
              $id_posterior = $_POST["id_labor_posterior"] == "NULL" ? null : $_POST["id_labor_posterior"];
              $tiempo = $_POST["cantidad_tiempo"];
              $id_medida = $_POST["unidades_tiempo"] == "NULL" ? null : $_POST["unidades_tiempo"];

              //Pasar valores parametros Statement->prepare()
              //$st->bind_param(tipo dato, Datos);
              //tipo dato = s | i | d | b (String,Integer,Double,boolean)
              $param = $st->bind_param("ssiisi", $desc, $desc_amplia, $id_procedente, $id_posterior, $tiempo, $id_medida);
              if( $param )
              {
                if( $st->execute() ) //Se realizó el registro
                {
                  $retorno["estado"] = "OK";
                  $retorno["id_labores"] = $st->insert_id;
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
      case '2': //Actualizar
          if( empty($_POST["descripcion_corta"]) || empty($_POST["id_labor_procedente"]) || empty($_POST["id_labor_posterior"]) || empty($_POST["cantidad_tiempo"]) || empty($_POST["unidades_tiempo"]) || empty($_POST["id_labores"]) )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }else{
            $query = "UPDATE labores SET descripcion_corta=?, descripcion_ampliada =?, id_labor_procedente=?, id_labor_posterior=?, cantidad_tiempo=?,
                      unidades_tiempo_medida_id_unidades_tiempo_medida=? WHERE id_labores=?";
            $st = $con->prepare($query); //Statement
            if( $st )
            {
              $desc = utf8_decode( $_POST["descripcion_corta"] );
              $desc_amplia = utf8_decode( $_POST["descripcion_ampliada"] );
              $id_procedente = $_POST["id_labor_procedente"] == "NULL" ? null : $_POST["id_labor_procedente"];
              $id_posterior = $_POST["id_labor_posterior"] == "NULL" ? null : $_POST["id_labor_posterior"];
              $tiempo = $_POST["cantidad_tiempo"];
              $id_medida = $_POST["unidades_tiempo"] == "NULL" ? null : $_POST["unidades_tiempo"];
              $id = $_POST["id_labores"];

              $param = $st->bind_param("ssiisii", $desc, $desc_amplia, $id_procedente, $id_posterior, $tiempo, $id_medida, $id);
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
          $query = "DELETE FROM labores WHERE id_labores='". $_POST["id_labores"] ."'";
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
          $query = "SELECT * FROM qr_labores";
          $resultado = mysqli_query($con, $query);
          $labores = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $labores[] = array(
                                  "id_labores" => $row["id_labores"],
                                  "descripcion_corta" => utf8_encode( $row["descripcion_corta"] ),
                                  "descripcion_ampliada" => utf8_encode( $row["descripcion_ampliada"] ),
                                  "id_labor_procedente" => utf8_encode( $row["id_labor_procedente"] == null ? '' : $row["id_labor_procedente"]),
                                  "id_labor_posterior" => utf8_encode( $row["id_labor_posterior"] == null ? '' : $row["id_labor_posterior"]),
                                  "cantidad_tiempo" => $row["cantidad_tiempo"],
                                  "id_unidades_tiempo_medida" => $row["id_unidades_tiempo_medida"],
                                  "unidad_medida" => utf8_encode($row["unidad_medida"]),
                                  "desc_corta_labor_procedente" => $row["desc_corta_labor_procedente"] == null ? '' : utf8_encode($row["desc_corta_labor_procedente"]),
                                  "desc_corta_labor_posterior" => $row["desc_corta_labor_posterior"] == null ? '' : utf8_encode($row["desc_corta_labor_posterior"])
                                );
          }

          if( count($labores) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["labores"] = $labores;
          }else{
            $retorno["estado"] = "EMPTY";
          }
        break;
      case '5':
        //Editar campo
        $query = "UPDATE labores SET ". $_POST["campo_query"] ."='". $_POST["valor_query"] ."' WHERE id_labores='". $_POST["id"] ."'";

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
        //Consultar lista labores
        $query = "SELECT id_labores, descripcion_corta FROM labores ORDER BY descripcion_corta ASC";
        $resultado = mysqli_query($con, $query);
        $labores = array();
        while( $row = mysqli_fetch_array( $resultado ) )
        {
          $labores[] = array(
                                "id" => $row["id_labores"],
                                "descripcion" => utf8_encode( $row["descripcion_corta"] ),
                              );
        }

        if( count($labores) > 0)
        {
          $retorno["estado"] = "OK";
          $retorno["labores"] = $labores;
        }else{
          $retorno["estado"] = "EMPTY";
        }
        break;
      case '7': //Agregar nueva Unidad de Medida
          $query = "INSERT INTO unidades_medida (descripcion)
                      VALUES('". $_POST["descripcion"] ."')";
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
