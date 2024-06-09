<?php
function connexionDB(){
    $host = "localhost";
    $dbname = "NOTESAE203"; // Nouveau nom de la base de données
    $user ="root";
    $pass ="";

    try {
        $pdo = new PDO('mysql:host='. $host . ';dbname='. $dbname .';charset=utf8', $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        return $pdo;
     }
    catch(PDOException $e) {
        echo "Erreur : ".$e -> getMessage()."<br/>";
}
}
?>