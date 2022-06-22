/*==================== SHOW MENU ====================*/
const showMenu = (toggleId, navId) => {
  const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId);

  // Validate that variables exist
  if (toggle && nav) {
    toggle.addEventListener("click", () => {
      // We add the show-menu class to the div tag with the nav__menu class
      nav.classList.toggle("show-menu");
    });
  }
};
showMenu("nav-toggle", "nav-menu");

/*==================== REMOVE MENU MOBILE ====================*/
const navLink = document.querySelectorAll(".nav__link");

function linkAction() {
  const navMenu = document.getElementById("nav-menu");
  // When we click on each nav__link, we remove the show-menu class
  navMenu.classList.remove("show-menu");
}
navLink.forEach((n) => n.addEventListener("click", linkAction));

/*==================== SCROLL SECTIONS ACTIVE LINK ====================*/
// const sections = document.getElementById("section[id]");

// function scrollActive() {
//   const scrollY = window.pageYOffset;

//   sections.forEach((current) => {
//     const sectionHeight = current.offsetHeight;
//     const sectionTop = current.offsetTop - 50;
//     sectionId = current.getAttribute("id");

//     if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
//       document
//         .querySelector(".nav__menu a[href*=" + sectionId + "]")
//         .classList.add("active-link");
//     } else {
//       document
//         .querySelector(".nav__menu a[href*=" + sectionId + "]")
//         .classList.remove("active-link");
//     }
//   });
// }
// window.addEventListener("scroll", scrollActive);

/*==================== CHANGE BACKGROUND HEADER ====================*/
function scrollHeader() {
  const header = document.getElementById("header");
  // When the scroll is greater than 80 viewport height, add the scroll-header class to the header tag
  if (this.scrollY >= 80) header.classList.add("scroll-header");
  else header.classList.remove("scroll-header");
}
window.addEventListener("scroll", scrollHeader);

/*==================== SHOW SCROLL TOP ====================*/
function scrollTop() {
  const scrollTop = document.getElementById("scroll-top");
  // When the scroll is higher than 560 viewport height, add the show-scroll class to the a tag with the scroll-top class
  if (this.scrollY >= 560) scrollTop.classList.add("show-scroll");
  else scrollTop.classList.remove("show-scroll");
}
window.addEventListener("scroll", scrollTop);

/*==================== DARK LIGHT THEME ====================*/
// const themeButton = document.getElementById("theme-button");
// const darkTheme = "dark-theme";
// const iconTheme = "bx-toggle-right";

// // Previously selected topic (if user selected)
// const selectedTheme = localStorage.getItem("selected-theme");
// const selectedIcon = localStorage.getItem("selected-icon");

// // We obtain the current theme that the interface has by validating the dark-theme class
// const getCurrentTheme = () =>
//   document.body.classList.contains(darkTheme) ? "dark" : "light";
// const getCurrentIcon = () =>
//   themeButton.classList.contains(iconTheme)
//     ? "bx-toggle-left"
//     : "bx-toggle-right";

// // We validate if the user previously chose a topic
// if (selectedTheme) {
//   // If the validation is fulfilled, we ask what the issue was to know if we activated or deactivated the dark
//   document.body.classList[selectedTheme === "dark" ? "add" : "remove"](
//     darkTheme
//   );
//   themeButton.classList[selectedIcon === "bx-toggle-left" ? "add" : "remove"](
//     iconTheme
//   );
// }

// // Activate / deactivate the theme manually with the button
// themeButton.addEventListener("click", () => {
//   // Add or remove the dark / icon theme
//   document.body.classList.toggle(darkTheme);
//   themeButton.classList.toggle(iconTheme);
//   // We save the theme and the current icon that the user chose
//   localStorage.setItem("selected-theme", getCurrentTheme());
//   localStorage.setItem("selected-icon", getCurrentIcon());
// });

/*==================== SCROLL REVEAL ANIMATION ====================*/
// const sr = ScrollReveal({
//   distance: "30px",
//   duration: 1800,
//   reset: true,
// });

// sr.reveal(
//   `.home__data, .home__img,
//            .learn__data,
//            .accessory__content,
//            .footer__content`,
//   {
//     origin: "top",
//     interval: 200,
//   }
// );

// sr.reveal(`.advice__img, .send__content`, {
//   origin: "left",
// });

// sr.reveal(`.advice__data, .send__img`, {
//   origin: "right",
// });

/*==================== ACCORDION ====================*/
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function () {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}

/*==================== MODAL ====================*/
const openEls = document.querySelectorAll("[data-open]");
const closeEls = document.querySelectorAll("[data-close]");
const isVisible = "is-visible";

for (const el of openEls) {
  el.addEventListener("click", function () {
    const modalId = this.dataset.open;
    document.getElementById(modalId).classList.add(isVisible);
  });
}

for (const el of closeEls) {
  el.addEventListener("click", function () {
    this.parentElement.parentElement.parentElement.classList.remove(isVisible);
  });
}

// document.addEventListener("click", (e) => {
//   if (e.target == document.querySelector(".modal.is-visible")) {
//     document.querySelector(".modal.is-visible").classList.remove(isVisible);
//   }
// });

document.addEventListener("keyup", (e) => {
  // if we press the ESC
  if (e.key == "Escape" && document.querySelector(".modal.is-visible")) {
    document.querySelector(".modal.is-visible").classList.remove(isVisible);
  }
});

/*==================== reCAPTCHA ====================*/
function onSubmit(token) {
  document.getElementById("vragenForm").submit();
  document.getElementById("vragenForm").reset();
  document.getElementById("valBut").innerHTML =
    '<i class="fad fa-spinner-third loader" id="valLoad"></i> Genereren...';
  document.getElementById("valBut").classList.add("disabled");
  setTimeout(function () {
    '<i class="fad fa-download"></i> Downloaden (10)';
    var timeleft = 9;
    var downloadTimer = setInterval(function () {
      if (timeleft <= 0) {
        clearInterval(downloadTimer);
      }
      document.getElementById("valBut").innerHTML =
        '<i class="fad fa-download"></i> Downloaden... (' + timeleft + ")";
      timeleft--;
    }, 1000);
    setTimeout(function () {
      document.querySelector(".modal.is-visible").classList.remove(isVisible);
      setTimeout(function () {
        resetForm();
      }, 500);
    }, 10000);
  }, 5000);
}

function resetForm() {
  document.getElementById("vragenForm").reset();
  document.getElementById("valBut").innerText = "Controleren";
  document.getElementById("valBut").classList.remove("disabled");
}

/*==================== SLIDER ====================*/
function setValue(value, id) {
  document.getElementById(id).innerText = value;
}

/*==================== TOAST ====================*/
// let x;
// let toast = document.getElementById("toast");
// function showToast() {
//   clearTimeout(x);
//   toast.style.transform = "translateX(0)";
//   x = setTimeout(() => {
//     toast.style.transform = "translateX(400px)";
//   }, 4000);
// }
// function closeToast() {
//   toast.style.transform = "translateX(400px)";
// }

/*=============== ACCORDION ===============*/
const accordionItems = document.querySelectorAll(".accordion__item");

// 1. Selecionar cada item
accordionItems.forEach((item) => {
  const accordionHeader = item.querySelector(".accordion__header");

  // 2. Seleccionar cada click del header
  accordionHeader.addEventListener("click", () => {
    // 7. Crear la variable
    const openItem = document.querySelector(".accordion-open");

    // 5. Llamar a la funcion toggle item
    toggleItem(item);

    // 8. Validar si existe la clase
    if (openItem && openItem !== item) {
      toggleItem(openItem);
    }
  });
});

// 3. Crear una funcion tipo constante
const toggleItem = (item) => {
  // 3.1 Crear la variable
  const accordionContent = item.querySelector(".accordion__content");

  // 6. Si existe otro elemento que contenga la clase accorion-open que remueva su clase
  if (item.classList.contains("accordion-open")) {
    accordionContent.removeAttribute("style");
    item.classList.remove("accordion-open");
  } else {
    // 4. Agregar el height maximo del content
    accordionContent.style.height = accordionContent.scrollHeight + "px";
    item.classList.add("accordion-open");
  }
};

/*=============== HIDE URL TAB BRONNEN ===============*/
function hideURL(type, url) {
  if (document.getElementById(type).value == "url") {
    document.getElementById(url).hidden = false;
    document.getElementById(url).required = true;
  } else {
    document.getElementById(url).hidden = true;
    document.getElementById(url).required = false;
  }
}

/*==================== EASTER EGGS ====================*/
