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
      });
    }
  ]);

}).call(this);
