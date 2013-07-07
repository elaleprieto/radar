(function() {
  'use strict';
  var RadarApp;

  RadarApp = angular.module('RadarApp', ['$strap.directives']);

  RadarApp.value('$strapConfig', {
    datepicker: {},
    timepicker: {
      time: "03:00",
      time_from: "03:00"
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
    $scope.event = {};
    $scope.santafe = new google.maps.LatLng(-31.625906, -60.696774);
    $scope.opciones = {
      zoom: 13,
      center: $scope.santafe,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    $scope.map = new google.maps.Map(document.getElementById("map"), $scope.opciones);
    $scope.event.categories = [];
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
      console.log($scope.eventForm.$valid);
      if ($scope.event.categories.length <= 0) {
        return console.error("Error: Debe seleccionar al menos una categoría");
      }
      return console.log($scope.event);
    };
    $scope.$watch('event.date_from', function(newValue) {
      return console.log(newValue);
    });
    $scope.$watch('event.address', function(newValue) {
      return $scope.setAddress(newValue);
    });
    $scope.geocoder = new google.maps.Geocoder();
    $scope.addAddressToMap = function(response, status) {
      var icon;
      console.log(response);
      if (response.length === 0 || !response) {
        return this;
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
    return $scope.setAddress = function(address) {
      var request;
      request = new Object();
      request.address = address;
      request.bounds = $scope.map.getBounds();
      return $scope.geocoder.geocode(request, $scope.addAddressToMap);
    };
    /*
    	 time pickers
    */

  });

}).call(this);
