<?php

include("config.php");

include("Product.php");
include("utilities.php");
User::checkAdminRight();

if(isset($_POST["id"]) && isset($_POST["submit"])){
    if($_POST["submit"]=="NON"){
        header('Location: products.php');
        exit();
    }else{
        if(!$_FILES['picture']['name']){
     
        $requete="UPDATE products SET name ='".$_POST['name']."',description ='".$_POST['description']."',price ='".$_POST['price']."' ,ranking ='".$_POST['ranking']."' WHERE id ='".$_POST['id']."'";
        echo $requete;
        $sth=$bdd->query($requete);
        $sth->closeCursor();
        header('Location: products.php');
        exit();
        }else{
            
            
        
        $name=$_POST["name"];
        $namePicture=$_FILES["picture"]["name"];
 
        $requete="UPDATE products SET name ='".$_POST['name']."',description ='".$_POST['description']."',price ='".$_POST['price']."',picture='".$_FILES['picture']['name']."',ranking ='".$_POST['ranking']."' WHERE id ='".$_POST['id']."'";
        $prod=Product::displayProduct($bdd,$_POST["id"]);
        $OLDpicture="upload/".$prod["picture"];
        unlink($OLDpicture);
        move_uploaded_file($_FILES['picture']['tmp_name'], './upload/'.$_FILES['picture']['name']);
        $sth=$bdd->query($requete);
        $sth->closeCursor();
        header('Location: products.php');
        exit();

         
        }}}
        else{
            header('Location: products.php');
            exit();
        }
        
        
   
    
