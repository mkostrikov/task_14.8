// slideshow
let switchs = document.querySelectorAll(".slideshow__switch");
let dots = document.querySelectorAll(".dot");
let slideIndex = 1;
showSlide(slideIndex);

switchs.forEach((s) => s.addEventListener("click", switchSlide));
dots.forEach((d) => d.addEventListener("click", currentSlide));

function showSlide(n) {
  let slides = document.querySelectorAll(".slideshow__slide");
  if (n > slides.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slides.length;
  }
  slides.forEach((s) => s.classList.add("hidden"));
  dots.forEach((d) => d.classList.remove("current"));
  slides[slideIndex - 1].classList.remove("hidden");
  dots[slideIndex - 1].classList.add("current");
}

function switchSlide(e) {
  if (e.currentTarget.classList.contains("slideshow__switch_prev")) {
    slideIndex -= 1;
  } else {
    slideIndex += 1;
  }
  showSlide(slideIndex);
}

function currentSlide(e) {
  slideIndex = Number(e.currentTarget.id) + 1;
  showSlide(slideIndex);
}
// /slideshow

// menu
const tablinks = document.querySelectorAll(".menu__tablink");
const tabcontents = document.querySelectorAll(".services-list__item");

tablinks.forEach((link) => link.addEventListener("click", showTabContent));

function showTabContent(event) {
  tablinks.forEach((c) => {
    c.classList.remove("current");
  });
  tabcontents.forEach((c) => {
    c.classList.remove("active");
    c.classList.add("hidden");
  });
  tabcontents[event.currentTarget.id].classList.remove("hidden");
  tabcontents[event.currentTarget.id].classList.add("active");
  event.currentTarget.classList.add("current");
}

document.addEventListener("DOMContentLoaded", function () {
  tabcontents[0].classList.remove("hidden");
  tabcontents[0].classList.add("active");
  tablinks[0].classList.add("current");
});
// /menu
