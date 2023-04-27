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
        controller: "marketplace-controller"
    })
    .when("/marketplace-details/:identifier", {
        templateUrl: "views/marketplace-details.html",
        controller: "marketplace-details-controller",
        resolve: {
            "check": (security, fetches) => {
                security.refreshToken();
                fetches.userDetails();
            }
        }
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
    .when("/views/admin/", {
        templateUrl: "views/admin/overview.html",
    })
    .when("/views/admin/categories", {
        templateUrl: "views/admin/categories.html",
        controller: "categories-controller"
    })
    .when("/views/admin/commodities", {
        templateUrl: "views/admin/commodities.html",
        controller: "commodities-controller"
    })
    .when("/views/admin/types", {
        templateUrl: "views/admin/types.html",
        controller: "types-controller"
    })
    .when("/views/admin/users", {
        templateUrl: "views/admin/users.html",
        controller: "users-controller"
    })
    .when("/views/admin/bookings", {
        templateUrl: "views/admin/bookings.html",
        controller: "bookings-controller"
    })
    
    .otherwise({
        templateUrl: "page-not-found.html"
    });
    $locationProvider.hashPrefix("");
    $locationProvider.html5Mode(true);
});