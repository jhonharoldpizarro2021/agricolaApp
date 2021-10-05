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
          $query = " SELECT * FROM qryInforme_TCHM_variedad WHERE finca=".$_POST["finca"]." ";
          $resultado = mysqli_query($con, $query);
          $informe = array();
          $suertes = array();
          while( $row = mysqli_fetch_array( $resultado ) ){
            $informe[] = array(
                                "suerte" => $row["idUnidadAgricola"],
                                "variedad" => $row["variedad"],
                                "tchm" => $row["total_TCHM"],
                              );
            if ( !in_array( $row["idUnidadAgricola"],$suertes ) ){
              $suertes[] = $row["idUnidadAgricola"];
              $finca = $row["finca"];
            }
          }
          $informeSuertes = array();
          for ($i=0; $i < count($suertes); $i++){
            $queryTmp = "SELECT * FROM qryInforme_TCHM_variedad WHERE idUnidadAgricola='".$suertes[$i]."'";
            $resultadoTmp = mysqli_query($con, $queryTmp);
            $informeTmp = array();
            while( $rowTmp = mysqli_fetch_array( $resultadoTmp ) ){
              $informeTmp[] = array(
                                      "variedad" => $rowTmp["variedad"],
                                      "tchm" => $rowTmp["total_TCHM"],
                                    );
            }
            $informeSuertes[]=array(
                                    "idFinca" => $finca,
                                    "idSuerte" => $suertes[$i],
                                    "informes" => $informeTmp,
                                    "query" => $queryTmp,
                                    );          }
          //retorno
          if( count($informe) > 0) {
            $retorno["estado"] = "OK";
            $retorno["informe"] = $informe;
            $retorno["informeSuertes"] = $informeSuertes;
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
