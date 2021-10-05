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
      case 1: //Insertar
            $finca = $_POST['finca'];
            $suerte= $_POST['unidad_agricola'];
            $corte=  $_POST['corte'];
            $query = "SELECT COUNT(*) AS cantidad FROM produccion WHERE finca='". $finca ."' AND idUnidadAgricola='". $suerte ."' AND codigoCorte='". $corte ."'";
            $resultado = mysqli_query($con, $query);
            if( $row = mysqli_fetch_array( $resultado ) )
            {
              if( $row["cantidad"] > 0 )
              {
                $retorno["estado"] = "EXIST";
                $retorno["msg"] = "Producción existente con los datos solicitados";
              }else
              {
                $query = "INSERT INTO produccion (finca,idUnidadAgricola,fechaCosecha,fechaInicio,fechaFin,area,descripcion,codigoCorte,variedad,edad,TCT,TCH,TCHM,rendimiento)
                          VALUES('". $_POST["finca"] ."','". $_POST["unidad_agricola"] ."','". $_POST["fechaCosecha"] ."','". $_POST["fechaInicio"] ."','". $_POST["fechaFin"] ."','". $_POST["area"] ."','". utf8_decode($_POST["descripcion"]) ."','". $_POST["corte"] ."','".utf8_decode($_POST["variedad"]) ."','". $_POST["edad"] ."','". $_POST["TCT"] ."','". $_POST["TCH"] ."','". $_POST["TCHM"] ."','". $_POST["rendimiento"] ."')";

                $resultado = mysqli_query($con, $query);
                if( $resultado ) //Se realizó el registro
                {
                  $retorno["estado"] = "OK";
                }
                else //Error al actualizar
                {
                  $retorno["estado"] = "ERROR";
                  $retorno["msg"] = mysqli_error($con);
                }
              }
            }
        break;
      case 2: //Actualizar
          if( empty($_POST["finca"]) ||  empty($_POST["idUnidadAgricola"]) )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }
          else
          {
            $query = "UPDATE produccion SET 
                                            finca='". $_POST["finca"] ."',
                                            idUnidadAgricola='". $_POST["idUnidadAgricola"] ."',
                                            fechaCosecha='". $_POST["fechaCosecha"] ."',
                                            fechaInicio='". $_POST["fechaInicio"] ."',
                                            fechaFin='". $_POST["fechaFin"] ."',
                                            area='". $_POST["area"] ."',
                                            descripcion='". utf8_decode($_POST["descripcion"]) ."',
                                            codigoCorte='". $_POST["corte"] ."',
                                            variedad= '". utf8_decode($_POST["variedad"]) ."',
                                            edad='". $_POST["edad"]."',
                                            TCT='". $_POST["TCT"] ."',
                                            TCH='". $_POST["TCH"] ."',
                                            TCHM='". $_POST["TCHM"] ."',
                                            rendimiento='". $_POST["rendimiento"] ."' 
                      WHERE idProduccion='". $_POST["id"] ."'";

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
      case 3: //Borrar
          $query = "DELETE FROM produccion WHERE idProduccion='". $_POST["id"] ."'";
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
      case 4: //Consultar todos
          $query = "SELECT * FROM qr_produccion WHERE fechaCosecha!='0000-00-00' ";
          $resultado = mysqli_query($con, $query);
          $resultados = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $resultados[] = array(
                                  "id" => $row["idProduccion"],
                                  "finca" => $row["finca"] == null ? '' : $row["finca"],
                                  "nombre_finca" => utf8_encode($row["nombre_finca"]),
                                  "unidad_agricola" => $row["idUnidadAgricola"] == null ? '' : $row["idUnidadAgricola"],
                                  "nombre_unidad_agricola" => utf8_encode($row["nombre_unidad_agricola"]),
                                  "fechaCosecha" => $row["fechaCosecha"],
                                  "fechaInicio" => $row["fechaInicio"],
                                  "fechaFin" => $row["fechaFin"],
                                  "area" => $row["area"],
                                  "descripcion" => utf8_encode($row["descripcion"]),
                                  "corte" => $row["codigoCorte"],
                                  "variedad" => utf8_encode($row["variedad"]),
                                  "edad" => $row["edad"],
                                  "TCT" => $row["TCT"],
                                  "TCH" => $row["TCH"],
                                  "TCHM" => $row["TCHM"],
                                  "rendimiento" => $row["rendimiento"]
                                );
          }
          if( count($resultados) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["resultados"] = $resultados;
          }
          else
          {
            $retorno["estado"] = "EMPTY";
          }
        break;
      case 5: //Editar campo
        $query = "UPDATE unidades_agricolas SET ". $_POST["campo_query"] ."='". $_POST["valor_query"] ."' WHERE id_unidades_agricolas='". $_POST["id"] ."'";
        $resultado = mysqli_query($con, $query);
        if( $resultado ) //Se realizó el registro
        {
          $retorno["estado"] = "OK";
        }
        else //Error al actualizar
        {
          $retorno["estado"] = "ERROR";
          $retorno["msg"] = mysqli_error($con);
        }
        break;
      case 6: //Consultar lista Unidades
        $id_padre = $_POST['id'];
        $query = "SELECT id_unidades_agricolas,nombre FROM unidades_agricolas WHERE id_padre=". $_POST['id'] ." ORDER BY nombre ASC";
        $resultado = mysqli_query($con, $query);
        $unidades = array();
        while( $row = mysqli_fetch_array( $resultado ) )
        {
          $unidades[] = array(
                                "id" => $row["id_unidades_agricolas"],
                                "nombre" => utf8_encode( $row["nombre"] ),
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
      case 7: //Actualizar corte
          if( empty($_POST["finca"]) ||  empty($_POST["idUnidadAgricola"]) )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }
          else
          {
            $query = "UPDATE produccion SET 
                                            finca='". $_POST["finca"] ."',
                                            idUnidadAgricola='". $_POST["idUnidadAgricola"] ."',
                                            fechaInicio='". $_POST["fechaInicio"] ."',
                                            fechaFin='". $_POST["fechaFin"] ."',
                                            area='". $_POST["area"] ."',
                                            descripcion='". utf8_decode($_POST["descripcion"]) ."',
                                            codigoCorte='". $_POST["corte"] ."',
                                            variedad= '". utf8_decode($_POST["variedad"]) ."'
                      WHERE idProduccion='". $_POST["id"] ."'";

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
      case 8: //finalizar corte
          $query = "UPDATE produccion SET 
                                            fechaCosecha='". $_POST["fechaCosecha"] ."',
                                            edad='". $_POST["edad"]."',
                                            TCT='". $_POST["TCT"] ."',
                                            TCH='". $_POST["TCH"] ."',
                                            TCHM='". $_POST["TCHM"] ."',
                                            rendimiento='". $_POST["rendimiento"] ."'
                      WHERE idProduccion='". $_POST["id"] ."'";

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
