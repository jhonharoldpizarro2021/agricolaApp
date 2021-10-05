function seguimientoLabores(idProduccion,idfinca,idsuerte,corte,suerte,finca){
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-planificacion-cosechas.php",
    data: {
            opcion:7,
            idProduccion:idProduccion,
            idfinca:idfinca,
            idsuerte:idsuerte,
            corte:corte
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }
          else if(res.estado === "EMPTY")
      {
        jAlert('¡¡Este Corte no tiene labores asignadas', 'SIN LABORES');
        $("#seguimientoLabores").modal('hide');
      }
      else if(res.estado === "OK")
      {
        var datos = [];
        for( var i=0; i < res.seguimiento.length; i++)
        {
          var labor = res.seguimiento[i].labor;
          var idLabor = res.seguimiento[i].id_labor; 
          var idProduccion = res.seguimiento[i].id;         
          var idSuerte = res.seguimiento[i].suerte;
          var idFinca = res.seguimiento[i].finca;
          datos[i] = [
                        res.seguimiento[i].labor,
                        res.seguimiento[i].fecha_inicio,
                        res.seguimiento[i].fecha_fin,
                        '<center><a data-toggle="modal" data-target="#editar" onclick="editarLaborSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].id +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].nombreFinca +'\',\''+ res.seguimiento[i].nombreSuerte +'\',\''+ res.seguimiento[i].labor +'\',\''+ res.seguimiento[i].fecha_inicio +'\',\''+ res.seguimiento[i].fecha_fin +'\')" ria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></center>',
                        '<center><a href="javascript:borrarLaborAsignada(\''+ res.seguimiento[i].idSeguimiento+'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a></center>',
                        '<center><a onclick="verMaquinaSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a></center>',
                        '<center><a onclick="nuevaMaquinaSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-plus"></i></button></a></center>',
                        '<center><a onclick="verInsumoSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a></center>',
                        '<center><a onclick="nuevoInsumoSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-plus"></i></button></a></center>',
                        '<center><a onclick="verGastoSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a></center>',
                        '<center><a onclick="nuevoGastoSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-plus"></i></button></a></center>',
                        '<center><a onclick="verNovedadSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a></center>',
                        '<center><a onclick="nuevaNovedadSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-plus"></i></button></a></center>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_seguimientoLabores').DataTable();
        table.destroy();
        $('#tabla_seguimientoLabores').DataTable( {
            data: datos,
            responsive: true,
            "order": [],
            "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
        } );
      $("#corte_sg").html(corte);
      $("#suerte_sg").html(suerte);
      $("#idSuerte_sg").html(idSuerte);
      $("#finca_sg").html(finca);
      $("#idFinca_sg").html(idFinca);
      $("#id_sg").html(id);
      $("#labor_sg").html(labor);
      $("#idLabor_sg").html(idLabor);
      $("#idProduccion_sg").html(idProduccion);
      $("#seguimientoLabores").modal('show');
      }
    }
  });
}
function nuevaLaborSeguimiento(id,idfinca,idsuerte,corte,finca,suerte){
  $("#id").val(id);
  $("#labor_finca").val(idfinca);
  $("#labor_suerte").val(idsuerte);
  $("#labor_corte").val(corte);
  $("#numero_corte").html(corte);
  $("#nombre_suerte").html(suerte);
  $("#nombre_finca").html(finca);
  $("#nuevaLaborSeguimiento").modal('show');
}
function guardarNuevaLaborSeguimiento(){
  var id = $("#id").val();
  var finca = $("#labor_finca").val();
  var suerte = $("#labor_suerte").val();
  var corte2 = $("#labor_corte").val();
  var labor = $("#labor2").val();
  var inicio_labor = $("#inicio_labor").val();
  var fin_labor = $("#fin_labor").val();

  //Validar campos
  if( labor === "")
  {
    jAlert('¡¡Ingrese la Labor', 'DATOS INCOMPLETOS');
  }
  else if( labor === "" )
  {
    jAlert('¡¡Ingrese la Labor', 'DATOS INCOMPLETOS');
  }
  else
  {
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:1,
              labor:labor,
              inicio_labor:inicio_labor,
              fin_labor:fin_labor,
              finca:finca,
              suerte:suerte,
              corte2:corte2,
              id:id
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la informacion', 'ERROR');
          recargarDatos();
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡Labor fue agregada al corte con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
    $('#nuevaLaborSeguimiento').on('hidden.bs.modal', function (e) {
      	$("#id").val("");
		$("#labor_finca").val("");
		$("#labor_suerte").val("");
		$("#labor_corte").val("");
		$("#labor2").val("NULL");
		$("#inicio_labor").val("");
		$("#fin_labor").val(""); 
  	});
  }
  $("#nuevaLaborSeguimiento").modal('hide');
}
function editarLaborSeguimiento(idSeguimiento,id,labor,finca,suerte,corte,nSuerte,nFinca,nLabor,fecha_inicio,fecha_fin) {
  //Asignar valores de edición
  $("#edit_id").val(idSeguimiento);
  $("#edit_produccion").val(id);
  $("#edit_labor2").val(labor);
  $("#edit_labor_finca").val(finca);
  $("#edit_labor_suerte").val(suerte);
  $("#edit_labor_corte").val(corte);
  $("#edit_numero_corte").html(corte);
  $("#edit_nombre_suerte").html(nSuerte);
  $("#edit_nombre_finca").html(nFinca);
  $("#edit_nombre_labor").html(nLabor);
  $("#edit_inicio_labor").val(fecha_inicio);
  $("#edit_fin_labor").val(fecha_fin);
  $("#editarLaborSeguimiento").modal('show');
}
function guardarEdicionLabor(){
  var seguimiento = $("#edit_id").val();  
  var id = $("#edit_produccion").val();
  var finca = $("#edit_labor_finca").val();
  var suerte = $("#edit_labor_suerte").val();
  var corte = $("#edit_labor_corte").val();
  var labor = $("#edit_labor2").val();
  var inicio_labor = $("#edit_inicio_labor").val();
  var fin_labor = $("#edit_fin_labor").val();
  //Validar campos
  if( inicio_labor === "")
  {
    jAlert('¡Por favor ingrese la fecha de inicio', 'CAMPOS INCOMPLETOS');
  }
  else if( fin_labor === "" )
  {
    jAlert('¡Por favor ingrese la fecha de fin', 'CAMPOS INCOMPLETOS');
  }
  else
  {
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:2,
              labor:labor,
              inicio_labor:inicio_labor,
              fin_labor:fin_labor,
              finca:finca,
              suerte:suerte,
              corte:corte,
              seguimiento:seguimiento,
              id:id,
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          recargarLabores();
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡Registro Actualizado con exito!', 'CONFIRMACION');
          recargarLabores();

        }
      }
    });
  }
  $("#editarLaborSeguimiento").modal('hide');
}
function borrarLaborAsignada(idSeguimiento){
  if( confirm("¿Desea borrar la Labor Asignada?") )
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:3,
              idSeguimiento:idSeguimiento
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
          recargarLabores();
        }
      }
    });
  }
}
/* RECARGA LAS LABORES*/
function recargarLabores(){
  var idProduccion = $("#idProduccion_sg").html();
  var corte = $("#corte_sg").html();
  var idsuerte = $("#idSuerte_sg").html();
  var idfinca = $("#idFinca_sg").html();
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-planificacion-cosechas.php",
    data: {
            opcion:7,
            idProduccion:idProduccion,
            idfinca:idfinca,
            idsuerte:idsuerte,
            corte:corte

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
        for( var i=0; i < res.seguimiento.length; i++)
        {
          datos[i] = [
                        res.seguimiento[i].labor,
                        res.seguimiento[i].fecha_inicio,
                        res.seguimiento[i].fecha_fin,
                        '<div class="col-md-8"><a data-toggle="modal" data-target="#editar" onclick="editarLaborSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].id +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].nombreFinca +'\',\''+ res.seguimiento[i].nombreSuerte +'\',\''+ res.seguimiento[i].labor +'\',\''+ res.seguimiento[i].fecha_inicio +'\',\''+ res.seguimiento[i].fecha_fin +'\')" ria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></div>',
                        '<div class="col-md-8"><a href="javascript:borrarLaborAsignada(\''+ res.seguimiento[i].idSeguimiento+'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a></div>',
                        '<div class="col-md-8"><a onclick="verMaquinaSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a></div>',
                        '<div class="col-md-8"><a onclick="nuevaMaquinaSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-plus"></i></button></a></div>',
                        '<div class="col-md-8"><a onclick="verInsumoSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a></div>',
                        '<div class="col-md-8"><a onclick="nuevoInsumoSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-plus"></i></button></a></div>',
                        '<div class="col-md-8"><a onclick="verGastoSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a></div>',
                        '<div class="col-md-8"><a onclick="nuevoGastoSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-plus"></i></button></a></div>',
                        '<div class="col-md-8"><a onclick="verNovedadSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a></div>',
                        '<div class="col-md-8"><a onclick="nuevaNovedadSeguimiento(\''+ res.seguimiento[i].idSeguimiento +'\',\''+ res.seguimiento[i].finca +'\',\''+ res.seguimiento[i].suerte +'\',\''+ res.seguimiento[i].corte +'\',\''+ res.seguimiento[i].id_labor +'\',\''+ res.seguimiento[i].labor +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-plus"></i></button></a></div>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_seguimientoLabores').DataTable();
        table.destroy();
        $('#tabla_seguimientoLabores').DataTable( {
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
/* CREA LAS MAQUINAS ASOCIADAS A LA LABOR ASIGNADA AL CORTE*/ 
function nuevaMaquinaSeguimiento(idSeguimiento,finca,suerte,corte,labor,n_labor){
  var n_suerte = $("#suerte_sg").html();
  var n_finca = $("#finca_sg").html();

  $("#seguimientoM").val(idSeguimiento);
  $("#laborM").val(labor);
  $("#maquina_finca").val(finca);
  $("#maquina_suerte").val(suerte);
  $("#maquina_corte").val(corte);
  $("#m_labor").html(n_labor);
  $("#m_finca").html(n_finca);
  $("#m_suerte").html(n_suerte);
  $("#m_corte").html(corte);

  $("#seguimientoLabores").modal('hide');
  $("#nuevaMaquinaSeguimiento").modal('show');
  $('#nuevaMaquinaSeguimiento').on('hidden.bs.modal', function (e) {
      $("#seguimientoLabores").modal('show'); // do something...
  });
}
/* GUARDA LAS MAQUINAS ASOCIADAS A LA LABOR ASIGNADA AL CORTE*/ 
function guardarNuevaMaquinaSeguimiento(){
  var tipo        = $("#tipo").val();
  var codigoTipo  = $("#maquinaHerramienta").val();
  var comentario  = $("#comentario").val();
  var fecha       = $("#fecha").val();
  var seguimiento  = $("#seguimientoM").val();
  var labor       = $("#laborM").val();
  //Validar campos
  if( codigoTipo === null)
  {
    jAlert('¡Seleciona la Maquina!', 'CAMPOS INCOMPLETOS');
  }else if( codigoTipo === null )
  {
    jAlert('¡Seleciona la Maquina!', 'CAMPOS INCOMPLETOS');
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:8,
              tipo:tipo,
              codigoTipo:codigoTipo,
              comentario:comentario,
              fecha:fecha,
              seguimiento:seguimiento,
              labor:labor
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
          jAlert('¡La Maquina/Herramienta fue agregada al corte con exito!', 'CONFIRMACION');
          recargarFormMaquina();
        }
      }
    });
    $("#nuevaMaquinaSeguimiento").modal('hide');
    $('#seguimientoLabores').modal('show');
  }
}
/* RESETEA FORM MAQUINA*/
function recargarFormMaquina(){
  $("#maquinaHerramienta").val("NULL");
  $("#comentario").val("");
  $("#fecha").val("");
}
/* MUESTRA LAS MAQUINAS ASOCIADAS A LA LABOR ASIGNADA AL CORTE*/ 
function verMaquinaSeguimiento(idSeguimiento,finca,suerte,corte,labor,n_labor){
  var finca = finca;
  var suerte = suerte;
  var corte = corte;
  var labor = labor;
  var n_suerte = $("#suerte_sg").html();
  var n_finca = $("#finca_sg").html();
  $.ajax(
  {
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-planificacion-cosechas.php",
    data: {
            opcion:9,
            idSeguimiento:idSeguimiento,
            labor:labor
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }
          else if(res.estado === "EMPTY")
      {
        jAlert('¡¡Esta labor no tiene Maquinas/Herramientas asignadas', 'SIN MAQUINAS/HERRAMIENTAS');
        console.log("Error:"+ res.msg);
        $("#maquinaSeguimiento").modal('hide');
      }
      else if(res.estado === "OK")
      {
        var datos = [];
        for( var i=0; i < res.detalle.length; i++)
        {
          datos[i] = [
                        res.detalle[i].nombre_tipo,
                        res.detalle[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        res.detalle[i].fecha,
                        '<center><a onclick="editarMaquinaSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].tipo +'\',\''+ res.detalle[i].codigo_tipo +'\',\''+ res.detalle[i].comentario +'\',\''+ res.detalle[i].fecha +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ finca +'\',\''+ suerte +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></center>',
                        '<center><a onclick="borrarMaquinaSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ res.detalle[i].nombre_tipo +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a></center>',
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_maquinaHerramientaLabor').DataTable();
        table.destroy();
        $('#tabla_maquinaHerramientaLabor').DataTable( {
            data: datos,
            responsive: true,
            "order": [],
            "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
        } );

      $("#vm_labor").html(n_labor);
      $("#vm_finca").html(n_finca);
      $("#vm_suerte").html(n_suerte);
      $("#vm_corte").html(corte);

      $("#seguimientoLabores").modal('hide');
      $("#maquinaSeguimiento").modal('show');
      $('#maquinaSeguimiento').on('hidden.bs.modal', function (e) {
          $("#seguimientoLabores").modal('show'); // do something...
      });
      }
    }
  });
}
/* EDITA LAS MAQUINAS ASOCIADAS A LA LABOR ASIGNADA AL CORTE*/ 
function editarMaquinaSeguimiento(idDetalle,tipo,idTipo,comentario,fecha,idSeguimiento,labor,finca,suerte,corte,nLabor,nFinca,nSuerte){
  //asignar los datos para edicion
  $("#edit_m_labor").html(nLabor);
  $("#edit_m_corte").html(corte);
  $("#edit_m_suerte").html(nSuerte);
  $("#edit_m_finca").html(nFinca);
  $("#edit_idDetalle").val(idDetalle);
  $("#edit_tipo").val(tipo); 
  $("#edit_maquinaHerramienta").val(idTipo);
  $("#edit_comentario").val(comentario);
  $("#edit_fecha").val(fecha);  
  $("#edit_seguimientoM").val(idSeguimiento);
  $("#edit_laborM").val(labor);  
  $("#edit_maquina_finca").val(finca);
  $("#edit_maquina_suerte").val(suerte);
  $("#edit_maquina_corte").val(corte);
  
  $("#editarMaquinaSeguimiento").modal('show');
}
/* GUARDA EDICION DE LAS MAQUINAS ASOCIADAS A LA LABOR ASIGNADA AL CORTE*/ 
function guardarEdicionMaquinaSeguimiento(){
  //obtengo los datos 
  var idDetalle = $("#edit_idDetalle").val();
  var idSeguimiento = $("#edit_seguimientoM").val();
  var comentario = $("#edit_comentario").val();
  var fecha = $("#edit_fecha").val(); 
  var labor = $("#edit_laborM").val(); 
  //Validar campos
  if( idDetalle === null)
  {
    jAlert('¡Seleciona la Maquina!', 'CAMPOS INCOMPLETOS');
  }
  else if( idDetalle === null )
  {
    jAlert('¡Seleciona la Maquina!', 'CAMPOS INCOMPLETOS');
  }
  else
  {
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:16,
              idDetalle:idDetalle,
              comentario:comentario,
              fecha:fecha
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          recargarDatos();
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡La Edición del Registro fue Exitosa!', 'CONFIRMACION');
          recargarFormMaquina();
          recargarMaquinaSeguimiento();
          $("#editarMaquinaSeguimiento").modal('hide');
        }
      }
    });
  }
}
/* GUARDA EDICION DE LAS MAQUINAS ASOCIADAS A LA LABOR ASIGNADA AL CORTE*/ 
function borrarMaquinaSeguimiento(idDetalle,idSeguimiento,labor,nTipo,corte,nLabor,nFinca,nSuerte){
  if( confirm("¿Desea borrar la maquina" + nTipo + "Asignada a la labor "+ nLabor + " del Corte # " + corte +"  " + nFinca + "  " + nSuerte + " ?") )
  {
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:17,
              idDetalle:idDetalle
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar la unidad', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡Registro eliminado con exito!', 'CONFIRMACION');
          recargarMaquinaSeguimiento();

        }
      }
    });
  }
}
/* ACTUALIZA TABLA DE MAQUINAS ASOCIADAS A LA LABOR ASIGNADA AL CORTE DESPUES DE EDITARLA*/
function recargarMaquinaSeguimiento(){
  var idSeguimiento = $("#edit_seguimientoM").val();
  var labor = $("#edit_laborM").val();
  var suerte = $("#edit_maquina_suerte").val();
  var corte = $("#edit_maquina_corte").val();
  var finca = $("#edit_maquina_finca").val();
  var nSuerte = $("#edit_m_suerte").html();
  var nFinca = $("#edit_m_finca").html();
  $.ajax(
  {
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-planificacion-cosechas.php",
    data: {
            opcion:9,
            idSeguimiento:idSeguimiento,
            labor:labor
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
        for( var i=0; i < res.detalle.length; i++)
        {
          datos[i] = [
                        res.detalle[i].nombre_tipo,
                        res.detalle[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        res.detalle[i].fecha,
                        '<center><a onclick="editarMaquinaSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].tipo +'\',\''+ res.detalle[i].codigo_tipo +'\',\''+ res.detalle[i].comentario +'\',\''+ res.detalle[i].fecha +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ finca +'\',\''+ suerte +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></center>',
                        '<center><a onclick="borrarMaquinaSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].nombre_tipo +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a></center>',
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_maquinaHerramientaLabor').DataTable();
        table.destroy();
        $('#tabla_maquinaHerramientaLabor').DataTable( {
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

/*CREA LOS INSUMOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function nuevoInsumoSeguimiento(idSeguimiento,finca,suerte,corte,labor,n_labor){
  var n_suerte = $("#suerte_sg").html();
  var n_finca = $("#finca_sg").html();

  $("#seguimientoI").val(idSeguimiento);
  $("#laborI").val(labor);
  $("#maquina_finca").val(finca);
  $("#maquina_suerte").val(suerte);
  $("#maquina_corte").val(corte);
  $("#i_labor").html(n_labor);
  $("#i_finca").html(n_finca);
  $("#i_suerte").html(n_suerte);
  $("#i_corte").html(corte);

  $("#seguimientoLabores").modal('hide');
  $("#nuevoInsumoSeguimiento").modal('show');
  $('#nuevoInsumoSeguimiento').on('hidden.bs.modal', function (e) {
      $("#seguimientoLabores").modal('show'); // do something...
  });
}
/*GUARDA LOS INSUMOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function guardarNuevoInsumoSeguimiento(){
  var tipo = $("#tipoI").val();
  var codigoTipo = $("#insumo").val();
  var comentario = $("#comentarioI").val();
  var fecha = $("#fechaI").val();
  var seguimiento = $("#seguimientoI").val();
  var labor = $("#laborI").val();
  //Validar campos
  if( codigoTipo === "")
  {
    jAlert('¡Seleciona el Insumo', 'CAMPOS INCOMPLETOS');
  }else if( codigoTipo === "" )
  {
    jAlert('¡Seleciona el Insumo', 'CAMPOS INCOMPLETOS');
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:8,
              tipo:tipo,
              codigoTipo:codigoTipo,
              comentario:comentario,
              fecha:fecha,
              seguimiento:seguimiento,
              labor:labor
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
          jAlert('¡El Insumo fue agregado al corte con exito!', 'CONFIRMACION');
          recargarFormInsumo();
        }
      }
    });
    $("#nuevoInsumoSeguimiento").modal('hide');
    $('#seguimientoLabores').modal('show');
  }
}
/* RESETEA FORM INSUMO */
function recargarFormInsumo(){
  $("#insumo").val("NULL");
  $("#comentarioI").val("");
  $("#fechaI").val("");
}
/*MUESTRA LOS INSUMOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function verInsumoSeguimiento(idSeguimiento,finca,suerte,corte,labor,n_labor){
  var n_suerte = $("#suerte_sg").html();
  var n_finca = $("#finca_sg").html();
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-planificacion-cosechas.php",
    data: {
            opcion:10,
            idSeguimiento:idSeguimiento,
            labor:labor
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }
          else if(res.estado === "EMPTY")
      {
        jAlert('¡¡Esta labor no tiene insumos asignados', 'SIN INSUMOS');
        console.log("Error:"+ res.msg);
        $("#insumoSeguimiento").modal('hide');
      }
      else if(res.estado === "OK")
      {
        var datos = [];
        for( var i=0; i < res.detalle.length; i++)
        {
          datos[i] = [
                        res.detalle[i].nombre_tipo,
                        res.detalle[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        res.detalle[i].fecha,
                        '<center><a onclick="editarInsumoSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].tipo +'\',\''+ res.detalle[i].codigo_tipo +'\',\''+ res.detalle[i].comentario +'\',\''+ res.detalle[i].fecha +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ finca +'\',\''+ suerte +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></center>',
                        '<center><a onclick="borrarInsumoSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ res.detalle[i].nombre_tipo +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a></center>',
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_insumoLabor').DataTable();
        table.destroy();
        $('#tabla_insumoLabor').DataTable( {
            data: datos,
            "order": [],
            "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
        } );
      $("#vm_labor_i").html(n_labor);
      $("#vm_finca_i").html(n_finca);
      $("#vm_suerte_i").html(n_suerte);
      $("#vm_corte_i").html(corte);

      $("#seguimientoLabores").modal('hide');
      $("#insumoSeguimiento").modal('show');
      $('#insumoSeguimiento').on('hidden.bs.modal', function (e) {
          $("#seguimientoLabores").modal('show'); // do something...
      });
      }
    }
  });
}
/* EDITA LOS INSUMOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function editarInsumoSeguimiento(idDetalle,tipo,idTipo,comentario,fecha,idSeguimiento,labor,finca,suerte,corte,nLabor,nFinca,nSuerte){
  //asignar los datos para edicion
  $("#edit_i_labor").html(nLabor);
  $("#edit_i_corte").html(corte);
  $("#edit_i_suerte").html(nSuerte);
  $("#edit_i_finca").html(nFinca);
  $("#edit_idDetalleI").val(idDetalle);
  $("#edit_tipoI").val(tipo); 
  $("#edit_insumo").val(idTipo);
  $("#edit_comentarioI").val(comentario);
  $("#edit_fechaI").val(fecha);  
  $("#edit_seguimientoI").val(idSeguimiento);
  $("#edit_laborI").val(labor);  
  $("#edit_maquina_fincaI").val(finca);
  $("#edit_maquina_suerteI").val(suerte);
  $("#edit_maquina_corteI").val(corte);  
  $("#editarInsumoSeguimiento").modal('show');
}
/* GUARDA EDICION DE LOS INSUMOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function guardarEdicionInsumoSeguimiento(){
  //obtengo los datos 
  var idDetalle = $("#edit_idDetalleI").val();
  var idSeguimiento = $("#edit_seguimientoI").val();
  var comentario = $("#edit_comentarioI").val();
  var fecha = $("#edit_fechaI").val(); 
  var labor = $("#edit_laborI").val(); 
  //Validar campos
  if( idDetalle === null)
  {
    jAlert('¡Seleciona la Insumo!', 'CAMPOS INCOMPLETOS');
  }
  else if( idDetalle === null )
  {
    jAlert('¡Seleciona la Insumo!', 'CAMPOS INCOMPLETOS');
  }
  else
  {
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:16,
              idDetalle:idDetalle,
              comentario:comentario,
              fecha:fecha
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          recargarDatos();
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡La Edición del Registro fue Exitosa!', 'CONFIRMACION');
          recargarInsumoSeguimiento();
          $("#editarInsumoSeguimiento").modal('hide');
        }
      }
    });
  }
}
/* GUARDA EDICION DE LOS INSUMOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function borrarInsumoSeguimiento(idDetalle,idSeguimiento,labor,nTipo,corte,nLabor,nFinca,nSuerte){
  if( confirm("¿Desea borrar el Insumo  " + nTipo + "  Asignado a la labor "+ nLabor + " del Corte # " + corte + "  " + nFinca + "  " + nSuerte + " ?") )
  {
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:17,
              idDetalle:idDetalle
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar la unidad', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡Registro eliminado con exito!', 'CONFIRMACION');
          recargarInsumoSeguimiento();

        }
      }
    });
  }
}
/* ACTUALIZA TABLA DE MAQUINAS ASOCIADOS A LA LABOR ASIGNADA AL CORTE DESPUES DE EDITARLA*/
function recargarInsumoSeguimiento(){
  var idSeguimiento = $("#edit_seguimientoI").val();
  var labor = $("#edit_laborI").val();
  var suerte = $("#edit_maquina_suerteI").val();
  var corte = $("#edit_maquina_corteI").val();
  var finca = $("#edit_maquina_fincaI").val();
  var nSuerte = $("#edit_i_suerte").html();
  var nFinca = $("#edit_i_finca").html();
  $.ajax(
  {
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-planificacion-cosechas.php",
    data: {
            opcion:10,
            idSeguimiento:idSeguimiento,
            labor:labor
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
        for( var i=0; i < res.detalle.length; i++)
        {
          datos[i] = [
                        res.detalle[i].nombre_tipo,
                        res.detalle[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        res.detalle[i].fecha,
                        '<center><a onclick="editarInsumoSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].tipo +'\',\''+ res.detalle[i].codigo_tipo +'\',\''+ res.detalle[i].comentario +'\',\''+ res.detalle[i].fecha +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ finca +'\',\''+ suerte +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></center>',
                        '<center><a onclick="borrarInsumoSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ res.detalle[i].nombre_tipo +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a></center>',
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_insumoLabor').DataTable();
        table.destroy();
        $('#tabla_insumoLabor').DataTable( {
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


/*CREA LOS GASTOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function nuevoGastoSeguimiento(idSeguimiento,finca,suerte,corte,labor,n_labor){
  var n_suerte = $("#suerte_sg").html();
  var n_finca = $("#finca_sg").html();
  $("#seguimientoG").val(idSeguimiento);
  $("#laborG").val(labor);
  $("#maquina_finca").val(finca);
  $("#maquina_suerte").val(suerte);
  $("#maquina_corte").val(corte);
  $("#g_labor").html(n_labor);
  $("#g_finca").html(n_finca);
  $("#g_suerte").html(n_suerte);
  $("#g_corte").html(corte);
  $("#valorG").maskMoney(
      {
        symbol:'$', // Simbolo
        decimal:',', // Separador do decimal
        precision:0, // Precisão
        thousands:'.', // Separador para os milhares
        allowZero:false, // Permite que o digito 0 seja o primeiro caractere
        showSymbol:true // Exibe/Oculta o símbolo
      }
    );
  $("#seguimientoLabores").modal('hide');
  $("#nuevoGastoSeguimiento").modal('show');
  $('#nuevoGastoSeguimiento').on('hidden.bs.modal', function (e) {
      $("#seguimientoLabores").modal('show'); // do something...
  });
}
/*CREA LOS GASTOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function guardarNuevoGastoSeguimiento(){
  var tipo = $("#tipoG").val();
  var codigoTipo = $("#gastoG").val();
  var comentario = $("#comentarioG").val();
  var fecha = $("#fechaG").val();
  var valor = $("#valorG").val().replace(/\./g, '');;
  var seguimiento = $("#seguimientoG").val();
  var labor = $("#laborG").val();
  //Validar campos
  if( codigoTipo === "")
  {
    jAlert('¡Seleciona el Gasto', 'CAMPOS INCOMPLETOS');
  }else if( codigoTipo === "" )
  {
    jAlert('¡Seleciona el Gasto', 'CAMPOS INCOMPLETOS');
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:8,
              tipo:tipo,
              codigoTipo:codigoTipo,
              comentario:comentario,
              fecha:fecha,
              valor:valor,
              seguimiento:seguimiento,
              labor:labor
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
          jAlert('¡El Costo Directo fue agregado al corte con exito!', 'CONFIRMACION');
          recargarFormGasto();
        }
      }
    });
    $("#nuevoGastoSeguimiento").modal('hide');
    $('#seguimientoLabores').modal('show');
  }
}
/* * RESETEA FORM GASTO */
function recargarFormGasto(){
  $("#gastoG").val("NULL");
  $("#comentarioG").val("");
  $("#nuevoCorte").modal("hide");
}
/*MUESTRA LOS GASTOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function verGastoSeguimiento(idSeguimiento,finca,suerte,corte,labor,n_labor){
  var n_suerte = $("#suerte_sg").html();
  var n_finca = $("#finca_sg").html();
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-planificacion-cosechas.php",
    data: {
            opcion:11,
            idSeguimiento:idSeguimiento,
            labor:labor
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }
          else if(res.estado === "EMPTY")
      {
        jAlert('¡¡Esta labor no tiene gastos asignados', 'SIN GASTOS');
        console.log("Error:"+ res.msg);
        $("#gastoSeguimiento").modal('hide');
      }
      else if(res.estado === "OK")
      {
        var datos = [];
        for( var i=0; i < res.detalle.length; i++)
        {
          datos[i] = [
                        res.detalle[i].nombre_tipo,
                        res.detalle[i].valor,
                        res.detalle[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        res.detalle[i].fecha,
                        '<center><a onclick="editarGastoSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].tipo +'\',\''+ res.detalle[i].codigo_tipo +'\',\''+ res.detalle[i].comentario +'\',\''+ res.detalle[i].fecha +'\',\''+ res.detalle[i].valor +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ finca +'\',\''+ suerte +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></center>',
                        '<center><a onclick="borrarGastoSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ res.detalle[i].nombre_tipo +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a></center>',
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_gastoLabor').DataTable();
        table.destroy();
        $('#tabla_gastoLabor').DataTable( {
            data: datos,
            responsive: true,
            "order": [],
            "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
        } );
        $("#vm_labor_g").html(n_labor);
        $("#vm_finca_g").html(n_finca);
        $("#vm_suerte_g").html(n_suerte);
        $("#vm_corte_g").html(corte);

        $("#seguimientoLabores").modal('hide');
        $("#gastoSeguimiento").modal('show');
        $('#gastoSeguimiento').on('hidden.bs.modal', function (e) {
            $("#seguimientoLabores").modal('show'); // do something...
        });
      }
    }
  });
}
/* EDITA LOS GASTOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function editarGastoSeguimiento(idDetalle,tipo,idTipo,comentario,fecha,valor,idSeguimiento,labor,finca,suerte,corte,nLabor,nFinca,nSuerte){
  //asignar los datos para edicion
  $("#edit_g_labor").html(nLabor);
  $("#edit_g_corte").html(corte);
  $("#edit_g_suerte").html(nSuerte);
  $("#edit_g_finca").html(nFinca);
  $("#edit_idDetalleG").val(idDetalle);
  $("#edit_tipoG").val(tipo); 
  $("#edit_insumo").val(idTipo);
  $("#edit_comentarioG").val(comentario);
  $("#edit_fechaG").val(fecha);  
  $("#edit_valorG").val(valor); 
  $("#edit_seguimientoG").val(idSeguimiento);
  $("#edit_laborG").val(labor);  
  $("#edit_maquina_fincaG").val(finca);
  $("#edit_maquina_suerteG").val(suerte);
  $("#edit_maquina_corteG").val(corte);  
  $("#editarGastoSeguimiento").modal('show');
}
/* GUARDA EDICION DE LOS GASTOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function guardarEdicionGastoSeguimiento(){
  //obtengo los datos 
  var idDetalle = $("#edit_idDetalleG").val();
  var idSeguimiento = $("#edit_seguimientoG").val();
  var comentario = $("#edit_comentarioG").val();
  var fecha = $("#edit_fechaG").val(); 
  var valor = $("#edit_valorG").val(); 
  var labor = $("#edit_laborG").val(); 
  //Validar campos
  if( idDetalle === null)
  {
    jAlert('¡Seleciona el Gasto!', 'CAMPOS INCOMPLETOS');
  }
  else if( idDetalle === null )
  {
    jAlert('¡Seleciona el Gasto!', 'CAMPOS INCOMPLETOS');
  }
  else
  {
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:16,
              idDetalle:idDetalle,
              comentario:comentario,
              fecha:fecha,
              valor:valor
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          recargarDatos();
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡La Edición del Registro fue Exitosa!', 'CONFIRMACION');
          recargarGastoSeguimiento();
          $("#editarGastoSeguimiento").modal('hide');
        }
      }
    });
  }
}
/* GUARDA EDICION DE LOS GASTOS ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function borrarGastoSeguimiento(idDetalle,idSeguimiento,labor,nTipo,corte,nLabor,nFinca,nSuerte){
  if( confirm("¿Desea borrar el Gasto  " + nTipo + "  Asignado a la labor "+ nLabor + " del Corte # " + corte + "  " + nFinca + "  " + nSuerte + " ?") )
  {
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:17,
              idDetalle:idDetalle
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar la unidad', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡Registro eliminado con exito!', 'CONFIRMACION');
          recargarGastoSeguimiento();

        }
      }
    });
  }
}
/* ACTUALIZA TABLA DE MAQUINAS ASOCIADOS A LA LABOR ASIGNADA AL CORTE DESPUES DE EDITARLA*/
function recargarGastoSeguimiento(){
  var idSeguimiento = $("#edit_seguimientoG").val();
  var labor = $("#edit_laborG").val();
  var suerte = $("#edit_maquina_suerteG").val();
  var corte = $("#edit_maquina_corteG").val();
  var finca = $("#edit_maquina_fincaG").val();
  var nSuerte = $("#edit_g_suerte").html();
  var nFinca = $("#edit_g_finca").html();
  $.ajax(
  {
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-planificacion-cosechas.php",
    data: {
            opcion:11,
            idSeguimiento:idSeguimiento,
            labor:labor
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
        for( var i=0; i < res.detalle.length; i++)
        {
          datos[i] = [
                        res.detalle[i].nombre_tipo,
                        res.detalle[i].valor,
                        res.detalle[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        res.detalle[i].fecha,
                        '<center><a onclick="editarGastoSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].tipo +'\',\''+ res.detalle[i].codigo_tipo +'\',\''+ res.detalle[i].comentario +'\',\''+ res.detalle[i].fecha +'\',\''+ res.detalle[i].valor +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ finca +'\',\''+ suerte +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></center>',
                        '<center><a onclick="borrarGastoSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ res.detalle[i].nombre_tipo +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a></center>',
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_gastoLabor').DataTable();
        table.destroy();
        $('#tabla_gastoLabor').DataTable( {
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




/**/
function nuevaNovedadSeguimiento(idSeguimiento,finca,suerte,corte,labor,n_labor){
  var n_suerte = $("#suerte_sg").html();
  var n_finca = $("#finca_sg").html();
  $("#seguimientoN").val(idSeguimiento);
  $("#laborN").val(labor);
  $("#maquina_finca").val(finca);
  $("#maquina_suerte").val(suerte);
  $("#maquina_corte").val(corte);
  $("#n_labor").html(n_labor);
  $("#n_finca").html(n_finca);
  $("#n_suerte").html(n_suerte);
  $("#n_corte").html(corte);

  $("#seguimientoLabores").modal('hide');
  $("#nuevaNovedadSeguimiento").modal('show');
  $('#nuevaNovedadSeguimiento').on('hidden.bs.modal', function (e) {
      $("#seguimientoLabores").modal('show');
  });
}
function guardarNuevaNovedadSeguimiento(){
  var tipo = $("#tipoN").val();
  var comentario = $("#comentarioN").val();
  var fecha = $("#fecha").val();
  var seguimiento = $("#seguimientoN").val();
  var labor = $("#laborN").val();
  //Validar campos
  if( comentario === "")
  {
    jAlert('¡Ingresa la Novedad', 'CAMPOS INCOMPLETOS');
  }else if( comentario === "" )
  {
    jAlert('¡Ingresa la Novedad', 'CAMPOS INCOMPLETOS');
  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:13,
              tipo:tipo,
              comentario:comentario,
              fecha:fecha,
              seguimiento:seguimiento,
              labor:labor
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
          jAlert('¡El Costo Directo fue agregado al corte con exito!', 'CONFIRMACION');
          recargarFormNovedad();
        }
      }
    });
    $("#nuevaNovedadSeguimiento").modal('hide');
    $('#seguimientoLabores').modal('show');
  }
}
function recargarFormNovedad(){
  $("#comentarioN").val("");
  $("#nuevaNovedadSeguimiento").modal("hide");
}
function verNovedadSeguimiento(idSeguimiento,finca,suerte,corte,labor,n_labor){
  var n_suerte = $("#suerte_sg").html();
  var n_finca = $("#finca_sg").html();
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-planificacion-cosechas.php",
    data: {
            opcion:14,
            idSeguimiento:idSeguimiento,
            labor:labor
          },
    success: function(res)
    {
      if(res.estado === "ERROR")
      {
        jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }
          else if(res.estado === "EMPTY")
      {
        jAlert('¡¡Esta labor no tiene Novedades asignadas', 'SIN NOVEDADES');
        console.log("Error:"+ res.msg);
        $("#novedadSeguimiento").modal('hide');
      }
      else if(res.estado === "OK")
      {
        var datos = [];
        for( var i=0; i < res.detalle.length; i++)
        {
          datos[i] = [
                        res.detalle[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        res.detalle[i].fecha,
                        '<center><a onclick="editarNovedadSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].tipo +'\',\''+ res.detalle[i].comentario +'\',\''+ res.detalle[i].fecha +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ finca +'\',\''+ suerte +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></center>',
                        '<center><a onclick="borrarNovedadSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ res.detalle[i].nombre_tipo +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a></center>',
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_novedadLabor').DataTable();
        table.destroy();
        $('#tabla_novedadLabor').DataTable( {
            data: datos,
            responsive: true,
            "order": [],
            "language":{
                "url"   :   "extensions/datatables/language/es.json"
            }
        } );
        $("#vm_labor_n").html(n_labor);
        $("#vm_finca_n").html(n_finca);
        $("#vm_suerte_n").html(n_suerte);
        $("#vm_corte_n").html(corte);

        $("#seguimientoLabores").modal('hide');
        $("#novedadSeguimiento").modal('show');
        $('#novedadSeguimiento').on('hidden.bs.modal', function (e) {
            $("#seguimientoLabores").modal('show'); // do something...
        });
      }
    }
  });
}
/* EDITA LOS NOVEDADES ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function editarNovedadSeguimiento(idDetalle,tipo,comentario,fecha,idSeguimiento,labor,finca,suerte,corte,nLabor,nFinca,nSuerte){
  //asignar los datos para edicion
  $("#edit_n_labor").html(nLabor);
  $("#edit_n_corte").html(corte);
  $("#edit_n_suerte").html(nSuerte);
  $("#edit_n_finca").html(nFinca);
  $("#edit_idDetalleN").val(idDetalle);
  $("#edit_tipoN").val(tipo); 
  $("#edit_comentarioN").val(comentario);
  $("#edit_fechaN").val(fecha);  
  $("#edit_seguimientoN").val(idSeguimiento);
  $("#edit_laborN").val(labor);  
  $("#edit_maquina_fincaN").val(finca);
  $("#edit_maquina_suerteN").val(suerte);
  $("#edit_maquina_corteN").val(corte);  
  $("#editarNovedadSeguimiento").modal('show');
}
/* GUARDA EDICION DE LOS NOVEDADES ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function guardarEdicionNovedadSeguimiento(){
  //obtengo los datos 
  var idDetalle = $("#edit_idDetalleN").val();
  var idSeguimiento = $("#edit_seguimientoN").val();
  var comentario = $("#edit_comentarioN").val();
  var fecha = $("#edit_fechaN").val(); 
  var labor = $("#edit_laborN").val(); 
  //Validar campos
  if( idDetalle === null )
  {
    jAlert('¡Seleciona la Novedad!', 'CAMPOS INCOMPLETOS');
  }
  else if( idDetalle === null )
  {
    jAlert('¡Seleciona la Novedad!', 'CAMPOS INCOMPLETOS');
  }
  else
  {
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:16,
              idDetalle:idDetalle,
              comentario:comentario,
              fecha:fecha
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          recargarDatos();
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡La Edición del Registro fue Exitosa!', 'CONFIRMACION');
          recargarNovedadSeguimiento();
          $("#editarNovedadSeguimiento").modal('hide');
        }
      }
    });
  }
}
/* GUARDA EDICION DE LOS NOVEDADES ASOCIADOS A LA LABOR ASIGNADA AL CORTE*/ 
function borrarNovedadSeguimiento(idDetalle,idSeguimiento,labor,nTipo,corte,nLabor,nFinca,nSuerte){
  if( confirm("¿Desea borrar el Novedad  " + nTipo + "  Asignado a la labor "+ nLabor + " del Corte # " + corte + "  " + nFinca + "  " + nSuerte + " ?") )
  {
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:17,
              idDetalle:idDetalle
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar la unidad', 'ERROR');
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡Registro eliminado con exito!', 'CONFIRMACION');
          recargarNovedadSeguimiento();

        }
      }
    });
  }
}
/* ACTUALIZA TABLA DE MAQUINAS ASOCIADOS A LA LABOR ASIGNADA AL CORTE DESPUES DE EDITARLA*/
function recargarNovedadSeguimiento(){
  var idSeguimiento = $("#edit_seguimientoN").val();
  var labor = $("#edit_laborN").val();
  var suerte = $("#edit_maquina_suerteN").val();
  var corte = $("#edit_maquina_corteN").val();
  var finca = $("#edit_maquina_fincaN").val();
  var nSuerte = $("#edit_n_suerte").html();
  var nFinca = $("#edit_n_finca").html();
  $.ajax(
  {
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-planificacion-cosechas.php",
    data: {
            opcion:14,
            idSeguimiento:idSeguimiento,
            labor:labor
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
        for( var i=0; i < res.detalle.length; i++)
        {
          datos[i] = [
                        res.detalle[i].comentario.replace(/(?:\\[rn]|[\r\n]+)+/g, "<br>"),
                        res.detalle[i].fecha,
                        '<center><a onclick="editarNovedadSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].tipo +'\',\''+ res.detalle[i].comentario +'\',\''+ res.detalle[i].fecha +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ finca +'\',\''+ suerte +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></center>',
                        '<center><a onclick="borrarNovedadSeguimiento(\''+ res.detalle[i].idDetalle +'\',\''+ res.detalle[i].idSeguimiento +'\',\''+ res.detalle[i].labor +'\',\''+ res.detalle[i].nombre_tipo +'\',\''+ corte +'\',\''+ res.detalle[i].nombre_labor +'\',\''+ n_finca +'\',\''+ n_suerte +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a></center>',
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_novedadLabor').DataTable();
        table.destroy();
        $('#tabla_novedadLabor').DataTable( {
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


function recargarDatos(){
  $.ajax(
  {
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-planificacion-cosechas.php",
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
        for( var i=0; i < res.produccion.length; i++)
        {
          datos[i] = [
                        res.produccion[i].finca,
                        res.produccion[i].suerte,
                        res.produccion[i].codigoCorte,
                        res.produccion[i].fecha_inicio,
                        res.produccion[i].area + " has" ,
                        res.produccion[i].variedad,
                        res.produccion[i].descripcion,
                        '<center><a data-toggle="modal" data-target="#editar" onclick="editarCorte(\''+ res.produccion[i].id +'\',\''+ res.produccion[i].id_finca +'\',\''+ res.produccion[i].id_suerte +'\',\''+ res.produccion[i].finca +'\',\''+ res.produccion[i].suerte +'\',\''+ res.produccion[i].fecha_cosecha +'\',\''+ res.produccion[i].fecha_inicio +'\',\''+ res.produccion[i].fecha_fin +'\',\''+ res.produccion[i].area +'\',\''+ res.produccion[i].descripcion +'\',\''+ res.produccion[i].codigoCorte +'\',\''+ res.produccion[i].variedad +'\',\''+ res.produccion[i].edad +'\',\''+ res.produccion[i].tct +'\',\''+ res.produccion[i].tch +'\',\''+ res.produccion[i].tchm +'\',\''+ res.produccion[i].rendimiento +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a></center>',
                        '<center><a onclick="seguimientoLabores(\''+ res.produccion[i].id +'\',\''+ res.produccion[i].id_finca +'\',\''+ res.produccion[i].id_suerte +'\',\''+ res.produccion[i].codigoCorte +'\',\''+ res.produccion[i].suerte +'\',\''+ res.produccion[i].finca +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-eye"></i></button></a></center>',
                        '<center><a onclick="nuevaLaborSeguimiento(\''+ res.produccion[i].id +'\',\''+ res.produccion[i].id_finca +'\',\''+ res.produccion[i].id_suerte +'\',\''+ res.produccion[i].codigoCorte +'\',\''+ res.produccion[i].suerte +'\',\''+ res.produccion[i].finca +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-plus"></i></button></a></center>',
                        '<center><a data-toggle="modal" data-target="#editar" onclick="finalizarCosecha(\''+ res.produccion[i].id +'\',\''+ res.produccion[i].id_finca +'\',\''+ res.produccion[i].id_suerte +'\',\''+ res.produccion[i].finca +'\',\''+ res.produccion[i].suerte +'\',\''+ res.produccion[i].fecha_cosecha +'\',\''+ res.produccion[i].fecha_inicio +'\',\''+ res.produccion[i].fecha_fin +'\',\''+ res.produccion[i].area +'\',\''+ res.produccion[i].descripcion +'\',\''+ res.produccion[i].codigoCorte +'\',\''+ res.produccion[i].variedad +'\',\''+ res.produccion[i].edad +'\',\''+ res.produccion[i].tct +'\',\''+ res.produccion[i].tch +'\',\''+ res.produccion[i].tchm +'\',\''+ res.produccion[i].rendimiento +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-unlock-alt"></i></button></a></center>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_planificacion').DataTable();
        table.destroy();
        $('#tabla_planificacion').DataTable( {
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
function nuevoCorte(){
  var idProduccion = $("#idProduccion_sg").val();
  var finca = $("#finca").val();
  var suerte = $("#unidad_agricola").val();
  var corte = $("#corte").val();
  var labor = $("#labor").val();
  var fecha_inicio = $("#fecha_inicio").val();
  var fecha_fin = $("#fecha_fin").val();
  //Validar campos
  if( labor === "NULL")
  {
    alert("Por favor ingrese la labor");
  }
  else{
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:1,
              idProduccion:idProduccion,
              finca:finca,
              suerte:suerte,
              corte:corte,
              labor:labor,
              fecha_inicio:fecha_inicio,
              fecha_fin:fecha_fin
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Registro creado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
function recargarFomGuardar(){
  $("#finca").val("NULL");
  $("#unidad_agricola").val("NULL");
  $("#corte").val("");
  $("#area").val("");
  $("#descripcion").val("");
  $("#variedad").val("");
  $("#labor").val("");
  $("#fecha_inicio").val("");
  $("#fecha_fin").val("");
  $("#resultadoBusqueda").html('');
  $("#complemento").css("display", "none");
  $(".buscar").css("display", "block");
  $("#nuevoCorte").modal("hide");
}
function nuevoResultadoProduccion(){
  var finca = $("#finca").val();
  var unidad_agricola = $("#unidad_agricola").val();
  var codigoCorte = $("#corte").val();
  var area = $("#area").val();
  var descripcion = $("#descripcion").val();
  var variedad = $("#variedad").val();
  //Validar campos
  if( codigoCorte === "")
  {
    jAlert('¡Por favor ingrese el codigo', 'CAMPOS INCOMPLETOS');
  }else if( codigoCorte === "" )
  {

  }else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-planificacion-cosechas.php",
      data: {
              opcion:6,
              finca:finca,
              unidad_agricola:unidad_agricola,
              codigoCorte:codigoCorte,
              area:area,
              descripcion:descripcion,
              variedad:variedad
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Registro creado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardarResultado();
        }
      }
    });
  }
}
function recargarFomGuardarResultado(){
  $("#finca").val("NULL");
  $("#unidad_agricola").val("NULL");
  $("#area").val("");
  $("#descripcion").val("");
  $("#corte").val("");
  $("#variedad").val("");
  $("#resultadoBusqueda").html('');
  $("#complemento").css("display", "none");
  $("#nuevoCorte").modal("hide");
}
function buscar() {
  var textoBusqueda = $("#corte").val();
  var finca = $("#finca").val();
  var nFinca = $("#finca option:selected").html();
  var suerte = $("#unidad_agricola").val();
  var nSuerte = $("#unidad_agricola option:selected").text();
  
  if( nFinca === "Finca")
  {
    jAlert('¡Selecciona la Finca!', 'CAMPOS INCOMPLETOS');
    $("#finca").focus();
  }
  else if( nSuerte === "Seleccione la Suerte" )
  {
    jAlert('¡Selecciona la Suerte!', 'CAMPOS INCOMPLETOS');
    $("#unidad_agricola").focus();
  }
  else if( textoBusqueda === "" )
  {
    jAlert('¡Ingresa el # de Corte!', 'CAMPOS INCOMPLETOS');
    $("#corte").focus();
  }
  else if (textoBusqueda != "") 
  {
    $.ajax({
        cache:false,
        dataType:"json",
        type:"POST",
        url: "./querys/q-planificacion-cosechas.php",
        data: {
                opcion:15,
                textoBusqueda:textoBusqueda,
                finca:finca,
                suerte:suerte,
              },
        success: function(res)
        {
          if(res.estado === "ERROR")
          {
            jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
            console.log("Error:"+ res.msg);
          }
          else if(res.estado === "EMPTY")
          {
            var mensaje = "";
            jAlert('¡¡El corte # '+ textoBusqueda +' '+ nFinca +' '+ nSuerte +' No Existe. Por favor ingresar los datos para crearlo.', 'NUEVO CORTE', function(){
              mensaje += '<div class="form-group"><label for="area">&Aacute;rea</label><input id="area" name="area" class="form-control" placeholder="&Aacute;rea" onkeypress="return valida(event)" ></div><div class="form-group"><label for="descripcion">Observaci&oacute;n</label><input id="descripcion" name="descripcion" class="form-control" placeholder="Observaci&oacute;n" ></div><div class="form-group">  <label for="variedad">Variedad</label>  <input id="variedad" name="variedad" class="form-control" placeholder="Variedad" ></div><button type="button" onclick="nuevoResultadoProduccion()" id="form-submit" class="btn btn-default pull-right ">Crear</button><div id="msgSubmit" class="h3 text-center hidden">Creado!</div>';
              $(".buscar").hide();
              $("#resultadoBusqueda").html(mensaje);
              $("#area").focus();
            });
            $("#resultadoBusqueda").delay(3000).empty();
          }
          else if(res.estado === "EXIST")
          {
            var mensaje = "";
            jAlert('¡¡El corte # '+ textoBusqueda +' '+ nFinca +' '+ nSuerte +' ya fue cosechado el dia '+ res.resultados2[0].fechaCosecha +' .', 'CORTE YA FUE COSECHADO', function(){
              mensaje += '<br><div id="msg_error_validacion" class="alert alert-danger" role="alert"><center><label><h3>El Corte  # '+ textoBusqueda +' '+nFinca +' '+ nSuerte +' ya fue cosechado el dia '+ res.resultados2[0].fechaCosecha +' </h3></label></center></div>';
              $("#resultadoBusqueda").html(mensaje);
              $("#corte").val("");
              $("#corte").focus();
            });
            $("#resultadoBusqueda").delay(3000).empty();
          }
          else if(res.estado === "OK")
          {
            for( var i=0; i < res.resultados.length; i++)
            {
              var idProduccion = res.resultados[i].idProduccion; 
              var suerte = res.resultados[i].idUnidadAgricola;
              var nsuerte = res.resultados[i].nombre_unidad_agricola;
              var finca = res.resultados[i].finca;
              var nfinca = res.resultados[i].nombre_finca;
              var corte = res.resultados[i].corte;
              var descripcion = res.resultados[i].descripcion;
              var area = res.resultados[i].area;
              var variedad = res.resultados[i].variedad;
              var fechaCosecha = res.resultados[i].fechaCosecha;
              var mensaje = "";
              //Output
              if (fechaCosecha==='0000-00-00')
              {
                jAlert('¡¡El corte # '+ corte +' '+nFinca +' '+ nSuerte +' ya fue Creado. Puede agregar una Labor.', 'AGREGAR LABOR AL CORTE', function(){
                  mensaje += '<div class="row" id="msj"><input type="hidden" value="'+ idProduccion +'" id="idProduccion_sg" ><div class="col-xs-12 col-sm-6 col-md-4 col-lg-4"><div class="form-group"><label for="area">Area:</label><input id="area" name="area" class="form-control" value="'+ area +'" ></div></div><div class="col-xs-12 col-sm-6 col-md-4 col-lg-4"><div class="form-group"><label for="descripcion">Descripción:</label><input id="descripcion" name="descripcion" class="form-control" value="'+ descripcion +'" ></div></div><div class="col-xs-12 col-sm-6 col-md-4 col-lg-4"><div class="form-group"><label for="variedad">Variedad:</label><input id="variedad" name="variedad" class="form-control" value="'+ variedad +'" ></div></div></div><div id="msg_error_validacion" class="alert alert-success" role="alert"><center><label><h3>Agregar labor al corte # '+ corte +' '+nFinca +' '+ nSuerte +'</h3></label></center></div> ';
                  $("#resultadoBusqueda").html(mensaje);
                  $(".buscar").css("display", "none");
                  $("#complemento").css("display", "inline-block");
                });
                
              }
             } 
          }
        }
      });


  } 
  else {
    $("#resultadoBusqueda").html('');
    $("#complemento").css("display", "none");
  };
  $('#nuevoCorte').on('hidden.bs.modal', function () {
    // resetear campos …
    $("#finca").val("NULL");
    $("#unidad_agricola").val("NULL");
    $("#corte").val("");
    $("#resultadoBusqueda").html('');
    $("#complemento").css("display", "none");
    $(".buscar").css("display", "block");
  });
}
//FUNCION ENCARGADA DE EDITAR LOS DATOS DEL CORTE 
function editarCorte(id,finca,idUnidadAgricola,nFinca,nUnidadAgricola,fechaCosecha,fechaInicio,fechaFin,area,descripcion,corte,variedad,edad,TCT,TCH,TCHM,rendimiento){//Asignar valores de edición
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
  $("#editCorte").modal('show');
}
//FUNCION ENCARGADA DE GUARDAR LOS DATOS QUE SE EDITARON EN EL CORTE
function guardarEdicionCorte(){
  var id = $("#edit_id").val();
  var finca = $("#edit_finca option:selected").val();
  var idUnidadAgricola = $("#edit_unidad_agricola option:selected").val();
  var fechaInicio = $("#edit_fechaInicio").val();
  var fechaFin = $("#edit_fechaFin").val();
  var area = $("#edit_area").val();
  var descripcion = $("#edit_descripcion").val();
  var corte = $("#edit_codigoCorte").val();
  var variedad = $("#edit_variedad").val();
  //Validar campos
  if( finca === "")
  {
    alert("Por favor ingrese la finca");
  }
  else if( unidad_agricola === "NULL" )
  {

  }
  else
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-prontuario.php",
      data: {
          opcion:7,
          finca:finca,
          idUnidadAgricola:idUnidadAgricola,
          fechaInicio:fechaInicio,
          fechaFin:fechaFin,
          area:area,
          descripcion:descripcion,
          corte:corte,
          variedad:variedad,
          id:id
        },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al procesar la actualización', 'ERROR');
          recargarDatos();
          console.log("Error:"+ res.msg);
        }
        else if(res.estado === "OK")
        {
          jAlert('¡Unidad Agrícola actualizada con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  }
  $("#editCorte").modal('hide');
}

//FUNCION ENCARGADA DE ABRIR EL MODAL PARA AGREGAR LA FECHA DE COSECHA Y OTROS DATOS
function finalizarCosecha(id,finca,idUnidadAgricola,nFinca,nUnidadAgricola,fechaCosecha,fechaInicio,fechaFin,area,descripcion,corte,variedad,edad,TCT,TCH,TCHM,rendimiento){
   //Asignar valores de edición
  $("#fin_id").val(id);
  $("#fin_finca option:selected").val( finca === '' ? "NULL" : finca );
  $("#fin_finca option:selected").html( nFinca );
  $("#fin_unidad_agricola option:selected").val( idUnidadAgricola === '' ? "NULL" : idUnidadAgricola );
  $("#fin_unidad_agricola option:selected").html( nUnidadAgricola );
  $("#fin_fechaCosecha").val(fechaCosecha);
  $("#fin_fechaInicio").val(fechaInicio);
  $("#fin_fechaFin").val(fechaFin);
  $("#fin_area").val(area);
  $("#fin_descripcion").val(descripcion);
  $("#fin_codigoCorte").val(corte);
  $("#fin_variedad").val(variedad);
  $("#fin_edad").val(edad);
  $("#fin_TCT").val(TCT);
  $("#fin_TCH").val(TCH);
  $("#fin_TCHM").val(TCHM);
  $("#fin_rendimiento").val(rendimiento);
  $("#finCorte").modal('show');
}
//FUNCION ENCARGADA DE GUARDAR LOS DATOS QUE SE finARON EN EL CORTE
function guardarFin(){
  var id = $("#fin_id").val();
  var fechaCosecha = $("#fin_fechaCosecha").val();
  var edad = $("#fin_edad").val();
  var TCT = $("#fin_TCT").val();
  var TCH = $("#fin_TCH").val();
  var TCHM = $("#fin_TCHM").val();
  var rendimiento = $("#fin_rendimiento").val();
  //Validar campos
  if( fechaCosecha === "0000-00-00")
  {
    alert("Por favor ingrese la fecha de cosecha");
    $("#fin_fechaCosecha").focus();
  }
  else if( fechaCosecha === "" )
  {
    alert("Por favor ingrese la fecha de cosecha");
    $("#fin_fechaCosecha").focus();
  }
  else
  {
    $.ajax(
    {
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-prontuario.php",
      data: {
          opcion:8,
          fechaCosecha:fechaCosecha,
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
        }
        else if(res.estado === "OK")
        {
          jAlert('¡Unidad Agrícola actualizada con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  }
  $("#finCorte").modal('hide');
}
/*  VALIDA AREA */
function valida(e){
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla==8){
        return true;
    }
        
    // Patron de entrada, en este caso solo acepta numeros
    patron =/[0-9-.]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}
//Document Ready Funtions //
$(document).ready(function(){
  recargarFomGuardar();
  $('#tabla_planificacion').DataTable( {
      responsive: true,
      "order": [],
      "language":{
          "url"   :   "extensions/datatables/language/es.json"
      }
  });
  $('#tabla_seguimientoLabores').DataTable( {
      responsive: true,
      "order": [],
      "language":{
          "url"   :   "extensions/datatables/language/es.json"
      }
  } );
  $('#tabla_maquinaHerramientaLabor').DataTable( {
      responsive: true,
      "order": [],
      "language":{
          "url"   :   "extensions/datatables/language/es.json"
      }
  });
  $("#finca").change(function () {
       $("#finca option:selected").each(function () {
        id_padre = $(this).val();
        $.post("ua.php", { id_padre: id_padre }, function(data){
            $("#unidad_agricola").html(data);
        });
    });
  })
  $("#edit_finca").change(function () {
       $("#edit_finca option:selected").each(function () {
        id_padre = $(this).val();
        $.post("ua.php", { id_padre: id_padre }, function(data){
            $("#edit_unidad_agricola").html(data);
        });
    });
  })
  $("#suerte").change(function () {
       $("#suerte option:selected").each(function () {
        id_suerte = $(this).val();
        $.post("ua.php", { id_suerte: id_suerte }, function(data){
            $("#corte").html(data);
        });
    });
  })
  $("#resultadoBusqueda").html('');
  $("#complemento").css("display", "none");
});//end Document Ready Funtions
