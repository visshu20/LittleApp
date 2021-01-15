<?php

require_once("../database/connection.php");

if (isset($_POST['action'])) {

    if ($_POST['action'] == "orderstatus") {
        $data = $_POST['data'];
        $order_status = $data['order_status'];
        $order_id = $data['order_id'];
        $type = $data['type'];

        if ($type == 'normal') {
            @$query = "UPDATE orders SET status = '$order_status' WHERE id=$order_id";
            @$result = $pdo->prepare($query);
            @$result->execute();
            echo json_encode("success");
        } else {

            @$query = "UPDATE media_order SET status = '$order_status' WHERE id=$order_id";
            @$result = $pdo->prepare($query);
            @$result->execute();
            echo json_encode("success");
        }
    }

    if ($_POST['action'] == "ordercancel") {
        $id = $_POST['id'];
        $qu = "UPDATE orders SET status='cancelled' WHERE id=$id";
        $result = $pdo->prepare($qu);
        $result->execute();
        echo json_encode("Order cancled");
    }

    if ($_POST['action'] == "vieworderedproducts") {
        $orderId = $_POST['id'];
        $query = "SELECT o.total,oi.quantity,p.selling,p.`name`,p.original FROM `order_items` as oi LEFT JOIN `orders` as o on oi.`order_id` = o.`id` LEFT JOIN
        `product` as p ON oi.`product_id`=p.`id`
        WHERE order_id=$orderId";
        $result = $pdo->prepare($query);
        $result->execute();

        $noOfRows = $result->rowCount();
        if ($noOfRows > 0) {
            $row = $result->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($row);
        } else {
            echo json_encode('');
        }
    }
    if ($_POST['action'] == "showalladdress") {
        $id = $_POST['id'];
        $query = "SELECT o.id,a.name,o.user_id,u.email,o.total,o.status,o.date_ordered,a.mobile,a.line1,a.city,a.state,a.country,a.pincode,a.landmark
    FROM orders as o
    INNER JOIN `address` as a
    ON o.address_id = a.id INNER JOIN `user` as u ON o.user_id = u.id  WHERE o.user_id=$id";
        $result = $pdo->prepare($query);
        $result->execute();

        $noOfRows = $result->rowCount();
        if ($noOfRows > 0) {
            $row = $result->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($row);
        } else {
            echo json_encode('');
        }
    }
    if ($_POST['action'] == "updatedeliveryby") {
       
        $data=$_POST['data'];
        $name=$data['name'];
        $id = $data['id'];

        $qu = "UPDATE orders SET deliveryby='$name' WHERE id=$id";
        $result = $pdo->prepare($qu);
        $result->execute();
        echo json_encode("Successfully Updated");
    }
    if ($_POST['action'] == "updatemediadeliveryby") {
       
        $data=$_POST['data'];
        $name=$data['name'];
        $id = $data['id'];

        $qu = "UPDATE media_order SET deliveryby='$name' WHERE id=$id";
        $result = $pdo->prepare($qu);
        $result->execute();
        echo json_encode("Successfully Updated");
    }
}
