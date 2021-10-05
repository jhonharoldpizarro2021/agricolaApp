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
          $idSuerte = $_POST['suerte'];
          $query = " SELECT * FROM geolocalizacion WHERE idUnidadAgricolaGeo='". $idSuerte ."' ";
          $resultado = mysqli_query($con, $query);
          $geolocalizacion = array();
          while( $row = mysqli_fetch_array( $resultado ) ){           


            $geolocalizacion[] = array(
                                  lat => $row[latitudGeo],
                                  lng => $row[longitudGeo]                                  
                                );
          }
          $retorno["query"] = $query;
          if( count($geolocalizacion) > 0){
            $retorno["estado"] = "OK";
            $retorno["geolocalizacion"] = $geolocalizacion;
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
