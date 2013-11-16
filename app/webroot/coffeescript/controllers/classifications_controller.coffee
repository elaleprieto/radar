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
	
	$scope.searchById = (id) ->
		if $scope.classifications?
			aux = $scope.classifications.filter (classification) ->
				+classification.Classification.id is +id
			aux[0]
	
	$scope.show = (classification) ->
		classification.highlight = !classification.highlight
		if classification.highlight
			$scope.classificationsSelected.push(classification.id)
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
	
	$scope.$watch 'classifications.length', ->
		if not location.contains('events/add')
			if $scope.classifications? and $.cookie? and $scope.classifications.length > 0
				$.cookie.json = true
				lastValEventCategory = $.cookie('classificationsSelected')
				if lastValEventCategory? and lastValEventCategory.length > 0
					angular.forEach lastValEventCategory, (categoryId, index) ->
						$scope.show($scope.searchById(categoryId))

	]
	

