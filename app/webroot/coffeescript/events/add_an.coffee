'use strict'

RadarApp = angular.module('RadarApp', ['$strap.directives'])


RadarApp.value('$strapConfig', {
	datepicker: {
		# language: 'fr',
		# format: 'M d, yyyy'
	},
	timepicker: {
		time: "03:00",
		time_from: "03:00"
	},
});

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
		console.log $scope.eventForm.$valid
		if $scope.event.categories.length <= 0
			return console.error "Error: Debe seleccionar al menos una categoría"
		console.log $scope.event
		
	$scope.$watch 'event.date_from', (newValue) ->
		console.log newValue


	$scope.$watch 'event.address', (newValue) ->
		$scope.setAddress(newValue)

	$scope.geocoder = new google.maps.Geocoder()
	
	$scope.addAddressToMap = (response, status) ->
		console.log response
		if response.length is 0 or !response then return @ #si no pudo
		
		# blankicono que voy a usar para mostrar el punto en el mapa
		icon = new google.maps.MarkerImage("http://gmaps-samples.googlecode.com/svn/trunk/markers/blue/blank.png"
			, new google.maps.Size(20, 34)
			, new google.maps.Point(0, 0)
			, new google.maps.Point(10, 34)
		)
		
		if $scope.marker? then $scope.marker.setMap(null)
		
		# creo el marcador con la posición, el mapa, y el icono
		$scope.marker = new google.maps.Marker({'position': response[0].geometry.location
			, 'map': $scope.map
			, 'icon': icon
		})
		
		$scope.marker.setMap($scope.map) # inserto el marcador en el mapa
	
	
	$scope.setAddress = (address) ->
		request = new Object() # se crea un objeto request
		request.address = address
		request.bounds = $scope.map.getBounds()
		$scope.geocoder.geocode(request, $scope.addAddressToMap) # geocode hace la conversión a un punto, y su segundo parámetro es una función de callback
	
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
