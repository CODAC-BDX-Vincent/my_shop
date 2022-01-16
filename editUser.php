<?php
include_once('config.php');
include_once('utilities.php');

//Check if user has admin privileges to access this page
User::checkAdminRight();

//Check if id received
if (!isset($_GET['id'])) {
    header('Location:users.php');
}

//Check if user exists and if yes get user data
$userIdToEdit = (int)$_GET['id'];
$result = User::getUserData($userIdToEdit);
//print_r($result);

//if  user not found -> redirect to users list
if ($result == false) {
    header('Location:users');
    return;
};


//If form submitted
if (isset($_POST['submit'])) {
    //Update user data
    User::editUser($userIdToEdit, $_POST['username'], $_POST['email'], $_POST['isAdmin']);
    //display message 'User updated' and click OK to redirect to users.php
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/editUser.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body class="editUser-body">
<div class="editUser-container">
     <h1> My Shop JDV</h1>
    <a href="users.php">ANNULER</a>
    <form action="editUser.php?id=<?php echo (int)$_GET['id'] ?>" method="POST" class="editUser-inputs-wrapper">
        <label>User Name</label>
        <input type="username" name="username" placeholder="username" value="<?php echo $result['username'] ?? '' ?>"/>
        <br/>
        <br/>
        <label>Email</label>
        <input type="email" name="email" placeholder="email" value="<?php echo $result['email'] ?? '' ?>"/>
        <br/>
        <br/>
        <label>Admin privilege</label>
        <br/>
        <select name="isAdmin" default="<?php echo $result['admin'] ?? '' ?>">
            <option value=1 <?php echo $result['admin'] == 1 ? 'selected' : '' ?>>YES</option>
            <option value=0 <?php echo $result['admin'] == 0 ? 'selected' : '' ?>>NO</option>
        </select>
        <br/>
        <br/>
        <input type="submit" name="submit" value="Update"/>
    </form>
</div>

</body>
</html>
