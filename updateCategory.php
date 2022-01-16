<?php

include("config.php");

include("category.php");
include("utilities.php");
User::checkAdminRight();

if (isset($_POST["id"]) && isset($_POST["submit"])) {
    if ($_POST["submit"] == "NON") {
        header('Location: categories.php');
        exit();

    } else {

       $rep=Category::displayCategory($bdd,$_POST["id"]);


        ?>
        <!DOCTYPE html>
        <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/updateProduct.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
        <title>My Shop JDV</title>
    </head>
    <body class="updateProduct-body">
         <h1> My Shop JDV</h1>
    <nav class="products-nav">
        <div><a href="index.php">HOME</a></div>
        <div><a href="categories.php">PRODUCTS LIST</a></div>
    </nav>
    <div class="updateProduct-container">
        <a href="categories.php">ANNULER</a>
    <form class="updateProduct-inputs-wrapper" action="updateC.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $rep["id"]; ?>">
        <label for="name">Nom du produit</label>
        <input required type="text" name="name" value="<?php echo $rep["name"]; ?>">

        <button type="submit" name="submit">SUBMIT</button>
    </form>
    </div>

    </body>
        <?php
    }
}

?>

