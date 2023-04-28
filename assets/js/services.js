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
                if(typeof success.data === 'object' && success.data !== null){
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
app.service("fetches", function($rootScope, $timeout, $http, $cookies, security){
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
                console.log(jwtData);
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
                    $rootScope.loggedInUser = success.data;
                    console.log($rootScope.loggedInUser);
                    $http({
                        "method": "POST",
                        "url": "server/v1/bookings/user",
                        "data": {
                            "userID": $rootScope.loggedInUser.id
                        },
                        "header": {
                            "Content-Type": "application/json"
                        }
                    })
                    .then((success) => {
                        console.log(success);
                        $rootScope.getUserbookings = success.data;
                        $timeout(() => {
                            xui.reveal.images();
                        })
                        console.log($rootScope.getUserbookings);
                    }, (error) => {
                        console.log(error);
                    });
                }, (error) => {
                    // console.log(error.data);
                });
            }, (error) => {
                console.log(error.data);
                security.refreshToken();
            });
        }
    }
});