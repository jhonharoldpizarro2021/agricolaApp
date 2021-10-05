/*  /// 
/////////////  FUNCION ENCARGADA DE GENERAR EL GRAFICO  X FINCA
//////*/
function informeFinca(){
  $("#morris-area-chart").html("");
  var finca = $("#finca").val();
  if( finca === ""){
      alert("Seleccione la Finca");
  }
  else{
      $.ajax({
          cache:false,
          dataType:"json",
          type:"POST",
          url: "./querys/q_informe_pluviometria.php",
          data: {
                  opcion:1,
                  finca:finca
                },
          success: function(res){
            if(res.estado === "ERROR"){
              alert("jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');");
              console.log("Error:"+ res.msg);
            }
            else if(res.estado === "OK"){
              var datos = [];
              for( var i=0; i < res.informePluviometria.length; i++){
                datos[i] =  { 
                              y: res.informePluviometria[i].fecha, 
                              a: res.informePluviometria[i].medicion 
                            };
              }
              //Recargar 
              Morris.Line({
                element: 'morris-area-chart',
                data: datos,
                xkey: 'y',
                ykeys: 'a',
                labels: 'Medicion', 
              });
              $("#informeFinca").modal('hide');
              $("#finca").val("NULL");
            }
            else if(res.estado === "EMPTY"){
              jAlert('La Finca No Cuenta con Registro de Pluviometria', 'SIN REGISTROS DE PLUVIOMETRIA');
              $("#morris-area-chart").html("");
              $("#finca").val("NULL");
            }            
          }
      });
  }




}

//
$(document).ready(function(){
  


});