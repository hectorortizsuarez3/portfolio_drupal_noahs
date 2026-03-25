(function (Drupal, once) {
  'use strict';

  Drupal.behaviors.miswidgetsImageComparer = {
    attach(context) {
      const comparers = once(
        'miswidgets-image-comparer',
        '.miswidgets-image-comparer',
        context
      );

      comparers.forEach((comparer) => {
        const divider = comparer.querySelector('.miswidgets-image-comparer__divider');

        let isDragging = false;

        let startPosition = parseFloat(comparer.dataset.startPosition) || 50;

        function clamp(v, min, max) {
          return Math.min(Math.max(v, min), max);
        }

        function update(percent) {
          const safe = clamp(percent, 0, 100);
          comparer.style.setProperty('--miswidgets-compare-position', `${safe}%`);
        }

        function getPercent(x) {
          const rect = comparer.getBoundingClientRect();
          return ((x - rect.left) / rect.width) * 100;
        }

        update(startPosition);

        divider.addEventListener('mousedown', () => {
          isDragging = true;
        });

        window.addEventListener('mousemove', (e) => {
          if (!isDragging) return;
          update(getPercent(e.clientX));
        });

        window.addEventListener('mouseup', () => {
          isDragging = false;
        });

        comparer.addEventListener('click', (e) => {
          if (!e.target.closest('.miswidgets-image-comparer__divider')) {
            update(getPercent(e.clientX));
          }
        });
      });
    },
  };
})(Drupal, once);