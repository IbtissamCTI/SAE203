<?php
session_start();

include 'config.php';
$pdo = connexionDB();

if (isset($_POST['login'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM Compte WHERE login = :login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['type_compte'] = $user['type_compte'];
        $_SESSION['id_compte'] = $user['id_compte']; // Ajoutez cette ligne pour stocker l'id_compte dans la session

        echo "Connexion réussie";

        switch ($user['type_compte']) {
            case 'admin': 
                header("Location: adminboard.php");
                die();
                break;
            case 'enseignant': 
                header("Location: profboard.php");
                die();
                break;
            case 'etudiant': 
                header("Location: etudiantboard.php");
                die();
                break;
        }
    } else {
        echo "Identifiant ou mot de passe incorrect.";
    }
} 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/SAE203-201/CSS/ETUDIANT.css">
    <title>Page de connexion</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <p>Les fruits du travail</p>
        </div>

        <div class="login-box">
            <form method="POST">
                <div class="input-container">
                    <label for="login">Identifiant</label>
                    <input type="text" id="login" name="login" required>
                </div>
                <div class="input-container">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Connexion</button>
            </form>
        </div>

        <div class="footer">
            <p>ESPACE CONNEXION</p>
        </div>
    </div>
</body>
</html>



