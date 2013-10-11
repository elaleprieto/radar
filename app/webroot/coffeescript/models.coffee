angular.module('models', ['ngResource'])
	.factory('Category', ['$resource', ($resource) ->
		$resource '/categories.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, get: {cache: true, method: 'GET', url: '/categories.json'}
	])
	.factory('Event', ['$resource', ($resource) ->
		$resource '/events.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, get: {cache: true, method: 'GET', url: '/events/get.json'}
	])