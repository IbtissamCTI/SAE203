<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Évaluation</title>
    <link rel="stylesheet" href="../CSS/css_evaluation-prof.css">
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="../photo/logoblanc.png" alt="NoteNote Logo" class="logo">
        </div>
        <button class="logout" onclick="location.href='login.php'">Quitter</button>
    </div>

    <div id="back-button">
        <a href="../PHP/accueil_prof.php">
            <img src="../photo/BOUTONARRIERE.png" alt="Back Button" class="back-button-img">
        </a>
    </div>

    <div class="container">
        <img src="../photo/titreevaluation.png" alt="Évaluation" class="evaluation-title">
        <div class="evaluation-form">
            <div class="form-left">
                <label for="ressource">Ressource</label>
                <input type="text" id="ressource" name="ressource">
                
                <label for="classe">Classe</label>
                <input type="text" id="classe" name="classe">
                
                <label for="notes">Notes</label>
                <input type="text" id="notes" name="notes">
            </div>
            <div class="form-right">
                <label for="coefficient">Coefficient</label>
                <input type="text" id="coefficient" name="coefficient">
                
                <label for="intitule">Intitulé de l'évaluation</label>
                <input type="text" id="intitule" name="intitule">
            </div>
        </div>
        <div class="buttons">
            <button type="button" class="btn" onclick="resetForm()">Effacer</button>
            <button type="submit" class="btn">Envoyer</button>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }

        function resetForm() {
            document.getElementById('ressource').value = '';
            document.getElementById('classe').value = '';
            document.getElementById('notes').value = '';
            document.getElementById('coefficient').value = '';
            document.getElementById('intitule').value = '';
        }
    </script>
</body>
</html>
