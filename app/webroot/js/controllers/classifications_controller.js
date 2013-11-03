/* *******************************************************************************************************************
								CATEGORIAS
*******************************************************************************************************************
*/


(function() {
  angular.module('RadarApp').controller('ClassificationsController', [
    '$http', '$location', '$scope', '$timeout', 'Classification', function($http, $location, $scope, $timeout, Classification) {
      var location;
      location = $location.absUrl();
      Classification.get({}, function(response) {
        return $scope.classifications = response.classifications;
      });
      $scope.classificationToogle = function(classification) {
        if (!classification.highlight) {
          return $scope.$parent.classificationsAdd(classification);
        } else {
          return $scope.$parent.classificationsDelete(classification);
        }
      };
      $scope.searchById = function(id) {
        var aux;
        if ($scope.classifications != null) {
          aux = $scope.classifications.filter(function(classification) {
            return +classification.Classification.id === +id;
          });
          return aux[0];
        }
      };
      $scope.show = function(clasificacion) {
        clasificacion.highlight = !clasificacion.highlight;
        if (clasificacion.highlight) {
          $scope.classificationsSelected.push(clasificacion.Classification.id);
        } else {
          $scope.classificationsSelected.splice($scope.classificationsSelected.indexOf(clasificacion.Classification.id), 1);
        }
        $.cookie.json = true;
        return $.cookie("classificationsSelected", $scope.classificationsSelected, {
          expires: 360,
          path: '/'
        });
      };
      return $scope.$watch('classifications.length', function() {
        var lastValEventCategory;
        if (!location.contains('events/add')) {
          if (($scope.classifications != null) && ($.cookie != null) && $scope.classifications.length > 0) {
            $.cookie.json = true;
            lastValEventCategory = $.cookie('classificationsSelected');
            if ((lastValEventCategory != null) && lastValEventCategory.length > 0) {
              return angular.forEach(lastValEventCategory, function(categoryId, index) {
                return $scope.show($scope.searchById(categoryId));
              });
            }
          }
        }
      });
    }
  ]);

}).call(this);
