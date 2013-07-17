(function() {
  'use strict';
  var RadarApp;

  RadarApp = angular.module('RadarApp', ['fechaFilters']);

  RadarApp.directive('loading', [
    '$rootScope', function($rootScope) {
      return {
        link: function(scope, element, attrs) {
          element.addClass('hide');
          $rootScope.$on('$routeChangeStart', function() {
            return element.removeClass('hide');
          });
          return $rootScope.$on('$routeChangeSuccess', function() {
            return element.addClass('hide');
          });
        }
      };
    }
  ]);

  RadarApp.directive('loaded', [
    '$rootScope', function($rootScope) {
      return {
        link: function(scope, element, attrs) {
          $rootScope.$on('$routeChangeStart', function() {
            return element.addClass('hide');
          });
          return $rootScope.$on('$routeChangeSuccess', function() {
            return element.removeClass('hide');
          });
        }
      };
    }
  ]);

  /* *******************************************************************************************************************
  								CATEGORIAS
  *******************************************************************************************************************
  */


  RadarApp.controller('CategoriaController', function($scope) {
    return $scope.show = function(categoria) {
      categoria.highlight = !categoria.highlight;
      if (categoria.highlight) {
        return $scope.eventCategory.push(categoria.Category.id);
      } else {
        return $scope.eventCategory.splice($scope.eventCategory.indexOf(categoria.Category.id), 1);
      }
    };
  });

  /* *******************************************************************************************************************
  								EVENTOS
  *******************************************************************************************************************
  */


  RadarApp.controller('EventoController', function($scope, $http) {
    /* ***************************************************************************************************************
    			Inicialización de Objetos
    	***************************************************************************************************************
    */

    $scope.capital = new google.maps.LatLng(-34.603, -58.382);
    $scope.santafe = new google.maps.LatLng(-31.625906, -60.696774);
    $scope.eventCategory = [];
    $scope.eventInterval = 1;
    $scope.opciones = {
      zoom: 13,
      center: window.santafe,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    $scope.map = new google.maps.Map(document.getElementById("map"), $scope.opciones);
    $scope.markers = [];
    /* ***************************************************************************************************************
    			Eventos
    			Aquí se registran los eventos para los objetos de la vista
    	***************************************************************************************************************
    */

    $scope.$watch('eventCategory.length', function() {
      return $scope.actualizarEventos();
    });
    $scope.$watch('eventInterval', function() {
      return $scope.actualizarEventos();
    });
    $scope.$watch('eventos.length', function() {
      $scope.deleteOverlays();
      angular.forEach($scope.eventos, function(event, key) {
        var latlng;
        latlng = new google.maps.LatLng(event.Event.lat, event.Event.long);
        return $scope.createMarker(event.Event.id, event.Event.title, latlng);
      });
      return $scope.showOverlays();
    });
    google.maps.event.addListener($scope.map, 'dragend', function() {
      return $scope.actualizarEventos();
    });
    google.maps.event.addListener($scope.map, 'tilesloaded', function() {
      return $scope.actualizarEventos();
    });
    google.maps.event.addListener($scope.map, 'zoom_changed', function() {
      return $scope.actualizarEventos();
    });
    /* *************************************************************************************************************** 
    			Funciones
    			Aquí se escriben las funciones
    	***************************************************************************************************************
    */

    $scope.actualizarEventos = function() {
      var bounds, ne, options, sw;
      if ($scope.map.getBounds() != null) {
        bounds = $scope.map.getBounds();
        ne = bounds.getNorthEast();
        sw = bounds.getSouthWest();
        options = {
          "eventCategory": $scope.eventCategory,
          "eventInterval": $scope.eventInterval,
          "neLat": ne.lat(),
          "neLong": ne.lng(),
          "swLat": sw.lat(),
          "swLong": sw.lng()
        };
        return $http.get('/events/get', {
          cache: true,
          params: options
        }).success(function(data) {
          return $scope.eventos = data;
        });
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
          return $scope.setDefaultLocation();
        });
      }
    };
    $scope.createMarker = function(eventId, eventTitle, latlng) {
      var marker;
      marker = new google.maps.Marker({
        eventId: eventId,
        title: eventTitle,
        position: latlng,
        map: $scope.map,
        zIndex: Math.round(latlng.lat() * -100000) << 5
      });
      return $scope.markers.push(marker);
    };
    $scope.clearOverlays = function() {
      return $scope.setAllMap(null);
    };
    $scope.deleteOverlays = function() {
      $scope.clearOverlays();
      return $scope.markers = [];
    };
    $scope.setDefaultLocation = function() {
      var initialLocation;
      initialLocation = $scope.santafe;
      $scope.map.setCenter(initialLocation);
      if (window.browserSupportFlag === true) {
        return console.log("El servicio de geolocalización falló. Iniciamos desde Santa Fe.");
      } else {
        return console.log("Tu navegador no soporta geolocalización. Iniciamos desde Santa Fe.");
      }
    };
    $scope.setAllMap = function(map) {
      var marker, _i, _len, _ref, _results;
      _ref = $scope.markers;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        marker = _ref[_i];
        _results.push(marker.setMap(map));
      }
      return _results;
    };
    $scope.setEventInterval = function(interval) {
      return $scope.eventInterval = interval;
    };
    $scope.showOverlays = function() {
      return $scope.setAllMap($scope.map);
    };
    return $scope.setDefaultLocation();
  });

}).call(this);
