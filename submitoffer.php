<?php

require_once("database/connection.php");

if (isset($_POST['action'])) {

    if ($_POST["action"] == "submitoffer") {
        $data = $_POST['data'];
        $qu = "INSERT INTO `offers` (`image_url`,`title`) VALUES ('$data','new');";
        @$result = $pdo->prepare($qu);
        @$result->execute();
        echo json_encode("offer submited succssfully");
    }
    
    if ($_POST["action"] == "savenotification") {
        $data = $_POST['data'];
        $qu = "INSERT INTO `notifications` (`notification`) VALUES ('$data');";
        @$result = $pdo->prepare($qu);
        @$result->execute();
        echo json_encode("notification added succssfully");
    }
}
