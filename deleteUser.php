<?php
include_once('utilities.php');
include_once('config.php');

//check if user has access privileges to this page
User::checkAdminRight();

//if deletion confirmed
if (isset($_POST['submit'])) {
    $userId = $_POST['userId'];
    //Connect to db

    //var_dump($db);
    //check if user id received
    if (!isset($_POST['userId'])) {
//        echo "NO ID RECEIVED";
        header('Location: users.php');
    } else {
        //check if user exists
        $result = User::getUserData($userId);
        if ($result == false) {
//            echo "USER NOT FOUND";
            Header('Location: users.php');
        } else {
            //user exists -> launch delete query via User class
            User::deleteUser($_POST['userId']);
        }
    }
} else {
//check if id received;
    if (!isset($_GET['id'])) {
//        echo "NO ID RECEIVED";
        header('location:users.php');
    } else {
        //check if user exists
        $result = User::getUserData((int)$_GET['id']);
        if ($result == false) {
            echo "USER NOT FOUND";
            //Header('Location: users.php');
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
    <link rel="stylesheet" href="styles/deleteUser.css">
    <title>My Shop JDV</title>
</head>
<body class="deleteUser-body">
<form action="deleteUser.php" method="POST">
    <input hidden name="userId" value="<?php echo $_GET['id'] ?? null ?>"/>
    <div>Confirm user deletion?</div>
    <div class="deletebuttons">
        <div>
            <input type="submit" name="submit" action="deleteUser.php" method="POST" value="YES"/>
        </div>
        <div>
            <button><a href="users.php">NO</a></button>
        </div>
    </div>
</form>
</body>
</html>