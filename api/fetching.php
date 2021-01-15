<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once 'config/Database.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

$fetch = $data->fetch;
@$orderId = $data->orderId;
@$n = $data->pageNo;
@$product_id = $data->productId;
@$aboutId = $data->aboutUs;
@$offers_upload = $data->path;

function fetchUsers($db)
{
    $query = "SELECT * FROM user ";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}


function fetchNotifications($db)
{
    $query = "SELECT * FROM notifications";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}

function fetchOrders($db, $n)
{
    $query = "SELECT o.id,o.status,o.date_ordered,u.phone FROM `orders` as o LEFT JOIN user as u on o.user_id = u.id ";
    $result = $db->prepare($query);
    $result->execute();
    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}



function fetchProducts($db)
{
    $query = "SELECT * FROM `product` WHERE `availability`= 1 ";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        $rows = array();

        // foreach ($row as $value) {

        //     $data=$value;
        //     $id=$value['category'];
        //     $q = "SELECT * FROM category WHERE id = $id";
        //     $result = $db->prepare($q);
        //     $result->execute();
        //     $image = $result->fetchAll(PDO::FETCH_ASSOC);
        //     $value["category"] = $image[0]["category"];
        //     $rows[]=$value;
        // }

        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}

function allorders($db)
{
    $query = "SELECT o.id,u.`name`,u.phone,a.landmark,a.line1,a.city,a.country,a.pincode,a.state,o.`status`,o.total,o.date_ordered,o.deliveryby FROM `orders` as o LEFT JOIN `user` as u on o.user_id = u.id 
    LEFT JOIN `address` as a on o.`address_id` =a.`id`";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}


function orderedProducts($db, $orderId)
{
    $query = "SELECT o.total,p.`name`,p.price FROM `order_items` as oi LEFT JOIN `orders` as o on oi.`order_id` = o.`id` LEFT JOIN
    `product` as p ON oi.`product_id`=p.`id`
    WHERE order_id=$orderId";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}

function fetchMedia_orders($db, $n)
{


    $query = "SELECT * FROM `media_order`";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}

function fetchDisabledProducts($db)
{
    $query = "SELECT * FROM `product` WHERE `availability`= 0 ";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        $rows = array();

        // foreach ($row as $value) {

        //     $data=$value;
        //     $id=$value['category'];
        //     $q = "SELECT * FROM category WHERE id = $id";
        //     $result = $db->prepare($q);
        //     $result->execute();
        //     $image = $result->fetchAll(PDO::FETCH_ASSOC);
        //     $value["category"] = $image[0]["category"];
        //     $rows[]=$value;
        // }
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}
function specificProduct($db, $product_id)
{
    $query = "SELECT * FROM `product` WHERE `id`= $product_id ";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}

function about_usSpecific($db, $aboutId)
{
    $query = "SELECT * FROM `about_us` WHERE id=$aboutId";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}
function about_us($db)
{
    $query = "SELECT * FROM `about_us`";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}
function offers($db)
{

    $query = "SELECT * FROM `offers`";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}


function offers_upload($db, $offers_upload)
{
    $query = "INSERT INTO `offers`(`image`,`title`) VALUES ('$offers_upload','edit');";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}

function fetchcategories($db, $n)
{
    $query = "SELECT * FROM `category`";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}

function fetchrestaurantcategories($db, $n)
{
    $query = "SELECT * FROM `restaurant_categories`";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}

function fetchitemcategories($db, $n)
{
    $query = "SELECT * FROM `item_categories`";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}

// function fetchcategoriesbyrestaurantid($db, $restaurantid)
// {
//     $query = "SELECT  c.type itemcategories
//     FROM    restaurants a
//             INNER JOIN item_categories c
//             ON FIND_IN_SET(c.id, a.categories) !=0
//             Where a.id=$restaurantid";
//     $result = $db->prepare($query);
//     $result->execute();

//     $noOfRows = $result->rowCount();
//     if ($noOfRows > 0) {
//         $row = $result->fetchAll(PDO::FETCH_ASSOC);
//         echo json_encode($row);
//     } else {
//         echo json_encode('');
//     }
// }


function fetchmediacategories($db, $n)
{
    $query = "SELECT * FROM `media_categories`";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}
function fetchitemcategoriesbyrestaurantid($db, $restaurantid)
{
    $query = "SELECT  
    distinct b.type category
    FROM    items a
    INNER JOIN item_categories b
    ON FIND_IN_SET(b.id, a.category) != 0
    Where a.restaurant_id='$restaurantid'
    GROUP   BY a.id;";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if ($noOfRows > 0) {
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    } else {
        echo json_encode('');
    }
}


switch ($fetch) {
    case 'orders':
        # code...
        fetchOrders($db, $n);
        break;
    case 'users':
        # code...
        fetchUsers($db);
        break;
    case 'notifications':
        # code...
        fetchNotifications($db);
        break;
    case 'enabledProducts':
        # code...
        fetchProducts($db);
        break;
    case 'disabledProducts':
        # code...
        fetchDisabledProducts($db);
        break;
    case 'allorders':
        # code...
        allorders($db);
        break;
    case 'orderedProducts':
        # code...
        orderedProducts($db, $orderId);
        break;
    case 'media_orders':
        # code...
        fetchMedia_orders($db, $n);
        break;
    case 'category':
        # code...
        fetchcategories($db, $n);
        break;
    case 'mediacategory':
        # code...
        fetchmediacategories($db, $n);
        break;
    case 'restaurantcategory':
        # code...
        fetchrestaurantcategories($db, $n);
        break;
    case 'itemcategory':
        # code...
        fetchitemcategories($db, $n);
        break;
    case 'specificProduct':
        # code...
        specificProduct($db, $product_id);
        break;
    case 'about_us':
        # code...
        about_us($db);
        break;
    case 'about_usSpecific':
        # code...
        about_usSpecific($db, $aboutId);
        break;
    case 'offers':
        # code...
        offers($db);
        break;
    case 'offers_upload':
        # code...
        offers_upload($db, $offers_upload);
        break;
    case 'fetchcategoriesbyrestaurantid':
        # code...
        fetchitemcategoriesbyrestaurantid($db, $n);
        break;

        //    default:
        //        # code...
        //        break;
}
