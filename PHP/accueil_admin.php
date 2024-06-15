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
        <button class="logout" onclick="location.href='login.php'">Quitter</button>
    </div>

    <div class="container">
        <button class="btn" onclick="location.href='admin_partie_compte.php'">Gestion des comptes</button>
        <button class="btn" onclick="location.href='admin_partie_ressources.php'">Gestion des Ressources</button>
    </div>
</body>
</html>
