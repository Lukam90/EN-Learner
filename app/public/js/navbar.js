function slideNav() {
    const navbar = document.getElementsByTagName("nav")[0];

    console.log(navbar);
    console.log(navbar.className);
    
    if (navbar.className != "responsive") {
        navbar.className = "responsive";
    } else {
        navbar.className = "";
    }
}