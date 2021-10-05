/*  /// 
/////////////  FUNCION ENCARGADA DE GENERAR EL GRAFICO  X FINCA
//////*/
function informeFinca(){
    var finca = $("#finca").val();
    if( finca === ""){
        alert("Seleccione la Finca");
    }
    else{
        $.ajax({
            cache:false,
            dataType:"json",
            type:"POST",
            url: "./querys/q_tc_vs_pluviometria.php",
            data: {
                    opcion:1,
                    finca:finca
                  },
            success: function(res)
            {
              if(res.estado === "ERROR"){
                alert("jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');");
                console.log("Error:"+ res.msg);
              }
              else if(res.estado === "OK") {
                var datos = [];
                for( var i=0; i < res.informePluviometria.length; i++){
                  datos[i] =  { y: res.informePluviometria[i].fecha, a: res.informePluviometria[i].medicion };
                }
                //Recargar 
                
                Morris.Line({
                  element: 'morris-area-chart',
                  data: datos,
                  xkey: 'y',
                  ykeys: ['a', ''],
                  labels: ['Medicion', '']
                });
                $("#informeFinca").modal('hide');
              }
            }
        });
    }




}

//
$(document).ready(function(){
  


});