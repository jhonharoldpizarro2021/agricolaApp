<?php
  $retorno = array();

  if( $_REQUEST )
  {
    if( !isset($_REQUEST["cel"]) )
    {
      $retorno["status"] = "ERROR";
      $retorno["msg"] = "Parámetros incompletos. cel no está presente";
    }else
    {
      include "functions.php";
      $msg = "La Estancia-Suerte 1:  Labor ABONADA debe iniciar el día de hoy 27-abr-2016.-Mensaje aut. de TIERRADULCE-";
      $res = enviarSMS($msg, $_REQUEST["cel"]);
      if( $res["status"] == "ERROR")
      {
        $retorno["sms_status"] = "ERROR";
        $retorno["sms_msg"] = $res["msg"];
      }else{
        $retorno["sms_status"] = "OK";
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
