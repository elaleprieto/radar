### *******************************************************************************************************************
								CATEGORIAS
******************************************************************************************************************* ###
angular.module('RadarApp').controller 'ClassificationsController'
	, ['$http', '$location', '$scope', '$timeout', 'Classification'
		, ($http, $location, $scope, $timeout, Classification) ->
	
	location = $location.absUrl()
	
	Classification.get {}, (response) ->
		$scope.classifications = []
		angular.forEach response.classifications, (element) ->
			$scope.classifications.push(element.Classification)
	
	# # classificationToogle(classification): agrega o elimina la clasificacion al padre.
	# $scope.classificationToogle = (classification) ->
		# if not classification.highlight
			# $scope.$parent.classificationsAdd(classification)
		# else
			# $scope.$parent.classificationsDelete(classification)
		
	# deselectAllClassifications: resetea el array classificationsSelected,
	# elimina todas las categorías seleccionadas del array classificationsSelected
	# y resetea el highlight en todas las categorías
	$scope.deselectAllClassifications = ->
		$scope.$parent.classificationsSelected = []
		$scope.allClassificationsSelected = off
		angular.forEach $scope.classifications, (classification, index) ->
			classification.highlight = off
	
	# hideAllClassifications: borra todas las categorías seleccionadas del array classificationsSelected
	# y elimina el highlight de todas las categorías
	$scope.hideAllClassifications = ->
		$scope.deselectAllClassifications()
		# $scope.setCookieClassificationsSelected()


	$scope.searchById = (id) ->
		if $scope.classifications?
			aux = $scope.classifications.filter (classification) ->
				+classification.Classification.id is +id
			aux[0]
	

	# selectAllClassifications: resetea el array classificationsSelected,
	# agrega todas las categorías seleccionadas al array classificationsSelected
	# y setea el highlight en todas las categorías
	$scope.selectAllClassifications = ->
		$scope.$parent.classificationsSelected = []
		$scope.allClassificationsSelected = on
		angular.forEach $scope.classifications, (classification, index) ->
			classification.highlight = on
			$scope.classificationsSelected.push classification.id	

	$scope.show = (classification) ->
		classification.highlight = !classification.highlight
		if classification.highlight
			$scope.classificationsSelected.push classification.id
		else
			$scope.classificationsSelected.splice($scope.classificationsSelected.indexOf(classification.id), 1)
				
		$.cookie.json = true
		$.cookie("classificationsSelected"
			, $scope.classificationsSelected
			, {
				# expires in 10 days
				expires: 360,

				# The value of the path attribute of the cookie 
				# (default: path of page that created the cookie).
				path: '/'

				# domain: '.radar.workspace.com'
				# The value of the domain attribute of the cookie
				# (default: domain of page that created the cookie).
	
				# If set to true the secure attribute of the cookie
				# will be set and the cookie transmission will
				# require a secure protocol (defaults to false).
				# secure  : true
			}
		);
	
	$scope.showAllClassifications = ->
		$scope.selectAllClassifications()
		# $scope.setCookieClassificationsSelected()

	$scope.$watch 'classifications.length', ->
		locations = ['places/add', 'places/edit', 'espacios/agregar', 'espacios/editar']

		# if not location.contains('places/add') and not location.contains('espacios/agregar')
		if not containLocations(locations)
			if $scope.classifications? and $.cookie? and $scope.classifications.length > 0
				$.cookie.json = true
				lastValEventCategory = $.cookie('classificationsSelected')
				if lastValEventCategory? and lastValEventCategory.length > 0
					angular.forEach lastValEventCategory, (classificationId, index) ->
						$scope.show($scope.searchById(classificationId))

	### *************************************************************************************************************** 
			Funciones Auxiliares
			Aquí se escriben las funciones auxiliares
	*************************************************************************************************************** ###
	containLocations = (locations = null) ->
		containURL = false
		angular.forEach locations, (url, index) ->
			if not containURL then containURL = location.contains(url)
		containURL

	]
