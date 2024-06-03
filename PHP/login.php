<?php
session_start();

include 'config.php';
$pdo=connexionDB();
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $stmt = $pdo->prepare("SELECT * FROM COMPTES WHERE utilisateur = :username");
    $stmt->bindParam(':username', $username);
   // $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch();
    var_dump($user);
    if ( password_verify($password,$user['password'])){
        echo "conenxion reussi";
            $_SESSION['user_id'] = $user['id'];
            echo $user['id'];

        }
    
  
        switch ($user['id']) {
            case 1: 
                header("Location: adminboard.php");
                die();
                break;
            case 2: 
                header("Location: profboard.php");
                die();
                break;
            case 3: 
                header("Location: etudiantboard.php");
                die();
                break;
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
                    <label for="utilisateur">Identifiant</label>
                    <input type="text" id="utilisateur" name="username" required>
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