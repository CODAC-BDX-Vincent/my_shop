<?php
include_once('config.php');

//Connect to db


class User
{

    public static function checkAdminRight()
    {
        if (!isset($_COOKIE['isAdmin']) || $_COOKIE['isAdmin'] != 1) {
            header('Location:index.php');
        }
    }

    public static function getUserData($userId)
    {
//        $db = connect('root', 'root');
        global $db;
        $sqlQuery = "SELECT * FROM users WHERE id=:id";
        $getUserStatement = $db->prepare($sqlQuery);
        $getUserStatement->execute([
            'id' => $userId,
        ]);
        return $getUserStatement->fetch(PDO::FETCH_ASSOC);
    }

    public static function editUser(int $userId, string $userName, string $userEmail, int $isAdmin)
    {
        try {
            $db = connect('root', 'root');
            $sqlQuery = "UPDATE users SET username=:username,email=:email, admin=:admin WHERE id=:id";
            $updateUserStatement = $db->prepare($sqlQuery);
            $updateUserStatement->execute([
                'username' => $userName,
                'email' => $userEmail,
                'admin' => $isAdmin,
                'id' => $userId,
            ]);
            header('Location: editUserSuccess.php');
        } catch (Exception $e) {
            echo 'Update Failed: ' . $e->getMessage();
            header('Location:editUserFail.php');
        }

    }

    public static function deleteUser ($userId){
        try{
//            $db = connect('joel', 'joel');
            global $db;
            $sqlQuery = "DELETE from users WHERE id=:id";
            $deleteUserStatement = $db->prepare($sqlQuery);
            $deleteUserStatement -> execute([
                'id'=>$userId,
            ]);
            header('Location: deleteUserSuccess.php');
        }catch(Exception $e){
            echo 'Delete Failed: ' . $e->getMessage();
//            header('Location:users.php');
        }
    }
}