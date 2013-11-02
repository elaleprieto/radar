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

  angular.module('RadarApp').directive('fundooRating', function() {
    return {
      restrict: 'A',
      template: '<ul class="rating">' + '<li class="star" x-ng-repeat="star in stars" ' + 'x-ng-class="{\'filled\':star.filled, \'not-allowed\':readonly==\'true\' || userVoted!=null || userId==\'\'}" x-ng-click="toggle($index)">' + '\u2605' + '</li>' + '</ul>',
      scope: {
        max: '=',
        onRatingSelected: '&',
        ratingValue: '=',
        readonly: '@',
        userId: '=',
        userVoted: '='
      },
      link: function(scope, elem, attrs) {
        var updateStars;
        updateStars = function() {
          var i, _i, _ref, _results;
          scope.stars = [];
          _results = [];
          for (i = _i = 1, _ref = scope.max; 1 <= _ref ? _i <= _ref : _i >= _ref; i = 1 <= _ref ? ++_i : --_i) {
            _results.push(scope.stars.push({
              filled: i <= scope.ratingValue
            }));
          }
          return _results;
        };
        scope.toggle = function(index) {
          if (scope.readonly && scope.readonly === 'true') {
            return;
          }
          if (scope.userId === '') {
            return;
          }
          if (scope.userVoted) {
            return;
          }
          scope.readonly = 'true';
          scope.ratingValue = index + 1;
          return scope.onRatingSelected({
            newRating: index + 1
          });
        };
        return scope.$watch('ratingValue', function(oldVal, newVal) {
          if (newVal) {
            return updateStars();
          }
        });
      }
    };
  });

  angular.module('components', []).directive('marker', function() {
    return {
      restrict: "E",
      templateURL: "inicio.html"
    };
  });

}).call(this);
