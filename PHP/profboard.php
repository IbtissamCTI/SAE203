<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_compte']) || $_SESSION['type_compte'] !== 'enseignant') {
    // Si l'utilisateur n'est pas connecté en tant qu'enseignant, rediriger vers la page de connexion
    header("Location: index.php");
    exit(); // Arrêter l'exécution du script après la redirection
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Professeur</title>
    <link rel="stylesheet" href="../CSS/accueil_prof.css">
</head>
<body>
    <div class="header">
        <img src="../photo/logoblanc.png" alt="NoteNote Logo" class="logo">
        <button class="logout" onclick="location.href='index.php'">Quitter</button>
    </div>

    <div class="container">
        <button class="btn" onclick="location.href='Ajouternote.php'">Ajouter Evaluation</button>
        <button class="btn" onclick="location.href='etu.php'">Acceder à la liste</button>
    </div>
</body>
</html>

    
