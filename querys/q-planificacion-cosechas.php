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
          $query = "INSERT INTO seguimiento_labores (
                                                      labores_id_labores,
                                                      fecha_inicio,
                                                      fecha_fin,
                                                      produccion_finca,
                                                      produccion_idUnidadAgricola,
                                                      produccion_codigoCorte,
                                                      produccion_idProduccion
                                                    )
                            VALUES(
                                    '". $_POST["labor"] ."',
                                    '". $_POST["inicio_labor"] ."',
                                    '". $_POST["fin_labor"] ."',
                                    '". $_POST["finca"] ."',
                                    '". $_POST["suerte"] ."',
                                    '". $_POST["corte2"] ."',
                                    '". $_POST["id"] ."'
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
          $query = " UPDATE seguimiento_labores SET 
                                                    labores_id_labores='". $_POST["labor"] ."',
                                                    fecha_inicio= '". $_POST["inicio_labor"] ."',
                                                    fecha_fin='". $_POST["fin_labor"] ."',
                                                    produccion_finca='". $_POST["finca"] ."',
                                                    produccion_idUnidadAgricola='". $_POST["suerte"] ."',
                                                    produccion_codigoCorte='". $_POST["corte"] ."' 
                      WHERE id_seguimiento_labores='". $_POST["seguimiento"] ."' ";
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
      case 3:
          //Borrar
          $query = "DELETE FROM seguimiento_labores WHERE id_seguimiento_labores='". $_POST["idSeguimiento"] ."'";
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
          $query = " SELECT * FROM qr_produccion WHERE fechaCosecha = '0000-00-00' ";
          $resultado = mysqli_query($con, $query);
          $produccion = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $produccion[] = array(
                                  "id" => $row["idProduccion"],
                                  "finca" => utf8_encode($row["nombre_finca"]),
                                  "id_finca" => $row["finca"],
                                  "suerte" => utf8_encode($row["nombre_unidad_agricola"]),
                                  "id_suerte" => $row["idUnidadAgricola"],
                                  "codigoCorte" => $row["codigoCorte"],
                                  "fecha_cosecha" => $row["fechaCosecha"],
                                  "fecha_inicio" => $row["fechaInicio"],
                                  "fecha_fin" => $row["fechaFin"],
                                  "area" => $row["area"],
                                  "descripcion" => utf8_encode($row["descripcion"]),
                                  "variedad" => $row["variedad"],
                                  "edad" => $row["edad"],
                                  "tct" => $row["TCT"],
                                  "tch" => $row["TCH"],
                                  "tchm" => $row["TCHM"],
                                  "rendimiento" => $row["rendimiento"]
                                );
          }

          if( count($produccion) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["produccion"] = $produccion;
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
          $query = "SELECT * FROM qr_segimiento_labores WHERE produccion_finca='". $finca ."' AND produccion_idUnidadAgricola='". $suerte ."' AND produccion_codigoCorte='". $corte ."' AND produccion_idProduccion='". $idProduccion ."' ORDER BY fecha_inicio ASC ";
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
                                  "idSeguimiento" => $row["id_produccion"],
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
                                  "idSeguimiento" => $row["id_produccion"],
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
                                  "idSeguimiento" => $row["id_produccion"],
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
      case 12:
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
      case 13: //Insertar Maquina insumo gasto  novedad a la labor
          $query = "INSERT INTO detalle_seguimiento (tipo,id_codigo_tipo,comentario,fecha,seguimiento_labores_id_seguimiento_labores,id_labor)
                    VALUES('". $_POST["tipo"] ."','". $_POST["tipo_codigo"] ."','". utf8_decode($_POST["comentario"]) ."','". $_POST["fecha"] ."','". $_POST["seguimiento"] ."','". $_POST["labor"] ."')";

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
      case 14:
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
                                  "comentario" => utf8_encode($row["comentario"]),
                                  "fecha" => $row["fecha"],
                                  "labor" => $row["id_labor"],
                                  "idSeguimiento" => $row["id_produccion"],
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
      case 15:
          $query =  "SELECT * FROM qr_produccion WHERE finca = '". $_POST["finca"] ."' AND  idUnidadAgricola = '". $_POST["suerte"] ."' AND codigoCorte = '". $_POST["textoBusqueda"] ."' AND fechaCosecha = '0000-00-00'  ";
          //Obtiene la cantidad de filas que hay en la consulta
          $resultado = mysqli_query($con, $query);
          $resultados = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $resultados[] = array(
                                  "idProduccion" => $row["idProduccion"],
                                  "suerte"=> $row["idUnidadAgricola"],
                                  "nSuerte" => utf8_encode($row["nombre_unidad_agricola"]),
                                  "finca" => $row["finca"],
                                  "nFinca" => $row["nombre_finca"],
                                  "fechaCosecha" => $row["fechaCosecha"],
                                  "corte" => $row["codigoCorte"],
                                  "descripcion" => $row["descripcion"],
                                  "area" => $row["area"],
                                  "variedad" => $row["variedad"]
                                );
          }
          if( count($resultados) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["resultados"] = $resultados;
          }
          else
          {
            //Verificar que si existe el corte
            $query = "SELECT COUNT(*) FROM qr_produccion WHERE finca = '". $_POST["finca"] ."' AND  idUnidadAgricola = '". $_POST["suerte"] ."' AND codigoCorte = '". $_POST["textoBusqueda"] ."'";
            $result = mysqli_query($con,$query);
            $row = mysqli_fetch_array($result);
            if( $row[0] > 0 ) //el corte existe
            {
              $query2 =  "SELECT * FROM qr_produccion WHERE finca = '". $_POST["finca"] ."' AND  idUnidadAgricola = '". $_POST["suerte"] ."' AND codigoCorte = '". $_POST["textoBusqueda"] ."'  ";
              //Obtiene la cantidad de filas que hay en la consulta
              $resultado2 = mysqli_query($con, $query2);
              $resultados2 = array();
              while( $row2 = mysqli_fetch_array( $resultado2 ) )
              {
                $resultados2[] = array(
                                      "fechaCosecha" => $row2["fechaCosecha"],
                                    );
              }
              $retorno["estado"] = "EXIST";
              $retorno["resultados2"] = $resultados2; 
            }
            else
            {
              $retorno["estado"] = "EMPTY";
              $retorno["msg"] = "El Corte No Existe";
            }
          }
        break;
      case 16: //Editar Maquina insumo gasto a labor
          if( $_POST["valor"] == "")
          {
            $query = " UPDATE detalle_seguimiento SET  
                                                  comentario='". $_POST["comentario"] ."',
                                                  fecha='". $_POST["fecha"] ."'

                    WHERE id_detalle='". $_POST["idDetalle"] ."' ";
          }
          else
          {
            $query = " UPDATE detalle_seguimiento SET  
                                                  comentario='". $_POST["comentario"] ."',
                                                  fecha='". $_POST["fecha"] ."',
                                                  valor='". $_POST["valor"] ."'

                    WHERE id_detalle='". $_POST["idDetalle"] ."' ";
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
      case 17:
          //Borrar
          $query = "DELETE FROM detalle_seguimiento WHERE id_detalle='". $_POST["idDetalle"] ."'";
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



        $query = " UPDATE detalle_seguimiento SET  
                                                  id_detalle='". $_POST["idDetalle"] ."',
                                                  tipo='". $_POST["tipo"] ."',
                                                  id_codigo_tipo='". $_POST["idTipo"] ."',
                                                  nombre_tipo='". $_POST["nTipo"] ."',
                                                  comentario='". $_POST["comentario"] ."',
                                                  fecha='". $_POST["fecha"] ."',
                                                  valor='". $_POST["valor"] ."',
                                                  id_labor='". $_POST["labor"] ."',
                                                  descripcion_corta='". $_POST["labor"] ."',

                    WHERE id_seguimiento_labores='". $_POST["seguimiento"] ."' ";
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
