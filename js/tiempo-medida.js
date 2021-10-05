function editarTiempo(id_unidades_tiempo_medida,descripcion)
{
  //Asignar valores de edición
  $("#edit_id_unidades_tiempo_medida").val(id_unidades_tiempo_medida);
  $("#edit_descripcion").val(descripcion);
  $("#editTiempo").modal('show'); //Mostrar PopUp
}

function guardarEdicion()
{
  var id_unidades_tiempo_medida = $("#edit_id_unidades_tiempo_medida").val();
  var descripcion = $("#edit_descripcion").val();
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
      url: "./querys/q-tiempo-medida.php",
      data: {
              opcion:2,
              descripcion:descripcion,
              id_unidades_tiempo_medida:id_unidades_tiempo_medida
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
          jAlert('¡Labor actualizada con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  }
  $("#editTiempo").modal('hide');
}


function recargarDatos()
{
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-tiempo-medida.php",
    data: {opcion:4},
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        alert("jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');");
        console.log("Error:"+ res.msg);
      }else if(res.estado === "OK")
      {
        var datos = [];
        for( var i=0; i < res.tiempo.length; i++)
        {
          datos[i] = [
                        res.tiempo[i].descripcion,
                        '<a data-toggle="modal" data-target="#editar" onclick="editarTiempo(\''+ res.tiempo[i].id_unidades_tiempo_medida +'\',\''+ res.tiempo[i].descripcion +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarTiempo(\''+ res.tiempo[i].id_unidades_tiempo_medida +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_tiempo').DataTable();
        table.destroy();
        $('#tabla_tiempo').DataTable( {
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


function borrarTiempo(id_unidades_tiempo_medida)
{
  if( 
    confirm("¿Desea borrar la unidad de Tiempo?") 
    )
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-tiempo-medida.php",
      data: {
              opcion:3,
              id_unidades_tiempo_medida:id_unidades_tiempo_medida
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar la unidad de Tiempo', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('Unidad de Tiempo eliminada con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}


function nuevoTiempo()
{
  var descripcion = $("#descripcion").val();
  //Validar campos
  if( descripcion === "")
  {
    alert("Por favor ingrese el Nombre");
  }else if( descripcion === "" )
  {
    alert("Por favor ingrese el Nombre");
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-tiempo-medida.php",
      data: {
              opcion:1,
              descripcion:descripcion,
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Unidad Tiempo creada con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}


function recargarFomGuardar()
{
  $("#descripcion").val("");
  $("#nuevoTiempo").modal("hide");
}
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
      url: "./querys/q-tiempo-medida.php",
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
          jAlert('¡Unidad Agrícola actualizada con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  });

  recargarFomGuardar();

  $('#tabla_tiempo').DataTable( {
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
