### *******************************************************************************************************************
								PLACES
******************************************************************************************************************* ###

angular.module('RadarApp').controller 'PlacesController'
	, ['$http', '$location', '$scope', '$timeout', '$compile', 'Place', 'PlaceView', 'User'
		, ($http, $location, $scope, $timeout, $compile, Place, PlaceView, User) ->

	### ***************************************************************************************************************
			Inicialización de Objetos
	*************************************************************************************************************** ###
	$scope.placeInterval = 1
	$scope.user = {}
	$scope.classificationsSelected = []
	date = new Date()
	$scope.minutoEnMilisegundos = 60 * 1000
	$scope.diaEnMilisegundos = 24 * 60 * $scope.minutoEnMilisegundos
	$scope.place = {}
	$scope.place.accessibility_parking = 0
	$scope.place.accessibility_ramp = 0
	$scope.place.accessibility_equipment = 0
	$scope.place.accessibility_signage = 0
	$scope.place.accessibility_braille = 0
	$scope.place.classifications = []
	$scope.hideSponsors = 1

	# Cities
	$scope.capital = new google.maps.LatLng(-34.603, -58.382)
	$scope.cordoba = new google.maps.LatLng(-31.388813, -64.179726)
	$scope.santafe = new google.maps.LatLng(-31.625906,-60.696774)
	$scope.cordobaSantafe = new google.maps.LatLng(-31.52081,-62.411469)
	$scope.locationDefault = $scope.cordobaSantafe
	$scope.zoomDefault = 8
	$scope.zoomSantafe = 12
	$scope.zoomCordoba = 11
	$scope.zoomCity = 15
	
	# Map constants
	$scope.ROADMAP = google.maps.MapTypeId.ROADMAP
	$scope.SATELLITE = google.maps.MapTypeId.SATELLITE
	
	# Map defaults
	$scope.opciones = center: $scope.locationAux ? $scope.locationDefault
		, mapTypeId: $scope.ROADMAP
		, panControl: false
		, zoomControl: false
		, mapTypeControl: false
		, scaleControl: false
		, streetViewControl: false
		, overviewMapControl: false
		, zoom: $scope.zoomDefault
	
	# User defaults
	if $.cookie?
		$.cookie.json = true
		userMapCenter = $.cookie('userMapCenter')
		userMapTypeId = $.cookie('userMapTypeId')
		userMapZoom = $.cookie('userMapZoom')
		userLastLocationString = $.cookie('userLastLocationString')
		
		# Se sobreescriben las opciones del mapa si el usuario las tiene seteadas
		$scope.opciones.center = new google.maps.LatLng(userMapCenter.lat, userMapCenter.lng) if userMapCenter?
		$scope.opciones.mapTypeId = userMapTypeId if userMapTypeId?
		$scope.opciones.zoom = userMapZoom if userMapZoom?
		$scope.user.location = userLastLocationString if userLastLocationString?
		
		$timeout ->
			$scope.setUserLocationByLatLng($scope.opciones.center)
		, 50
	
	$scope.map = new google.maps.Map(document.getElementById("map"), $scope.opciones)
	$scope.markers = []
	$scope.infowindows = []
	$scope.geocoder = new google.maps.Geocoder()
	

	### ***************************************************************************************************************
			Places
			Aquí se registran los eventos para los objetos de la vista
	*************************************************************************************************************** ###
	
	# Se observan las classifications seleccionadas
	$scope.$watch 'classificationsSelected.length', () ->
		$scope.placesUpdate()		

	# Se observa el intervalo seleccionado: Hoy, Mañana ó Próximos 7 días
	$scope.$watch 'placeInterval', () ->
		$scope.placesUpdate() 

	# Se observa el listado de places
	$scope.$watch 'places', ->
			$scope.deleteOverlays()
			angular.forEach $scope.places, (place, key) ->
				latlng = new google.maps.LatLng(place.Place.lat, place.Place.long)
				# $scope.createMarker(place.Place.id, place.Place.title, place.Classification.icon, latlng)
				$scope.createMarker(place, latlng)
			$scope.showOverlays()
		, true
	
	# Se comenta esto para hacerlo con un botón
	# Se observa cuando cambia el address y se hace la llamada al API si la longitud es superior a 3
	# $scope.$watch 'place.address', (newValue) ->
		# $scope.setAddress(newValue) if newValue? and newValue.length > 3
	
	# Se observa el user.location
	$scope.$watch 'user.locationAux', (location) ->
		if not userMapCenter? and location? and location.length > 0
			$scope.setLocationByUserLocation(location)

	# Se crea el Listener para el clic sobre el mapa en la creacion de Places
	google.maps.event.addListener $scope.map, 'click', (event) ->
		if $location.absUrl().contains('/places/add') or $location.absUrl().contains('/espacios/agregar')
			# se crea un objeto request
			request = new Object()
			request.location = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())

			# geocode hace la conversión a un punto, y su segundo parámetro es una función de callback
			$scope.geocoder.geocode request, (response, status) ->
				$scope.place.address = response[0].formatted_address
				$scope.$apply()
				$('.typeahead').val($scope.place.address)
				$scope.addAddressToMap(response)

	google.maps.event.addListener $scope.map, 'dragend', () ->
		$scope.placesUpdate()
		$scope.saveUserMapCenter()

	google.maps.event.addListener $scope.map, 'tilesloaded', () ->
		$scope.placesUpdate()

	google.maps.event.addListener $scope.map, 'zoom_changed', () ->
		$scope.placesUpdate()
		$scope.saveUserMapZoom()

	google.maps.event.addListener $scope.map, 'position_changed', () ->
		$scope.placesUpdate()

	
	### *************************************************************************************************************** 
			Funciones
			Aquí se escriben las funciones
	*************************************************************************************************************** ###
	
	$scope.accessibilityParkingToogle = ->
		$scope.place.accessibility_parking = ++$scope.place.accessibility_parking % 3
	
	$scope.accessibilityRampToogle = ->
		$scope.place.accessibility_ramp = ++$scope.place.accessibility_ramp % 3
	
	$scope.accessibilityEquipmentToogle = ->
		$scope.place.accessibility_equipment = ++$scope.place.accessibility_equipment % 3
	
	$scope.accessibilitySignageToogle = ->
		$scope.place.accessibility_signage = ++$scope.place.accessibility_signage % 3
	
	$scope.accessibilityBrailleToogle = ->
		$scope.place.accessibility_braille = ++$scope.place.accessibility_braille % 3
		
	$scope.addAddressToMap = (response, status) ->
		if !response or response.length is 0 then return @ #si no pudo
		
		$scope.place.lat = response[0].geometry.location.lat()
		$scope.place.long = response[0].geometry.location.lng()
		
		# Se centra el mapa si el zoom es inferior a 13.
		# Si no es así, se considera que el usuario buscó la ubicación y el mapa está donde tiene que estar.
		if $scope.map.getZoom() < 13 then $scope.centerMapInLatLng(response[0].geometry.location)
		
		# blankicono que voy a usar para mostrar el punto en el mapa
		icon = new google.maps.MarkerImage("http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png"
			, new google.maps.Size(20, 34)
			, new google.maps.Point(0, 0)
			, new google.maps.Point(10, 34)
		)
		
		if $scope.marker? then $scope.marker.setMap(null)
		
		# creo el marcador con la posición, el mapa, y el icono
		$scope.marker = new google.maps.Marker 
			'position': response[0].geometry.location
			, 'map': $scope.map
			, 'icon': icon
		
		$scope.marker.setMap($scope.map) # inserto el marcador en el mapa
	
	# centerMapByUserLocation: centers map with parameter location, called by setLocationByUserLocation
	$scope.centerMapByUserLocation = (response, status) ->
		if response[0]? and response[0].geometry? and response[0].geometry.location?
			# Center Map
			$scope.centerMapInLatLng response[0].geometry.location, $scope.zoomCity
			$scope.saveUserMapCenter()
			setUserLocationString(response[0])

	# centerMapInCity: centers map with parameter city
	$scope.centerMapInCity = (city) ->
		$scope.map.setZoom($scope.zoomDefault)
		
		switch city
			when 'cordoba' 
				$scope.centerMapInLatLng $scope.cordoba, $scope.zoomCordoba
			when 'santafe'
				$scope.centerMapInLatLng $scope.santafe, $scope.zoomSantafe
			else 
				$scope.centerMapInLatLng $scope.locationDefault
		$scope.placesUpdate()
		# Se guardan las preferencias
		$scope.saveUserMapCenter()
		$scope.saveUserMapZoom()
		
	$scope.centerMapInLatLng = (location, zoom = 13) ->
		$scope.map.setCenter(location)
		$scope.map.setZoom(13)

	
	# A function to create the marker and set up the place window function
	# $scope.createMarker = (placeId, latlng) ->
	$scope.createMarker = (place, latlng) ->
		icon = new google.maps.MarkerImage('/img/map-marker/' + getPlaceIcon(place)
			#, new google.maps.Size(25, 26)
			, new google.maps.Size(30, 40)
			, new google.maps.Point(0, 0)
			, new google.maps.Point(10, 34)
		)
		# icon = {
		# 	# path: 'M 125,5 155,90 245,90 175,145 200,230 125,180 50,230 75,145 5,90 95,90 z',
		# 	path: google.maps.SymbolPath.CIRCLE,
		# 	fillColor: getPlaceColor(place),
		# 	fillOpacity: 0.8,
		# 	scale: 1,
		# 	strokeColor: getPlaceColor(place),
		# 	strokeWeight: 14
		# }

		
		marker = new google.maps.Marker placeId: getPlaceId(place)
			, map: $scope.map
			, icon: icon
			, position: latlng
			, title: getPlaceName(place)
			, zIndex: Math.round(latlng.lat()*-100000)<<5
		
		# $scope.placeMarkerAux = place
# 			
		# contenido = $compile('<marker place="placeMarkerAux"></marker>')($scope)
		# console.log contenido
		# console.log contenido[0]
		# console.log contenido[0].textContent
		# console.log contenido[0].innerHTML
		
		contenido = '<div>'
		contenido += '<p>' + getPlaceName(place) + '</p>'
		# contenido += '<a href="/places/view/' + getPlaceId(place) + '">'
		contenido += '<a ng-click="openModal(\'places/view/' + getPlaceId(place) + '\')">'
		contenido += '<p class="text-right"><i class="icon-expand-alt"></i> info</p>'
		contenido += '</a>'
		contenido += '</div>'
		contenido = $compile(contenido)($scope)
		# if getPlaceDescription(place) then contenido += '<p>' + getPlaceDescription(place) + '</p>'
		# if getPlaceDescription(place) 
			# contenido += '<p>' + getPlaceDescription(place) + '</p>'
		# else 
			# contenido += '<p>No description</p>'
		
		infowindow = new google.maps.InfoWindow {
			# content: contenido  
			content: contenido[0]
		}

		# Se agrega el listener del marker sobre el place click 
		google.maps.event.addListener marker, 'click', ->
			$scope.closeAllInfowindows()
			infowindow.open($scope.map, marker)
		
		$scope.infowindows.push(infowindow)
		$scope.markers.push(marker)

	$scope.classificationsAdd = (classification) ->
		if $scope.place.classifications.length < 3
			$scope.place.classifications.push(classification)
			# $scope.place.classifications.push(classification.Classification.id)
			# classification.highlight = true

	# $scope.classificationsDelete = (classification) ->
		# index = $scope.place.classifications.indexOf(classification.Classification.id)
		# if index >= 0 
			# $scope.place.classifications.splice(index, 1)
			# classification.highlight = false
	$scope.classificationsDelete = (classification) ->
		angular.forEach $scope.place.classifications, (element, index, array) ->
			if element.id is classification.id
				$scope.place.classifications.splice(index, 1)

	# classificationToogle(classification): agrega o elimina la clasificacion al padre.
	$scope.classificationToogle = (classification) ->
		if not $scope.placeHasClassification(classification)
			$scope.classificationsAdd(classification)
		else
			$scope.classificationsDelete(classification)

	# Removes the overlays from the map, but keeps them in the array.
	$scope.clearOverlays = ->
		$scope.setAllMap(null)
	
	# Cierra todas las infowindows que están en el array $scope.infowindows
	$scope.closeAllInfowindows = ->
		angular.forEach $scope.infowindows, (infowindow, index) ->
			infowindow.close()

	# Deletes all markers in the array by removing references to them.
	$scope.deleteOverlays = ->
		$scope.clearOverlays()
		$scope.markers = []
			
	# Inicializa el mapa
	$scope.inicializar = ->
		if navigator.geolocation
			window.browserSupportFlag = on
			navigator.geolocation.getCurrentPosition (position) ->
				initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
				$scope.map.setCenter(initialLocation)
			, ->
				$scope.setLocationDefault()

	$scope.placeHasClassification = (classification) ->
		if $scope.place.classifications?
			$scope.place.classifications.some (element, index, array) ->
				element.id is classification.id

	# Se consulta al servidor por los places dentro de los límites del mapa y que cumplen las condiciones
	# de categoría e intervalo seleccionadas.
	$scope.placesUpdate = ->
		# Se verifica si hay alguna categoría seleccionada
		if $scope.classificationsSelected.length is 0
			$scope.places = []
			return
		if $scope.map.getBounds()?
			bounds = $scope.map.getBounds()
			ne = bounds.getNorthEast()
			sw = bounds.getSouthWest()
			options = "classificationsSelected": $scope.classificationsSelected
				, "placeInterval": $scope.placeInterval
				, "neLat": ne.lat()
				, "neLong": ne.lng()
				, "swLat": sw.lat()
				, "swLong": sw.lng()
			
			Place.get {params:options}, (response) ->
				$scope.places = response.places
		
	$scope.resetView = (place) ->
		console.log $('ng-view').innerHtml
		
		$location.path('/')

	# Save Location Preferences
	$scope.saveUserLocationPreferences = ->
		$scope.saveUserLocationString()
		$scope.saveUserMapCenter()
		$scope.saveUserMapTypeId()
		$scope.saveUserMapZoom()
		
		if $scope.user.id?
			$scope.user.map_lat = $scope.map.getCenter().lat()
			$scope.user.map_lng = $scope.map.getCenter().lng()
			$scope.user.map_type = $scope.map.getMapTypeId()
			$scope.user.map_zoom = $scope.map.getZoom()
			User.update {id: $scope.user.id}, $scope.user

	# Save as cookie, the user map desired center
	$scope.saveUserLocationString = ->
		$.cookie.json = true
		# expires in 30 days
		$.cookie("userLastLocationString", $scope.user.location, {expires: 30})

	# Save as cookie, the user map desired center
	$scope.saveUserMapCenter = ->
		$.cookie.json = true
		# expires in 30 days
		$.cookie("userMapCenter", {lat:$scope.map.getCenter().lat(), lng:$scope.map.getCenter().lng()}, {expires: 30})
		
	# Save as cookie, the user map desired zoom
	$scope.saveUserMapTypeId = ->
		$.cookie.json = true
		# expires in 30 days
		$.cookie("userMapTypeId", $scope.map.getMapTypeId(), {expires: 30})
		
	# Save as cookie, the user map desired zoom
	$scope.saveUserMapZoom = ->
		$.cookie.json = true
		# expires in 30 days
		$.cookie("userMapZoom", $scope.map.getZoom(), {expires: 30})

	# Search Location
	# @param location: string
	$scope.searchLocation = (location) ->
		$scope.setLocationByUserLocation(location)

	# Sets the map on all markers in the array.
	$scope.setAllMap = (map) ->
		for marker in $scope.markers
			marker.setMap(map)

	# setAddress hace la llamada al API y hace el callback
	$scope.setAddress = (event) ->
		event.preventDefault() if event?
		request = new Object() # se crea un objeto request
		request.address = $scope.place.address
		# se comenta para que busque en todo el país y no solo en el mapa que se ve
		# request.bounds = $scope.map.getBounds()
		request.region = 'AR'
		# geocode hace la conversión a un punto, y su segundo parámetro es una función de callback
		$scope.geocoder.geocode(request, $scope.addAddressToMap)

	$scope.setPlaceInterval = (interval) ->
		$scope.placeInterval = interval
	
	$scope.setLocation = ->
		$scope.map.setZoom($scope.zoomCity)
		if navigator.geolocation
			window.browserSupportFlag = on
			navigator.geolocation.getCurrentPosition (position) ->
					location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
					$scope.map.setCenter(location)
					$scope.placesUpdate()
				, ->
					$scope.errorLocation = 'Debes autorizar la captura de tu ubicación'
					$scope.setLocationDefault()
					$timeout ->
							$scope.errorLocation = null
						, 2000
		else
			$scope.errorLocation = 'Esta función no está soportada por tu navegador'

	$scope.setLocationByUserLocation = (location) ->
		request = new Object() # se crea un objeto request
		request.address = location
		# request.region = 'AR'
		# geocode hace la conversión a un punto, y su segundo parámetro es una función de callback
		$scope.geocoder.geocode(request, $scope.centerMapByUserLocation)

	# Setea una localización por defecto		
	$scope.setLocationDefault = ->
		$scope.map.setZoom($scope.zoomDefault)
		$scope.map.setCenter($scope.locationDefault)

	$scope.setUserLocationByLatLng = (location) ->
		request = {} # se crea un objeto request
		request.location = location
		# geocode hace la conversión a un punto, y su segundo parámetro es una función de callback
		$scope.geocoder.geocode request, (response, status) ->
			setUserLocationString(response[0])

	# Setea el Tipo de Mapa: RoadMap o StreetMap
	$scope.setMapType = (mapTypeId) ->
		$scope.map.setMapTypeId(mapTypeId)
		$scope.saveUserMapTypeId()
	
	# Shows any overlays currently in the array.
	$scope.showOverlays = ->
		$scope.setAllMap($scope.map)
	
	# Crea y guarda el place
	$scope.submit = ->
		# Se actualiza el mensaje
		$scope.cargando = 'Cargando.'
		
		# Se verifica que se hayan rellenado todos los datos requeridos
		if !$scope.placeForm.$valid
			# Se actualiza el mensaje
			$scope.cargando = null
			return @
		
		# Se actualiza el mensaje
		$scope.cargando = 'Cargando..'
		
		# Se verifica que se haya seleccionado al menos una categoría
		if $scope.place.classifications.length <= 0
			# Se actualiza el mensaje
			$scope.cargando = 'Error: Debe seleccionar al menos una categoría'
			return console.error 'Error: Debe seleccionar al menos una categoría'
			
		# Se actualiza el mensaje
		$scope.cargando = 'Cargando...'

		if not $scope.place.id
			# Se guarda el place
			Place.create {}
				, {Place: $scope.place, Classification: $scope.place.classifications}
				, (data) ->
					# Se actualiza el mensaje
					$scope.cargando = '¡Lugar guardado!'
					window.location.pathname = 'places'
				, ->
					# Se actualiza el mensaje
					$scope.cargando = 'Ocurrió un error guardando el place'
	
				
			# $http.post('/admin/places/add', {Place: $scope.place, Classification: $scope.place.classifications})
				# .success (data) ->
					# # Se actualiza el mensaje
					# $scope.cargando = '¡Lugar guardado!'
					# # window.location.pathname = 'places'
				# .error ->
					# # Se actualiza el mensaje
					# $scope.cargando = 'Ocurrió un error guardando el place'		
		else
			# Se actualiza
			Place.update {id: $scope.place.id}
				, {Place: $scope.place, Classification: $scope.place.classifications}
				, (data) ->
					# Se actualiza el mensaje
					$scope.cargando = '¡Lugar guardado!'
					window.location.pathname = 'admin/places'
				, ->
					# Se actualiza el mensaje
					$scope.cargando = 'Ocurrió un error guardando el place'
	
	$scope.viewDisplayed = ->
		$location.path() == '/'
	
	$scope.openModal = (URL) ->
		# console.log 'modal'
		# $scope.locatAux = "places/view/52568fd2-3de8-4911-9c4d-0cf54a46329a"
		PlaceView($scope, URL)
		
	
	# Se inicializa el mapa
	# $scope.inicializar() # Se lo quito por ahora pero debería centrar el mapa en el lugar del visitante..
	# $scope.setLocationDefault() # Se agrega esta línea para inicializar el mapa pero la idea es que inicialice con inicializar()
	
	
	### *************************************************************************************************************** 
			Funciones Auxiliares
			Aquí se escriben las funciones auxiliares
	*************************************************************************************************************** ###
	
	# findResult es usada para filtrar la ciudad, estado y pais de una respuesta de la API
	# findResult = (results, name) ->
		# result =  _.find results, (obj) ->
			# obj.types[0] is name and obj.types[1] is "political"
		# result ? result.short_name : null
	findResult = (results, name) ->
		result = results.filter (obj) ->
			obj.types[0] is name and obj.types[1] is "political"
		if result[0]? then result[0].long_name else null
	
	getPlaceColor = (place) ->
		place.Classification.color

	getPlaceIcon = (place) ->
		place.Classification.icon

	getPlaceId = (place) ->
		place.Place.id
	
	getPlaceName = (place) ->
		place.Place.name
	
	getPlaceDescription = (place) ->
		place.Place.description
	
	setUserLocationString = (location) ->
		if location? and location.address_components?
			results = location.address_components
			city = findResult(results, "locality")
			country = findResult(results, "country")
			
			if city and country
				$scope.user.location = city + ', ' + country
			else
				$scope.user.location = location.formatted_address
				
			$scope.saveUserLocationString()
		else
			$scope.user.location = $scope.user.locationAux
	
	#####################################################################################################################
	#
	# 		AUTOCOMPLETE
	#
	#####################################################################################################################
	
	$('.typeahead').typeahead({
		limit: 10,
		name: 'Address',
		remote: {
			# url: 'https://maps.googleapis.com/maps/api/geocode/json?parameters'
			url: 'https://maps.googleapis.com/maps/api/geocode/json?address=%QUERY&sensor=false'
			cache: true,
			filter: (response) ->
				results = response.results
				status = response.status
				datums = []
				
				# si la respuesta es nula
				if not results or results.length is 0 then return items
				
				for result in results
					datums.push {
						value: result.formatted_address
						location: result.geometry.location
					}
				
				$scope.setAddressToMap(datums[0])
				return datums		
		} 
	})
	.on('typeahead:selected typeahead:autocompleted', (e, datum) ->
		$scope.setAddressToMap(datum)
	)
	
	$scope.setAddressToMap = (datum) ->
		$scope.place.address = datum.value
		$scope.place.lat = datum.location.lat
		$scope.place.long = datum.location.lng
		$scope.user.location = datum.value
		
		# Center Map
		$scope.map.setCenter(datum.location)
		$scope.map.setZoom(13)
		
		# blankicono que voy a usar para mostrar el punto en el mapa
		icon = new google.maps.MarkerImage("http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png"
			, new google.maps.Size(20, 34)
			, new google.maps.Point(0, 0)
			, new google.maps.Point(10, 34)
		)
		
		if $scope.marker? then $scope.marker.setMap(null)
		
		# creo el marcador con la posición, el mapa, y el icono
		$scope.marker = new google.maps.Marker 
			'position': datum.location
			, 'map': $scope.map
			, 'icon': icon
		
		$scope.marker.setMap($scope.map) # inserto el marcador en el mapa
		
	]