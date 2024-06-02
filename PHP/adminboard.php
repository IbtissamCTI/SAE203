<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
if(!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true){
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté en tant qu'administrateur
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
    <p>Ce tableau de bord vous permet de gérer les différentes fonctionnalités de votre application.</p>
    
    <a href="logout.php">Déconnexion</a>
</body>
</html>