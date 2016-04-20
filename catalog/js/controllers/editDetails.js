//controller to edit/update information on editcourse.html
catalogControllers.controller('EditDetailsController', ['$scope', '$http', '$location', '$routeParams', function ($scope, $http, $location, $routeParams) {


  //listing information
  $http.get('config/multi-table.php?', {
    params: { courseNumber: $routeParams.courseNumber}
  }).success(function(courses) {
 
    var id = $routeParams.courseNumber;
    $scope.courses = [];
    $scope.courses = courses.filter(function (update) {
    return ~id.indexOf(update.courseNumber + '');    
    });
    //add languages to Array in order to highlight languages
    $scope.updatelanguages = $scope.courses[0]['languages'];
    $scope.updatelanguagesArray = [];
    //add categoris to Array in order to highlight categories
    $scope.updatecategories = $scope.courses[0]['categories'];
    $scope.updateCategoryArray = [];
    //Retrieve topics
    $scope.updateTopic = $scope.courses[0]['topicDesc'];

  
      //add languages to Array in order to highlight languages
    for (index = 0; index < $scope.updatelanguages.length; index++){   
      $scope.updatelanguagesArray.push($scope.updatelanguages[index]['langCode']);
      $scope.updatelanguagesArray.push($scope.updatelanguages[index]['langIndex'])
      //console.log($scope.updatelanguagesArray)
    };//end of for statement

    //add categories to Array in order to highlight languages
    for (index = 0; index < $scope.updatelanguages.length; index++){   
      $scope.updateCategoryArray.push($scope.updatecategories[index]['categoryText']);
      $scope.updateCategoryArray.push($scope.updatecategories[index]['categoryCode'])
      //console.log($scope.updatelanguagesArray)
    };//end of for statement


    //Retrieve topics
    //add extra topic input fields
    $scope.addNewTopicEdit = function() {
      var newItemNo = $scope.updateTopic.length+1;
      $scope.updateTopic.push({'topicIndex':'topic'+newItemNo});
      console.log($scope.updateTopic);
    };//

    //remove Topic input fields in addcourse
    $scope.removeTopicEdit = function (){
      data = {
        courseNumber: $scope.courses[0]['courseNumber'],
        topicDesc: $scope.updateTopic
      }
      $http.post('config/delete.php?action=delete_topic', data)
        .success(function (data, status, headers, config){
      var newItemNo = $scope.updateTopic.length-1;
      $scope.updateTopic.pop();
      console.log("topic to be deleted");  
      });
    }//

});//end of get

  //Posting information to db from editcourse.html
  $scope.updateCourseCatalogPost = function (){
      
    var topicData = {
          courseNumber: $scope.courses[0]['courseNumber'],
          topicDesc: $scope.updateTopic
        }

    $http.post('config/update.php?action=update_topic', topicData)
      .success(function(topicData, status, headers, config){
         console.log("topic Added");
    });

    var data = {
          courseName: $scope.courses[0]['courseName'],
          courseNumber: $scope.courses[0]['courseNumber'],
          length: $scope.courses[0]['length'],
          daysFromHire: $scope.courses[0]['daysFromHire'],
          trainingFreq: $scope.courses[0]['trainingFreq'],
          recAudience: $scope.courses[0]['recAudience'],
          courseDesc: $scope.courses[0]['courseDesc'],
          courseStatus: $scope.courses[0]['courseStatus'],
          categories: $scope.updateCategoryArray,
          languages: $scope.updatelanguagesArray,
          topicDesc: $scope.updateTopic
        }
        console.log($scope.courses[0]['courseDesc']);
      $http.post("config/update.php?action=update_course", data)
        .success(function (data, status, headers, config){
          console.log("inserted Successfully");
          console.log(data);         
          //path to redirect users to update section
          $location.path('/updatecourse', false);
      });
  }

}]);//end of controller