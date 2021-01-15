<?php

require_once("database/connection.php");

$email=@$_POST['email'];
$password=@$_POST['password'];

echo $email;
echo $password;

$query = "SELECT * FROM aadmin WHERE email = '$email' AND password = '$password'";
$result = $pdo->prepare($query);
$result->execute();

$noOfRows = $result->rowCount();
if($noOfRows>0){
    $row = $result->fetch(PDO::FETCH_ASSOC);
    if(strcmp($row['password'],$password)==0){
        $_SESSION['id']=$row['id'];
        $_SESSION['theVar'] = "theData";
        header('location:index.php');
    }else{

        echo json_encode("Invalid Password !");
        die();
    }
}
else{
    $msg = "No Admin Found";
    header("Location:login.php?msg=$msg");
}