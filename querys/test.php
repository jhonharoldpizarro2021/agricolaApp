<?php
/**
* {
    estado: OK | ERROR | EMPTY
    msg: Cadena de texto con información
    unidades: [
    {},{},
    ]
  }
*/
  $retorno = array();
  if( $_POST )
  {
    include "functions.php";
    $con = start_connect();
    if( $con )
    {
      switch ( $_POST["opcion"]) {
        case '1': //Insertar
            $query = "INSERT INTO unidades_agricolas (nombre,id_padre,codigo,descripcion_ampliada,area)
                      VALUES('". $_POST["nombre"] ."','". $_POST["id_padre"] ."','". $_POST["codigo"] ."','". $_POST["descp"] ."','". $_POST["area"] ."')";
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
            $query = "UPDATE unidades_agricolas SET nombre='". $_POST["nombre"] ."',codigo= '". $_POST["codigo"] ."' WHERE id_unidades_agricolas='". $_POST["id"] ."'";
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
            //Consultar
            $query = "SELECT * FROM unidades_agricolas WHERE id_unidades_agricolas='". $_POST["id"] ."'";
            $resultado = mysqli_query($con, $query);
            $unidades = array();
            while( $row = mysqli_fetch_row( $resultado ) )
            {
              $unidades[] = array(
                                    "id" => $row["id_unidades_agricolas"],
                                    "nombre" => $row["nombre"],
                                    "id_padre" => $row["id_padre"],
                                    "codigo" => $row["codigo"],
                                    "descp" => $row["descripcion_ampliada"],
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
