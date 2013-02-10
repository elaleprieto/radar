jQuery ->
	###
	Variables Globales
	###
	# vacío
	window.capital = new google.maps.LatLng(-34.603, -58.382)
	window.santafe = new google.maps.LatLng(-31.625906,-60.696774)

	###
	Inicialización de Objetos
	###
	opciones = {zoom: 13, center: window.capital, mapTypeId: google.maps.MapTypeId.ROADMAP}
	window.map = new google.maps.Map(document.getElementById("map"), opciones)
	
	###
	Eventos
	Aquí se registran los eventos para los objetos de la vista
	###
	inicializar()

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
