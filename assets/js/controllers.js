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
        "url": "server/v1/commodities/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.commodities = success.data;
        console.log($scope.commodities);
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
        // xui.modal.hide("filterCategoryModal");
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

app.controller("marketplace-details-controller", function($scope, $rootScope, $location, $cookies, $routeParams, $timeout, $http){
    $scope.bookData = {};
    $http({
        "method": "POST",
        "url": "server/v1/commodities/fetch",
        "data": {
            "identifier": $routeParams.identifier
        },
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        $scope.commodityDetails = success.data;
        console.log($scope.commodityDetails);
        $timeout(() =>{
            xui.reveal.images();
            
        })
    }, (error) => {
        console.log(error);
    });
    // a and b are javascript Date objects
    function dateDiffInDays(a, b) {
        const _MS_PER_DAY = 1000 * 60 * 60 * 24;
        // Discard the time and time-zone information.
        const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
        const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());
    
        return Math.floor((utc2 - utc1) / _MS_PER_DAY);
    }
    function payWithPaystack(amount) {
        let handler = PaystackPop.setup({
            key: 'pk_test_eb4f265077adbc7c1d3ef73be8fa77503c8a3a8a', // Replace with your public key
            email: "percy6d@gmail.com",
            amount: amount * 100,
            // ref: 'ref-'+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            // label: "Optional string that replaces customer email"
            onClose: function(){
            alert('Cancelling booking...');
            },
            callback: function(response){
            let message = 'Payment complete! Reference: ' + response.reference;
            alert(message);
            $http({
                "method": "POST",
                "url": "server/v1/bookings/create-new",
                "data": $scope.bookData,
                "header": {
                    "Content-Type": "application/json"
                }
            })
            .then((success) => {
                console.log(success.data);
                $timeout(() =>{
                    $location.path("dashboard/overview");
                })
            }, (error) => {
                console.log(error);
            });
            }
        });
        handler.openIframe();
    }
    $scope.bookNow = () => {
        let tokenCookie = $cookies.get("bk-tokens", {path: '/'});
        if(tokenCookie === undefined || tokenCookie.length <= 2){
            alert("Please log in before creating a booking");
        } else {
            $scope.bookData.commodityID = $scope.commodityDetails.id;
            $scope.bookData.userID = $rootScope.loggedInUser.id;
            const a = new Date($scope.bookData.dateFrom),
            b = new Date($scope.bookData.dateTo),
            difference = dateDiffInDays(a, b);
            payWithPaystack($scope.commodityDetails.price * difference);
        }
    }

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

app.controller("payment-history-controller", function($scope, $rootScope, $route, $timeout, $http){
    $rootScope.pageTitle = "Payment History";
    $http({
        "method": "GET",
        "url": "server/v1/payment-history/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        console.log(success);
        $scope.paymentHistory = success.data;
        console.log($scope.paymentHistory);
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
app.controller("dashboard-bookings-controller", function($rootScope, $timeout, $http, $scope){
    console.log($rootScope.loggedInUser);
    $rootScope.pageTitle = "Bookings"
    angular.element(document).ready(()=>{
		xui.run();
        
	});
});
app.controller("host-overview-controller", function($rootScope, $timeout, $http, $scope){
    $rootScope.pageTitle = "Bookings"
    angular.element(document).ready(()=>{
		xui.run();
        
	});
});
app.controller("host-commodities-controller", function($rootScope, $route, $timeout, $http, $scope){
    $rootScope.pageTitle = "Commodities";

    $http({
        "method": "GET",
        "url": "server/v1/commodities/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        console.log(success);
        $scope.getCommodities = success.data;
        console.log($scope.getCommodities);
    }, (error) => {
        console.log(error);
    });

    $http({
        "method": "GET",
        "url": "server/v1/categories/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        console.log(success);
        $scope.getCategories = success.data;
        console.log($scope.getCategories);
        $scope.selectCategory = $scope.getCategories[0];
    }, (error) => {
        console.log(error);
    });

    $http({
        "method": "GET",
        "url": "server/v1/types/fetch-all",
        "header": {
            "Content-Type": "application/json"
        }
    })
    .then((success) => {
        console.log(success);
        $scope.getTypes = success.data;
        console.log($scope.getTypes);
        $scope.selectType = $scope.getTypes[0];
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
        console.log(success);
        $scope.getUsers = success.data;
        console.log($scope.getUsers);
        $scope.selectUser = $scope.getUsers[0];
    }, (error) => {
        console.log(error);
    });

    $scope.newImage = {};
    $scope.imageURLArray = [];
    $scope.addImages = function() {
        $scope.imageURLArray.push(angular.copy($scope.newImage.url));
        $scope.newImage = {};
        console.log($scope.imageURLArray);
    };

    $scope.addCommodity = (commodityname, userid, categoryid, typeid) => {
        $scope.commodityName = commodityname;
        $scope.categoryID = categoryid;
        $scope.userID = userid;
        $scope.typeID = typeid;


        console.log($scope.commodityName, $scope.categoryID, $scope.userID, $scope.typeID);
        $http({
            "method": "POST",
            "url": "server/v1/commodities/create-new",
            "data": {
                "name": $scope.commodityName,
                "userID": $scope.userID,
                "categoryID": $scope.categoryID,
                "typeID": $scope.typeID,
                "images": $scope.imageURLArray
            },
            "header": {
                "Content-Type": "application/json"
            }
        })
        .then((success) => {
            console.log(success);
            xui.animate.default("successBox"); 
            $scope.success = "Commodity created";
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

    angular.element(document).ready(()=>{
		xui.run();
        
	});
});

app.controller("navbarCtrl", function($rootScope, $scope, $location){
    $scope.path = $location.path();
    $scope.MKPath = $rootScope.bookinguid;
    console.log($scope.path, $scope.MKPath);
});

