'use strict'

RadarApp = angular.module('RadarApp', ['fechaFilters', 'ui.keypress', '$strap.directives'])

RadarApp.value('$strapConfig', {
	datepicker: {
		language: 'es',
		# format: 'M d, yyyy'
	}
})

if(!('contains' in String.prototype))
  String.prototype.contains = (str, startIndex) ->
   return -1 isnt this.indexOf(str, startIndex)

# App.config(['$routeProvider', ($routeProvider) ->
    # $routeProvider.
      # when('/', {
        # controller: 'CategoriaController',
        # resolve: {
          # recipes: (MultiRecipeLoader) ->
            # return MultiRecipeLoader();
        # },
        # templateUrl:'/events/list'
      # })
      # # .when('/edit/:recipeId', {
        # # controller: 'EditCtrl',
        # # resolve: {
          # # recipe: function(RecipeLoader) {
            # # return RecipeLoader();
          # # }
        # # },
        # # templateUrl:'/views/recipeForm.html'
      # # })
      # # .when('/view/:recipeId', {
        # # controller: 'ViewCtrl',
        # # resolve: {
          # # recipe: function(RecipeLoader) {
            # # return RecipeLoader();
          # # }
        # # },
        # # templateUrl:'/views/viewRecipe.html'
      # # })
      # # .when('/new', {
        # # controller: 'NewCtrl',
        # # templateUrl:'/views/recipeForm.html'
      # # })
      # .otherwise({redirectTo:'/'});
# ]);








	
