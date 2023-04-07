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