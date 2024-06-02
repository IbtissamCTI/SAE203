<?php
session_start();

if(!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true){

    header("location: Indexco.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord de l'administrateur</title>
</head>
<body>
    <h1>Bienvenue dans le tableau de bord de l'administrateur</h1>    
    <a href="logout.php">Déconnexion</a>
</body>
</html>