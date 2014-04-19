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
        $scope.classifications = [];
        return angular.forEach(response.classifications, function(element) {
          return $scope.classifications.push(element.Classification);
        });
      });
      $scope.deselectAllClassifications = function() {
        $scope.$parent.classificationsSelected = [];
        $scope.allClassificationsSelected = false;
        return angular.forEach($scope.classifications, function(classification, index) {
          return classification.highlight = false;
        });
      };
      $scope.hideAllClassifications = function() {
        return $scope.deselectAllClassifications();
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
      $scope.selectAllClassifications = function() {
        $scope.$parent.classificationsSelected = [];
        $scope.allClassificationsSelected = true;
        return angular.forEach($scope.classifications, function(classification, index) {
          classification.highlight = true;
          return $scope.classificationsSelected.push(classification.id);
        });
      };
      $scope.show = function(classification) {
        classification.highlight = !classification.highlight;
        if (classification.highlight) {
          $scope.classificationsSelected.push(classification.id);
        } else {
          $scope.classificationsSelected.splice($scope.classificationsSelected.indexOf(classification.id), 1);
        }
        $.cookie.json = true;
        return $.cookie("classificationsSelected", $scope.classificationsSelected, {
          expires: 360,
          path: '/'
        });
      };
      $scope.showAllClassifications = function() {
        return $scope.selectAllClassifications();
      };
      return $scope.$watch('classifications.length', function() {
        var lastValEventCategory;
        if (!location.contains('events/add')) {
          if (($scope.classifications != null) && ($.cookie != null) && $scope.classifications.length > 0) {
            $.cookie.json = true;
            lastValEventCategory = $.cookie('classificationsSelected');
            if ((lastValEventCategory != null) && lastValEventCategory.length > 0) {
              return angular.forEach(lastValEventCategory, function(classificationId, index) {
                return $scope.show($scope.searchById(classificationId));
              });
            }
          }
        }
      });
    }
  ]);

}).call(this);
