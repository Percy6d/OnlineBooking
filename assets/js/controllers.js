app.controller("intro-controller", function($rootScope, $scope){

});
app.controller("register-controller", function($rootScope, $scope){
    // Creating an empty object to store form details
    $scope.user = {};
});
app.controller("navbarCtrl", function($rootScope, $scope, $location){
    $scope.path = $location.path();
});