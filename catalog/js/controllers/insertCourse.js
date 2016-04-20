//Controller to ADD the data into db//
catalogControllers.controller('InsertCourseController', ['$scope','$http', '$location', function ($scope,$http, $location) {
  

      


 
function myFunction(event) {
    var x = event.keyCode;
    document.getElementById("myInput").innerHTML = "The Unicode value is: " + x;
}


  // $scope.courseStatus = {courseStatus : 'Active'};
  $scope.topics = [{topicIndex: 'topic1'}, {topicIndex: 'topic2'}, {topicIndex: 'topic3'}];
  //console.log($scope.topics);

  //add extra topic input fields in addcourse
  $scope.addNewTopic = function() {
    var newItemNo = $scope.topics.length+1;
    $scope.topics.push({'topicIndex':'topic'+newItemNo});
  };

  //remove Topic input fields in addcourse
  $scope.removeTopic = function() {
    var newItemNo = $scope.topics.length-1;
    $scope.topics.pop();
  };

  //adding data grabbed from addcourse and adding it to db
  $scope.addCourseCatalogPost = function(){
   //console.log($scope.courseCatalogPost.languageCode)
    $scope.langCodePush = [];
    for (index = 0; index < $scope.courseCatalogPost.languageCode.length; index++){ 
      $scope.langCodeData = $scope.courseCatalogPost.languageCode[index];
      console.log($scope.langCodeData);
      $scope.langCodePush.push({'langIndex':'lang'+index,'langCode':$scope.langCodeData});
    };//end of for statement

    $scope.CatCodePush = [];
    console.log($scope.courseCatalogPost.categories);
    for (index = 0; index < $scope.courseCatalogPost.categories.length; index++){ 
      $scope.catCodeData = $scope.courseCatalogPost.categories[index];
      console.log($scope.catCodeData);
      $scope.CatCodePush.push({'categoryIndex':'cat'+index,'categoryCode':$scope.catCodeData});
    };//end of for statement
      
      var data = {
          courseName: $scope.courseCatalogPost.courseName,
          courseNumber: $scope.courseCatalogPost.courseNumber,
          length: $scope.courseCatalogPost.length,
          daysFromHire: $scope.courseCatalogPost.daysFromHire,
          trainingFreq: $scope.courseCatalogPost.trainingFreq,
          recAudience: $scope.courseCatalogPost.recAudience,
          courseStatus: $scope.courseStatus,
          courseDesc: $scope.htmlVariable,
          categories: $scope.CatCodePush,
          languageCode: $scope.langCodePush,
          topicDesc: $scope.topics
      }
     
     // Backend.post("config/insert.php", data).success(function(data, status, headers, config){
     //      console.log("inserted Successfully");
     //      console.log(data);
     //      //path to redirect users to update section
     //      $location.path('/updatecourse', true);
     //  });

      $http.post("config/insert.php", data)
        .success(function(data, status, headers, config){
          console.log("inserted Successfully");
          console.log(data);
          //path to redirect users to update section
          $location.path('/updatecourse', true);
      });
  }//end scope addCourse
}]);

