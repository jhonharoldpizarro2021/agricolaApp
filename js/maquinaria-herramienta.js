function nuevaMaquina(){
  var nombre = $("#nombre").val();
  var fecha_compra = $("#fecha_compra").val();
  var codigo = $("#codigo").val();
  var lapso_mantenimiento = $("#lapso_mantenimiento").val();
  var unidades_t = $("#unidades_t").val();
  var fecha_ultimo_mantenimiento = $("#fecha_ultimo_mantenimiento").val();
  var comentario = $("#comentario").val();
  var proveedor_id_proveedor = $("#proveedor_id_proveedor").val();
  //Validar campos
  if( unidades_t === "NULL"){
    jAlert('¡¡Por favor ingrese la unidad', 'DATOS INCOMPLETOS');
  }
  else if( codigo === "" ){
  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-maquinaria-herramienta.php",
      data: {
              opcion:1,
              nombre:nombre,
              fecha_compra:fecha_compra,
              codigo:codigo,
              lapso_mantenimiento:lapso_mantenimiento,
              unidades_t:unidades_t,
              fecha_ultimo_mantenimiento:fecha_ultimo_mantenimiento,
              comentario:comentario,
              proveedor_id_proveedor:proveedor_id_proveedor
            },
      success: function(res){
        if(res.estado === "ERROR"){
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK"){
          jAlert('¡Unidad Agrícola creada con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
function recargarFomGuardar(){
  $("#nombre").val("");
  $("#fecha_compra").val("");
  $("#codigo").val("");
  $("#lapso_mantenimiento").val("");
  $("#unidades_t").val("NULL");
  $("#fecha_ultimo_mantenimiento").val("");
  $("#comentario").val("");
  $("#proveedor_id_proveedor").val("NULL");
  $("#nuevaMaquina").modal("hide");
}
function editarMaquina(id,nombre,fecha_compra,codigo,lapso_mantenimiento,unidades_t_m,fecha_ultimo_mantenimiento,comentario,proveedor_id_proveedor){
  $("#edit_id_maquina").val(id);
  $("#edit_nombre").val(nombre);
  $("#edit_fecha_compra").val(fecha_compra);
  $("#edit_codigo").val(codigo);
  $("#edit_lapso_mantenimiento").val(lapso_mantenimiento);
  $("#edit_unidades_t_m").val(unidades_t_m);
  $("#edit_fecha_ultimo_mantenimiento").val(fecha_ultimo_mantenimiento);
  $("#edit_comentario").val(comentario);
  $("#edit_proveedor_id_proveedor").val(proveedor_id_proveedor);
  $("#editMaquina").modal('show');
}
function guardarEdicion(){
  var id = $("#edit_id_maquina").val();
  var nombre = $("#edit_nombre").val();
  var fecha_compra = $("#edit_fecha_compra").val();
  var codigo = $("#edit_codigo").val();
  var lapso_mantenimiento = $("#edit_lapso_mantenimiento").val();
  var unidades_t_m = $("#edit_unidades_t_m").val();
  var fecha_ultimo_mantenimiento = $("#edit_fecha_ultimo_mantenimiento").val();
  var comentario = $("#edit_comentario").val();
  var proveedor_id_proveedor = $("#edit_proveedor_id_proveedor").val();
  //Validar campos
  if( unidades_t_m === ""){
    jAlert('¡¡Ingrese la unidad', 'DATOS INCOMPLETOS');
  }
  else if( codigo === "" ){

  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-maquinaria-herramienta.php",
      data: {
              opcion:2,
              nombre:nombre,
              fecha_compra:fecha_compra,
              codigo:codigo,
              lapso_mantenimiento:lapso_mantenimiento,
              unidades_t_m:unidades_t_m,
              fecha_ultimo_mantenimiento:fecha_ultimo_mantenimiento,
              comentario:comentario,
              proveedor_id_proveedor:proveedor_id_proveedor,
              id:id
            },
      success: function(res){
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
  $("#editMaquina").modal('hide');
}
function recargarDatos(){
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-maquinaria-herramienta.php",
    data: {
            opcion:4
          },
    success: function(res){
      if(res.estado === "EMPTY"){
        jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }
      else if(res.estado === "OK"){
        var datos = [];
        for( var i=0; i < res.maquinas.length; i++){
          var comentsinr = res.maquinas[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>");
          datos[i] = [
                        res.maquinas[i].nombre,
                        res.maquinas[i].fecha_compra,
                        res.maquinas[i].codigo,
                        '<td class="hideColum">'+res.maquinas[i].lapso_mantenimiento + '  ' + res.maquinas[i].unidades_t_m+'</td>',
                        '<td class="hideColum">'+res.maquinas[i].fecha_ultimo_mantenimiento+'</td>',
                        '<td class="hideColum">'+res.maquinas[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "\\r")+'</td>',
                        '<td class="hideColum">'+res.maquinas[i].nombre_proveedor+'</td>',
                        '<a data-toggle="modal" data-target="#editar" onclick="verMaquina(\''+ res.maquinas[i].id +'\',\''+ res.maquinas[i].nombre +'\',\''+ res.maquinas[i].fecha_compra +'\',\''+ res.maquinas[i].codigo +'\',\''+ res.maquinas[i].lapso_mantenimiento +'\',\''+ res.maquinas[i].id_unidades_t_m +'\',\''+ res.maquinas[i].fecha_ultimo_mantenimiento +'\',\''+ res.maquinas[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "\\r") +'\',\''+ res.maquinas[i].id_proveedor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a>',
                        '<a data-toggle="modal" data-target="#editar" onclick="editarMaquina(\''+ res.maquinas[i].id +'\',\''+ res.maquinas[i].nombre +'\',\''+ res.maquinas[i].fecha_compra +'\',\''+ res.maquinas[i].codigo +'\',\''+ res.maquinas[i].lapso_mantenimiento +'\',\''+ res.maquinas[i].id_unidades_t_m +'\',\''+ res.maquinas[i].fecha_ultimo_mantenimiento +'\',\''+ res.maquinas[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "\\r") +'\',\''+ res.maquinas[i].id_proveedor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarMaquina(\''+ res.maquinas[i].id +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_maquinas').DataTable();
        table.destroy();
        $('#tabla_maquinas').DataTable( {
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
function borrarMaquina(id){
  if( confirm("¿Desea borrar la unidad agrícola?") ){
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-maquinaria-herramienta.php",
      data: {opcion:3,id:id},
      success: function(res){
        if(res.estado === "ERROR"){
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar la Maquina ó Herramienta', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK"){
          jAlert('¡ Registro Eliminado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
function verMaquina(id,nombre,compra,codigo,mantenimiento,unidades,mantenimiento,comentario,proveedor){
  $("#ver_id_maquina").html(id);
  $("#ver_nombre").html(nombre);
  $("#ver_fecha_compra").html(compra);
  $("#ver_codigo").html(codigo);
  $("#ver_lapso_mantenimiento").html(mantenimiento);
  $("#ver_unidades_t_m").html(unidades);
  $("#ver_fecha_ultimo_mantenimiento").html(mantenimiento);
  $("#ver_comentario").html(comentario);
  $("#ver_proveedor").html(proveedor);
  $("#verMaquina").modal('show');
}
$(document).ready(function(){
  //Editar campos tabla
  $.fn.editable.defaults.mode = 'popup';
  $('.xedit').editable();
   $('.seleccion').editable({
        type: 'select',
        title: 'Select status',
        placement: 'right',
        value: 2,
        source: [
            {value: 1, text: 'status 1'},
            {value: 2, text: 'status 2'},
            {value: 3, text: 'status 3'}
        ]
        /*
        //uncomment these lines to send data on server
        ,pk: 1
        ,url: '/post'
        */
    });
  $(document).on('click','.editable-submit',function(){
    var id = $(this).closest('td').children('span').attr('id');
    var campo_q = $(this).closest('td').children('span').attr('campo_query');
    var valor_q = $('.editable-input .input-sm').val();
    $.ajax({
      url: "./querys/q-maquinaria-herramienta.php",
      type: 'POST',
      dataType:"json",
      data: {
              opcion:5,
              campo_query:campo_q,
              valor_query:valor_q,
              id:id
            },
      success: function(res){
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          recargarDatos();
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK"){
          jAlert('¡Maquina ó Herramienta actualizada con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  });
  //Resetear formulario Al Guardar Nueva labor
  recargarFomGuardar();
  //
  $('#tabla_maquinas').DataTable( {
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
// ////



});
