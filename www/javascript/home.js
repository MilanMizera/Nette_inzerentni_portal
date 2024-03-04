
function addTown() {
    var select = document.getElementById("towns");
    var container = document.getElementById("town_value");

    var selectedTown = select.options[select.selectedIndex].text;

    // Zkontrolujte, zda město již není v seznamu
    if (!container.textContent.includes(selectedTown)) {
        // Přidej město s tlačítkem pro odstranění
        var mestoElement = document.createElement("span");
        mestoElement.textContent = selectedTown;

        var odstranElement = document.createElement("span");
        odstranElement.textContent = "✖";
        odstranElement.className = "odstran";
        odstranElement.onclick = function () {
            deleteTown(mestoElement);
        };

        mestoElement.appendChild(odstranElement);
        container.appendChild(mestoElement);
    }

}


function deleteTown(element) {
    var container = document.getElementById("town_value");

    // Odstraň vybrané město
    container.removeChild(element);
}




function addProfession() {
    var select = document.getElementById("professions");
    var container = document.getElementById("profession_value");

    var selectedProffesion = select.options[select.selectedIndex].text;

    // Zkontrolujte, zda město již není v seznamu
    if (!container.textContent.includes(selectedProffesion)) {
        // Přidej město s tlačítkem pro odstranění
        var mestoElement = document.createElement("span");
        mestoElement.textContent = selectedProffesion;

        var odstranElement = document.createElement("span");
        odstranElement.textContent = "✖";
        odstranElement.className = "odstran";
        odstranElement.onclick = function () {
            deleteProffesion(mestoElement);
        };

        mestoElement.appendChild(odstranElement);
        container.appendChild(mestoElement);
    }
}


function deleteProffesion(element) {
    var container = document.getElementById("profession_value");

    // Odstraň vybrané město
    container.removeChild(element);
}




function deleteObligation(element) {
    var container = document.getElementById("town_value");

    // Odstraň vybrané město
    container.removeChild(element);
}




function addObligation() {
    var select = document.getElementById("obligation");
    var container = document.getElementById("obligation_value");

    var selectedObligation = select.options[select.selectedIndex].text;

    // Zkontrolujte, zda město již není v seznamu
    if (!container.textContent.includes(selectedObligation)) {
        // Přidej město s tlačítkem pro odstranění
        var mestoElement = document.createElement("span");
        mestoElement.textContent = selectedObligation;

        var odstranElement = document.createElement("span");
        odstranElement.textContent = "✖";
        odstranElement.className = "odstran";
        odstranElement.onclick = function () {
            deleteObligation(mestoElement);
        };

        mestoElement.appendChild(odstranElement);
        container.appendChild(mestoElement);
    }
}


function deleteObligation(element) {
    var container = document.getElementById("obligation_value");

    // Odstraň vybrané město
    container.removeChild(element);
}




