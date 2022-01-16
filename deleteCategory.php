<?php

include("config.php");

include("category.php");
include("utilities.php");
User::checkAdminRight();

if(isset($_POST["id"]) && isset($_POST["submit"])){
    if($_POST["submit"]=="NON"){
        header('Location: categories.php');
        exit();
    }else{

      Category::deleteCategory($bdd,$_POST["id"]);
    }
}

?>