function editarCosto(id,descripcion,comentarios){
   //Asignar valores de edición
  $("#edit_id").val(id);
  $("#edit_descripcion").val(descripcion);
  $("#edit_comentarios").val(comentarios);
  $("#editCosto").modal('show'); //Mostrar PopUp  
}
/*
// FUNCION ENCARGADA DE 
*/
function guardarEdicion(){
  var id = $("#edit_id").val();
  var descripcion = $("#edit_descripcion").val();
  var comentarios = $("#edit_comentarios").val();
  //Validar campos
  if( descripcion === "")
  {
    alert("Falta Nombre");
  }else if( descripcion === "" )
  {

  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-costos-indirectos.php",
      data: {
              opcion:2,
              descripcion:descripcion,
              comentarios:comentarios,
              id:id       
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          recargarDatos();
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Registro Actualizado con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  }
  $("#editCosto").modal('hide');
}
/*
// FUNCION ENCARGADA DE 
*/
function recargarDatos(){
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-costos-indirectos.php",
    data: {
            opcion:4
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }else if(res.estado === "OK")
      {
        var datos = [];
        for( var i=0; i < res.costos.length; i++)
        {
          datos[i] = [
                        res.costos[i].descripcion,
                        res.costos[i].comentarios.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        '<a data-toggle="modal" data-target="#editar" onclick="editarCosto(\''+ res.costos[i].id +'\',\''+ res.costos[i].descripcion +'\',\''+ res.costos[i].comentarios.replace(/(?:\\[rn]|[\r\n]+)+/g, "\\n") +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarCosto(\''+ res.costos[i].id +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_costo').DataTable();
        table.destroy();
        $('#tabla_costo').DataTable( {
            data: datos,
            responsive: true,
            "order": [],
            "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
        } );
      }
    }
  });
}
/*
// FUNCION ENCARGADA DE 
*/
function borrarCosto(idCostos){
  if( 
    confirm("¿Desea borrar el Registro?") 
    )
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-costos-indirectos.php",
      data: {
              opcion:3,
              idCostos:idCostos
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar el Registro', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Registro eliminado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
/*
// FUNCION ENCARGADA DE CREAR EL NUEVO COSTO
*/
function nuevoCosto(){
  var descripcion = $("#descripcion").val();
  var comentarios = $("#comentarios").val();
  var tipo = $("#tipo").val();
  //Validar campos
  if( descripcion === "")
  {
    alert("Por favor ingrese el Nombre");
  }
  else if( descripcion === "" )
  {
    alert("Por favor ingrese el Nombre");
  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-costos-indirectos.php",
      data: {
              opcion:1,
              descripcion:descripcion,
              comentarios:comentarios,
              tipo:tipo
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Nuevo Registro creado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
/*
// FUNCION ENCARGADA DE 
*/
function recargarFomGuardar(){
  $("#descripcion").val("");
  $("#comentarios").val("");
  $("#nuevoCosto").modal("hide");
}
/*
// DOCUMENT ready
*/
$(document).ready(function(){
  //Editar campos tabla
  $.fn.editable.defaults.mode = 'popup';
  $('.xedit').editable();
  $(document).on('click','.editable-submit',function()
  {
    var id = $(this).closest('td').children('span').attr('id');
    var campo_q = $(this).closest('td').children('span').attr('campo_query');
    var valor_q = $('.editable-input .input-sm').val();
    $.ajax({
      url: "./querys/q-costos-indirectos.php",
      type: 'POST',
      dataType:"json",
      data: {
              opcion:5,
              campo_query:campo_q,
              valor_query:valor_q,
              id:id
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          recargarDatos();
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Registro Actualizado con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  });

  recargarFomGuardar();

  $('#tabla_costo').DataTable( {
      responsive: true,
      "language": {
        "decimal":        "",
        "emptyTable":     "No hay datos",
        "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
        "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
        "infoFiltered":   "(Filtrando de _MAX_ total de registros)",
        "infoPostFix":    "",
        "thousands":      ",",
        "lengthMenu":     "Mostrar _MENU_ registros",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search":         "Buscar:",
        "zeroRecords":    "No se encontratron registros",
        "paginate": {
            "first":      "Primero",
            "last":       "Ultimo",
            "next":       "Siguiente",
            "previous":   "Anterior"
        },
        "aria": {
          "sortAscending":  ": activate to sort column ascending",
          "sortDescending": ": activate to sort column descending"
        }
      }
  } );
});
