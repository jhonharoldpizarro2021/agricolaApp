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
        url: "./querys/q_informe_costos.php",
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
              var colores = [];
              var datosConvenciones = "";
              var tablaConvenciones = [];
              for( var j=0; j < informes.length; j++){
                datos[j] =  { 
                              label: informes[j].tc, 
                              value: informes[j].valor
                            };
                colores[j] = res.colores[informes[j].tc];
              }
              datosConvenciones += '<div class="panel panel-success"><div class="panel-heading"> <div class="row">   <div class="col-md-12">      <h4>'+nSuerte+' => '+nFinca+'</h4>    </div>  </div></div><div class="panel-body">  <div class="row">       <div class="col-md-4">      <div id="convenciones">                    <div class="table-responsive">              <table class="table inforTable">               <tbody>';
              for( var k=0; k < datos.length; k++){
              colores[k] = res.colores[informes[k].tc];
              tablaConvenciones[k] = [
                              datosConvenciones += '<tr style="background: '+ colores[k] +' ">',
                              datosConvenciones += '<td>'+ datos[k].label +'</td>',
                              datosConvenciones += '<td>'+ Math.floor(datos[k].value) +'</td>',
                              datosConvenciones += '</tr>',
                        ];
              }                   
              datosConvenciones += '</tbody>              </table>            </div>              </div>    </div> <div class="col-md-8">      <div class="grafico" id="grafico'+idSuerte+'"></div>    </div>  </div></div> </div>';        
              $("#morris-area-chart").append(datosConvenciones);
              //Recargar 
              Morris.Donut({
                element: 'grafico'+idSuerte,
                data: datos,
                colors: colores
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