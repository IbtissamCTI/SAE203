<?php
include 'config.php';
session_start();

if (!isset($_SESSION['id_compte'])) {
    header("Location: login.php");
    exit();
}

$pdo = connexionDB();

$stmt_libelles = $pdo->query("SELECT DISTINCT libelle FROM Evaluation");
$libelles = $stmt_libelles->fetchAll(PDO::FETCH_COLUMN);

$students = [];
$notes = [];
$selected_libelle = null;
$update_success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['libelle'])) {
        $selected_libelle = $_POST['libelle'];

        $stmt_students = $pdo->prepare("SELECT e.id_compte, e.nom, e.prenom, ev.note 
                                        FROM Etudiant e
                                        JOIN Evaluation ev ON e.id_compte = ev.id_etudiant
                                        WHERE ev.libelle = :libelle");
        $stmt_students->bindParam(':libelle', $selected_libelle);
        $stmt_students->execute();

        if ($stmt_students === false) {
            echo "Erreur PDO : " . implode(" ", $pdo->errorInfo());
            exit();
        }

        $students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

        if (empty($students)) {
            echo "Aucun étudiant trouvé pour le libellé sélectionné : " . $selected_libelle;
        } else {
            foreach ($students as $student) {
                $notes[$student['id_compte']] = $student['note'];
            }
        }
    }

    if (isset($_POST['submit']) && isset($_POST['notes'])) {
        $new_notes = $_POST['notes'];

        foreach ($new_notes as $id_compte => $new_note) {
            if ($new_note !== '' && is_numeric($new_note)) {
                $stmt_update = $pdo->prepare("UPDATE Evaluation 
                                              SET note = :note 
                                              WHERE id_etudiant = :id_compte AND libelle = :libelle");
                $stmt_update->bindParam(':note', $new_note, PDO::PARAM_STR);
                $stmt_update->bindParam(':id_compte', $id_compte, PDO::PARAM_INT);
                $stmt_update->bindParam(':libelle', $selected_libelle, PDO::PARAM_STR);
                if ($stmt_update->execute()) {
                    $update_success = true;
                } else {
                    echo "Erreur de mise à jour pour l'étudiant $id_compte : " . implode(" ", $stmt_update->errorInfo());
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier les notes</title>
    <link rel="stylesheet" href="../CSS/modif.css">
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
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
        <form method="post" action="Modifnote.php" class="evaluation-form">
            <div class="form-group">
                <label for="libelle">Sélectionner le libellé :</label>
                <select class="form-control" id="libelle" name="libelle" required>
                    <option value="">Choisir un libellé</option>
                    <?php foreach ($libelles as $libelle) { ?>
                        <option value="<?php echo $libelle; ?>" <?php echo ($selected_libelle == $libelle) ? 'selected' : ''; ?>><?php echo $libelle; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-3">Valider</button>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Étudiant</th>
                        <th>Note actuelle</th>
                        <th>Nouvelle note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student) { ?>
                        <tr>
                            <td><?php echo $student['nom'] . ' ' . $student['prenom']; ?></td>
                            <td><?php echo isset($notes[$student['id_compte']]) ? $notes[$student['id_compte']] : 'Aucune note'; ?></td>
                            <td><input type="number" class="form-control" name="notes[<?php echo $student['id_compte']; ?>]" min="0" max="20" step="0.5"></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit" name="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
    </div>

    <?php if ($update_success) { ?>
        <script>
            showAlert("Les modifications ont été enregistrées avec succès.");
        </script>
    <?php } ?>
</body>
</html>
