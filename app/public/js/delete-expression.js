const deleteModal = document.getElementById("delete-modal");

function openModal(id, french, english) {
    deleteModal.style.display = 'block';

    const deleteFR = document.getElementById("delete-fr");
    const deleteEN = document.getElementById("delete-en");

    const deleteForm = document.getElementById("delete-form");

    const link = `http://localhost/en_app/themes/delete/${id}`;

    // AJAX Request
    
    const xmlHttp = new XMLHttpRequest();

    xmlHttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            deleteForm.action = link;
            deleteTitle.innerHTML = title;
        }
    }

    xmlHttp.open("GET", link, true);
    xmlHttp.send();
}

function closeModal() {
    deleteModal.style.display = 'none';
}