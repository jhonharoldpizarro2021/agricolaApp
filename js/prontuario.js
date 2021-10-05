function editarResultadoProduccion(id,finca,idUnidadAgricola,nFinca,nUnidadAgricola,fechaCosecha,fechaInicio,fechaFin,area,descripcion,corte,variedad,edad,TCT,TCH,TCHM,rendimiento){
   //Asignar valores de edición
  $("#edit_id").val(id);
  $("#edit_finca option:selected").val( finca === '' ? "NULL" : finca );
  $("#edit_finca option:selected").html( nFinca );
  $("#edit_unidad_agricola option:selected").val( idUnidadAgricola === '' ? "NULL" : idUnidadAgricola );
  $("#edit_unidad_agricola option:selected").html( nUnidadAgricola );
  $("#edit_fechaCosecha").val(fechaCosecha);
  $("#edit_fechaInicio").val(fechaInicio);
  $("#edit_fechaFin").val(fechaFin);
  $("#edit_area").val(area);
  $("#edit_descripcion").val(descripcion);
  $("#edit_codigoCorte").val(corte);
  $("#edit_variedad").val(variedad);
  $("#edit_edad").val(edad);
  $("#edit_TCT").val(TCT);
  $("#edit_TCH").val(TCH);
  $("#edit_TCHM").val(TCHM);
  $("#edit_rendimiento").val(rendimiento);
  $("#editResultadoProduccion").modal('show');
}
// FUNCION ENCARGADA DE GUARDAR LA EDICION
function guardarEdicion(){
  var id = $("#edit_id").val();
  var finca = $("#edit_finca option:selected").val();
  var idUnidadAgricola = $("#edit_unidad_agricola option:selected").val();
  var fechaCosecha = $("#edit_fechaCosecha").val();
  var fechaInicio = $("#edit_fechaInicio").val();
  var fechaFin = $("#edit_fechaFin").val();
  var area = $("#edit_area").val();
  var descripcion = $("#edit_descripcion").val();
  var corte = $("#edit_codigoCorte").val();
  var variedad = $("#edit_variedad").val();
  var edad = $("#edit_edad").val();
  var TCT = $("#edit_TCT").val();
  var TCH = $("#edit_TCH").val();
  var TCHM = $("#edit_TCHM").val();
  var rendimiento = $("#edit_rendimiento").val();
  //Validar campos
  if( finca === "")
  {
    alert("Por favor ingrese la finca");
  }
  else if( unidad_agricola === "NULL" )
  {

  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-prontuario.php",
      data: {
          opcion:2,
          finca:finca,
          idUnidadAgricola:idUnidadAgricola,
          fechaCosecha:fechaCosecha,
          fechaInicio:fechaInicio,
          fechaFin:fechaFin,
          area:area,
          descripcion:descripcion,
          corte:corte,
          variedad:variedad,
          edad:edad,
          TCT:TCT,
          TCH:TCH,
          TCHM:TCHM,
          rendimiento:rendimiento,
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
  }
  $("#editResultadoProduccion").modal('hide');
}
// FUNCION ENCARGADA DE RECARGAR DATOS 
function recargarDatos(){
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-prontuario.php",
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
        for( var i=0; i < res.resultados.length; i++)
        {
          datos[i] = [
                        res.resultados[i].nombre_finca,
                        res.resultados[i].nombre_unidad_agricola,
                        res.resultados[i].fechaCosecha,
                        res.resultados[i].fechaInicio,
                        res.resultados[i].fechaFin,
                        res.resultados[i].area,                        
                        res.resultados[i].corte,
                        res.resultados[i].variedad,
                        res.resultados[i].edad,
                        res.resultados[i].TCT,
                        res.resultados[i].TCH,
                        res.resultados[i].TCHM,
                        res.resultados[i].rendimiento,
                        res.resultados[i].descripcion,
                        '<a data-toggle="modal" data-target="#editar" onclick="editarResultadoProduccion(\''+ res.resultados[i].id +'\',\''+ res.resultados[i].finca +'\',\''+ res.resultados[i].unidad_agricola +'\',\''+ res.resultados[i].nombre_finca +'\',\''+ res.resultados[i].nombre_unidad_agricola +'\',\''+ res.resultados[i].fechaCosecha +'\',\''+ res.resultados[i].fechaInicio +'\',\''+ res.resultados[i].fechaFin +'\',\''+ res.resultados[i].area +'\',\''+ res.resultados[i].descripcion +'\',\''+ res.resultados[i].corte +'\',\''+ res.resultados[i].variedad +'\',\''+ res.resultados[i].edad +'\',\''+ res.resultados[i].TCT +'\',\''+ res.resultados[i].TCH +'\',\''+ res.resultados[i].TCHM +'\',\''+ res.resultados[i].rendimiento +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarResultadoProduccion(\''+ res.resultados[i].id +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_resultados').DataTable();
        table.destroy();
        $('#tabla_resultados').DataTable( {
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
// FUNCION ENCARGADA DE BORRAR RESULTADO DE PRODUCCION
function borrarResultadoProduccion(id){
  if( confirm("¿Desea borrar la unidad agrícola?") )
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-prontuario.php",
      data: {
              opcion:3,
              id:id
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar la unidad', 'ERROR');
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
// FUNCION ENCARGADA DE CREAR NUEVO RESULTAD DE PRODUCCION
function nuevoResultadoProduccion(){
  var finca = $("#finca").val();
  var unidad_agricola = $("#unidad_agricola").val();
  var fechaCosecha = $("#fechaCosecha").val();
  var fechaInicio = $("#fechaInicio").val();
  var fechaFin = $("#fechaFin").val();
  var area = $("#area").val();
  var descripcion = $("#descripcion").val();
  var corte = $("#codigoCorte").val();
  var variedad = $("#variedad").val();
  var edad = $("#edad").val();
  var TCT = $("#TCT").val();
  var TCH = $("#TCH").val();
  var TCHM = $("#TCHM").val();
  var rendimiento = $("#rendimiento").val();
  var nFinca = $("#finca  option:selected").html();
  var nSuerte = $("#unidad_agricola  option:selected").html();
  //Validar campos
  if( codigoCorte === "")
  {
    alert("Por favor ingrese el codigo");
  }else if( codigoCorte === "" )
  {

  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-prontuario.php",
      data: {
              opcion:1,
              finca:finca,
              unidad_agricola:unidad_agricola,
              fechaCosecha:fechaCosecha,
              fechaInicio:fechaInicio,
              fechaFin:fechaFin,
              area:area,
              descripcion:descripcion,
              corte:corte,
              variedad:variedad,
              edad:edad,
              TCT:TCT,
              TCH:TCH,
              TCHM:TCHM,
              rendimiento:rendimiento
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "EXIST")
        {
          jAlert('¡¡El Corte ' + corte + ' ya Existe en la ' + nSuerte + ' ' + nFinca + ' ', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡Registro Creado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
// FUNCION ENCARGADA DE GUARDAR LA EDICION
function recargarFomGuardar(){
  $("#finca").val("NULL");
  $("#unidad_agricola").val("NULL");
  $("#fechaCosecha").val("");
  $("#fechaInicio").val("");
  $("#fechaFin").val("");
  $("#area").val("");
  $("#descripcion").val("");
  $("#codigoCorte").val("");
  $("#variedad").val("");
  $("#edad").val("");
  $("#TCT").val("");
  $("#TCH").val("");
  $("#TCHM").val("");
  $("#rendimiento").val("");
  $("#nuevoResultadoProduccion").modal("hide");
}
// DOCUMENT READY FUNCIONS
$(document).ready(function(){
  recargarFomGuardar();
  $('#tabla_resultados').DataTable( {
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
  $("#finca").change(function () {
           $("#finca option:selected").each(function () {
            id_padre = $(this).val();
            $.post("ua.php", { id_padre: id_padre }, function(data){
                $("#unidad_agricola").html(data);
            });            
        });
   });
   $("#edit_finca").change(function () {
           $("#edit_finca option:selected").each(function () {
            id_padre = $(this).val();
            $.post("ua.php", { id_padre: id_padre }, function(data){
                $("#edit_unidad_agricola").html(data);
            });            
        });
   });
});


