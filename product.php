<?php


class Product{

    


    public static function createProduct($bdd,$name,$desc,$namePicture,$tmpName,$price,$category,$ranking){
        $requete1 = "SELECT EXISTS(SELECT * from products WHERE name='$name') AS rep;";

            
        $sth=$bdd->query($requete1);

        $rep=$sth->fetch(PDO::FETCH_ASSOC);
        $sth->closeCursor();
       
        if(!$rep["rep"]){
        move_uploaded_file($tmpName, './uploads/'.$namePicture);
            
         $requete = "INSERT INTO products ( name, description,picture,price,category_id,ranking)
        VALUES
        ('$name', '$desc','$namePicture', '$price','$category','$ranking')";

        echo $requete;

   
        $sth=$bdd->query($requete);

         $sth->closeCursor();
         header('Location: products.php');
         exit();
        }
        
    }


    public static function deleteProduct($bdd,$id){
        $requete2="SELECT picture FROM `products` WHERE `id` =".$id;
        $sth=$bdd->query($requete2);
        $rep=$sth->fetch(PDO::FETCH_ASSOC);
        $picture="upload/".$rep["picture"];
         unlink($picture);
        $sth->closeCursor();
        $requete="DELETE FROM `products` WHERE `id` = ".$id;
        $sth=$bdd->query($requete);
       
        $sth->closeCursor();
        header('Location: products.php');
        exit();
    }

    public static function displayProduct($bdd,$id){
        $requete="SELECT * FROM products WHERE id=".$id;
        $sth=$bdd->query($requete);
        $rep=$sth->fetch(PDO::FETCH_ASSOC);
        $sth->closeCursor();
        return $rep;
    }

    public static function nbProducts($bdd){

        $sql = 'SELECT COUNT(*) AS nb_products FROM `products`;';

        $query = $bdd->prepare($sql);

        $query->execute();

        // On récupère le nombre d'articles
        $result=$query->fetch();
        return (int) $result['nb_products'];
    }


    public static function displayAllProducts($bdd,$premier,$parPage){

        $sql = 'SELECT * FROM `products` ORDER BY `id`  LIMIT :premier, :parpage;';

        // On prépare la requête
        $query = $bdd->prepare($sql);

        $query->bindValue(':premier', $premier, PDO::PARAM_INT);
        $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}


?>