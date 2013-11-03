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
  ]).factory('Classification', [
    '$resource', function($resource) {
      return $resource('/classifications.json', {
        callback: 'JSON_CALLBACK'
      }, {
        buscar: {
          method: 'GET'
        },
        get: {
          cache: true,
          method: 'GET',
          url: '/classifications.json'
        }
      });
    }
  ]).factory('Compliant', [
    '$resource', function($resource) {
      return $resource('/compliants.json', {
        callback: 'JSON_CALLBACK'
      }, {
        buscar: {
          method: 'GET'
        },
        create: {
          method: 'POST',
          url: '/compliants.json'
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
  ]).factory('Place', [
    '$resource', function($resource) {
      return $resource('/places.json', {
        callback: 'JSON_CALLBACK'
      }, {
        buscar: {
          method: 'GET'
        },
        get: {
          cache: true,
          method: 'GET',
          url: '/places/get.json'
        }
      });
    }
  ]).factory('Rate', [
    '$resource', function($resource) {
      return $resource('/rates.json', {
        callback: 'JSON_CALLBACK'
      }, {
        buscar: {
          method: 'GET'
        },
        create: {
          method: 'POST',
          url: '/rates.json'
        }
      });
    }
  ]);

}).call(this);
