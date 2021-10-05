<?php
  session_start();
  ob_start();
$retorno = array();
if( $_POST ){
  include "../functions.php";
  $con = start_connect();
  if( $con ){
    switch ( $_POST["opcion"]){

      case 1: //Agregar nueva Unidad de Medida
          $query = "INSERT INTO movimiento_pluviometria ( fecha,
                                                          valor_medicion,
                                                          estaciones_pluviometria_id_estaciones_pluviometria,
                                                          idUnidadAgricola
                                                        )
                      VALUES( '". $_POST["fecha"] ."',
                              '". $_POST["medicion"] ."',
                              '". $_POST["estacion"] ."',
                              '". $_POST["finca"] ."' 
                            )";
          $resultado = mysqli_query($con, $query);
            if( $resultado ) {
              $retorno["estado"] = "OK";
            }
            else //Error al actualizar
            {
              $retorno["estado"] = "ERROR";  -
              $retorno["msg"] = mysqli_error($con);
            }
        break;        
      case 2: //Actualizar
          if( empty($_POST["medicion"] || $_POST["fecha"] ) ) {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }
          else{
            $query = " UPDATE movimiento_pluviometria SET fecha=?,valor_medicion=?, estaciones_pluviometria_id_estaciones_pluviometria=?, idUnidadAgricola=? WHERE id_movimiento_pluviometria=? ";
            $st = $con->prepare($query); //Statement
            if( $st ){
              $fecha = $_POST["fecha"];
              $medicion = $_POST["medicion"];
              $estacion = $_POST["estacion"];
              $finca = $_POST["finca"];
              $id = $_POST["id"];

              $param = $st->bind_param("ssiii", $fecha, $medicion, $estacion, $finca, $id);
              if( $param ){
                if( $st->execute() )  {
                  $retorno["estado"] = "OK";
                }
                else{
                  $retorno["estado"] = "ERROR";
                  $retorno["msg"] = "Error al ejecutar la sentencia:". $st->errno .":". $st->error;
                }
              }
              else{
                $retorno["estado"] = "ERROR";
                $retorno["msg"] = "Error al vincular los parametros:". $st->errno .":". $st->error;
              }
              //Cerrar sentencia
              $st->close();
            }
            else{
              $retorno["estado"] = "ERROR";
              $retorno["msg"] = "Error al preparar la sentencia:". mysqli_connect_error();
            }
          }
        break;
      case 3:
          //Borrar
          $query = " DELETE FROM movimiento_pluviometria WHERE id_movimiento_pluviometria='". $_POST["id"] ."' ";
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
          $query = " SELECT * FROM movimiento_pluviometria ";
          $resultado = mysqli_query($con, $query);
          $movimientoPluviometria = array();
          while( $row = mysqli_fetch_array( $resultado ) ){
            $movimientoPluviometria[] = array(
                                              "id" => $row["id_movimiento_pluviometria"],
                                              "fecha" => utf8_encode( $row["fecha"] ),
                                              "medicion" => $row["valor_medicion"],
                                              "estacion" => utf8_encode( $row["estaciones_pluviometria_id_estaciones_pluviometria"] ),
                                              "finca" => $row["idUnidadAgricola"]
                                            );
          }
          $retorno["estado"] = "OK";
          $retorno["movimientoPluviometria"] = $movimientoPluviometria;
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
