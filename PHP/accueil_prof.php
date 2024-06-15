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
        <button class="logout" onclick="location.href='login.php'">Quitter</button>
    </div>

    <div class="container">
        <button class="btn" onclick="location.href='Ajouternote.php'">Ajouter Evaluation</button>
        <button class="btn" onclick="location.href='listeetudiant_partieprof.php'">Acceder à la liste</button>
        <button class="btn" onclick="location.href='listeetudiant_partieprof.php'">Modifier des evaluations</button>
    </div>
</body>
</html>