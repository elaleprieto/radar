'use strict'

# App = angular.module('App', ['fechaFilters', 'scroll'])
App = angular.module('App', ['ngResource'])

App.config(['$routeProvider', ($routeProvider) ->
    $routeProvider.
      when('/', {
        controller: 'CategoriaController',
        resolve: {
          recipes: (MultiEventLoader) ->
            return MultiEventLoader();
        },
        templateUrl:'/events/indice'
      })
      # .when('/edit/:recipeId', {
        # controller: 'EditCtrl',
        # resolve: {
          # recipe: function(RecipeLoader) {
            # return RecipeLoader();
          # }
        # },
        # templateUrl:'/views/recipeForm.html'
      # })
      # .when('/view/:recipeId', {
        # controller: 'ViewCtrl',
        # resolve: {
          # recipe: function(RecipeLoader) {
            # return RecipeLoader();
          # }
        # },
        # templateUrl:'/views/viewRecipe.html'
      # })
      # .when('/new', {
        # controller: 'NewCtrl',
        # templateUrl:'/views/recipeForm.html'
      # })
      .otherwise({redirectTo:'/'});
]);

App.factory('Event', ['$resource', ($resource) ->
  return $resource('/events/:id', {id: '@id'})
])

App.factory('MultiEventLoader', ['Event', '$q',	(Event, $q) ->
		return () ->
	    delay = $q.defer()
	    
	    Event.query (events) ->
	    		delay.resolve(events);
	    , () ->
	      	delay.reject('Unable to fetch recipes');

	    return delay.promise;
])

App.directive('loading', ['$rootScope', ($rootScope) ->
  return {
    link: (scope, element, attrs) ->
      element.addClass('hide');

      $rootScope.$on('$routeChangeStart', () ->
        element.removeClass('hide');
      );

      $rootScope.$on('$routeChangeSuccess', () ->
        element.addClass('hide');
      );
  };
]);



App.controller 'CategoriaController', ($scope) ->
	$scope.show = (categoria) ->
		categoria.highlight = !categoria.highlight
		

# App.factory 'modalService', ($rootScope) ->
	# broadcast: (pedido) ->
		# $rootScope.$broadcast('modalBroadcast', pedido) 
# 	
# App.controller 'PedidoController', ($scope, $http, modalService) ->
	# $scope.direccion = 0
	# $scope.limite = 30
	# $scope.orden = 'Pedido.created'
	# $scope.pagina = 1
	# $scope.cursandoPeticion = off
	# $scope.predicate = 'pedido.Cliente.nombre'
# 	
	# $scope.addAll = (collection) ->
		# angular.forEach collection, (value, key) ->
			# $scope.addOne(value)
# 
	# $scope.addOne = (model) ->
		# $scope.pedidos.push(model);
# 		
	# $scope.getNextPagina = () ->
		# if $scope.cursandoPeticion is off
			# $scope.cursandoPeticion = on
			# $scope.pagina++
			# $scope.getPagina()
# 
	# $scope.getPagina = () ->
		# $http.get('controlados', {cache: true, params: {pagina: $scope.pagina, limit: $scope.limite, orden: $scope.orden, direccion: $scope.direccion}}).success (data) ->
			# $scope.addAll(data)
			# $scope.cursandoPeticion = off
# 	
	# $scope.facturar = (event, pedido) ->
		# event.preventDefault()
		# # Se dispara el evento para asignar el pedido al modal
		# modalService.broadcast(pedido)
# 		
	# $scope.reset = () ->
		# $scope.pagina = 1
		# $scope.pedidos = []
		# $scope.getPagina()
# 		
# 
# App.controller 'ModalController', ($scope, modalService) ->
	# $scope.submit = () ->
		# window.open('facturar/' + $scope.pedido.Pedido.id)
		# angular.element('#modal').modal 'hide'
# 
	# $scope.$on 'modalBroadcast', (event, pedido) ->
		# $scope.pedido = pedido
		# angular.element('#modal').modal 'show'
	
	
	
