app.config(($routeProvider, $locationProvider) => {
    $routeProvider
    .when("/", {
        templateUrl: "views/intro.html",
        controller: "intro-controller",
        resolve: {
            "check": (security) => {
                security.refreshToken();
            }
        }
    })
    .when("/login", {
        templateUrl: "views/login.html",
        controller: "login-controller",
        resolve: {
            "check": (security) => {
                security.isLoggedIn();
                security.refreshToken();
            }
        }
    })
    .when("/register", {
        templateUrl: "views/register.html",
        controller: "register-controller",
        resolve: {
            "check": (security) => {
                security.refreshToken();
            }
        }
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
        controller: "services-controller"
    })
    .when("/marketplace", {
        templateUrl: "views/marketplace.html",
    })
    .when("/dashboard/overview", {
        templateUrl: "views/dashboard/overview.html",
        controller: "dashboard-overview-controller",
        resolve: {
            "check": (security, fetches) => {
                security.isLoggedIn();
                security.refreshToken();
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