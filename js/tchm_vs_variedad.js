/*  /// 
/////////////  FUNCION ENCARGADA DE GENERAR EL GRAFICO  X FINCA
//////*/
function informeFinca(){
  $("#modalSpinner").modal('show');
  $("#morris-area-chart").html("");
  var finca = $("#finca").val();
  var nFinca = $("#finca option:selected").text();
  if( finca === null){
      alert("Seleccione la Finca");
  }
  else{
    $("#informeFinca").modal('hide');
    $.ajax({
        cache:false,
        dataType:"json",
        type:"POST",
        url: "./querys/q_tchm_vs_variedad.php",
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
            $("#resultado").fadeIn(350);
            $("#nFinca").html(nFinca);
            $("#informeFinca").modal('hide');
            var datos = [];
            for( var i=0; i < res.informe.length; i++){
              datos[i] =  { 
                            y: 'Variedad '+res.informe[i].variedad, 
                            a: res.informe[i].tchm 
                          };
            }
            //Recargar 
            Morris.Bar({
              element: 'morris-area-chart',
              data: datos,
              xkey: 'y',
              ykeys: 'a',
              labels: [' '],
              gridTextWeight: 'bold',
              yLabelFormat : function (y) { return y.toString() + ' TCHM'; },
            });
            $("#modalSpinner").modal('hide');
            $("#finca").val("NULL");
          }
          else if(res.estado === "EMPTY"){
            jAlert('La Finca No Cuenta con Registro de Pluviometria', 'SIN REGISTROS DE PLUVIOMETRIA');
            $("#morris-area-chart").html("");
            $("#finca").val("NULL");
          }            
        }
        /*success: function(res)  {
          if(res.estado === "ERROR"){
            alert("jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');");
            $("#modalSpinner").modal('hide');
            console.log("Error:"+ res.msg);
          }
          else if(res.estado === "OK"){
            $("#informeFinca").modal('hide');
            for( var i=0; i < res.informeSuertes.length; i++){
              var informes = res.informeSuertes[i].informes;
              var idSuerte = res.informeSuertes[i].idSuerte;
              var idFinca = res.informeSuertes[i].idFinca;
              var datos = [];
              for( var j=0; j < informes.length; j++){
                datos[j] =  { 
                            y: informes[j].variedad, 
                            a: informes[j].rendimiento 
                          };
              }
              $("#morris-area-chart").append('<div class="panel panel-tierra"><div class="panel-heading">  <div class="row">    <div class="col-md-6">  <h4>ID Suerte # '+idSuerte+' ID Finca # '+idFinca+'</h4>    </div>    </div> </div><div class="panel-body">   <div id="grafico'+idSuerte+'"></div>  </div>');
              //Recargar 
              Morris.Bar({
                element: 'grafico'+idSuerte,
                data: datos,
                xkey: 'y',
                ykeys: 'a',
                labels: 'Rendimiento'
              });
            }
            $("#modalSpinner").modal('hide');
            $("#finca").val("NULL");
          }
          else if(res.estado === "EMPTY"){
            jAlert('La Finca No Cuenta con Registro de Pluviometria', 'SIN REGISTROS DE PLUVIOMETRIA');
            $("#morris-area-chart").html("");
            $("#finca").val("NULL");
          }            
        }*/
    });
  }
}
//
$(document).ready(function(){
});