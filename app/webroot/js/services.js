(function() {
  angular.module('services', []).factory('EventView', function() {
    var modalElement;
    modalElement = angular.element('#eventViewModal');
    return function(scope, URL) {
      scope.modalURL = URL;
      return modalElement.modal('show');
    };
  });

}).call(this);
