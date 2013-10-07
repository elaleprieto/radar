(function() {
  'use strict';
  /* *******************************************************************************************************************
  								CATEGORIAS
  *******************************************************************************************************************
  */

  /* *******************************************************************************************************************
  								EVENTOS
  *******************************************************************************************************************
  */

  RadarApp.controller('EventController', function($scope, $http) {
    var date;
    date = new Date();
    $scope.minutoEnMilisegundos = 60 * 1000;
    $scope.diaEnMilisegundos = 24 * 60 * $scope.minutoEnMilisegundos;
    $scope.event = {};
    $scope.santafe = new google.maps.LatLng(-31.625906, -60.696774);
    $scope.argentina = new google.maps.LatLng(-31.659226, -60.485229);
    $scope.zoomCity = 5;
    $scope.opciones = {
      zoom: $scope.zoomCity,
      center: $scope.argentina,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    $scope.map = new google.maps.Map(document.getElementById("map"), $scope.opciones);
    $scope.event.categories = [];
    $scope.geocoder = new google.maps.Geocoder();
    $scope.inicializar = function() {
      if (navigator.geolocation) {
        window.browserSupportFlag = true;
        return navigator.geolocation.getCurrentPosition(function(position) {
          var initialLocation;
          initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
          return $scope.map.setCenter(initialLocation);
        }, function() {
          return $scope.noGeolocalizacion();
        });
      }
    };
    $scope.noGeolocalizacion = function() {
      var initialLocation;
      initialLocation = $scope.santafe;
      $scope.map.setCenter(initialLocation);
      if (window.browserSupportFlag === true) {
        return console.log("El servicio de geolocalización falló. Iniciamos desde Santa Fe.");
      } else {
        return console.log("Tu navegador no soporta geolocalización. Iniciamos desde Santa Fe.");
      }
    };
    $scope.centerMapByUserLocation = function(response, status) {
      if ((response[0] != null) && (response[0].geometry != null) && (response[0].geometry.location != null)) {
        $scope.map.setCenter(response[0].geometry.location);
        return $scope.map.setZoom($scope.zoomCity);
      }
    };
    $scope.setAddress = function() {
      var request;
      request = new Object();
      request.address = $scope.event.address;
      request.region = 'AR';
      return $scope.geocoder.geocode(request, $scope.addAddressToMap);
    };
    $scope.setLocationByUserLocation = function(location) {
      var request;
      request = new Object();
      request.address = location;
      return $scope.geocoder.geocode(request, $scope.centerMapByUserLocation);
    };
    $scope.$watch('event.date_from', function(newValue) {
      if (newValue != null) {
        $('#date_to').datepicker('setDate', newValue);
        $('#date_to').datepicker('setStartDate', newValue);
        $('#date_to').datepicker('setEndDate', new Date(newValue.getTime() + (3 * $scope.diaEnMilisegundos)));
        return $scope.event.date_to = newValue;
      }
    });
    $scope.$watch('event.time_from', function(newValue) {
      if (newValue != null) {
        return $scope.checkTimeTo();
      }
    });
    $scope.$watch('event.time_to', function(newValue) {
      if (newValue != null) {
        return $scope.checkTimeTo();
      }
    });
    $scope.$watch('user.location', function(location) {
      if ((location != null) && location.length > 0) {
        return $scope.setLocationByUserLocation(location);
      }
    });
    return $scope.checkTimeTo = function() {
      var dateEnd, dateEndAux, dateFrom, dateStart, dateTo, timeFrom, timeTo;
      if ($scope.event.time_from != null) {
        if ($scope.event.date_from === $scope.event.date_to) {
          dateFrom = $scope.event.date_from;
          dateTo = $scope.event.date_to;
          timeFrom = $scope.event.time_from.split(':');
          dateStart = new Date(dateFrom.getFullYear(), dateFrom.getMonth(), dateFrom.getDate(), timeFrom[0], timeFrom[1]);
          dateEnd = new Date(dateStart.getTime() + (15 * $scope.minutoEnMilisegundos));
          if ($scope.event.time_to == null) {
            return $scope.event.time_to = dateEnd.getHours() + ':' + dateEnd.getMinutes();
          } else {
            timeTo = $scope.event.time_to.split(':');
            dateEndAux = new Date(dateTo.getFullYear(), dateTo.getMonth(), dateTo.getDate(), timeTo[0], timeTo[1]);
            if (dateEnd.getTime() > dateEndAux.getTime()) {
              $scope.event.time_to = dateEnd.getHours() + ':' + dateEnd.getMinutes();
              if (dateEnd.getMinutes() === 0) {
                return $scope.event.time_to += '0';
              }
            }
          }
        }
      }
    };
    /*
    	 time pickers
    */

  });

}).call(this);
