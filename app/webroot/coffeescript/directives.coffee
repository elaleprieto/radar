angular.module('RadarApp').directive('loading', ['$rootScope', ($rootScope) ->
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

angular.module('RadarApp').directive('loaded', ['$rootScope', ($rootScope) ->
  return {
    link: (scope, element, attrs) ->
      # element.addClass('show');

      $rootScope.$on('$routeChangeStart', () ->
        element.addClass('hide');
      );

      $rootScope.$on('$routeChangeSuccess', () ->
        element.removeClass('hide');
      );
  };
]);