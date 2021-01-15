<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('location: login.php');
}
if (isset($_COOKIE['restaurantid'])) {
    unset($_COOKIE['restaurantid']);
    setcookie('restaurantid', '', time() - 3600, '/');
}
session_destroy();
header('location: login.php');
