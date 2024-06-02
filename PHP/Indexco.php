<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/SAE203-201/CSS/ETUDIANT.css">

    <title>Page de connexion administrateur</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <p>Les fruits du travail</p>
        </div>

        <div class="login-box">
            <form action="loginadmin.php" method="POST">
                <div class="input-container">
                    <label for="identifiant">Identifiant</label>
                    <input type="text" id="identifiant" name="utilisateur" required>
                </div>
                <div class="input-container">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" id="mdp" name="password" required>
                </div>
                <button type="submit">Connexion</button>
            </form>
        </div>

        <div class="footer">
            <p>ESPACE ADMIN</p>
        </div>
    </div>
</body>
</html>
