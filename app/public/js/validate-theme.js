const tips = document.getElementById("tips-title");
const errors = document.getElementById("errors-title");

const formTitle = document.getElementById("form-title");

function validateModal(event) {    
    let title = formTitle.value;

    let nb = title.length;

    let valid = (nb > 0 && nb <= 50);
        
    if (valid) {
        tips.value = "";
    } else {
        errorsTitle.value = "Le titre doit être renseigné et contenir jusqu'à 50 caractères.";

        event.preventDefault();
    }
}