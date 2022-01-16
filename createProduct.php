<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/createProduct.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <title>My Shop JDV</title>
</head>
<body class="createProduct-body">

<?php
include("product.php");
include("config.php");
include("category.php");
include("utilities.php");
User::checkAdminRight();
$categories=Category::displayAllCategoriesTAB($bdd);


$isCorrect = true;
if (isset($_FILES["file"]) && isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["price"])) {
    $tmpName = $_FILES['file']['tmp_name'];
    $namePicture = $_FILES['file']['name'];
    $name = $_POST["name"];
    $desc = $_POST["description"];
    $price = $_POST["price"];
    $category=$_POST["category"];
    $ranking=$_POST["ranking"];
    // echo $_POST["name"],$_POST["description"],$_POST["price"];

    if (strlen($_POST["name"]) < 3) {
        $isCorrect = false;
        echo "<p>Invalid name</p>";

    }
    if (strlen($_POST["description"]) < 8) {
        $isCorrect = false;
        echo "<p>Invalid description</p>";
    }


    if ($isCorrect) {

         Product::createProduct($bdd,$name,$desc,$namePicture,$tmpName,$price,$category,$ranking);

    }


}
?>
<div class="createProduct-container">
     <h1> My Shop JDV</h1>
    <a href="products.php">ANNULER</a>
    <form action="createProduct.php" method="POST" enctype="multipart/form-data" class="createProduct-inputs-wrapper">
        <label for="name">Nom du produit</label>
        <input type="text" name="name" required>
        <label for="description">Description</label>
        <textarea name="description" cols="30" rows="10" required></textarea>
        <label for="price">Price</label>
        <input type="number" min="1" step="any" name="price" required/>
        <label for="ranking">Ranking/5</label>
        <input type="number" min="1" max="5" step="any" name="ranking" required/>
        <label for="file">Picture</label>
        <input type="file" name="file" required>
        <label>Category</label>
         <select name="category" required>
            <option value="" default>--Please choose an option--</option>
           
        <?php
                foreach($categories as $category){
                    echo "<option value=".$category["id"].">".$category["name"]."</option>";
                    
                }



        ?>
        </select>
        <button type="submit">SUBMIT</button>
    </form>

</div>


</body>
</html>







