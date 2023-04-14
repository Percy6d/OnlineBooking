app.service("security", function($cookies, $location, $http){
    this.isLoggedIn = function(){
        let tokenCookie = $cookies.get("bk-tokens", {path: '/'});
        if(tokenCookie === undefined){
            // Redirect to login page
            $location.path("/login");
        } else {
            // Redirect to the overview page of the dashboard
            $location.path("/dashboard/overview");
        }
    }
});
app.service("fetches", function($http, $cookies){
    this.userDetails = function(){
        let tokenCookie = $cookies.get("bk-tokens", {path: '/'});
        if(tokenCookie === undefined){
            $rootScope.loggedInUser = {};
        } else {
            tokenCookie = JSON.parse(tokenCookie);
            $http({
                "method": "GET",
                "url": "server/v1/jwt/read-data",
                "headers": {
                    "Content-Type": "application/json",
                    "Authorization": tokenCookie.access
                }
            }).then((success) => {
                let jwtData = success.data.data;
                console.log(jwtData.emailAddress);
            }, (error) => {
                console.log(error.data);
            });
        }
    }
});