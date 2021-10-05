function editarCat(id_Cat,tipo,descripcion)
{
  //Asignar valores de edición
  $("#edit_id").val(id_Cat);  
  $("#edit_tipo").val(tipo);
  $("#edit_descripcion").val(descripcion === '' ? "NULL" : descripcion );
  $("#editCat").modal('show'); //Mostrar PopUp
}

function guardarEdicion()
{
  var id_Cat = $("#edit_id").val();
  var tipo = $("#edit_tipo").val();
  var descripcion = $("#edit_descripcion").val();
  
  //Validar campos
  if( descripcion === "")
  {
    alert("Falta Nombre");
  }else if( tipo === "NULL" )
  {
     alert("Falta Tipo");
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_cat_gastos_costos.php",
      data: {
              opcion:2,
              tipo:tipo,
              descripcion:descripcion,
              id_Cat:id_Cat
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
  $("#editCat").modal('hide');
}


function recargarDatos()
{
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q_cat_gastos_costos.php",
    data: {
            opcion:4
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        alert("jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');");
        console.log("Error:"+ res.msg);
      }else if(res.estado === "OK")
      {
        var datos = [];
        for( var i=0; i < res.cat.length; i++)
        {
          datos[i] = [
                        res.cat[i].nombre_tipo,
                        res.cat[i].descripcion.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        '<a data-toggle="modal" data-target="#editar" onclick="editarCat(\''+ res.cat[i].id_cat +'\',\''+ res.cat[i].tipo +'\',\''+ res.cat[i].descripcion.replace(/(?:\\[rn]|[\r\n]+)+/g, "\\n") +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarCat(\''+ res.cat[i].id_cat + '\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_Cat').DataTable();
        table.destroy();
        $('#tabla_Cat').DataTable( {
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


function borrarCat(id)
{
  if( 
    confirm("¿Desea borrar el Registro?") 
    )
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_cat_gastos_costos.php",
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
        }else if(res.estado === "OK")
        {
          jAlert('Registro eliminado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}


function nuevaCat()
{
  var tipo = $("#tipo").val();
  var descripcion = $("#descripcion").val();
  //Validar campos
  if( tipo === "NULL")
  {
    alert("Por favor ingrese el Tipo");
  }else if( tipo === "NULL" )
  {
    alert("Por favor ingrese el Tipo");
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q_cat_gastos_costos.php",
      data: {
              opcion:1,
              tipo,tipo,
              descripcion:descripcion
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Categoria creada con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}


function recargarFomGuardar()
{
  $("#tipo").val("NULL");
  $("#descripcion").val("");
  $("#nuevaCat").modal("hide");
}

$(document).ready(function(){
  
  recargarFomGuardar();

  $('#tabla_Cat').DataTable( {
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
