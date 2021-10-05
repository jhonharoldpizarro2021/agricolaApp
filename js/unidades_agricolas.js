function editarUnidad(id,nombre,codigo,id_padre,descp,area)
{
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-unidades-agricolas.php",
    data: {
            opcion:6
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        jAlert('¡¡Lo sentimos, ocurrió un error al consultar el listado de unidades', 'ERROR');
        console.log("Error:"+ res.msg);
      }else if(res.estado === "OK")
      {
        var lista = '<option value="" disabled="disable" selected="true" >Pertenece a:</option>';
        lista += '<option value="NULL" >Ninguna</option>';
        for( var i=0; i < res.unidades.length; i++)
        {
          lista += '<option value="'+ res.unidades[i].id +'">'+ res.unidades[i].descripcion +'</option>';
        }
        //Cargar listas con los datos de la BDD
        $("#edit_id_padre").html(lista);
       //Asignar valores de edición
        $("#edit_id_unidad").val(id);
        $("#edit_nombre").val(nombre);
        $("#edit_codigo").val(codigo);
        $("#edit_id_padre").val( id_padre === '' ? "NULL" : id_padre );
        $("#edit_descripcion").val(descp);
        $("#edit_area").val(area);
        $("#editUnidad").modal('show');
      }
    }
  });
}

function guardarEdicion()
{
  var id = $("#edit_id_unidad").val();
  var nombre = $("#edit_nombre").val();
  var codigo = $("#edit_codigo").val();
  var id_padre = $("#edit_id_padre").val();
  var descp = $("#edit_descripcion").val();
  var area = $("#edit_area").val();
  //Validar campos
  if( nombre === "")
  {
    alert("Por favor ingrese el nombre");
  }else if( codigo === "" )
  {

  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-unidades-agricolas.php",
      data: {opcion:2,nombre:nombre,id_padre:id_padre,codigo:codigo,descp:descp,area:area,id:id},
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
  }
  $("#editUnidad").modal('hide');
}

function recargarDatos()
{
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-unidades-agricolas.php",
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
        for( var i=0; i < res.unidades.length; i++)
        {
          datos[i] = [
                        res.unidades[i].codigo,
                        res.unidades[i].nombre,
                        res.unidades[i].nombre_padre,
                        res.unidades[i].descp.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        res.unidades[i].area,
                        '<a data-toggle="modal" data-target="#editar" onclick="editarUnidad(\''+ res.unidades[i].id +'\',\''+ res.unidades[i].nombre +'\',\''+ res.unidades[i].codigo +'\',\''+ res.unidades[i].id_padre +'\',\''+ res.unidades[i].descp.replace(/(?:\\[rn]|[\r\n]+)+/g, "\\n") +'\',\''+ res.unidades[i].area +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarUnidad(\''+ res.unidades[i].id +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_unidades').DataTable();
        table.destroy();
        $('#tabla_unidades').DataTable( {
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

function borrarUnidad(id)
{
  if( confirm("¿Desea borrar la unidad agrícola?") )
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-unidades-agricolas.php",
      data: {opcion:3,id:id},
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar la unidad', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Unidad Agrícola eliminada con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
function abrirNuevaUnidad()
{
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-unidades-agricolas.php",
    data: {
            opcion:6
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        jAlert('¡¡Lo sentimos, ocurrió un error al consultar el listado de unidades', 'ERROR');
        console.log("Error:"+ res.msg);
      }else if(res.estado === "OK")
      {
        var lista = '<option value="NULL" disabled="disable" selected="true" >Pertenece a:</option>';
        lista += '<option value="NULL" >Ninguna</option>';
        for( var i=0; i < res.unidades.length; i++)
        {
          lista += '<option value="'+ res.unidades[i].id +'">'+ res.unidades[i].descripcion +'</option>';
        }
        $("#id_padre").html(lista);
        $("#nuevaUnidad").modal("show");
      }
    }
  });
}
function nuevaUnidad()
{
  var nombre = $("#nombre").val();
  var codigo = $("#codigo").val();
  var id_padre = $("#id_padre").val();
  var descp = $("#descripcion").val();
  var area = $("#area").val();
  //Validar campos
  if( nombre === "")
  {
    alert("Por favor ingrese el nombre");
  }else if( codigo === "" )
  {

  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-unidades-agricolas.php",
      data: {opcion:1,nombre:nombre,id_padre:id_padre,codigo:codigo,descp:descp,area:area},
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Unidad Agrícola creada con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
function recargarFomGuardar()
{
  $("#nombre").val("");
  $("#codigo").val("");
  $("#id_padre").val("NULL");
  $("#descripcion").val("");
  $("#area").val("");
  $("#nuevaUnidad").modal("hide");
}

$(document).ready(function(){



  recargarFomGuardar();
  
  $('#tabla_unidades').DataTable( {      
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
