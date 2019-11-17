(function($) {
    "use strict";

    if ($('.accrodion-grp').length) {
        var accrodionGrp = $('.accrodion-grp');
        accrodionGrp.each(function() {
            var accrodionName = $(this).data('grp-name');
            var Self = $(this);
            var accordion = Self.find('.accrodion');
            Self.addClass(accrodionName);
            Self.find('.accrodion .accrodion-content').hide();
            Self.find('.accrodion.active').find('.accrodion-content').show();
            accordion.each(function() {
                $(this).find('.accrodion-title').on('click', function() {
                    if ($(this).parent().hasClass('active') === false) {
                        $('.accrodion-grp.' + accrodionName).find('.accrodion').removeClass('active');
                        $('.accrodion-grp.' + accrodionName).find('.accrodion').find('.accrodion-content').slideUp();
                        $(this).parent().addClass('active');
                        $(this).parent().find('.accrodion-content').slideDown();
                    };


                });
            });
        });

    };


    if ($('.counter').length) {
        $('.counter').counterUp({
            delay: 10,
            time: 3000
        });
    };



    if ($('.img-popup').length) {
        var groups = {};
        $('.img-popup').each(function() {
            var id = parseInt($(this).attr('data-group'), 10);

            if (!groups[id]) {
                groups[id] = [];
            }

            groups[id].push(this);
        });


        $.each(groups, function() {

            $(this).magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                closeBtnInside: false,
                gallery: { enabled: true }
            });

        });

    }

    if ($('.main-navigation .navigation-box .sub-menu').length) {
        var subMenu = $('.main-navigation .sub-menu');
        subMenu.parent('li').children('a').append(function() {
            return '<button class="sub-nav-toggler"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>';
        });
        var mainNavToggler = $('.header-navigation .menu-toggler');
        var subNavToggler = $('.main-navigation .sub-nav-toggler');
        mainNavToggler.on('click', function() {
            var Self = $(this);
            var menu = Self.data('target');
            $(menu).slideToggle();
            $(menu).toggleClass('showen');
            return false;
        });
        subNavToggler.on('click', function() {
            var Self = $(this);
            Self.parent().parent().children('.sub-menu').slideToggle();
            return false;
        });
    }
    if ($('.video-popup').length) {
        $('.video-popup').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: true,

            fixedContentPos: false
        });
    }

    if ($('.scroll-to-target').length) {
        $(".scroll-to-target").on('click', function() {
            var target = $(this).attr('data-target');
            // animate
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 1000);

            return false;

        });
    }

    if ($('.brand-carousel-one').length) {
        $('.brand-carousel-one').owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            navText: [
                '<i class="fa fa-long-arrow-left"></i>',
                '<i class="fa fa-long-arrow-right"></i>'
            ],
            dots: false,
            autoWidth: false,
            autoplay: true,
            smartSpeed: 700,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 3
                },
                600: {
                    items: 3
                },
                991: {
                    items: 4
                },
                1000: {
                    items: 5
                },
                1200: {
                    items: 5
                }
            }
        });
    }


    function SmoothMenuScroll() {
        var anchor = $('.scrollToLink');
        if (anchor.length) {
            anchor.children('a').bind('click', function(event) {
                if ($(window).scrollTop() > 10) {
                    var headerH = '80';
                } else {
                    var headerH = '120';
                }
                var target = $(this);
                $('html, body').stop().animate({
                    scrollTop: $(target.attr('href')).offset().top - headerH + 'px'
                }, 1200, 'easeInOutExpo');
                anchor.removeClass('current');
                target.parent().addClass('current');
                event.preventDefault();
            });
        }
    }
    SmoothMenuScroll();

    function OnePageMenuScroll() {
        var windscroll = $(window).scrollTop();
        if (windscroll >= 100) {
            var menuAnchor = $('.one-page-scroll-menu .scrollToLink').children('a');
            menuAnchor.each(function() {
                // grabing section id dynamically
                var sections = $(this).attr('href');
                $(sections).each(function() {
                    // checking is scroll bar are in section
                    if ($(this).offset().top <= windscroll + 100) {
                        // grabing the dynamic id of section
                        var Sectionid = $(sections).attr('id');
                        // removing current class from others
                        $('.one-page-scroll-menu').find('li').removeClass('current');
                        // adding current class to related navigation
                        $('.one-page-scroll-menu').find('a[href*=\\#' + Sectionid + ']').parent().addClass('current');
                    }
                });
            });
        } else {
            $('.one-page-scroll-menu li.current').removeClass('current');
            $('.one-page-scroll-menu li:first').addClass('current');
        }
    }


    $(window).on('scroll', function() {
        if ($('.scroll-to-top').length) {
            var strickyScrollPos = 100;
            if ($(window).scrollTop() > strickyScrollPos) {
                $('.scroll-to-top').fadeIn(500);
            } else if ($(this).scrollTop() <= strickyScrollPos) {
                $('.scroll-to-top').fadeOut(500);
            }
        }
        if ($('.stricky').length) {
            var headerScrollPos = 100;
            var stricky = $('.stricky');
            if ($(window).scrollTop() > headerScrollPos) {
                stricky.removeClass('slideIn animated');
                stricky.addClass('stricky-fixed slideInDown animated');
            } else if ($(this).scrollTop() <= headerScrollPos) {
                stricky.removeClass('stricky-fixed slideInDown animated');
                stricky.addClass('slideIn animated');
            }
        }
        OnePageMenuScroll();
    });
    $(window).on('load', function() {
        if ($('.preloader').length) {
            $('.preloader').fadeOut('slow');
        }
        if ($('.testimonials-slider').length) {
            $('.testimonials-slider').bxSlider({
                // adaptiveHeight: true,
                auto: true,
                controls: true,
                nextText: '<i class="nonid-icon-left-arrow icon-revresed"></i>',
                prevText: '<i class="nonid-icon-left-arrow"></i>',
                pause: 5000,
                speed: 500,
                pager: true,
                pagerCustom: '.testimonials-slider-pager-one'
            });
        }
    });

})(jQuery);