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
          $query = " SELECT * FROM qryInformePluviometriaMes WHERE idUnidadAgricola=".$_POST["finca"]." AND idEstacion=".$_POST["estacion"]." AND yyyy=".$_POST["año"]."  ";
          $resultado = mysqli_query($con, $query);
          $informePluviometria = array();
          while( $row = mysqli_fetch_array( $resultado ) ){
            $informePluviometria[] = array(
                                            "finca" => $row["idUnidadAgricola"],
                                            "nFinca" => utf8_encode( $row["finca"] ),
                                            "estacion" => $row["idEstacion"],
                                            "nEstacion" => utf8_encode( $row["estacion"] ),
                                            "medicion" => $row["total_mm"],                                              
                                            "fecha" => $row["yyyy"]."-".$row["mes"]
                                          );
          }
          if( count($informePluviometria) > 0) {
            $retorno["estado"] = "OK";
            $retorno["informePluviometria"] = $informePluviometria;
          }
          else {
            $retorno["estado"] = "EMPTY";
          }
        break;
/*      case 111:
          //Consultar todos
          $query = " SELECT * FROM qryInformePluviometriaMes WHERE idUnidadAgricola=".$_POST["finca"]." ";
          $resultado = mysqli_query($con, $query);
          $meses = array();
          $finca = "";
          $nFinca = "";
          while( $row = mysqli_fetch_array( $resultado ) ){
            $finca = $row["idUnidadAgricola"];
            $nFinca = utf8_encode( $row["finca"] );
            $mesTmp = array();
            if ( array_key_exists( $row["mes"], $meses) ){
              $mesTmp = $meses[ $row["mes"] ];
            }
            $mesTmp[] = array(
                              "estacion" => utf8_encode( $row["estacion"] ),
                              "medicion" => $row["total_mm"]
                              ); 
            $meses[ $row["mes"] ] = $mesTmp;            
          }
          $informePluviometria = array(
                                        "finca" => $finca,
                                        "nFinca" => $nFinca,                                              
                                        "meses" => $meses
                                      );




          if( count($informePluviometria) > 0) {
            $retorno["estado"] = "OK";
            $retorno["informePluviometria"] = $informePluviometria;
          }
          else {
            $retorno["estado"] = "EMPTY";
          }
        break;*/        
      case 2: //Actualizar
          if( empty($_POST["medicion"] || $_POST["fecha"] ) ) {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }
          else {
            $query = " UPDATE informe_pluviometria SET fecha=?,valor_medicion=?, estaciones_pluviometria_id_estaciones_pluviometria=?, idUnidadAgricola=? WHERE id_informe_pluviometria=? ";
            $st = $con->prepare($query); //Statement
            if( $st ){
              $fecha = $_POST["fecha"];
              $medicion = $_POST["medicion"];
              $estacion = $_POST["estacion"];
              $finca = $_POST["finca"];
              $id = $_POST["id"];

              $param = $st->bind_param("ssiii", $fecha, $medicion, $estacion, $finca, $id);
              if( $param ) {
                if( $st->execute() )  {
                  $retorno["estado"] = "OK";
                }
                else {
                  $retorno["estado"] = "ERROR";
                  $retorno["msg"] = "Error al ejecutar la sentencia:". $st->errno .":". $st->error;
                }
              }
              else {
                $retorno["estado"] = "ERROR";
                $retorno["msg"] = "Error al vincular los parametros:". $st->errno .":". $st->error;
              }
              //Cerrar sentencia
              $st->close();
            }
            else {
              $retorno["estado"] = "ERROR";
              $retorno["msg"] = "Error al preparar la sentencia:". mysqli_connect_error();
            }
          }
        break;
      case 3:
          //Borrar
          $query = " DELETE FROM informe_pluviometria WHERE id_informe_pluviometria='". $_POST["id"] ."' ";
          $resultado = mysqli_query($con, $query);
          if( $resultado ) {
            $retorno["estado"] = "OK";
          }
          else {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = mysqli_error($con);
          }
        break;
      case 4:
        //Consultar todos
        $query = " SELECT * FROM informe_pluviometria ";
        $resultado = mysqli_query($con, $query);
        $informePluviometria = array();
        while( $row = mysqli_fetch_array( $resultado ) ){
          $informePluviometria[] = array(
                                            "id" => $row["id_informe_pluviometria"],
                                            "fecha" => utf8_encode( $row["fecha"] ),
                                            "medicion" => $row["valor_medicion"],
                                            "estacion" => utf8_encode( $row["estaciones_pluviometria_id_estaciones_pluviometria"] ),
                                            "finca" => $row["idUnidadAgricola"]
                                          );
        }
        $retorno["estado"] = "OK";
        $retorno["informePluviometria"] = $informePluviometria;
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
echo json_encode( $retorno );

?>
