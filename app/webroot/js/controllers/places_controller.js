/* *******************************************************************************************************************
								PLACES
*******************************************************************************************************************
*/


(function() {
  angular.module('RadarApp').controller('PlacesController', [
    '$http', '$location', '$scope', '$timeout', '$compile', 'Place', 'PlaceView', 'User', function($http, $location, $scope, $timeout, $compile, Place, PlaceView, User) {
      /* ***************************************************************************************************************
      			Inicialización de Objetos
      	***************************************************************************************************************
      */

      var date, findResult, getPlaceColor, getPlaceDescription, getPlaceIcon, getPlaceId, getPlaceName, setUserLocationString, userLastLocationString, userMapCenter, userMapTypeId, userMapZoom, _ref;
      $scope.placeInterval = 1;
      $scope.user = {};
      $scope.classificationsSelected = [];
      date = new Date();
      $scope.minutoEnMilisegundos = 60 * 1000;
      $scope.diaEnMilisegundos = 24 * 60 * $scope.minutoEnMilisegundos;
      $scope.place = {};
      $scope.place.accessibility_parking = 0;
      $scope.place.accessibility_ramp = 0;
      $scope.place.accessibility_equipment = 0;
      $scope.place.accessibility_signage = 0;
      $scope.place.accessibility_braille = 0;
      $scope.place.classifications = [];
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
        center: (_ref = $scope.locationAux) != null ? _ref : $scope.locationDefault,
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
      $scope.infowindows = [];
      $scope.geocoder = new google.maps.Geocoder();
      /* ***************************************************************************************************************
      			Places
      			Aquí se registran los eventos para los objetos de la vista
      	***************************************************************************************************************
      */

      $scope.$watch('classificationsSelected.length', function() {
        return $scope.placesUpdate();
      });
      $scope.$watch('placeInterval', function() {
        return $scope.placesUpdate();
      });
      $scope.$watch('places', function() {
        $scope.deleteOverlays();
        angular.forEach($scope.places, function(place, key) {
          var latlng;
          latlng = new google.maps.LatLng(place.Place.lat, place.Place.long);
          return $scope.createMarker(place, latlng);
        });
        return $scope.showOverlays();
      }, true);
      $scope.$watch('user.locationAux', function(location) {
        if ((userMapCenter == null) && (location != null) && location.length > 0) {
          return $scope.setLocationByUserLocation(location);
        }
      });
      google.maps.event.addListener($scope.map, 'click', function(event) {
        var request;
        request = new Object();
        request.location = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
        return $scope.geocoder.geocode(request, function(response, status) {
          $scope.place.address = response[0].formatted_address;
          $scope.$apply();
          $('.typeahead').val($scope.place.address);
          return $scope.addAddressToMap(response);
        });
      });
      google.maps.event.addListener($scope.map, 'dragend', function() {
        $scope.placesUpdate();
        return $scope.saveUserMapCenter();
      });
      google.maps.event.addListener($scope.map, 'tilesloaded', function() {
        return $scope.placesUpdate();
      });
      google.maps.event.addListener($scope.map, 'zoom_changed', function() {
        $scope.placesUpdate();
        return $scope.saveUserMapZoom();
      });
      google.maps.event.addListener($scope.map, 'position_changed', function() {
        return $scope.placesUpdate();
      });
      /* *************************************************************************************************************** 
      			Funciones
      			Aquí se escriben las funciones
      	***************************************************************************************************************
      */

      $scope.accessibilityParkingToogle = function() {
        return $scope.place.accessibility_parking = ++$scope.place.accessibility_parking % 3;
      };
      $scope.accessibilityRampToogle = function() {
        return $scope.place.accessibility_ramp = ++$scope.place.accessibility_ramp % 3;
      };
      $scope.accessibilityEquipmentToogle = function() {
        return $scope.place.accessibility_equipment = ++$scope.place.accessibility_equipment % 3;
      };
      $scope.accessibilitySignageToogle = function() {
        return $scope.place.accessibility_signage = ++$scope.place.accessibility_signage % 3;
      };
      $scope.accessibilityBrailleToogle = function() {
        return $scope.place.accessibility_braille = ++$scope.place.accessibility_braille % 3;
      };
      $scope.addAddressToMap = function(response, status) {
        var icon;
        if (!response || response.length === 0) {
          return this;
        }
        $scope.place.lat = response[0].geometry.location.lat();
        $scope.place.long = response[0].geometry.location.lng();
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
        $scope.placesUpdate();
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
      $scope.createMarker = function(place, latlng) {
        var contenido, icon, infowindow, marker;
        icon = new google.maps.MarkerImage('/img/map-marker/' + getPlaceIcon(place), new google.maps.Size(30, 40), new google.maps.Point(0, 0), new google.maps.Point(10, 34));
        marker = new google.maps.Marker({
          placeId: getPlaceId(place),
          map: $scope.map,
          icon: icon,
          position: latlng,
          title: getPlaceName(place),
          zIndex: Math.round(latlng.lat() * -100000) << 5
        });
        contenido = '<div>';
        contenido += '<p>' + getPlaceName(place) + '</p>';
        contenido += '<a ng-click="openModal(\'places/view/' + getPlaceId(place) + '\')">';
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
      $scope.classificationsAdd = function(classification) {
        if ($scope.place.classifications.length < 3) {
          return $scope.place.classifications.push(classification);
        }
      };
      $scope.classificationsDelete = function(classification) {
        return angular.forEach($scope.place.classifications, function(element, index, array) {
          if (element.id === classification.id) {
            return $scope.place.classifications.splice(index, 1);
          }
        });
      };
      $scope.classificationToogle = function(classification) {
        if (!$scope.placeHasClassification(classification)) {
          return $scope.classificationsAdd(classification);
        } else {
          return $scope.classificationsDelete(classification);
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
      $scope.placeHasClassification = function(classification) {
        if ($scope.place.classifications != null) {
          return $scope.place.classifications.some(function(element, index, array) {
            return element.id === classification.id;
          });
        }
      };
      $scope.placesUpdate = function() {
        var bounds, ne, options, sw;
        if ($scope.classificationsSelected.length === 0) {
          $scope.places = [];
          return;
        }
        if ($scope.map.getBounds() != null) {
          bounds = $scope.map.getBounds();
          ne = bounds.getNorthEast();
          sw = bounds.getSouthWest();
          options = {
            "classificationsSelected": $scope.classificationsSelected,
            "placeInterval": $scope.placeInterval,
            "neLat": ne.lat(),
            "neLong": ne.lng(),
            "swLat": sw.lat(),
            "swLong": sw.lng()
          };
          return Place.get({
            params: options
          }, function(response) {
            return $scope.places = response.places;
          });
        }
      };
      $scope.resetView = function(place) {
        console.log($('ng-view').innerHtml);
        return $location.path('/');
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
        var marker, _i, _len, _ref1, _results;
        _ref1 = $scope.markers;
        _results = [];
        for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
          marker = _ref1[_i];
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
        request.address = $scope.place.address;
        request.region = 'AR';
        return $scope.geocoder.geocode(request, $scope.addAddressToMap);
      };
      $scope.setPlaceInterval = function(interval) {
        return $scope.placeInterval = interval;
      };
      $scope.setLocation = function() {
        $scope.map.setZoom($scope.zoomCity);
        if (navigator.geolocation) {
          window.browserSupportFlag = true;
          return navigator.geolocation.getCurrentPosition(function(position) {
            var location;
            location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            $scope.map.setCenter(location);
            return $scope.placesUpdate();
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
        if (!$scope.placeForm.$valid) {
          $scope.cargando = null;
          return this;
        }
        $scope.cargando = 'Cargando..';
        if ($scope.place.classifications.length <= 0) {
          $scope.cargando = 'Error: Debe seleccionar al menos una categoría';
          return console.error('Error: Debe seleccionar al menos una categoría');
        }
        $scope.cargando = 'Cargando...';
        if (!$scope.place.id) {
          return Place.create({}, {
            Place: $scope.place,
            Classification: $scope.place.classifications
          }, function(data) {
            $scope.cargando = '¡Lugar guardado!';
            return window.location.pathname = 'places';
          }, function() {
            return $scope.cargando = 'Ocurrió un error guardando el place';
          });
        } else {
          return Place.update({
            id: $scope.place.id
          }, {
            Place: $scope.place,
            Classification: $scope.place.classifications
          }, function(data) {
            $scope.cargando = '¡Lugar guardado!';
            return window.location.pathname = 'admin/places';
          }, function() {
            return $scope.cargando = 'Ocurrió un error guardando el place';
          });
        }
      };
      $scope.viewDisplayed = function() {
        return $location.path() === '/';
      };
      $scope.openModal = function(URL) {
        return PlaceView($scope, URL);
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
      getPlaceColor = function(place) {
        return place.Classification.color;
      };
      getPlaceIcon = function(place) {
        return place.Classification.icon;
      };
      getPlaceId = function(place) {
        return place.Place.id;
      };
      getPlaceName = function(place) {
        return place.Place.name;
      };
      getPlaceDescription = function(place) {
        return place.Place.description;
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
        $scope.place.address = datum.value;
        $scope.place.lat = datum.location.lat;
        $scope.place.long = datum.location.lng;
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
