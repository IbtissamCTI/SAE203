<?php
session_start();

include 'config.php';
$pdo = connexionDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM Compte WHERE login = :login");
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['type_compte'] = $user['type_compte'];
        $_SESSION['id_compte'] = $user['id_compte']; 

        switch ($user['type_compte']) {
            case 'admin': 
                header("Location: accueil_admin.php");
                exit();
            case 'enseignant': 
                header("Location: profboard.php");
                exit();
            case 'etudiant': 
                header("Location: note_etudiants.php");
                exit();
        }
    } else {
        $error_message = "Identifiant ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <title>Page de connexion</title>
</head>
<body>
    <div class="header">
        <img src="../photo/logoNOTENOTEvert.png" alt="NoteNote Logo">
        <p>Les fruits du travail</p>
    </div>
    <div class="login-container">
        <div class="login-box">
            <h2>Connexion</h2>
            <?php
            if (isset($error_message)) {
                echo "<p style='color: red;'>$error_message</p>";
            }
            ?>
            <form method="POST">
                <input type="text" name="login" placeholder="Identifiant" required>
                <input type="password" name="password" placeholder="Mot de passe" required>
                <button type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</body>
</html>
