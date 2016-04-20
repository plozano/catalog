catalogControllers.controller('login', function($scope, loginService) {
  $scope.msgtxt='';
  $scope.login = function(user){
    loginService.login(user, $scope);
  }
})