// header
const registrBtn = document.querySelector(".header__button_reg");
const authBtn = document.querySelector(".header__button_auth");

authBtn.addEventListener("click", showAuthDialog);
registrBtn.addEventListener("click", showRegistrDialog);

function showAuthDialog() {
  const authDialog = document.querySelector(".dialog_auth");
  const closeBtn = document.querySelector(
    ".form_auth .form__button_type_close"
  );
  const authCheckbox = document.querySelector(
    ".form_auth .form__input_type_checkbox"
  );
  const authPassInput = document.querySelector(
    ".form_auth .form__input_type_password"
  );

  authDialog.showModal();
  closeBtn.addEventListener("click", closeAuthDialog);
  authCheckbox.addEventListener("click", showPassword);

  function closeAuthDialog() {
    authDialog.close();
    closeBtn.removeEventListener("click", closeAuthDialog);
    authCheckbox.removeEventListener("click", showPassword);
  }

  function showPassword() {
    if (authCheckbox.checked === true) {
      authPassInput.type = "text";
    } else {
      authPassInput.type = "password";
    }
  }
}

function showRegistrDialog() {
  const registrDialog = document.querySelector(".dialog_registr");
  const registrForm = document.querySelector(".form_registr");
  const inputLogin = document.querySelector(
    ".form_registr .form__input_type_login"
  );
  const inputPassword = document.querySelector(
    ".form_registr .form__input_type_password"
  );
  const inputRepeatPassword = document.querySelector(
    ".form_registr .form__input_type_password-repeat"
  );
  const inputDate = document.querySelector(
    ".form_registr .form__input_type_date"
  );
  const closeBtn = document.querySelector(
    ".form_registr .form__button_type_close"
  );
  const registrCheckbox = document.querySelector(
    ".form_registr .form__input_type_checkbox"
  );
  const registrPassInput = document.querySelector(
    ".form_registr .form__input_type_password"
  );

  registrDialog.showModal();
  closeBtn.addEventListener("click", closeRegistrDialog);
  registrCheckbox.addEventListener("click", showPassword);
  registrForm.addEventListener("submit", verifyForm);

  function closeRegistrDialog() {
    registrDialog.close();
    closeBtn.removeEventListener("click", closeRegistrDialog);
    registrCheckbox.removeEventListener("click", showPassword);
    registrForm.removeEventListener("submit", verifyForm);
  }

  function showPassword() {
    if (registrCheckbox.checked === true) {
      registrPassInput.type = "text";
    } else {
      registrPassInput.type = "password";
    }
  }

  function verifyLoginPassword(login, password, repeatPassword) {
    if (login.length < 6) {
      return "1";
    } else if (login[login.length - 1] === "_") {
      return "2";
    } else if (/[^a-z]/i.test(login[0])) {
      return "3";
    } else if (/[\W]/i.test(login)) {
      return "4";
    } else if (password.length < 6) {
      return "5";
    } else if (password.length > 8) {
      return "6";
    } else if (/[^a-z]/i.test(password[0])) {
      return "7";
    } else if (/[^a-z0-9@*]/i.test(password)) {
      return "8";
    } else if (password !== repeatPassword) {
      return "9";
    }
    return "0";
  }

  function verifyForm(event) {
    let errors = [
      "",
      "Логин менее 6 символов",
      "Логин заканчивается _",
      "Логин начинается не с буквы",
      "Логин содержит недопустимые символы",
      "Пароль менее 6 символов",
      "Пароль более 8 символов",
      "Пароль начинается не с буквы",
      "Пароль содержит недопустимые символы",
      "Пароли не совпадают",
    ];
    let errorCode = verifyLoginPassword(
      inputLogin.value,
      inputPassword.value,
      inputRepeatPassword.value
    );
    if (errorCode !== "0") {
      event.preventDefault();
      divError(errors[errorCode]);
    }

    function divError(error) {
      let div = document.createElement("div");
      div.className = "error";
      div.innerHTML = `<span>${error}</span>`;
      registrForm.append(div);
      setTimeout(() => div.remove(), 2000);
    }
  }
}
// /header

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
