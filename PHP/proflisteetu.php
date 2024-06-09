<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Liste des étudiants par niveau</title>
    <link href="../css/listetudiant.css" rel="stylesheet" type="text/css"/>
    <link href="../css/tableStyles.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<header>
    <nav>
        <div class="menu">
            <img class="logo" src="../image/Logo.png" alt="logo">
        </div>
    </nav>
</header>

<div class="etudiants-par-niveau">
    <h3>Liste des étudiants</h3>
    <form method="get" action="">
        <label for="niveau">Sélectionnez le niveau :</label>
        <select id="niveau" name="niveau">
            <option value="BUT1">BUT1</option>
            <option value="BUT2">BUT2</option>
            <option value="BUT3">BUT3</option>
        </select>
        <input type="submit" value="Voir les étudiants"/>
    </form>

<?php
