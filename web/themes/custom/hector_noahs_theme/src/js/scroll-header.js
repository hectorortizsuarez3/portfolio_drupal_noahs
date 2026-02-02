//Añado la clase is-scrolled cuando se scrolea hacia abajo en inicio

(function () {
  window.addEventListener("scroll", function() {
    if (window.scrollY > 0) {
        document.body.classList.add("is-scrolled");
    } else {
        document.body.classList.remove("is-scrolled");
    }
  });
})();
