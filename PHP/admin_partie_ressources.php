<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Admin</title>
    <link rel="stylesheet" href="../CSS/css_acceuil_admin.css">
</head>
<body>
    <div class="header">
        <img src="../photo/logoblanc.png" alt="NoteNote Logo" class="logo">
        <button class="logout" onclick="location.href='index.php'">Quitter</button>
    </div>
    <div id="back-button">
        <a href="../PHP/accueil_admin.php">
            <img src="../photo/BOUTONARRIERE.png" alt="Back Button" class="back-button-img">
        </a>
    </div>
    <div class="container">
        <button class="btn" onclick="location.href='ajouter_ressource.php'">Ajouter une ressource</button>
        <button class="btn" onclick="location.href='modifier_ressource.php'">Modifier une ressource</button>
    </div>
</body>
</html>

