(function (Drupal, once) {
  'use strict';

  /**
   * Behavior: Image Comparer
   * Inicializa la interacción (drag + click) del comparador.
   * Usa "once" para evitar re-inicializaciones en contenidos dinámicos (AJAX/Builder).
   */
  Drupal.behaviors.miswidgetsImageComparer = {
    attach(context) {
      const comparers = once(
        'miswidgets-image-comparer',
        '.miswidgets-image-comparer',
        context
      );

      //Este bloque se ejecuta una vez para cada comparador de imágenes en la página
      comparers.forEach((comparer) => {
        const divider = comparer.querySelector('.miswidgets-image-comparer__divider'); //divider guarda el nodo DOM del divider arrastrable
        let isDragging = false;  //está arrastrando? Se inicializa en false

        // Clamp genérico para mantener el porcentaje en [0, 100]
        function clamp(v, min, max) {
          return Math.min(Math.max(v, min), max);
        }

        /*Actualiza la variable css que decide la posición del divider*/
        function update(percent) {
          const safe = clamp(percent, 0, 100);
          comparer.style.setProperty('--miswidgets-compare-position', `${safe}%`);
        }

        // Convierte la posición del ratón dentro del widget en un porcentaje (0-100)
        function getPercent(x) {
          const rect = comparer.getBoundingClientRect();
          return ((x - rect.left) / rect.width) * 100;
        }

        // Estado inicial centrado
        update(50);

        // Inicio de drag solo desde el divider
        divider.addEventListener('mousedown', () => {
          isDragging = true;
        });

        // Movimiento global para no perder el drag si el cursor sale del elemento
        window.addEventListener('mousemove', (e) => {
          if (!isDragging) return;
          update(getPercent(e.clientX));
        });

        // Fin de drag
        window.addEventListener('mouseup', () => {
          isDragging = false;
        });

        /*Click para reposicionar directamente. Ignora clicks en el divisor.*/
        comparer.addEventListener('click', (e) => {
          if (!e.target.closest('.miswidgets-image-comparer__divider')) {
            update(getPercent(e.clientX));
          }
        });
      });
    },
  };
})(Drupal, once);