(function() {
  'use strict';
  var RadarApp,
    __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  RadarApp = angular.module('RadarApp', ['fechaFilters', 'ui.keypress', 'rutes', '$strap.directives', 'components', 'models', 'services']);

  RadarApp.config([
    '$httpProvider', '$locationProvider', function($httpProvider, $locationProvider) {
      $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
      return $locationProvider.html5Mode(true).hashPrefix('!');
    }
  ]);

  RadarApp.value('$strapConfig', {
    datepicker: {
      language: 'es'
    }
  });

  if (!(__indexOf.call(String.prototype, 'contains') >= 0)) {
    String.prototype.contains = function(str, startIndex) {
      return -1 !== this.indexOf(str, startIndex);
    };
  }

}).call(this);
