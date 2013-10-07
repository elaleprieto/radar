(function() {
  'use strict';
  var RadarApp;

  RadarApp = angular.module('RadarApp', ['$strap.directives']);

  RadarApp.value('$strapConfig', {
    datepicker: {
      language: 'es'
    }
  });

  /* *******************************************************************************************************************
  								CATEGORIAS
  *******************************************************************************************************************
  */


  RadarApp.controller('CategoriaController', function($scope, $http) {
    $http.get('/categories ', {
      cache: true
    }).success(function(data) {
      return $scope.categorias = data;
    });
    return $scope.show = function(category) {
      if (!category.highlight) {
        return $scope.$parent.eventCategoriesAdd(category);
      } else {
        return $scope.$parent.eventCategoriesDelete(category);
      }
    };
  });

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
    $scope.ROADMAP = google.maps.MapTypeId.ROADMAP;
    $scope.SATELLITE = google.maps.MapTypeId.SATELLITE;
    $scope.opciones = {
      center: $scope.argentina,
      mapTypeId: $scope.ROADMAP,
      panControl: false,
      zoomControl: false,
      mapTypeControl: false,
      scaleControl: false,
      streetViewControl: false,
      overviewMapControl: false,
      zoom: 5
    };
    $scope.map = new google.maps.Map(document.getElementById("map"), $scope.opciones);
    $scope.event.categories = [];
    $scope.geocoder = new google.maps.Geocoder();
    $scope.eventCategoriesAdd = function(category) {
      if ($scope.event.categories.length < 3) {
        $scope.event.categories.push(category.Category.id);
        return category.highlight = true;
      }
    };
    $scope.eventCategoriesDelete = function(category) {
      var index;
      index = $scope.event.categories.indexOf(category.Category.id);
      if (index >= 0) {
        $scope.event.categories.splice(index, 1);
        return category.highlight = false;
      }
    };
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
    $scope.submit = function() {
      $scope.cargando = 'Cargando.';
      if (!$scope.eventForm.$valid) {
        $scope.cargando = null;
        return this;
      }
      $scope.cargando = 'Cargando..';
      if ($scope.event.categories.length <= 0) {
        $scope.cargando = 'Error: Debe seleccionar al menos una categoría';
        return console.error('Error: Debe seleccionar al menos una categoría');
      }
      $scope.cargando = 'Cargando...';
      return $http.post('/events/add', {
        Event: $scope.event,
        Category: $scope.event.categories
      }).success(function(data) {
        $scope.cargando = '¡Evento guardado!';
        console.log('Evento guardado');
        return window.location.pathname = 'events';
      }).error(function() {
        $scope.cargando = 'Ocurrió un error guardando el evento';
        return console.log('Ocurrió un error guardando el evento');
      });
    };
    $scope.addAddressToMap = function(response, status) {
      var icon;
      if (!response || response.length === 0) {
        return this;
      }
      $scope.event.lat = response[0].geometry.location.lat();
      $scope.event.long = response[0].geometry.location.lng();
      $scope.map.setCenter(response[0].geometry.location);
      $scope.map.setZoom(13);
      icon = new google.maps.MarkerImage("http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png", new google.maps.Size(20, 34), new google.maps.Point(0, 0), new google.maps.Point(10, 34));
      if ($scope.marker != null) {
        $scope.marker.setMap(null);
      }
      $scope.marker = new google.maps.Marker({
        'position': response[0].geometry.location,
        'map': $scope.map,
        'icon': icon
      });
      return $scope.marker.setMap($scope.map);
    };
    $scope.setAddress = function() {
      var request;
      request = new Object();
      request.address = $scope.event.address;
      request.region = 'AR';
      return $scope.geocoder.geocode(request, $scope.addAddressToMap);
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
