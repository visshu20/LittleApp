<?php

require_once("database/connection.php");




if (isset($_POST['action'])) {

    if ($_POST["action"] == "edit") {
        $product_id = $_POST["id"];
        $query = "SELECT * FROM `product` WHERE `id`= $product_id ";
        $result = $pdo->prepare($query);
        $result->execute();

        $noOfRows = $result->rowCount();
        if ($noOfRows > 0) {
            $row = $result->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode($row);
        } else {
            echo json_encode(
                array('message' => 'no data found')
            );
        }
    }
    if ($_POST["action"] == "add") {
        $data = $_POST['data'];
        $name = $data['productname'];
        $category = $data['category'];
        $original = $data['originalprice'];
        $Discount = $data['discountprice'];
        $sellingprice = $data['sellingprice'];
        $weight = $data['weight'];
        $path = $data['imageurl'];
        

        // $q = "SELECT * FROM category WHERE id = $category";
        // $result = $pdo->prepare($q);
        // $result->execute();
        // $image = $result->fetchAll(PDO::FETCH_ASSOC);
        // $path = $result[0]['image'];


        $qu = "INSERT INTO `product` 
        (`name`, `selling`, `original`, `discount`, `image`, `category`, `weight` ,`availability`)
        VALUES ('$name', '$sellingprice', '$original', '$Discount', '$path', '$category', '$weight',1);";
        @$result = $pdo->prepare($qu);
        @$result->execute();
        echo json_encode("product created succssfully");
    }

    if ($_POST["action"] == "update") {

        $data = $_POST['data'];
        $name = $data['productname'];
        $category = $data['category'];
        $original = $data['originalprice'];
        $Discount = $data['discountprice'];
        $sellingprice = $data['sellingprice'];
        $weight = $data['weight'];
        $path = $data['imageurl'];

        $id = $data["id"];

        // $q = "SELECT * FROM category WHERE id = $category";
        // $result = $pdo->prepare($q);
        // $result->execute();
        // $image = $result->fetchAll(PDO::FETCH_ASSOC);
        // $path = $image[0]['image'];

        $query = "UPDATE product
         SET name = '$name' , category = '$category' ,original = '$original'
         ,discount = '$Discount',selling = '$sellingprice',
         weight = '$weight', image = '$path'
         WHERE id= $id ";
        @$result = $pdo->prepare($query);
        @$result->execute();
        echo json_encode("product updated succssfully");
    }

    if ($_POST["action"] == "status") {

        $data = $_POST['data'];
        $id =  $data['id'];
        $status = $data['status'];

        $query = " UPDATE product SET `availability` = $status WHERE id = $id";
        $result = $pdo->prepare($query);
        $result->execute();
        echo json_encode($status);
    }

    if ($_POST["action"] == "mediaorders") {
        $id =  $_POST['id'];
        $query = "SELECT * FROM `media_order` WHERE `id`= $id";
        $result = $pdo->prepare($query);
        $result->execute();
        $noOfRows = $result->rowCount();
        if ($noOfRows > 0) {
            $row = $result->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode($row);
        } else {
            echo json_encode(
                array('message' => 'no data found')
            );
        }
    }

    if ($_POST["action"] == "updatemediaorder") {
        $data = $_POST['data'];
        $mobile = $data['mobile'];
        $deliveryby = $data['deliveryby'];
        $description = $data['description'];
        $orderdate = $data['orderdate'];
        $total = $data['total'];
        $status = $data['status'];
        $imageurl = $data['imageurl'];
        $id =  $data['id'];
        $query = "UPDATE media_order SET phone='$mobile',deliveryby='$deliveryby',description='$description',date_ordered='$orderdate',amount='$total',status='$status',image='$imageurl'  WHERE `id`= $id";
        $result = $pdo->prepare($query);
        $result->execute();
        echo json_encode("MediaOrder updated succssfully");
    }

    
}
