<?php
	$retorno = array();
	include "functions.php";
  	$con = start_connect();
  	if( $con ) //Conexion establecida
  	{
    	$result = mysqli_query($con,"SELECT COUNT(*) FROM qryAlertaLabores");
 		$row=mysqli_fetch_row($result);
 		if($row[0] > 0)
 		{
			$nroRegistros = $row[0];
     		mysqli_free_result($result);
     		$sql = "SELECT * FROM qryAlertaLabores";
			$result = mysqli_query($con, $sql); 
     		for ($i = 0; $i <=$nroRegistros; $i++)
     		{
         		$row=mysqli_fetch_row($result);
         		if ($row[1] > '')
         		{
		      		$msg = "Alerta TIERRA DULCE:" . $row[4] . " / " . $row[2] . " / " . $row[3] . " / " . $row[5];
		      		$celular = "3002394200";
		    //   		$comando = "https://www.intuitiva.com.co/webservices/test_sms.php?cel=". $celular. "&msg=" . $msg;
		    //   		echo $comando;
 					// $page = file_get_contents($comando);
  				// 	echo $page;
//		      		$retorno["sms_status"] = "OK";
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
//  	header('Content-Type: application/json; charset=utf-8');
//  	echo json_encode( $retorno );
?>
