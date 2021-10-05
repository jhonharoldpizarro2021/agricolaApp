/**
* Función encargada de gestionar la apertura del PopUp para el ingreso del nuevo costo indirecto
*/
function abrirNuevo(){
  $("#modalSpinner").modal("show");
  //Consultar perfiles
  $("#fecha").val("");  
  $("#descripcion").val("");  
  $("#valor").val("").maskMoney({
    symbol:'$', // Simbolo
    decimal:'.', // Separador do decimal
    precision:2, // Precisão
    thousands:',', // Separador para os milhares
    allowZero:false, // Permite que o digito 0 seja o primeiro caractere
    showSymbol:true // Exibe/Oculta o símbolo
  });
  $("#empleado").val("NULL");  
  $("#nuevo").modal('show');
}
/*
// FUNCION ENCARGADA DE CREAR 
*/
function guardarNuevo(){
  var fecha = $("#fecha").val();
  var valor = $("#valor").val().replace(/\,/g, '');
  var descripcion = $("#descripcion").val();  
  var idPersonal = $("#empleado").val();
  //Validar campos
  if( fecha === "") {
    jAlert('¡Ingresa la Fecha', 'CAMPOS INCOMPLETOS');
  }
  else if( valor === "" ) {
    jAlert('¡Ingresa el Valor', 'CAMPOS INCOMPLETOS');
  }
  else if( descripcion === "" ) {
    jAlert('¡Ingresa la Descripci&oacute;n', 'CAMPOS INCOMPLETOS');
  }
  else if( idPersonal === null ) {
    jAlert('¡Seleciona el Empleado', 'CAMPOS INCOMPLETOS');
  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_nomina.php",
      data: {
              opcion:1,              
              fecha:fecha,
              valor:valor,
              descripcion:descripcion,              
              idPersonal:idPersonal
            },
      success: function(res){
        if(res.estado === "ERROR"){
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los Datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK"){
          recargarDatos();
          recargarFormGuardar();
          $("#nuevo").modal('hide');
          jAlert('¡El Registro se realizo exitosamente!', 'CONFIRMACION');
        }
      }
    });
  }
}
/*
// FUNCION ENCARGADA DE RESTEAR EL FORM NUEVO 
*/
function recargarFormGuardar(){
  $("#empleado").val("NULL");
  $("#fecha").val("");
  $("#descripcion").val("");  
  $("#valor").val("")
}
/*
// FUNCION ENCARGADA DE ABRIR POPUP PARA EDITAR
*/
function editar(id,fecha,valor,descripcion,nEmpleado) {
  //Asignar valores de edición
  $("#edit_id").val(id);
  $("#edit_fecha").val(fecha);
  $("#edit_valor").val(valor).maskMoney({
    symbol:'$', // Simbolo
    decimal:'.', // Separador do decimal
    precision:2, // Precisão
    thousands:',', // Separador para os milhares
    allowZero:false, // Permite que o digito 0 seja o primeiro caractere
    showSymbol:true // Exibe/Oculta o símbolo
  });
  $("#edit_descripcion").val(descripcion);
  $("#edit_nEmpleado").val(nEmpleado);
  $("#editar").modal('show');
}
/*
// FUNCION ENCARGADA DE GUARDAR LA EDICION DEL COSTO INDIRECTO
*/
function guardarEdicion() {
  var id = $("#edit_id").val();
  var fecha = $("#edit_fecha").val();
  var valor = $("#edit_valor").val().replace(/\,/g, '');
  var descripcion = $("#edit_descripcion").val();
  //Validar campos
  if( fecha === ""){
    jAlert('¡Por favor ingrese la fecha', 'CAMPOS INCOMPLETOS');
  }
  else if( valor === "" ){
    jAlert('¡Por favor ingrese el valor', 'CAMPOS INCOMPLETOS');
  }
  else if( descripcion === "" ){
    jAlert('¡Por favor ingrese la descripcion', 'CAMPOS INCOMPLETOS');
  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_nomina.php",
      data: {
              opcion:2,
              id:id,
              fecha:fecha,
              valor:valor,
              descripcion:descripcion              
            },
      success: function(res){
        if(res.estado === "ERROR"){
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK"){
          jAlert('¡Registro Actualizado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFormEditar();
          $("#editar").modal('hide');
        }
      }
    });
  }
}
/*
// FUNCION ENCARGADA DE RESTEAR EL FORM EDITAR COSTO
*/
function recargarFormEditar(){
  $('#edit_id').val("");
  $('#edit_costo').val("NULL");
  $("#edit_fecha").val("");
  $("#edit_descripcion").val("");  
  $("#edit_valor").val("");
}
/*
// FUNCION ENCARGADA DE RECARGAR LOS DATOS DE LA TABLA COSTOS INDIRECETOS
*/
function recargarDatos(){
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q_nomina.php",
    data: {
            opcion:4
          },
    success: function(res){
      if(res.estado === "ERROR"){
      jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }
      else if(res.estado === "OK"){
        var datos = [];
        for( var i=0; i < res.nomina.length; i++){
          datos[i] = [
                        res.nomina[i].nEmpleado,
                        res.nomina[i].fecha,
                        res.nomina[i].valor,
                        res.nomina[i].descripcion,
                        '<div class="col-md-6"><a onclick="editar(\''+ res.nomina[i].id +'\',\''+ res.nomina[i].fecha +'\',\''+ res.nomina[i].valor +'\',\''+ res.nomina[i].descripcion +'\',\''+ res.nomina[i].nEmpleado +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></div>',
                        '<div class="col-md-6"><a onclick="borrar(\''+ res.nomina[i].id +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a></div>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla').DataTable();
        table.destroy();
        $("#tabla").DataTable({
          data: datos,
          responsive: true,
          "language":{
              "url"   :   "extensions/datatables/language/es.json"
          }
        });
      }
    }
  });
}
/*
// FUNCION ENCARGADA DE BORRAR COSTOS INDIRECTOS
*/
function borrar(id){
  if(confirm("¿Desea borrarel Registro?") ){
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_nomina.php",
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
/*
//////// Document Ready Funtions ///////////
*/
$(document).ready(function(){

/*$("#edit_valor").on({
  "focus": function(event) {
    $(event.target).select();
  },
  "keyup": function(event) {
    $(event.target).val(function(index, value) {
      return value.replace(/\D/g, "")
        .replace(/([0-9])([0-9]{2})$/, '$1.$2')
        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
    });
  }
});

*/

  $("#tabla").DataTable({
    responsive: true,
    "language":{
        "url"   :   "extensions/datatables/language/es.json"
    }
  });
  
});//end Document Ready Funtions
