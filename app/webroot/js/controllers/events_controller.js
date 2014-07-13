/* *******************************************************************************************************************
								EVENTOS
*******************************************************************************************************************
*/


(function() {
  angular.module('RadarApp').controller('EventsController', [
    '$http', '$location', '$scope', '$timeout', '$compile', 'Compliant', 'CompliantView', 'Event', 'EventView', 'Rate', 'User', function($http, $location, $scope, $timeout, $compile, Compliant, CompliantView, Event, EventView, Rate, User) {
      /* ***************************************************************************************************************
      			Inicialización de Objetos
      	***************************************************************************************************************
      */

      var date, findResult, getEventCategoryIcon, getEventDescription, getEventId, getEventTitle, setUserLocationString, userLastLocationString, userMapCenter, userMapTypeId, userMapZoom;
      if ($location.absUrl().contains('/events/edit/')) {
        console.log('Ruta: ', $location.absUrl());
        $scope.$watch('evento.id', function(id) {
          return Event.getById({
            id: id
          }, function(data) {
            return $scope.evento = data.event.Event;
          });
        });
      }
      $scope.eventInterval = 1;
      $scope.isReadonly = false;
      $scope.max = 5;
      $scope.user = {};
      $scope.categoriesSelected = [];
      date = new Date();
      $scope.minutoEnMilisegundos = 60 * 1000;
      $scope.diaEnMilisegundos = 24 * 60 * $scope.minutoEnMilisegundos;
      $scope.evento = {};
      $scope.evento.categories = [];
      $scope.descriptionSize = 500;
      $scope.hideSponsors = 1;
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
        center: $scope.locationDefault,
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
      }
      $scope.map = new google.maps.Map(document.getElementById("map"), $scope.opciones);
      $scope.markers = [];
      $scope.infowindows = [];
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
        angular.forEach($scope.eventos, function(evento, key) {
          var latlng;
          latlng = new google.maps.LatLng(evento.Event.lat, evento.Event.long);
          return $scope.createMarker(evento, latlng);
        });
        return $scope.showOverlays();
      }, true);
      $scope.$watch('evento.date_from', function(newValue) {
        if (newValue != null) {
          $('#date_to').datepicker('setDate', newValue);
          $('#date_to').datepicker('setStartDate', newValue);
          $('#date_to').datepicker('setEndDate', new Date(newValue.getTime() + (3 * $scope.diaEnMilisegundos)));
          return $scope.evento.date_to = newValue;
        }
      });
      $scope.$watch('evento.time_from', function(newValue) {
        if (newValue != null) {
          return $scope.checkTimeTo();
        }
      });
      $scope.$watch('evento.time_to', function(newValue) {
        if (newValue != null) {
          return $scope.checkTimeTo();
        }
      });
      $scope.$watch('user.locationAux', function(location) {
        if ((location != null) && location.length > 0) {
          return $scope.setLocationByUserLocation(location);
        }
      });
      google.maps.event.addListener($scope.map, 'click', function(event) {
        var request;
        request = new Object();
        request.location = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
        return $scope.geocoder.geocode(request, function(response, status) {
          $scope.evento.address = response[0].formatted_address;
          $scope.$apply();
          $('.typeahead').val($scope.evento.address);
          return $scope.addAddressToMap(response);
        });
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
        $scope.evento.lat = response[0].geometry.location.lat();
        $scope.evento.long = response[0].geometry.location.lng();
        if ($scope.map.getZoom() < 13) {
          $scope.centerMapInLatLng(response[0].geometry.location);
        }
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
      $scope.centerMapByUserLocation = function(response, status) {
        if ((response[0] != null) && (response[0].geometry != null) && (response[0].geometry.location != null)) {
          $scope.centerMapInLatLng(response[0].geometry.location, $scope.zoomCity);
          $scope.saveUserMapCenter();
          return setUserLocationString(response[0]);
        }
      };
      $scope.centerMapInCity = function(city) {
        $scope.map.setZoom($scope.zoomDefault);
        switch (city) {
          case 'cordoba':
            $scope.centerMapInLatLng($scope.cordoba, $scope.zoomCordoba);
            break;
          case 'santafe':
            $scope.centerMapInLatLng($scope.santafe, $scope.zoomSantafe);
            break;
          default:
            $scope.centerMapInLatLng($scope.locationDefault);
        }
        $scope.eventsUpdate();
        $scope.saveUserMapCenter();
        return $scope.saveUserMapZoom();
      };
      $scope.centerMapInLatLng = function(location, zoom) {
        if (zoom == null) {
          zoom = 13;
        }
        $scope.map.setCenter(location);
        return $scope.map.setZoom(13);
      };
      $scope.createMarker = function(evento, latlng) {
        var contenido, icon, infowindow, marker;
        icon = new google.maps.MarkerImage('/img/map-marker/' + getEventCategoryIcon(evento), new google.maps.Size(30, 40), new google.maps.Point(0, 0), new google.maps.Point(10, 34));
        marker = new google.maps.Marker({
          eventId: getEventId(evento),
          map: $scope.map,
          icon: icon,
          position: latlng,
          title: getEventTitle(evento),
          zIndex: Math.round(latlng.lat() * -100000) << 5
        });
        contenido = '<div>';
        contenido += '<p>' + getEventTitle(evento) + '</p>';
        contenido += '<a ng-click="openModal(\'events/view/' + getEventId(evento) + '\')">';
        contenido += '<p class="text-right"><i class="icon-expand-alt"></i> info</p>';
        contenido += '</a>';
        contenido += '</div>';
        contenido = $compile(contenido)($scope);
        infowindow = new google.maps.InfoWindow({
          content: contenido[0]
        });
        google.maps.event.addListener(marker, 'click', function() {
          $scope.closeAllInfowindows();
          return infowindow.open($scope.map, marker);
        });
        $scope.infowindows.push(infowindow);
        return $scope.markers.push(marker);
      };
      $scope.checkDescriptionSize = function(event, evento) {
        if (evento.description != null) {
          if (+$scope.descriptionSize - evento.description.length < 0) {
            evento.description = evento.description.substr(0, 500);
            return event.preventDefault();
          }
        }
      };
      $scope.checkTimeTo = function() {
        var dateEnd, dateEndAux, dateFrom, dateStart, dateTo, timeFrom, timeTo;
        if ($scope.evento.time_from != null) {
          if ($scope.evento.date_from === $scope.evento.date_to) {
            dateFrom = $scope.evento.date_from;
            dateTo = $scope.evento.date_to;
            timeFrom = $scope.evento.time_from.split(':');
            dateStart = new Date(dateFrom.getFullYear(), dateFrom.getMonth(), dateFrom.getDate(), timeFrom[0], timeFrom[1]);
            dateEnd = new Date(dateStart.getTime() + (15 * $scope.minutoEnMilisegundos));
            if ($scope.evento.time_to == null) {
              return $scope.evento.time_to = dateEnd.getHours() + ':' + dateEnd.getMinutes();
            } else {
              timeTo = $scope.evento.time_to.split(':');
              dateEndAux = new Date(dateTo.getFullYear(), dateTo.getMonth(), dateTo.getDate(), timeTo[0], timeTo[1]);
              if (dateEnd.getTime() > dateEndAux.getTime()) {
                $scope.evento.time_to = dateEnd.getHours() + ':' + dateEnd.getMinutes();
                if (dateEnd.getMinutes() === 0) {
                  return $scope.evento.time_to += '0';
                }
              }
            }
          }
        }
      };
      $scope.clearOverlays = function() {
        return $scope.setAllMap(null);
      };
      $scope.closeAllInfowindows = function() {
        return angular.forEach($scope.infowindows, function(infowindow, index) {
          return infowindow.close();
        });
      };
      $scope.deleteOverlays = function() {
        $scope.clearOverlays();
        return $scope.markers = [];
      };
      $scope.categoriesAdd = function(category) {
        if ($scope.evento.categories.length < 3) {
          $scope.evento.categories.push(category.Category.id);
          return category.highlight = true;
        }
      };
      $scope.categoriesDelete = function(category) {
        var index;
        index = $scope.evento.categories.indexOf(category.Category.id);
        if (index >= 0) {
          $scope.evento.categories.splice(index, 1);
          return category.highlight = false;
        }
      };
      $scope.denounce = function(evento) {
        if (($scope.user.id != null) && (evento.Compliant != null) && (evento.Compliant.title != null)) {
          Compliant.create(evento);
          return CompliantView.close();
        }
      };
      $scope.eventsUpdate = function() {
        var bounds, ne, options, sw;
        if ($scope.categoriesSelected.length === 0) {
          $scope.eventos = [];
          return;
        }
        if (!$location.absUrl().contains('events/add') && ($scope.map.getBounds() != null)) {
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
      $scope.resetView = function(evento) {
        return $location.path('/');
      };
      $scope.saveRatingToServer = function(evento, newRating) {
        evento.Event.rate = +evento.Event.rate + newRating;
        evento.Rate.rate = newRating;
        if (newRating > 0) {
          evento.Rate.user_id = $scope.user.id;
        }
        if (newRating < 0) {
          evento.Rate.user_id = false;
        }
        return Rate.create(evento);
      };
      $scope.saveUserLocationPreferences = function() {
        $scope.saveUserLocationString();
        $scope.saveUserMapCenter();
        $scope.saveUserMapTypeId();
        $scope.saveUserMapZoom();
        if ($scope.user.id != null) {
          $scope.user.map_lat = $scope.map.getCenter().lat();
          $scope.user.map_lng = $scope.map.getCenter().lng();
          $scope.user.map_type = $scope.map.getMapTypeId();
          $scope.user.map_zoom = $scope.map.getZoom();
          return User.update({
            id: $scope.user.id
          }, $scope.user);
        }
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
      $scope.setAddress = function(event) {
        var request;
        if (event != null) {
          event.preventDefault();
        }
        request = new Object();
        request.address = $scope.evento.address;
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
        if ($scope.evento.categories.length <= 0) {
          $scope.cargando = 'Error: Debe seleccionar al menos una categoría';
          return console.error('Error: Debe seleccionar al menos una categoría');
        }
        $scope.cargando = 'Cargando...';
        return Event.save({}, {
          Event: $scope.evento,
          Category: $scope.evento.categories
        }, function(data) {
          $scope.cargando = '¡Evento guardado!';
          return window.location.pathname = 'events';
        }, function() {
          return $scope.cargando = 'Ocurrió un error guardando el evento';
        });
      };
      $scope.viewDisplayed = function() {
        return $location.path() === '/';
      };
      $scope.openModal = function(URL) {
        return EventView($scope, URL);
      };
      $scope.openCompliantModal = function(evento) {
        return CompliantView.show($scope, evento);
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
      getEventCategoryIcon = function(evento) {
        return evento.Category.icon;
      };
      getEventId = function(evento) {
        return evento.Event.id;
      };
      getEventTitle = function(evento) {
        return evento.Event.title;
      };
      getEventDescription = function(evento) {
        return evento.Event.description;
      };
      setUserLocationString = function(location) {
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
          $scope.locationSearched = $scope.user.location;
          return $scope.saveUserLocationString();
        } else {
          return $scope.user.location = $scope.user.locationAux;
        }
      };
      $('.typeahead').typeahead({
        limit: 10,
        name: 'Address',
        remote: {
          url: 'https://maps.googleapis.com/maps/api/geocode/json?address=%QUERY&sensor=false',
          cache: true,
          filter: function(response) {
            var datums, result, results, status, _i, _len;
            results = response.results;
            status = response.status;
            datums = [];
            if (!results || results.length === 0) {
              return items;
            }
            for (_i = 0, _len = results.length; _i < _len; _i++) {
              result = results[_i];
              datums.push({
                value: result.formatted_address,
                location: result.geometry.location
              });
            }
            $scope.setAddressToMap(datums[0]);
            return datums;
          }
        }
      }).on('typeahead:selected typeahead:autocompleted', function(e, datum) {
        return $scope.setAddressToMap(datum);
      });
      return $scope.setAddressToMap = function(datum) {
        var icon;
        $scope.evento.address = datum.value;
        $scope.evento.lat = datum.location.lat;
        $scope.evento.long = datum.location.lng;
        $scope.user.location = datum.value;
        $scope.map.setCenter(datum.location);
        $scope.map.setZoom(13);
        icon = new google.maps.MarkerImage("http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png", new google.maps.Size(20, 34), new google.maps.Point(0, 0), new google.maps.Point(10, 34));
        if ($scope.marker != null) {
          $scope.marker.setMap(null);
        }
        $scope.marker = new google.maps.Marker({
          'position': datum.location,
          'map': $scope.map,
          'icon': icon
        });
        return $scope.marker.setMap($scope.map);
      };
    }
  ]);

}).call(this);
