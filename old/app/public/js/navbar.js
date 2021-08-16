function toggleNavbar() {
    const navbar = document.getElementById("navbar");

    if (navbar.className === "responsive") {
        navbar.className = "";
    } else {
        navbar.className = "responsive";
    }
}
