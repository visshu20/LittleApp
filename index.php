<?php
require_once("database/connection.php");
require_once("database/curl_call.php");

if (!isset($_SESSION['id'])) {
    header('location:login.php');
} 

?>

<!DOCTYPE html>
<html>

<head>

    <?php
    if (!isset($_SESSION['id'])) {
        header('location:login.php');
    }
    ?>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Little App</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="assets/js/main.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="assets/toast_notifications/simply-toast.js"></script>
    <link rel="stylesheet" href="assets/toast_notifications/simply-toast.css" />
    <!-- <script src="assets/js/router.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">




    <!-- General JS Scripts -->

    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.nicescroll.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/stisla.js"></script>



    <!-- JS Libraies -->

    <!-- <script src=assets/js/jquery.sparkline.min.js"></script> -->
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/js/summernote/summernote-bs4.js"></script>
    <script src="assets/js/jquery.chocolat.min.js"></script>
    <script src="assets/js/orderaction.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>


    <!-- Template JS File -->
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/custom.js"></script>


    <!-- General CSS Files -->

    <link href="assets/css/all.css" rel="stylesheet" />
    <!-- <link href="assets/css/font-awsome.min.css" rel="stylesheet" /> -->


    <!-- CSS Libraries -->

    <link href="assets/js/jqv/jqvmap.min.css" rel="stylesheet" />
    <link href="assets/js/summernote/summernote-bs4.css" rel="stylesheet" />
    <link href="assets/js/owlcarousel/owl.carousel.min.css" rel="stylesheet" />
    <link href="assets/js/owlcarousel/owl.theme.default.min.css" rel="stylesheet" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">

    <!--<link href="assets/css/form.css" rel="stylesheet" />-->


    <style>
        /* Center the loader */
        #loader {
            position: absolute;
            left: 60%;
            top: 60%;
            z-index: 1;
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #956f00;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Add animation to "page content" */
        .animate-bottom {
            position: relative;
            -webkit-animation-name: animatebottom;
            -webkit-animation-duration: 1s;
            animation-name: animatebottom;
            animation-duration: 1s
        }

        @-webkit-keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0
            }

            to {
                bottom: 0px;
                opacity: 1
            }
        }

        @keyframes animatebottom {
            from {
                bottom: -100px;
                opacity: 0
            }

            to {
                bottom: 0;
                opacity: 1
            }
        }

        #content {
            display: none;
        }
    </style>


</head>

<body>

    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="../Little_App_New/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, Admin</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">

                            <a href="javascript:void(0)" class="dropdown-item has-icon" id="changepassword">
                                <i class="far fa-user"></i> Change Password
                            </a>

                            <div class="dropdown-divider"></div>
                            <a href="logout.php" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <img alt="image" src="../Little_App_New/assets/img/avatar/logo.jpg" class="rounded-circle" style="width:30px;">&nbsp;&nbsp;
                        <label style="font-weight:bold;font-size:15px;">Little App </lable>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <img alt="image" src="../Little_App_New/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1" style="width:30px">

                    </div>
                    <ul class="sidebar-menu">

                        <li class="nav-item">
                            <a id="dashboard" class="nav-link" href="javascript:void(0);"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="orders" class="nav-link has-dropdown" href="#"><i class="fas fa-archive"></i> <span>Orders</span></a>
                            <ul class="dropdown-menu">
                                <li><a id="normalorders" class="nav-link" href="#">Normal Orders</a></li>
                                <li><a id="mediaorders" class="nav-link" href="#">MediaOrders</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="productdetails" class="nav-link has-dropdown" href="#"><i class="fas fa-list"></i> <span>Product Details</span></a>
                            <ul class="dropdown-menu">
                                <li><a id="enabledproduct" class="nav-link" href="#">Enabled Products</a></li>
                                <li><a id="disableproduct" class="nav-link" href="#">Disabled Products</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="productdetails" class="nav-link has-dropdown" href="#"><i class="fas fa-list"></i> <span>Categories</span></a>
                            <ul class="dropdown-menu">
                                <li><a id="categories" class="nav-link" href="#">Normal Categories</a></li>
                                <li><a id="mediacategories" class="nav-link" href="#">Midia Categories</a></li>
                                <li><a id="restaurantcategory" class="nav-link" href="#">Restaurant Categories</a></li>
                                <!-- <li><a id="itemcategory" class="nav-link" href="#">Item Categories</a></li> -->
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a id="users" class="nav-link" href="javascript:void(0);"><i class="fas fa-user"></i> <span>Users</span></a>
                        </li>
                        <li class="nav-item">
                            <a id="offers" class="nav-link" href="javascript:void(0);"><i class="fas fa-gift"></i> <span>Offers</span></a>
                        </li>
                        <li class="nav-item">
                            <a id="notification" class="nav-link" href="javascript:void(0);"><i class="fas fa-bell"></i> <span>Notification</span></a>
                        </li>
                        <li class="nav-item">
                            <a id="restaurant" class="nav-link" href="javascript:void(0);"><i class="fas fa-utensils"></i> <span>Restaurants</span></a>
                        </li>
                    </ul>
                </aside>
            </div>

            <div id="loader"></div>

            <div id="content" class="main-content">

            </div>

            <!-- <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="#">Vishal G</a>
                </div>
                <div class="footer-right">
                    2.3.0
                </div>
            </footer> -->
        </div>
    </div>


</body>
<form id='changepasswordform' class="needs-validation" novalidate="">
    <div class="modal fade bd-example-modal-lg" id="changepasswordModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changepasswordTitle">Offers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="changepasswordModelclose1">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="password" class="form-control" id="_oldpassword" name="oldpassword" placeholder="Old Password">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="password" class="form-control" id="_changepassword" name="changepassword" placeholder="Change Password">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <input type="password" class="form-control" id="_confirmpassword" name="confirmpassword" placeholder="ConfimPassword">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="changepasswordModelclose2">Close</button>
                    <button type="button" class="btn btn-primary" id="changepasswordsave">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
     
        var mySessionId = '<%=Session.SessionID%>';
        $("#changepassword").click(function() {
            $('#changepasswordModel').modal('show');
        });

        $("#changepasswordModelclose1,#changepasswordModelclose2").click(function() {
            $('#changepasswordform').find('input:password').val('');
            validator.resetForm();
        });

        $("#changepassword").click(function() {
            $('#changepasswordModel').modal('show');
        });

        $("#changepasswordsave").click(function() {
       
            if ($("#changepasswordform").valid()) {
                var oldpassword = $("#_oldpassword").val();
                var changepassword = $("#_changepassword").val();
                var cofirmpassword = $("#_confirmpassword").val();

                var data = {
                    oldpassword: oldpassword,
                    changepassword: changepassword,
                    cofirmpassword: cofirmpassword
                };

                $.ajax({
                    url: BaseURL + "/actions.php",
                    method: "POST",
                    data: {
                        data: data,
                        action: "updatepassword"
                    },
                    dataType: "json",
                    success: function(response) {

                        if (response == "Invalid Old Password") {
                            $.simplyToast(response, 'success');
                        } else {
                            $('#changepasswordModel').modal('hide');
                            $.simplyToast(response, 'success');
                            $('#changepasswordform').find('input:text').val('');
                            validator.resetForm();
                        }
                    }
                });
            }
        });

        var validator = $("#changepasswordform").validate({
            rules: {
                oldpassword: "required",
                changepassword: "required",
                confirmpassword: {
                    required: true,
                    equalTo: '[name="changepassword"]'
                }
            },
            messages: {
                oldpassword: "Please enter your oldpassword",
                changepassword: "Please enter changepassword",
                confirmpassword: "Please check confirmpassword"

            }
        });


    });
</script>


</html>