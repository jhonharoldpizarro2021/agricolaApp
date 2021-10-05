<?php
  session_start();
  ob_start();
$retorno = array();
if( $_POST ){
  include "../functions.php";
  $con = start_connect();
  if( $con ){
    switch ( $_POST["opcion"]){
      case 1:
          //Consultar todos
          $query = " SELECT * FROM qryInformeCostos WHERE id_finca=".$_POST["finca"]." ";
          $resultado = mysqli_query($con, $query);
          $informe = array();
          $suertes = array();
          $colores = array();
          while( $row = mysqli_fetch_array( $resultado ) ){
            $informe[] = array(
                                "suerte" => $row["id_unidad_agricola"],
                                "tc" => $row["tipo_costo"],
                                "valor" => $row["valor"],
                              );
            if ( !in_array( $row["id_unidad_agricola"],$suertes ) ){
              $suertes[] = $row["id_unidad_agricola"];
              $nSuerte[] = $row["nombre_unidad_agricola"];
              $finca[] = $row["id_finca"];
              $nFinca[] = $row["nombre_finca"];
            }
          }
          $informeSuertes = array();
          
          for ($i=0; $i < count($suertes); $i++){
            $queryTmp = "SELECT * FROM qryInformeCostos WHERE id_unidad_agricola='".$suertes[$i]."'";
            $resultadoTmp = mysqli_query($con, $queryTmp);
            $informeTmp = array();
            while( $rowTmp = mysqli_fetch_array( $resultadoTmp ) ){
              $informeTmp[] = array(
                                      "tc" => $rowTmp["tipo_costo"],
                                      "valor" => $rowTmp["valor"],
                                    );
              if ( !array_key_exists( $rowTmp["tipo_costo"],$colores ) ){
                $queryColor = " SELECT valor FROM parametros_generales WHERE nombre='".$rowTmp["tipo_costo"]."' AND tipo='color' ";
                $resultadoColor = mysqli_query($con, $queryColor);
                if ($rowColor = mysqli_fetch_array($resultadoColor )){
                  $colores[$rowTmp["tipo_costo"]] = $rowColor["valor"];
                }
              }
            }
            $informeSuertes[]=array(
                                    "idFinca" => $finca[$i],
                                    "nFinca" => $nFinca[$i],
                                    "idSuerte" => $suertes[$i],
                                    "nSuerte" => $nSuerte[$i],
                                    "informes" => $informeTmp,
                                    "query" => $queryTmp,
                                    );          
          }
          //retorno
          if( count($informe) > 0) {
            $retorno["estado"] = "OK";
            $retorno["informe"] = $informe;
            $retorno["informeSuertes"] = $informeSuertes;
            $retorno["colores"] = $colores;
          }
          else {
            $retorno["estado"] = "EMPTY";
          }
        break; 
    }
    if( !close_bd($con) ) {
      $retorno["msg"] = "Error al cerrar la conexión a la BDD";
    }
  }
  else {
    $retorno["estado"] = "ERROR";
    $retorno["msg"] = "Error de conexión a la BDD:". mysqli_connect_error();
  }
}
else {
  $retorno["estado"] = "ERROR";
  $retorno["msg"] = "Parámetros no encontrados";
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode( $retorno );

?>
