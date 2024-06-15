<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
    <link rel="stylesheet" href="../CSS/css_liste_etudiants.css">
    <script>
        function redirectToDetails(studentId) {
            location.href = `etudiant_note_individuel.php?id=${studentId}`;
        }
    </script>
</head>
<body>
    <div class="header">
        <img src="../photo/logoblanc.png" alt="NoteNote Logo" class="logo">
        <button class="logout" onclick="location.href='login.php'">Quitter</button>
    </div>
    <div id="back-button">
        <a href="profboard.php">
            <img src="../photo/BOUTONARRIERE.png" alt="Back Button" class="back-button-img">
        </a>
    </div>
    <div class="container">
        <table>
            <tbody>
                <?php
                include 'etuliste.php';

                foreach ($etudiants as $etudiant) {
                    echo "<tr>";
                    echo "<td>" . $etudiant['nom'] . "</td>"; 
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
