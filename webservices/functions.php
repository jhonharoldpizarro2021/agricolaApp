<?php
  /**
  * Función encargada de iniciar la conexión a la BDD,
  * Para evaluar errores se puede utilizar isErrorConexionBDD( $con )
  * @return Objecto conexión msqli
  */
  function start_connect()
  {
    $host = "localhost";
  	$user = "intuitiv_cabal";
  	$pass = "4iGMaHgL78nqcCm0";
  	$bd = "intuitiv_cabal";

  	return mysqli_connect($host,$user,$pass,$bd);
  }

  /**
  * Función encargada de cerrar la conexión a la BDD,
  * Para evaluar errores se puede utilizar isErrorConexionBDD( $con )
  * @return Objecto conexión msqli
  */
  function close_bd($con)
  {
    return mysqli_close($con);
  }

  /**
  * Función encargada de definir los parámetros básicos del mail para uso de PHPMailer
  * @return Objecto/Instancia PHPMailer
  */
  function get_mail_config()
  {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "single-priva16.privatednsorg.com"; // Servidor saliente SMTP
    $mail->Username = "desarrollo@intuitiva.com.co";
    $mail->Password = "oeRt5LFD@!@1xKzW";
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->CharSet = "UTF­-8";
    return $mail;
  }

  /**
  * Función encargada de enviar correo electrónico utilizando PHPMailer
  * @param $to Array correos electrónicos destino, requerido
  * @param $cc Array correos electrónicos copia, ingresar null si no se desa usar
  * @param $subject Asunto del correo
  * @param $msg Contenido del mensaje, puede ser HTML
  * @return array
  */
  function enviar_correo($to,$cc,$msg,$subject)
  {
    $retorno = array();
    if( file_exists("phpmailer/PHPMailerAutoload.php") )
    {
      require_once("phpmailer/PHPMailerAutoload.php");
      $mail = get_mail_config();
      $mail->AddReplyTo("desarrollo@intuitiva.com.co", "Cool Events Group");
      //Agregar destinatarios
      foreach ($to as $i => $value)
      {
        $mail->AddAddress( $to[$i] );
      }
      //Agregar copias (CC)
      if( $cc != null )
      {
        foreach ($cc as $i => $value)
        {
          $mail->AddCC( $cc[$i] );
        }
      }
      $mail->setFrom("desarrollo@intuitiva.com.co", "INTUITIVA S.A.S.");
      $mail->IsHTML(true);
      $mail->Subject = utf8_encode("=?UTF-8?B?". base64_encode( $subject ) ."?="); //Codificado en UTF-8
      $mensaje = $msg;
      $mail->Body= $mensaje;

      if( $mail->Send() )
      {
        $retorno["status"] = "OK";
      }else{
        $retorno["status"] = "ERROR";
        $retorno["msg"] = "". $mail->ErrorInfo;
      }
    }else{
      $retorno["status"] = "ERROR";
      $retorno["msg"] = "Libreria PhpMailer no existe";
    }
    return $retorno;
  }

  /**
  * Función encargada de enviar correo electrónico utilizando PHPMailer,
  * $from y $from_name será utilizados tambien como reply
  * @param $from correo electrónico origen, requerido
  * @param $from_name nombre origen, requerido
  * @param $to Array correos electrónicos destino, requerido
  * @param $cc Array correos electrónicos copia, ingresar null si no se desa usar
  * @param $subject Asunto del correo
  * @param $msg Contenido del mensaje, puede ser HTML
  * @return array
  */
  function enviar_correo_desde($from,$from_name,$to,$cc,$msg,$subject)
  {
    $retorno = array();
    if( file_exists("phpmailer/PHPMailerAutoload.php") )
    {
      require_once("phpmailer/PHPMailerAutoload.php");
      $mail = get_mail_config();;
      $mail->AddReplyTo($from, $from_name);
      //Agregar destinatarios
      foreach ($to as $i => $value)
      {
        $mail->AddAddress( $to[$i] );
      }
      //Agregar copias (CC)
      if( $cc != null )
      {
        foreach ($cc as $i => $value)
        {
          $mail->AddCC( $cc[$i] );
        }
      }
      $mail->setFrom($from, $from_name);
      $mail->IsHTML(true);
      $mail->Subject = utf8_encode("=?UTF-8?B?". base64_encode( $subject ) ."?="); //Codificado en UTF-8
      $mensaje = $msg;
      $mail->Body= $mensaje;

      if( $mail->Send() )
      {
        $retorno["status"] = "OK";
      }else{
        $retorno["status"] = "ERROR";
        $retorno["msg"] = "". $mail->ErrorInfo;
      }
    }else{
      $retorno["status"] = "ERROR";
      $retorno["msg"] = "Libreria PhpMailer no existe";
    }
    return $retorno;
  }
?>
