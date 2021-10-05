<?php
  include "../functions.php";
  $retorno = array();

  $con = start_connect();
  if( $con )
  {
    $query = "INSERT INTO labores (descripcion_corta, descripcion_ampliada, id_labor_procedente, id_labor_posterior, cantidad_tiempo, unidades_medida_id_unidades_medida)
              VALUES(?,?,?,?,?,?)";
    $st = $con->prepare($query); //Statement
    if( $st )
    {
      $des = "Prueba insert";
      $des_amplia = "Se implementa Statement con Prepare para insertar valores";
      $id_procedente = null;
      $id_posterior = null;
      $tiempo = "30";
      $id_medida = 1;

      //Pasar valores parametros Statement->prepare, tipo dato (s | i | d | b)-String,Integer,Double,boolean
      //$st->bind_param(tipo dato, Datos);
      //tipo dato = s | i | d | b-String,Integer,Double,boolean-
      $param = $st->bind_param("ssiisi", $des, $des_amplia, $id_procedente, $id_posterior, $tiempo, $id_medida);
      if( $param )
      {
        if( $st->execute() )
        {
          $retorno["estado"] = "OK";
          $retorno["id"] = $st->insert_id;
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

    if( !close_bd($con) )
    {
      $retorno["msg"] = "Error al cerrar la conexión a la BDD";
    }
  }else
  {
    $retorno["estado"] = "ERROR";
    $retorno["msg"] = "Error de conexión a la BDD:". mysqli_connect_error();
  }
  echo json_encode( $retorno );
?>
