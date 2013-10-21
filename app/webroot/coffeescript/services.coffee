angular.module('services', [])
	.factory 'EventView', ->
		modalElement = angular.element('#eventViewModal')
		
		return (scope, URL) ->
			scope.modalURL = URL
			modalElement.modal('show')
			
	.factory 'PlaceView', ->
		modalElement = angular.element('#placeViewModal')
		
		return (scope, URL) ->
			scope.modalURL = URL
			modalElement.modal('show')
