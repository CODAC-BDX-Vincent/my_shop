<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/createCategory.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <link></link>
    <title>My Shop JDV</title>
</head>
<body class="createCategory_body">
     <h1> My Shop JDV</h1>
<?php
include("category.php");
include("config.php");
include("utilities.php");
User::checkAdminRight();


$isCorrect = true;
if (isset($_POST["name"])) {

    $name = $_POST["name"];
    if (strlen($_POST["name"]) < 3) {
        $isCorrect = false;
        echo "<p>Invalid name</p>";
    }
    if ($isCorrect) {
        Category::createCategory($bdd, $name);
    }
}
?>
<div class="createCategory_container">
    <a href="categories.php">ANNULER</a>
    <form action="createCategory.php" method="POST" enctype="multipart/form-data" class="createCategory_wrapper">
        <label for="name">Nom de la catégorie</label>
        <input type="text" name="name" required>
        <button type="submit">SUBMIT</button>
    </form>
</div>

</body>
</html>







