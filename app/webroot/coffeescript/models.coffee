angular.module('models', ['ngResource'])
	
	# Category
	.factory('Category', ['$resource', ($resource) ->
		$resource '/categories.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, get: {cache: true, method: 'GET', url: '/categories.json'}
	])
	
	# Event
	.factory('Event', ['$resource', ($resource) ->
		$resource '/events.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, get: {cache: true, method: 'GET', url: '/events/get.json'}
	])
	
	# Place
	.factory('Place', ['$resource', ($resource) ->
		$resource '/places.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, get: {cache: true, method: 'GET', url: '/places/get.json'}
	])

	# Rate
	.factory('Rate', ['$resource', ($resource) ->
		$resource '/rates.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, create: {method: 'POST', url: '/rates.json'}
	])