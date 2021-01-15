$(document).ready(function () {
    window.onload = function () {
        var currentpath = window.location.pathname;

        // if (currentpath == "/Little_App_New/Index.php") {

        //     window.history.pushState(currentpath, 'Dashboard', '/Dashboad');
        // }


        // var Router = function (name, routes) {
        //     return {
        //         name: name,
        //         routes: routes
        //     }
        // };

        // var myFirstRouter = new Router('myFirstRouter', [
        //     {
        //         path: '/Dashboard',
        //         name: '/Dashboard'
        //     },
        //     {
        //         path: '/Orders',
        //         name: '/Orders'
        //     },
        //     {
        //         path: '/Product',
        //         name: '/Product'
        //     },
        //     {
        //         path: '/EnaledProduct',
        //         name: '/EnaledProduct'
        //     },
        //     {
        //         path: '/DisabledProduct',
        //         name: '/DisabledProduct'
        //     }


        // ]);




        switch (currentpath) {
            case '/enabledproduct': {
                showDiv();
                pageload("master/product.php");
            }
            case '/orders': {
                showDiv();
                pageload("master/order.php");
            }
        }

    }

});