function editarProveedor(id_proveedor,nombre,nit,direccion,telefono,email,comentarios)
{
  //Asignar valores de edición
  $("#edit_id_proveedor").val(id_proveedor);
  $("#edit_nombre").val(nombre);
  $("#edit_nit").val(nit);
  $("#edit_direccion").val(direccion);
  $("#edit_telefono").val(telefono);
  $("#edit_email").val(email);
  $("#edit_comentarios").val(comentarios);
  $("#editProveedor").modal('show'); //Mostrar PopUp
}

function guardarEdicion()
{
  var id_proveedor = $("#edit_id_proveedor").val();
  var nombre = $("#edit_nombre").val();
  var nit = $("#edit_nit").val();
  var direccion = $("#edit_direccion").val();
  var telefono = $("#edit_telefono").val();
  var email = $("#edit_email").val();
  var comentarios = $("#edit_comentarios").val();  
  //Validar campos
  if( nombre === "")
  {
    alert("Falta Nombre");
  }else if( nit === "" )
  {
    alert("Falta nit");      
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-proveedores.php",
      data: {
              opcion:2,
              nombre:nombre,
              nit:nit,
              direccion:direccion,
              telefono:telefono,
              email:email,
              comentarios:comentarios,
              id_proveedor:id_proveedor
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
          jAlert('Proveedor actualizado con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  }
  $("#editProveedor").modal('hide');
}


function recargarDatos()
{
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-proveedores.php",
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
        for( var i=0; i < res.proveedores.length; i++)
        {
          datos[i] = [
                        res.proveedores[i].nombre,
                        res.proveedores[i].nit,
                        res.proveedores[i].direccion,
                        res.proveedores[i].telefono,
                        res.proveedores[i].email,
                        res.proveedores[i].comentarios.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        '<a data-toggle="modal" data-target="#editar" onclick="editarProveedor(\''+ res.proveedores[i].id_proveedor +'\',\''+ res.proveedores[i].nombre +'\',\''+ res.proveedores[i].nit +'\',\''+ res.proveedores[i].direccion +'\',\''+ res.proveedores[i].telefono +'\',\''+ res.proveedores[i].email +'\',\''+ res.proveedores[i].comentarios.replace(/(?:\\[rn]|[\r\n]+)+/g, "\\n") +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarProveedor(\''+ res.proveedores[i].id_proveedor +'\')" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_proveedor').DataTable();
        table.destroy();
        $('#tabla_proveedor').DataTable( {
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
function borrarProveedor(id_proveedor)
{
  if( 
    confirm("¿Desea borrar la unidad de Medida?") 
    )
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-proveedores.php",
      data: {
              opcion:3,
              id_proveedor:id_proveedor
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar la unidad de Medida', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('Unidad de Medida eliminada con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
function nuevoProveedor()
{
  var nombre = $("#nombre").val();
  var nit = $("#nit").val();
  var direccion = $("#direccion").val();
  var telefono = $("#telefono").val();
  var email = $("#email").val();
  var comentarios = $("#comentarios").val();
  //Validar campos
  if( nombre === "")
  {
    alert("Por favor ingrese el Nombre");
  }else if( nit === "" )
  {
    alert("Por favor ingrese el Nit");
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-proveedores.php",
      data: {
              opcion:1,
              nombre:nombre,
              nit:nit,
              direccion:direccion,
              telefono:telefono,
              email:email,
              comentarios:comentarios
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Prooveedor creado con exito!', 'CONFIRMACION');
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
  $("#nombre").val("");
  $("#nit").val("");
  $("#direccion").val("");
  $("#telefono").val("");
  $("#email").val("");
  $("#comentarios").val("");
  $("#nuevoProveedor").modal("hide");
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
      url: "./querys/q-proveedores.php",
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
          jAlert('¡Campo actualizado con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  });

  recargarFomGuardar();

  $('#tabla_proveedor').DataTable( {
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
