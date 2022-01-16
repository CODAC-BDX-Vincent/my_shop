<?php
// On détermine sur quelle page on se trouve
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int)strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}
include("config.php");

include("category.php");
include("utilities.php");
User::checkAdminRight();

$nbArticles = Category::nbCategories($bdd);

// On détermine le nombre d'articles par page
$parPage = 2;

// On calcule le nombre de pages total
$pages = ceil($nbArticles / $parPage);

// Calcul du 1er article de la page
$premier = ($currentPage * $parPage) - $parPage;
$categories = Category::displayAllCategories($bdd, $premier, $parPage);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/categories.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <title>My Shop JDV</title>
    <style>
        .disabled {
            pointer-events: none;
            cursor: default;
        }
    </style>

</head>
<body class="categories-body">
<nav class="categories-nav">
    <div><a href="index.php">HOME</a></div>
    <div><a href="admin.php">ADMIN PAGE</a></div>
</nav>
<main class="container">
     <h1> My Shop JDV</h1>
    <div class="row">
        <section>
            <h1>List of categories</h1>
            <button class="addCategory_btn">
                <a href="createCategory.php">Ajouter une category</a>
            </button>
            <table class="table">
                <thead>

                <th>id</th>
                <th>name</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                <?php
                foreach ($categories as $categorie) {
                    ?>
                    <tr>
                        <td><?= $categorie['id'] ?></td>
                        <td><?= $categorie['name'] ?></td>
                        <td class="edit_delete_btns">
                            <button><a href="confirmC.php?id=<?php echo $categorie['id'] ?>&func=modif">MODIFIER</a>
                            </button>
                        </td>
                        <td class="edit_delete_btns">
                            <button><a href="confirmC.php?id=<?php echo $categorie['id'] ?>&func=supp">X</a></button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <nav class="pagination-container">
                <ul class="pagination">
                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="./categories.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                    </li>
                    <?php for ($page = 1; $page <= $pages; $page++): ?>
                        <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                        <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                            <a href="./categories.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                        </li>
                    <?php endfor ?>
                    <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                    <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="./categories.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                    </li>
                </ul>
            </nav>
        </section>
    </div>
</main>
</body>
</html>




