var myApp = angular.module('myApp', ['ngRoute', 'textAngular',
  'catalogControllers'])

var catalogControllers = angular.module('catalogControllers', 
    ['ngAnimate']);

myApp.config(['$routeProvider', function($routeProvider) {
  $routeProvider.
  when('/login', {
      templateUrl: 'views/login.html',
      controller: 'login'
    }). 
    when('/listcatalog', {
        templateUrl: 'views/listcatalog.html',
        controller: 'ListCatalogController'
      }). 
   when('/addcourse', {
        templateUrl: 'views/addcourse.html',
        controller: 'InsertCourseController'
      }).
    when('/updatecourse', {
      templateUrl: 'views/updatecourse.html',
      controller:'ListCatalogController' //using this controller for the highlight search section
    }).
     when('/editcourse', {
      templateUrl: 'views/editcourse.html',
      controller: 'EditDetailsController'
    }).      
    when('/coursedetails/:itemId', {
      templateUrl: 'views/coursedetails.html',
      controller: 'CourseDetailsController'
    }). 
    otherwise({
      redirectTo: '/listcatalog'
    });
}]);
