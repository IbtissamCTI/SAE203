
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

<?php
include 'config.php'; 
$pdo=connexionDB();

echo "<h2>Table des étudiants</h2>";
echo "<table border='1'>";
echo "<tr><th>Idlog</th><th>ID_etudiant</th><th>Nom</th><th>Prenom</th><th>Email</th><th>Mot_de_passe</th><th>Niveau</th><th>Groupe</th><th>Promotion</th></tr>";

$query = "SELECT * FROM Etudiants";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>". $row['Idlog']. "</td>";
    echo "<td>". $row['idEtudiant']. "</td>";
    echo "<td>". $row['Nom']. "</td>";
    echo "<td>". $row['Prenom']. "</td>";
    echo "<td>". $row['Email']. "</td>";
    echo "<td>". $row['Mot_de_passe']. "</td>";
    echo "<td>". $row['Niveau']. "</td>";
    echo "<td>". $row['Groupe']. "</td>";
    echo "<td>". $row['Promotion']. "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h2>Ajouter un étudiant</h2>";
echo "<form action='' method='post'>";
echo "<label for='idEtudiant'>ID Étudiant :</label>";
echo "<input type='text' id='idEtudiant' name='idEtudiant'><br><br>";
echo "<label for='classe'>Classe :</label>";
echo "<input type='text' id='classe' name='classe'><br><br>";
echo "<input type='submit' value='Ajouter'>";
echo "</form>";

