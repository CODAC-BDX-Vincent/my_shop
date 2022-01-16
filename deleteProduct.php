<?php

include("config.php");
$bdd=connect("root","root");
include("product.php");
include("utilities.php");
User::checkAdminRight();

if(isset($_POST["id"]) && isset($_POST["submit"])){
    if($_POST["submit"]=="NON"){
        header('Location: products.php');
        exit();
    }else{

      Product::deleteProduct($bdd,$_POST["id"]);
    }
}

?>