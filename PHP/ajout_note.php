<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant que professeur
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != '2') {
    header("Location: index.php"); // Rediriger vers la page de connexion si ce n'est pas le cas
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une note</title>
    <link rel="stylesheet" href="../CSS/css_evaluation-prof.css">
</head>
<body>
    <h1>Ajouter une note</h1>
    
    <?php
    // Afficher un message de succès si la note a été ajoutée avec succès
    if (isset($_GET['success']) && $_GET['success'] === 'true') {
        echo "<p style='color: green;'>La note a été ajoutée avec succès.</p>";
    }

    // Afficher un message d'erreur s'il y a eu un problème lors de l'ajout de la note
    if (isset($_GET['error']) && $_GET['error'] === 'true') {
        $errorMessage = isset($_GET['message']) ? $_GET['message'] : "Une erreur s'est produite lors de l'ajout de la note.";
        echo "<p style='color: red;'>Erreur : $errorMessage</p>";
    }
    ?>
    
    <form action="" method="post">
        <label for="student_id">Étudiant :</label>
        <select name="student_id" id="student_id" required>
            <?php
            $pdo = connexionDB();
            $stmt = $pdo->query("SELECT id, nom FROM Etudiants"); // Sélectionnez à la fois l'ID et le nom de l'étudiant
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>"; // Utilisez l'ID comme valeur et le nom de l'étudiant comme texte affiché
            }
            ?>
        </select>
        <label for="resource_id">Ressource :</label>
        <select name="resource_id" id="resource_id" required>
            <?php
            $stmt = $pdo->query("SELECT id, nom FROM Ressources");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row['id'] . "'>" . $row['nom'] . "</option>";
            }
            ?>
        </select>
        <label for="grade">Note :</label>
        <input type="number" name="grade" id="grade" required>
        <button type="submit">Ajouter</button>
    </form>
    <a href="profboard.php">Retour au tableau de bord</a>
</body>
</html>
