app.controller("intro-controller", function($rootScope, $scope){

});
app.controller("register-controller", function($rootScope, $scope, $http, $cookies, $timeout, $location){
    // Creating an empty object to store form details
    $scope.user = {};

    // Get user details and create an account via API
    $scope.createUser = () => {
        // Make submit button disabled
        $scope.isLoading = true;
        // Changing submit text
        $scope.defaultFormText = "Submitting...";
        $http({
            "method": "POST",
            "url": "server/v1/users/create-new",
            "data": $scope.user,
            "headers": {
                "Content-Type": "application/json"
            }
        }).then((success) => {
            let exp = new Date(); exp. setDate(exp. getDate() + 30);
            $scope.tokens = {};
            $scope.tokens.access = success.data.access_token;
            $scope.tokens.refresh = success.data.refresh_token;
            $cookies.put('bk-tokens', JSON.stringify($scope.tokens), {
                path: '/',
                secure: true,
                samesite: 'strict',
                expires: exp}
            );
            $scope.defaultFormText = "Setting up your dashboard...";
            $timeout(() => {
                $location.path("/dashboard/overview");
            }, 3000);
        }, (error) => {
            $scope.errMsg = error.data;
            xuiAnime("errorBox");
            $scope.isLoading = false;
            $scope.defaultFormText = "Create Account";
        });
    }
});
app.controller("login-controller", function($rootScope, $scope, $http, $cookies, $timeout, $location){
    // Creating an empty object to store form details
    $scope.user = {};

    // Get user details and create an account via API
    $scope.authUser = () => {
        // Make submit button disabled
        $scope.isLoading = true;
        // Changing submit text
        $scope.defaultFormText = "Submitting...";
        $http({
            "method": "POST",
            "url": "server/v1/users/authorize",
            "data": $scope.user,
            "headers": {
                "Content-Type": "application/json"
            }
        }).then((success) => {
            let exp = new Date(); exp. setDate(exp. getDate() + 30);
            $scope.tokens = {};
            $scope.tokens.access = success.data.access_token;
            $scope.tokens.refresh = success.data.refresh_token;
            $cookies.put('bk-tokens', JSON.stringify($scope.tokens), {
                path: '/',
                secure: true,
                samesite: 'strict',
                expires: exp}
            );
            $scope.defaultFormText = "Setting up your dashboard...";
            $timeout(() => {
                $location.path("/dashboard/overview");
            }, 3000);
        }, (error) => {
            $scope.errMsg = error.data;
            xuiAnime("errorBox");
            $scope.isLoading = false;
            $scope.defaultFormText = "Log into your account";
        });
    }
});
app.controller("navbarCtrl", function($rootScope, $scope, $location){
    $scope.path = $location.path();
});