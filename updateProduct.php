<?php

include("config.php");
$bdd = connect('root', 'root');
include("product.php");
include("utilities.php");
User::checkAdminRight();

if (isset($_POST["id"]) && isset($_POST["submit"])) {
    if ($_POST["submit"] == "NON") {
        header('Location: products.php');
        exit();

    } else {

        $rep = Product::displayProduct($bdd, $_POST["id"]);


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
    <nav class="products-nav">
        <div><a href="index.php">HOME</a></div>
        <div><a href="products.php">PRODUCTS LIST</a></div>
    </nav>
    <div class="updateProduct-container">
         <h1> My Shop JDV</h1>
        <a href="products.php">ANNULER</a>
    <form class="updateProduct-inputs-wrapper" action="updateP.php" method="POST" enctype="multipart/form-data">
        <input  type="hidden" name="id" value="<?php echo $rep["id"]; ?>">
        <label for="name">Nom du produit</label>
        <input required type="text" name="name" value="<?php echo $rep["name"]; ?>">
        <label for="description">Description</label>
        <textarea required name="description" cols="30" rows="10"><?php echo $rep["description"]; ?></textarea>
        <label for="price">Price</label>
        <input required type="number" min="1" name="price" value="<?php echo $rep["price"]; ?>"/>
        <label for="ranking">Ranking/5</label>
        <input required type="number" min="1" max="5" name="ranking" value="<?php echo $rep["ranking"]; ?>"/>
        <label for="file">Picture</label>
        <img src="upload/<?php echo $rep["picture"]; ?>" width="100" alt="<?php echo $rep["picture"]; ?>">
        <input  type="file" name="picture" value=<?php echo $rep["picture"]; ?>>
        <button type="submit" name="submit">SUBMIT</button>
    </form>
    </div>

    </body>
        <?php
    }
}

?>