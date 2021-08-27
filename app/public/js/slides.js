let index = 1;

const slides = document.getElementsByClassName("slides");

const count = slides.length;

showSlides(index);

document.addEventListener("keydown", changeSlide);

function nextSlide(number) {
	showSlides(index += number);
}

function showSlides(number) {
    if (number > count) {index = count;}
	
    if (number < 1) {index = 1;}
	
    for (let i = 0 ; i < count ; i++) {
		slides[i].style.display = "none";
	}

	slides[index - 1].style.display = "block";
}

function changeSlide(event) {
	let code = event.keyCode;

	console.log(code);

	if (code == 37) {
		nextSlide(-1);
	}

	if (code == 39) {
		nextSlide(1);
	}
}