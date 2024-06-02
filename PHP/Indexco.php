<?php
session_start();
include 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $pdo = connexionBDD();
    $utilisateur = $_POST['identifiant'];
    $pswrd = $_POST['password'];

    $statement = $pdo->prepare('SELECT * FROM Administrateur WHERE utilisateur = :utilisateur');
    $statement->bindParam(':utilisateur', $utilisateur);
    $statement->execute(); //execute l'instruciton déjà préparée (la requete ligne 10)
    $admin = $statement->fetch(); //afficher en forme de tableau les elements select de la bdd 

    if ($admin && password_verify($pswrd, $admin['password'])){
        $_SESSION['admin'] = $admin['idAdmin'];
        header('Location: http://localhost/SAE203-201/PHP/adminboard.php');
        exit;
    }
    else {
        $error = "Identifiants ou mot de passe incorrect";
     
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteNote - Espace Étudiant</title>
    <link rel="stylesheet" href="http://localhost/SAE203-201/CSS/ETUDIANT.css">
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="../Desktop/logoblanc.png" alt="NoteNote Logo">
            <p>Les fruits du travail</p>
        </div>

        <div class="login-box">
            <form action="your_login_endpoint" method="POST">
                <div class="input-container">
                    <label for="identifiant">Identifiant</label>
                    <input type="text" id="identifiant" name="identifiant" required> <!-- Identifiant modifié -->
                </div>
                <div class="input-container">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="mdp" name="password" required>
                </div>
                <button type="submit">Connexion</button>
                <?php if (!empty($error)) { ?>
                    <p><?php echo $error; ?></p>
                <?php } ?>
            </form>
        </div>

        <div class="footer">
            <p>ESPACE ADMIN</p>
        </div>
    </div>

</body>
</html>
