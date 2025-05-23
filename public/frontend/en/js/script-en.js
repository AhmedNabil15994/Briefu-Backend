(function ($) {
    "use strict";
    new WOW().init();

//    $(window).scroll(function () {
//
//        if ($(window).scrollTop() >= 85) {
//            $('.header-inner').removeClass('header-home');
//        } else {
//
//            $('.header-inner').addClass('header-home');
//        }
//    });
    /*========== Add Class active To search Form  ==========*/
    $(".header-inner .nav-search .search-btn a").on("click", function (e) {
        e.preventDefault();
        $(".header-inner .search-form").toggleClass("active animated");
    });
    $(".header-inner .navbar .nav li a").on("click", function (e) {
        if ($(this).attr('href').charAt(0) === "#") {
            e.preventDefault();
        }
        $(this).next().slideToggle();
    });
    /*========== Add Class active To side menu  ==========*/
    $(".header-inner .nav-search .bar-icon a").on("click", function (e) {
        e.preventDefault();
        $(".side-menu").addClass("open");
    });

    $(".side-menu .side-menu-close").on("click", function (e) {
        e.preventDefault();
        $(".side-menu").removeClass("open");
    });

    $(".header-inner .responsive-menu").on("click", function () {
        $(".navbar").toggleClass("active");
        $(".search-form").removeClass("active");
    });
    $('.header-inner .menu-close').on('click', function () {
        $('.navbar').removeClass("active");
        return false;
    });




    $(".list-courses").owlCarousel({
        navigation: true,
        pagination: true,
        nav: false,
        dots: true,
        loop: false,
        autoplay: false,
        margin: 20,
        items: 4,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 1
            },
            992: {
                items: 2
            },
            1200: {
                items: 4
            }
        }
    });
    $(".list-events").owlCarousel({
        navigation: true,
        pagination: true,
        nav: false,
        dots: true,
        loop: false,
        autoplay: false,
        margin: 20,
        items: 3,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 1
            },
            992: {
                items: 2
            },
            1200: {
                items: 3
            }
        }
    });
    $(".list-members").owlCarousel({
        navigation: true,
        pagination: true,
        nav: false,
        dots: true,
        loop: false,
        autoplay: false,
        margin: 15,
        items: 6,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 1
            },
            992: {
                items: 2
            },
            1200: {
                items: 6
            }
        }
    });
    $(".list-testimonial").owlCarousel({
        navigation: true,
        pagination: true,
        nav: false,
        dots: true,
        loop: false,
        autoplay: false,
        items: 1,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 1
            },
            992: {
                items: 1
            },
            1200: {
                items: 1
            }
        }
    });
    $(".header-slider").owlCarousel({
        navigation: false,
        pagination: false,
        nav: false,
        dots: false,
        loop: true,
        margin: 0,
        items: 1,
        autoplay: 3000,
        autoplayTimeout: 3000,
        smartSpeed: 1000,
        animateOut: 'fadeOut',
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            768: {
                items: 1
            },
            992: {
                items: 1
            },
            1200: {
                items: 1
            }
        }
    });
    $('[data-rel^=lightcase]').lightcase({
        maxWidth: 1100,
        maxHeight: 800
    });
    $('.select2').select2();
    //    Remove promo code
    $('.promo-code .remove').click(function () {
        $('.promo-code').addClass("hide");
    });
    $('.date').dateDropper();
    $('.sidebar-box .media').on('click', function (e) {
        $(this).toggleClass("active");
        $(".sidebar-box ul").slideToggle();
    });
    $('.res-blog-side').on('click', function () {
        $('.blog-side-container').toggleClass("active");
//        event.stopPropagation();
    });
    $('.blog-side-container .close-side').on('click', function () {
        $('.blog-side-container').removeClass("active");
    });
})(jQuery); // End of use strict
