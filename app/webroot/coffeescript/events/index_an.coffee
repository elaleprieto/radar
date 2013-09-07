'use strict'

# App = angular.module('App', ['fechaFilters', 'scroll'])
RadarApp = angular.module('RadarApp', ['fechaFilters'])

# App.config(['$routeProvider', ($routeProvider) ->
    # $routeProvider.
      # when('/', {
        # controller: 'CategoriaController',
        # resolve: {
          # recipes: (MultiRecipeLoader) ->
            # return MultiRecipeLoader();
        # },
        # templateUrl:'/events/list'
      # })
      # # .when('/edit/:recipeId', {
        # # controller: 'EditCtrl',
        # # resolve: {
          # # recipe: function(RecipeLoader) {
            # # return RecipeLoader();
          # # }
        # # },
        # # templateUrl:'/views/recipeForm.html'
      # # })
      # # .when('/view/:recipeId', {
        # # controller: 'ViewCtrl',
        # # resolve: {
          # # recipe: function(RecipeLoader) {
            # # return RecipeLoader();
          # # }
        # # },
        # # templateUrl:'/views/viewRecipe.html'
      # # })
      # # .when('/new', {
        # # controller: 'NewCtrl',
        # # templateUrl:'/views/recipeForm.html'
      # # })
      # .otherwise({redirectTo:'/'});
# ]);


RadarApp.directive('loading', ['$rootScope', ($rootScope) ->
  return {
    link: (scope, element, attrs) ->
      element.addClass('hide');

      $rootScope.$on('$routeChangeStart', () ->
        element.removeClass('hide');
      );

      $rootScope.$on('$routeChangeSuccess', () ->
        element.addClass('hide');
      );
  };
]);

RadarApp.directive('loaded', ['$rootScope', ($rootScope) ->
  return {
    link: (scope, element, attrs) ->
      # element.addClass('show');

      $rootScope.$on('$routeChangeStart', () ->
        element.addClass('hide');
      );

      $rootScope.$on('$routeChangeSuccess', () ->
        element.removeClass('hide');
      );
  };
]);


### *******************************************************************************************************************
								CATEGORIAS
******************************************************************************************************************* ###
RadarApp.controller 'CategoriaController', ($scope) ->
	$scope.show = (categoria) ->
		categoria.highlight = !categoria.highlight
		if categoria.highlight
			$scope.eventCategory.push(categoria.Category.id)
		else
			$scope.eventCategory.splice($scope.eventCategory.indexOf(categoria.Category.id), 1)
		
		

### *******************************************************************************************************************
								EVENTOS
******************************************************************************************************************* ###

RadarApp.controller 'EventoController', ($scope, $http, $timeout) ->

	### ***************************************************************************************************************
			Inicialización de Objetos
	*************************************************************************************************************** ###
	$scope.eventCategory = []
	$scope.eventInterval = 1

	# Cities
	$scope.capital = new google.maps.LatLng(-34.603, -58.382)
	$scope.cordoba = new google.maps.LatLng(-31.388813, -64.179726)
	$scope.santafe = new google.maps.LatLng(-31.625906,-60.696774)
	$scope.cordobaSantafe = new google.maps.LatLng(-31.52081,-62.411469)
	$scope.locationDefault = $scope.cordobaSantafe
	$scope.zoomDefault = 8
	$scope.zoomSantafe = 12
	$scope.zoomCordoba = 11
	$scope.zoomCity = 12
	
	# Map defaults
	$scope.opciones = {zoom: $scope.zoomDefault, center: $scope.locationDefault, mapTypeId: google.maps.MapTypeId.ROADMAP}
	$scope.map = new google.maps.Map(document.getElementById("map"), $scope.opciones)
	$scope.markers = []
	

	### ***************************************************************************************************************
			Eventos
			Aquí se registran los eventos para los objetos de la vista
	*************************************************************************************************************** ###
	
	# Se observan las categorías seleccionadas
	$scope.$watch 'eventCategory.length', () ->
		$scope.eventsUpdate() 

	# Se observa el intervalo seleccionado: Hoy, Mañana ó Próximos 7 días
	$scope.$watch 'eventInterval', () ->
		$scope.eventsUpdate() 

	# Se observa el listado de eventos
	$scope.$watch 'eventos.length', () ->
		$scope.deleteOverlays()
		angular.forEach $scope.eventos, (event, key) ->
			latlng = new google.maps.LatLng(event.Event.lat, event.Event.long)
			$scope.createMarker(event.Event.id, event.Event.title, latlng)
		$scope.showOverlays()
	
	# # google.maps.event.addListener window.map, 'bounds_changed', () ->
	google.maps.event.addListener $scope.map, 'dragend', () ->
		$scope.eventsUpdate()

	google.maps.event.addListener $scope.map, 'tilesloaded', () ->
		$scope.eventsUpdate()

	google.maps.event.addListener $scope.map, 'zoom_changed', () ->
		$scope.eventsUpdate()
	
	
	### *************************************************************************************************************** 
			Funciones
			Aquí se escriben las funciones
	*************************************************************************************************************** ###
	
	# Se consulta al servidor por los eventos dentro de los límites del mapa y que cumplen las condiciones
	# de categoría e intervalo seleccionadas.
	$scope.eventsUpdate = () ->
		if $scope.map.getBounds()?
			bounds = $scope.map.getBounds()
			ne = bounds.getNorthEast()
			sw = bounds.getSouthWest()
			options = "eventCategory": $scope.eventCategory
				, "eventInterval": $scope.eventInterval
				, "neLat": ne.lat()
				, "neLong": ne.lng()
				, "swLat": sw.lat()
				, "swLong": sw.lng()
			
			$http.get('/events/get', {cache: false, params: options})
				.success (data) ->
					$scope.eventos = data
	
	# centerMap: centers map with parameter city
	$scope.centerMap = (city) ->
		$scope.map.setZoom($scope.zoomDefault)
		
		switch city
			when 'cordoba' 
				location = $scope.cordoba
				$scope.map.setZoom($scope.zoomCordoba)
			when 'santafe'
				location = $scope.santafe
				$scope.map.setZoom($scope.zoomSantafe)
			else location = $scope.locationDefault
		$scope.map.setCenter(location)
		$scope.eventsUpdate()
	
	# Inicializa el mapa
	$scope.inicializar = ->
		if navigator.geolocation
			window.browserSupportFlag = on
			navigator.geolocation.getCurrentPosition (position) ->
				initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
				$scope.map.setCenter(initialLocation)
			, ->
				$scope.setLocationDefault()
	
	# A function to create the marker and set up the event window function
	$scope.createMarker = (eventId, eventTitle, latlng) ->
		marker = new google.maps.Marker eventId: eventId
			, title: eventTitle
			, position: latlng
			, map: $scope.map
			, zIndex: Math.round(latlng.lat()*-100000)<<5
		$scope.markers.push(marker)

	# Removes the overlays from the map, but keeps them in the array.
	$scope.clearOverlays = ->
		$scope.setAllMap(null)
	
	# Deletes all markers in the array by removing references to them.
	$scope.deleteOverlays = ->
		$scope.clearOverlays()
		$scope.markers = []

	# Sets the map on all markers in the array.
	$scope.setAllMap = (map) ->
		for marker in $scope.markers
			marker.setMap(map)

	$scope.setEventInterval = (interval) ->
		$scope.eventInterval = interval
	
	$scope.setLocation = ->
		$scope.map.setZoom(14)
		if navigator.geolocation
			window.browserSupportFlag = on
			navigator.geolocation.getCurrentPosition (position) ->
					location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
					$scope.map.setCenter(location)
					$scope.eventsUpdate()
				, ->
					$scope.errorLocation = 'Debes autorizar la captura de tu ubicación'
					$scope.setLocationDefault()
					$timeout ->
							$scope.errorLocation = null
						, 2000
		else
			$scope.errorLocation = 'Esta función no está soportada por tu navegador'

	# Setea una localización por defecto		
	$scope.setLocationDefault = ->
		$scope.map.setZoom($scope.zoomDefault)
		$scope.map.setCenter($scope.locationDefault)
		$scope.eventsUpdate()
	
	# Shows any overlays currently in the array.
	$scope.showOverlays = ->
		$scope.setAllMap($scope.map)
	
	# Se inicializa el mapa
	# $scope.inicializar() # Se lo quito por ahora pero debería centrar el mapa en el lugar del visitante..
	$scope.setLocationDefault() # Se agrega esta línea para inicializar el mapa pero la idea es que inicialice con inicializar()
	
	
	
