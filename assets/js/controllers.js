app.controller("intro-controller", function($rootScope, $scope){

});
app.controller("login-controller", function($rootScope, $scope){
    
});
app.controller("navbarCtrl", function($rootScope, $scope, $location){
    $scope.path = $location.path();
});