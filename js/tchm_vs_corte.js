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
        url: "./querys/q_tchm_vs_corte.php",
        data: {
                opcion:1,
                finca:finca
              },
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
                            a: informes[j].tchm 
                          };
              }
              $("#morris-area-chart").append('<div class="panel panel-tierra"><div class="panel-heading">  <div class="row">    <div class="col-md-6">  <h4>'+nSuerte+' => '+nFinca+'</h4>    </div>    </div> </div><div class="panel-body">   <div id="grafico'+idSuerte+'"></div>  </div>');
              //Recargar 
              Morris.Bar({
                element: 'grafico'+idSuerte,
                data: datos,
                xkey: 'y',
                ykeys: 'a',
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
            $("#resultado").fadeOut(500);
            $("#morris-area-chart").html("");
            $("#finca").val("NULL");
            $("#modalSpinner").modal('hide');
          }            
        }
    });
  }
}
//
$(document).ready(function(){
});