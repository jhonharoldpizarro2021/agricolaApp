function nuevoRegistroPluviometria(){
  var finca = $("#finca").val();
  var estacion = $("#estaciones").val();
  var fecha = $("#fecha").val();
  var medicion = $ ("#medicion").val();
  //Validar campos
  if( finca === null ){
    jAlert("Por favor seleccione la Finca",'DATOS INCOMPLETOS');
  }
  else if( estacion === null ){
    jAlert("Por favor seleccione la Estaci&oacute;n de Pluviometria", 'DATOS INCOMPLETOS');
  }
  else if( fecha === "" ){
    jAlert("Por favor ingrese la Fecha", 'DATOS INCOMPLETOS');
  }
  else if( medicion === "" ){
    jAlert("Por favor ingrese el valor de Medici&oacute;n", 'DATOS INCOMPLETOS');
  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_registro_pluviometria.php",
      data: {
              opcion:1,
              finca:finca,
              estacion:estacion,
              fecha:fecha,
              medicion:medicion
            },
      success: function(res){
        if(res.estado === "ERROR"){
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK"){
          jAlert('¡Registro Pluviometria creada con exito!', 'CONFIRMACION');
          recargarDatos();
          $("#nuevoRegistroPluviometria").modal("hide");
          recargarFomGuardar();
        }
      }
    });
  }
}
//
//
function recargarFomGuardar(){
  $("#descripcion").val("");
  $("#finca").val("NULL");
}
//
//
function editarRegistroPluviometria(id,fecha,medicion,finca,estacion){
  //Asignar valores de edición
  $("#edit_id").val(id);
  $("#edit_estaciones option:selected").val( estacion );
  $("#edit_estaciones option:selected").text( estacion );
  $("#edit_finca option:selected").val( finca );
  $("#edit_finca option:selected").text( finca );
  $("#edit_fecha").val(fecha);
  $("#edit_medicion").val(medicion);
  $("#editRegistroPluviometria").modal('show'); //Mostrar PopUp
}
//
//
function guardarEdicion(){
  var id = $("#edit_id").val();
  var fecha = $("#edit_fecha").val();
  var medicion = $("#edit_medicion").val();
  var estacion = $("#edit_estaciones").val();
  var finca = $("#edit_finca").val();
  //Validar campos
  if( fecha === ""){
    jAlert("Falta Fecha", "CAMPOS INCOMPLETOS");
  }
  else if( medicion === "" ){
    jAlert("Falta Valor de Medici&oacute;n", "CAMPOS INCOMPLETOS");
  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_registro_pluviometria.php",
      data: {
              opcion:2,
              fecha:fecha,
              medicion:medicion,
              estacion:estacion,
              finca:finca,
              id:id
            },
      success: function(res){
        if(res.estado === "ERROR"){
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          recargarDatos();
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK") {
          jAlert('¡Registro Actualizado con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  }
  $("#editRegistroPluviometria").modal('hide');
}
function borrarRegistroPluviometria(id){
  if( confirm("¿Desea borrar el Registro?") ){
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_registro_pluviometria.php",
      data: {
              opcion:3,
              id:id
            },
      success: function(res){
        if(res.estado === "ERROR"){
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar el registro', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK"){
          jAlert('Registro eliminado con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  }
}
//
function recargarDatos(){
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q_registro_pluviometria.php",
    data: {
            opcion:4
          },
    success: function(res){
      if(res.estado === "ERROR"){
        alert("jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');");
        console.log("Error:"+ res.msg);
      }
      else if(res.estado === "OK"){
        var datos = [];
        for( var i=0; i < res.movimientoPluviometria.length; i++){
          datos[i] = [
                        res.movimientoPluviometria[i].fecha,
                        res.movimientoPluviometria[i].medicion,
                        res.movimientoPluviometria[i].estacion,
                        res.movimientoPluviometria[i].finca,
                        '<a data-toggle="modal" data-target="#editar" onclick="editarRegistroPluviometria(\''+ res.movimientoPluviometria[i].id +'\',\''+ res.movimientoPluviometria[i].fecha +'\',\''+ res.movimientoPluviometria[i].medicion +'\',\''+ res.movimientoPluviometria[i].finca +'\',\''+ res.movimientoPluviometria[i].estacion +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarRegistroPluviometria(\''+ res.movimientoPluviometria[i].id +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_pluviometria').DataTable();
        table.destroy();
        $('#tabla_pluviometria').DataTable( {
            data: datos,
            responsive: true,
            "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
        } );
      }
    }
  });
}
//
$(document).ready(function(){
  recargarFomGuardar();
  $('#tabla_pluviometria').DataTable( {
      responsive: true,
      "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
  });


  $("#finca").change(function () {
           $("#finca option:selected").each(function () {
            var id_finca = $(this).val();
            $.post("est.php", { id_finca:id_finca }, function(data){
                $("#estaciones").html(data);
            });            
        });
   });
   $("#edit_finca").change(function () {
           $("#edit_finca option:selected").each(function () {
            var id_finca = $(this).val();
            $.post("est.php", { id_finca:id_finca }, function(data){
                $("#edit_estaciones").html(data);
            });            
        });
   });


});