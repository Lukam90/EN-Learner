let index = 0;

let flashcards = document.getElementsByClassName("flashcards");

let count = flashcards.length;

let nextButtons = document.getElementsByClassName("next");

let restartBtn = document.getElementById("restart");

nextSlide();

function nextSlide() {
    

    for (let i = 0 ; i < count ; i++) {
        flashcards[i].style.display = "none";
    }

    if (index < count) {
        flashcards[index].style.display = "block";
        index++;
    }
}

function flipCard() {
    let answers = document.querySelector(`#card${index} > .answer`);
    let nextButton = nextButtons[index];

    if (answers.style.visibility != "visible") {
        answers.style.visibility = "visible";

        if (index < count) {
            nextButton.style.visibility = "visible";
        } else {
            restartBtn.style.display = "block";
        }
    }
}