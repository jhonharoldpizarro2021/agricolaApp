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
      case 1:
          $idFinca = $_POST['finca'];
          $idSuerte = $_POST['suerte'];
          $query = " SELECT * FROM qryDatosUltimoCorte WHERE id_finca='".$idFinca."' AND id_unidad_agricola='".$idSuerte."' ";
          $resultado = mysqli_query($con, $query);
          $corteactual = array();
          while( $row = mysqli_fetch_array( $resultado ) ){
            $queryCI = " SELECT SUM(total_costos_indirectos) AS vr_costos_indirectos FROM qryCostosIndirectosporcorte WHERE produccion_finca ='". $row["id_finca"] ."' AND produccion_codigoCorte = '". $row["corte"] ."' ";
            $resultadoCI = mysqli_query($con, $queryCI);
            $totalCI = 0;
            if( $rowCI = mysqli_fetch_array($resultadoCI) )
            {
              $totalCI = empty($rowCI["vr_costos_indirectos"]) ? 0 : $rowCI["vr_costos_indirectos"];
            }

            $corteactual[] = array(
                                  "idFinca" => $row["id_finca"],
                                  "idSuerte" => $row["id_unidad_agricola"],
                                  "fechaCosecha" => $row["fechaCosecha"],
                                  "fechaInicio" => $row["fechaInicio"],
                                  "fechaFin" => $row["fechaFin"],
                                  "area" => $row["area"],
                                  "descripcion" => utf8_encode($row["descripcion"]),
                                  "corte" => $row["corte"],
                                  "variedad" => $row["variedad"],
                                  "edad" => $row["edad"],
                                  "tct" => $row["TCT"],
                                  "tch" => $row["TCH"],
                                  "tchm" => $row["TCHM"],
                                  "rendimiento" => $row["rendimiento"],
                                  "idProduccion" => $row["idProduccion"],
                                  "totalCI" => $totalCI,
                                  "idProduccionActual" => $row["idProduccionActual"],
                                  "corteActual" => $row["corteActual"],
                                  //"curvas" =>  $curvas
                                );
          }

          $retorno["query"] = $query;
          $queryCurvas = " SELECT area FROM unidades_agricolas WHERE id_unidades_agricolas ='". $row["id_finca"] ."' AND area!=null   ";
          $resultadoCurvas = mysqli_query($con, $queryCurvas);
          $curvas = array();
          while( $rowCurvas = mysqli_fetch_array($resultadoCurvas) ){
            $curvas[] = array(
                              "curvas" => $rowCurvas["area"]
                            );
          }
          

          if( count($corteactual) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["corteactual"] = $corteactual;
            $retorno["curvas"] = $curvas;
          }
          else if( count($corteactual) === 0)
          {
            $retorno["estado"] = "EMPTY";
          }
          else
          {
            $retorno["estado"] = "ERROR";
          }
        break;
      case 2:
          //* MUESTRA LOS DATOS DE CORTE ANTERIOR *//
          //$idFinca = $_POST['idFinca'];
          //$idSuerte = $_POST['idSuerte'];
          //$ultimaFechaCosecha = $_POST['fechaUltimaCosecha'];
          //$ultima = $ultimaFechaCosecha - 1;
          // //Consultar
          //$query = "SELECT * FROM qr_produccion WHERE finca='". $idFinca ."' AND idUnidadAgricola='". $idSuerte ."' AND YEAR(fechaCosecha)='". $ultima ."'  ";

          //$resultado = mysqli_query($con, $query);
          //$corteanterior = array();
          //while( $row = mysqli_fetch_array($resultado) ){

            //* MUESTRA LOS DATOS DEL CORTE ANTERIOR *//
            //$corteanterior[] = array(
                              //"idProduccion" => $row["idProduccion"],
                              //"corteAnterior" => $row["codigoCorte"],
                              //"fechaCosechaAnterior" => $row["fechaCosecha"],
                              //"variedad" => $row["variedad"],
                              //"edad" => $row["edad"],
                              //"tct" => $row["TCT"],
                              //"tch" => $row["TCH"],
                              //"tchm" => $row["TCHM"],
                              //"rendimiento" => $row["rendimiento"],
                              //"labores" => $labores,
                           //);
          //}
          //$retorno["query"] = $query;
          //if( count($corteanterior) > 0){
            //$retorno["estado"] = "OK";
            //$retorno["corteanterior"] = $corteanterior;

          //}
        break;
      case 3:
          //* MUESTRA LAS LABORES DEL CORTE ACTUAL*//
          $idFinca = $_POST['idFinca'];
          $idSuerte = $_POST['idSuerte'];
          $idProduccionActual = $_POST['idProduccionActual'];
          $costos_totales = 0;
            //* MUESTRA LOS DATOS DE LAS LABORES ASIGNADAS AL CORTE Actual *//
            $queryLabores = " SELECT * FROM qr_segimiento_labores WHERE produccion_finca='". $idFinca ."' AND produccion_idUnidadAgricola='". $idSuerte ."' AND produccion_idProduccion='". $idProduccionActual  ."' ORDER BY fecha_inicio ASC ";
            $resultadoLabores = mysqli_query($con, $queryLabores);
            $labores = array();
            while( $rowLabores = mysqli_fetch_array($resultadoLabores) ){
              //* MUESTRA LAS NOVEDADES PRESENTADAS EN LAS LABORES ASIGNADAS AL CORTE Actual*//
              $queryNovedades = "SELECT * FROM qr_detalle_seguimiento WHERE id_produccion='". $rowLabores["id_seguimiento_labores"] ."' AND tipo = '4' ";
              $resultadoNovedades = mysqli_query($con, $queryNovedades);
              $novedades = array();
              while( $rowNovedades = mysqli_fetch_array($resultadoNovedades) ){
                $novedades[] = array(
                                  "idDetalle" => $rowNovedades["id_detalle"],
                                  "tipo" => $rowNovedades["nombre_tipo"],
                                  "idNovedad" => $rowNovedades["id_codigo_tipo"],
                                  "nNovedad" => utf8_encode($rowNovedades["nombre_tipo"]),
                                  "comentario" => utf8_encode(eregi_replace("[\n|\r|\n\r]", ' ',$rowNovedades["comentario"])),
                                  "fecha" => $rowNovedades["fecha"],
                                  "idSeguimiento" => $rowNovedades["id_produccion"],
                                  "idLabor" => $rowNovedades["id_labor"],
                                  "labor" => utf8_encode($rowNovedades["descripcion_corta"]),
                                  "id_labor_procedente" => $rowNovedades["id_labor_procedente"],
                                  "desc_corta_labor_procedente" => utf8_encode($rowNovedades["desc_corta_labor_procedente"]),
                                  "desc_ampliada_labor_procedente " => utf8_encode($rowNovedades["desc_ampliada_labor_procedente "]),
                                  "id_labor_posterior" => $rowNovedades["id_labor_posterior"],
                                  "desc_corta_labor_posterior" => utf8_encode($rowNovedades["desc_corta_labor_posterior"]),
                                  "desc_ampliada_labor_posterior" => utf8_encode($rowNovedades["desc_ampliada_labor_posterior"]),
                                  "cantidad_tiempo" => $rowNovedades["cantidad_tiempo"],
                                  "id_unidades_tiempo_medida" => $rowNovedades["id_unidades_tiempo_medida"],
                                  "unidad_medida" => utf8_encode($rowNovedades["unidad_medida"]),
                               );
              }
              //* MUESTRA LOS GASTOS EFECTUADOS EN LAS LABORES ASIGNADAS AL CORTE ANTERIOR*//
              $queryGastos = "SELECT * FROM qr_detalle_seguimiento WHERE id_produccion='". $rowLabores["id_seguimiento_labores"] ."' AND tipo = '3' ";
              $resultadoGastos = mysqli_query($con, $queryGastos);
              $gastos = array();
              while( $rowGastos = mysqli_fetch_array($resultadoGastos) ){
                $gastos[] = array(
                                  "idDetalle" => $rowGastos["id_detalle"],
                                  "tipo" => $rowGastos["tipo"],
                                  "idGasto" => $rowGastos["id_codigo_tipo"],
                                  "nGasto" => utf8_encode($rowGastos["nombre_tipo"]),
                                  "comentario" => utf8_encode(eregi_replace("[\n|\r|\n\r]", ' ',$rowGastos["comentario"])),
                                  "fecha" => $rowGastos["fecha"],
                                  "valor" => $rowGastos["valor"],
                                  "idSeguimiento" => $rowGastos["id_produccion"],
                                  "idLabor" => $rowGastos["id_labor"],
                                  "labor" => utf8_encode($rowGastos["descripcion_corta"]),
                                  "id_labor_procedente" => $rowGastos["id_labor_procedente"],
                                  "desc_corta_labor_procedente" => utf8_encode($rowGastos["desc_corta_labor_procedente"]),
                                  "desc_ampliada_labor_procedente " => utf8_encode($rowGastos["desc_ampliada_labor_procedente "]),
                                  "id_labor_posterior" => $rowGastos["id_labor_posterior"],
                                  "desc_corta_labor_posterior" => utf8_encode($rowGastos["desc_corta_labor_posterior"]),
                                  "desc_ampliada_labor_posterior" => utf8_encode($rowGastos["desc_ampliada_labor_posterior"]),
                                  "cantidad_tiempo" => $rowGastos["cantidad_tiempo"],
                                  "id_unidades_tiempo_medida" => $rowGastos["id_unidades_tiempo_medida"],
                                  "unidad_medida" => utf8_encode($rowGastos["unidad_medida"]),
                               );
                $costos_totales += (float) $rowGastos["valor"];
              }
              //* MUESTRA LOS MINSUMOS USADOS EN LAS LABORES ASIGNADAS AL CORTE ANTERIOR*//
              $queryInsumos = "SELECT * FROM qr_detalle_seguimiento WHERE id_produccion='". $rowLabores["id_seguimiento_labores"] ."' AND tipo = '2' ";
              $resultadoInsumos = mysqli_query($con, $queryInsumos);
              $insumos = array();
              while( $rowInsumos = mysqli_fetch_array($resultadoInsumos) ){
                $insumos[] = array(
                                  "idDetalle" => $rowInsumos["id_detalle"],
                                  "tipo" => $rowInsumos["tipo"],
                                  "idinsumo" => $rowInsumos["id_codigo_tipo"],
                                  "nInsumo" => utf8_encode($rowInsumos["nombre_tipo"]),
                                  "comentario" => utf8_encode(eregi_replace("[\n|\r|\n\r]", ' ',$rowInsumos["comentario"])),
                                  "fecha" => $rowInsumos["fecha"],
                                  "idSeguimiento" => $rowInsumos["id_produccion"],
                                  "idLabor" => $rowInsumos["id_labor"],
                                  "labor" => utf8_encode($rowInsumos["descripcion_corta"]),
                                  "id_labor_procedente" => $rowInsumos["id_labor_procedente"],
                                  "desc_corta_labor_procedente" => utf8_encode($rowInsumos["desc_corta_labor_procedente"]),
                                  "desc_ampliada_labor_procedente " => utf8_encode($rowInsumos["desc_ampliada_labor_procedente"]),
                                  "id_labor_posterior" => $rowInsumos["id_labor_posterior"],
                                  "desc_corta_labor_posterior" => utf8_encode($rowInsumos["desc_corta_labor_posterior"]),
                                  "desc_ampliada_labor_posterior" => utf8_encode($rowInsumos["desc_ampliada_labor_posterior"]),
                                  "cantidad_tiempo" => $rowInsumos["cantidad_tiempo"],
                                  "id_unidades_tiempo_medida" => $rowInsumos["id_unidades_tiempo_medida"],
                                  "unidad_medida" => utf8_encode($rowInsumos["unidad_medida"]),
                               );
              }
              //* MUESTRA LAS MAQUINAS o HERRAMIENTAS USADAS EN LAS LABORES ASIGNADAS AL CORTE ANTERIOR*//
              $queryMaquinas = "SELECT a.*,b.codigo_consumo FROM qr_detalle_seguimiento AS a
                                LEFT JOIN maquinas_herramientas AS b ON a.id_codigo_tipo = b.id_maquinas_herramientas
                                WHERE id_produccion='". $rowLabores["id_seguimiento_labores"] ."' AND tipo = '1'";
              $resultadoMaquinas = mysqli_query($con, $queryMaquinas);
              $maquinas = array();
              while( $rowMaquinas = mysqli_fetch_array($resultadoMaquinas) ){
                //* MUESTRA EL CONSUMO DE COMBUSTIBLE POR CADA MAQUINA EN CADA CORTE*//
                $queryCombustible = "SELECT SUM(litros) AS consumo FROM consumo_maquinaria WHERE cod_maquinaria='". $rowMaquinas["codigo_consumo"] ."' AND fecha_hora BETWEEN '". $rowLabores["fecha_inicio"] ."' AND '". $rowLabores["fecha_fin"] ."' ";
                $resultadoCombustible = mysqli_query($con, $queryCombustible);
                $consumo = 0;
                if( $rowCombustible = mysqli_fetch_array($resultadoCombustible) )
                {
                  $consumo = empty($rowCombustible["consumo"]) ? 0 : $rowCombustible["consumo"];
                }
                $maquinas[] = array(
                                  "idDetalle" => $rowMaquinas["id_detalle"],
                                  "tipo" => $rowMaquinas["tipo"],
                                  "idMaquina" => $rowMaquinas["id_codigo_tipo"],
                                  "nMaquina" => utf8_encode($rowMaquinas["nombre_tipo"]),
                                  "comentario" => utf8_encode(eregi_replace("[\n|\r|\n\r]", ' ',$rowMaquinas["comentario"])),
                                  "fecha" => $rowMaquinas["fecha"],
                                  "idSeguimiento" => $rowMaquinas["id_produccion"],
                                  "idLabor" => $rowMaquinas["id_labor"],
                                  "labor" => $rowMaquinas["descripcion_corta"],
                                  "id_labor_procedente" => $rowMaquinas["id_labor_procedente"],
                                  "desc_corta_labor_procedente" => utf8_encode($rowMaquinas["desc_corta_labor_procedente"]),
                                  "desc_ampliada_labor_procedente " => utf8_encode($rowMaquinas["desc_ampliada_labor_procedente"]),
                                  "id_labor_posterior" => $rowMaquinas["id_labor_posterior"],
                                  "desc_corta_labor_posterior" => utf8_encode($rowMaquinas["desc_corta_labor_posterior"]),
                                  "desc_ampliada_labor_posterior" => utf8_encode($rowMaquinas["desc_ampliada_labor_posterior"]),
                                  "cantidad_tiempo" => $rowMaquinas["cantidad_tiempo"],
                                  "id_unidades_tiempo_medida" => $rowMaquinas["id_unidades_tiempo_medida"],
                                  "unidad_medida" => utf8_encode($rowMaquinas["unidad_medida"]),
                                  "combustible" => $consumo
                               );
              }
              //* MUESTRA LOS DATOS DE LAS LABORES DEL CORTE  *//
              $labores[] = array(
                                "idSeguimiento" => $rowLabores["id_seguimiento_labores"],
                                "idLabor" => $rowLabores["labores_id_labores"],
                                "labor" => utf8_encode($rowLabores["labor"]),
                                "fechaInicio" => $rowLabores["fecha_inicio"],
                                "fechaFin" => $rowLabores["fecha_fin"],
                                "idFinca" => $rowLabores["produccion_finca"],
                                "nombreFinca" => utf8_encode($rowLabores["finca"]),
                                "idSuerte" => $rowLabores["produccion_idUnidadAgricola"],
                                "nombreSuerte" => utf8_encode($rowLabores["unidad_agricola"]),
                                "corte" => $rowLabores["produccion_codigoCorte"],
                                "idProduccion" => $rowLabores["produccion_idProduccion"],
                                "maquinas" => $maquinas,
                                "insumos" => $insumos,
                                "gastos" => $gastos,
                                "novedades" => $novedades,
                             );
            }

          $retorno["query"] = $queryLabores;
          if( count($labores) > 0){
            $retorno["estado"] = "OK";
            $retorno["labores"] = $labores;
            $retorno["costos_totales"] = $costos_totales;

          }
        break;
      case 4:
          //* MUESTRA EDAD CORTE ACTUAL *//
          $idFinca = $_POST['idFinca'];
          $idSuerte = $_POST['idSuerte'];
          $fechaUltimaCosecha = $_POST['fechaUltimaCosecha'];
          //CALCULA EDAD
          $fecha = date($fechaUltimaCosecha);
          $segundos = strtotime('now') - strtotime($fecha);
          $edadActual = intval($segundos/60/60/24);
          if( count($edadActual) > 0){
            $retorno["estado"] = "OK";
            $retorno["edadActual"] = $edadActual;
            $retorno["msg"] = "Edad Actual". $edadActual;

          }
        break;
      case 5:
          //* MUESTRA LOS DATOS DE CORTE ANTERIOR *//
          $idFinca = $_POST['idFinca'];
          $idSuerte = $_POST['idSuerte'];
          $ultimaFechaCosecha = $_POST['fechaUltimaCosecha'];
          $ultima = $ultimaFechaCosecha - 1;
          // //Consultar
          $query = "SELECT * FROM qr_produccion WHERE finca='". $idFinca ."' AND idUnidadAgricola='". $idSuerte ."' AND YEAR(fechaCosecha)='". $ultima ."'  ";

          $resultado = mysqli_query($con, $query);
          $corteanterior = array();
          while( $row = mysqli_fetch_array($resultado) ){

            //* MUESTRA LOS DATOS DE LAS LABORES ASIGNADAS AL CORTE ANTERIOR *//
            $queryLabores = " SELECT * FROM qr_segimiento_labores WHERE produccion_finca='". $idFinca ."' AND produccion_idUnidadAgricola='". $idSuerte ."' AND produccion_idProduccion='". $row["idProduccion"] ."' ";
            $resultadoLabores = mysqli_query($con, $queryLabores);
            $labores = array();
            while( $rowLabores = mysqli_fetch_array($resultadoLabores) ){

              //* MUESTRA LOS GASTOS EFECTUADOS EN LAS LABORES ASIGNADAS AL CORTE ANTERIOR*//
              // NOTA EL CAMPO id_produccion equivale al campo seguimiento_labores_id_seguimiento_labores SOLO Q EN LA VISTA QUEDO MAL NOMBRADO
              //$queryGastos = "SELECT * FROM qr_detalle_seguimiento WHERE id_produccion='". $rowLabores["id_seguimiento_labores"] ."' AND tipo = '3' ";
              $queryGastos = "  SELECT SUM(valor) AS valor
                                FROM detalle_seguimiento
                                WHERE seguimiento_labores_id_seguimiento_labores='". $rowLabores["id_seguimiento_labores"] ."' ";
              $resultadoGastos = mysqli_query($con, $queryGastos);
              $gastos = array();
              $valor = 0;
                if( $rowGastos = mysqli_fetch_array($resultadoCombustible) )
                {
                  $valor = empty($rowGastos["valor"]) ? 0 : $rowGastos["valor"];
                }
            }
            //* MUESTRA LOS DATOS DEL CORTE ANTERIOR *//
            $corteanterior[] = array(
                              "idProduccion" => $row["idProduccion"],
                              "corteAnterior" => $row["codigoCorte"],
                              "fechaCosechaAnterior" => $row["fechaCosecha"],
                              "variedad" => $row["variedad"],
                              "edad" => $row["edad"],
                              "tct" => $row["TCT"],
                              "tch" => $row["TCH"],
                              "tchm" => $row["TCHM"],
                              "rendimiento" => $row["rendimiento"],
                              "gastos" => $valor,
                           );
          }
          $retorno["query"] = $query;
          if( count($corteanterior) > 0){
            $retorno["estado"] = "OK";
            $retorno["corteanterior"] = $corteanterior;

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
