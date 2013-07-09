angular.module('fechaFilters', []).filter 'isodate', () ->
	(datetime) ->
		n = datetime.split(' ')
		if(n.length == 1)
			return datetime
		else
			return n.join('T')+'-0300'