const deleteModal = document.getElementById("delete-modal");

function openModal(id, title) {
    const deleteTitle = document.getElementById("delete-title");

    // AJAX Request
    
    const xmlHttp = new XMLHttpRequest();

    xmlHttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            deleteForm.action = `{{ root }}/themes/delete/${id}`;
            deleteTitle.innerHTML = title;
        }
    }

    xmlHttp.open("GET", `{{ root }}/themes/delete/${id}`, true);
    xmlHttp.send();
}

function closeModal() {
    deleteModal.style.display = 'none';
}