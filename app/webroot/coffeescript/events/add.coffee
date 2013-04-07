jQuery ->
	###
	Variables Globales
	###
	diaEnMilisegundos = 24 * 60 * 60 * 1000
	window.alertMessageDisplayed = off
	window.capital = new google.maps.LatLng(-34.603, -58.382)
	window.santafe = new google.maps.LatLng(-31.625906,-60.696774)


	###
	Inicialización de Objetos
	###
	opciones = {zoom: 13, center: window.santafe, mapTypeId: google.maps.MapTypeId.ROADMAP}
	window.map = new google.maps.Map(document.getElementById("map"), opciones)

	###
	Eventos
	Aquí se registran los eventos para los objetos de la vista
	###
	inicializar()

	# google.maps.event.addListener(map, 'click', function( event ){
		# alert( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng() ); 
	# });
	google.maps.event.addListener window.map, 'click', (event) ->
		# console.info("Latitude: " + event.latLng.lat() + " " + ", longitude: " + event.latLng.lng())
		$('#EventLat').val(event.latLng.lat())
		$('#EventLong').val(event.latLng.lng())
		
		# call function to create marker
		if(window.marker)
			window.marker.setMap(null);
			window.marker = null;
		window.marker = createMarker(event.latLng);
		
	###
		date pickers
	###
	# Regional
	$.datepicker.setDefaults($.datepicker.regional["es"])
	
	$("#from").datepicker(
		defaultDate: null
		changeMonth: true
		minDate: "0d"
		onClose: (selectedDate) ->
			$("#to").datepicker("option", "minDate", selectedDate)
			maxDay = new Date($("#from").datepicker("getDate").getTime() + (3 * diaEnMilisegundos))
			$("#to").datepicker("option", "maxDate", maxDay)
	)

	$("#to").datepicker(
		defaultDate: null
		changeMonth: true
		# numberOfMonths: 3
		# onClose: (selectedDate) ->
			# $("#from").datepicker("option", "maxDate", selectedDate)
	)

	###
	 time pickers
	###
	# Use default settings
	$("#time3, #time4").timePicker()
	
	# Store time used by duration.
	oldTime = $.timePicker("#time3").getTime()

	# Keep the duration between the two inputs.
	$("#time3").on 'change', () ->
		if $("#time4").val() # Only update when second input has a value.
			# Calculate duration.
			duration = ($.timePicker("#time4").getTime() - oldTime)
			time = $.timePicker("#time3").getTime()
			# Se resetea el time3 por si escribieron una hora que no es válida
			# $("#time3").value = $.timePicker.formatTime(timeToDate(time, settings), settings);
			# Calculate and update the time in the second input.
			$.timePicker("#time4").setTime(new Date(new Date(time.getTime() + duration)))
			oldTime = time

	$("#time3, #time4").on 'blur', () ->
		time = $.timePicker(@).getTime()
	# Se resetea el time por si escribieron una hora que no es válida
		$.timePicker(@).setTime(new Date(new Date(time.getTime())))

	# Validate.
	$("#time4").on 'change', () ->
		 # time = $.timePicker("#time4").getTime()
			# # Se resetea el time4 por si escribieron una hora que no es válida
			# $.timePicker("#time4").setTime(new Date(new Date(time.getTime())))
		if $.timePicker("#time3").getTime() > $.timePicker(this).getTime()
			$(this).parent().addClass("error")
		else
			$(this).parent().removeClass("error")

	###
		Categories
	###
	categoriesCheckbox = $('#categoriesSelect').find('input[type="checkbox"]')
	$(categoriesCheckbox).on 'click', (event) ->
		if categoriesCheckedCount() > 3
			event.preventDefault()
			showAlertMessage()
			return false

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

# A function to create the marker and set up the event window function
createMarker = (latlng) ->
	marker = new google.maps.Marker({
		position: latlng,
		map: window.map,
		zIndex: Math.round(latlng.lat()*-100000)<<5
	})

# Calculate Categories Checked Count
categoriesCheckedCount = () ->
	 return $('#categoriesSelect').find('input:checked').length
	 
showAlertMessage = () ->
	if window.alertMessageDisplayed is off
		window.alertMessageDisplayed = on
		$('#alertMessage').fadeIn('slow').delay(5000).fadeOut('slow', () ->
			window.alertMessageDisplayed = off
			)
