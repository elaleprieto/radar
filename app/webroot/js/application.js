(function ($) {

	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 12,
		center: new google.maps.LatLng(-34.603, -58.382),
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	var markers = function () {
		var callback = function (response) {
			//console.log('recibidos los eventos, cargar en el mapa');
		}, cache = {}, timer;
		return {
			refresh: function () {
				clearInterval(timer);
				timer = setTimeout(function () {
					var bounds = map.getBounds().toUrlValue();
					//console.log('pidiendo eventos', bounds);
					if (cache[bounds]) {
						// le puse cache para no hacer el pedido multiples veces si vuelve a un mismo lugar
						// algo bastante "paranoico" cuando todavia ni existe el metodo en la API :)
						callback(cache[bounds]);
					}
					// pedido a la api de eventos para los lat/long que esta viendo el cliente ahora
					$.post('/api/events/', 'bounds=' + bounds, function (response) {
						cache[bounds] = response;
						callback(response);
					});
				}, 1000);
			}
		};
	}();

	google.maps.event.addListenerOnce(map, 'idle', markers.refresh); // callback mapa cargado
	google.maps.event.addListener(map, 'center_changed', markers.refresh); // callback cambia el centro
	google.maps.event.addListener(map, 'zoom_changed', markers.refresh); // callback cambia el zoop

	$('form button[data-set]').on('click', function () {
		var object = $(this),
			form = object.closest('form'),
			targetName = object.attr('data-set'),
			target = form.find('[name=' + targetName + ']'),
			value = object.val();
		target.val(value);
	}).filter('.active').trigger('click');

}(jQuery));