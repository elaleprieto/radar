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
          $scope.categoriesSelected.push(categoria.Category.id);
        } else {
          $scope.categoriesSelected.splice($scope.categoriesSelected.indexOf(categoria.Category.id), 1);
        }
        $.cookie.json = true;
        return $.cookie("categoriesSelected", $scope.categoriesSelected, {
          expires: 360,
          path: '/'
        });
      };
      $scope.showAllCategories = function() {
        if ($scope.allCategoriesSelected) {
          $scope.categoriesSelected = [];
          angular.forEach($scope.categorias, function(category, index) {
            return category.highlight = false;
          });
        } else {
          angular.forEach($scope.categorias, function(category, index) {
            category.highlight = true;
            return $scope.categoriesSelected.push(category.Category.id);
          });
        }
        return $scope.allCategoriesSelected = !$scope.allCategoriesSelected;
      };
      $scope.$watch('categorias.length', function() {
        var lastValEventCategory;
        if (!location.contains('events/add')) {
          if (($scope.categorias != null) && ($.cookie != null) && $scope.categorias.length > 0) {
            $.cookie.json = true;
            lastValEventCategory = $.cookie('categoriesSelected');
            if ((lastValEventCategory != null) && lastValEventCategory.length > 0) {
              return angular.forEach(lastValEventCategory, function(categoryId, index) {
                return $scope.show($scope.searchById(categoryId));
              });
            }
          }
        }
      });
      return $scope.$watch('categoriesSelected.length', function() {
        console.log($scope.categoriesSelected.length);
        if ($scope.categoriesSelected.length === 0) {
          $scope.allCategoriesSelected = false;
          return $scope.showAllCategories();
        }
      });
    }
  ]);

}).call(this);
