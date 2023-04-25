app.service("security", function($cookies, $location, $http){
    this.isLoggedIn = function(){
        let tokenCookie = $cookies.get("bk-tokens", {path: '/'});
        if(tokenCookie === undefined || tokenCookie.length <= 2){
            // Redirect to login page
            $location.path("/login");
        } else {
            // Redirect to the overview page of the dashboard
            $location.path("/dashboard/overview");
        }
    }
    this.refreshToken = function(){
        let tokenCookie = $cookies.get("bk-tokens", {path: '/'});
        if(tokenCookie !== undefined){
            tokenCookie = JSON.parse(tokenCookie);
            $http({
                "method": "POST",
                "url": "server/v1/jwt/refresh",
                "data": {
                    token: tokenCookie.refresh
                },
                "headers": {
                    "Content-Type": "application/json",
                    "Authorization": tokenCookie.access
                }
            }).then((success) => {
                if(success.data !== "Still in use"){
                    let exp = new Date(); exp. setDate(exp. getDate() + 30);
                    let tokens = {};
                    tokens.access = success.data.access_token;
                    tokens.refresh = success.data.refresh_token;
                    $cookies.put('bk-tokens', JSON.stringify(tokens), {
                        path: '/',
                        secure: true,
                        samesite: 'strict',
                        expires: exp
                    });
                }
            }, (error) => {
                // console.log(error.data);
            });
        }
    }
});
app.service("fetches", function($rootScope, $http, $cookies){
    this.userDetails = function(){
        let tokenCookie = $cookies.get("bk-tokens", {path: '/'});
        if(tokenCookie === undefined){
            $rootScope.loggedInUser = {};
        } else {
            tokenCookie = JSON.parse(tokenCookie);
            $http({
                "method": "POST",
                "url": "server/v1/jwt/read-data",
                "headers": {
                    "Content-Type": "application/json",
                    "Authorization": tokenCookie.access
                }
            }).then((success) => {
                let jwtData = success.data.data;
                $http({
                    "method": "POST",
                    "url": "server/v1/users/details",
                    "data": {
                        "identifier": jwtData.emailAddress
                    },
                    "headers": {
                        "Content-Type": "application/json"
                    }
                }).then((success) => {
                    console.log(success.data);
                    $rootScope.loggedInUser = success.data;
                }, (error) => {
                    console.log(error.data);
                });
            }, (error) => {
                console.log(error.data);
            });
        }
    }
});