(function() {
  var createMarker, inicializar, noGeolocalizacion;

  jQuery(function() {
    /*
    	Variables Globales
    */
    var opciones;
    window.capital = new google.maps.LatLng(-34.603, -58.382);
    window.santafe = new google.maps.LatLng(-31.625906, -60.696774);
    /*
    	Inicialización de Objetos
    */
    opciones = {
      zoom: 13,
      center: window.santafe,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    window.map = new google.maps.Map(document.getElementById("map"), opciones);
    /*
    	Eventos
    	Aquí se registran los eventos para los objetos de la vista
    */
    inicializar();
    return google.maps.event.addListener(window.map, 'click', function(event) {
      console.info("Latitude: " + event.latLng.lat() + " " + ", longitude: " + event.latLng.lng());
      $('#EventLat').val(event.latLng.lat());
      $('#EventLong').val(event.latLng.lng());
      if (window.marker) {
        window.marker.setMap(null);
        window.marker = null;
      }
      return window.marker = createMarker(event.latLng);
    });
  });

  /*
  Funciones
  Aquí se escriben las funciones
  */

  inicializar = function() {
    if (navigator.geolocation) {
      window.browserSupportFlag = true;
      return navigator.geolocation.getCurrentPosition(function(position) {
        var initialLocation;
        initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        return window.map.setCenter(initialLocation);
      }, function() {
        return noGeolocalizacion();
      });
    }
  };

  noGeolocalizacion = function() {
    var initialLocation;
    initialLocation = window.santafe;
    window.map.setCenter(initialLocation);
    if (window.browserSupportFlag === true) {
      return alert("El servicio de geolocalización falló. Iniciamos desde Santa Fe.");
    } else {
      return alert("Tu navegador no soporta geolocalización. Iniciamos desde Santa Fe.");
    }
  };

  createMarker = function(latlng) {
    var marker;
    return marker = new google.maps.Marker({
      position: latlng,
      map: window.map,
      zIndex: Math.round(latlng.lat() * -100000) << 5
    });
  };

}).call(this);
