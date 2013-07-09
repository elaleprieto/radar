'use strict'

RadarApp = angular.module('RadarApp', ['$strap.directives'])


RadarApp.value('$strapConfig', {
	datepicker: {
		language: 'es',
		# format: 'M d, yyyy'
	}
})


### *******************************************************************************************************************
								CATEGORIAS
******************************************************************************************************************* ###
RadarApp.controller 'CategoriaController', ($scope, $http) ->
	$http.get('/categories ', {cache: true})
			.success (data) ->
				$scope.categorias = data
					
	$scope.show = (category) ->
		if not category.highlight
			$scope.$parent.eventCategoriesAdd(category)
		else
			$scope.$parent.eventCategoriesDelete(category)


### *******************************************************************************************************************
								EVENTOS
******************************************************************************************************************* ###
RadarApp.controller 'EventController', ($scope, $http) ->
	date = new Date()
	$scope.minutoEnMilisegundos = 60 * 1000
	$scope.diaEnMilisegundos = 24 * 60 * $scope.minutoEnMilisegundos
	$scope.event = {}
	$scope.santafe = new google.maps.LatLng(-31.625906,-60.696774)
	$scope.opciones = {zoom: 13, center: $scope.santafe, mapTypeId: google.maps.MapTypeId.ROADMAP}
	$scope.map = new google.maps.Map(document.getElementById("map"), $scope.opciones)
	# $scope.event.date_from = "0000-00-01T00:00:00.000Z"
	# $scope.event.date_to = "0000-00-01T00:00:00.000Z"
	# $scope.event.time_from = date.getHours()-1 + ":00"
	# $scope.event.time_to = (+date.getHours() + 1) + ":00"
	$scope.event.categories = []
	
	$scope.eventCategoriesAdd = (category) ->
		if($scope.event.categories.length < 3)
			$scope.event.categories.push(category.Category.id)
			category.highlight = true

	$scope.eventCategoriesDelete = (category) ->
		index = $scope.event.categories.indexOf(category.Category.id)
		if index >= 0 
			$scope.event.categories.splice(index, 1)
			category.highlight = false

	$scope.inicializar = ->
		if navigator.geolocation
			window.browserSupportFlag = on
			navigator.geolocation.getCurrentPosition (position) ->
				initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
				$scope.map.setCenter(initialLocation)
			, ->
				$scope.noGeolocalizacion()

	$scope.noGeolocalizacion = ->
		initialLocation = $scope.santafe
		$scope.map.setCenter(initialLocation)
		if window.browserSupportFlag is on
			console.log "El servicio de geolocalización falló. Iniciamos desde Santa Fe."
		else
			console.log "Tu navegador no soporta geolocalización. Iniciamos desde Santa Fe."	
		
	$scope.submit = ->
		# Se verifica que se hayan rellenado todos los datos requeridos
		if !$scope.eventForm.$valid
			return @
		
		# Se verifica que se haya seleccionado al menos una categoría
		if $scope.event.categories.length <= 0
			return console.error 'Error: Debe seleccionar al menos una categoría'
			
		# Se guarda el evento
		$http.post('/events/add', {Event: $scope.event, Category: $scope.event.categories})
			.success (data) ->
				console.log 'Evento guardado'
			.error ->
				console.log 'Ocurrió un error guardando el evento'
		
	$scope.geocoder = new google.maps.Geocoder()
	
	$scope.addAddressToMap = (response, status) ->
		if !response or response.length is 0 then return @ #si no pudo
		
		$scope.event.lat = response[0].geometry.location.lat()
		$scope.event.long = response[0].geometry.location.lng()
		
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
	
	# setAddress hace la llamada al API y hace el callback
	$scope.setAddress = (address) ->
		request = new Object() # se crea un objeto request
		request.address = address
		request.bounds = $scope.map.getBounds()
		request.region = 'AR'
		# geocode hace la conversión a un punto, y su segundo parámetro es una función de callback
		$scope.geocoder.geocode(request, $scope.addAddressToMap)
	

	# Se observa cuando cambia el address y se hace la llamada al API si la longitud es superior a 3
	$scope.$watch 'event.address', (newValue) ->
		$scope.setAddress(newValue) if newValue? and newValue.length > 3
	
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
		
	
# 
# jQuery ->
	# ###
	# Variables Globales
	# ###
	# diaEnMilisegundos = 24 * 60 * 60 * 1000
	# window.alertMessageDisplayed = off
	# window.capital = new google.maps.LatLng(-34.603, -58.382)
# 
# 
	# ###
	# Inicialización de Objetos
	# ###
# 
	# ###
	# Eventos
	# Aquí se registran los eventos para los objetos de la vista
	# ###
	# # inicializar()
# 
	# # google.maps.event.addListener(map, 'click', function( event ){
		# # alert( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng() ); 
	# # });
	# # google.maps.event.addListener window.map, 'click', (event) ->
		# # # console.info("Latitude: " + event.latLng.lat() + " " + ", longitude: " + event.latLng.lng())
		# # $('#EventLat').val(event.latLng.lat())
		# # $('#EventLong').val(event.latLng.lng())
# # 		
		# # # call function to create marker
		# # if(window.marker)
			# # window.marker.setMap(null);
			# # window.marker = null;
		# # window.marker = createMarker(event.latLng);
# 		
	# ###
		# date pickers
	# ###
	# # Regional
	# # $.datepicker.setDefaults($.datepicker.regional["es"])
# 	
	# # $("#from").datepicker(
		# # defaultDate: null
		# # changeMonth: true
		# # minDate: "0d"
		# # onClose: (selectedDate) ->
			# # $("#to").datepicker("option", "minDate", selectedDate)
			# # maxDay = new Date($("#from").datepicker("getDate").getTime() + (3 * diaEnMilisegundos))
			# # $(value"#to").datepicker("option", "maxDate", maxDay)
	# # )
# # 
	# # $("#to").datepicker(
		# # defaultDate: null
		# # changeMonth: true
		# # # numberOfMonths: 3
		# # # onClose: (selectedDate) ->
			# # # $("#from").datepicker("option", "maxDate", selectedDate)
	# # )
# 
	###
	 time pickers
	###
	# $('#time_from').on 'show.timepicker', (e) =>
		# # $scope.oldTime.hour = e.time.hours
		# $scope.event.oldTime = e.time.value
		# console.log('The time is ' + e.time.value)
		# console.log('The time is ' , $scope.event.oldTime)
# 
	# $('#time_to').on 'changeTime.timepicker', (e) ->
		# # $scope.oldTime.hour = e.time.hours
		# console.log('The time is ' + e.time.hours)
		# $scope.event.timeTo = e.time.value
# 	
# 	
	# $('#time_from').on 'hide.timepicker', (e) ->
		# console.log 'trigger', e
		# # console.log this.getTime()
		# duration = +"14:30" - +$scope.event.oldTime
		# console.log $scope.event.timeTo, $scope.event.oldTime, duration
		# $scope.event.time_to = e.time.value + duration  
	
	
	# $scope.$watch 'event.time_from', (newValue, oldValue, scope) ->
		# console.log('The time is ', scope.$parent)
		# $('#time_from').timepicker().on 'show.timepicker', (e) ->
			# console.log('The time is ' + e.time.hours)
		# # console.log newValue, oldValue, scope.event.time_to.getTime(), scope
		# console.log $('#time_from').timepicker()
		# duration = new Date(new Date().toDateString() + ' ' + scope.event.time_to) - new Date(new Date().toDateString() + ' ' + oldValue)
		# console.log duration
		# newTimeTo = new Date(newValue + duration)
		# scope.event.time_to = newTimeTo.getHours() + ':' + newTimeTo.getMinutes()
	
	# # Use default settings
	# # $("#time3, #time4").timePicker()
# # 	
	# Store time used by duration.
	# oldTime = $.timePicker("#time3").getTime()
# # 
	# # # Keep the duration between the two inputs.
	# # $("#time3").on 'change', () ->
		# # if $("#time4").val() # Only update when second input has a value.
			# # # Calculate duration.
			# # duration = ($.timePicker("#time4").getTime() - oldTime)
			# # time = $.timePicker("#time3").getTime()
			# # # Se resetea el time3 por si escribieron una hora que no es válida
			# # # $("#time3").value = $.timePicker.formatTime(timeToDate(time, settings), settings);
			# # # Calculate and update the time in the second input.
			# # $.timePicker("#time4").setTime(new Date(new Date(time.getTime() + duration)))
			# # oldTime = time
# # 
	# # $("#time3, #time4").on 'blur', () ->
		# # time = $.timePicker(@).getTime()
	# # # Se resetea el time por si escribieron una hora que no es válida
		# # $.timePicker(@).setTime(new Date(new Date(time.getTime())))
# # 
	# # # Validate.
	# # $("#time4").on 'change', () ->
		 # # # time = $.timePicker("#time4").getTime()
			# # # # Se resetea el time4 por si escribieron una hora que no es válida
			# # # $.timePicker("#time4").setTime(new Date(new Date(time.getTime())))
		# # if $.timePicker("#time3").getTime() > $.timePicker(this).getTime()
			# # $(this).parent().addClass("error")
		# # else
			# # $(this).parent().removeClass("error")
# 
	# ###
		# Categories
	# ###
	# categoriesCheckbox = $('#categoriesSelect').find('input[type="checkbox"]')
	# $(categoriesCheckbox).on 'click', (event) ->
		# if categoriesCheckedCount() > 3
			# event.preventDefault()
			# showAlertMessage('Los eventos no pueden pertenecer a más de 3 (tres) categorías.')
			# return false
# 
	# ###
		# Form submit
	# ###
	# $('form').on 'submit', (event) ->
		# if $('#EventLat').val() is '' or $('#EventLong').val() is ''
			# event.preventDefault()
			# showAlertMessage('Debes seleccionar un lugar para el evento.')
			# return false
		# if $('#date_from').val() is '' or $('#date_to').val() is '' or $('#time3').val() is '' or $('#time4').val() is ''
			# event.preventDefault()
			# showAlertMessage('Debes seleccionar una fecha para el evento.')
			# return false
# 
# ###
# Funciones
# Aquí se escriben las funciones
# ###
# # inicializar = ->
	# # if navigator.geolocation
		# # window.browserSupportFlag = on
		# # navigator.geolocation.getCurrentPosition (position) ->
			# # initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
			# # window.map.setCenter(initialLocation)
		# # , ->
			# # noGeolocalizacion()
# # 
# # noGeolocalizacion = ->
	# # initialLocation = window.santafe
	# # window.map.setCenter(initialLocation)
# #  "time": "03:00 AM"
		# }
	# # if window.browserSupportFlag is on
		# # console.log "El servicio de geolocalización falló. Iniciamos desde Santa Fe."
	# # else
		# # console.log "Tu navegador no soporta geolocalización. Iniciamos desde Santa Fe."
# # 
# # # A function to create the marker and set up the event window function
# # createMarker = (latlng) ->
	# # marker = new google.maps.Marker({
		# # position: latlng,
		# # map: window.map,
		# # zIndex: Math.round(latlng.lat()*-100000)<<5
	# # })
# # 
# # # Calculate Categories Checked Count
# # categoriesCheckedCount = () ->
	 # # return $('#categoriesSelect').find('input:checked').length
# # 	 
# # showAlertMessage = (string) ->
	# # if string isnt '' and window.alertMessageDisplayed is off
		# # $('#alertMessageString').text(' ' + string)
		# # window.alertMessageDisplayed = on
		# # $('#alertMessage').fadeIn('slow').delay(5000).fadeOut('slow', () ->
			# # window.alertMessageDisplayed = off
		# # )
