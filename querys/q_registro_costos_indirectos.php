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
          $query = "INSERT INTO mvto_costos_indirectos (
                                                      id_costos_indirectos,
                                                      fecha,
                                                      descripcion,
                                                      valor
                                                    )
                    VALUES(
                            '". $_POST["idCosto"] ."',
                            '". $_POST["fecha"] ."',
                            '". $_POST["descripcion"] ."',
                            '". $_POST["valor"] ."'
                          )";
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
      case 2: //Actualizar
          if( empty($_POST["costo"]) ||  empty($_POST["valor"]) )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }else{
            $query = "UPDATE mvto_costos_indirectos SET id_costos_indirectos='". $_POST["costo"] ."',fecha= '". $_POST["fecha"] ."',descripcion='". utf8_decode($_POST["descripcion"]) ."',valor='". $_POST["valor"] ."' WHERE id_mvto_ci='". $_POST["id"] ."'";
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
      case 3:
          //Borrar
          $query = "DELETE FROM mvto_costos_indirectos WHERE id_costos_indirectos='". $_POST["id"] ."'";
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
      case 4:
          //Consultar todos
          $query = " SELECT * FROM mvto_costos_indirectos ";
          $resultado = mysqli_query($con, $query);
          $costos = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $costos[] = array(
                                  "id" => $row["id_mvto_ci "],
                                  "costo" => $row["id_costos_indirectos"],
                                  "fecha" => $row["fecha"],
                                  "descripcion" => utf8_encode($row["descripcion"]),
                                  "valor" => $row["valor"]
                                );
          }

          if( count($costos) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["costos"] = $costos;
          }else{
            $retorno["estado"] = "EMPTY";
          }
      break;
      case 5:
          $query = "UPDATE personal SET ". $_POST["campo_query"] ."='". $_POST["valor_query"] ."' WHERE id_personal='". $_POST["id"] ."'";

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
      case 6:
        $query = "INSERT INTO produccion (finca,idUnidadAgricola,area,descripcion,codigoCorte,variedad)
                      VALUES('". $_POST["finca"] ."','". $_POST["unidad_agricola"] ."','". $_POST["area"] ."','". utf8_decode($_POST["descripcion"]) ."','". $_POST["codigoCorte"] ."','". $_POST["variedad"] ."')";

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
      case 7:
          $idProduccion = $_POST['idProduccion'];
          $finca = $_POST['idfinca'];
          $suerte = $_POST['idsuerte'];
          $corte =  $_POST['corte'];
          
          // //Consultar labores asignadas al corte
          $query = "SELECT * FROM qr_segimiento_labores WHERE produccion_finca='". $finca ."' AND produccion_idUnidadAgricola='". $suerte ."' AND produccion_codigoCorte='". $corte ."' AND produccion_idProduccion='". $idProduccion ."' ";
          $resultado = mysqli_query($con, $query);
          $seguimiento = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $seguimiento[] = array(
                                  "idSeguimiento" => $row["id_seguimiento_labores"],
                                  "id" => $row["produccion_idProduccion"],
                                  "id_labor"=> $row["labores_id_labores"],
                                  "labor" => utf8_encode($row["labor"]),
                                  "fecha_inicio" => $row["fecha_inicio"],
                                  "fecha_fin" => $row["fecha_fin"],
                                  "finca" => $row["produccion_finca"],
                                  "nombreFinca" => utf8_encode($row["finca"]),
                                  "suerte" => $row["produccion_idUnidadAgricola"],
                                  "nombreSuerte" => utf8_encode($row["unidad_agricola"]),
                                  "corte" => $row["produccion_codigoCorte"]
                                );
          }
          $retorno["query"] = $query;
          if( count($seguimiento) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["seguimiento"] = $seguimiento;
          }else{
            $retorno["estado"] = "EMPTY";
          }
        break;
      case 8: //Insertar Maquina insumo gasto a labor
          if( $_POST["valor"] == "")
          {
            $query = "INSERT INTO detalle_seguimiento (
                                                        tipo,
                                                        id_codigo_tipo,
                                                        comentario,
                                                        fecha,
                                                        seguimiento_labores_id_seguimiento_labores,
                                                        id_labor
                                                      ) 
                    VALUES(
                            '". $_POST["tipo"] ."',
                            '". $_POST["codigoTipo"] ."',
                            '". utf8_decode($_POST["comentario"]) ."',
                            '". $_POST["fecha"] ."',
                            '". $_POST["seguimiento"] ."',
                            '". $_POST["labor"] ."' 
                          )";
          }
          else
          {
            $query = "INSERT INTO detalle_seguimiento (
                                                        tipo,
                                                        id_codigo_tipo,
                                                        comentario,
                                                        fecha,
                                                        valor,
                                                        seguimiento_labores_id_seguimiento_labores,
                                                        id_labor
                                                      )
                    VALUES(
                            '". $_POST["tipo"] ."',
                            '". $_POST["codigoTipo"] ."',
                            '". utf8_decode($_POST["comentario"]) ."',
                            '". $_POST["fecha"] ."',
                            '". $_POST["valor"] ."',
                            '". $_POST["seguimiento"] ."',
                            '". $_POST["labor"] ."'
                          )";
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
      case 9: /* MUESTRA LAS MAQUINAS ASOCIADAS A LA LABOR ASIGNADA AL CORTE*/ 
          $idSeguimiento = $_POST['idSeguimiento'];
          $id_labor = $_POST['labor'];
          // NOTA EL CAMPO id_produccion equivale al campo seguimiento_labores_id_seguimiento_labores SOLO Q EN LA VISTA QUEDO MAL NOMBRADO
          $query = "SELECT * FROM qr_detalle_seguimiento WHERE id_produccion='". $idSeguimiento ."' AND id_labor='". $id_labor ."' AND tipo='1' ";
          $resultado = mysqli_query($con, $query);
          $detalle = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $detalle[] = array(
                                  "idDetalle" => $row["id_detalle"],
                                  "tipo" => $row["tipo"],
                                  "codigo_tipo" => $row["id_codigo_tipo"],
                                  "nombre_tipo" => utf8_encode($row["nombre_tipo"]),
                                  "comentario" => utf8_encode($row["comentario"]),
                                  "fecha" => $row["fecha"],
                                  "valor" => $row["valor"],
                                  "labor" => $row["id_labor"],
                                  "nombre_labor" => utf8_encode($row["descripcion_corta"])
                                );
          }

          if( count($detalle) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["detalle"] = $detalle;
          }else{
            $retorno["estado"] = "EMPTY";
          }
        break;
      case 10: /* MUESTRA LOS INSUMOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
          $idSeguimiento = $_POST['idSeguimiento'];
          $id_labor = $_POST['labor'];
          // NOTA EL CAMPO id_produccion equivale al campo seguimiento_labores_id_seguimiento_labores SOLO Q EN LA VISTA QUEDO MAL NOMBRADO
          $query = "SELECT * FROM qr_detalle_seguimiento WHERE id_produccion='". $idSeguimiento ."' AND id_labor='". $id_labor ."' AND tipo='2' ";
          $resultado = mysqli_query($con, $query);
          $detalle = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $detalle[] = array(
                                  "idDetalle" => $row["id_detalle"],
                                  "tipo" => $row["tipo"],
                                  "codigo_tipo" => $row["id_codigo_tipo"],
                                  "nombre_tipo" => utf8_encode($row["nombre_tipo"]),
                                  "comentario" => utf8_encode($row["comentario"]),
                                  "fecha" => $row["fecha"],
                                  "valor" => $row["valor"],
                                  "labor" => $row["id_labor"],
                                  "nombre_labor" => utf8_encode($row["descripcion_corta"])
                                );
          }

          if( count($detalle) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["detalle"] = $detalle;
          }else{
            $retorno["estado"] = "EMPTY";
          }
        break;
      case 11:
          $idSeguimiento = $_POST['idSeguimiento'];
          $id_labor = $_POST['labor'];
          // NOTA EL CAMPO id_produccion equivale al campo seguimiento_labores_id_seguimiento_labores SOLO Q EN LA VISTA QUEDO MAL NOMBRADO
          $query = "SELECT * FROM qr_detalle_seguimiento WHERE id_produccion='". $idSeguimiento ."' AND id_labor='". $id_labor ."' AND tipo='3' ";
          $resultado = mysqli_query($con, $query);
          $detalle = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $detalle[] = array(
                                  "idDetalle" => $row["id_detalle"],
                                  "tipo" => $row["tipo"],
                                  "codigo_tipo" => $row["id_codigo_tipo"],
                                  "nombre_tipo" => utf8_encode($row["nombre_tipo"]),
                                  "comentario" => utf8_encode($row["comentario"]),
                                  "fecha" => $row["fecha"],
                                  "valor" => $row["valor"],
                                  "labor" => $row["id_labor"],
                                  "nombre_labor" => utf8_encode($row["descripcion_corta"])
                                );
          }

          if( count($detalle) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["detalle"] = $detalle;
          }else{
            $retorno["estado"] = "EMPTY";
          }
        break;
      case '12':
          //Consultar todos
          $idSeguimiento = $_POST['idSeguimiento'];
          $query = "SELECT * FROM qr_segimiento_labores WHERE produccion_idProduccion ='". $idSeguimiento ."' ";
          $resultado = mysqli_query($con, $query);
          $seguimiento = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $seguimiento[] = array(
                                  "idSeguimiento" => $row["id_seguimiento_labores"],
                                  "id" => $row["produccion_idProduccion"],
                                  "id_labor"=> $row["labores_id_labores"],
                                  "labor" => utf8_encode($row["labor"]),
                                  "fecha_inicio" => $row["fecha_inicio"],
                                  "fecha_fin" => $row["fecha_fin"],
                                  "finca" => $row["produccion_finca"],
                                  "nombreFinca" => utf8_encode($row["finca"]),
                                  "suerte" => $row["produccion_idUnidadAgricola"],
                                  "nombreSuerte" => utf8_encode($row["unidad_agricola"]),
                                  "corte" => $row["produccion_codigoCorte"],
                                );
          }
          if( count($seguimiento) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["seguimiento"] = $seguimiento;
          }else{
            $retorno["estado"] = "EMPTY";
          }
      break;
    case '13': //Insertar Maquina insumo gasto a labor
          $query = "INSERT INTO detalle_seguimiento (tipo,id_codigo_tipo,comentario,fecha,seguimiento_labores_id_seguimiento_labores,id_labor)
                    VALUES('". $_POST["tipo"] ."','". $_POST["tipo_codigo"] ."','". utf8_decode($_POST["comentario"]) ."','". $_POST["fecha"] ."','". $_POST["produccion"] ."','". $_POST["labor"] ."')";

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
      case '14':
          $idSeguimiento = $_POST['idSeguimiento'];
          $id_labor = $_POST['labor'];
          // NOTA EL CAMPO id_produccion equivale al campo seguimiento_labores_id_seguimiento_labores SOLO Q EN LA VISTA QUEDO MAL NOMBRADO
          $query = "SELECT * FROM qr_detalle_seguimiento WHERE id_produccion='". $idSeguimiento ."' AND id_labor='". $id_labor ."' AND tipo='4' ";
          $resultado = mysqli_query($con, $query);
          $detalle = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $detalle[] = array(
                                  "idDetalle" => $row["id_detalle"],
                                  "tipo" => $row["tipo"],
                                  "codigo_tipo" => $row["id_codigo_tipo"],
                                  "nombre_tipo" => utf8_encode($row["nombre_tipo"]),
                                  "comentario" => utf8_encode($row["comentario"]),
                                  "fecha" => $row["fecha"],
                                  "valor" => $row["valor"],
                                  "labor" => $row["id_labor"],
                                  "nombre_labor" => utf8_encode($row["descripcion_corta"])
                                );
          }

          if( count($detalle) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["detalle"] = $detalle;
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
