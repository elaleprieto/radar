/* *******************************************************************************************************************
								EVENTOS
*******************************************************************************************************************
*/


(function() {
  angular.module('RadarApp').controller('EventsController', [
    '$http', '$location', '$scope', '$timeout', '$compile', 'Event', 'EventView', function($http, $location, $scope, $timeout, $compile, Event, EventView) {
      /* ***************************************************************************************************************
      			Inicialización de Objetos
      	***************************************************************************************************************
      */

      var date, findResult, getEventCategoryIcon, getEventDescription, getEventId, getEventTitle, setUserLocationString, userLastLocationString, userMapCenter, userMapTypeId, userMapZoom;
      $scope.eventInterval = 1;
      $scope.user = {};
      $scope.categoriesSelected = [];
      date = new Date();
      $scope.minutoEnMilisegundos = 60 * 1000;
      $scope.diaEnMilisegundos = 24 * 60 * $scope.minutoEnMilisegundos;
      $scope.event = {};
      $scope.event.categories = [];
      $scope.capital = new google.maps.LatLng(-34.603, -58.382);
      $scope.cordoba = new google.maps.LatLng(-31.388813, -64.179726);
      $scope.santafe = new google.maps.LatLng(-31.625906, -60.696774);
      $scope.cordobaSantafe = new google.maps.LatLng(-31.52081, -62.411469);
      $scope.locationDefault = $scope.cordobaSantafe;
      $scope.zoomDefault = 8;
      $scope.zoomSantafe = 12;
      $scope.zoomCordoba = 11;
      $scope.zoomCity = 15;
      $scope.ROADMAP = google.maps.MapTypeId.ROADMAP;
      $scope.SATELLITE = google.maps.MapTypeId.SATELLITE;
      $scope.opciones = {
        center: $scope.locationAux,
        mapTypeId: $scope.ROADMAP,
        panControl: false,
        zoomControl: false,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        overviewMapControl: false,
        zoom: $scope.zoomDefault
      };
      if ($.cookie != null) {
        $.cookie.json = true;
        userMapCenter = $.cookie('userMapCenter');
        userMapTypeId = $.cookie('userMapTypeId');
        userMapZoom = $.cookie('userMapZoom');
        userLastLocationString = $.cookie('userLastLocationString');
        if (userMapCenter != null) {
          $scope.opciones.center = new google.maps.LatLng(userMapCenter.lat, userMapCenter.lng);
        }
        if (userMapTypeId != null) {
          $scope.opciones.mapTypeId = userMapTypeId;
        }
        if (userMapZoom != null) {
          $scope.opciones.zoom = userMapZoom;
        }
        if (userLastLocationString != null) {
          $scope.user.location = userLastLocationString;
        }
        $timeout(function() {
          return $scope.setUserLocationByLatLng($scope.opciones.center);
        }, 50);
      }
      $scope.map = new google.maps.Map(document.getElementById("map"), $scope.opciones);
      $scope.markers = [];
      $scope.geocoder = new google.maps.Geocoder();
      /* ***************************************************************************************************************
      			Eventos
      			Aquí se registran los eventos para los objetos de la vista
      	***************************************************************************************************************
      */

      $scope.$watch('categoriesSelected.length', function() {
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
          return $scope.createMarker(event, latlng);
        });
        return $scope.showOverlays();
      }, true);
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
      $scope.$watch('user.locationAux', function(location) {
        if ((userMapCenter == null) && (location != null) && location.length > 0) {
          return $scope.setLocationByUserLocation(location);
        }
      });
      google.maps.event.addListener($scope.map, 'dragend', function() {
        $scope.eventsUpdate();
        return $scope.saveUserMapCenter();
      });
      google.maps.event.addListener($scope.map, 'tilesloaded', function() {
        return $scope.eventsUpdate();
      });
      google.maps.event.addListener($scope.map, 'zoom_changed', function() {
        $scope.eventsUpdate();
        return $scope.saveUserMapZoom();
      });
      google.maps.event.addListener($scope.map, 'position_changed', function() {
        return $scope.eventsUpdate();
      });
      /* *************************************************************************************************************** 
      			Funciones
      			Aquí se escriben las funciones
      	***************************************************************************************************************
      */

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
        $scope.eventsUpdate();
        $scope.saveUserMapCenter();
        return $scope.saveUserMapZoom();
      };
      $scope.centerMapByUserLocation = function(response, status) {
        if ((response[0] != null) && (response[0].geometry != null) && (response[0].geometry.location != null)) {
          $scope.map.setCenter(response[0].geometry.location);
          $scope.map.setZoom($scope.zoomCity);
          $scope.saveUserMapCenter();
          return setUserLocationString(response[0]);
        }
      };
      $scope.createMarker = function(event, latlng) {
        var contenido, icon, infowindow, marker;
        icon = new google.maps.MarkerImage('/img/map-marker/' + getEventCategoryIcon(event), new google.maps.Size(25, 26), new google.maps.Point(0, 0), new google.maps.Point(10, 34));
        marker = new google.maps.Marker({
          eventId: getEventId(event),
          map: $scope.map,
          icon: icon,
          position: latlng,
          title: getEventTitle(event),
          zIndex: Math.round(latlng.lat() * -100000) << 5
        });
        contenido = '<div>';
        contenido += '<p>' + getEventTitle(event) + '</p>';
        contenido += '<a ng-click="openModal(\'events/view/' + getEventId(event) + '\')">';
        contenido += '<p class="text-right"><i class="icon-expand-alt"></i> info</p>';
        contenido += '</a>';
        contenido += '</div>';
        contenido = $compile(contenido)($scope);
        infowindow = new google.maps.InfoWindow({
          content: contenido[0]
        });
        google.maps.event.addListener(marker, 'click', function() {
          return infowindow.open($scope.map, marker);
        });
        return $scope.markers.push(marker);
      };
      $scope.checkTimeTo = function() {
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
      $scope.clearOverlays = function() {
        return $scope.setAllMap(null);
      };
      $scope.deleteOverlays = function() {
        $scope.clearOverlays();
        return $scope.markers = [];
      };
      $scope.categoriesAdd = function(category) {
        if ($scope.event.categories.length < 3) {
          $scope.event.categories.push(category.Category.id);
          return category.highlight = true;
        }
      };
      $scope.categoriesDelete = function(category) {
        var index;
        index = $scope.event.categories.indexOf(category.Category.id);
        if (index >= 0) {
          $scope.event.categories.splice(index, 1);
          return category.highlight = false;
        }
      };
      $scope.eventsUpdate = function() {
        var bounds, ne, options, sw;
        if ($scope.map.getBounds() != null) {
          bounds = $scope.map.getBounds();
          ne = bounds.getNorthEast();
          sw = bounds.getSouthWest();
          options = {
            "categoriesSelected": $scope.categoriesSelected,
            "eventInterval": $scope.eventInterval,
            "neLat": ne.lat(),
            "neLong": ne.lng(),
            "swLat": sw.lat(),
            "swLong": sw.lng()
          };
          console.log(options);
          return Event.get({
            params: options
          }, function(response) {
            return $scope.eventos = response.events;
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
            return $scope.setLocationDefault();
          });
        }
      };
      $scope.resetView = function(event) {
        console.log($('ng-view').innerHtml);
        return $location.path('/');
      };
      $scope.saveUserLocationString = function() {
        $.cookie.json = true;
        return $.cookie("userLastLocationString", $scope.user.location, {
          expires: 30
        });
      };
      $scope.saveUserMapCenter = function() {
        $.cookie.json = true;
        return $.cookie("userMapCenter", {
          lat: $scope.map.getCenter().lat(),
          lng: $scope.map.getCenter().lng()
        }, {
          expires: 30
        });
      };
      $scope.saveUserMapTypeId = function() {
        $.cookie.json = true;
        return $.cookie("userMapTypeId", $scope.map.getMapTypeId(), {
          expires: 30
        });
      };
      $scope.saveUserMapZoom = function() {
        $.cookie.json = true;
        return $.cookie("userMapZoom", $scope.map.getZoom(), {
          expires: 30
        });
      };
      $scope.searchLocation = function(location) {
        return $scope.setLocationByUserLocation(location);
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
      $scope.setAddress = function() {
        var request;
        request = new Object();
        request.address = $scope.event.address;
        request.region = 'AR';
        return $scope.geocoder.geocode(request, $scope.addAddressToMap);
      };
      $scope.setEventInterval = function(interval) {
        return $scope.eventInterval = interval;
      };
      $scope.setLocation = function() {
        $scope.map.setZoom($scope.zoomCity);
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
      $scope.setLocationByUserLocation = function(location) {
        var request;
        request = new Object();
        request.address = location;
        return $scope.geocoder.geocode(request, $scope.centerMapByUserLocation);
      };
      $scope.setLocationDefault = function() {
        $scope.map.setZoom($scope.zoomDefault);
        return $scope.map.setCenter($scope.locationDefault);
      };
      $scope.setUserLocationByLatLng = function(location) {
        var request;
        request = {};
        request.location = location;
        return $scope.geocoder.geocode(request, function(response, status) {
          return setUserLocationString(response[0]);
        });
      };
      $scope.setMapType = function(mapTypeId) {
        $scope.map.setMapTypeId(mapTypeId);
        return $scope.saveUserMapTypeId();
      };
      $scope.showOverlays = function() {
        return $scope.setAllMap($scope.map);
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
          return window.location.pathname = 'events';
        }).error(function() {
          return $scope.cargando = 'Ocurrió un error guardando el evento';
        });
      };
      $scope.viewDisplayed = function() {
        return $location.path() === '/';
      };
      $scope.openModal = function(URL) {
        return EventView($scope, URL);
      };
      /* *************************************************************************************************************** 
      			Funciones Auxiliares
      			Aquí se escriben las funciones auxiliares
      	***************************************************************************************************************
      */

      findResult = function(results, name) {
        var result;
        result = results.filter(function(obj) {
          return obj.types[0] === name && obj.types[1] === "political";
        });
        if (result[0] != null) {
          return result[0].long_name;
        } else {
          return null;
        }
      };
      getEventCategoryIcon = function(event) {
        return event.Category.icon;
      };
      getEventId = function(event) {
        return event.Event.id;
      };
      getEventTitle = function(event) {
        return event.Event.title;
      };
      getEventDescription = function(event) {
        return event.Event.description;
      };
      return setUserLocationString = function(location) {
        var city, country, results;
        if ((location != null) && (location.address_components != null)) {
          results = location.address_components;
          city = findResult(results, "locality");
          country = findResult(results, "country");
          if (city && country) {
            $scope.user.location = city + ', ' + country;
          } else {
            $scope.user.location = location.formatted_address;
          }
          return $scope.saveUserLocationString();
        } else {
          return $scope.user.location = $scope.user.locationAux;
        }
      };
    }
  ]);

}).call(this);
