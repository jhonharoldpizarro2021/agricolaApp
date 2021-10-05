function nuevaEstacionPluviometria(){
  var finca = $("#finca").val();
  var descripcion = $("#descripcion").val();
  //Validar campos
  if( descripcion === ""){
    jAlert("Por favor ingrese la Descripci$oacute;n",'DATOS INCOMPLETOS');
  }
  else if( finca === "" ){
    jAlert("Por favor seleccione la Finca", 'DATOS INCOMPLETOS');
  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_estaciones_pluviometria.php",
      data: {
              opcion:1,
              finca:finca,
              descripcion:descripcion
            },
      success: function(res){
        if(res.estado === "ERROR"){
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK"){
          jAlert('¡Estacion Pluviometria creada con exito!', 'CONFIRMACION');
          recargarDatos();
          $("#nuevaEstacionPluviometria").modal("hide");
          recargarFomGuardar();
        }
      }
    });
  }
}
function recargarFomGuardar(){
  $("#descripcion").val("");
  $("#finca").val("NULL");
}

function editarEstacionPluviometria(id_estaciones_pluviometria,descripcion,finca){
  //Asignar valores de edición
  $("#edit_id").val(id_estaciones_pluviometria);
  $("#edit_descripcion").val(descripcion);
  $("#edit_finca").val(finca);
  $("#editEstacionPluviometria").modal('show'); //Mostrar PopUp
}

function guardarEdicion(){
  var id = $("#edit_id").val();
  var descripcion = $("#edit_descripcion").val();
  var finca = $("#edit_finca").val();
  //Validar campos
  if( descripcion === "")
  {
    alert("Falta Descripcion");
  }
  else if( descripcion === "" ){

  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_estaciones_pluviometria.php",
      data: {
              opcion:2,
              descripcion:descripcion,
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
  $("#editEstacionPluviometria").modal('hide');
}



function borrarEstacionPluviometria(id){
  if( confirm("¿Desea borrar el Registro?") ){
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_estaciones_pluviometria.php",
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

function recargarDatos(){
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q_estaciones_pluviometria.php",
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
        for( var i=0; i < res.estacionesPluviometria.length; i++){
          datos[i] = [
                        res.estacionesPluviometria[i].descripcion,
                        res.estacionesPluviometria[i].nFinca,
                        '<a data-toggle="modal" data-target="#editar" onclick="editarEstacionPluviometria(\''+ res.estacionesPluviometria[i].id +'\',\''+ res.estacionesPluviometria[i].descripcion +'\',\''+ res.estacionesPluviometria[i].finca +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarEstacionPluviometria(\''+ res.estacionesPluviometria[i].id +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
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



$(document).ready(function(){


  recargarFomGuardar();

  $('#tabla_pluviometria').DataTable( {
      responsive: true,
      "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
  } );
});
