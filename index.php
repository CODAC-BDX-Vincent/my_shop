<?php
include_once('config.php');
include_once('utilities.php');
include("category.php");
$recherche=FALSE;






$tableausearch=array();
if(isset($_POST["search"])){

$tableau = explode(" ", $_POST["search"]);
$recherche=TRUE;

foreach($tableau as $search){
    
    $requete="SELECT products.name,price,picture,category_id,ranking FROM products INNER JOIN categories ON  categories.id=products.category_id WHERE CONCAT(products.name,products.description) LIKE '%$search%' OR categories.name LIKE '%$search%';";
    $query = $bdd->prepare($requete);

        // On exécute
    $query->execute();

        // On récupère les valeurs dans un tableau associatif
    $result=$query->fetchAll(PDO::FETCH_ASSOC);
    $tableausearch=array_merge($tableausearch,$result);
    

}

}


$isAdmin = false;
if (isset($_COOKIE['isAdmin']) && $_COOKIE['isAdmin'] == 1) {
    $isAdmin = true;
}

// Define on which page we are currently
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int)strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}
// Connect to db
$db = connect('root', 'root');

//Number of  Products
$sqlQuery = "SELECT COUNT(*) AS nb_Products FROM `products`";
$getProductsStatement = $db->prepare($sqlQuery);
$getProductsStatement->execute();
$result = $getProductsStatement->fetch(PDO::FETCH_ASSOC);
$ProductsQuantity = (int)$result['nb_Products'];

//Products quantity per page
$perPage = 8;

//Number of pages
$pages = ceil($ProductsQuantity / $perPage);

// Define the first user of the current page
$firstArticle = ($currentPage * $perPage) - $perPage;

//Query to execute which takes into account inputs (currentPage, users per page...)
$sqlQueryLimitedProducts = "SELECT * FROM `products`  LIMIT $firstArticle, $perPage";


if(isset($_POST["filtersubmit"])){
    global $sqlQueryLimitedProducts;
    switch($_POST["filter"]){
        case "price_asc" :
            $sqlQueryLimitedProducts = "SELECT * FROM `products` ORDER BY price ASC  LIMIT $firstArticle, $perPage";
            break;
        case "price_desc" :
            $sqlQueryLimitedProducts = "SELECT * FROM `products` ORDER BY price DESC LIMIT $firstArticle, $perPage";
            break;
        case "name_asc" :
            $sqlQueryLimitedProducts = "SELECT * FROM `products` ORDER BY name ASC  LIMIT $firstArticle, $perPage";
            break;
        case "name_desc":
            $sqlQueryLimitedProducts = "SELECT * FROM `products` ORDER BY name DESC LIMIT $firstArticle, $perPage";
            break;
        case "ranking_asc":
            $sqlQueryLimitedProducts = "SELECT * FROM `products` ORDER BY ranking ASC   LIMIT $firstArticle, $perPage";
            break;
        case "ranking_desc":
            $sqlQueryLimitedProducts = "SELECT * FROM `products` ORDER BY ranking DESC  LIMIT $firstArticle, $perPage";
            break;
         case "category":
            $sqlQueryLimitedProducts = "SELECT * FROM `products` ORDER BY category_id   LIMIT $firstArticle, $perPage";
            break;
        default :
            $sqlQueryLimitedProducts = "SELECT * FROM `products`  LIMIT $firstArticle, $perPage";
            break;
    }
}
$getLimitedProductsStatement = $db->prepare($sqlQueryLimitedProducts);
$getLimitedProductsStatement->execute();



$ProductsList = $getLimitedProductsStatement->fetchAll(PDO::FETCH_ASSOC);
if($recherche){
    
    $ProductsList=array_unique($tableausearch,SORT_REGULAR);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/group.css">
    <script src="https://kit.fontawesome.com/df0909b738.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
    <title>My Shop JDV</title>
</head>
<body>
<div id="wrapper">
    <header>
        <div>
            <img src="integration-design-and-assets/Logo.png" alt="Logo"/>
            
            <div class="hidden_menu">
                <a href="index.php">My shop JDV</a>
                
            </div>
        </div>
        <div class="right-header">
          
         <div class="burger_menu"><i class="fas fa-bars"></i></div>
         <div class="hello_user"><?php if (isset($_COOKIE["username"])) {
                echo 'Bonjour ' . $_COOKIE["username"];
            } ?>
            </div>

        <?php if ($isAdmin): ?>
        <div class="adminPage_link">
            <a href="admin.php">AdminPage</a>
        </div>
        <?php endif; ?>

        <?php
        if (isset($_COOKIE["username"])) {
            echo "<div class='logout'><a href='logout.php'>LOGOUT</a></div>";
        } else {

            echo "<div class='x'><a href='signin.php'>LOGIN</a></div>
            <div class='signup'><a href='signup.php'>SIGN UP</a></div>";
        }
        ?>
        </div>
    </header>
    <div class="searches">
        <div class="boite">
            <div class="input_search">
                <img src="integration-design-and-assets/Search.png" alt="search"/>
               
                <form action="index.php" method="POST">
                    <input type="text" name="search" />
                    
                    </form>
                
            </div>
            <div class="space"></div>
            <div class="algo">
                <p>Powered by <strong>Algolia</strong></p>
                <img src="integration-design-and-assets/Sajari%20Logo.png" alt="logo"/>
            </div>
        </div>
        <div class="best">
            <form action="index.php" method="post">
            <select name="filter">
                <option value="">
                    FILTER BY
                </option>
                <option value="price_asc">
                    Prix croissant
                </option>
                <option value="price_desc">
                    Prix decroissant
                </option>
                <option value="name_asc">
                    Nom alphabetique
                </option>
                <option value="name_desc">
                    Nom alphabetique desc
                </option>
                <option value="ranking_asc">
                    ranking 
                </option>
                <option value="ranking_desc">
                    ranking desc
                </option>
                 <option value="category">
                    category
                </option>
                <input type="submit" name="filtersubmit" value="Apply">
            </select>
            </form>
        </div>
        
    </div>
    <h1> My Shop JDV</h1>

    <!--    product list-->
    <main class="products_container">
    

        <?php foreach ($ProductsList as $product){
                $category=Category::displayCategory($bdd,$product['category_id']);
        
         ?>
            <div class="product_tag">
                <img class="image_product" alt="<?php echo $product['picture'] ?>" src="uploads/<?php echo $product['picture'] ?>"/>
                <div class="Sous_boite">
                    <div class="name_prices">
                        <p><strong><?php echo $product['name'] ?></strong></p>
                        <p>$<?php echo $product['price'] ?></p>
                    </div>
                    <div class="tag_footer">
                        <div>
                            <p><?php echo $category["name"]?></p>
                            <div class="stars">
                            
                            <?php for($i=0;$i<$product["ranking"];$i++){
                                echo "<img src='integration-design-and-assets/Star%20-%20On.png' alt='rating'/>";
                            }for($i=5-$product["ranking"];$i>0;$i--){
                                echo "<img src='integration-design-and-assets/Star.png' alt='rating'/>";
                            }
                            
                      ?>
                            </div> 
                        </div>
                        <div><img src="integration-design-and-assets/Cart%20Button.png" alt="cart"/></div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </main>
</div>

<!--PAGINATION-->
<nav class="pagination-container">
    <ul class="pagination">
        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
            <a href="index.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
        </li>
        <?php for ($page = 1; $page <= $pages; $page++): ?>
            <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                <a href="index.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
            </li>
        <?php endfor ?>
        <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
            <a href="index.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
        </li>
    </ul>
</nav>

</body>
</html>