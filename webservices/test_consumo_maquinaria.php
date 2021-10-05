<?php
  $retorno = array();

  if( $_REQUEST )
  {
    if( !isset($_REQUEST["cod_maquinaria"]) || !isset($_REQUEST["litros"]) || !isset($_REQUEST["fecha"]) )
    {
      $retorno["status"] = "ERROR";
      $retorno["msg"] = "Parámetros incompletos";
    }else
    {
      include "functions.php";
      $con = start_connect();
      if( $con ) //Conexion establecida
      {
        //Consultar nombre de maquina en maquinas_herramientas
        $nombre_maquina = "------";
        $query = "SELECT nombre FROM maquinas_herramientas WHERE codigo_consumo='". $_REQUEST["cod_maquinaria"] ."'";
        $res =  mysqli_query($con,$query);
        if( $row = mysqli_fetch_array($res) )
        {
          $nombre_maquina = $row["nombre"];
        }

        //Enviar correo electrónico de confirmación
        $fecha = new DateTime( $_REQUEST["fecha"] );
        $from = "desarrollo@intuitiva.com.co";
        $from_name = "Desarrollo INTUITIVA S.A.S.";
        $to = array(
                      "carlos.mera@intuitiva.com.co"
                      // "jvpalacios@intuitiva.com.co",
                      // "cicabal@gmail.com",
                      // "juanmanuelcabal@yahoo.com",
                      // "mafraca17@une.net.co"
                      // "milton.oviedo@intuitiva.com.co"
                    );
        // $cc = array( "info@intuitiva.com.co" );
        $cc = null;
        $subject = "TIERRA DULCE: (Test) Registro de consumo de combustible  [". $_REQUEST["fecha"] ."]";
        $msg = '<html>
                  <body>
                    <p>
                      # Maquinaria: <b>'. $_REQUEST["cod_maquinaria"] .'</b></br>
                      Nombre maquinaria: <b>'. $nombre_maquina .'</b></br>
                      Litros:  <b>'. $_REQUEST["litros"] .'</b></br>
                      Fecha / hora: <b>'. date("d-M-Y h:i a") .'</b>
                    </p>
                    <hr>
                    <p>
                      <i>Envío automático de TIERRA DULCE -Test-</i>
                    </p>
                  </body>
                </html>';
        $retorno["status"] = "OK";
        $retorno["msg"] = $msg;
        $retorno["query"] = $query;
        $retorno["email"] = enviar_correo_desde($from,$from_name,$to,$cc,$msg,$subject);

        //Close BD Connection
        if( !close_bd($con) )
        {
          $retorno["msg"] = "WARNING: Fallo al cerrar la conexión BDD";
        }
      }else //Error en conexion
      {
        $retorno["status"] = "ERROR";
        $retorno["msg"] = "Error en la conexión a la BDD:". mysqli_connect_error();
      }
    }
  }else
  {
    $retorno["status"] = "ERROR";
    $retorno["msg"] = "No se encontraron parámetros POST/GET";
  }
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode( $retorno );
?>
