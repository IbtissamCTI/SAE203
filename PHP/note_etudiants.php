<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes Étudiant</title>
    <link rel="stylesheet" href="../CSS/css_note_etudiants.css">
</head>
<body>
    <div class="header">
        <img src="../photo/logoblanc.png" alt="NoteNote Logo" class="logo">
        <button class="logout" onclick="location.href='login.php'">Quitter</button>
    </div>

    <div class="container">
        <div class="notes-recente">
            <img src="../photo/notelog 1.png" alt="Note Étudiant" class="note-image">
            <h3 class="recente">récentes</h3>
            <div class="grid-container">
                <div class="materes">
                    <p>ANGLAIS</p>
                    <p>FRANÇAIS</p>
                    <p>DEV WEB</p>
                    <p>C. NUMÉRIQUE</p>
                    <p>C. ARTISTIQUE</p>
                    <p>MATHÉMATIQUES</p>
                    <p>AUDIO VISUELLE</p>
                </div>
                <div class="notes">
                    <p>17/20</p>
                    <p>12/20</p>
                    <p>12/20</p>
                    <p>08/20</p>
                    <p>11/20</p>
                    <p>02/20</p>
                    <p>16/20</p>
                </div>
            </div>
        </div>

        <div class="matieres-moyenne">
            <h2>Matières</h2>
            <div class="matiere-grid" id="matiereGrid">
                <div class="matiere">ANGLAIS <span>12</span></div>
                <div class="matiere">FRANÇAIS <span>10</span></div>
                <div class="matiere">Developement WEB <span>02</span></div>
                <div class="matiere">Culture NUMÉRIQUE <span>11</span></div>
                <div class="matiere">Culture ARTISTIQUE <span>10</span></div>
                <div class="matiere">Audio VISUELLE <span>14</span></div>
                <div class="matiere">MATHÉ MATIQUE <span>19</span></div>
                <div class="matiere">HÉBERGEMENT <span>12</span></div>
                <div class="matiere">HISTOIRE <span>20</span></div>
            </div>
            <button class="btn-small" onclick="sortMatieres()">Trier par moyenne</button>
        </div>
    </div>

    <script>
        function sortMatieres() {
            var matiereGrid = document.getElementById('matiereGrid');
            var matieres = matiereGrid.getElementsByClassName('matiere');

            var matieresArray = Array.from(matieres);

            matieresArray.sort(function(a, b) {
                var moyenneA = parseInt(a.querySelector('span').innerText);
                var moyenneB = parseInt(b.querySelector('span').innerText);
                return moyenneB - moyenneA;
            });

            matieresArray.forEach(function(matiere) {
                matiereGrid.appendChild(matiere);
            });
        }
    </script>
</body>
</html>