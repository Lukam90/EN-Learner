function showAnswer(index) {
    let answer = document.querySelector(`#card${index} > .answers`);
    let closeBtn = document.querySelector(`#card${index} > .close`);

    if (answer.style.display != "block") {
        answer.style.display = "block";
        closeBtn.style.display = "block";
        closeBtn.style.position = "relative";
    }
}

function closeCard(event) {
    event.parentElement.style.display = "none";
}