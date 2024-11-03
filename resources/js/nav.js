window.onscroll = function () {
    fixNav();
};

var navbar = document.getElementById("navbar");
var mainWrapper = document.getElementById("mainWrapper");
var sticky = navbar.offsetTop;

function fixNav() {
    if (window.pageYOffset >= sticky) {
        navbar.classList.add("navbar-expand-md-fixed");
        mainWrapper.classList.add("mainWrapper-rem");
    } else {
        navbar.classList.remove("navbar-expand-md-fixed");
        mainWrapper.classList.remove("mainWrapper-rem");
    }
}
