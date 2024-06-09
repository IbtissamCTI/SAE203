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
    $id_enseignant = 2; // Remplacez par l'ID de l'enseignant approprié
    $id_ressource = 311; // Remplacez par l'ID de la ressource appropriée
    $id_ue = 1; // Remplacez par l'ID de l'UE appropriée

    // Vérification des coefficients pour le même libellé
    $stmt_check_coef = $pdo->prepare('SELECT coef FROM Evaluation WHERE libelle = ? LIMIT 1');
    $stmt_check_coef->execute([$libelle]);
    $existing_coef = $stmt_check_coef->fetchColumn();

    if ($existing_coef !== false && $existing_coef != $coef) {
        echo "<script type='text/javascript'>
                alert('Erreur : Tous les coefficients pour un même libellé doivent être identiques.');
                window.location.href = 'Ajouternote.php';
              </script>";
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO Evaluation (note, date, id_etudiant, id_enseignant, id_ressource, id_ue, coef, libelle) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->execute([$note, $date, $id_etudiant, $id_enseignant, $id_ressource, $id_ue, $coef, $libelle]);

    echo "<script type='text/javascript'>
            alert('Ajout réussi');
            window.location.href = 'profboard.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Ajouter une note</title>
</head>
<body>
    <div class="starter-template">
        <h1>Ajouter une note</h1>
        <form method="post">
            <div class="form-group">
                <label for="id_etudiant">ID Étudiant</label>
                <input type="number" class="form-control" id="id_etudiant" name="id_etudiant" required>
            </div>
            <div class="form-group">
                <label for="note">Note</label>
                <input type="number" class="form-control" id="note" name="note" min="0" max="20" step="0.5" required>
            </div>
            <div class="form-group">
                <label for="coef">Coefficient</label>
                <input type="number" class="form-control" id="coef" name="coef" min="0" step="0.1" required>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="libelle">Libellé de l'évaluation</label>
                <input type="text" class="form-control" id="libelle" name="libelle" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="profboard.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>



