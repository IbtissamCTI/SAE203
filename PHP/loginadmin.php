<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo = connexionBDD(); 
    $username = $_POST['utilisateur']; 
    $password = $_POST['password']; 

    $stmt = $pdo->prepare('SELECT * FROM Administrateur WHERE utilisateur = :utilisateur'); 
    $stmt->bindParam(':utilisateur', $username);
    $stmt->execute();
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = $admin['idAdmin']; 
        header('Location: adminboard.php'); 
        exit;

    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect";
    }
}
?>

