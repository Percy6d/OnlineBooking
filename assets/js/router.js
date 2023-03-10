app.config(($routeProvider, $locationProvider) => {
    $routeProvider
    .when("/", {
        templateUrl: "views/intro.html",
        controller: "intro-controller"
    })
    .otherwise({
        templateUrl: "page-not-found.html"
    });
    $locationProvider.hashPrefix("");
    $locationProvider.html5Mode(true);
});