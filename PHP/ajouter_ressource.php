<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Ressource</title>
    <link rel="stylesheet" href="../CSS/ressourceajout.css">
</head>
<body>
    <header>
        <img src="../photo/logoblanc.png" alt="NoteNote Logo" class="logo">
        <nav>
            <button class="logout" onclick="location.href='login.php'">Quitter</button>
        </nav>
    </header>

    <div id="back-button">
        <a href="../PHP/admin_partie_ressources.php">
            <img src="../photo/BOUTONARRIERE.png" alt="Back Button" class="back-button-img">
        </a>
    </div>

    <div class="container">
        <form class="form-container" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="id_ressource">ID Ressource:</label>
            <input type="number" id="id_ressource" name="id_ressource" required>
            
            <label for="libelle">Libellé:</label>
            <input type="text" id="libelle" name="libelle" required>
            
            <label for="libelle_ue">Libellé UE:</label>
            <select id="libelle_ue" name="libelle_ue" required>
                <?php
                include 'config.php';

                $pdo = connexionDB();

                $sql = "SELECT id_ue, libelle FROM UE";
                $stmt = $pdo->query($sql);

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id_ue'] . "'>" . $row['libelle'] . "</option>";
                }
                ?>
            </select>

            <label for="id_enseignant">Enseignant:</label>
            <select id="id_enseignant" name="id_enseignant" required>
                <?php
                $sql = "SELECT id_compte, nom, prenom FROM Enseignant";
                $stmt = $pdo->query($sql);

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['id_compte'] . "'>" . $row['nom'] . " " . $row['prenom'] . "</option>";
                }
                ?>
            </select>

            <div class="form-buttons">
                <input type="submit" class="form-btn" value="Ajouter Ressource">
            </div>
        </form>
    </div>

</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ressource = $_POST['id_ressource'];
    $libelle = $_POST['libelle'];
    $libelle_ue = $_POST['libelle_ue'];
    $id_enseignant = $_POST['id_enseignant'];

    if (empty($id_ressource) || empty($libelle) || empty($libelle_ue) || empty($id_enseignant)) {
        echo "Erreur : les champs du formulaire sont incomplets.";
        exit;
    }

    try {
        $pdo = connexionDB();

        $sql = "INSERT INTO Ressource (id_ressource, libelle, libelle_ue) VALUES (:id_ressource, :libelle, :libelle_ue)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_ressource', $id_ressource);
        $stmt->bindParam(':libelle', $libelle);
        $stmt->bindParam(':libelle_ue', $libelle_ue);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $sql = "INSERT INTO Enseignant_ressource (id_enseignant, id_ressource) VALUES (:id_enseignant, :id_ressource)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_enseignant', $id_enseignant);
            $stmt->bindParam(':id_ressource', $id_ressource);
            $stmt->execute();

            header("Location: accueil_admin.php");
            exit();
        } else {
            echo "Erreur : L'ajout de la ressource a échoué. Veuillez réessayer.";
        }
    } catch (PDOException $e) {
        echo "Erreur d'insertion : " . $e->getMessage();
    }
}
?>
