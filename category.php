<?php

class Category{



    public static function createCategory($bdd,$name){
        $requete1 = "SELECT EXISTS(SELECT * from categories WHERE name='$name') AS rep;";

            
        $sth=$bdd->query($requete1);

        $rep=$sth->fetch(PDO::FETCH_ASSOC);
        $sth->closeCursor();
       
        if(!$rep["rep"]){
        move_uploaded_file($tmpName, './upload/'.$namePicture);
            
    
        $requete = "INSERT INTO categories (name)
        VALUES
        ('$name')";


   
        $sth=$bdd->query($requete);
       
    

        $sth->closeCursor();
        header('Location: categories.php');
        exit();
        }
        
    }


    public static function deleteCategory($bdd,$id){
    
        $requete="DELETE FROM `categories` WHERE `id` = ".$id;
        $sth=$bdd->query($requete);
   
        $sth->closeCursor();
        header('Location: categories.php');
        exit();
    }

    public static function displayCategory($bdd,$id){
        $requete="SELECT * FROM categories WHERE id=".$id;
        $sth=$bdd->query($requete);
        $rep=$sth->fetch(PDO::FETCH_ASSOC);
        $sth->closeCursor();
        return $rep;
    }

    public static function nbCategories($bdd){

        $sql = 'SELECT COUNT(*) AS nb_categories FROM `categories`;';

        $query = $bdd->prepare($sql);

        $query->execute();

        // On récupère le nombre d'articles
        $result=$query->fetch();
        return (int) $result['nb_categories'];
    }


    public static function displayAllCategories($bdd,$premier,$parPage){

        $sql = 'SELECT * FROM `categories` ORDER BY `id`  LIMIT :premier, :parpage;';

        // On prépare la requête
        $query = $bdd->prepare($sql);

        $query->bindValue(':premier', $premier, PDO::PARAM_INT);
        $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


      public static function displayAllCategoriesTAB($bdd){

        $sql = 'SELECT * FROM `categories` ORDER BY `id`';

        // On prépare la requête
        $query = $bdd->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}


?>