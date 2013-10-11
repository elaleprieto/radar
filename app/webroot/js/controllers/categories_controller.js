/* *******************************************************************************************************************
								CATEGORIAS
*******************************************************************************************************************
*/


(function() {
  angular.module('RadarApp').controller('CategoriesController', [
    '$http', '$location', '$scope', '$timeout', 'Category', function($http, $location, $scope, $timeout, Category) {
      var location;
      location = $location.absUrl();
      Category.get({}, function(response) {
        return $scope.categorias = response.categories;
      });
      $scope.addCategoryToEvent = function(category) {
        if (!category.highlight) {
          return $scope.$parent.eventCategoriesAdd(category);
        } else {
          return $scope.$parent.eventCategoriesDelete(category);
        }
      };
      $scope.searchById = function(id) {
        var aux;
        if ($scope.categorias != null) {
          aux = $scope.categorias.filter(function(category) {
            return +category.Category.id === +id;
          });
          return aux[0];
        }
      };
      $scope.show = function(categoria) {
        categoria.highlight = !categoria.highlight;
        if (categoria.highlight) {
          $scope.eventCategory.push(categoria.Category.id);
        } else {
          $scope.eventCategory.splice($scope.eventCategory.indexOf(categoria.Category.id), 1);
        }
        $.cookie.json = true;
        return $.cookie("eventCategory", $scope.eventCategory, {
          expires: 360,
          path: '/'
        });
      };
      return $scope.$watch('categorias.length', function() {
        var lastValEventCategory;
        if (!location.contains('events/add')) {
          if (($scope.categorias != null) && ($.cookie != null) && $scope.categorias.length > 0) {
            $.cookie.json = true;
            lastValEventCategory = $.cookie('eventCategory');
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
