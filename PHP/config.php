<?php
function connexionBDD(){
    $host = "localhost";
    $dbname = "NOTENOTE";
    $user = "root";
    $pswrd = "";

    try {
        $pdo = new PDO('mysql:host='. $host . ':dbname=' . $dbname . ';charset=utf8', $user, $pswrd )
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    catch(PDOException $e){
        echo "Erreur : ".$e -> getMessage(). "<br/>";

    }
}
