function enableEditing() {
    const table = document.querySelector('table tbody');
    const cells = table.querySelectorAll('td');
    cells.forEach(cell => {
        cell.setAttribute('contenteditable', 'true');
    });
}

function saveData() {
    const table = document.querySelector('table tbody');
    const rows = table.querySelectorAll('tr');
    let data = [];

    rows.forEach(row => {
        let rowData = {};
        const cells = row.querySelectorAll('td');
        rowData.ue = cells[0].textContent;
        rowData.matiere = cells[1].textContent;
        rowData.intitule = cells[2].textContent;
        rowData.note = cells[3].textContent;
        rowData.coefficient = cells[4].textContent;
        data.push(rowData);
    });

    console.log("Données enregistrées:", data); 
    alert("Données enregistrées avec succès !");
}
