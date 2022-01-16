<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <title>My Shop JDV</title>
    <link rel="stylesheet" href="style/signup.css">
</head>
<body class="signup-body">
<div class="signup">
    <nav class="signup-nav">
        <a href="index.php">HOME</a>
    </nav>
    <?php
    session_start();

    include("config.php");
    $bdd = connect("root", "root");
    $isCorrect = true;

    if (isset($_POST["name"]) && isset($_POST["password"]) && isset($_POST["password_confirmation"]) && isset($_POST["email"])) {


        $_SESSION["name"] = $_POST["name"];
        $_SESSION["email"] = $_POST["email"];
        //echo $_SESSION["name"];

        if (strlen($_POST["name"]) < 3 || strlen($_POST["name"]) > 10) {
            $isCorrect = false;
            unset($_SESSION["name"]);
            echo "<p>Invalid name</p>";
        }
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            unset($_SESSION["email"]);
            $isCorrect = false;
            echo "<p>Invalid email</p>";
        }
        if ((strlen($_POST["password"]) < 3 || strlen($_POST["password"]) > 10) || $_POST["password"] != $_POST["password_confirmation"]) {

            $isCorrect = false;
            echo "<p>Invalid password</p>";
        }
        if ($isCorrect) {

            unset($_SESSION["name"]);
            unset($_SESSION["password"]);
            unset($_SESSION["password_confirmation"]);
            unset($_SESSION["email"]);


            $password = $_POST["password"];


            $name = $_POST["name"];
            $email = $_POST["email"];
            $password = password_hash($password, PASSWORD_DEFAULT);

            $requete1 = "SELECT EXISTS(SELECT * from users WHERE email='$email') AS rep;";
            $sth = $bdd->query($requete1);
            $rep = $sth->fetch(PDO::FETCH_ASSOC);
            $sth->closeCursor();

            if (!$rep["rep"]) {

                $requete = "INSERT INTO users ( username, password,admin,email)
        VALUES
        ('$name', '$password',0, '$email')";
                $sth = $bdd->query($requete);


                $sth->closeCursor();
                header('location: index.php');
            } else {
                echo "<p> Email déja utilisé </p>";
            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles/signup.css">
        <title>My Shop - Sign Up</title>
    </head>
    <body class="signup-body">
    <div class="signup-container">
         <h1> My Shop JDV</h1>
        <a href="index.php">ANNULER</a>
        <form action="signup.php" method="post" class="signup-inputs-wrapper">
            <label for="name">NAME</label>
            <input required type="text" name="name" value="<?php if (isset($_SESSION["name"])) {
                echo $_SESSION["name"];
            } ?>">
            <label for="email">EMAIL</label>
            <input required type="email" name="email" value="<?php if (isset($_SESSION["email"])) {
                echo $_SESSION["email"];
            } ?>">
            <label for="password">PASSWORD</label>
            <input required type="password" name="password" value="<?php if (isset($_SESSION["password"])) {
                echo $_SESSION["password"];
            } ?>">
            <label for="password_confirmation">CONFIRM PASSSWORD</label>
            <input required type="password" name="password_confirmation"
                   value="<?php if (isset($_SESSION["password_confirmation"])) {
                       echo $_SESSION["password_confirmation"];
                   } ?>">
            <input type="submit" value="submit">
        </form>
    </div>
    </body>
</div>
</body>
</html>


