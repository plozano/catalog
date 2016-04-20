'use strict';

myApp.factory('loginService', function ($http) {
	return{
		login: function(user, scope){
			    console.log(user);
			var $promise = $http.post('config/user.php', user)
			$promise.then(function(msg){
				if(msg.data=='sucess') scope.msgtxt='correct information';
					else scope.msgtxt = 'Error information';
			});
		}
	}
})