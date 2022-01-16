<?php

include("config.php");

include("Category.php");
include("utilities.php");
User::checkAdminRight();

if(isset($_POST["id"]) && isset($_POST["submit"])){
    if($_POST["submit"]=="NON"){
        header('Location: categories.php');
        exit();
    }else{
        $requete1 = 'SELECT EXISTS(SELECT * from categories WHERE name="'.$_POST["name"].'") AS rep;';
        $sth=$bdd->query($requete1);
        $rep=$sth->fetch(PDO::FETCH_ASSOC);
        $sth->closeCursor();
       
        if(!$rep["rep"]){
        $requete="UPDATE categories SET name ='".$_POST['name']."' WHERE id ='".$_POST['id']."'";
      
        $sth=$bdd->query($requete);
        $sth->closeCursor();
        header('Location: categories.php');
        exit();
        }else{
            header('Location: categories.php');
            exit();
        }
    }
}