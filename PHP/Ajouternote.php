<?php
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$pdo = connexionDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_etudiant = $_POST['id_etudiant'];
    $note = $_POST['note'];
    $coef = $_POST['coef'];
    $date = $_POST['date'];
    $libelle = $_POST['libelle'];
    $id_enseignant = 2; 
    $id_ressource = 311; 
    $id_ue = 1; 

    
    $stmt_check_coef = $pdo->prepare('SELECT coef FROM Evaluation WHERE libelle = ? LIMIT 1');
    $stmt_check_coef->execute([$libelle]);
    $existing_coef = $stmt_check_coef->fetchColumn();

    if ($existing_coef !== false && $existing_coef != $coef) {
        echo "<script type='text/javascript'>
                alert('Erreur : Tous les coefficients pour le même libellé doivent être identiques.');
                window.location.href = 'Ajouternote.php';
              </script>";
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO Evaluation (note, date, id_etudiant, id_enseignant, id_ressource, id_ue, coef, libelle) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->execute([$note, $date, $id_etudiant, $id_enseignant, $id_ressource, $id_ue, $coef, $libelle]);

    echo "<script type='text/javascript'>
            alert('Ajouté avec succès');
            window.location.href = 'profboard.php';
          </script>";
}
?>
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
        <a href="profboard.php">
            <img src="../photo/BOUTONARRIERE.png" alt="Back Button" class="back-button-img">
        </a>
    </div>

    <div class="container">
        <img src="../photo/titreevaluation.png" alt="Évaluation" class="evaluation-title">
        <form method="post" class="evaluation-form">
            <div class="form-left">
                <label for="id_etudiant">ID Étudiant</label>
                <input type="number" id="id_etudiant" name="id_etudiant" required>
                
                <label for="note">Note</label>
                <input type="number" id="note" name="note" min="0" max="20" step="0.5" required>
                
                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-right">
                <label for="coef">Coefficient</label>
                <input type="number" id="coef" name="coef" min="0" step="0.1" required>
                
                <label for="libelle">Libellé de l'évaluation</label>
                <input type="text" id="libelle" name="libelle" required>
            </div>
            <div class="buttons">
                <button type="button" class="btn" onclick="resetForm()">Effacer</button>
                <button type="submit" class="btn">Envoyer</button>
            </div>
        </form>
    </div>

    <script>
        function resetForm() {
            document.getElementById('id_etudiant').value = '';
            document.getElementById('note').value = '';
            document.getElementById('date').value = '';
            document.getElementById('coef').value = '';
            document.getElementById('libelle').value = '';
        }
    </script>
</body>
</html>
