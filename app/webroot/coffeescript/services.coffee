angular.module('services', [])
	.service 'CompliantView', ->
		modalElement = angular.element('#compliantViewModal')
		
		# return (scope, evento) ->
		this.show = (scope, evento) ->
			scope.evento = evento
			scope.evento.Compliant = {}
			modalElement.modal('show')
		
		this.close = ->
			modalElement.modal('hide')

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
