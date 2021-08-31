const flashcards = document.getElementsByClassName("flashcard");
const answers = document.getElementsByClassName("answers");
const closeButtons = document.getElementsByClassName("card-close");

const nb = flashcards.length;

showAnswers();
closeCards();

function showAnswers() {
    for (let index = 0 ; index < nb ; index++) {
        flashcards[index].addEventListener("click", () => {
            answers[index].style.display = "block";
            closeButtons[index].style.display = "block";
        });
    }
}

function closeCards() {
    for (let index = 0 ; index < nb ; index++) {
        closeButtons[index].addEventListener("click", () => {
            flashcards[index].style.display = "none";
        });

        closeButtons[index].style.display = "none";
    }
}