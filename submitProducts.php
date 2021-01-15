<?php
   require_once("include/connection.php");
   $name=$_POST['name'];
        $category=$_POST['category'];
        $original=@$_POST['originalprice'];
        $Discount=$_POST['discountprice'];
        $description=@$_POST['description'];
        $quantity=@$_POST['quantity'];
        
        //$availability=@$_POST['availability'];
        
        
        
           $qu="INSERT INTO litil.`product` 
           (`name`, `description`, `price`, `discount_price`, `imagename`, `category`, `weight` ,`availability`)
           VALUES ($name, '$quantity', '$original', '$Discount', '$path', '$category', '100gm',1);";
           @$result = $pdo->prepare($qu);
           @$result->execute();
           header('location:productDetails.php');


?>