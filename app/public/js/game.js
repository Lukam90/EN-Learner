function flipCard(index) {
    const card = document.getElementById(`card${index}`);

    const question = document.querySelector(`#card${index} > .question`);
    const answers = document.querySelector(`#card${index} > .answers`);

    if (answers.style.visibility != "visible") {
        answers.style.visibility = "visible";
        /*question.style.visibility = "hidden";
    } else {
        answers.style.visibility = "hidden";
        question.style.visibility = "visible";*/
    }
}

function closeCard(index) {
    const card = document.getElementById(`card${index}`);

    card.style.display = "none";
}