(function() {
  angular.module('RadarApp').directive('loading', [
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

  angular.module('RadarApp').directive('loaded', [
    '$rootScope', function($rootScope) {
      return {
        link: function(scope, element, attrs) {
          $rootScope.$on('$routeChangeStart', function() {
            return element.addClass('hide');
          });
          return $rootScope.$on('$routeChangeSuccess', function() {
            return element.removeClass('hide');
          });
        }
      };
    }
  ]);

  angular.module('components', []).directive('marker', function() {
    return {
      restrict: "E",
      templateURL: "inicio.html"
    };
  });

}).call(this);
