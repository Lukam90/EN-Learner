const addModal = document.getElementById("add-modal");

function openAddModal(token) {
    addModal.style.display = 'block';

    // Form & Data

    const link = "http://localhost/en_app/themes/new";

    const addForm = document.getElementById("add-form");
    const addToken = document.getElementById("add-token");

    // AJAX Request
    
    const xmlHttp = new XMLHttpRequest();

    xmlHttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            addForm.action = link;
            addToken.value = token;
        }
    }

    xmlHttp.open("GET", link, true);
    xmlHttp.send();
}

function closeAddModal() {
    addModal.style.display = 'none';
}