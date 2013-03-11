(function() {
  var actualizarEventos, clearOverlays, createMarker, deleteOverlays, inicializar, noGeolocalizacion, setAllMap, showOverlays;

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
    window.eventCategory = [];
    window.eventInterval = 1;
    opciones = {
      zoom: 13,
      center: window.santafe,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    window.map = new google.maps.Map(document.getElementById("map"), opciones);
    window.markers = [];
    /*
    	Eventos
    	Aquí se registran los eventos para los objetos de la vista
    */
    inicializar();
    $('#eventInterval > button').on('click', function() {
      window.eventInterval = $(this).val();
      deleteOverlays();
      return actualizarEventos();
    });
    $('#eventCategories').find('input[id*="Category"]').on('click', function() {
      var category, _i, _len, _ref;
      window.eventCategory = [];
      _ref = $('#eventCategories').find('input:checked');
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        category = _ref[_i];
        window.eventCategory.push($(category).val());
      }
      deleteOverlays();
      return actualizarEventos();
    });
    return google.maps.event.addListener(window.map, 'bounds_changed', function() {
      return actualizarEventos();
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

  actualizarEventos = function() {
    var bounds, ne, options, sw;
    bounds = window.map.getBounds();
    ne = bounds.getNorthEast();
    sw = bounds.getSouthWest();
    options = {
      "eventCategory": window.eventCategory,
      "eventInterval": window.eventInterval,
      "neLat": ne.lat(),
      "neLong": ne.lng(),
      "swLat": sw.lat(),
      "swLong": sw.lng()
    };
    return $.getJSON(WEBROOT + 'events/get', options, function(data) {
      var event, exist, marker, _i, _j, _len, _len2, _ref, _results;
      _results = [];
      for (_i = 0, _len = data.length; _i < _len; _i++) {
        event = data[_i];
        _ref = window.markers;
        for (_j = 0, _len2 = _ref.length; _j < _len2; _j++) {
          marker = _ref[_j];
          if (marker.eventId === event.Event.id) exist = true;
        }
        if (!exist) {
          _results.push(createMarker(event.Event.id, event.Event.title, new google.maps.LatLng(event.Event.lat, event.Event.long)));
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    });
  };

  createMarker = function(eventId, eventTitle, latlng) {
    var marker;
    marker = new google.maps.Marker({
      eventId: eventId,
      title: eventTitle,
      position: latlng,
      map: window.map,
      zIndex: Math.round(latlng.lat() * -100000) << 5
    });
    return window.markers.push(marker);
  };

  setAllMap = function(map) {
    var marker, _i, _len, _ref, _results;
    _ref = window.markers;
    _results = [];
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      marker = _ref[_i];
      _results.push(marker.setMap(map));
    }
    return _results;
  };

  clearOverlays = function() {
    return setAllMap(null);
  };

  showOverlays = function() {
    return setAllMap(map);
  };

  deleteOverlays = function() {
    clearOverlays();
    return window.markers = [];
  };

}).call(this);
