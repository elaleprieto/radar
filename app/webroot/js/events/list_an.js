(function() {
  'use strict';
  var App;

  App = angular.module('App', ['ngResource']);

  App.config([
    '$routeProvider', function($routeProvider) {
      return $routeProvider.when('/', {
        controller: 'CategoriaController',
        resolve: {
          recipes: function(MultiEventLoader) {
            return MultiEventLoader();
          }
        },
        templateUrl: '/events/indice'
      }).otherwise({
        redirectTo: '/'
      });
    }
  ]);

  App.factory('Event', [
    '$resource', function($resource) {
      return $resource('/events/:id', {
        id: '@id'
      });
    }
  ]);

  App.factory('MultiEventLoader', [
    'Event', '$q', function(Event, $q) {
      return function() {
        var delay;
        delay = $q.defer();
        Event.query(function(events) {
          return delay.resolve(events);
        }, function() {
          return delay.reject('Unable to fetch recipes');
        });
        return delay.promise;
      };
    }
  ]);

  App.directive('loading', [
    '$rootScope', function($rootScope) {
      return {
        link: function(scope, element, attrs) {
          element.addClass('hide');
          $rootScope.$on('$routeChangeStart', function() {
            return element.removeClass('hide');
          });
          return $rootScope.$on('$routeChangeSuccess', function() {
            return element.addClass('hide');
          });
        }
      };
    }
  ]);

  App.controller('CategoriaController', function($scope) {
    return $scope.show = function(categoria) {
      return categoria.highlight = !categoria.highlight;
    };
  });

}).call(this);
