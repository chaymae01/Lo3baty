(function ($) {
    "use strict";

    // Initialize WOW.js
    new WOW({ offset: 50 }).init();

    // Spinner
    $(window).on('load', function() {
        $('#spinner').fadeOut(500);
    });

    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').addClass('shadow-sm').css('top', '0px');
        } else {
            $('.sticky-top').removeClass('shadow-sm').css('top', '-100px');
        }
    });
    
    // Back to top
    $(window).scroll(function () {
        $('.back-to-top')[$(this).scrollTop() > 300 ? 'fadeIn' : 'fadeOut']('slow');
    }).trigger('scroll');
    
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1000);
        return false;
    });

    // Carousels
    $(".header-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: true,
        loop: true,
        nav: true,
        navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>']
    });

    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 24,
        dots: false,
        loop: true,
        nav: true,
        responsive: {
            0: { items: 1 },
            992: { items: 2 }
        },
        navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>']
    });

})(jQuery);