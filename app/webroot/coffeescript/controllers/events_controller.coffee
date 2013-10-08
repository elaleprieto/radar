### *******************************************************************************************************************
								EVENTOS
******************************************************************************************************************* ###

angular.module('RadarApp').controller 'EventsController'
	, ['$http', '$scope', '$timeout'
		, ($http, $scope, $timeout) ->

	### ***************************************************************************************************************
			Inicialización de Objetos
	*************************************************************************************************************** ###
	$scope.eventInterval = 1
	$scope.user = {}
	$scope.eventCategory = []
	date = new Date()
	$scope.minutoEnMilisegundos = 60 * 1000
	$scope.diaEnMilisegundos = 24 * 60 * $scope.minutoEnMilisegundos
	$scope.event = {}
	$scope.event.categories = []

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
	$scope.opciones = center: $scope.locationDefault
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
		
		# Se sobreescriben las opciones del mapa si el usuario las tiene seteadas
		$scope.opciones.center = new google.maps.LatLng(userMapCenter.lat, userMapCenter.lng) if userMapCenter?
		$scope.opciones.mapTypeId = userMapTypeId if userMapTypeId?
		$scope.opciones.zoom = userMapZoom if userMapZoom?
	
	$scope.map = new google.maps.Map(document.getElementById("map"), $scope.opciones)
	$scope.markers = []
	$scope.geocoder = new google.maps.Geocoder()
	

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
	$scope.$watch 'eventos', ->
			$scope.deleteOverlays()
			angular.forEach $scope.eventos, (event, key) ->
				latlng = new google.maps.LatLng(event.Event.lat, event.Event.long)
				$scope.createMarker(event.Event.id, event.Event.title, event.Category.icon, latlng)
			$scope.showOverlays()
		, true
	
	# Se comenta esto para hacerlo con un botón
	# Se observa cuando cambia el address y se hace la llamada al API si la longitud es superior a 3
	# $scope.$watch 'event.address', (newValue) ->
		# $scope.setAddress(newValue) if newValue? and newValue.length > 3
	
	# Se observa cuando cambie el date_from y se setea el date_to
	$scope.$watch 'event.date_from', (newValue) ->
		# Se setea el mínimo día de finalización y el máximo día de finalización del evento
		if newValue?
			$('#date_to').datepicker('setDate', newValue)
			$('#date_to').datepicker('setStartDate', newValue)
			$('#date_to').datepicker('setEndDate', new Date(newValue.getTime() + (3 * $scope.diaEnMilisegundos)))
			$scope.event.date_to = newValue

	# Se observa cuando cambie el time_from y se setea el time_to
	$scope.$watch 'event.time_from', (newValue) ->
		# Se setea el mínimo tiempo de finalización y el máximo tiempo de finalización del evento
		if newValue? then $scope.checkTimeTo()

	# Se observa cuando cambie el time_to y se verifica que no sea menor a time_from
	$scope.$watch 'event.time_to', (newValue) ->
		# Se setea el mínimo tiempo de finalización y el máximo tiempo de finalización del evento
		if newValue? then $scope.checkTimeTo()
	
	# Se observa el user.location
	$scope.$watch 'user.location', (location) ->
		if not userMapCenter? and location? and location.length > 0
			$scope.setLocationByUserLocation(location)

	# # google.maps.event.addListener window.map, 'bounds_changed', () ->
	google.maps.event.addListener $scope.map, 'dragend', () ->
		$scope.eventsUpdate()
		$scope.saveUserMapCenter()

	google.maps.event.addListener $scope.map, 'tilesloaded', () ->
		$scope.eventsUpdate()

	google.maps.event.addListener $scope.map, 'zoom_changed', () ->
		$scope.eventsUpdate()
		$scope.saveUserMapZoom()

	google.maps.event.addListener $scope.map, 'position_changed', () ->
		$scope.eventsUpdate()

	
	### *************************************************************************************************************** 
			Funciones
			Aquí se escriben las funciones
	*************************************************************************************************************** ###
	
	$scope.addAddressToMap = (response, status) ->
		if !response or response.length is 0 then return @ #si no pudo
		
		$scope.event.lat = response[0].geometry.location.lat()
		$scope.event.long = response[0].geometry.location.lng()
		
		# Center Map
		$scope.map.setCenter(response[0].geometry.location)
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
			'position': response[0].geometry.location
			, 'map': $scope.map
			, 'icon': icon
		
		$scope.marker.setMap($scope.map) # inserto el marcador en el mapa
	
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
		# Se guardan las preferencias
		$scope.saveUserMapCenter()
		$scope.saveUserMapZoom()
		
	
	# centerMap: centers map with parameter location, called by setLocationByUserLocation
	$scope.centerMapByUserLocation = (response, status) ->
		if response[0]? and response[0].geometry? and response[0].geometry.location?
			# Center Map
			$scope.map.setCenter(response[0].geometry.location)
			$scope.map.setZoom($scope.zoomCity)


	# A function to create the marker and set up the event window function
	$scope.createMarker = (eventId, eventTitle, eventCategory, latlng) ->
		# icon = new google.maps.MarkerImage("http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png"
		icon = new google.maps.MarkerImage('/img/categorias/' + eventCategory
			, new google.maps.Size(25, 26)
			, new google.maps.Point(0, 0)
			, new google.maps.Point(10, 34)
		)
		
		marker = new google.maps.Marker eventId: eventId
			, map: $scope.map
			, icon: icon
			, position: latlng
			, title: eventTitle
			, zIndex: Math.round(latlng.lat()*-100000)<<5
		$scope.markers.push(marker)

	$scope.checkTimeTo = ->
		# Se setea el mínimo tiempo de finalización y el máximo tiempo de finalización del evento
		if $scope.event.time_from?
			# Si las fechas de inicio y fin coinciden, el tiempo de inicio y finalización debería distar al menos
			# 15 (quince) minutos.
			if $scope.event.date_from is $scope.event.date_to
				dateFrom = $scope.event.date_from
				dateTo = $scope.event.date_to
				timeFrom = ($scope.event.time_from).split(':')
				dateStart = new Date(dateFrom.getFullYear(), dateFrom.getMonth(), dateFrom.getDate(), timeFrom[0], timeFrom[1])
				dateEnd = new Date(dateStart.getTime() + (15 * $scope.minutoEnMilisegundos))
				
				# Si está vacío el time_to se autocompleta con una diferencia de 15 minutos
				# si contiene algo, se verifica que la diferencia sea 15 minutos, sino se ajusta.
				if !$scope.event.time_to?
					$scope.event.time_to = dateEnd.getHours() + ':' + dateEnd.getMinutes()
				else
					timeTo = ($scope.event.time_to).split(':') 
					dateEndAux = new Date(dateTo.getFullYear(), dateTo.getMonth(), dateTo.getDate(), timeTo[0], timeTo[1])
					
					# Se compara la dateEnd que debería ser con la dateEnd que es
					# si la dateEnd que debería ser (15 minutos mayor a la dateStart), es mayor a la dateEnd calculada
					# (dateEndAux), entonces se sobreescribe con la dateEnd que debería ser para respetar los 
					# 15 minutos de diferencia. 
					if dateEnd.getTime() > dateEndAux.getTime()
						$scope.event.time_to = dateEnd.getHours() + ':' + dateEnd.getMinutes()
						# Ajuste de minutos cuando es cero
						if dateEnd.getMinutes() is 0 then $scope.event.time_to += '0'
		
	# Removes the overlays from the map, but keeps them in the array.
	$scope.clearOverlays = ->
		$scope.setAllMap(null)
	
	# Deletes all markers in the array by removing references to them.
	$scope.deleteOverlays = ->
		$scope.clearOverlays()
		$scope.markers = []

	$scope.eventCategoriesAdd = (category) ->
		if($scope.event.categories.length < 3)
			$scope.event.categories.push(category.Category.id)
			category.highlight = true

	$scope.eventCategoriesDelete = (category) ->
		index = $scope.event.categories.indexOf(category.Category.id)
		if index >= 0 
			$scope.event.categories.splice(index, 1)
			category.highlight = false

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
			
			$http.get('/events/get', {cache: true, params: options})
				.success (data) ->
					$scope.eventos = data

	# Inicializa el mapa
	$scope.inicializar = ->
		if navigator.geolocation
			window.browserSupportFlag = on
			navigator.geolocation.getCurrentPosition (position) ->
				initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
				$scope.map.setCenter(initialLocation)
			, ->
				$scope.setLocationDefault()

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

	# Sets the map on all markers in the array.
	$scope.setAllMap = (map) ->
		for marker in $scope.markers
			marker.setMap(map)

	# setAddress hace la llamada al API y hace el callback
	$scope.setAddress = () ->
		request = new Object() # se crea un objeto request
		request.address = $scope.event.address
		# se comenta para que busque en todo el país y no solo en el mapa que se ve
		# request.bounds = $scope.map.getBounds()
		request.region = 'AR'
		# geocode hace la conversión a un punto, y su segundo parámetro es una función de callback
		$scope.geocoder.geocode(request, $scope.addAddressToMap)

	$scope.setEventInterval = (interval) ->
		$scope.eventInterval = interval
	
	$scope.setLocation = ->
		$scope.map.setZoom($scope.zoomCity)
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
	
	# Setea el Tipo de Mapa: RoadMap o StreetMap
	$scope.setMapType = (mapTypeId) ->
		$scope.map.setMapTypeId(mapTypeId)
		$scope.saveUserMapTypeId()
	
	# Shows any overlays currently in the array.
	$scope.showOverlays = ->
		$scope.setAllMap($scope.map)
	
	# Crea y guarda el evento
	$scope.submit = ->
		# Se actualiza el mensaje
		$scope.cargando = 'Cargando.'
		
		# Se verifica que se hayan rellenado todos los datos requeridos
		if !$scope.eventForm.$valid
			# Se actualiza el mensaje
			$scope.cargando = null
			return @
		
		# Se actualiza el mensaje
		$scope.cargando = 'Cargando..'
		
		# Se verifica que se haya seleccionado al menos una categoría
		if $scope.event.categories.length <= 0
			# Se actualiza el mensaje
			$scope.cargando = 'Error: Debe seleccionar al menos una categoría'
			return console.error 'Error: Debe seleccionar al menos una categoría'
			
		# Se actualiza el mensaje
		$scope.cargando = 'Cargando...'

		# Se guarda el evento
		$http.post('/events/add', {Event: $scope.event, Category: $scope.event.categories})
			.success (data) ->
				# Se actualiza el mensaje
				$scope.cargando = '¡Evento guardado!'
				console.log 'Evento guardado'
				window.location.pathname = 'events'
			.error ->
				# Se actualiza el mensaje
				$scope.cargando = 'Ocurrió un error guardando el evento'
				console.log 'Ocurrió un error guardando el evento'
	
	# Se inicializa el mapa
	# $scope.inicializar() # Se lo quito por ahora pero debería centrar el mapa en el lugar del visitante..
	# $scope.setLocationDefault() # Se agrega esta línea para inicializar el mapa pero la idea es que inicialice con inicializar()	
	]