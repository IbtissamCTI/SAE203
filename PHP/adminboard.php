<?php

session_start();

if (!isset($_SESSION["lastname"])) {
    header("Location indexco.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    PAGE DE CONNEXION
</body>
</html>