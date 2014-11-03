### *******************************************************************************************************************
								EVENTOS
******************************************************************************************************************* ###
angular.module('RadarApp').controller 'EventsController'
	, ['$http', '$location', '$scope', '$rootScope', '$timeout', '$compile', 'Compliant', 'CompliantView', 'Event', 'EventView', 'Rate'
		, 'User'
			, ($http, $location, $scope, $rootScope, $timeout, $compile, Compliant, CompliantView, Event, EventView, Rate, User) ->

	### ***************************************************************************************************************
			Inicialización de Objetos
	*************************************************************************************************************** ###
	if $location.absUrl().contains('/events/edit/')
		$scope.$watch 'evento.id', (id) ->
			Event.getById {id: id}
				, (data) ->
					$scope.evento = data.event.Event
					date_start = sqlToJsDate(data.event.Event.date_start)
					date_end = sqlToJsDate(data.event.Event.date_end)
					$scope.evento.date_from = date_start
					$scope.evento.time_from = "#{date_start.getHours()}:#{date_start.getMinutes()}"
					$scope.evento.date_to = date_end
					$scope.evento.time_to = "#{date_end.getHours()}:#{date_end.getMinutes()}"
					$scope.addLatLngToMap(data.event.Event.lat, data.event.Event.long)
					
					# Se cargan las categorías del evento
					if not $scope.evento.categories then $scope.evento.categories = []
					$rootScope.$broadcast('categoriesAddBroadcast', data.event.Category)

	$scope.eventInterval = 1
	$scope.isReadonly = false
	$scope.max = 5
	$scope.user = {}
	$scope.categoriesSelected = []
	date = new Date()
	$scope.minutoEnMilisegundos = 60 * 1000
	$scope.diaEnMilisegundos = 24 * 60 * $scope.minutoEnMilisegundos
	$scope.evento = {}
	$scope.evento.categories = []
	$scope.descriptionSize = 500
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
		userLastLocationString = $.cookie('userLastLocationString')
		
		# Se sobreescriben las opciones del mapa si el usuario las tiene seteadas
		$scope.opciones.center = new google.maps.LatLng(userMapCenter.lat, userMapCenter.lng) if userMapCenter?
		$scope.opciones.mapTypeId = userMapTypeId if userMapTypeId?
		$scope.opciones.zoom = userMapZoom if userMapZoom?
		$scope.user.location = userLastLocationString if userLastLocationString?
		
		# $timeout ->
			# $scope.setUserLocationByLatLng($scope.opciones.center)
		# , 50
	
	$scope.map = new google.maps.Map(document.getElementById("map"), $scope.opciones)
	$scope.markers = []
	$scope.infowindows = []
	$scope.geocoder = new google.maps.Geocoder()
	

	### ***************************************************************************************************************
			Eventos
			Aquí se registran los eventos para los objetos de la vista
	*************************************************************************************************************** ###
	
	# Se observan las categorías seleccionadas
	$scope.$watch 'categoriesSelected.length', () ->
		$scope.eventsUpdate()		

	# Se observa el intervalo seleccionado: Hoy, Mañana ó Próximos 7 días
	$scope.$watch 'eventInterval', () ->
		$scope.eventsUpdate() 

	# Se observa el listado de eventos
	$scope.$watch 'eventos', ->
			$scope.deleteOverlays()
			angular.forEach $scope.eventos, (evento, key) ->
				latlng = new google.maps.LatLng(evento.Event.lat, evento.Event.long)
				# $scope.createMarker(evento.Event.id, evento.Event.title, evento.Category.icon, latlng)
				$scope.createMarker(evento, latlng)
			$scope.showOverlays()
		, true
	
	# Se comenta esto para hacerlo con un botón
	# Se observa cuando cambia el address y se hace la llamada al API si la longitud es superior a 3
	# $scope.$watch 'evento.address', (newValue) ->
		# $scope.setAddress(newValue) if newValue? and newValue.length > 3
	
	# Se observa cuando cambie el date_from y se setea el date_to
	$scope.$watch 'evento.date_from', (newValue) ->
		# Se setea el mínimo día de finalización y el máximo día de finalización del evento
		if newValue? and (!$scope.evento.date_to or $scope.evento.date_to.getTime() < newValue.getTime())
			$('#date_to').datepicker('setDate', newValue)
			$('#date_to').datepicker('setStartDate', newValue)
			$('#date_to').datepicker('setEndDate', new Date(newValue.getTime() + (3 * $scope.diaEnMilisegundos)))
			$scope.evento.date_to = newValue

	# Se observa cuando cambie el time_from y se setea el time_to
	$scope.$watch 'evento.time_from', (newValue) ->
		# Se setea el mínimo tiempo de finalización y el máximo tiempo de finalización del evento
		if newValue? then $scope.checkTimeTo()

	# Se observa cuando cambie el time_to y se verifica que no sea menor a time_from
	$scope.$watch 'evento.time_to', (newValue) ->
		# Se setea el mínimo tiempo de finalización y el máximo tiempo de finalización del evento
		if newValue? then $scope.checkTimeTo()
	
	# Se observa el user.location
	$scope.$watch 'user.locationAux', (location) ->
		if location? and location.length > 0
			$scope.setLocationByUserLocation(location)

	# Se crea el Listener para el clic sobre el mapa en la creación de Eventos
	google.maps.event.addListener $scope.map, 'click', (event) ->
		locations = ['events/add', 'events/edit', 'eventos/agregar', 'eventos/editar']
		if containLocations(locations)
			# se crea un objeto request
			request = new Object()
			request.location = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng())

			# geocode hace la conversión a un punto, y su segundo parámetro es una función de callback
			$scope.geocoder.geocode request, (response, status) ->
				$scope.evento.address = response[0].formatted_address
				$scope.$apply()
				$('.typeahead').val($scope.evento.address)
				$scope.addAddressToMap(response)

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
		if not response or response.length is 0 then return @ #si no pudo
		
		$scope.evento.lat = response[0].geometry.location.lat()
		$scope.evento.long = response[0].geometry.location.lng()
		
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

	$scope.addLatLngToMap = (lat, lng) ->
		location = new google.maps.LatLng(lat, lng)
		
		# Se centra el mapa.
		$scope.centerMapInLatLng(location)

		# blankicono que voy a usar para mostrar el punto en el mapa
		icon = new google.maps.MarkerImage("http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png"
			, new google.maps.Size(20, 34)
			, new google.maps.Point(0, 0)
			, new google.maps.Point(10, 34)
		)
		
		if $scope.marker? then $scope.marker.setMap(null)
		
		# creo el marcador con la posición, el mapa, y el icono
		$scope.marker = new google.maps.Marker 
			'position': location
			, 'map': $scope.map
			, 'icon': icon
		
		$scope.marker.setMap($scope.map) # inserto el marcador en el mapa
	
	# centerMapInCity: centers map with parameter location, called by setLocationByUserLocation
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
		$scope.eventsUpdate()
		# Se guardan las preferencias
		$scope.saveUserMapCenter()
		$scope.saveUserMapZoom()
		
	$scope.centerMapInLatLng = (location, zoom = 13) ->
		$scope.map.setCenter(location)
		$scope.map.setZoom(13)

	# A function to create the marker and set up the evento window function
	# $scope.createMarker = (eventId, eventTitle, categoriesSelected, latlng) ->
	$scope.createMarker = (evento, latlng) ->
		# icon = new google.maps.MarkerImage("http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png"
		icon = new google.maps.MarkerImage('/img/map-marker/' + getEventCategoryIcon(evento)
			#, new google.maps.Size(25, 26)
			, new google.maps.Size(30, 40)
			, new google.maps.Point(0, 0)
			, new google.maps.Point(10, 34)
		)
		
		marker = new google.maps.Marker eventId: getEventId(evento)
			, map: $scope.map
			, icon: icon
			, position: latlng
			, title: getEventTitle(evento)
			, zIndex: Math.round(latlng.lat()*-100000)<<5
		
		# $scope.eventMarkerAux = evento
# 			
		# contenido = $compile('<marker evento="eventMarkerAux"></marker>')($scope)
		# console.log contenido
		# console.log contenido[0]
		# console.log contenido[0].textContent
		# console.log contenido[0].innerHTML
		
		contenido = '<div>'
		contenido += '<p>' + getEventTitle(evento) + '</p>'
		# contenido += '<a href="/events/view/' + getEventId(evento) + '">'
		contenido += '<a ng-click="openModal(\'events/view/' + getEventId(evento) + '\')">'
		contenido += '<p class="text-right"><i class="icon-expand-alt"></i> info</p>'
		contenido += '</a>'
		contenido += '</div>'
		contenido = $compile(contenido)($scope)
		# if getEventDescription(evento) then contenido += '<p>' + getEventDescription(evento) + '</p>'
		# if getEventDescription(evento) 
			# contenido += '<p>' + getEventDescription(evento) + '</p>'
		# else 
			# contenido += '<p>No description</p>'
		
		infowindow = new google.maps.InfoWindow {
			# content: contenido  
			content: contenido[0]
		}
		
		# Se agrega el listener del marker sobre el evento click 
		google.maps.event.addListener marker, 'click', ->
			$scope.closeAllInfowindows()
			infowindow.open($scope.map, marker)
		
		$scope.infowindows.push(infowindow)
		$scope.markers.push(marker)


	$scope.checkDescriptionSize = (event, evento) ->
		if evento.description?
			if +$scope.descriptionSize - evento.description.length < 0
				evento.description = evento.description.substr(0, 500)
				event.preventDefault()

	$scope.checkTimeTo = ->
		# Se setea el mínimo tiempo de finalización y el máximo tiempo de finalización del evento
		if $scope.evento.time_from?
			# Si las fechas de inicio y fin coinciden, el tiempo de inicio y finalización debería distar al menos
			# 15 (quince) minutos.
			if $scope.evento.date_from is $scope.evento.date_to
				dateFrom = $scope.evento.date_from
				dateTo = $scope.evento.date_to
				timeFrom = ($scope.evento.time_from).split(':')
				dateStart = new Date(dateFrom.getFullYear(), dateFrom.getMonth(), dateFrom.getDate(), timeFrom[0], timeFrom[1])
				dateEnd = new Date(dateStart.getTime() + (15 * $scope.minutoEnMilisegundos))
				
				# Si está vacío el time_to se autocompleta con una diferencia de 15 minutos
				# si contiene algo, se verifica que la diferencia sea 15 minutos, sino se ajusta.
				if !$scope.evento.time_to?
					$scope.evento.time_to = dateEnd.getHours() + ':' + dateEnd.getMinutes()
				else
					timeTo = ($scope.evento.time_to).split(':') 
					dateEndAux = new Date(dateTo.getFullYear(), dateTo.getMonth(), dateTo.getDate(), timeTo[0], timeTo[1])
					
					# Se compara la dateEnd que debería ser con la dateEnd que es
					# si la dateEnd que debería ser (15 minutos mayor a la dateStart), es mayor a la dateEnd calculada
					# (dateEndAux), entonces se sobreescribe con la dateEnd que debería ser para respetar los 
					# 15 minutos de diferencia. 
					if dateEnd.getTime() > dateEndAux.getTime()
						$scope.evento.time_to = dateEnd.getHours() + ':' + dateEnd.getMinutes()
						# Ajuste de minutos cuando es cero
						if dateEnd.getMinutes() is 0 then $scope.evento.time_to += '0'
		
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

	$scope.categoriesAdd = (category) ->
		if($scope.evento.categories.length < 3)
			$scope.evento.categories.push(category.Category.id)
			category.highlight = true
			category.checkbox = true

	$scope.categoriesDelete = (category) ->
		index = $scope.evento.categories.indexOf(category.Category.id)
		if index >= 0 
			$scope.evento.categories.splice(index, 1)
			category.highlight = false
			category.checkbox = false

	$scope.denounce = (evento) ->
		# Se verifica que el usuario esté registrado
		if $scope.user.id? and evento.Compliant? and evento.Compliant.title?
				Compliant.create evento
				CompliantView.close()

	# Se consulta al servidor por los eventos dentro de los límites del mapa y que cumplen las condiciones
	# de categoría e intervalo seleccionadas.
	$scope.eventsUpdate = ->
		# Se verifica si hay alguna categoría seleccionada
		if $scope.categoriesSelected.length is 0
			$scope.eventos = []
			return
		# Se verifica que no se obtengan los eventos en la pantalla de agregar evento.
		if not $location.absUrl().contains('events/add') and $scope.map.getBounds()?
			bounds = $scope.map.getBounds()
			ne = bounds.getNorthEast()
			sw = bounds.getSouthWest()
			options = "categoriesSelected": $scope.categoriesSelected
				, "eventInterval": $scope.eventInterval
				, "neLat": ne.lat()
				, "neLong": ne.lng()
				, "swLat": sw.lat()
				, "swLong": sw.lng()
			
			
			Event.get {params:options}, (response) ->
				$scope.eventos = response.events

	# Inicializa el mapa
	$scope.inicializar = ->
		if navigator.geolocation
			window.browserSupportFlag = on
			navigator.geolocation.getCurrentPosition (position) ->
				initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
				$scope.map.setCenter(initialLocation)
			, ->
				$scope.setLocationDefault()

	$scope.resetView = (evento) ->
		$location.path('/')

	$scope.saveRatingToServer = (evento, newRating) ->
		evento.Event.rate = +evento.Event.rate + newRating
		evento.Rate.rate = newRating
		evento.Rate.user_id = $scope.user.id if newRating > 0 
		evento.Rate.user_id = false if newRating < 0
		 
		Rate.create evento

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
		request.address = $scope.evento.address
		
		# se comenta para que busque en todo el país y no solo en el mapa que se ve
		# request.bounds = $scope.map.getBounds()
		# request.region = 'AR'
		
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
		if $scope.evento.categories.length <= 0
			# Se actualiza el mensaje
			$scope.cargando = 'Error: Debe seleccionar al menos una categoría'
			return console.error 'Error: Debe seleccionar al menos una categoría'
			
		# Se actualiza el mensaje
		$scope.cargando = 'Cargando...'

		# Se guarda el evento
		# $http.post('/events/add', {Event: $scope.evento, Category: $scope.evento.categories})
			# .success (data) ->
				# # Se actualiza el mensaje
				# $scope.cargando = '¡Evento guardado!'
				# # window.location.pathname = 'events'
			# .error ->
				# # Se actualiza el mensaje
				# $scope.cargando = 'Ocurrió un error guardando el evento'		
		# Event.save {}
		# 	, {Event: $scope.evento, Category: $scope.evento.categories}
		# 	, (data) ->
		# 		# Se actualiza el mensaje
		# 		$scope.cargando = '¡Evento guardado!'
		# 		window.location.pathname = 'events'
		# 	, ->
		# 		# Se actualiza el mensaje
		# 		$scope.cargando = 'Ocurrió un error guardando el evento'

		$('#eventForm').submit()
	
	$scope.viewDisplayed = ->
		$location.path() == '/'
	
	$scope.openModal = (URL) ->
		EventView($scope, URL)
	
	$scope.openCompliantModal = (evento) ->
		CompliantView.show($scope, evento)
		
	
	# Se inicializa el mapa
	# $scope.inicializar() # Se lo quito por ahora pero debería centrar el mapa en el lugar del visitante..
	# $scope.setLocationDefault() # Se agrega esta línea para inicializar el mapa pero la idea es que inicialice con inicializar()
	
	
	### *************************************************************************************************************** 
			Funciones Auxiliares
			Aquí se escriben las funciones auxiliares
	*************************************************************************************************************** ###
	containLocations = (locations = null) ->
		containURL = false
		angular.forEach locations, (url, index) ->
			if not containURL then containURL = $location.absUrl().contains(url)
		containURL

	# findResult es usada para filtrar la ciudad, estado y pais de una respuesta de la API
	# findResult = (results, name) ->
		# result =  _.find results, (obj) ->
			# obj.types[0] is name and obj.types[1] is "political"
		# result ? result.short_name : null
	findResult = (results, name) ->
		result = results.filter (obj) ->
			obj.types[0] is name and obj.types[1] is "political"
		if result[0]? then result[0].long_name else null
	
	getEventCategoryIcon = (evento) ->
		evento.Category.icon
	
	getEventId = (evento) ->
		evento.Event.id
	
	getEventTitle = (evento) ->
		evento.Event.title
	
	getEventDescription = (evento) ->
		evento.Event.description
	
	setUserLocationString = (location) ->
		if location? and location.address_components?
			results = location.address_components
			city = findResult(results, "locality")
			country = findResult(results, "country")
			
			if city and country
				$scope.user.location = city + ', ' + country
			else
				$scope.user.location = location.formatted_address
				
			# Se setea el input de búsqueda
			$scope.locationSearched = $scope.user.location
				
			$scope.saveUserLocationString()
		else
			$scope.user.location = $scope.user.locationAux
	
	sqlToJsDate = (sqlDate) ->
		# sqlDate in SQL DATETIME format ("yyyy-mm-dd hh:mm:ss.ms")
		sqlDateArr1 = sqlDate.split("-")
		# format of sqlDateArr1[] = ['yyyy','mm','dd hh:mm:ms']
		sYear = sqlDateArr1[0]
		sMonth = (Number(sqlDateArr1[1]) - 1).toString()
		sqlDateArr2 = sqlDateArr1[2].split(" ")
		# format of sqlDateArr2[] = ['dd', 'hh:mm:ss.ms']
		sDay = sqlDateArr2[0]
		sqlDateArr3 = sqlDateArr2[1].split(":")
		# format of sqlDateArr3[] = ['hh','mm','ss.ms']
		sHour = sqlDateArr3[0]
		sMinute = sqlDateArr3[1]
		sqlDateArr4 = sqlDateArr3[2].split(".")
		# format of sqlDateArr4[] = ['ss','ms']
		sSecond = sqlDateArr4[0]
		# sMillisecond = sqlDateArr4[1]

		# new Date(sYear,sMonth,sDay,sHour,sMinute,sSecond,sMillisecond)
		new Date(sYear, sMonth, sDay, sHour, sMinute, sSecond)

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
		$scope.evento.address = datum.value
		$scope.evento.lat = datum.location.lat
		$scope.evento.long = datum.location.lng
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