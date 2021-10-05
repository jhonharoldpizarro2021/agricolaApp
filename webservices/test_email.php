<?php
  include "functions.php";
  $from = "desarrollo@intuitiva.com.co";
  $from_name = "Desarrollo INTUITIVA S.A.S.";
  $to = array(
                "carlos.mera@intuitiva.com.co",
                // "carlosemr24@yahoo.com.ar",
                // "carlosmeraruiz@gmail.com"
              );
  $cc = array(
                "desarrollo@intuitiva.com.co",
                "krlosemr24@hotmail.com"
              );
  $msg = '<html>
            <body>
              <h1>Prueba de mensaje</h1>
              <p>
                Hola, esto no es más que una prueba de correo electrónico utilizando
                PHPMailer y SMTP.
              </p>
              <hr>
              <p>
                Buen día.
              </p>
            </body>
          </html>';
  $subject ="Test Correo";


  header('Content-Type: application/json; charset=utf-8');
  $res = enviar_correo_desde($from,$from_name,$to,$cc,$msg,$subject);
  echo json_encode( $res );

?>
