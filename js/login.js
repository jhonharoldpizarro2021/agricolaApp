/**
* Funcion encargada de validar e iniciar la session
*/
function iniciarSesion()
{
  var usuario = $("#usuario").val();
  var password = $("#password").val();

  //ocultar mensajes
  $("#login #msg_error_usuario").fadeOut();
  $("#login #msg_error_password").fadeOut();
  $("#login #msg_error_session").fadeOut();

  //validar campos
  if( usuario === "" )
  {
    $("#usuario").focus();
    $("#login #msg_error_usuario").fadeIn();

  }else if( password === "" )
  {
    $("#login #msg_error_password").fadeIn();
    $("#password").focus();
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/iniciar_session.php",
      data: {
              user  : usuario,
              pass  : password
            },
      success: function(res)
      {
        if( res.status === "ERROR" || res.status === "INVALID")
        {
          $("#login #msg_error_session").text( res.msg );
          $("#login #msg_error_session").fadeIn();
        }else if(res.status === "OK")
        {
          window.location = "home.php";
        }
      }
    });
  }
}
$(document).ready(function(){
    $("#password").bind('keypress', function(event) {
      if(event.which === 13)
      {
        iniciarSesion();
      }
    });
});
