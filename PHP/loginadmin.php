<?php
include 'config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["utilisateur"])) || empty(trim($_POST["password"]))){
        echo "Veuillez saisir à la fois votre nom d'utilisateur et votre mot de passe.";
    } else{
        $sql = "SELECT password FROM Administrateur WHERE utilisateur = :utilisateur";

        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":utilisateur", $param_utilisateur, PDO::PARAM_STR);
            $param_utilisateur = trim($_POST["utilisateur"]);

            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $hashed_password = $row["password"];
                        if(password_verify($_POST["password"], $hashed_password)){
                            session_start();
                            $_SESSION["admin"] = true;
                            header("location: adminboard.php");
                            exit;
                        } else{
                            echo "Le mot de passe que vous avez saisi est incorrect.";
                        }
                    }
                } else{
                    echo "Aucun compte trouvé avec cet identifiant.";
                }
            } else{
                echo "Oops! Quelque chose s'est mal passé. Veuillez réessayer plus tard.";
            }
            unset($stmt);
        }
    }
    unset($pdo);
}
?>
