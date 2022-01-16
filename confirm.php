<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/confirm.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <title>My Shop JDV</title>
</head>
<body class="confirm-body">
     <h1> My Shop JDV</h1>
    <?php
    include("utilities.php");
User::checkAdminRight();
 if(isset($_GET["id"]) && isset($_GET["func"])){
        

        if($_GET["func"] =="supp"){
            ?>
            <form action="deleteProduct.php" method="post">
                <label for="confirm">Confirmer la suppression ?</label>
                <div class="yes_no_btns">
                    <input  type='submit' name = 'submit'    value = 'OUI'>
                    <input  type='submit' name = 'submit' value = 'NON'>
                </div>

                <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
            </form>

        <?php

        }

        if($_GET["func"] =="modif"){
                ?>
            <form action="updateProduct.php" method="post">
                <label for="confirm">Confirmer la modification ?</label>
                <div class="yes_no_btns">
                    <input  type='submit' name = 'submit'    value = 'OUI'>
                    <input  type='submit' name = 'submit' value = 'NON'>
                </div>

                <input type="hidden" name="id" value="<?php echo $_GET["id"] ?>">
            </form>

        <?php
        }

    }
    
    ?>
   
    
</body>
</html>