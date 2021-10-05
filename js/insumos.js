function verInsumo(id,descripcion,proveedor,unidades,fCompra,comentarios){
  $("#ver_id").html(id);
  $("#ver_nombre").html(descripcion);
  $("#ver_proveedor").html(proveedor);
  $("#ver_unidades").html(unidades);
  $("#ver_fcompra").html(fCompra);
  $("#ver_comentarios").html(comentarios);
  $("#verInsumo").modal('show');
}
function editarInsumo(id_insumos,descripcion,id_proveedor,unidades_m,fecha_compra,comentarios)
{
  $("#edit_id_insumos").val(id_insumos);
  $("#edit_descripcion").val(descripcion);
  $("#edit_proveedor_id_proveedor").val(id_proveedor);
  $("#edit_unidades_m").val(unidades_m);
  $("#edit_fecha_compra").val(fecha_compra);
  $("#edit_comentarios").val(comentarios);
  $("#editInsumos").modal('show');
}
function guardarEdicion()
{
  var id_insumos = $("#edit_id_insumos").val();
  var descripcion = $("#edit_descripcion").val();
  var id_proveedor = $("#edit_proveedor_id_proveedor").val();
  var unidades_m = $("#edit_unidades_m").val();
  var fecha_compra = $("#edit_fecha_compra").val();
  var comentarios = $("#edit_comentarios").val();
  
  //Validar campos
  if( descripcion === "")
  {
    alert("Falta nombre");
  }else if( id_proveedor === "" )
  {
    alert("Falta proveedor");
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-insumos.php",
      data: {
              opcion:2,
              descripcion:descripcion,
              comentarios:comentarios,
              id_proveedor:id_proveedor,
              unidades_m:unidades_m,
              fecha_compra:fecha_compra,              
              id_insumos:id_insumos
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
          jAlert('¡Insumo actualizado con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  }
  $("#editInsumos").modal('hide');
}
function recargarDatos()
{
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-insumos.php",
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
        for( var i=0; i < res.insumos.length; i++)
        {
          datos[i] = [
                        res.insumos[i].descripcion,
                        res.insumos[i].nombre_proveedor,
                        res.insumos[i].desc_unidades_medida,
                        res.insumos[i].fecha_compra,
                        '<td class="hideColum">'+res.insumos[i].comentarios.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>")+'</td>',
                        '<a data-toggle="modal" data-target="#editar" onclick="editarInsumo(\''+ res.insumos[i].id_insumos +'\',\''+ res.insumos[i].descripcion +'\',\''+ res.insumos[i].id_proveedor +'\',\''+ res.insumos[i].unidades_m +'\',\''+ res.insumos[i].fecha_compra +'\',\''+ res.insumos[i].comentarios.replace(/(?:\\[rn]|[\r\n]+)+/g, "\\n") +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarInsumo(\''+ res.insumos[i].id_insumos +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_insumos').DataTable();
        table.destroy();
        $('#tabla_insumos').DataTable( {
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
function borrarInsumo(id_insumos)
{
  if( confirm("¿Desea borrar el Insumo?") )
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-insumos.php",
      data: {
              opcion:3,
              id_insumos:id_insumos
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar el Insumo', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Insumo eliminado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
function nuevoInsumo()
{
  var descripcion = $("#descripcion").val();
  var proveedor_id_proveedor = $("#proveedor_id_proveedor").val();
  var unidades_medida_id_unidades_medida = $("#unidades_medida_id_unidades_medida").val();
  var fecha_compra = $("#fecha_compra").val();
  var comentarios = $("#descripcion_ampliada").val();
  
  //Validar campos
  if( unidades_medida_id_unidades_medida === "NULL")
  {
    alert("Por favor ingrese la Unidad");
  }else if( proveedor_id_proveedor === "NULL" )
  {
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-insumos.php",
      data: {
              opcion:1,
              descripcion:descripcion,
              proveedor_id_proveedor:proveedor_id_proveedor,
              unidades_medida_id_unidades_medida:unidades_medida_id_unidades_medida,
              fecha_compra:fecha_compra,
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
          jAlert('¡Insumo creado con exito!', 'CONFIRMACION');
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
  $("#proveedor_id_proveedor").val("NULL");
  $("#unidades_medida_id_unidades_medida").val("NULL");
  $("#fecha_compra").val("");
  $("#descripcion_ampliada").val("");
  $("#nuevoInsumo").modal("hide");
}
$(document).ready(function(){
  
  //Resetear formulario Al Guardar Nuevo Insumo
  recargarFomGuardar();
  //
  $('#tabla_insumos').DataTable( {
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
