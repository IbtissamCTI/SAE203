<?php
include 'config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

$pdo = connexionDB();
$etudiants = [];


$stmtGroupes = $pdo->prepare("SELECT id_groupe, libelle FROM Groupe");
$stmtGroupes->execute();
$groupes = $stmtGroupes->fetchAll(PDO::FETCH_ASSOC);

$id_enseignant = 2; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['groupe'])) {
    $id_groupe = $_POST['groupe'];

    if ($id_groupe == 0) {
        $stmt = $pdo->prepare("
            SELECT e.id_compte, e.nom, e.prenom, 
            IFNULL(SUM(ev.note * ev.coef) / NULLIF(SUM(ev.coef), 0), 'N/A') as moyenne
            FROM Etudiant e
            LEFT JOIN Evaluation ev ON e.id_compte = ev.id_etudiant AND ev.id_enseignant = :id_enseignant
            GROUP BY e.id_compte, e.nom, e.prenom
        ");
        $stmt->bindParam(':id_enseignant', $id_enseignant, PDO::PARAM_INT);
    } else {
        $stmt = $pdo->prepare("
            SELECT e.id_compte, e.nom, e.prenom, 
            IFNULL(SUM(ev.note * ev.coef) / NULLIF(SUM(ev.coef), 0), 'N/A') as moyenne
            FROM Etudiant e
            LEFT JOIN Evaluation ev ON e.id_compte = ev.id_etudiant AND ev.id_enseignant = :id_enseignant
            WHERE e.id_groupe = :id_groupe
            GROUP BY e.id_compte, e.nom, e.prenom
        ");
        $stmt->bindParam(':id_groupe', $id_groupe, PDO::PARAM_INT);
        $stmt->bindParam(':id_enseignant', $id_enseignant, PDO::PARAM_INT);
    }
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // LE AVG POUR AFFICHER LEUR MOYENNE DONNAIT UNE ERREUR
    $stmt = $pdo->prepare("
        SELECT e.id_compte, e.nom, e.prenom, 
        IFNULL(SUM(ev.note * ev.coef) / NULLIF(SUM(ev.coef), 0), 'N/A') as moyenne
        FROM Etudiant e
        LEFT JOIN Evaluation ev ON e.id_compte = ev.id_etudiant AND ev.id_enseignant = :id_enseignant
        GROUP BY e.id_compte, e.nom, e.prenom
    ");
    $stmt->bindParam(':id_enseignant', $id_enseignant, PDO::PARAM_INT);
    $stmt->execute();
    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des étudiants</title>
    <link rel="stylesheet" href="../CSS/css_liste_etudiants.css">
</head>
<body>
<div class="container">
    <h1>Liste des étudiants</h1>
    <form method="post" action="">
        <div class="form-group">
            <label for="groupe">Sélectionner un groupe</label>
            <select class="form-control" id="groupe" name="groupe" required>
                <option value="0">Tous les étudiants</option>
                <?php foreach ($groupes as $groupe) { ?>
                    <option value="<?php echo $groupe['id_groupe']; ?>"><?php echo $groupe['libelle']; ?></option>
                <?php } ?>
            </select>
        </div>
        <p>
        <button type="submit" class="btn btn-primary">Afficher</button>
        </p>
    </form>

    <?php if (!empty($etudiants)) { ?>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Moyenne</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($etudiants as $etudiant) { ?>
                    <tr>
                        <td><?php echo $etudiant['nom']; ?></td>
                        <td><?php echo $etudiant['prenom']; ?></td>
                        <td><?php echo is_numeric($etudiant['moyenne']) ? number_format($etudiant['moyenne'], 2) : 'N/A'; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Aucun étudiant trouvé.</p>
    <?php } ?>
</div>
</body>
</html>


