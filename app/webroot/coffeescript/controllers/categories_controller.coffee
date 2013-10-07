### *******************************************************************************************************************
								CATEGORIAS
******************************************************************************************************************* ###
angular.module('RadarApp').controller 'CategoriesController'
	, ['$http', '$location', '$scope', '$timeout'
		, ($http, $location, $scope, $timeout) ->
	
	location = $location.absUrl()
	
	$http.get('/categories ', {cache: true})
			.success (data) ->
				$scope.categorias = data
	
	# addCategoryToEvent(category): agrega la categoria al evento padre.
	$scope.addCategoryToEvent = (category) ->
		if not category.highlight
			$scope.$parent.eventCategoriesAdd(category)
		else
			$scope.$parent.eventCategoriesDelete(category)
	
	$scope.searchById = (id) ->
		if $scope.categorias?
			aux = $scope.categorias.filter (category) ->
				+category.Category.id is +id
			aux[0]
	
	$scope.show = (categoria) ->
		categoria.highlight = !categoria.highlight
		if categoria.highlight
			$scope.eventCategory.push(categoria.Category.id)
		else
			$scope.eventCategory.splice($scope.eventCategory.indexOf(categoria.Category.id), 1)
		
		$.cookie.json = true
		$.cookie("eventCategory"
			, $scope.eventCategory
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
	
	$scope.$watch 'categorias.length', ->
		if not location.contains('events/add')
			if $scope.categorias? and $.cookie? and $scope.categorias.length > 0
				$.cookie.json = true
				lastValEventCategory = $.cookie('eventCategory')
				if lastValEventCategory? and lastValEventCategory.length > 0
					angular.forEach lastValEventCategory, (categoryId, index) ->
						$scope.show($scope.searchById(categoryId))

	]
	

