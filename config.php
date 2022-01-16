<?php
 define('ERROR_LOG_FILE',"errors.log");

function connect($name,$password){
try{
    $bdd = new PDO("mysql:host=localhost;dbname=my_shop;port=3360", $name, $password);  
    return $bdd;
} catch (PDOException $e) {
        echo $e->getMessage();
        error_log("Error connection to DB\n",3,ERROR_LOG_FILE );
        error_log("PDO ERROR:".$e." storage in ".ERROR_LOG_FILE."\n",3,ERROR_LOG_FILE );
        
        
    }
    
}

$db = connect('root', 'root');
$bdd =connect('root','root');
?>
