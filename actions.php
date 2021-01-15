<?php

use function PHPSTORM_META\type;

require_once("database/connection.php");

if (isset($_POST['action'])) {

    if ($_POST["action"] == "delete_notification") {
        $data = $_POST['data'];
        $qu = "DELETE FROM `notifications` 
        WHERE id=$data;";
        @$result = $pdo->prepare($qu);
        @$result->execute();
        echo json_encode("notification deleted succssfully");
    }

    if ($_POST["action"] == "delete_offers") {
        $data = $_POST['data'];
        $qu = "DELETE FROM `offers` 
        WHERE id=$data;";
        @$result = $pdo->prepare($qu);
        @$result->execute();
        echo json_encode("offer deleted succssfully");
    }

    if ($_POST["action"] == "updatepassword") {
        $data = $_POST['data'];
        $Id = $_SESSION['id'];
        $oldpassword = $data['oldpassword'];
        $changepassword = $data['changepassword'];
        $cofirmpassword = $data['cofirmpassword'];
        $query = "SELECT * FROM aadmin WHERE id = '$Id' AND password = '$oldpassword'";
        $result = $pdo->prepare($query);
        $result->execute();

        $noOfRows = $result->rowCount();
        if ($noOfRows > 0) {
            $query = "UPDATE aadmin SET password = '$changepassword' WHERE id= $Id";
            @$result = $pdo->prepare($query);
            @$result->execute();
            echo json_encode("Password updated succssfully");
        } else {
            echo json_encode("Invalid Old Password");
        }
    }


    if ($_POST["action"] == "insertcategory") {
        $msg;
        $qu;
        $data = $_POST['data'];
        $category = $data['categorie'];
        $type = $data['type'];
        if ($type == "normal" && $type = "media")
            $image = $data['image'];


        switch ($type) {
            case "normal":
                $qu = "INSERT INTO `category` (`category`,`image`) VALUES ('$category','$image')";
                $msg = "Category";
                break;
            case "media":
                $qu = "INSERT INTO `media_categories` (`category`,`image`) VALUES ('$category','$image')";
                $msg = "Media Category";
                break;
            case "restaurant":
                $qu = "INSERT INTO `restaurant_categories` (`type`) VALUES ('$category')";
                $msg = "Restaurant Category";
                break;
            case "item":
                $qu = "INSERT INTO `item_categories` (`type`) VALUES ('$category')";
                $msg = "Item Category";
                break;
            default:
                break;
        }

        @$result = $pdo->prepare($qu);
        @$result->execute();
        echo json_encode("$msg  added succssfully");
    }

    if ($_POST["action"] == "updatecategory") {
        $msg;
        $qu;
        $data = $_POST['data'];
        $id = $data['id'];
        $category = $data['categorie'];
        $type = $data['type'];
        if ($type == "normal" && $type = "media")
            $image = $data['image'];


        $type = $data['type'];

        switch ($type) {
            case "normal":
                $qu = "UPDATE `category` SET category='$category',image='$image' WHERE id=$id;";
                $msg = "Category";
                break;
            case "media":
                $qu = "UPDATE `media_categories` SET category='$category',image='$image' WHERE id=$id;";
                $msg = "Media Category";
                break;
            case "restaurant":
                $qu = "UPDATE `restaurant_categories` SET type='$category' WHERE id=$id;";
                $msg = "Restaurant Category";
                break;
            case "item":
                $qu = "UPDATE `item_categories` SET type='$category' WHERE id=$id;";
                $msg = "Item Category";
                break;
            default:
                break;
        }

        @$result = $pdo->prepare($qu);
        @$result->execute();
        echo json_encode("$msg updated succssfully");
    }

    if ($_POST["action"] == "getcategory") {
        $query;
        $id =  $_POST['id'];
        $type = $_POST['type'];

        if ($type == 'normal') {
            $query = "SELECT * FROM `category` WHERE `id`= $id";
        } else {
            $query = "SELECT * FROM `media_categories` WHERE `id`= $id";
        }

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

    if ($_POST["action"] == "deletecategory") {
        $msg;
        $id =  $_POST['id'];
        $type = $_POST['type'];
        $query;
        switch ($type) {
            case 'normal':
            case 'media':
                $query = "DELETE FROM `category` WHERE `id`= $id";
                $msg = $type + "Category";
                break;
            case 'restaurant':
                $query = "DELETE FROM `restaurant_categories` WHERE `id`= $id";
                $msg = "Restaurant Category";
                break;
            case 'item':
                $query = "DELETE FROM `item_categories` WHERE `id`= $id";
                $msg = "Item Category";
                break;
        }

        $result = $pdo->prepare($query);
        $result->execute();
        $noOfRows = $result->rowCount();
        echo json_encode("$msg deleted succssfully");
    }



    if ($_POST["action"] == "pincodeaction") {
        $qu;
        $msg;
        $id = $_POST['id'];
        $pincode = $_POST['pincode'];
        $type = $_POST['type'];

        if ($type == "insert") {
            $qu = "INSERT INTO `pincode` (`pincode`) VALUES ('$pincode');";
            $msg = "added";
        } else {
            $qu = "UPDATE `pincode` SET `pincode`='$pincode' where id='$id';";
            $msg = "updated";
        }

        @$result = $pdo->prepare($qu);
        @$result->execute();
        echo json_encode("Pincode $msg succssfully");
    }

    if ($_POST["action"] == "restaurant_action") {
        $msg;

        $data = $_POST['data'];
        $name = $data['name'];
        $restaurantcategory = $data['restaurantcategory'];
        $itemtype = $data['type'];
        $minorder = $data['minorder'];
        $deliverytime = $data['deliverytime'];
        $phone = $data['phone'];
        $restaurantioc = $data['restaurantioc'];
        $restaurantimage = $data['restaurantimage'];
        $status = $data['status'];
        $type = $data['actionType'];

        if ($type == "insert") {
            $qu = "INSERT INTO `restaurants` (`image`,`name`,`type`,`categories`,`min_order`,`delivery_time`,`phone`,`restaurant_loc`,`active`) VALUES ('$restaurantimage','$name','$itemtype','$restaurantcategory','$minorder','$deliverytime','$phone','$restaurantioc','$status');";
            $msg = "added";
        } else {
            $id = $data['restaurantid'];
            $qu = "UPDATE `restaurants` SET `image`='$restaurantimage',`name`='$name',`type`='$itemtype',`categories`='$restaurantcategory',`min_order`='$minorder' ,`delivery_time`='$deliverytime',`phone`='$phone',`restaurant_loc`='$restaurantioc',`active`='$status' where id='$id';";
            $msg = "updated";
        }

        @$result = $pdo->prepare($qu);
        @$result->execute();
        echo json_encode("Restaurant $msg succssfully");
    }

    if ($_POST["action"] == "restaurant_item_action") {
        $data = $_POST['data'];
        $msg;
        $name = $data['name'];
        $itemcategory = $data['itemcategory'];
        $type = $data['type'];
        $price = $data['price'];
        $quantity = $data['quantity'];
        $status = $data['status'];
        $itemimage = $data['itemimage'];
        $restaurantid=$data['restaurantid'];
        $actionType = $data['actionType'];

        if ($actionType == "insert") {
            $qu = "INSERT INTO `items` (`type`,`image`,`name`,`category`,`active`,`price`,`quantity`,`restaurant_id`) VALUES ('$type','$itemimage','$name','$itemcategory','$status','$price','$quantity','$restaurantid');";
            $msg = "added";
        } else {
            $id=$data['itemid'];
            $qu = "UPDATE `Items` SET type='$type',image='$itemimage',name='$name',category='$itemcategory',active='$status',price='$price',quantity='$quantity' where id='$id';";
            $msg = "updated";
        }

        @$result = $pdo->prepare($qu);
        @$result->execute();
        echo json_encode("Item $msg succssfully");
    }
    if ($_POST["action"] == "restaurant_item_get") {
        $id =  $_POST['id'];
        $query = "SELECT * FROM `items` WHERE `id`= $id";
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
    if ($_POST["action"] == "restaurant_restaurant_get") {
        $id =  $_POST['id'];
        $query = "SELECT * FROM `restaurants` WHERE `id`= $id";
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
}
