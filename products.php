<?php

include_once ("utilities.php");
User::checkAdminRight();
// On détermine sur quelle page on se trouve
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int)strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}
include_once("config.php");
<<<<<<< HEAD

include("product.php");
include("category.php");
=======
//$bdd=connect("vincent","vincent");
$bdd = connect('root', 'root');
include("Product.php");
>>>>>>> 6d6d5f3d11cd241523558e9680ba2845b6492b1f

$nbArticles = Product::nbProducts($bdd);


// On détermine le nombre d'articles par page
$parPage = 2;

// On calcule le nombre de pages total
$pages = ceil($nbArticles / $parPage);

// Calcul du 1er article de la page
$premier = ($currentPage * $parPage) - $parPage;

$products = Product::displayAllProducts($bdd, $premier, $parPage);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/products.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <title>My Shop JDV</title>
    <style>
        .disabled {
            pointer-events: none;
            cursor: default;
        }
    </style>

</head>
<body class="products-body">
<nav class="products-nav">
    <div><a href="index.php">HOME</a></div>
    <div><a href="admin.php">ADMIN PAGE</a></div>
</nav>
<main class="container">
     <h1> My Shop JDV</h1>
    <div class="row">
        <section class="col-12">
            <h1>List of products</h1>
            <button class="add-product-btn">
                <a href="createProduct.php">Ajouter un produit</a>
            </button>
            <table class="table">
                <thead>

                <th>name</th>
                <th>description</th>
                <th>price</th>
                <th>picture</th>
                <th>category</th>
                <th>ranking</th>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                <?php
                foreach ($products as $product) {
                     $category=Category::displayCategory($bdd,$product['category_id']);
                    ?>
                    <tr>

                        <td><?= $product['name'] ?></td>
                        <td><?= $product['description'] ?></td>
                        <td><?= $product['price'] ?></td>
                        <td><?= $product['picture'] ?></td>
                        <td><?= $category['name'] ?></td>
                        <td><?= $product['ranking'] ?></td>
                        <td class="edit_delete_btns">
                            <button><a href="confirm.php?id=<?php echo $product['id'] ?>&func=modif">MODIFIER</a>
                            </button>
                        </td>
                        <td class="edit_delete_btns">
                            <button><a href="confirm.php?id=<?php echo $product['id'] ?>&func=supp">X</a></button>
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
<nav>
    <ul class="pagination">
        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
            <a href="./products.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
        </li>
        <?php for ($page = 1; $page <= $pages; $page++): ?>
            <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                <a href="./products.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
            </li>
        <?php endfor ?>
        <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
            <a href="./products.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
        </li>
    </ul>
</nav>
</body>
</html>




