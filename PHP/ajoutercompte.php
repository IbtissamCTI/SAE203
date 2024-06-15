<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Compte</title>
    <link rel="stylesheet" href="../CSS/ajouter_categorie.css">
    <script>
        function toggleFields() {
            var typeCompte = document.getElementById('type_compte').value;
            document.getElementById('enseignant_fields').style.display = (typeCompte === 'enseignant') ? 'block' : 'none';
            document.getElementById('etudiant_fields').style.display = (typeCompte === 'etudiant') ? 'block' : 'none';
        }
    </script>
</head>
<body>
    <header>
        <img src="../photo/logoblanc.png" alt="NoteNote Logo" class="logo">
        <nav>
            <button class="logout" onclick="location.href='login.php'">Quitter</button>
        </nav>
    </header>
    <div id="back-button">
        <a href="admin_partie_compte.php">
            <img src="../photo/BOUTONARRIERE.png" alt="Back Button" class="back-button-img">
        </a>
    </div>
    <main class="container">
        <div class="form-container">
            <form action="ajoutercompte.php" method="post">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required>
                
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
                
                <label for="type_compte">Type de compte</label>
                <select id="type_compte" name="type_compte" onchange="toggleFields()" required>
                    <option value="">Sélectionnez le type de compte</option>
                    <option value="admin">Admin</option>
                    <option value="enseignant">Enseignant</option>
                    <option value="etudiant">Étudiant</option>
                </select>
                
                <div id="enseignant_fields" style="display:none;">
                    <label for="nom_enseignant">Nom</label>
                    <input type="text" id="nom_enseignant" name="nom_enseignant">
                    
                    <label for="prenom_enseignant">Prénom</label>
                    <input type="text" id="prenom_enseignant" name="prenom_enseignant">
                    
                    <label for="ressource">Ressource</label>
                    <select id="ressource" name="ressource">
                        <?php
                        include 'config.php';
                        $pdo = connexionDB();
                        $stmt = $pdo->query("SELECT id_ressource, libelle FROM Ressource");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['id_ressource']}'>{$row['libelle']}</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div id="etudiant_fields" style="display:none;">
                    <label for="nom_etudiant">Nom</label>
                    <input type="text" id="nom_etudiant" name="nom_etudiant">
                    
                    <label for="prenom_etudiant">Prénom</label>
                    <input type="text" id="prenom_etudiant" name="prenom_etudiant">
                    
                    <label for="groupe">Groupe</label>
                    <select id="groupe" name="groupe">
                        <?php
                        $stmt = $pdo->query("SELECT id_groupe, libelle FROM Groupe");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['id_groupe']}'>{$row['libelle']}</option>";
                        }
                        ?>
                    </select>
                </div>
                
                <div class="form-buttons">
                    <button class="form-btn" type="reset" id="effacer">Effacer</button>
                    <button class="form-btn" type="submit" id="envoyer">Envoyer</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>

<?php

require_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = connexionDB();

        $nom_utilisateur = htmlspecialchars($_POST['login'] ?? '');
        $mot_de_passe = htmlspecialchars($_POST['password'] ?? '');
        $type_compte = htmlspecialchars($_POST['type_compte'] ?? '');

        if (!empty($nom_utilisateur) && !empty($mot_de_passe) && !empty($type_compte)) {

            $hash_mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            // Insertion du compte dans la table Compte
            $sql_insert_compte = "INSERT INTO Compte (login, password, type_compte) VALUES (:login, :password, :type_compte)";
            $stmt_compte = $pdo->prepare($sql_insert_compte);
            $stmt_compte->bindParam(':login', $nom_utilisateur);
            $stmt_compte->bindParam(':password', $hash_mot_de_passe);
            $stmt_compte->bindParam(':type_compte', $type_compte);

            if ($stmt_compte->execute()) {
                $id_compte = $pdo->lastInsertId();

                if ($type_compte == 'enseignant') {
                    $nom = htmlspecialchars($_POST['nom_enseignant'] ?? '');
                    $prenom = htmlspecialchars($_POST['prenom_enseignant'] ?? '');
                    $ressource_id = htmlspecialchars($_POST['ressource'] ?? '');

                    if (!empty($nom) && !empty($prenom) && !empty($ressource_id)) {
                        $sql_insert_enseignant = "INSERT INTO Enseignant (id_compte, nom, prenom) VALUES (:id_compte, :nom, :prenom)";
                        $stmt_enseignant = $pdo->prepare($sql_insert_enseignant);
                        $stmt_enseignant->bindParam(':id_compte', $id_compte);
                        $stmt_enseignant->bindParam(':nom', $nom);
                        $stmt_enseignant->bindParam(':prenom', $prenom);

                        if ($stmt_enseignant->execute()) {
                            $sql_insert_enseignant_ressource = "INSERT INTO Enseignant_ressource (id_enseignant, id_ressource) VALUES (:id_enseignant, :id_ressource)";
                            $stmt_enseignant_ressource = $pdo->prepare($sql_insert_enseignant_ressource);
                            $stmt_enseignant_ressource->bindParam(':id_enseignant', $id_compte);
                            $stmt_enseignant_ressource->bindParam(':id_ressource', $ressource_id);

                            if ($stmt_enseignant_ressource->execute()) {
                                echo "Enseignant ajouté et lié à la ressource avec succès.<br>";
                            } else {
                                echo "Erreur lors de la liaison de l'enseignant à la ressource.<br>";
                            }
                        } else {
                            echo "Erreur lors de l'ajout de l'enseignant.<br>";
                        }
                    } else {
                        echo "Erreur : les champs du formulaire pour l'enseignant sont incomplets.<br>";
                    }
                } elseif ($type_compte == 'etudiant') {
                    $nom = htmlspecialchars($_POST['nom_etudiant'] ?? '');
                    $prenom = htmlspecialchars($_POST['prenom_etudiant'] ?? '');
                    $groupe_id = htmlspecialchars($_POST['groupe'] ?? '');

                    if (!empty($nom) && !empty($prenom) && !empty($groupe_id)) {
                        $sql_insert_etudiant = "INSERT INTO Etudiant (id_compte, nom, prenom, id_groupe) VALUES (:id_compte, :nom, :prenom, :id_groupe)";
                        $stmt_etudiant = $pdo->prepare($sql_insert_etudiant);
                        $stmt_etudiant->bindParam(':id_compte', $id_compte);
                        $stmt_etudiant->bindParam(':nom', $nom);
                        $stmt_etudiant->bindParam(':prenom', $prenom);
                        $stmt_etudiant->bindParam(':id_groupe', $groupe_id);

                        if ($stmt_etudiant->execute()) {
                            echo "Étudiant ajouté avec succès.<br>";
                        } else {
                            echo "Erreur lors de l'ajout de l'étudiant.<br>";
                        }
                    } else {
                        echo "Erreur : les champs du formulaire pour l'étudiant sont incomplets.<br>";
                    }
                } else {
                    echo "Compte administrateur ajouté avec succès.<br>";
                }
            } else {
                echo "Erreur lors de l'ajout du compte.<br>";
            }
        } else {
            echo "Erreur : les champs du formulaire sont incomplets.<br>";
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>





