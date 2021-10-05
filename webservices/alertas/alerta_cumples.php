<?php
	//Display error's
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);
	$retorno = array();
	include "functions.php";
	$con = start_connect();
	if( $con ) //Conexion establecida
	{
  	$result = mysqli_query($con,"SELECT COUNT(*) FROM qryCumples");
 		$row=mysqli_fetch_row($result);
 		if( $row[0] > 0 )
 		{
			$nroRegistros = $row[0];
     	mysqli_free_result($result);
     	$sql = "SELECT * FROM qryCumples";
			$result = mysqli_query($con, $sql);
     	for ($i = 0; $i <=$nroRegistros; $i++)
     	{
      	$row=mysqli_fetch_row($result);
      	if ($row[1] > '')
      	{
		  		$msg = "Alerta TIERRA DULCE, cumpleaños:" . $row[0] . ">Fecha Nacimiento:" . $row[1];
		  		$celular = "3155218823";
				$retorno["msg_alert"] = $msg;
				$res = enviarSMS($msg, $celular);
		  //  		$celular = "3002394200";
				// $res = enviarSMS($msg, $celular);
		  		$celular = "3155775678";
				$res = enviarSMS($msg, $celular);
		  		$celular = "3155759323";
				$res = enviarSMS($msg, $celular);
				if( $res["status"] == "ERROR")
				{
					$retorno["sms_status"] = "ERROR";
					$retorno["sms_msg"] = $res["msg"];
				}else{
					$retorno["sms_status"] = "OK";
				}
    		}
    	}
  	}else{
			$retorno["status"] = "EMPTY";
			$retorno["msg"] = "No se encontraton registros en alertas";
		}
    //Close BD Connection
  	if( !close_bd($con) )
  	{
  		$retorno["msg"] = "WARNING: Fallo al cerrar la conexión BDD";
  	}
	}
	else //Error en conexion
	{
		$retorno["status"] = "ERROR";
		$retorno["msg"] = "Error en la conexión a la BDD:". mysqli_connect_error();
	}
 	header('Content-Type: application/json; charset=utf-8');
 	echo json_encode( $retorno );
?>
