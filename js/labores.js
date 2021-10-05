function editarLabor(id_labores,descripcion_corta,id_labor_procedente,id_labor_posterior,unidades_tiempo,cantidad_tiempo,descripcion_ampliada)
{
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-labores.php",
    data: {
            opcion:6
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        jAlert('¡¡Lo sentimos, ocurrió un error al consultar el listado de labores', 'ERROR');
        console.log("Error:"+ res.msg);
      }else if(res.estado === "OK")
      {
        var lista = '<option value="" disabled="disable" selected="true" >Labor Precedente</option>';
        lista += '<option value="NULL" >Ninguna</option>';
        for( var i=0; i < res.labores.length; i++)
        {
          lista += '<option value="'+ res.labores[i].id +'">'+ res.labores[i].descripcion +'</option>';
        }
        //Cargar listas con los datos de la BDD
        $("#edit_id_labor_procedente").html(lista);
        $("#edit_id_labor_posterior").html(lista);
        //Asignar valores de edición
        $("#edit_id_labores").val(id_labores);
        $("#edit_descripcion_corta").val(descripcion_corta);
        $("#edit_id_labor_procedente").val(id_labor_procedente === '' ? "NULL" : id_labor_procedente);
        $("#edit_id_labor_posterior").val(id_labor_posterior === '' ? "NULL" : id_labor_posterior);
        $("#edit_unidades_tiempo").val(unidades_tiempo === '' ? "NULL" : unidades_tiempo);
        $("#edit_cantidad_tiempo").val(cantidad_tiempo);
        $("#edit_descripcion_ampliada").val(descripcion_ampliada);
        $("#editLabor").modal('show'); //Mostrar PopUp
      }
    }
  });
}

function guardarEdicion()
{
  var id_labores = $("#edit_id_labores").val();
  var descripcion_corta = $("#edit_descripcion_corta").val();
  var id_labor_procedente = $("#edit_id_labor_procedente").val();
  var id_labor_posterior = $("#edit_id_labor_posterior").val();
  var unidades_tiempo = $("#edit_unidades_tiempo").val();
  var cantidad_tiempo = $("#edit_cantidad_tiempo").val();
  var descripcion_ampliada = $("#edit_descripcion_ampliada").val();
  //Validar campos
  if( descripcion_corta === "")
  {
    alert("Falta procede");
  }else if( id_labor_procedente === "" )
  {

  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-labores.php",
      data: {
              opcion:2,
              descripcion_corta:descripcion_corta,
              id_labor_procedente:id_labor_procedente,
              id_labor_posterior:id_labor_posterior,
              unidades_tiempo:unidades_tiempo,
              cantidad_tiempo:cantidad_tiempo,
              descripcion_ampliada:descripcion_ampliada,
              id_labores:id_labores
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
  $("#editLabor").modal('hide');
}


function recargarDatos()
{
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-labores.php",
    data: {opcion:4},
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }else if(res.estado === "OK")
      {
        var datos = [];
        for( var i=0; i < res.labores.length; i++)
        {
          datos[i] = [
                        res.labores[i].descripcion_corta,
                        res.labores[i].desc_corta_labor_procedente,
                        res.labores[i].desc_corta_labor_posterior,
                        res.labores[i].unidad_medida + ' ' + res.labores[i].cantidad_tiempo,
                        res.labores[i].descripcion_ampliada.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        '<a data-toggle="modal" data-target="#editar" onclick="editarLabor(\''+ res.labores[i].id_labores +'\',\''+ res.labores[i].descripcion_corta +'\',\''+ res.labores[i].id_labor_procedente +'\',\''+ res.labores[i].id_labor_posterior +'\',\''+ res.labores[i].id_unidades_tiempo_medida +'\',\''+ res.labores[i].cantidad_tiempo +'\',\''+ res.labores[i].descripcion_ampliada.replace(/(?:\\[rn]|[\r\n]+)+/g, "\\n") +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarLabor(\''+ res.labores[i].id_labores +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_labores').DataTable();
        table.destroy();
        $('#tabla_labores').DataTable( {
            data: datos,
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
      }
    }
  });
}


function borrarLabor(id_labores)
{
  if( confirm("¿Desea borrar la unidad agrícola?") )
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-labores.php",
      data: {opcion:3,id_labores:id_labores},
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar la labor', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Labor eliminada con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}

function abrirNuevaLabor()
{
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-labores.php",
    data: {
            opcion:6
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        jAlert('¡¡Lo sentimos, ocurrió un error al consultar el listado de labores', 'ERROR');
        console.log("Error:"+ res.msg);
      }else if(res.estado === "OK")
      {
        var lista = '<option value="NULL" disabled="disable" selected="true" >Labor Precedente</option>';
        lista += '<option value="NULL" >Ninguna</option>';
        for( var i=0; i < res.labores.length; i++)
        {
          lista += '<option value="'+ res.labores[i].id +'">'+ res.labores[i].descripcion +'</option>';
        }
        $("#id_labor_procedente").html(lista);
        $("#id_labor_posterior").html(lista);
        $("#nuevaLabor").modal("show");
      }
    }
  });
}

function nuevaLabor() 
{
  var descripcion_corta = $("#descripcion_corta").val();
  var id_labor_procedente = $("#id_labor_procedente").val();
  var id_labor_posterior = $("#id_labor_posterior").val();
  var unidades_tiempo = $("#unidades_tiempo").val();
  var cantidad_tiempo = $("#cantidad_tiempo").val();
  var descripcion_ampliada = $("#descripcion_ampliada").val();
  //Validar campos
  if( descripcion_corta === "")
  {
    alert("Por favor ingrese el Nombre");
  }
  else if( $("#id_labor_procedente option:selected").val() === "Labor Procedente" )
  {
    alert('Por favor ingrese La Labor Procedente, de no tener selecciona "NINGUNA"');
  }
  else if( $("#id_labor_posterior option:selected").val() === "Labor Posterior" )
  {
    alert('Por favor ingrese La Labor Posterior, de no tener selecciona "NINGUNA"');
  }
  else if( unidades_tiempo === "" )
  {
    alert("Por favor ingrese La Unidad de Tiempo");
  }
  else if( cantidad_tiempo === "" )
  {
    alert("Por favor ingrese El tiempo estimado");
  }
  else{
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-labores.php",
      data: {
              opcion:1,
              descripcion_corta:descripcion_corta,
              id_labor_procedente:id_labor_procedente,
              id_labor_posterior:id_labor_posterior,
              unidades_tiempo:unidades_tiempo,
              cantidad_tiempo:cantidad_tiempo,
              descripcion_ampliada:descripcion_ampliada
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Labor creada con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
function recargarFomGuardar()
{
  $("#descripcion_corta").val("");
  $("#id_labor_procedente").val("NULL");
  $("#id_labor_posterior").val("NULL");
  $("#unidades_tiempo").val("NULL");
  $("#cantidad_tiempo").val("");
  $("#descripcion_ampliada").val("");
  $("#nuevaLabor").modal("hide");
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
      url: "./querys/q-labores.php",
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
          jAlert('¡Labor actualizada con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  });

  recargarFomGuardar();

  $('#tabla_labores').DataTable( {
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
