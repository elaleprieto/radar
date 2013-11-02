angular.module('RadarApp').directive 'loading', ['$rootScope', ($rootScope) ->
	return {
		link: (scope, element, attrs) ->
			element.addClass('hide');

			$rootScope.$on '$routeChangeStart', () ->
				element.removeClass('hide')

			$rootScope.$on '$routeChangeSuccess', () ->
				element.addClass('hide')
	}
]

angular.module('RadarApp').directive 'loaded', ['$rootScope', ($rootScope) ->
	return {
		link: (scope, element, attrs) ->
			# element.addClass('show');

			$rootScope.$on '$routeChangeStart', () ->
				element.addClass('hide');

			$rootScope.$on '$routeChangeSuccess', () ->
				element.removeClass('hide');
	}
]

angular.module('RadarApp').directive 'fundooRating', () ->
	return {
		restrict: 'A'
		template: 
			'<ul class="rating">' +
				'<li class="star" x-ng-repeat="star in stars" ' +
				'x-ng-class="{\'filled\':star.filled, \'not-allowed\':readonly==\'true\' || userVoted!=null || userId==\'\'}" x-ng-click="toggle($index)">' +
						# estrellita
						'\u2605' +
				'</li>' +
			'</ul>'
		scope: {
			max: '='
			onRatingSelected: '&'
			ratingValue: '='
			readonly: '@'
			userId: '='
			userVoted: '='
		}
		link: (scope, elem, attrs) ->
			
			# Actualiza los iconos de las estrellas
			updateStars = ->
				scope.stars = []
				for i in [1..scope.max]
					scope.stars.push({filled: i <= scope.ratingValue})
			
			# Cambia el rating
			scope.toggle = (index) ->
				# Se verifica que no el evento no esté en readonly mode
				return if scope.readonly and scope.readonly is 'true'
				# Se verifica que el usuario esté logueado
				return if scope.userId is ''
				# Se verifica que el usuario no haya votado
				return if scope.userVoted
				scope.readonly = 'true'
				scope.ratingValue = index + 1
				scope.onRatingSelected({newRating: index + 1})
			
			# Vigila el cambio de rating
			scope.$watch 'ratingValue', (oldVal, newVal) ->
				updateStars() if(newVal)
	}

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
