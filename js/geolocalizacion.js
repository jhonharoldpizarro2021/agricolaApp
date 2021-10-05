/* VARIABLE GLOBALES */
var map;
var geo = [];
var idSuerte;
/* MUESTRA EL MAPA DE LA SUERTE */
function geolocalizacion(suerte){
  idSuerte = suerte;
  $("#content_mapa").show();
  $("#content_mapa").css('height','300px').css('width','100%');

  map = new google.maps.Map(document.getElementById('content_mapa'), {
          zoom                : 10,
          center              : { lat: 3.7403600, lng: -76.3871878 },
          zoomControl         : true,

          mapTypeId: google.maps.MapTypeId.SATELLITE
        });

  $.ajax({
    cache:false,
    dataType:"json",
    type:"POST",
    url: "./querys/q_geolocalizacion.php",
    data: {
            opcion:1,
            suerte:suerte
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
        console.log("Error:"+ res.msg);
      }
      else if(res.estado === "OK")
      {
        //Define the LatLng coordinates for the polygon.
        geo = [];
        for( var i=0; i < res.geolocalizacion.length; i++)
        {
          var lat = parseFloat(res.geolocalizacion[i].lat);
          var lng = parseFloat(res.geolocalizacion[i].lng);
          var latitud = lat;
          var longitud = lng;
          geo[i] = { lat: latitud, lng: longitud };
        }
        // Construct the polygon.
        var suertePoligono = new google.maps.Polygon({
          paths: geo,
          strokeColor: '#FF0000',
          strokeOpacity: 0.8,
          strokeWeight: 3,
          fillColor: '#FF0000',
          fillOpacity: 0.35
        });
        suertePoligono.setMap(map);
        var punto_medio = parseInt(res.geolocalizacion.length / 2); //Punto medio para centrar el mapa
        var center = new google.maps.LatLng(parseFloat(res.geolocalizacion[punto_medio].lat), parseFloat(res.geolocalizacion[punto_medio].lng));
       
        map.setZoom(15);
        //$(".mapa").css('height','00px').css('width','100%');
        
        $("#mygeolocalizacion").on("shown.bs.modal", function () {
            google.maps.event.trigger(map, "resize");
            map.panTo(center);
        });


        /*$('#mygeolocalizacion').on('shown.bs.modal', function() {
          var currentCenter = map.getCenter();  // Get current center before resizing
          google.maps.event.trigger(map, "resize");
          map.setCenter(currentCenter); // Re-set previous center
        });*/



        $("#mygeolocalizacion").modal('show');
        //$('#point').html('<a id="point" href="javascript:ocultar()" aria-hidden="true"> Ocultar Mapa <i class="fa fa-map-marker" aria-hidden="true"></i></a>');
      }
    }
  });
}
function ocultar(){
        $('#point').html('<a id="point" href="javascript:geolocalizacion(\''+ idSuerte +'\')" aria-hidden="true"> Ver Mapa <i class="fa fa-map-marker" aria-hidden="true"></i></a>');
        $("#content_mapa").hide();
        $("#content_mapa").html('');
      }
//Document Ready Funtions //
$(document).ready(function(){






});//end Document Ready Funtions
