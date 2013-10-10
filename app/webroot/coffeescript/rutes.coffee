rutes = angular.module('rutes', ['ngResource'])

### *******************************************************************************************************************
			Routes
******************************************************************************************************************* ###
rutes.config ['$routeProvider', ($routeProvider) ->
	$routeProvider
		.when('/events/add', {
			templateUrl: '/events/add'
			, controller: this.EventsController
		})
		# .when('/admin/articulos/resumen', {
			# templateUrl: '/admin/articulos/resumen'
			# , controller: this.ArticuloIndiceController
		# })
		# .when('/admin/clientes/listar', {
			# templateUrl: '/admin/clientes/listar'
			# , controller: this.ClienteController
		# })
		# .when('/admin/ordenes/faltantes', {
			# templateUrl: '/admin/ordenes/faltantes'
			# , controller: this.PedidosController
		# })
		# .when('/admin/pedidos/controlados', {
			# templateUrl: '/admin/pedidos/controlados'
			# , controller: this.PedidosController
		# })
		# .when('/admin/pedidos/despachados', {
			# templateUrl: '/admin/pedidos/despachados'
			# , controller: this.PedidosController
		# })
		# .when('/admin/pedidos/embalados', {
			# templateUrl: '/admin/pedidos/embalados'
			# , controller: this.PedidosController
		# })
		# .when('/admin/pedidos/facturados', {
			# templateUrl: '/admin/pedidos/facturados'
			# , controller: this.PedidosController
		# })
		# .when('/admin/pedidos/finalizados', {
			# templateUrl: '/admin/pedidos/finalizados'
			# , controller: this.PedidosController
		# })
		# .when('/admin/pedidos/nuevo', {
			# templateUrl: '/admin/pedidos/nuevo'
			# , controller: this.PedidoNuevoController
		# })
		# .when('/admin/pedidos/pendientes', {
			# templateUrl: '/admin/pedidos/index'
			# , controller: this.PedidosController
		# })
		# .when('/mostrador/pedidos/pendientes', {
			# templateUrl: '/mostrador/pedidos/index'
			# , controller: this.PedidosController
		# })
		# .otherwise templateUrl: '/admin/articulos/indice'
			# , controller: this.ArticuloIndiceController
]