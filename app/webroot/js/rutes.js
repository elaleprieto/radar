(function() {
  var rutes;

  rutes = angular.module('rutes', ['ngResource']);

  /* *******************************************************************************************************************
  			Routes
  *******************************************************************************************************************
  */

  rutes.config([
    '$routeProvider', function($routeProvider) {
      return $routeProvider.when('/events/add', {
        templateUrl: '/events/add'
      }).when('/events/view/:id', {
        templateUrl: function(params) {
          return '/events/view/' + params.id;
        }
      });
    }
  ]);

}).call(this);
