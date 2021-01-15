<?php
   header('Access-Control-Allow-Origin: *');
   header('Content-Type: application/json');
   header('Access-Control-Allow-Methods: POST');
   header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
   
   include_once 'config/Database.php';
   
   $database=new Database();
   $db=$database->connect();
   
   $data = json_decode(file_get_contents("php://input"));
   
   $id = $data->fetch;

   function fetchAllUserOrders($db,$id){
        $query = "SELECT o.id,a.name,o.user_id,o.total,o.`status`,o.date_ordered,a.mobile,a.line1,a.city,a.state,a.country,a.pincode,a.landmark
        FROM `orders` as o INNER JOIN `address` as a ON o.address_id = a.id
        WHERE o.user_id=$id";
    $result = $db->prepare($query);
    $result->execute();

    $noOfRows = $result->rowCount();
    if($noOfRows>0){
        $row = $result->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($row);
    }else{
        echo json_encode('');
    }
}

fetchAllUserOrders($db,$id);
