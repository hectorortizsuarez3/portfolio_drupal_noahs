document.addEventListener("DOMContentLoaded", function () {
  function updateHeaderHeight() {
    const header = document.querySelector(".noahs-theme--header");
    const headerEmpty = document.querySelector(".noahs-header-empty");
    const toolbar = document.querySelector("#toolbar-administration");

    if (header) {
      // Ajustar top del header si existe el toolbar de administración.
      if (toolbar) {
        const toolbarHeight = 79;
        header.style.top = `${toolbarHeight}px`;
      }

      // Ajustar el espacio vacío bajo el header.
      if (headerEmpty) {
        headerEmpty.style.height = `${header.offsetHeight}px`;
      }
    }
  }

  // Función para alternar clase al hacer scroll.
  function handleScroll() {
    const header = document.querySelector(".noahs-theme--header");
    if (!header) return;

    const scrollY = window.scrollY || window.pageYOffset;
    const scrollThreshold = 50; // píxeles para activar el sticky (ajusta a gusto)

    if (scrollY > scrollThreshold) {
      header.classList.add("is-sticky");
    } else {
      header.classList.remove("is-sticky");
    }
  }

  // Esperar hasta que el header esté disponible.
  const checkHeader = setInterval(() => {
    const header = document.querySelector(".noahs-theme--header");

    if (header) {
      clearInterval(checkHeader);

      // Ajustar tamaño y posición inicialmente.
      updateHeaderHeight();

      // Observar cambios en el tamaño del header.
      const resizeObserver = new ResizeObserver(updateHeaderHeight);
      resizeObserver.observe(header);

      // Escuchar cambios en el tamaño de la ventana.
      window.addEventListener("resize", updateHeaderHeight);

      // Añadir el listener de scroll.
      window.addEventListener("scroll", handleScroll);

      // Ejecutar una vez para estado inicial.
      handleScroll();
    }
  }, 100);
});
