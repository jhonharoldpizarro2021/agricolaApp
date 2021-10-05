function editarEmpleado(id,doc,nacimiento,nombre,direccion,telefono,celular,email,eps,arl,pension,ingreso,estado_civil,hijos,cuenta)
{
  $("#edit_id_personal").val(id);
  $("#edit_doc").val(doc);
  $("#edit_fecha_nac").val(nacimiento);
  $("#edit_nombre").val(nombre);
  $("#edit_dir").val(direccion);
  $("#edit_tel").val(telefono);
  $("#edit_cel").val(celular);
  $("#edit_email").val(email);
  $("#edit_eps").val(eps === '' ? "NULL" : eps);
  $("#edit_arl").val(arl === '' ? "NULL" : arl);
  $("#edit_pension").val(pension === '' ? "NULL" : pension);
  $("#edit_fecha_ingreso").val(ingreso);
  $("#edit_estado_civil").val(estado_civil);
  $("#edit_hijos").val(hijos);
  $("#edit_cuenta").val(cuenta);
  $("#editPersonal").modal('show');
}
function guardarEdicion()
{
  var id = $("#edit_id_personal").val();
  var doc = $("#edit_doc").val();
  var nacimiento = $("#edit_fecha_nac").val();
  var nombre = $("#edit_nombre").val();
  var direccion = $("#edit_dir").val();
  var telefono = $("#edit_tel").val();
  var celular = $("#edit_cel").val();
  var email = $("#edit_email").val();
  var eps = $("#edit_eps").val();
  var arl = $("#edit_arl").val();
  var pension = $("#edit_pension").val();
  var ingreso = $("#edit_fecha_ingreso").val();
  var estado_civil = $("#edit_estado_civil").val();
  var hijos = $("#edit_hijos").val();
  var cuenta = $("#edit_cuenta").val();

  //Validar campos
  if( doc === "")
  {
    jAlert('¡¡Lo sentimos, el campo Documento es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#doc").focus();
        });
  }
  else if( nacimiento === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Fecha de Nacimiento es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#fecha_nac").focus();
        });
  }
  else if( nombre === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Nombre y Apellido es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#new_email").focus();
        });
  }
  else if( direccion === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Direcci&oacute;n es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#dir").focus();
        });
  }
  else if( celular === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Celular es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#cel").focus();
        });
  }
  else if( email === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Correo Electronico es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#email").focus();
        });
  }
  else if( !validarEmail(email) )
  {
    jAlert('¡¡Lo sentimos, el Correo Electronico no posee el formato adecuado', 'FORMATO INVALIDO', function(){
          $("#email").focus();
        });
  }
  else if( eps === "" )
  {
    jAlert('¡¡Lo sentimos, el campo EPS es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#eps").focus();
        });
  }
  else if( arl === "" )
  {
    jAlert('¡¡Lo sentimos, el campo ARL es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#arl").focus();
        });
  }
  else if( pension === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Fondo de Pension es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#pension").focus();
        });
  }
  else if( ingreso === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Fecha de Ingreso es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#fecha_ingreso").focus();
        });
  }
  else if( estado_civil === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Estado Civil  es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#estado_civil").focus();
        });
  }
  else if( cuenta === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Cuenta Bancaria es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#cuenta").focus();
        });
  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-personal.php",
      data: {
              opcion:2,
              nombre:nombre,
              doc:doc,
              nacimiento:nacimiento,
              direccion:direccion,
              telefono:telefono,
              celular:celular,
              email:email,
              ingreso:ingreso,
              estado_civil:estado_civil,
              hijos:hijos,
              eps:eps,
              arl:arl,
              pension:pension,
              cuenta:cuenta,
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
          jAlert('¡Actualizado con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  }
  $("#editPersonal").modal('hide');
}
function recargarDatos()
{
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q-personal.php",
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
        for( var i=0; i < res.personal.length; i++)
        {
          datos[i] = [
                        res.personal[i].nombre,
                        res.personal[i].doc,
                        res.personal[i].nacimiento,
                        res.personal[i].direccion,
                        res.personal[i].telefono,
                        res.personal[i].celular,
                        res.personal[i].email,
                        res.personal[i].ingreso,
                        res.personal[i].estado_civil,
                        res.personal[i].hijos,
                        res.personal[i].nombre_eps,
                        res.personal[i].nombre_arl,
                        res.personal[i].nombre_pension,
                        res.personal[i].cuenta,
                        '<a data-toggle="modal" data-target="#editar" onclick="editarEmpleado(\''+ res.personal[i].id +'\',\''+ res.personal[i].doc +'\',\''+ res.personal[i].nacimiento +'\',\''+ res.personal[i].nombre +'\',\''+ res.personal[i].direccion +'\',\''+ res.personal[i].telefono +'\',\''+ res.personal[i].celular +'\',\''+ res.personal[i].email +'\',\''+ res.personal[i].eps +'\',\''+ res.personal[i].arl +'\',\''+ res.personal[i].pension +'\',\''+ res.personal[i].ingreso +'\',\''+ res.personal[i].estado_civil +'\',\''+ res.personal[i].hijos +'\',\''+ res.personal[i].cuenta +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-pencil"></i></button></a>',
                        '<a href="javascript:borrarEmpleado(\''+ res.personal[i].id +'\')" aria-hidden="true"><button type="button" class="btn btn-default btn-circle btn-pq" ><i class="fa fa-trash-o"></i></button></a>'
                      ];
        }
        //Recargar tabla con función propia de dataTable
        var table = $('#tabla_personal').DataTable();
        table.destroy();
        $('#tabla_personal').DataTable( {
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
function borrarEmpleado(id)
{
  if( confirm("¿Desea borrar el Empleado?") )
  {
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-personal.php",
      data: {
              opcion:3,
              id:id
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al eliminar el Empleado', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Empleado eliminado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
/**
* Función encargada de gestionar la apertura del PopUp para el ingreso del nuevo Empleado
*/
function abrirNuevo()
{
  $("#modalSpinner").modal("show");
  //Consultar perfiles
  $.ajax(
  {
      cache: false,
      type: "POST",
      url: "querys/q-personal.php",
      data: { opcion : 8 },
      dataType: "json",
      success: function(res)
      {
          if( res.status === "OK" )
          { //console.log(""+res);
            //spinner
            
            //lista EPS
            var lista = "";
            for( var i=0; i < res.eps.length; i++ )
            {
              lista += '<option value="'+ res.eps[i].id +'">'+ res.eps[i].nombre +'</option>';
            }
            $("#eps").html( lista );
            //lista ARL
            var lista2 = "";
            for( var i=0; i < res.arl.length; i++ )
            {
              lista2 += '<option value="'+ res.arl[i].id +'">'+ res.arl[i].nombre +'</option>';
            }
            $("#arl").html( lista2 );
            //lista Pension
            var lista3 = "";
            for( var i=0; i < res.pension.length; i++ )
            {
              lista3 += '<option value="'+ res.pension[i].id +'">'+ res.pension[i].nombre +'</option>';
            }
            $("#pension").html( lista3 );
            
            //Resetear campos
            $("#doc").val("");
            $("#fecha_nac").val("");
            $("#nombre").val("");
            $("#dir").val("");
            $("#tel").val("");
            $("#cel").val("");
            $("#email").val("");
            $("#fecha_ingreso").val("");
            $("#estado_civil").val("");
            $("#hijos").val("");
            $("#cuenta").val("");
            $("#nuevoEmpleado").modal("hide");

            //Abrir PopUp
            $("#modalSpinner").modal("hide");
            $("#nuevoEmpleado").modal("show");
            $('#nuevoEmpleado').on('shown.bs.modal', function (e) {
                $("#doc").focus();
            });
          }else if(res.status === "EXPIRED" )//Sesión finalizada
          {
            jAlert('Su sesión ha caducado, por favor inicie sesión de nuevo', 'Sesión expirada', function(){
              window.location = "cerrar_sesion.php";
            });
          }else if( res.status === "ERROR")
          {
            jAlert('Lo sentimos, se ha presentado un error:<br>['+ res.msg +']', 'Error');
          }
      }
  });
}

function nuevoPersonal()
{
  var doc = $("#doc").val();
  var nacimiento = $("#fecha_nac").val();
  var nombre = $("#nombre").val();
  var direccion = $("#dir").val();
  var telefono = $("#tel").val();
  var celular = $("#cel").val();
  var email = $("#email").val();
  var eps = $("#eps").val();
  var arl = $("#arl").val();
  var pension = $("#pension").val();
  var ingreso = $("#fecha_ingreso").val();
  var estado_civil = $("#estado_civil").val();
  var hijos = $("#hijos").val();
  var cuenta = $("#cuenta").val();
  //Validar campos
  if( doc === "")
  {
    jAlert('¡¡Lo sentimos, el campo Documento es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#doc").focus();
        });
  }
  else if( nacimiento === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Fecha de Nacimiento es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#fecha_nac").focus();
        });
  }
  else if( nombre === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Nombre y Apellido es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#new_email").focus();
        });
  }
  else if( direccion === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Direcci&oacute;n es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#dir").focus();
        });
  }
  else if( celular === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Celular es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#cel").focus();
        });
  }
  else if( email === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Correo Electronico es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#email").focus();
        });
  }
  else if( !validarEmail(email) )
  {
    jAlert('¡¡Lo sentimos, el Correo Electronico no posee el formato adecuado', 'FORMATO INVALIDO', function(){
          $("#email").focus();
        });
  }
  else if( eps === "" )
  {
    jAlert('¡¡Lo sentimos, el campo EPS es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#eps").focus();
        });
  }
  else if( arl === "" )
  {
    jAlert('¡¡Lo sentimos, el campo ARL es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#arl").focus();
        });
  }
  else if( pension === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Fondo de Pension es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#pension").focus();
        });
  }
  else if( ingreso === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Fecha de Ingreso es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#fecha_ingreso").focus();
        });
  }
  else if( estado_civil === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Estado Civil  es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#estado_civil").focus();
        });
  }
  else if( cuenta === "" )
  {
    jAlert('¡¡Lo sentimos, el campo Cuenta Bancaria es de caracter obligatorio', 'CAMPO REQUERIDO', function(){
          $("#cuenta").focus();
        });
  }
  else{
    $.ajax({
      cache:false,
      dataType:"json",
      type:"POST",
      url: "./querys/q-personal.php",
      data: {
              opcion:1,
              doc:doc,
              nacimiento:nacimiento,
              nombre:nombre,
              direccion:direccion,
              telefono:telefono,
              celular:celular,
              email:email,
              eps:eps,
              arl:arl,
              pension:pension,
              ingreso:ingreso,
              estado_civil:estado_civil,
              hijos:hijos,
              cuenta:cuenta
            },
      success: function(res)
      {
        if(res.estado === "ERROR")
        {
          jAlert('¡¡Lo sentimos, ocurrió un error al guardar los datos', 'ERROR');
          console.log("Error:"+ res.msg);
        }else if(res.estado === "OK")
        {
          jAlert('¡Empleado creado con exito!', 'CONFIRMACION');
          recargarDatos();
          recargarFomGuardar();
        }
      }
    });
  }
}
function recargarFomGuardar()
{
  $("#doc").val("");
  $("#fecha_nac").val("");
  $("#nombre").val("");
  $("#dir").val("");
  $("#tel").val("");
  $("#cel").val("");
  $("#email").val("");
  $("#eps").val("");
  $("#arl").val("");
  $("#pension").val("");
  $("#fecha_ingreso").val("");
  $("#estado_civil").val("");
  $("#hijos").val("");
  $("#cuenta").val("");
  $("#nuevoEmpleado").modal("hide");
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
  $(document).on('click','.editable-submit',function()
  {
    var id = $(this).closest('td').children('span').attr('id');
    var campo_q = $(this).closest('td').children('span').attr('campo_query');
    var valor_q = $('.editable-input .input-sm').val();
    $.ajax({
      url: "./querys/q-personal.php",
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
          jAlert('Campo Actualizado con exito!', 'CONFIRMACION');
          recargarDatos();
        }
      }
    });
  });
  //Resetear formulario Al Guardar Nueva labor
  recargarFomGuardar();
  //
  $('#tabla_personal').DataTable( {
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
