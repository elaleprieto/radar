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
      $scope.categoryToogle = function(category) {
        if (!category.highlight) {
          return $scope.$parent.categoriesAdd(category);
        } else {
          return $scope.$parent.categoriesDelete(category);
        }
      };
      $scope.deselectAllCategories = function() {
        $scope.$parent.categoriesSelected = [];
        $scope.allCategoriesSelected = false;
        return angular.forEach($scope.categorias, function(category, index) {
          return category.highlight = false;
        });
      };
      $scope.hideAllCategories = function() {
        $scope.deselectAllCategories();
        return $scope.setCookieCategoriesSelected();
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
      $scope.selectAllCategories = function() {
        $scope.$parent.categoriesSelected = [];
        $scope.allCategoriesSelected = true;
        return angular.forEach($scope.categorias, function(category, index) {
          category.highlight = true;
          return $scope.categoriesSelected.push(category.Category.id);
        });
      };
      $scope.setCookieCategoriesSelected = function() {
        $.cookie.json = true;
        return $.cookie("categoriesSelected", $scope.categoriesSelected, {
          expires: 360,
          path: '/'
        });
      };
      $scope.show = function(categoria) {
        categoria.highlight = !categoria.highlight;
        if (categoria.highlight) {
          $scope.categoriesSelected.push(categoria.Category.id);
        } else {
          $scope.categoriesSelected.splice($scope.categoriesSelected.indexOf(categoria.Category.id), 1);
        }
        return $scope.setCookieCategoriesSelected();
      };
      $scope.showAllCategories = function() {
        $scope.selectAllCategories();
        return $scope.setCookieCategoriesSelected();
      };
      return $scope.$watch('categorias.length', function() {
        var lastValEventCategory;
        if (!location.contains('events/add') && !location.contains('eventos/agregar') && ($scope.categorias != null) && $scope.categorias.length > 0) {
          if ($scope.categoriesSelected.length === 0) {
            $scope.selectAllCategories();
          }
          if ($.cookie != null) {
            $.cookie.json = true;
            lastValEventCategory = $.cookie('categoriesSelected');
            if ((lastValEventCategory != null) && lastValEventCategory.length > 0) {
              $scope.hideAllCategories();
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
