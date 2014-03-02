(function() {

  angular.module('fechaFilters', []).filter('isodate', function() {
    return function(datetime) {
      var n;
      n = datetime.split(' ');
      if (n.length === 1) {
        return datetime;
      } else {
        return n.join('T') + '-0300';
      }
    };
  });

}).call(this);
