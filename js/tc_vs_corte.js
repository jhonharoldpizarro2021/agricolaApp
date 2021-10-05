/*  /// 
/////////////  FUNCION ENCARGADA DE GENERAR EL GRAFICO  X FINCA
//////*/
function informeFinca(){
  $("#modalSpinner").modal('show');
  $("#morris-area-chart").html("");
  var finca = $("#finca").val();
  if( finca === ""){
      alert("Seleccione la Finca");
  }
  else{
    $("#informeFinca").modal('hide');
    $.ajax({
        cache:false,
        dataType:"json",
        type:"POST",
        url: "./querys/q_tc_vs_corte.php",
        data: {
                opcion:1,
                finca:finca
              },
        /*success: function(res){
          if(res.estado === "ERROR"){
            alert("jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');");
            console.log("Error:"+ res.msg);
          }
          else if(res.estado === "OK"){

            var datos = [];
            for( var i=0; i < res.informe.length; i++){
              datos[i] =  { 
                            y: res.informe[i].corte, 
                            a: res.informe[i].tc
                          };
            }
            //Recargar 
            Morris.Bar({
              element: 'morris-area-chart',
              data: datos,
              xkey: 'y',
              ykeys: 'a',
              labels: 'TCT'
            });
            $("#modalSpinner").modal('hide');
            $("#finca").val("NULL");
          }
          else if(res.estado === "EMPTY"){
            jAlert('La Finca No Cuenta con Registro de Pluviometria', 'SIN REGISTROS DE PLUVIOMETRIA');
            $("#morris-area-chart").html("");
            $("#finca").val("NULL");
          }            
        }*/
        success: function(res)  {
          if(res.estado === "ERROR"){
            alert("jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');");
            $("#modalSpinner").modal('hide');
            console.log("Error:"+ res.msg);
          }
          else if(res.estado === "OK"){
            $("#resultado").fadeIn(350);
            $("#informeFinca").modal('hide');
            for( var i=0; i < res.informeSuertes.length; i++){
              var informes = res.informeSuertes[i].informes;
              var idSuerte = res.informeSuertes[i].idSuerte;
              var nSuerte = res.informeSuertes[i].nSuerte;
              var idFinca = res.informeSuertes[i].idFinca;
              var nFinca = res.informeSuertes[i].nFinca;
              var datos = [];
              for( var j=0; j < informes.length; j++){
                datos[j] =  { 
                            y: 'Corte '+ informes[j].corte, 
                            a: informes[j].tc 
                          };
              }
              $("#morris-area-chart").append('<div class="panel panel-tierra"><div class="panel-heading">  <div class="row">    <div class="col-md-6">  <h4>'+nSuerte+' => '+nFinca+'</h4>    </div>    </div> </div><div class="panel-body">   <div id="grafico'+idSuerte+'"></div>  </div>');
              //Recargar 
              Morris.Bar({
                element: 'grafico'+idSuerte,
                data: datos,
                xkey: ['y'],
                ykeys: ['a'],
                labels: [' '],
                gridTextWeight: 'bold',
                yLabelFormat : function (y) { return y.toString() + ' TC'; },
              });
            }
            $("#modalSpinner").modal('hide');
            $("#finca").val("NULL");
          }
          else if(res.estado === "EMPTY"){
            jAlert('La Finca No Cuenta con Registro de Pluviometria', 'SIN REGISTROS DE PLUVIOMETRIA');
            $("#morris-area-chart").html("");
            $("#resultado").fadeOut(500);
            $("#modalSpinner").modal('hide');
            $("#finca").val("NULL");
          }            
        }
    });
  }
}
//
$(document).ready(function(){
});