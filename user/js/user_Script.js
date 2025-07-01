/*==============================
  NAVBAR SCRIPT
==============================*/
// Get the hamburger icon and navbar
const navbarHamburger = document.getElementById('navbar-hamburger');
const navbar = document.querySelector('.navbar');

// Toggle the active class on navbar when hamburger is clicked
navbarHamburger.addEventListener('click', () => {
  navbar.classList.toggle('active');
});

/*==============================
  LOGIN/REGISTER POPUP OVERLAY SCRIPT
==============================*/
function openLoginPopup() {
  document.getElementById("login-popup").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}

function closeLoginPopup() {
  document.getElementById("login-popup").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

function openRegPopup() {
  document.getElementById("reg-popup").style.display = "block";
  document.getElementById("overlay").style.display = "block";
}

function closeRegPopup() {
  document.getElementById("reg-popup").style.display = "none";
  document.getElementById("login-popup").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

/*forget password*/
const popup = document.querySelector('.forget-password-popup');
const overlay = document.querySelector('.forget-password-overlay');
const closeBtn = document.querySelector('.forget-password-popup .close-btn');

function showForgetPasswordPopup() {
    popup.style.display = 'block';
    overlay.style.display = 'block';
}

function hideForgetPasswordPopup() {
    popup.style.display = 'none';
    overlay.style.display = 'none';
}

closeBtn.addEventListener('click', hideForgetPasswordPopup);
overlay.addEventListener('click', hideForgetPasswordPopup);

const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i");

menuBtn.addEventListener("click", (e) => {
  navLinks.classList.toggle("open");

  const isOpen = navLinks.classList.contains("open");
  menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
});

navLinks.addEventListener("click", (e) => {
  navLinks.classList.remove("open");
  menuBtnIcon.setAttribute("class", "ri-menu-line");
});

const scrollRevealOption = {
  origin: "bottom",
  distance: "50px",
  duration: 1000,
};

ScrollReveal().reveal(".header__image img", {
  ...scrollRevealOption,
  origin: "right",
});
ScrollReveal().reveal(".header__content p", {
  ...scrollRevealOption,
  delay: 500,
});
ScrollReveal().reveal(".header__content h1", {
  ...scrollRevealOption,
  delay: 1000,
});
ScrollReveal().reveal(".header__btns", {
  ...scrollRevealOption,
  delay: 1500,
});

ScrollReveal().reveal(".destination__card", {
  ...scrollRevealOption,
  interval: 500,
});

ScrollReveal().reveal(".showcase__image img", {
  ...scrollRevealOption,
  origin: "left",
});
ScrollReveal().reveal(".showcase__content h4", {
  ...scrollRevealOption,
  delay: 500,
});
ScrollReveal().reveal(".showcase__content p", {
  ...scrollRevealOption,
  delay: 1000,
});
ScrollReveal().reveal(".showcase__btn", {
  ...scrollRevealOption,
  delay: 1500,
});

ScrollReveal().reveal(".banner__card", {
  ...scrollRevealOption,
  interval: 500,
});

ScrollReveal().reveal(".discover__card", {
  ...scrollRevealOption,
  interval: 500,
});

const swiper = new Swiper(".swiper", {
  slidesPerView: 3,
  spaceBetween: 20,
  loop: true,
});
