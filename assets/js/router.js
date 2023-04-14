app.config(($routeProvider, $locationProvider) => {
    $routeProvider
    .when("/", {
        templateUrl: "views/intro.html",
        controller: "intro-controller"
    })
    .when("/login", {
        templateUrl: "views/login.html",
        controller: "login-controller",
        resolve: {
            "check": (security) => {
                security.isLoggedIn();
            }
        }
    })
    .when("/register", {
        templateUrl: "views/register.html",
        controller: "register-controller"
    })
    .when("/verify/:uid", {
        templateUrl: "views/verify.html"
    })
    .when("/about", {
        templateUrl: "views/about.html"
    })
    .when("/contact", {
        templateUrl: "views/contact.html"
    })
    .when("/services", {
        templateUrl: "views/services.html",
    })
    .when("/dashboard/overview", {
        templateUrl: "views/dashboard-overview.html",
        resolve: {
            "check": (security, fetches) => {
                security.isLoggedIn();
                fetches.userDetails();
            }
        }
    })
    .otherwise({
        templateUrl: "page-not-found.html"
    });
    $locationProvider.hashPrefix("");
    $locationProvider.html5Mode(true);
});