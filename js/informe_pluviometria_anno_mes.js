/*  /// 
/////////////  FUNCION ENCARGADA DE GENERAR EL GRAFICO  X FINCA
//////*/
function informeFinca(){
  $("#modalSpinner").modal('show');
  $("#morris-area-chart").html("");
  var finca = $("#finca").val();
  var nFinca = $("#finca option:selected").text();
  var estacion = $("#estacion").val();
  var año =$("#año").val();
  if( finca === null){
      alert("Seleccione la Finca");
  }
  else if( estacion === null){
      alert("Seleccione la Finca");
  }
  if( año === ""){
      alert("Seleccione la Finca");
  }
  else{
    $.ajax({
        cache:false,
        dataType:"json",
        type:"POST",
        url: "./querys/q_informe_pluviometria_anno_mes.php",
        data: {
                opcion:1,
                finca:finca,
                estacion:estacion,
                año:año
              },
        success: function(res){
          if(res.estado === "ERROR"){
            $("#modalSpinner").modal('hide');
            alert("jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');");
            console.log("Error:"+ res.msg);
          }
          else if(res.estado === "OK"){
            $("#modalSpinner").modal('hide');
            $("#resultado").fadeIn(350);
            $("#nFinca").html(nFinca);
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
                ykeys: ['a'],
                labels: ['Medida'],
                gridTextWeight: 'bold',
                yLabelFormat : function (y) { return y.toString() + ' ml'; },
              });
              $("#informeFinca").modal('hide');
              $("#finca").val("NULL");
            /*$.each(res.informePluviometria.meses, function(mes, datos) {
              console.log(""+mes);
            })*/
            /*for( var i=0; i < res.informePluviometria.length; i++){
              datos[i] =  { 
                            y: res.informePluviometria[i].fecha, 
                            a: res.informePluviometria[i].meses[j].estacion,
                            b: res.informePluviometria[i].meses[j].medicion,
                            c: res.informePluviometria[i].medicion
                          };
            }*/
            //Recargar 
            /*Morris.Bar({
              element: 'morris-area-chart',
              data: datos,
              xkey: 'y',
              ykeys: ['a', 'b', 'c'],
              labels: ['Est. 1', 'Est. 2', 'Est. 3']
            });
            $("#informeFinca").modal('hide');
            $("#finca").val("NULL");*/

          }
          else if(res.estado === "EMPTY"){
            $("#modalSpinner").modal('hide');
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
  
  $("#finca").change(function () {
           $("#finca option:selected").each(function () {
            var id_finca = $(this).val();
            $.post("est.php", { id_finca:id_finca }, function(data){
                $("#estacion").html(data);
            });            
        });
   });
   $("#edit_finca").change(function () {
           $("#edit_finca option:selected").each(function () {
            var id_finca = $(this).val();
            $.post("est.php", { id_finca:id_finca }, function(data){
                $("#edit_estacion").html(data);
            });            
        });
   });


});