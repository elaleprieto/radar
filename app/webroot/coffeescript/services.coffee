angular.module('services', [])
	.factory 'EventView', ->
		modalElement = angular.element('#eventViewModal')
		
		return (scope, URL) ->
			scope.modalURL = URL
			modalElement.modal('show')
