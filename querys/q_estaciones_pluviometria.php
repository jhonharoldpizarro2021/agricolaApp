<?php
  session_start();
  ob_start();
$retorno = array();
if( $_POST ){
  include "../functions.php";
  $con = start_connect();
  if( $con ){
    switch ( $_POST["opcion"]){

      case '1': //Agregar nueva Unidad de Medida
          $query = "INSERT INTO estaciones_pluviometria ( descripcion,
                                                          unidades_agricolas_id_unidades_agricolas
                                                        )
                      VALUES( '". utf8_decode($_POST["descripcion"]) ."',
                              '". $_POST["finca"] ."' 
                            )";
          $resultado = mysqli_query($con, $query);
            if( $resultado ) {
              $retorno["estado"] = "OK";
            }
            else //Error al actualizar
            {
              $retorno["estado"] = "ERROR";
              $retorno["msg"] = mysqli_error($con);
            }
        break;        
      case '2': //Actualizar
          if( empty($_POST["descripcion"]) ) {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }
          else{
            $query = "UPDATE estaciones_pluviometria SET descripcion=?,unidades_agricolas_id_unidades_agricolas=? WHERE id_estaciones_pluviometria=?";
            $st = $con->prepare($query); //Statement
            if( $st ){
              $desc = utf8_decode( $_POST["descripcion"] );
              $finca = $_POST["finca"];
              $id = $_POST["id"];

              $param = $st->bind_param("sii", $desc, $finca, $id);
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
      case '3':
          //Borrar
          $query = "DELETE FROM estaciones_pluviometria WHERE id_estaciones_pluviometria='". $_POST["id"] ."'";
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
          //Consultar todos
          $query = " SELECT * FROM qr_estaciones_pluviometria ";
          $resultado = mysqli_query($con, $query);
          $estacionesPluviometria = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $estacionesPluviometria[] = array(
                                  "id" => $row["id_estaciones_pluviometria"],
                                  "descripcion" => utf8_encode( $row["descripcion"] ),
                                  "finca" => utf8_encode( $row["unidades_agricolas_id_unidades_agricolas"] ),
                                  "nFinca" => utf8_encode( $row["unidad_agricola"] )
                                );
          }
          $retorno["estado"] = "OK";
          $retorno["estacionesPluviometria"] = $estacionesPluviometria;
        break;
      case '5':
        //Editar campo
        $query = "UPDATE unidades_tiempo_medida SET ". $_POST["campo_query"] ."='". $_POST["valor_query"] ."' WHERE id_unidades_tiempo_medida='". $_POST["id"] ."'";

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
