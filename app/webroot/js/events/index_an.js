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


  RadarApp.controller('EventoController', function($scope, $http, $timeout) {
    /* ***************************************************************************************************************
    			Inicialización de Objetos
    	***************************************************************************************************************
    */

    $scope.eventCategory = [];
    $scope.eventInterval = 1;
    $scope.capital = new google.maps.LatLng(-34.603, -58.382);
    $scope.cordoba = new google.maps.LatLng(-31.388813, -64.179726);
    $scope.santafe = new google.maps.LatLng(-31.625906, -60.696774);
    $scope.cordobaSantafe = new google.maps.LatLng(-31.52081, -62.411469);
    $scope.locationDefault = $scope.cordobaSantafe;
    $scope.zoomDefault = 8;
    $scope.zoomSantafe = 12;
    $scope.zoomCordoba = 11;
    $scope.zoomCity = 12;
    $scope.opciones = {
      zoom: $scope.zoomDefault,
      center: $scope.locationDefault,
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
      return $scope.eventsUpdate();
    });
    $scope.$watch('eventInterval', function() {
      return $scope.eventsUpdate();
    });
    $scope.$watch('eventos', function() {
      $scope.deleteOverlays();
      angular.forEach($scope.eventos, function(event, key) {
        var latlng;
        latlng = new google.maps.LatLng(event.Event.lat, event.Event.long);
        return $scope.createMarker(event.Event.id, event.Event.title, latlng);
      });
      return $scope.showOverlays();
    }, true);
    google.maps.event.addListener($scope.map, 'dragend', function() {
      return $scope.eventsUpdate();
    });
    google.maps.event.addListener($scope.map, 'tilesloaded', function() {
      return $scope.eventsUpdate();
    });
    google.maps.event.addListener($scope.map, 'zoom_changed', function() {
      return $scope.eventsUpdate();
    });
    /* *************************************************************************************************************** 
    			Funciones
    			Aquí se escriben las funciones
    	***************************************************************************************************************
    */

    $scope.eventsUpdate = function() {
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
    $scope.centerMap = function(city) {
      var location;
      $scope.map.setZoom($scope.zoomDefault);
      switch (city) {
        case 'cordoba':
          location = $scope.cordoba;
          $scope.map.setZoom($scope.zoomCordoba);
          break;
        case 'santafe':
          location = $scope.santafe;
          $scope.map.setZoom($scope.zoomSantafe);
          break;
        default:
          location = $scope.locationDefault;
      }
      $scope.map.setCenter(location);
      return $scope.eventsUpdate();
    };
    $scope.inicializar = function() {
      if (navigator.geolocation) {
        window.browserSupportFlag = true;
        return navigator.geolocation.getCurrentPosition(function(position) {
          var initialLocation;
          initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
          return $scope.map.setCenter(initialLocation);
        }, function() {
          return $scope.setLocationDefault();
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
    $scope.setLocation = function() {
      $scope.map.setZoom(14);
      if (navigator.geolocation) {
        window.browserSupportFlag = true;
        return navigator.geolocation.getCurrentPosition(function(position) {
          var location;
          location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
          $scope.map.setCenter(location);
          return $scope.eventsUpdate();
        }, function() {
          $scope.errorLocation = 'Debes autorizar la captura de tu ubicación';
          $scope.setLocationDefault();
          return $timeout(function() {
            return $scope.errorLocation = null;
          }, 2000);
        });
      } else {
        return $scope.errorLocation = 'Esta función no está soportada por tu navegador';
      }
    };
    $scope.setLocationDefault = function() {
      $scope.map.setZoom($scope.zoomDefault);
      $scope.map.setCenter($scope.locationDefault);
      return $scope.eventsUpdate();
    };
    $scope.showOverlays = function() {
      return $scope.setAllMap($scope.map);
    };
    return $scope.setLocationDefault();
  });

}).call(this);
