const deleteModal = document.getElementById("delete-modal");

function openModal(type, values) {
    deleteModal.style.display = 'block';

    // Values

    const id = values["id"];
    const token = values["token"];
    const title = values["title"];

    // Form & Data

    const deleteForm = document.getElementById("delete-form");

    const link = `http://localhost/en_app/${type}/delete/${id}`;

    const deleteToken = document.getElementById("delete-token");
    const deleteTitle = document.getElementById("delete-title");

    // AJAX Request
    
    const xmlHttp = new XMLHttpRequest();

    xmlHttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            deleteForm.action = link;
            deleteTitle.innerHTML = title;
            deleteToken.value = token;
        }
    }

    xmlHttp.open("GET", link, true);
    xmlHttp.send();
}

function closeModal() {
    deleteModal.style.display = 'none';
}