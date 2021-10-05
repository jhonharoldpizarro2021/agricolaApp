// ASIGNA FORMATO MONEDA
var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
  num +='';
  var splitStr = num.split('.');
  var splitLeft = splitStr[0];
  var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
  var regx = /(\d+)(\d{3})/;
  while (regx.test(splitLeft)) {
  splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
  }
  return this.simbol + splitLeft  +splitRight;
 },
 new:function(num, simbol){
  this.simbol = simbol ||'';
  return this.formatear(num);
 }
}
// VARIABLE PARA ALMACENAR COSTOS INDIRECTOS PARA HACER CALCULO
var totalCosInd = 0;
/* MUESTRA LOS DATOS DEL CORTE ACTUAL */
function corteActual(finca,suerte,nSuerte,nFinca){
  $("#modalSpinner").modal("show"); // muestra spinner
  $(".panel-body").fadeIn(500);
  //RESETEAR CAMPOS CUANDO SE QUIER EVER UN NUEVO DATO
  $('#datosCorteAnterior').hide();
  $('#datosCorteAnterior').html("");
  $('#idProduccion').html("");
  $('#idProduccionActual').html("");
  $('#finca').html("");
  $('#idFinca').html("");
  $('#suerte').html("");
  $('#idSuerte').html("");
  $('#corteActual').html("");
  $('#corte').html("");
  $('#areaActual').html("");
  $('#edadActual').html("");
  $('#fechaCosecha').html("");
  $('#geolocalizacion').html('');
  $('#curvasNivel').html('');
  $('#zonaAgro').html('');
  $('#costosIndirectos').html("");
  $('#variedad').html("");
  $('#edad').html("");
  $('#tct').html("");
  $('#tch').html("");
  $('#tchm').html("");
  $('#rendimiento').html("");
  $('#costosDirectos').html("");
  $('#costosTotales').html("");
  $('#has').html("");
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q_seguimiento_labores.php",
    data: {
            opcion:1,
            finca:finca,
            suerte:suerte
          },
    success: function(res){
      if(res.estado === "ERROR"){
        jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        $("#modalSpinner").modal("hide"); //ocultar spinner
        console.log("Error:"+ res.msg);
      }
      else if(res.estado === "EMPTY"){
        jAlert('¡¡Este Corte no tiene labores asignadas', 'SIN LABORES');
        $("#modalSpinner").modal("hide"); // ocultar spinner
        console.log("Error:"+ res.msg);
      }
      else if(res.estado === "OK"){
        for( var i=0; i < res.corteactual.length; i++){
          var idFinca = res.corteactual[i].idFinca;
          var idSuerte = res.corteactual[i].idSuerte;
          var corte = res.corteactual[i].corte;
          var fechaUltimaCosecha = res.corteactual[i].fechaCosecha;
          var idProduccion = res.corteactual[i].idProduccion;
          var areaActual = res.corteactual[i].area;
          var costos =  res.corteactual[i].totalCI;
          var idProduccionActual = res.corteactual[i].idProduccionActual;
          var corteActual = res.corteactual[i].corteActual;
          var variedad = res.corteactual[i].variedad;
          var edad = res.corteactual[i].edad;
          var tct = res.corteactual[i].tct;
          var tch = res.corteactual[i].tch;
          var tchm = res.corteactual[i].tchm;
          var rendimiento = res.corteactual[i].rendimiento;
        }
        var curvas = res.curvas;
        var zonaAgro = res.zonaAgro;
        $('#idProduccion').html(idProduccion);
        $('#idProduccionActual').html(idProduccionActual);
        $('#finca').html(nFinca);
        $('#idFinca').html(idFinca);
        $('#suerte').html(nSuerte);
        $('#idSuerte').html(idSuerte);
        $('#corteActual').html(corteActual);
        $('#corte').html(corte);
        $('#areaActual').html(areaActual);
        if(areaActual != ""){
          $('#has').html(" has");
        }
        else if(areaActual === ""){
          $('#has').html("");
        }
        $('#fechaCosecha').html(fechaUltimaCosecha);
        $('#geolocalizacion').html('<a id="point" href="javascript:geolocalizacion(\''+ idSuerte +'\')" aria-hidden="true"> Ver <i class="fa fa-map-marker" aria-hidden="true"></i></a>');
        $('#curvasNivel').html('<a href="./curvas/'+ idSuerte +'.pdf" target="_blank">Ver <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>');
        $('#zonaAgro').html('<a href="./zonas_agroecologicas/'+ idSuerte +'.pdf" target="_blank">Ver <i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>');
        var hectareas = areaActual.replace(/\,/g, '.');
        var totalCI = costos / hectareas;
        $('#costosIndirectos').html(formatNumber.new(parseInt(totalCI), "$"));
        edadActual();
        $('#variedad').html(variedad);
        $('#edad').html(edad);
        $('#tct').html(tct);
        $('#tch').html(tch);
        $('#tchm').html(tchm);
        $('#rendimiento').html(rendimiento);
        datosCorteActual(idFinca,idSuerte,idProduccionActual);
        totalCosInd = totalCI;
        $("#modalSpinner").modal("hide"); //ocultar spinner
        
      }
    }
  });
}
/* EDAD COSECHA ACTUAL O ULTIMO CORTE*/
function edadActual(){
  var idFinca = $('#idFinca').html();
  var idSuerte = $('#idSuerte').html();
  var fechaUltimaCosecha = $('#fechaCosecha').html();
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q_seguimiento_labores.php",
    data: {
            opcion:4,
            idFinca:idFinca,
            idSuerte:idSuerte,
            fechaUltimaCosecha:fechaUltimaCosecha
          },
    success: function(res){
      if(res.estado === "ERROR"){
        jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }
          else if(res.estado === "EMPTY"){
        jAlert('¡¡Este Corte no tiene labores asignadas', 'SIN LABORES');
        console.log("Error:"+ res.msg);
      }
      else if(res.estado === "OK"){
        //edad corte actual
        var calcular = (res.edadActual)/30 ;
        var edadActual = calcular.toFixed(2) + '  Meses';
        $('#edadActual').html(edadActual);
      }
    }
  });
}
/* MUESTRA LABORES CORTE ACTUAL*/
function datosCorteActual(idFinca,idSuerte,idProduccionActual){
  var idFinca = idFinca;
  var idSuerte = idSuerte;
  var idProduccionActual = idProduccionActual;
  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q_seguimiento_labores.php",
    data: {
            opcion:3,
            idFinca:idFinca,
            idSuerte:idSuerte,
            idProduccionActual:idProduccionActual
          },
    success: function(res){
      if(res.estado === "ERROR"){
        jAlert('¡¡Lo sentimos, ocurrió un error al procesar los datos', 'ERROR');
        console.log("Error:"+ res.msg);
      }
      else if(res.estado === "EMPTY"){
        jAlert('¡¡Este Corte no tiene labores asignadas', 'SIN LABORES');
        console.log("Error:"+ res.msg);
      }
      else if(res.estado === "OK"){
          var listaLabores ='';
          for( var j=0; j< res.labores.length; j++){
            var idSeguimiento = res.labores[j].idSeguimiento;
            var idLabor = res.labores[j].idLabor;
            var labor = res.labores[j].labor;
            var fechaInicio = res.labores[j].fechaInicio;
            var fechaFin = res.labores[j].fechaFin;
            var idFinca = res.labores[j].idFinca;
            var nFinca = res.labores[j].nombreFinca;
            var idSuerte = res.labores[j].idSuerte;
            var nSuerte = res.labores[j].nombreSuerte;
            
            listaLabores += '<!-- panel --><div class="panel panel-custom"><div class="panel-heading"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+ idSeguimiento +'" aria-expanded="true" class="tg'+ idSeguimiento +'"><div class="row"><div class="col-sm-12 col-md-4"><div class="row show-grid"><span id="idSeguimiento" style="display: none;">'+ res.labores[j].idSeguimiento +'</span><div class="col-md-12"><div class="nom"><i>Labor:</i></div><div class="data"><h3><span id="labor">'+ res.labores[j].labor +'</span></h3></div></div></div></div><div class="col-sm-12 col-md-4"><div class="row show-grid"><div class="col-md-12"><div class="nom"><i>Fecha Inicio:</i></div><div class="data"><h3><span id="fechaInicio">'+ res.labores[j].fechaInicio +'</span></h3></div></div></div></div><div class="col-sm-12 col-md-4"><div class="row show-grid"><div class="col-md-12"><div class="nom"><i>Fecha Fin:</i></div><div class="data"><h3><span id="fechaFin">'+ res.labores[j].fechaFin +'</span></h3></div></div></div></div></a></div></div>';
            
            listaLabores += '<div id="collapse'+ res.labores[j].idSeguimiento +'" class="panel-collapse collapse" aria-expanded="true"><div class="panel-body"><div class="row">';
            
            listaLabores += '<div class="col-md-12"><div class="panel panel-red"><div class="panel-heading"><h4>Maquinaria</h4></div><div class="panel-body"><div class="dataTable_wrapper table-responsive">';
            var tablaMaquinas = [];
            if ( res.labores[j].maquinas.length === 0 ){
                  tablaMaquinas[m] = [
                                    listaLabores += '<div id="alertaVacio" class="col-md-12"><div class="alert alert-danger " role="alert"> <h4>Aun no se han agregado Maquinas.</h4></div></div>',
                              ];
                } 
            else {
              listaLabores += '<table class="table table-striped table-bordered table-hover" id="tabla_maquinaria"><thead><tr><th>Maquina</th><th>Comentario</th><th>Fecha</th><th>Combustible</th></tr></thead><tbody id="body">';
              for( var m=0; m < res.labores[j].maquinas.length; m++){
                
                tablaMaquinas[m] = [
                                    listaLabores += '<tr>',
                                    listaLabores += '<td>'+ res.labores[j].maquinas[m].nMaquina +'</td>',
                                    listaLabores += '<td>'+ res.labores[j].maquinas[m].comentario +'</td>',
                                    listaLabores += '<td>'+ res.labores[j].maquinas[m].fecha +'</td>',
                                    listaLabores += '<td>'+ res.labores[j].maquinas[m].combustible +' Litros / ' + Math.round(res.labores[j].maquinas[m].combustible / 0.264172).toFixed(2) + ' Galones</td>',
                                    listaLabores += '</tr>',
                                  ];
                
              }
              listaLabores += '</tbody></table>';
            }
            listaLabores += '</div><!-- /.table-responsive --></div><!-- /.panel-body --></div></div>';
            listaLabores += '<div class="col-md-12"><div class="panel panel-danger"><div class="panel-heading"><h4>Insumos</h4></div><div class="panel-body"><div class="dataTable_wrapper table-responsive">';
            var tablaInsumos = [];
            if ( res.labores[j].insumos.length === 0 ){
                  tablaInsumos[k] = [
                                    listaLabores += '<div id="alertaVacio" class="col-md-12"><div class="alert alert-danger " role="alert"> <h4>Aun no se han agregado Insumos.</h4></div></div>',
                              ];
                } 
            else { 
            listaLabores +='<table class="table table-striped table-bordered table-hover" id="tabla_insumos"><thead><tr><th>Insumo</th><th>Comentario</th><th>Fecha</th></tr></thead><tbody id="body">';          
              for( var k=0; k < res.labores[j].insumos.length; k++){
                tablaInsumos[k] = [
                                    listaLabores += '<tr>',
                                    listaLabores += '<td>'+ res.labores[j].insumos[k].nInsumo +'</td>',
                                    listaLabores += '<td>'+ res.labores[j].insumos[k].comentario +'</td>',
                                    listaLabores += '<td>'+ res.labores[j].insumos[k].fecha +'</td>',
                                    listaLabores += '</tr>',
                              ];
              }
              listaLabores += '</tbody></table>';
            }
            listaLabores += '</div><!-- /.table-responsive --></div><!-- /.panel-body --></div></div>';
            listaLabores += '<div class="col-md-12"><div class="panel panel-info"><div class="panel-heading"><h4>Gastos</h4></div><div class="panel-body"><div class="dataTable_wrapper table-responsive">';
            var tablaGastos = [];
            if ( res.labores[j].gastos.length === 0 ){
                  tablaGastos[g] = [
                                    listaLabores += '<div id="alertaVacio" class="col-md-12"><div class="alert alert-info " role="alert"> <h4>Aun no se han registrado Gastos.</h4></div></div>',
                              ];
                }
            else { 
              listaLabores +='<table class="table table-striped table-bordered table-hover" id="tabla_gastos"><thead><tr><th>Gasto</th><th>Valor</th><th>Comentario</th><th>Fecha</th></tr></thead><tbody id="body">';  
              for( var g=0; g < res.labores[j].gastos.length; g++){
                  tablaGastos[g] = [
                                    listaLabores += '<tr>',
                                    listaLabores += '<td>'+ res.labores[j].gastos[g].nGasto +'</td>',
                                    listaLabores += '<td>'+ formatNumber.new(parseInt(res.labores[j].gastos[g].valor), "$") +'</td>',
                                    listaLabores += '<td>'+ res.labores[j].gastos[g].comentario +'</td>',
                                    listaLabores += '<td>'+ res.labores[j].gastos[g].fecha +'</td>',
                                    listaLabores += '</tr>',
                                ];
              }
              listaLabores +='</tbody></table>';
            }
            listaLabores += '</div><!-- /.table-responsive --></div><!-- /.panel-body --></div></div>';
            listaLabores += '<div class="col-md-12"><div class="panel panel-success"><div class="panel-heading"> <h4>Novedades</h4></div><div class="panel-body"><div class="dataTable_wrapper table-responsive">';
            var tablaNovedades = [];
            if ( res.labores[j].novedades.length === 0 ){
                  tablaNovedades[n] = [
                                    listaLabores += '<div id="alertaVacio" class="col-md-12"><div class="alert alert-success " role="alert"> <h4>Aun no se han registrado Novedades.</h4></div></div>',
                              ];
                }  
            else { 
            listaLabores +='<table class="table table-striped table-bordered table-hover" id="tabla_novedades"><thead><tr><th>Novedad</th><th>Fecha</th></tr></thead><tbody id="body">';          
              for( var n=0; n < res.labores[j].novedades.length; n++){
                tablaNovedades[n] = [
                                listaLabores += '<tr>',
                                listaLabores += '<td>'+ res.labores[j].novedades[n].comentario +'</td>',
                                listaLabores += '<td>'+ res.labores[j].novedades[n].fecha +'</td>',
                                listaLabores += '</tr>',
                              ];
              }
              listaLabores +='</tbody></table>';
            }
            listaLabores += '</div><!-- /.table-responsive --></div><!-- /.panel-body --></div></div></div>';
            listaLabores += '</div></div></div><!-- end panel-->';
            $(document).ready(function(){
                $(".tg"+idSeguimiento).click(function () {
                    $("#collapse"+idSeguimiento).toggleClass("in");
                });
            });
          }
        $('#idSeguimiento').html(idSeguimiento);
        var hectareas = $('#areaActual').html().replace(/\,/g, '.');
        var costos = res.costos_totales; 
        //console.log( costos +"/"+ hectareas);
        var totalCD = costos / hectareas;
        $('#costosDirectos').html(formatNumber.new(parseInt(totalCD), "$"));
        var totalCI = totalCosInd;
        $('#costosTotales').html(formatNumber.new(parseInt(totalCD + totalCI), "$"));
        $('#datosCorteAnterior').show();
        $('#datosCorteAnterior').html(listaLabores);
      }
    }
  });
}