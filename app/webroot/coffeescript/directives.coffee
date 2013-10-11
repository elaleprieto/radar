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

angular.module('components', []).directive 'marker', () ->
	return {
		restrict: "E"
		# scope: {
			# event:'='
		# }
		# template: "<div><h2>{{event.Event.title}}</h2><p>{{event.Event.description}}</p></div>"
		templateURL: "inicio.html"
		# link: (scope, elm, attrs, ctrl) ->
			# # get the attribute value
			# if not scope.event.Event.title
				# scope.event.Event.title = 'Sin Título'

	} 
