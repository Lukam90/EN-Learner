let index = 1;

const slides = document.getElementsByClassName("slides");

const count = slides.length;

showSlides(index);

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