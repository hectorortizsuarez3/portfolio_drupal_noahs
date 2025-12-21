
(function($, drupalSettings) {

  
  function isScrolledIntoView(elem) {
    var docViewBottom = $(window).scrollTop() + $(window).height();
    var elemTop = $(elem).offset().top;
    return (docViewBottom >= elemTop);
  }

  function checkElements() {
    if (drupalSettings.noahs_builder_theme && drupalSettings.noahs_builder_theme.animateOnLoad === true) {
      $('body').addClass('noahs-theme-animate-on-load');
      $('.noahs-theme-content-wrapper:not(.builder-wrapper) .noahs_page_builder-widget').each(function () {
        if (isScrolledIntoView(this)) {
          $(this).addClass('noahs-theme-animated');
        }
      });
    }else{
      
    }
  }

  $(window).on('load', function () {
    checkElements();
  });

  $(window).on('scroll', checkElements);
  $(window).on('resize', checkElements);

})(jQuery, drupalSettings);
  


 
 