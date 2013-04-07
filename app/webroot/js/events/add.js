(function() {
  var categoriesCheckedCount, createMarker, inicializar, noGeolocalizacion, showAlertMessage;

  jQuery(function() {
    /*
    	Variables Globales
    */
    var categoriesCheckbox, diaEnMilisegundos, oldTime, opciones;
    diaEnMilisegundos = 24 * 60 * 60 * 1000;
    window.alertMessageDisplayed = false;
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
    google.maps.event.addListener(window.map, 'click', function(event) {
      $('#EventLat').val(event.latLng.lat());
      $('#EventLong').val(event.latLng.lng());
      if (window.marker) {
        window.marker.setMap(null);
        window.marker = null;
      }
      return window.marker = createMarker(event.latLng);
    });
    /*
    		date pickers
    */
    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $("#from").datepicker({
      defaultDate: null,
      changeMonth: true,
      minDate: "0d",
      onClose: function(selectedDate) {
        var maxDay;
        $("#to").datepicker("option", "minDate", selectedDate);
        maxDay = new Date($("#from").datepicker("getDate").getTime() + (3 * diaEnMilisegundos));
        return $("#to").datepicker("option", "maxDate", maxDay);
      }
    });
    $("#to").datepicker({
      defaultDate: null,
      changeMonth: true
    });
    /*
    	 time pickers
    */
    $("#time3, #time4").timePicker();
    oldTime = $.timePicker("#time3").getTime();
    $("#time3").on('change', function() {
      var duration, time;
      if ($("#time4").val()) {
        duration = $.timePicker("#time4").getTime() - oldTime;
        time = $.timePicker("#time3").getTime();
        $.timePicker("#time4").setTime(new Date(new Date(time.getTime() + duration)));
        return oldTime = time;
      }
    });
    $("#time3, #time4").on('blur', function() {
      var time;
      time = $.timePicker(this).getTime();
      return $.timePicker(this).setTime(new Date(new Date(time.getTime())));
    });
    $("#time4").on('change', function() {
      if ($.timePicker("#time3").getTime() > $.timePicker(this).getTime()) {
        return $(this).parent().addClass("error");
      } else {
        return $(this).parent().removeClass("error");
      }
    });
    /*
    		Categories
    */
    categoriesCheckbox = $('#categoriesSelect').find('input[type="checkbox"]');
    return $(categoriesCheckbox).on('click', function(event) {
      if (categoriesCheckedCount() > 3) {
        event.preventDefault();
        showAlertMessage();
        return false;
      }
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

  categoriesCheckedCount = function() {
    return $('#categoriesSelect').find('input:checked').length;
  };

  showAlertMessage = function() {
    if (window.alertMessageDisplayed === false) {
      window.alertMessageDisplayed = true;
      return $('#alertMessage').fadeIn('slow').delay(5000).fadeOut('slow', function() {
        return window.alertMessageDisplayed = false;
      });
    }
  };

}).call(this);
