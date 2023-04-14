app.directive("customNavbar", function(){
    return {
        restrict: "E",
        templateUrl: "directives/navbar.html",
        controller: "navbarCtrl"
    }
});
app.directive("customFooter", function(){
    return {
        restrict: "E",
        templateUrl: "directives/footer.html"
    }
});
app.directive("alertDanger", function(){
    return {
        restrict: "E",
        scope: {
            msg: "@"
        },
        templateUrl: "directives/alert-danger.html"
    }
});
app.directive('showDuringResolve', function($rootScope, $timeout) {
    return {
        link: function(element) {
            $rootScope.$on('$routeChangeStart', function () {
                $rootScope.loaderStatus = true;
            });
            $rootScope.$on('$routeChangeSuccess', function () {
                $timeout(function(){
                    $rootScope.loaderStatus = false;
                }, 500);
            });
            $rootScope.$on('$routeChangeError', function () {
                $rootScope.loaderStatus = false;
            });
        }
    };
});