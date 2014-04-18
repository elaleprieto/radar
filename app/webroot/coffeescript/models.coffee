angular.module('models', ['ngResource'])
	
	# Category
	.factory('Category', ['$resource', ($resource) ->
		$resource '/categories.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, get: {cache: true, method: 'GET', url: '/categories.json'}
	])
	
	# Classification
	.factory('Classification', ['$resource', ($resource) ->
		$resource '/classifications.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, get: {cache: true, method: 'GET', url: '/classifications.json'}
	])
	
	# Compliant
	.factory('Compliant', ['$resource', ($resource) ->
		$resource '/compliants.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, create: {method: 'POST', url: '/compliants.json'}
	])
	
	# Event
	.factory('Event', ['$resource', ($resource) ->
		$resource '/events.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, get: {cache: true, method: 'GET', url: '/events/get.json'}
				, getById: {cache: false, method: 'GET', url: '/events/:id.json'}
	])
	
	# Place
	.factory('Place', ['$resource', ($resource) ->
		$resource '/places.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, create: {method: 'POST', url: '/admin/places/add.json'}
				, get: {cache: true, method: 'GET', url: '/places/get.json'}
				, update: {method: 'POST', url: '/admin/places/edit/:id.json'}
	])

	# Rate
	.factory('Rate', ['$resource', ($resource) ->
		$resource '/rates.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, create: {method: 'POST', url: '/rates.json'}
	])

	# User
	.factory('User', ['$resource', ($resource) ->
		$resource '/users.json'
			, { callback:'JSON_CALLBACK' }
			, buscar: {method:'GET'}
				, update: {method: 'PUT', url: '/users/:id.json'}
	])