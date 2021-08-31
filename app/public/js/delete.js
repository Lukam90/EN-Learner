const deleteModal = document.getElementById("delete-modal");
const deleteForm = document.getElementById("delete-form");

const openBtn = document.getElementById("open-btn");
const closeBtn = document.getElementById("close-btn");
const confirmBtn = document.getElementById("confirm-btn");

openBtn.addEventListener("click", (event) => {
    event.preventDefault();

    deleteModal.style.display = 'block';
});

closeBtn.addEventListener("click", () => {
    deleteModal.style.display = 'none';
});

confirmBtn.addEventListener("click", () => {
    deleteForm.submit();
});