<?php
include_once ('utilities.php');
User::checkAdminRight();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/admin.css">
    <script src="https://kit.fontawesome.com/df0909b738.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <title>My Shop JDV</title>
</head>
<body>
<div id="wrapper">
    <header>
        <div>
            <div class="hidden_menu">
                <a href="index.php">HOME</a>
            </div>
        </div>
        <div class="hidden_menu">
            <div><?php {
                    echo $_COOKIE["username"];
                } ?></div>
            <?php
            echo "<div class='login'>

            <a href='logout.php'>LOGOUT</a></div>";
            ?>
        </div>
    </header>
    <h1> My Shop JDV</h1>
    <main class="icone_container">
         
        <div >
            <button class="icone">
            <a href="users.php"><img src="integration-design-and-assets/users-icone.png" alt="users"/></a>
            <a href="users.php">USERS ADMIN</a>
            </button>
        </div>
        <div >
        <button class="icone">
            <a href="products.php"><img src="integration-design-and-assets/products-icon.png" alt="products"/></a>
            <a href="products.php">PRODUCTS ADMIN</a>
        </button>
        </div>
        <div >
            <button class="icone">
                <a href="categories.php"><img src="integration-design-and-assets/categories-icone.png" alt="products"/></a>
                <a href="categories.php">CATEGORIES ADMIN</a>
            </button>
        </div>

        </main>
</html>