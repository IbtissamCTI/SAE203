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
                header("Location: adminboard.php");
                exit();
            case 'enseignant': 
                header("Location: profboard.php");
                exit();
            case 'etudiant': 
                header("Location: etudiantboard.php");
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
    <title>Accueil Professeur</title>
    <link rel="stylesheet" href="../CSS/accueil_prof.css">
</head>
<body>
    <div class="header">
        <img src="../photo/logoblanc.png" alt="NoteNote Logo" class="logo">
        <button class="logout" onclick="location.href='login.php'">Quitter</button>
    </div>

    <div class="container">
        <button class="btn" onclick="location.href='Ajouternote.php'">Ajouter Evaluation</button>
        <button class="btn" onclick="location.href='Modifnote.php'">Modifier les notes</button>
        <button class="btn" onclick="location.href='listeetudiant_partieprof.php'">Acceder à la liste</button>
    </div>
</body>
</html>

