/**
* Función encargada de gestionar la apertura del PopUp para el ingreso del nuevo costo indirecto
*/
function abrirNuevo(){
  $("#modalSpinner").modal("show");
  //Consultar perfiles
  $("#costo").val("NULL");
  $("#fecha").val("");
  $("#descripcion").val("");  
  $("#valor").val("").maskMoney(
      {
        symbol:'$', // Simbolo
        decimal:'.', // Separador do decimal
        precision:2, // Precisão
        thousands:',', // Separador para os milhares
        allowZero:false, // Permite que o digito 0 seja o primeiro caractere
        showSymbol:true // Exibe/Oculta o símbolo
      }
    );
  $("#nuevoCostoIndirecto").modal('show');
}
/*
// FUNCION ENCARGADA DE CREAR EL COSTO INDIRECTO
*/
function guardarNuevoCostoIndirecto(){
  var idCosto = $("#costo").val();
  var fecha = $("#fecha").val();
  var descripcion = $("#descripcion").val();  
  var valor = $("#valor").val().replace(/\,/g, '');
  //Validar campos
  if( idCosto === "")
  {
    jAlert('¡Seleciona el Costo Indirecto', 'CAMPOS INCOMPLETOS');
  }
  else if( idCosto === "" )
  {
    jAlert('¡Seleciona el Costo Indirecto', 'CAMPOS INCOMPLETOS');
  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_registro_costos_indirectos.php",
      data: {
              opcion:1,
              idCosto:idCosto,
              fecha:fecha,
              descripcion:descripcion,
              valor:valor
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los Datos', 'ERROR');
          
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡El Costo Indirecto fue registrado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFormGuardar();
          $("#nuevoCostoIndirecto").modal('hide');
        }
      }
    });
    
  }
}
/*
// FUNCION ENCARGADA DE RESTEAR EL FORM NUEVO COSTO
*/
function recargarFormGuardar(){
  $("#costo").val("NULL");
  $("#fecha").val("");
  $("#descripcion").val("");  
  $("#valor").val("")
}
/*
// FUNCION ENCARGADA DE ABRIR POPUP PARA EDITAR COSTO INDIRECTO
*/
function editarCostoIndirecto(id,costo,valor,descripcion,fecha) {
  //Asignar valores de edición
  $("#edit_id").val(id);
  $("#edit_costo").val(costo);
  $("#edit_valor").val(valor).maskMoney(
      {
        symbol:'$', // Simbolo
        decimal:'.', // Separador do decimal
        precision:2, // Precisão
        thousands:',', // Separador para os milhares
        allowZero:false, // Permite que o digito 0 seja o primeiro caractere
        showSymbol:true // Exibe/Oculta o símbolo
      }
    );
  $("#edit_descripcion").val(descripcion);
  $("#edit_fecha").val(fecha);
  $("#editarCostoIndirecto").modal('show');
}
/*
// FUNCION ENCARGADA DE GUARDAR LA EDICION DEL COSTO INDIRECTO
*/
function guardarEdicionCostoIndirecto() {
  var id = $("#edit_id").val();
  var costo = $("#edit_costo").val();
  var valor = $("#edit_valor").val();
  var descripcion = $("#edit_descripcion").val();
  var fecha = $("#edit_fecha").val();
  //Validar campos
  if( costo === "")
  {
    jAlert('¡Por favor ingrese el costo indirecto', 'CAMPOS INCOMPLETOS');
  }
  else if( valor === "" )
  {
    jAlert('¡Por favor ingrese el valor', 'CAMPOS INCOMPLETOS');
  }
  else{
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_registro_costos_indirectos.php",
      data: {
              opcion:2,
              id:id,
              costo:costo,
              valor:valor,
              descripcion:descripcion,
              fecha:fecha
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Registro Actualizado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFormEditar();
          $("#editarCostoIndirecto").modal('hide');
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
  $.ajax(
  {
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q_registro_costos_indirectos.php",
    data: {
            opcion:4
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
      jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }
      else if(res.estado === "OK")
      {
        var datos = [];
        for( var i=0; i < res.costos.length; i++)
        {
          datos[i] = [
                        res.costos[i].costo,
                        res.costos[i].valor,
                        res.costos[i].descripcion,
                        res.costos[i].fecha,
                        '<div class="col-md-6"><a onclick="editarCostoIndirecto(\''+ res.costos[i].id +'\',\''+ res.costos[i].costo +'\',\''+ res.costos[i].valor +'\',\''+ res.costos[i].descripcion +'\',\''+ res.costos[i].fecha +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a></div>',
                        '<div class="col-md-6"><a onclick="borrarCostoIndirecto(\''+ res.costos[i].id +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-plus"></i></button></a></div>'
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
function borrarCostoIndirecto(id){
  if( 
    confirm("¿Desea borrar la unidad de Tiempo?") 
    )
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_registro_costos_indirectos.php",
      data: {
              opcion:3,
              id:id
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar el registro', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
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
  

  $("#tabla").DataTable({
    responsive: true,
    "language":{
        "url"   :   "extensions/datatables/language/es.json"
    }
  });
  
});//end Document Ready Funtions
