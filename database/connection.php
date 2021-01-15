<?php

$config=require 'config.php';


$BaseURL="http://localhost/Little_App_New";
//$BaseURL="https://shikastudio.com/LittleApp/";

      class connection{
         public $pdo;
         public static function make($config){
            try{
               // return $pdo=new PDO('conection','usernamed','password');
      
               return new PDO( 
                  $config['connection&DB'],
                  $config['username'],
                  $config['password']
               );
            }catch(PDOException $e){
               die("cant connect to db man ". $e->getMessage());
            }
         }
      };




     

      $pdo=connection::make($config['database']);

    session_start();