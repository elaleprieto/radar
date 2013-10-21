/* *******************************************************************************************************************
								EVENTOS
*******************************************************************************************************************
*/


(function() {
  angular.module('RadarApp').controller('PlacesController', [
    '$http', '$location', '$scope', '$timeout', '$compile', 'Place', function($http, $location, $scope, $timeout, $compile, Place) {
      /* ***************************************************************************************************************
      			Inicialización de Objetos
      	***************************************************************************************************************
      */

      var date, findResult, getPlaceCategoryIcon, getPlaceDescription, getPlaceId, getPlaceTitle, setUserLocationString, userLastLocationString, userMapCenter, userMapTypeId, userMapZoom;
      $scope.placeInterval = 1;
      $scope.user = {};
      $scope.placeCategory = [];
      date = new Date();
      $scope.minutoEnMilisegundos = 60 * 1000;
      $scope.diaEnMilisegundos = 24 * 60 * $scope.minutoEnMilisegundos;
      $scope.place = {};
      $scope.place.accessibility_parking = 0;
      $scope.place.accessibility_ramp = 0;
      $scope.place.accessibility_equipment = 0;
      $scope.place.accessibility_signage = 0;
      $scope.place.accessibility_braille = 0;
      $scope.place.categories = [];
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
      			Places
      			Aquí se registran los eventos para los objetos de la vista
      	***************************************************************************************************************
      */

      $scope.$watch('placeCategory.length', function() {
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
      google.maps.event.addListener($scope.map, 'dragend', function() {
        console.log($scope.map);
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
        $scope.placesUpdate();
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
      $scope.createMarker = function(place, latlng) {
        var contenido, icon, infowindow, marker;
        icon = new google.maps.MarkerImage('/img/map-marker/' + getPlaceCategoryIcon(place), new google.maps.Size(25, 26), new google.maps.Point(0, 0), new google.maps.Point(10, 34));
        marker = new google.maps.Marker({
          placeId: getPlaceId(place),
          map: $scope.map,
          icon: icon,
          position: latlng,
          title: getPlaceTitle(place),
          zIndex: Math.round(latlng.lat() * -100000) << 5
        });
        contenido = '<div>';
        contenido += '<p>' + getPlaceTitle(place) + '</p>';
        contenido += '<a ng-click="openModal(\'places/view/' + getPlaceId(place) + '\')">';
        contenido += '<p class="text-right"><i class="icon-expand-alt"></i> info</p>';
        contenido += '</a>';
        contenido += '</div>';
        contenido = $compile(contenido)($scope);
        infowindow = new google.maps.InfoWindow({
          content: contenido[0]
        });
        google.maps.place.addListener(marker, 'click', function() {
          return infowindow.open($scope.map, marker);
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
      $scope.categoriesAdd = function(category) {
        if ($scope.place.categories.length < 3) {
          $scope.place.categories.push(category.Category.id);
          return category.highlight = true;
        }
      };
      $scope.categoriesDelete = function(category) {
        var index;
        index = $scope.place.categories.indexOf(category.Category.id);
        if (index >= 0) {
          $scope.place.categories.splice(index, 1);
          return category.highlight = false;
        }
      };
      $scope.placesUpdate = function() {
        var bounds, ne, options, sw;
        if ($scope.map.getBounds() != null) {
          bounds = $scope.map.getBounds();
          ne = bounds.getNorthEast();
          sw = bounds.getSouthWest();
          options = {
            "placeCategory": $scope.placeCategory,
            "placeInterval": $scope.placeInterval,
            "neLat": ne.lat(),
            "neLong": ne.lng(),
            "swLat": sw.lat(),
            "swLong": sw.lng()
          };
          console.log(options);
          return Place.get({
            params: options
          }, function(response) {
            return $scope.places = response.places;
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
      $scope.resetView = function(place) {
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
        if ($scope.place.categories.length <= 0) {
          $scope.cargando = 'Error: Debe seleccionar al menos una categoría';
          return console.error('Error: Debe seleccionar al menos una categoría');
        }
        $scope.cargando = 'Cargando...';
        return $http.post('/places/add', {
          Place: $scope.place,
          Category: $scope.place.categories
        }).success(function(data) {
          $scope.cargando = '¡Placeo guardado!';
          return window.location.pathname = 'places';
        }).error(function() {
          return $scope.cargando = 'Ocurrió un error guardando el place';
        });
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
      getPlaceCategoryIcon = function(place) {
        return place.Category.icon;
      };
      getPlaceId = function(place) {
        return place.Place.id;
      };
      getPlaceTitle = function(place) {
        return place.Place.title;
      };
      getPlaceDescription = function(place) {
        return place.Place.description;
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
