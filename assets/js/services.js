app.service("security", function($cookies, $location){
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