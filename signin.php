<?php

//create user in db


//create function to connect to pdo
function connectToDb($name, $password)
{
    $dsn = "mysql:host=localhost;port=3306;dbname=my_shop;charset=utf8";
    try {
        return new PDO($dsn, $name, $password);
    } catch (Exception $e) {
        echo "CONNECTION DB NOK";
        die('Error: ' . $e->getMessage());
    }
}


//connect to pdo
include_once('config.php');
$db = connect('root', 'root');

//Error messages
$errors = [];

//Once form submitted
if (isset($_POST['submit'])) {
    //Step 0 - Rename data inside $_POST
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Step 1 - Check if user exists in db
    $sqlQuery = "SELECT * FROM  users WHERE email=:email";
    $getUserStatement = $db->prepare($sqlQuery);
    $getUserStatement->execute([
        'email' => $email,
    ]);
    $userToFind = $getUserStatement->fetch(PDO::FETCH_ASSOC);
//    var_dump($userToFind);
    if ($userToFind == false) {
        //No user found -> insert error messages
        $errors['email_password'] = 'User and/or password invalid';
    } else {
        //Step 2 - Check if password match with password in db using password_verify
        $isPasswordMatching = password_verify($password, $userToFind['password']);
        if ($isPasswordMatching != 1) {
            //if password don't match
            $errors['email_password'] = 'User and/or password invalid';
        } else {
            //set cookie username
            setcookie('username', $userToFind['username'],
                [
                    'expires' => time() + 1 * 24 * 3600,
                    'secure' => true,
                    'httponly' => true,
                ]);
            //set cookie isAdmin (1 or 0)
            setcookie('isAdmin', $userToFind['admin'],
                [
                    'expires' => time() + 1 * 24 * 3600,
                    'secure' => true,
                    'httponly' => true,
                ]);

            //redirect to index.php
            header('location: index.php');
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
    <link rel="stylesheet" href="styles/signinStyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <title>My Shop JDV</title>
</head>
<body class="signin-body">
<div class="signInForm-container">
     <h1> My Shop JDV</h1>
    <div style="color:red">
        <?php echo $errors['email_password'] ?? '' ?>
    </div>
    <br/>
    <form action="signin.php" method="POST" class="signin-inputs-wrapper" >
        <label>Email</label>
        <input type="email" name="email" placeholder="Type your email" value="<?php echo $_POST['email'] ?? '' ?>"
               required/>
        <br/>
        <br/>
        <label>Password</label>
        <input type="password" name="password" placeholder="Type your password"
               value="<?php echo $_POST[('password')] ?? '' ?>" required/>
        <br/>
        <br/>
        <input type="submit" name="submit" value="Connexion"/>
    </form>
</div>


</body>
</html>