### *******************************************************************************************************************
								CATEGORIAS
******************************************************************************************************************* ###
angular.module('RadarApp').controller 'CategoriesController'
	, ['$http', '$location', '$scope', '$timeout', 'Category'
		, ($http, $location, $scope, $timeout, Category) ->
	
	location = $location.absUrl()
	
	Category.get {}, (response) ->
		$scope.categorias = response.categories
	
	# categoryToogle(category): agrega o elimina la categoria al padre.
	$scope.categoryToogle = (category) ->
		if not category.highlight
			$scope.$parent.categoriesAdd(category)
		else
			$scope.$parent.categoriesDelete(category)
	
	$scope.searchById = (id) ->
		if $scope.categorias?
			aux = $scope.categorias.filter (category) ->
				+category.Category.id is +id
			aux[0]
	
	$scope.show = (categoria) ->
		categoria.highlight = !categoria.highlight
		if categoria.highlight
			$scope.categoriesSelected.push(categoria.Category.id)
		else
			$scope.categoriesSelected.splice($scope.categoriesSelected.indexOf(categoria.Category.id), 1)
		
		$.cookie.json = true
		$.cookie("categoriesSelected"
			, $scope.categoriesSelected
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
	
	$scope.showAllCategories = ->
		if $scope.allCategoriesSelected
			$scope.categoriesSelected = []
			angular.forEach $scope.categorias, (category, index) ->
				category.highlight = off
		else
			angular.forEach $scope.categorias, (category, index) ->
				category.highlight = on
				$scope.categoriesSelected.push category.Category.id
		$scope.allCategoriesSelected = !$scope.allCategoriesSelected
	
	$scope.$watch 'categorias.length', ->
		if not location.contains('events/add')
			if $scope.categorias? and $.cookie? and $scope.categorias.length > 0
				$.cookie.json = true
				lastValEventCategory = $.cookie('categoriesSelected')
				if lastValEventCategory? and lastValEventCategory.length > 0
					angular.forEach lastValEventCategory, (categoryId, index) ->
						$scope.show($scope.searchById(categoryId))

	$scope.$watch 'categoriesSelected.length', ->
		console.log $scope.categoriesSelected.length
		
		# Si no hay ninguna categoría seleccionada, se seleccionan todas.
		if $scope.categoriesSelected.length is 0
			$scope.allCategoriesSelected = off
			$scope.showAllCategories()

	]
	

