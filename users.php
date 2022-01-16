<?php

include_once('config.php');
include_once('utilities.php');

//Check if user has admin privileges
User::checkAdminRight();

// Connect to db
$db = connect('root', 'root');

//var_dump($db);


// Define on which page we are currently
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int)strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}

//Number of total users
$sqlQuery = "SELECT COUNT(*) AS nb_users FROM `users`";
$getUsersStatement = $db->prepare($sqlQuery);
$getUsersStatement->execute();
$result = $getUsersStatement->fetch(PDO::FETCH_ASSOC);
$usersQuantity = (int)$result['nb_users'];

//var_dump($usersQuantity);


//Users quantity per page
$perPage = 2;

//Number of pages
$pages = ceil($usersQuantity / $perPage);

// Define the first user of the current page
$firstUser = ($currentPage * $perPage) - $perPage;

//Query to execute which takes into account inputs (currentPage, users per page...)
$sqlQueryLimitedUsers = "SELECT * FROM `users`  LIMIT $firstUser, $perPage";
$getLimitedUserStatement = $db->prepare($sqlQueryLimitedUsers);
$getLimitedUserStatement->execute();
$usersList = $getLimitedUserStatement->fetchAll(PDO::FETCH_ASSOC);
//var_dump($usersList);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/users.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <!--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">-->
   <title>My Shop JDV</title>
</head>
<body class="users-body">
<nav class="users-nav">
    <div><a href="index.php">HOME</a></div>
    <div><a href="admin.php">ADMIN PAGE</a></div>
</nav>
<main class="container">
    <div class="row">
        <section class="col-12">
             <h1> My Shop JDV</h1>
            <table class="table">
                <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Admin</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                <?php
                // Loop on all users
                foreach ($usersList as $user) {
                    ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <?php if ($user['admin'] == 1): ?>
                            <td>YES</td>
                        <?php else : ?>
                            <td>NO</td>
                        <?php endif ?>
                        <td class="edit_delete_btns">
                            <button><a href="editUser.php?id=<?php echo $user['id'] ?>">Edit</a></button>
                        </td>
                        <td class="edit_delete_btns">
                            <button><a href="deleteUser.php?id=<?php echo $user['id'] ?>">X</a></button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </section>
    </div>
</main>
<nav class="pagination-container">
    <ul class="pagination">
        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
            <a href="users.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
        </li>
        <?php for ($page = 1; $page <= $pages; $page++): ?>
            <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                <a href="users.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
            </li>
        <?php endfor ?>
        <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
            <a href="users.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
        </li>
    </ul>
</nav>
</body>
</html>
