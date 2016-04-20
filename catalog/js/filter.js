angular.module('myApp.filters', [])
  .filter('linebreak', function() {
    return function(text) {
        return text.replace(/\n/g, '<br>');
    }
})
.filter('to_trusted', ['$sce', function($sce){
            return function(text) {
                return $sce.trustAsHtml(text);
            };
        }]);




