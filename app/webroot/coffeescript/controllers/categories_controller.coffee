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
		console.log $scope.$parent.evento.categories.length
		if not category.highlight
			$scope.$parent.categoriesAdd(category)
		else
			$scope.$parent.categoriesDelete(category)

	# deselectAllCategories: resetea el array categoriesSelected,
	# elimina todas las categorías seleccionadas del array categoriesSelected
	# y resetea el highlight en todas las categorías
	$scope.deselectAllCategories = ->
		$scope.$parent.categoriesSelected = []
		$scope.allCategoriesSelected = off
		angular.forEach $scope.categorias, (category, index) ->
			category.highlight = off
	
	# hideAllCategories: borra todas las categorías seleccionadas del array categoriesSelected
	# y elimina el highlight de todas las categorías
	$scope.hideAllCategories = ->
		$scope.deselectAllCategories()
		$scope.setCookieCategoriesSelected()

	$scope.searchById = (id) ->
		if $scope.categorias?
			aux = $scope.categorias.filter (category) ->
				+category.Category.id is +id
			aux[0]
	

	# selectAllCategories: resetea el array categoriesSelected,
	# agrega todas las categorías seleccionadas al array categoriesSelected
	# y setea el highlight en todas las categorías
	$scope.selectAllCategories = ->
		$scope.$parent.categoriesSelected = []
		$scope.allCategoriesSelected = on
		angular.forEach $scope.categorias, (category, index) ->
			category.highlight = on
			$scope.categoriesSelected.push category.Category.id	

	$scope.setCookieCategoriesSelected = ->
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

	$scope.show = (categoria) ->
		categoria.highlight = !categoria.highlight
		if categoria.highlight
			$scope.categoriesSelected.push(categoria.Category.id)
		else
			$scope.categoriesSelected.splice($scope.categoriesSelected.indexOf(categoria.Category.id), 1)
		
		$scope.setCookieCategoriesSelected()

	$scope.showAllCategories = ->
		$scope.selectAllCategories()
		$scope.setCookieCategoriesSelected()	
	
	containLocations = (locations = null) ->
		containURL = false
		angular.forEach locations, (url, index) ->
			if not containURL then containURL = location.contains(url)
		containURL


	$scope.$watch 'categorias.length', ->
		locations = ['events/add', 'events/edit', 'eventos/agregar', 'eventos/editar']

		# if not location.contains('events/add') and not location.contains('eventos/agregar') and not location.contains('events/add') and $scope.categorias? and $scope.categorias.length > 0
		if not containLocations(locations) and $scope.categorias? and $scope.categorias.length > 0
			# Al inicio, se seleccionan todas las categorías
			# si hay cookie, se sobreescriben después.
			if $scope.categoriesSelected.length is 0
				$scope.selectAllCategories()

			if $.cookie?
				$.cookie.json = true
				lastValEventCategory = $.cookie('categoriesSelected')
				if lastValEventCategory? and lastValEventCategory.length > 0
					$scope.hideAllCategories()
					angular.forEach lastValEventCategory, (categoryId, index) ->
						$scope.show($scope.searchById(categoryId))
			


]
	

