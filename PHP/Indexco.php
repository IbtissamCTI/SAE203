<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteNote - Espace Étudiant</title>
    <link rel="stylesheet" href="cssetudiant.css">
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
                    <input type="text" id="login" name="identifiant" required>
                </div>
                <div class="input-container">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="mdp" name="password" required>
                </div>
                <button type="submit">Connexion</button>
            </form>
        </div>

        <div class="footer">
            <p>ESPACE ETUDIANT</p>
        </div>
    </div>

</body>
</html>


<?php
session_start();
include 'config.php';

if ($SERVER['REQUEST_METHOD'] === 'POST'){
    $pdo = connexionBDD();
    $utilisateur = $_POST['login'];
    $pswrd = $_POST['mdp'];

    $statement = $pdo->prepare('SELECT * FROM Administrateur WHERE utilisateur = :username');
    $statement =bindParam(':username', $username);
    $statement-> execute(); //execute l'instruciton déjà préparée (la requete ligne 10)
    $admin = $statement-> fetch(); 

    if ($admin && password_verifyt($pswrd, $admin['mdp'])){
        $_SESSION['admin'] = $admin['idAdmin'];
        header('Location: epreuve.php');
        exit;
    }
    else {
        $error = "Identifiants ou mot de passe incorrect"; 
    }
}