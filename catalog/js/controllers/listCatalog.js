catalogControllers.controller('ListCatalogController', [ '$scope', '$http', '$sce', function ($scope, $http, $sce) {
$http.get('config/multi-table.php').success(function(data) {
    //console.log('success: ' + data);
    $scope.query = "";
    $scope.courses = data;
    $scope.courseOrder = 'courseName';//selecting the data
    $scope.custom = true; //


   //Highlight words globally
    $scope.highlight = function(text, search) {
        if (!search) {

           return text.replace(/\n/g, '<br>');
           return $sce.trustAsHtml(text);
        }
        return $sce.trustAsHtml(text.replace(new RegExp(search, 'gi'), '<span class="highlightedText">$&</span>'));
        };//end of highlight
    });

    $scope.delete = function(courseNumber, index){
      $http.get('config/delete.php?courseNumber=' + courseNumber).success(function(data) {
           $scope.courses.splice(index, 1);
              console.log($scope.courses);
      });
    }

}]);