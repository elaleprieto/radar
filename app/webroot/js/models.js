(function() {
  angular.module('models', ['ngResource']).factory('Category', [
    '$resource', function($resource) {
      return $resource('/categories.json', {
        callback: 'JSON_CALLBACK'
      }, {
        buscar: {
          method: 'GET'
        },
        get: {
          cache: true,
          method: 'GET',
          url: '/categories.json'
        }
      });
    }
  ]).factory('Event', [
    '$resource', function($resource) {
      return $resource('/events.json', {
        callback: 'JSON_CALLBACK'
      }, {
        buscar: {
          method: 'GET'
        },
        get: {
          cache: true,
          method: 'GET',
          url: '/events/get.json'
        }
      });
    }
  ]);

}).call(this);
