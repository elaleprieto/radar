jQuery ->
	###
	Variables Globales
	###
	# vacío
	window.capital = new google.maps.LatLng(-34.603, -58.382)
	window.santafe = new google.maps.LatLng(-31.625906,-60.696774)
	window.eventsListBody =  $('#eventsList tbody')

	###
	Inicialización de Objetos
	###
	window.eventCategory = []
	window.eventInterval = 1
	opciones = {zoom: 13, center: window.santafe, mapTypeId: google.maps.MapTypeId.ROADMAP}
	window.map = new google.maps.Map(document.getElementById("map"), opciones)
	window.markers = []
	
	
	###
	Eventos
	Aquí se registran los eventos para los objetos de la vista
	###
	inicializar()
	$('#eventInterval > button').on 'click', () ->
		 window.eventInterval = $(@).val()
		 deleteOverlays()
		 actualizarEventos()

	$('#eventCategories').find('input[id*="Category"]').on 'click', () ->
		window.eventCategory = []
		for category in $('#eventCategories').find('input:checked')
			window.eventCategory.push($(category).val())
		deleteOverlays()
		actualizarEventos()
	
	# google.maps.event.addListener window.map, 'bounds_changed', () ->
	google.maps.event.addListener window.map, 'dragend', () ->
		actualizarEventos()

	google.maps.event.addListener window.map, 'tilesloaded', () ->
		actualizarEventos()

	google.maps.event.addListener window.map, 'zoom_changed', () ->
		actualizarEventos()
		
###
Funciones
Aquí se escriben las funciones
###
inicializar = ->
	if navigator.geolocation
		window.browserSupportFlag = on
		navigator.geolocation.getCurrentPosition (position) ->
			initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
			window.map.setCenter(initialLocation)
		, ->
			noGeolocalizacion()

noGeolocalizacion = ->
	initialLocation = window.santafe
	window.map.setCenter(initialLocation)

	if window.browserSupportFlag is on
		alert "El servicio de geolocalización falló. Iniciamos desde Santa Fe."
	else
		alert "Tu navegador no soporta geolocalización. Iniciamos desde Santa Fe."

actualizarEventos = () ->
	bounds = window.map.getBounds()
	ne = bounds.getNorthEast()
	sw = bounds.getSouthWest()
	options = {"eventCategory": window.eventCategory, "eventInterval": window.eventInterval, "neLat": ne.lat(), "neLong": ne.lng(), "swLat": sw.lat(), "swLong": sw.lng()}
	
	$.getJSON(WEBROOT + 'events/get', options, (data) ->
		clearEventsList()
		for event in data
			exist = off
			for marker in window.markers
				exist = on if marker.eventId == event.Event.id
			if not exist
				createMarker(event.Event.id, event.Event.title, new google.maps.LatLng(event.Event.lat, event.Event.long)) 
				addEventToList(event.Event.date_start, event.Event.date_end, event.Event.title)
	)

# Remove all events from events table
clearEventsList = () ->
	window.eventsListBody.html('')
	
# Removes the overlays from the map, but keeps them in the array.
clearOverlays = () ->
	setAllMap(null)

# A function to create the marker and set up the event window function
createMarker = (eventId, eventTitle, latlng) ->
	marker = new google.maps.Marker({
		eventId: eventId,
		title: eventTitle,
		position: latlng,
		map: window.map,
		zIndex: Math.round(latlng.lat()*-100000)<<5
	})
	window.markers.push(marker)
	
# Deletes all markers in the array by removing references to them.
deleteOverlays = () ->
	clearOverlays()
	window.markers = []
	
# Sets the map on all markers in the array.
setAllMap = (map) ->
	for marker in window.markers
		marker.setMap(map)

# Shows any overlays currently in the array.
showOverlays = () ->
	setAllMap(map)

# Add event to events table
addEventToList = (date_start, date_end, title) ->
	row = $('<tr></tr>')
	row.append $('<td></td>').text(date_start)
	row.append $('<td></td>').text(date_end)
	row.append $('<td></td>').text(title)
	window.eventsListBody.append row
	
	
	
	
