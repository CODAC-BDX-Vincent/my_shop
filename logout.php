<?php
session_start();
session_destroy();

if (isset($_COOKIE["username"]) || isset($_COOKIE["isAdmin"])){
    setcookie("username", '', time() - (3600));
    setcookie("isAdmin", '', time() - (3600));
}

header('location:index.php');

?>
?>

