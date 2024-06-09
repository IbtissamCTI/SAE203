<?php
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_etudiant = $_POST['id_etudiant'];
    $note = $_POST['note'];
    $coef = $_POST['coef'];
    $date = $_POST['date'];
    $id_enseignant = 2; // Remplacez par l'ID de l'enseignant approprié
    $id_ressource = 1; // Remplacez par l'ID de la ressource appropriée
    $id_ue = 1; // Remplacez par l'ID de l'UE appropriée

    $pdo = connexionDB();
    $stmt = $pdo->prepare('INSERT INTO Evaluation (note, date, id_etudiant, id_enseignant, id_ressource, id_ue, coef) VALUES (?,?,?,?,?,?,?)');
    $stmt->execute([$note, $date, $id_etudiant, $id_enseignant, $id_ressource, $id_ue, $coef]);

    echo "<script type='text/javascript'>
            alert('Ajout réussi');
            window.location.href = 'profboard.php';
          </script>";
}
?>


<div class="starter-template">
    <h1>Ajouter une note</h1>
    <form method="post">
    <div class="form-group">
            <label for="id_etudiant">id_etudiant</label>
            <input type="number" class="form-control" id="id_etudiant" name="id_etudiant" required>
        </div>
        <div class="form-group">
            <label for="Note">Note</label>
            <input type="number" class="form-control" id="note" name="note" required>
        </div>
        <div class="form-group">
            <label for="coef">Coef</label>
            <input type="number" class="form-control" id="coef" name="coef" required>
        </div>
        <div class="form-group">
            <label for="note_eliminat">date</label>
            <input type="date" step="0.01" class="form-control" id="date" name="date" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="epreuves.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>