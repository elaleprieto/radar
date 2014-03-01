(function() {

  angular.module('services', []).service('CompliantView', function() {
    var modalElement;
    modalElement = angular.element('#compliantViewModal');
    this.show = function(scope, evento) {
      scope.evento = evento;
      scope.evento.Compliant = {};
      return modalElement.modal('show');
    };
    return this.close = function() {
      return modalElement.modal('hide');
    };
  }).factory('EventView', function() {
    var modalElement;
    modalElement = angular.element('#eventViewModal');
    return function(scope, URL) {
      scope.modalURL = URL;
      return modalElement.modal('show');
    };
  }).factory('PlaceView', function() {
    var modalElement;
    modalElement = angular.element('#placeViewModal');
    return function(scope, URL) {
      scope.modalURL = URL;
      return modalElement.modal('show');
    };
  });

}).call(this);
