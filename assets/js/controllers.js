app.controller("intro-controller", function($rootScope, $scope){

});
app.controller("register-controller", function($rootScope, $scope, $http, $cookies, $timeout, $location){
    // Creating an empty object to store form details
    $scope.user = {};

    // Get user details and create an account via API
    $scope.createUser = () => {
        // Make submit button disabled
        $scope.isLoading = true;
        // Changing submit text
        $scope.defaultFormText = "Submitting...";
        $http({
            "method": "POST",
            "url": "server/v1/users/create-new",
            "data": $scope.user,
            "headers": {
                "Content-Type": "application/json"
            }
        }).then((success) => {
            let exp = new Date(); exp. setDate(exp. getDate() + 30);
            $scope.tokens = {};
            $scope.tokens.access = success.data.access_token;
            $scope.tokens.refresh = success.data.refresh_token;
            $cookies.put('bk-tokens', JSON.stringify($scope.tokens), {
                path: '/',
                secure: true,
                samesite: 'strict',
                expires: exp}
            );
            $scope.defaultFormText = "Setting up your dashboard...";
            $timeout(() => {
                $location.path("/dashboard/overview");
            }, 3000);
        }, (error) => {
            $scope.errMsg = error.data;
            xuiAnime("errorBox");
            $scope.isLoading = false;
            $scope.defaultFormText = "Create Account";
        });
    }
});
app.controller("login-controller", function($rootScope, $scope, $http, $cookies, $timeout, $location){
    // Creating an empty object to store form details
    $scope.user = {};

    // Get user details and create an account via API
    $scope.authUser = () => {
        // Make submit button disabled
        $scope.isLoading = true;
        // Changing submit text
        $scope.defaultFormText = "Submitting...";
        $http({
            "method": "POST",
            "url": "server/v1/users/authorize",
            "data": $scope.user,
            "headers": {
                "Content-Type": "application/json"
            }
        }).then((success) => {
            let exp = new Date(); exp. setDate(exp. getDate() + 30);
            $scope.tokens = {};
            $scope.tokens.access = success.data.access_token;
            $scope.tokens.refresh = success.data.refresh_token;
            $cookies.put('bk-tokens', JSON.stringify($scope.tokens), {
                path: '/',
                secure: true,
                samesite: 'strict',
                expires: exp}
            );
            $scope.defaultFormText = "Setting up your dashboard...";
            $timeout(() => {
                $location.path("/dashboard/overview");
            }, 3000);
        }, (error) => {
            $scope.errMsg = error.data;
            xuiAnime("errorBox");
            $scope.isLoading = false;
            $scope.defaultFormText = "Log into your account";
        });
    }
});
app.controller("marketplace-controller", function($scope, $rootScope, $route, $timeout, $http){
    $http({
        "method": "GET",
        "url": "server/v1/bookings/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.bookings = success.data;
        console.log($scope.bookings);
        $timeout(() =>{
            xui.reveal.images();
            
        })
    }, (error) => {
        console.log(error);
    });

    $scope.showMP = (MKUID) => {
        $rootScope.bookinguid = MKUID;
        console.log($rootScope.bookinguid);
    }

    $http({
        "method": "GET",
        "url": "server/v1/categories/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.categories = success.data;
        console.log($scope.categories);
        $scope.selectCategory = $scope.categories[0];
    }, (error) => {
        console.log(error);
    });
    
    $scope.filterCategory = (selectCat) => {
        console.log(selectCat);
        $http({
            "method": "GET",
            "url": "server/v1/bookings/fetch-all",
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            $scope.bookings = success.data;
            for(let i=0; i < $scope.bookings.length; i++){
                if(selectCat.id == $scope.bookings[i].commodity.category.id){
                    $scope.bookings[i].id = selectCat.id;
                    
                    $timeout(() =>{
                        xui.reveal.images();
                        xui.modal.hide("filterCategoryModal");
                    })
                    console.log("Yes");
                    // console.log($scope.bookings[i]);
                }
                else{
                    $scope.bookings.length = 0;
                    console.log("No");
                }
                
            }
        }, (error) => {
            console.log(error);
        });

    }

    angular.element(document).ready(()=>{
		xui.run();
	});
});

app.controller("marketplace-details-controller", function($scope, $rootScope, $route, $routeParams, $timeout, $http){
    $http({
        "method": "POST",
        "url": "server/v1/bookings/fetch",
        "data": {
            "identifier": $routeParams.identifier
        },
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.bookingsDetails = success.data;
        console.log($scope.bookingsDetails);
        $timeout(() =>{
            xui.reveal.images();
            
        })
    }, (error) => {
        console.log(error);
    });


    angular.element(document).ready(()=>{
		xui.run();
	});
});
app.controller("services-controller", function($scope, $http){
    $http({
        "method": "GET",
        "url": "server/v1/categories/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.categories = success.data;
    }, (error) => {
        console.log(error);
    });
});
app.controller("categories-controller", function($scope, $rootScope, $route, $timeout, $http){
    $rootScope.pageTitle = "Categories";
    $http({
        "method": "GET",
        "url": "server/v1/categories/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.getAllCategories = success.data;
        console.log($scope.getAllCategories);
        $timeout(() =>{
            xui.reveal.images();
            
        })
    }, (error) => {
        console.log(error);
    });
    
    $scope.cat = {};
    $scope.addCategories = () => {
        isCategoryDisabled = true;
        console.log($scope.cat.name);
        $http({
            "method": "POST",
            "url": "server/v1/categories/create-new",
            "data": {
                "name": $scope.cat.name
            },
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            console.log(success);
            $scope.getAllCategories = success.data;
            console.log($scope.getAllCategories);
            xui.animate.default("successBox"); 
            $scope.success = $scope.getAllCategories;
            $timeout(() => {
            $route.reload();
            }, 2000)
            $timeout(() =>{
                xui.reveal.images();
                
            })
        }, (error) => {
            console.log(error);
            isCategoryDisabled = false;
        });
    }

    $scope.showCategories = (cat) => {
        $scope.catName = cat.name;
        $scope.catUID = cat.uid;
        console.log( $scope.catName,  $scope.catUID);
    }

    $scope.editCategories = () => {
        console.log($scope.cat.name);
        $http({
            "method": "POST",
            "url": "server/v1/categories/update",
            "data": {
                "uid":  $scope.catUID,
                "name": $scope.catName
            },
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            console.log(success);
            xui.animate.default("successBox"); 
            $scope.success = "Category updated";
            $timeout(() => {
            $route.reload();
            }, 2000)
            $timeout(() =>{
                xui.reveal.images();
                
            })
        }, (error) => {
            console.log(error);
        });
    }

    $scope.deleteCategories = (catUID) => {
        $scope.catUID = catUID;
        isCategoryDisabled = true;
        console.log($scope.catUID);
        $http({
            "method": "POST",
            "url": "server/v1/categories/delete",
            "data": {
                "uid": $scope.catUID
            },
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            console.log(success);
            xui.animate.default("successBox"); 
            $scope.success = "Category deleted";
            $timeout(() => {
            $route.reload();
            }, 2000)
        }, (error) => {
            console.log(error);
            isCategoryDisabled = false;
        });
    }

    angular.element(document).ready(()=>{
		xui.run();
	});
});

app.controller("commodities-controller", function($scope, $rootScope, $route, $timeout, $http){
    $rootScope.pageTitle = "Commodities";
    $http({
        "method": "GET",
        "url": "server/v1/commodities/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.getAllCommodities = success.data;
        console.log($scope.getAllCommodities);
        $timeout(() =>{
            xui.reveal.images();
            
        })
    }, (error) => {
        console.log(error);
    });

    $scope.verifyCommodities = (commodityUID) => {
        $scope.commodityUID = commodityUID;
        console.log($scope.commodityUID);
        $http({
            "method": "POST",
            "url": "server/v1/commodities/verify",
            "data": {
                "uid": $scope.commodityUID
            },
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            console.log(success);
            xui.animate.default("successBox"); 
            $scope.success = "Commodity Verified";
            $timeout(() => {
            $route.reload();
            }, 2000)
        }, (error) => {
            console.log(error);
            isCategoryDisabled = false;
        });
    }

    $scope.flagCommodities = (commodityUID) => {
        $scope.commodityUID = commodityUID;
        console.log($scope.commodityUID);
        $http({
            "method": "POST",
            "url": "server/v1/commodities/flag",
            "data": {
                "uid": $scope.commodityUID
            },
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            console.log(success);
            xui.animate.default("successBox"); 
            $scope.success = "Commodity Restricted";
            $timeout(() => {
            $route.reload();
            }, 2000)
        }, (error) => {
            console.log(error);
            isCategoryDisabled = false;
        });
    }

    $scope.deleteCommodities = (commodityUID) => {
        $scope.commodityUID = commodityUID;
        console.log($scope.commodityUID);
        $http({
            "method": "POST",
            "url": "server/v1/commodities/delete",
            "data": {
                "uid": $scope.commodityUID
            },
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            console.log(success);
            xui.animate.default("successBox"); 
            $scope.success = "Commodity Deleted";
            $timeout(() => {
            $route.reload();
            }, 2000)
        }, (error) => {
            console.log(error);
            isCategoryDisabled = false;
        });
    }

    angular.element(document).ready(()=>{
		xui.run();
	});
});

app.controller("types-controller", function($scope, $rootScope, $route, $timeout, $http){
    $rootScope.pageTitle = "Types";
    $http({
        "method": "GET",
        "url": "server/v1/types/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.getAllTypes = success.data;
        console.log($scope.getAllTypes);
        $timeout(() =>{
            xui.reveal.images();
            
        })
    }, (error) => {
        console.log(error);
    });
    
    $scope.type = {};
    $scope.addTypes = () => {
        isCategoryDisabled = true;
        console.log($scope.type.name);
        $http({
            "method": "POST",
            "url": "server/v1/types/create-new",
            "data": {
                "name": $scope.type.name
            },
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            console.log(success);
            $scope.getAllTypes = success.data;
            console.log($scope.getAllTypes);
            xui.animate.default("successBox"); 
            $scope.success = $scope.getAllTypes;
            $timeout(() => {
            $route.reload();
            }, 2000)
            $timeout(() =>{
                xui.reveal.images();
                
            })
        }, (error) => {
            console.log(error);
            isCategoryDisabled = false;
        });
    }

    $scope.showTypes = (type) => {
        $scope.typeName = type.name;
        $scope.typeUID = type.uid;
        console.log( $scope.typeName,  $scope.typeUID);
    }

    $scope.editTypes = () => {
        console.log($scope.type.name);
        $http({
            "method": "POST",
            "url": "server/v1/types/update",
            "data": {
                "uid":  $scope.typeUID,
                "name": $scope.typeName
            },
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            console.log(success);
            xui.animate.default("successBox"); 
            $scope.success = "Type updated";
            $timeout(() => {
            $route.reload();
            }, 2000)
            $timeout(() =>{
                xui.reveal.images();
                
            })
        }, (error) => {
            console.log(error);
        });
    }

    $scope.deleteTypes = (typeUID) => {
        $scope.typeUID = typeUID;
        isCategoryDisabled = true;
        console.log($scope.typeUID);
        $http({
            "method": "POST",
            "url": "server/v1/types/delete",
            "data": {
                "uid": $scope.typeUID
            },
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            console.log(success);
            xui.animate.default("successBox"); 
            $scope.success = "Type deleted";
            $timeout(() => {
            $route.reload();
            }, 2000)
        }, (error) => {
            console.log(error);
        });
    }

    angular.element(document).ready(()=>{
		xui.run();
	});
});

app.controller("users-controller", function($scope, $rootScope, $route, $timeout, $http){
    $rootScope.pageTitle = "Users";
    $http({
        "method": "GET",
        "url": "server/v1/users/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        console.log(success);
        $scope.getAllUsers = success.data;
        console.log($scope.getAllUsers);
    }, (error) => {
        console.log(error);
    });

    angular.element(document).ready(()=>{
		xui.run();
	});
})

app.controller("bookings-controller", function($scope, $rootScope, $route, $timeout, $http){
    $rootScope.pageTitle = "Bookings";
    $http({
        "method": "GET",
        "url": "server/v1/commodities/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.getCommodities = success.data;
        console.log($scope.getCommodities);
        $timeout(() =>{
            xui.reveal.images();
            
        })
    }, (error) => {
        console.log(error);
    });

    $http({
        "method": "GET",
        "url": "server/v1/users/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.getUsers = success.data;
        console.log($scope.getUsers);
        $timeout(() =>{
            xui.reveal.images();
            
        })
    }, (error) => {
        console.log(error);
    });

    $http({
        "method": "GET",
        "url": "server/v1/bookings/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.getAllBookings = success.data;
        console.log($scope.getAllBookings);
        $timeout(() =>{
            xui.reveal.images();
            
        })
    }, (error) => {
        console.log(error);
    });
    
    $scope.booking = {};
    $scope.addBookings = (commodityid, userid) => {
        $scope.commodityid = commodityid
        $scope.userid = userid;
        console.log($scope.booking.dateFrom, $scope.booking.dateTo, $scope.commodityid, $scope.userid);
        $scope.booking.commodityID = $scope.commodityid;
        $scope.booking.userID = $scope.userid;
        console.log($scope.booking);
        $http({
            "method": "POST",
            "url": "server/v1/Bookings/create-new",
            "data": $scope.booking,
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            console.log(success);
            $scope.getAllBookings = success.data;
            console.log($scope.getAllBookings);
            xui.animate.default("successBox"); 
            $scope.success = "Bookings created"
            $timeout(() => {
            $route.reload();
            }, 2000)
            $timeout(() =>{
                xui.reveal.images();
                
            })
        }, (error) => {
            console.log(error);
            ;
        });
    }

    $scope.showBookings = (booking) => {
        $scope.bookingName = booking.name;
        $scope.bookingUID = booking.uid;
        console.log( $scope.bookingName,  $scope.bookingUID);
    }


    angular.element(document).ready(()=>{
		xui.run();
	});
});
app.controller("dashboard-overview-controller", function($rootScope, $scope){
    $scope.user = {};
    $scope.submitBasicInfo = () => {
        $scope.isDisabled = true;
    }
});
app.controller("navbarCtrl", function($rootScope, $scope, $location){
    $scope.path = $location.path();
    $scope.MKPath = $rootScope.bookinguid;
    console.log($scope.MKPath);
});

