const deleteModal = document.getElementById("delete-modal");

function openDeleteModal(type, values) {
    deleteModal.style.display = 'block';

    // Values

    const id = values["id"];
    const token = values["token"];
    const text = values["text"];

    // Form & Data

    const link = `http://localhost/en_app/${type}/delete/${id}`;

    const deleteForm = document.getElementById("delete-form");
    const deleteToken = document.getElementById("delete-token");
    const deleteText = document.getElementById("delete-text");

    // AJAX Request
    
    const xmlHttp = new XMLHttpRequest();

    xmlHttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            deleteForm.action = link;
            deleteText.innerHTML = text;
            deleteToken.value = token;
        }
    }

    xmlHttp.open("GET", link, true);
    xmlHttp.send();
}

function closeDeleteModal() {
    deleteModal.style.display = 'none';
}

