<?php
include 'config.php';
session_start();

// Vérification de la session de connexion
if (!isset($_SESSION['id_compte'])) {
    header("Location: login.php");
    exit();
}

$pdo = connexionDB();

// Récupération des libellés distincts associés aux évaluations
$stmt_libelles = $pdo->query("SELECT DISTINCT libelle FROM Evaluation");
$libelles = $stmt_libelles->fetchAll(PDO::FETCH_COLUMN);

$students = [];
$notes = [];
$selected_libelle = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_libelle = $_POST['libelle'];

    // Récupération des étudiants et notes pour le libellé sélectionné
    $stmt_students = $pdo->prepare("SELECT e.id_compte, e.nom, e.prenom, ev.note 
                                    FROM Etudiant e
                                    JOIN Evaluation ev ON e.id_compte = ev.id_etudiant
                                    WHERE ev.libelle = :libelle");
    $stmt_students->bindParam(':libelle', $selected_libelle);
    $stmt_students->execute();

    // Vérification des erreurs PDO
    if ($stmt_students === false) {
        echo "Erreur PDO : " . implode(" ", $pdo->errorInfo());
        exit();
    }

    // Récupération des résultats de la requête
    $students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

    // Afficher la requête SQL pour récupérer les étudiants
    echo "Requête SQL pour récupérer les étudiants : " . $stmt_students->queryString . "<br>";

    // Vérification si des étudiants ont été récupérés
    if (empty($students)) {
        echo "Aucun étudiant trouvé pour le libellé sélectionné : " . $selected_libelle;
    } else {
        // Récupération des notes
        foreach ($students as $student) {
            $notes[$student['id_compte']] = $student['note'];
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Modifier les notes</h1>
        <form method="post" action="Modifnote.php" id="noteForm">
    <div class="form-row align-items-center">
        <div class="col-auto">
            <label class="sr-only" for="libelle">Sélectionner le libellé :</label>
            <select class="form-control mb-2" id="libelle" name="libelle" required>
                <option value="">Choisir un libellé</option>
                <?php foreach ($libelles as $libelle) { ?>
                    <option value="<?php echo $libelle; ?>" <?php echo ($selected_libelle == $libelle) ? 'selected' : ''; ?>><?php echo $libelle; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-2">Valider</button>
        </div>
    </div>

    <table class="table">
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
