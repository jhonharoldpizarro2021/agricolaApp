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
      case '1': //Insertar
          $query = "INSERT INTO personal (nombre_personal,cc,fecha_nacimiento,direccion,telefono,celular,email,fecha_ingreso,estado_civil,nro_hijos,eps,arl,pension,cuenta) 
                    VALUES('". utf8_decode($_POST["nombre"]) ."','". $_POST["doc"] ."','". $_POST["nacimiento"] ."','". utf8_decode($_POST["direccion"]) ."','". $_POST["telefono"] ."','". $_POST["celular"] ."','". $_POST["email"] ."','". $_POST["ingreso"] ."','". $_POST["estado_civil"] ."','". $_POST["hijos"] ."','". $_POST["eps"] ."','". $_POST["arl"] ."','". $_POST["pension"] ."','". $_POST["cuenta"] ."')";
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
      case '2': //Actualizar
          if( empty($_POST["doc"]) ||  empty($_POST["nombre"]) )
          {
            $retorno["estado"] = "ERROR";
            $retorno["msg"] = "Parámetros incompletos";
          }else{
            $query = "UPDATE personal SET nombre_personal='". utf8_decode($_POST["nombre"]) ."',cc= '". $_POST["doc"] ."',fecha_nacimiento='". $_POST["nacimiento"] ."',direccion='". utf8_decode($_POST["direccion"]) ."',telefono='". $_POST["telefono"] ."',celular='". $_POST["celular"] ."',email='". $_POST["email"] ."',fecha_ingreso='". $_POST["ingreso"] ."',estado_civil='". $_POST["estado_civil"] ."',nro_hijos='". $_POST["hijos"] ."',eps='". $_POST["eps"] ."',arl='". $_POST["arl"] ."',pension='".$_POST["pension"] ."',cuenta='". $_POST["cuenta"] ."' WHERE id_personal='". $_POST["id"] ."'";
            $resultado = mysqli_query($con, $query);
            if( $resultado ) //Se realizó el registro
            {
              $retorno["estado"] = "OK";
            }else //Error al actualizar
            {
              $retorno["estado"] = "ERROR";
              $retorno["msg"] = mysqli_error($con);
            }
          }
        break;
      case '3':
          //Borrar
          $query = "DELETE FROM personal WHERE id_personal='". $_POST["id"] ."'";
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
          $query = "SELECT * FROM qr_personal";
          $resultado = mysqli_query($con, $query);
          $personal = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $personal[] = array(
                                  "id" => $row["id_personal"], 
                                  "doc" => $row["cc"],
                                  "nacimiento" => $row["fecha_nacimiento"],
                                  "nombre" => utf8_encode($row["nombre_personal"]),
                                  "direccion" => utf8_encode($row["direccion"]),
                                  "telefono" => $row["telefono"],
                                  "celular" => $row["celular"],
                                  "email" => $row["email"],
                                  "eps" =>$row["id_eps"],
                                  "nombre_eps" =>utf8_encode($row["nombre_eps"]),
                                  "arl" =>$row["id_arl"],
                                  "nombre_arl" =>utf8_encode($row["nombre_arl"]),
                                  "pension" =>$row["id_pension"],
                                  "nombre_pension" =>utf8_encode($row["nombre_pension"]),
                                  "ingreso" =>$row["fecha_ingreso"],
                                  "estado_civil" =>$row["estado_civil"],
                                  "hijos" =>$row["nro_hijos"] ,
                                  "cuenta" =>$row["cuenta"]
                                );
          }

          if( count($personal) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["personal"] = $personal;
          }else{
            $retorno["estado"] = "EMPTY";
          }
      break;
      case "5":
          $query = "UPDATE personal SET ". $_POST["campo_query"] ."='". $_POST["valor_query"] ."' WHERE id_personal='". $_POST["id"] ."'";

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
      case "6":
          // para seguir la seccuencia de los otros archivos se deja este en blanco debido a que la consulta que habia aqui no sirve.
        break;
      case '7':
          //Consultar todos
          $query = "SELECT * FROM proveedor";
          $resultado = mysqli_query($con, $query);
          $insumos = array();
          while( $row = mysqli_fetch_array( $resultado ) )
          {
            $insumos[] = array(
                                  "id" => $row["id_proveedor"],
                                  "nombre" => utf8_encode($row["nombre"]),
                                );
          }

          if( count($insumos) > 0)
          {
            $retorno["estado"] = "OK";
            $retorno["insumos"] = $insumos;
          }else{
            $retorno["estado"] = "EMPTY";
          }
      break;               
      case "8"://Consultar perfiles
              $query = "SELECT * FROM eps ORDER BY nombre ASC";
              $result = mysqli_query($con,$query);
              $eps = array( array( "id" => $row["id_eps"], "nombre" => " EPS " ) );
              while( $row = mysqli_fetch_array($result) )
              {
                $eps[] = array( "id" => $row["id_eps"], "nombre" => utf8_encode($row["nombre"]) );
              }
              $retorno["eps"] = $eps;

              $query2 = "SELECT * FROM arl ORDER BY nombre ASC";
              $result2 = mysqli_query($con,$query2);
              $arl = array( array( "id" => $row2["id_arl"], "nombre" => " ARL " ) );
              while( $row2 = mysqli_fetch_array($result2) )
              {
                $arl[] = array( "id" => $row2["id_arl"], "nombre" => utf8_encode($row2["nombre"]) );
              }
              $retorno["arl"] = $arl;

              $query3 = "SELECT * FROM pension ORDER BY nombre ASC";
              $result3 = mysqli_query($con,$query3);
              $pension = array( array( "id" => $row3["id_pension"], "nombre" => " Pension " ) );
              while( $row3 = mysqli_fetch_array($result3) )
              {
                $pension[] = array( "id" => $row3["id_pension"], "nombre" => utf8_encode($row3["nombre"]) );
              }
              $retorno["pension"] = $pension;

              $retorno["status"] = "OK";
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
