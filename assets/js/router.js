app.config(($routeProvider, $locationProvider) => {
    $routeProvider
    .when("/", {
        templateUrl: "views/intro.html",
        controller: "intro-controller"
    })
    .when("/login", {
        templateUrl: "views/login.html",
        controller: "login-controller"
    })
    .when("/register", {
        templateUrl: "views/register.html",
        controller: "register-controller"
    })
    .when("/about", {
        templateUrl: "views/about.html",
        controller: "about-controller"
    })
    .when("/contact", {
        templateUrl: "views/contact.html",
        controller: "contact-controller"
    })
    .when("/services", {
        templateUrl: "views/services.html",
        controller: "services-controller"
    })
    .when("/service/car-rental", {
        templateUrl: "test.html"
    })
    .otherwise({
        templateUrl: "page-not-found.html"
    });
    $locationProvider.hashPrefix("");
    $locationProvider.html5Mode(true);
});