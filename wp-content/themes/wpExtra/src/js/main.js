(function($) {

	$(function() {
   
	});

	$(window).load(function() {

    var $_adminBar        = $('#wpadminbar'),
        $_body            = $('body'),
        $_wrapper         = $('#wrapper'),
        $_window          = $(this),
        isHomePage        = $_body.hasClass('home'),
        bodyInitTop       = ( $_adminBar.length > 0 ) ? $_adminBar.outerHeight() : 0,
        currentScrollTop  = 0;

    function init() {
      disableClick();
      contactFormHook();
    }
    init();

    function isIe() {
      var pattern = /Trident\/[0-9]+\.[0-9]+/;

      return pattern.test(navigator.userAgent);
    }

    function isEdge() {
      var pattern = /Edge\/[0-9]+\.[0-9]+/;

      return pattern.test(navigator.userAgent);
    }

    function disableClick() {
      $('.noclick').on('click', function() {
        return false;
      });
    }

    function contactFormHook() {
      if ( $('.wpcf7').length < 1 ) return false;

      var wpcf7Elm = document.querySelector( '.wpcf7' );

      wpcf7Elm.addEventListener( 'wpcf7invalid', function( event ) {
        $('.wpcf7 .wpcf7-not-valid').eq(0).focus();
      }, false );
    }

    function scrollToPosition(pos, second) {
      $('html, body').animate({
        scrollTop: pos
      }, second * 1000);
    }

    $(window).resize(function() {

      // Resize

    });

	});

})(jQuery);