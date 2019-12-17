//Global var
var RP = {};
(function ($) {
    // USE STRICT
    "use strict";
    //----------------------------------------------------/
    // Predefined Variables
    //----------------------------------------------------/
    var $window = $(window),
        $document = $(document),
        $body = $('body'),
        $wrapper = $('.wrapper'),
        $topbar = $('#topbar'),
        $header = $('#header'),

        //Logo
        logo = $('#logo').find('.logo'),
        logoImg = logo.find('img').attr('src'),
        logoDark = logo.attr('data-dark-logo'),

        //Main menu
        mainmenuitems = $("#mainMenu > ul > li"),
        mainmenu = $('#mainMenu'),
        mainmenuitems = mainmenu.find('li.dropdown > a'),
        mainsubmenuitems = mainmenu.find('li.dropdown-submenu > a, li.dropdown-submenu > span'),

        //Vertical Dot Menu
        navigationItems = $('#vertical-dot-menu a'),

        //Side panel
        sidePanel = $('#side-panel'),
        sidePanellogo = $('#panel-logo').find('.logo'),
        sidePanellogoImg = sidePanellogo.find('img').attr('src'),
        sidePanellogoDark = sidePanellogo.attr('data-dark-logo'),

        //Fullscreen panel
        fullScreenPanel = $('#fullscreen-panel'),

        $topSearch = $('#top-search'),
        $parallax = $('.parallax'),
        $textRotator = $('.text-rotator'),

        //Window size control
        $fullScreen = $('.fullscreen') || $('.section-fullscreen'),
        $halfScreen = $('.halfscreen'),

        //Elements
        dataAnimation = $("[data-animation]"),
        $counter = $('.counter:not(.counter-instant)'),
        $countdownTimer = $('.countdown'),
        //$progressBar = $('.progress-bar'),
        $pieChart = $('.pie-chart'),
        $map = $('.map'),
        accordionType = "accordion",
        toogleType = "toggle",
        accordionItem = "ac-item",
        itemActive = "ac-active",
        itemTitle = "ac-title",
        itemContent = "ac-content",

        $lightbox_gallery = $('[data-lightbox-type="gallery"]'),
        $lightbox_image = $('[data-lightbox-type="image"]'),
        $lightbox_iframe = $('[data-lightbox-type="iframe"]'),
        $lightbox_ajax = $('[data-lightbox-type="ajax"]'),

        //Widgets
        $flickr_widget = $('.flickr-widget'),

        $ytPlayer = $('.youtube-background'),

        //Utilites
        classFinder = ".";

    //----------------------------------------------------/
    // UTILITIES
    //----------------------------------------------------/

    //Check if function exists
    $.fn.exists = function () {
        return this.length > 0;
    };

    //----------------------------------------------------/
    // MOBILE CHECK
    //----------------------------------------------------/
    var isMobile = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function () {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function () {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    //----------------------------------------------------/
    // RESPONSIVE CLASSES
    //----------------------------------------------------/
    RP.responsiveClasses = function () {

        var jRes = jRespond([
            {
                label: 'smallest',
                enter: 0,
                exit: 479
                }, {
                label: 'handheld',
                enter: 480,
                exit: 767
                }, {
                label: 'tablet',
                enter: 768,
                exit: 991
                }, {
                label: 'laptop',
                enter: 992,
                exit: 1199
                }, {
                label: 'desktop',
                enter: 1200,
                exit: 10000
                }
            ]);
        jRes.addFunc([
            {
                breakpoint: 'desktop',
                enter: function () {
                    $body.addClass('device-lg');
                },
                exit: function () {
                    $body.removeClass('device-lg');
                }
                }, {
                breakpoint: 'laptop',
                enter: function () {
                    $body.addClass('device-md');
                },
                exit: function () {
                    $body.removeClass('device-md');
                }
                }, {
                breakpoint: 'tablet',
                enter: function () {
                    $body.addClass('device-sm');
                },
                exit: function () {
                    $body.removeClass('device-sm');
                }
                }, {
                breakpoint: 'handheld',
                enter: function () {
                    $body.addClass('device-xs');
                },
                exit: function () {
                    $body.removeClass('device-xs');
                }
                }, {
                breakpoint: 'smallest',
                enter: function () {
                    $body.addClass('device-xxs');
                },
                exit: function () {
                    $body.removeClass('device-xxs');
                }
                }
        ]);
    };

    //----------------------------------------------------/
    // CAROUSEL SLIDER
    //----------------------------------------------------/
    RP.carouselRP = function () {
        var $sliderCarousel = $('.carousel') || $('.owl-carousel'),
            $postCarousel = $(".post-mini-slider");
        if ($sliderCarousel.exists()) {
            $sliderCarousel.each(function () {
                var element = $(this),
                    sliderCarouselColumns = element.attr('data-carousel-col') || "4",
                    sliderCarouselColumnsMedium = element.attr('data-carousel-col-md') || "4",
                    sliderCarouselColumnsSmall = element.attr('data-carousel-col-sm') || "3",
                    sliderCarouselColumnsExtraSmall = element.attr('data-carousel-col-xs') || "1",
                    $sliderCarouselMargins = element.attr('data-carousel-margins') || "20",
                    $sliderCarouseDots = element.attr('data-carousel-dots') || false,
                    $sliderCarouseNav = false,
                    $sliderCarouseAutoPlay = element.attr('data-carousel-autoplay') || false,
                    $sliderCarouseVideo = element.attr('data-carousel-video') || false;
                if ($sliderCarouseDots === false) {
                    $sliderCarouseNav = true;
                } else {
                    $sliderCarouseDots = true;
                }
                if (sliderCarouselColumns == 1) {
                    element.owlCarousel({
                        margin: Number($sliderCarouselMargins),
                        nav: $sliderCarouseNav,
                        navText: ['<i class="fa fa-arrow-left icon-white"></i>',
                              '<i class="fa fa-arrow-right icon-white"></i>'],
                        autoplay: $sliderCarouseAutoPlay,
                        autoplayHoverPause: true,
                        dots: $sliderCarouseDots,
                        items: 1,
                        autoHeight: false,
                        video: $sliderCarouseVideo,
                    });
                } else {
                    element.owlCarousel({
                        margin: Number($sliderCarouselMargins),
                        nav: $sliderCarouseNav,
                        navText: ['<i class="fa fa-arrow-left icon-white"></i>',
                              '<i class="fa fa-arrow-right icon-white"></i>'],
                        autoplay: $sliderCarouseAutoPlay,
                        autoplayHoverPause: true,
                        dots: $sliderCarouseDots,
                        video: $sliderCarouseVideo,
                        responsive: {
                            0: {
                                items: sliderCarouselColumnsExtraSmall
                            },
                            600: {
                                items: sliderCarouselColumnsSmall
                            },
                            1000: {
                                items: sliderCarouselColumnsMedium
                            },
                            1200: {
                                items: sliderCarouselColumns
                            }
                        }
                    });
                }
            });
        }
        if ($postCarousel.exists()) {
            $postCarousel.each(function () {
                $postCarousel.owlCarousel({
                    autoplay: true,
                    autoplayHoverPause: true,
                    dots: true,
                    mouseDrag: false,
                    touchDrag: false,
                    items: 1,
                });

            });
        }
        if ($("#slider-carousel").exists()) {
            $("#slider-carousel").each(function () {
                $("#slider-carousel").owlCarousel({
                    margin: 0,
                    loop: true,
                    nav: true,
                    navText: ['<i class="fa fa-arrow-left icon-white"></i>',
                              '<i class="fa fa-arrow-right icon-white"></i>'],
                    autoplay: true,
                    dots: false,
                    autoplayHoverPause: true,
                    navigation: true,
                    items: 1,
                    animateOut: 'fadeOut'
                });
                var owl = $("#slider-carousel");
                $('.owl-item.active .slider-content').addClass("animated fadeIn");
                owl.on('changed.owl.carousel', function (event) {
                    $('.owl-item:not(.active)').siblings().find(".slider-content").removeClass("animated fadeIn");
                    setTimeout(function () {
                        $('.owl-item.active .slider-content').addClass("animated fadeIn");
                    }, 300);
                    //stop embed videos if they exists
                    if ($("#slider-carousel .owl-item.active .slider-content iframe").length) {
                        var url = $("#slider-carousel .owl-item.active .slider-content iframe").attr("src");
                        $('iframe').attr('src', '');
                        $('iframe').attr('src', url);

                    }
                });
            });
        }
        // News ticker
        if ($('.news-ticker-content').exists()) {
            $('.news-ticker-content').each(function () {
                $('.news-ticker-content').owlCarousel({
                    autoplay: true,
                    autoplayHoverPause: true,
                    dots: false,
                    mouseDrag: true,
                    touchDrag: true,
                    margin: 40,
                    autoWidth: true,
                    autoplayTimeout: "3000",
                    loop: true,
                });

            });
        }
        if ($('.tab-carousel').exists()) {
            if ($('.tab-carousel').parent().hasClass('active')) {
                $('.tab-carousel').owlCarousel({
                    navText: ['<i class="fa fa-arrow-left icon-white"></i>',
                              '<i class="fa fa-arrow-right icon-white"></i>'],
                    margin: 0,
                    nav: true,
                    dots: false,
                    items: 1
                });
            } else {
                $('.tabs-navigation li a').click(function () {
                    $('.tab-carousel').owlCarousel({
                        navText: ['<i class="fa fa-arrow-left icon-white"></i>',
                              '<i class="fa fa-arrow-right icon-white"></i>'],
                        margin: 0,
                        nav: true,
                        dots: false,
                        items: 1
                    });
                });
            }
        }
    };

    //----------------------------------------------------/
    // SMOTH SCROLL NAVIGATION
    //----------------------------------------------------/
    RP.naTo = function () {
        $('a.scroll-to, a.nav-to').on('click', function () {
            var $anchor = $(this);

            $('html, body').stop(true, false).animate({
                scrollTop: $($anchor.attr('href')).offset().top
            }, 1500, 'easeInOutExpo');
            return false;
        });
    };

    //----------------------------------------------------/
    // GO TO TOP
    //----------------------------------------------------/
    RP.goToTop = function () {
        var $goToTop = $('.gototop'),
            scrollOffsetFromTop = 800;
        if ($window.scrollTop() > scrollOffsetFromTop) {
            $goToTop.fadeIn("slow");
        } else {
            $goToTop.fadeOut("slow");
        }
        $goToTop.on("click", function () {
            $('body,html').stop(true).animate({
                scrollTop: 0
            }, 1500, 'easeInOutExpo');
            return false;
        });
    };

    //----------------------------------------------------/
    // LOGO STATUS
    //----------------------------------------------------/
    RP.logoStatus = function () {
        if ($header.hasClass('header-navigation-light') && $window.width() < 991) {
            logo.find('img').attr('src', logoImg);
        } else {
            if ($header.hasClass('header-dark')) {
                if (logoDark) {
                    logo.find('img').attr('src', logoDark);
                } else {
                    logo.find('img').attr('src', logoImg);
                }

            } else {
                logo.find('img').attr('src', logoImg);
            }
        }
    };

    //----------------------------------------------------/
    // STICKY HEADER
    //----------------------------------------------------/
    RP.stickyHeaderStatus = function () {
        if ($header.exists()) {
            var headerOffset = $header.offset().top;
            if ($window.scrollTop() > headerOffset) {
                
                    if (!$header.hasClass("header-no-sticky")) {
                        $header.addClass('header-sticky');
                    }
                    if ($header.hasClass('header-navigation-light')) {
                        logo.find('img').attr('src', logoImg);
                    }
                
            } else {
                $header.removeClass('header-sticky');
            }
        }
    };

    RP.stickyHeader = function () {
        $window.on('scroll', function () {
            RP.logoStatus();
            RP.stickyHeaderStatus();
        });
    };

    //----------------------------------------------------/
    // SCREEN SIZE CONTROL
    //----------------------------------------------------/
    RP.screenSizeControl = function () {
        if ($fullScreen.exists()) {
            var headerHeight = $header.height();
            var topbarHeight = $topbar.height();
            $fullScreen.each(function () {
                var $elem = $(this),
                    elemHeight = $window.height();
                $elem.css('height', elemHeight);
                if ($body.hasClass('device-lg') || $body.hasClass('device-md')) {
                    $elem.css('height', elemHeight);
                }else {
                    if ($topbar) {
                        $elem.css('height', elemHeight - (headerHeight + topbarHeight));
                    } else {
                        $elem.css('height', elemHeight - (headerHeight));
                    }
                }

            });
        }

        if ($halfScreen.exists()) {
            $halfScreen.each(function () {
                var $elem = $(this),
                    elemHeight = $window.height();

                $elem.css('height', elemHeight / 1.5);
            });
        }
    };

    //----------------------------------------------------/
    // TOP BAR
    //----------------------------------------------------/

    RP.topBar = function () {
        if ($topbar.exists()) {
            $("#topbar .topbar-dropdown .topbar-form").each(function (index, element) {                
                if ($window.width() - ($(element).width() + $(element).offset().left) < 0) {
                    $(element).addClass('dropdown-invert');
                }
            });
        }
    }

    //----------------------------------------------------/
    // TOP SEARCH
    //----------------------------------------------------/
    $("#top-search-trigger").on("click", function () {
        $body.toggleClass('top-search-active');
        $topSearch.find('input').focus();
        return false;
    });

    //----------------------------------------------------/
    // MAIN MENU FIXES
    //----------------------------------------------------/

    if (!$body.hasClass('device-lg') || !$body.hasClass('device-md')) {
        if (mainmenu.hasClass('mega-menu')) {
            mainmenuitems.on('click', function () {
                $(this).parent('ul li').toggleClass("resp-active", 1000, "easeOutSine");
                return false;
            });
            mainsubmenuitems.on('click', function () {
                $(this).parent('li').toggleClass('resp-active');
                return false;
            });
        }
    }

    RP.menuFix = function () {
        if ($body.hasClass('device-lg') || $body.hasClass('device-md')) {
            $('ul.main-menu .dropdown:not(.mega-menu-item) ul ul').each(function (index, element) {
                if ($window.width() - ($(element).width() + $(element).offset().left) < 0) {
                    $(element).addClass('menu-invert');
                }
            });
        }
    };

    //----------------------------------------------------/
    // Button lines
    //----------------------------------------------------/
    $(".lines-button").on("click", function () {
        $(this).toggleClass("lines-button-close");
        $("body").toggleClass("menu-open");
    });

    //----------------------------------------------------/
    // Side panel
    //----------------------------------------------------/

    RP.sidePanel = function () {
        if (sidePanel.exists()) {
            if ($body.hasClass("side-panel-static")) {
                $body.addClass("side-push-panel side-panel-left side-panel-active");

            } else {
                $(".side-panel-button button").on("click", function () {
                    if ($body.hasClass("side-panel-active")) {
                        $body.removeClass("side-panel-active");
                    } else {
                        $body.addClass("side-panel-active");
                    }
                    return false;
                });
                $body.removeClass("side-panel-active");
                $body.addClass("side-push-panel side-panel-left");
            }

        } else {
            $body.removeClass("side-push-panel side-panel-left");
        }

        //Side Panel Dark logo version
        if (sidePanel.hasClass('side-panel-dark')) {
            if (sidePanellogoDark) {
                sidePanellogo.find('img').attr('src', sidePanellogoDark);
            } else {
                sidePanellogo.find('img').attr('src', sidePanellogoImg);
            }

        } else {
            sidePanellogo.find('img').attr('src', sidePanellogoImg);
        }
    };
    //----------------------------------------------------/
    // VERTICAL MENU (DOTS)
    //----------------------------------------------------/

    RP.verticalDotMenu = function () {
        if (navigationItems.exists()) {
            navigationItems.on('click', function () {
                navigationItems.removeClass('active');
                $(this).addClass('active');
                return false;
            });
        }
    };

    //----------------------------------------------------/
    // FULLSCREEN MENU
    //----------------------------------------------------/

    RP.fullScreenPanel = function () {
        if (fullScreenPanel.exists()) {
            $("#fullscreen-panel-button").on("click", function () {
                $body.toggleClass('fullscreen-panel-active');
                return false;
            });
        }
    };


    //----------------------------------------------------/
    // TEXT ROTATOR
    //----------------------------------------------------/
    RP.textRotator = function () {
        if ($textRotator.exists()) {
            $textRotator.each(function () {
                var $elem = $(this),
                    dataTextSeperator = $elem.attr('data-rotate-separator') || ",",
                    dataTextEffect = $elem.attr('data-rotate-effect') || "flipInX",
                    dataTextSpeed = $elem.attr('data-rotate-speed') || 2000;
                $textRotator.Morphext({
                    animation: dataTextEffect,
                    separator: dataTextSeperator,
                    speed: Number(dataTextSpeed)
                });
            });
        }
    };

    //----------------------------------------------------/
    // ACCORDION
    //----------------------------------------------------/
    RP.accordion = function () {
        var $accs = $(classFinder + accordionItem);
        $accs.length && ($accs.each(function () {
            var $item = $(this);
            $item.hasClass(itemActive) ? $item.addClass(itemActive) : $item.find(classFinder + itemContent).hide();
        }), $(classFinder + itemTitle).on("click", function (e) {
            var $link = $(this),
                $item = $link.parents(classFinder + accordionItem),
                $acc = $item.parents(classFinder + accordionType);
            $item.hasClass(itemActive) ? $acc.hasClass(toogleType) ? ($item.removeClass(itemActive), $link.next(classFinder + itemContent).slideUp("fast")) : ($acc.find(classFinder + accordionItem).removeClass(itemActive), $acc.find(classFinder + itemContent).slideUp("fast")) : ($acc.hasClass(toogleType) || ($acc.find(classFinder + accordionItem).removeClass(itemActive), $acc.find(classFinder + itemContent).slideUp("fast")), $item.addClass(itemActive),
                    $link.next(classFinder + itemContent).slideToggle("fast")
                ),
                e.preventDefault();
            return false;
        }));
        if ($('.carousel').exists()) {
            RP.carouselRP();
        }
    };

    /* ---------------------------------------------------------------------------
     * TABS
     * --------------------------------------------------------------------------- */
    RP.tabs = function () {
        var $tabNavigation = $(".tabs-navigation a");
        if ($tabNavigation.exists()) {
            $tabNavigation.on("click", function (e) {
                $(this).tab("show"), e.preventDefault();
                return false;
            });
        }
    };

    /* ---------------------------------------------------------------------------
     * Animations
     * --------------------------------------------------------------------------- */
    RP.animations = function () {
        if (dataAnimation.exists() && $body.hasClass('device-lg') || $body.hasClass('device-md')) {
            dataAnimation.each(function () {
                $(this).addClass("animated");
                var $elem = $(this),
                    animationType = $elem.attr("data-animation") || "fadeIn",
                    animationDelay = $elem.attr("data-animation-delay") || 200,
                    animationDirection = ~animationType.indexOf("Out") ? "back" : "forward";
                if (animationDirection == "forward") {
                    $elem.appear(function () {
                        setTimeout(function () {
                            $elem.addClass(animationType + " visible");
                        }, animationDelay);
                    }, {
                        accX: 0,
                        accY: -120
                    }, 'easeInCubic');
                } else {
                    $elem.addClass("visible");
                    $elem.on("click", function () {
                        $elem.addClass(animationType);
                        return false;
                    });
                }
                if ($elem.parents('.demo-play-animations').length) {
                    $elem.on("click", function () {
                        $elem.removeClass(animationType);
                        setTimeout(function () {
                            $elem.addClass(animationType);
                        }, 50);
                        return false;
                    });
                }
            });
        }
    };

    /* ---------------------------------------------------------------------------
     * RESPONSIVE VIDEOS
     * --------------------------------------------------------------------------- */
    RP.resposniveVideos = function () {
        if ($().fitVids) {
            $("section, .content, .post-content, .ajax-quick-view,#slider:not(.revslider-wrap)").fitVids();
        }
    };

    /* ---------------------------------------------------------------------------
     * COUNTER NUMBERS
     * --------------------------------------------------------------------------- */
    RP.counters = function () {
        if ($counter.exists()) {
            $counter.each(function () {
                var $elem = $(this);
                $elem.appear(function () {
                    $elem.find('span').countTo();
                });
            });
        }
    };

    /* ---------------------------------------------------------------------------
     * COUNTDOWN TIMER
     * --------------------------------------------------------------------------- */
    RP.countdownTimer = function () {
        if ($countdownTimer.exists()) {
            setTimeout(function () {
                $('[data-countdown]').each(function () {
                    var $this = $(this),
                        finalDate = $(this).data('countdown');
                    $this.countdown(finalDate, function (event) {
                        $this.html(event.strftime('<div class="countdown-container"><div class="countdown-box"><div class="number">%-D</div><span>Day%!d</span></div>' + '<div class="countdown-box"><div class="number">%H</div><span>Hours</span></div>' + '<div class="countdown-box"><div class="number">%M</div><span>Minutes</span></div>' + '<div class="countdown-box"><div class="number">%S</div><span>Seconds</span></div></div>'));

                    });
                });
            }, 300);
        }
    };

    /* ---------------------------------------------------------------------------
     * PROGRESS BARS
     * --------------------------------------------------------------------------- */
    /* RP.progressBar = function () {
        if ($progressBar.exists()) {
            $progressBar.each(function (i, elem) {
                var $elem = $(this),
                    percent = $elem.attr('data-percent') || "100",
                    delay = $elem.attr('data-delay') || "100",
                    type = $elem.attr('data-type') || "%";
                if (!$elem.hasClass('progress-animated')) {
                    $elem.css({
                        'width': '0%'
                    });
                }
                var progressBarRun = function () {
                    $elem.animate({
                        'width': percent + '%'
                    }, 'easeInOutCirc').addClass('progress-animated');
                };
                if ($body.hasClass('device-lg') || $body.hasClass('device-md')) {
                    $(elem).appear(function () {
                        setTimeout(function () {
                            progressBarRun();
                        }, delay);
                    });
                } else {
                    progressBarRun();

                }
            });
        }
    }; */
 
    /* ---------------------------------------------------------------------------
     * PRI CHARTS
     * --------------------------------------------------------------------------- */
    RP.pieChart = function () {
        if ($pieChart.exists()) {
            $pieChart.each(function () {
                var $elem = $(this),
                    pieChartSize = $elem.attr('data-size') || "160",
                    pieChartAnimate = $elem.attr('data-animate') || "2000",
                    pieChartWidth = $elem.attr('data-width') || "6",
                    pieChartColor = $elem.attr('data-color') || "#00c0e9",
                    pieChartTrackColor = $elem.attr('data-trackcolor') || "rgba(0,0,0,0.10)";
                $elem.find('span, i').css({
                    'width': pieChartSize + 'px',
                    'height': pieChartSize + 'px',
                    'line-height': pieChartSize + 'px'
                });
                $elem.appear(function () {
                    $elem.easyPieChart({
                        size: Number(pieChartSize),
                        animate: Number(pieChartAnimate),
                        trackColor: pieChartTrackColor,
                        lineWidth: Number(pieChartWidth),
                        barColor: pieChartColor,
                        scaleColor: false,
                        lineCap: 'square',
                        onStep: function (from, to, percent) {
                            $elem.find('span.percent').text(Math.round(percent));
                        }
                    });
                });
            });
        }
    };

    /* ---------------------------------------------------------------------------
     * GOOGLE MAPS
     * --------------------------------------------------------------------------- */
    RP.maps = function () {
        if ($map.exists()) {
            $map.each(function () {
                var $elem = $(this),
                    mapAddress = $elem.attr('data-map-address') ? $elem.attr('data-map-address') : "Melbourne, Australia",
                    mapType = $elem.attr('data-map-type') ? $elem.attr('data-map-type') : "ROADMAP",
                    mapZoom = $elem.attr('data-map-zoom') ? $elem.attr('data-map-zoom') : "14",
                    mapIcon = $elem.attr('data-map-icon') ? $elem.attr('data-map-icon') : "images/markers/marker2.png";
                var markers = [{
                    address: mapAddress,
                    html: mapAddress,
                    icon: {
                        image: mapIcon,
                        iconsize: [40, 63],
                        iconanchor: [18, 60],
                    },
                    }];
                $elem.gMap({
                    address: mapAddress,
                    maptype: mapType,
                    markers: markers,
                    zoom: Number(mapZoom),
                    doubleclickzoom: true,
                    controls: {
                        panControl: true,
                        zoomControl: true,
                        mapTypeControl: false,
                        scaleControl: true,
                        streetViewControl: false,
                        overviewMapControl: true
                    }
                });
            });
        }
    };

    /* ---------------------------------------------------------------------------
     * MASONRY ISOTOPE
     * --------------------------------------------------------------------------- */
    RP.masonryIsotope = function () {
        var $isotops = $(".isotope");
        $isotops.each(function () {
            var isotopeTime,
                $elem = $(this),
                defaultFilter = $elem.data("isotopeDefaultFilter") || 0,
                id = $elem.attr("id"),
                mode = $elem.attr('data-isotope-mode') || "masonry",
                columns = $elem.attr('data-isotope-col') || "4",
                $elemContainer = $elem,
                itemElement = $elem.attr('data-isotope-item') || ".isotope-item",
                itemElementSpace = $elem.attr('data-isotope-item-space') || 0;
            $elem.isotope({
                    filter: defaultFilter,
                    itemSelector: itemElement,
                    layoutMode: mode,
                    transitionDuration: '0.6s',
                    resizesContainer: true,
                    resizable: true,
                    animationOptions: {
                        duration: 400,
                        queue: !1
                    }
                }),
                $window.resize(function () {
                    $elemContainer.css('margin-right', '-' + itemElementSpace + '%');
                    if ($body.hasClass('device-sm') || $body.hasClass('device-xs')) {
                        itemWidth(2, $elemContainer, itemElement, itemElementSpace);
                    } else if ($body.hasClass('device-xxs')) {
                        itemWidth(1, $elemContainer, itemElement, itemElementSpace);
                    } else {
                        itemWidth(columns, $elemContainer, itemElement, itemElementSpace);
                    }
                    if (columns == 1 && $body.hasClass('device-sm') || columns == 1 && $body.hasClass('device-xs')) {
                        itemWidth(1, $elemContainer, itemElement, itemElementSpace);
                    }
                    clearTimeout(isotopeTime), isotopeTime = setTimeout(function () {
                        $elem.isotope("layout");
                    }, 300);
                });

            var $menu = $('[data-isotope-nav="' + id + '"]');
            $menu.length && $menu.find("li:not('.link-only')").on("click", function (e) {
                var $link = $(this);
                $(".filter-active-title").empty().append($link.text());
                if (!$link.hasClass("ptf-active")) {
                    var selector = $link.attr("data-filter");
                    $link.parents(".portfolio-filter").eq(0).find(".ptf-active").removeClass("ptf-active"), $link.addClass("ptf-active"), $elem.isotope({
                        filter: selector
                    });
                }
                e.preventDefault();
                return false;
            }), $window.resize();
        });

    };

    // Intellegent Grid
    var itemWidth = function (columns, $elemContainer, itemElement, itemElementSpace) {
        var $findElement = $elemContainer.find(itemElement);
        var $findElementLarge = $elemContainer.find(".large-item");
        var itemElementMargins = {
            "margin-right": itemElementSpace + "%",
            "margin-bottom": itemElementSpace + "%",
        };
        if (columns == 1) {
            $findElement.width('100%');
            $findElementLarge.width('100%');
        }
        if (columns == 2) {
            $findElement.width(50 - itemElementSpace + '%').css(itemElementMargins);
            $findElementLarge.width(50 - itemElementSpace + '%').css(itemElementMargins);
        }
        if (columns == 3) {
            $findElement.width(33.33 - itemElementSpace + '%').css(itemElementMargins);
            $findElementLarge.width(66.66 - itemElementSpace + '%').css(itemElementMargins);
        }
        if (columns == 4) {
            $findElement.width(25 - itemElementSpace + '%').css(itemElementMargins);
            $findElementLarge.width(50 - itemElementSpace + '%').css(itemElementMargins);
        }
        if (columns == 5) {
            $findElement.width(20 - itemElementSpace + '%').css(itemElementMargins);
            $findElementLarge.width(40 - itemElementSpace + '%').css(itemElementMargins);
        }
        if (columns == 6) {
            $findElement.width(16.666666 - itemElementSpace + '%').css(itemElementMargins);
            $findElementLarge.width(33.333333 - itemElementSpace + '%').css(itemElementMargins);
        }
    };

    /* ---------------------------------------------------------------------------
     * TOOLTIPS
     * --------------------------------------------------------------------------- */
    RP.tooltip = function () {
        var $tooltip = $('[data-toggle="tooltip"]');
        if ($tooltip.exists()) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    };

    /* ---------------------------------------------------------------------------
     * POPOVER
     * --------------------------------------------------------------------------- */
    RP.popover = function () {
        var $popover = $('[data-toggle="popover"]');
        if ($popover.exists()) {
            $('[data-toggle="popover"]').popover({
                container: 'body',
                html: true
            });
        }
    };

    /* ---------------------------------------------------------------------------
     * LIGHTBOX
     * --------------------------------------------------------------------------- */
    RP.lightBoxRP = function () {
        if ($lightbox_image.exists()) {
            $lightbox_image.magnificPopup({
                type: 'image'
            });
        }
        if ($lightbox_gallery.exists()) {
            $lightbox_gallery.each(function () {
                $(this).magnificPopup({
                    delegate: 'a',
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                });
            });
        }
        if ($lightbox_iframe.exists()) {
            $lightbox_iframe.each(function () {
                $(this).magnificPopup({
                    type: 'iframe'
                });
            });
        }
        if ($lightbox_ajax.exists()) {
            $lightbox_ajax.each(function () {
                $(this).magnificPopup({
                    type: 'ajax',
                    callbacks: {
                        ajaxContentAdded: function (mfpResponse) {
                            RP.carouselRP();
                            RP.resposniveVideos();
                            RP.accordion();
                        }
                    }
                });
            });
        }
    }

    /* ---------------------------------------------------------------------------
     * FLICKR WIDGET
     * --------------------------------------------------------------------------- */
    RP.flickr_widget = function () {
        if ($flickr_widget.exists()) {
            $flickr_widget.each(function () {
                var $elem = $(this),
                    $flickrId = $elem.attr('data-flickr-id') || "52617155@N08",
                    $flickrImages = $elem.attr('data-flickr-images') || "9";
                $flickr_widget.jflickrfeed({
                    limit: $flickrImages,
                    qstrings: {
                        id: $flickrId
                    },
                    itemTemplate: '<a href="{{image}}" title="{{title}}"><img src="{{image_s}}" alt="{{title}}" /></a>'
                }, function () {
                    $elem.magnificPopup({
                        delegate: 'a',
                        type: 'image',
                        gallery: {
                            enabled: true
                        }
                    });
                });
            });
        }
    }

    /* ---------------------------------------------------------------------------
     * YOUTUBE BACKGROUND PLAYER
     * --------------------------------------------------------------------------- */
    RP.youTubeBgPlayer = function () {
        if ($ytPlayer.exists()) {
            $ytPlayer.each(function () {
                var elem = $(this),
                    ytPlayerVideo = elem.attr('data-youtube-url') || null,
                    ytPlayerMute = elem.attr('data-youtube-mute') || false,
                    ytPlayerRatio = elem.attr('data-youtube-ratio') || '16/9',
                    ytPlayerQuality = elem.attr('data-youtube-quality') || 'hd720',
                    ytPlayerOpacity = elem.attr('data-youtube-opacity') || 1,
                    ytPlayerContainer = elem.attr('data-youtube-container') || 'self',
                    ytPlayerOptimize = elem.attr('data-youtube-optimize') || true,
                    ytPlayerLoop = elem.attr('data-youtube-loop') || true,
                    ytPlayerVolume = elem.attr('data-youtube-volume') || 1,
                    ytPlayerStart = elem.attr('data-youtube-start') || 0,
                    ytPlayerStop = elem.attr('data-youtube-stop') || 0,
                    ytPlayerAutoPlay = elem.attr('data-youtube-autoplay') || false,
                    ytPlayerFullScreen = elem.attr('data-youtube-fullscreen') || true,
                    ytPlayerControls = elem.attr('data-youtube-controls') || false,
                    ytPlayerLogo = elem.attr('data-youtube-controls') || false,
                    ytPlayerAutoPause = elem.attr('data-youtube-autopause') || false;
                elem.mb_YTPlayer({
                    videoURL: ytPlayerVideo,
                    mute: ytPlayerMute,
                    ratio: ytPlayerRatio,
                    quality: ytPlayerQuality,
                    opacity: ytPlayerOpacity,
                    containment: ytPlayerContainer,
                    optimizeDisplay: ytPlayerOptimize,
                    loop: ytPlayerLoop,
                    vol: ytPlayerVolume,
                    startAt: ytPlayerStart,
                    stopAt: ytPlayerStop,
                    autoPlay: ytPlayerAutoPlay,
                    realfullscreen: ytPlayerFullScreen,
                    showYTLogo: ytPlayerLogo,
                    showControls: ytPlayerControls
                });
                if (!ytPlayerAutoPlay) {
                    elem.find("#youtube-background-controls").addClass("video-is-playing");
                }
                elem.on("YTPReady", function () {
                    $("#youtube-background-controls").on("click", function () {
                        if (!$(this).hasClass("video-is-playing")) {
                            $(this).addClass("video-is-playing");
                            $ytPlayer.YTPPause();
                        } else {
                            $(this).removeClass("video-is-playing");
                            $ytPlayer.YTPPlay();
                        }
                        return false;
                    });
                    var elemContainerHeight = elem.height();
                    if (ytPlayerAutoPause) {
                        $window.on('scroll', function () {
                            if ($window.scrollTop() > elemContainerHeight) {
                                $("#youtube-background-controls").addClass("video-is-playing");
                                $ytPlayer.YTPPause();
                            }

                        });
                    }
                });
            });
        }
    }

    //----------------------------------------------------/
    // Mouse Scroll
    //----------------------------------------------------/
    RP.mouseScroll = function () {
        if ($body.hasClass('mouse-scroll') && $window.width() > 767) {
            var $offset = 0;
            if ($header.hasClass('header-transparent')) {
                $offset = -$header.height() - 20;
            }
            $.scrollify({
                section: "section",
                sectionName: "section-name",
                scrollSpeed: 1100,
                offset: $offset,
                scrollbars: true,
            });
        }
    }

    //Window load functions
    /* $window.load(function () {
        RP.progressBar(),
            RP.pieChart(),
            RP.masonryIsotope(),
            RP.carouselRP(),
            RP.animations(),
            RP.menuFix()
    }); */

    //Document ready functions
    $document.ready(
        RP.responsiveClasses(),
        RP.stickyHeader(),
        RP.logoStatus(),
        RP.verticalDotMenu(),
        RP.mouseScroll(),
        RP.screenSizeControl(),
        //RP.parallax(),
        RP.naTo(),
        RP.sidePanel(),
        RP.fullScreenPanel(),
        RP.textRotator(),
        RP.accordion(),
        RP.tabs(),
        RP.counters(),
        RP.countdownTimer(),
        RP.youTubeBgPlayer(),
        RP.maps(),
        RP.lightBoxRP(),
        RP.resposniveVideos(),
        RP.tooltip(),
        RP.popover(),
        RP.flickr_widget(),
        RP.goToTop(),
        RP.topBar()

    );

    //Document resize functions
    $window.resize(function () {
        RP.logoStatus(),
            RP.screenSizeControl(),
            RP.menuFix()
    });

    //Document scrool functions
    $window.scroll(function () {
        RP.goToTop()
    });

    // Project Carousel 
    jQuery(document).ready(function($)
        {
        var ocClients = $("#project-carousal");
        ocClients.owlCarousel(
        {
            items:4,
            margin: 0,
            nav: false,
                 navText: [''],
            dots: false,
            navRewind: false,
            responsive:
            {
                0:{ items:1 },
                480:{ items:1 },
                768:{ items:3 },
                1000:{ items:4 },
                1200:{ items:4}
        }
        });
    });

    // Video Js
    $(".play-2").yu2fvl();    

    // Projects Slider in laptop
    jQuery(document).ready(function($)
        {
        var ocClients = $(".projrct-slider-action");
        ocClients.owlCarousel(
        {
            items:1,
            margin: 0,
            nav: true,
                 navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
            dots: false,
            navRewind: false,
            responsive:
            {
                0:{ items:1 },
                480:{ items:1 },
                768:{ items:1 },
                1000:{ items:1 },
                1200:{ items:1}
        }
        });
    });
	
	// Accordian Style 2  plus minus Icon
	jQuery(function ($) {
		var $active = $('#accordion-2 .panel-collapse.in').prev().addClass('active');
		$active.find('a').append('<span class="glyphicon glyphicon-minus pull-right"></span>');
		$('#accordion-2 .panel-heading').not($active).find('a').prepend('<span class="glyphicon glyphicon-plus pull-right"></span>');
		$('#accordion-2').on('show.bs.collapse', function (e)
		{
			$('#accordion-2 .panel-heading.active').removeClass('active').find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
			$(e.target).prev().addClass('active').find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
		});
		$('#accordion-2').on('hide.bs.collapse', function (e)
		{
			$(e.target).prev().removeClass('active').find('.glyphicon').removeClass('glyphicon-minus').addClass('glyphicon-plus');
		});
	});


	// Accordian  Style 3 plus minus Icon
	jQuery(function ($) {
		var $active = $('#accordion-3 .panel-collapse.in').prev().addClass('active');
		$active.find('a').append('<span class="glyphicon glyphicon-minus pull-right"></span>');
		$('#accordion-3 .panel-heading').not($active).find('a').prepend('<span class="glyphicon glyphicon-plus pull-right"></span>');
		$('#accordion-3').on('show.bs.collapse', function (e)
		{
			$('#accordion-3 .panel-heading.active').removeClass('active').find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
			$(e.target).prev().addClass('active').find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
		});
		$('#accordion-3').on('hide.bs.collapse', function (e)
		{
			$(e.target).prev().removeClass('active').find('.glyphicon').removeClass('glyphicon-minus').addClass('glyphicon-plus');
		});
	});


	// Accordian  Style 4 plus minus Icon
	jQuery(function ($) {
		var $active = $('#accordion-4 .panel-collapse.in').prev().addClass('active');
		$active.find('a').append('<span class="glyphicon glyphicon-minus pull-right"></span>');
		$('#accordion-4 .panel-heading').not($active).find('a').prepend('<span class="glyphicon glyphicon-plus pull-right"></span>');
		$('#accordion-4').on('show.bs.collapse', function (e)
		{
			$('#accordion-4 .panel-heading.active').removeClass('active').find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
			$(e.target).prev().addClass('active').find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
		});
		$('#accordion-4').on('hide.bs.collapse', function (e)
		{
			$(e.target).prev().removeClass('active').find('.glyphicon').removeClass('glyphicon-minus').addClass('glyphicon-plus');
		});
	});
	
	
	// Blog masnory 
	if($('.isotope').length) {
		$(function() {
			  // init Isotope
			  var $container = $('.isotope').isotope
			  ({
					itemSelector: '.element-item',
					layoutMode: 'fitRows'
			  });
		});
	}
		
					
	// Carousel Style One
    jQuery(document).ready(function($) {
        var ocClientsFull = $("#rp-slider-style-one");
        ocClientsFull.owlCarousel({
            items: 1,
            itemsDesktop : [970,1],
            margin: 0,                                
            padding: 0,
            loop: true,
            nav: true,
            navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
            autoplay: true,
            autoplayHoverPause: false,
            dots: false,
            navRewind: false,
            responsive:{
                0:{ items:1 },
                480:{ items:1 },
                768:{ items:1 },
                992:{ items:1 },
                1200:{ items:1 },
                1400:{ items:1 }
            }
        });

    });


    // Carousel Style Two
    jQuery(document).ready(function($) {
        var ocClientsFull = $("#rp-slider-style-two");
        ocClientsFull.owlCarousel({
            items: 1,
            itemsDesktop : [970,1],
            margin: 0,                                
            padding: 0,
            loop: true,
            nav: true,
            navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
            autoplay: true,
            autoplayHoverPause: false,
            dots: false,
            navRewind: false,
            responsive:{
                0:{ items:1 },
                480:{ items:1 },
                768:{ items:1 },
                992:{ items:1 },
                1200:{ items:1 },
                1400:{ items:1 }
            }
        });
    });


    // Carousel Style three
    jQuery(document).ready(function($) {
        var ocClientsFull = $("#rp-slider-style-three");
        ocClientsFull.owlCarousel({
            items: 3,
            itemsDesktop : 3,
            margin: 30,                                
            padding: 0,
            navText: [''],
            autoplay: true,
            autoplayHoverPause: false,
            dots: false,
            
            responsive:{
                0:{ items:0 },
                280:{ items:1 },
                480:{ items:1 },
                768:{ items:3 },
                992:{ items:3 },
                1200:{ items:3 },
                1400:{ items:3 }
            }
        });
    });	
		
		
	// carousel script style 1 
    jQuery(document).ready(function($)
        {
        var ocClients = $("#rp-clients-style-one");
        ocClients.owlCarousel(
        {
            items: 6,
            margin: 30,
            nav: false,
                navText: [''],
            dots: false,
            navRewind: false,
            responsive:
            {
                0:{ items:2 },
                480:{ items:3 },
                768:{ items:4 },
                1000:{ items:6 },
                1200:{ items:6 }
            }
        });
    });
    

    // carousel script style 2    
    jQuery(document).ready(function($)
        {
        var ocClients = $("#rp-clients-style-two");
        ocClients.owlCarousel(
        {
            items:6,
            margin: 30,
            nav: false,
                 navText: [''],
            dots: false,
            navRewind: false,
            responsive:
            {
                0:{ items:2 },
                480:{ items:3 },
                768:{ items:4 },
                1000:{ items:6 },
                1200:{ items:6}
        }
        });
    });
    
    
    // Full width carousel
    jQuery(document).ready(function($) {
        var ocClientsFull = $("#rp-clients-style-three");
        ocClientsFull.owlCarousel({
            items: 5,
            margin: 59,
            loop: true,
            nav: true,
            navText: [''],
            autoplay: true,
            autoplayHoverPause: false,
            dots: false,
            navRewind: false,
            responsive:{
                0:{ items:2 },
                480:{ items:3 },
                768:{ items:4 },
                992:{ items:5 },
                1200:{ items:5 },
                1400:{ items:5 }
            }
        });
    });
    
        
    // Full width carousel with bg
    jQuery(document).ready(function($)
        {
        var ocClients = $("#rp-clients-style-four");
        ocClients.owlCarousel(
        {
            items: 4,
            margin:0,
            nav: false,
                 navText: [''],
            dots: false,
            navRewind: false,
            responsive:
            {
                0:{ items:2 },
                480:{ items:3 },
                768:{ items:4 },
                1000:{ items:5 },
                1200:{ items:4 }
            }
        });
    });
		
		
	// Portfolio masnory Filter 
        $(window).load(function(){
             $('.grid').isotope({
             // options
             itemSelector: '.grid-item',
             layoutMode: 'masonry'
            });
        });

        
        if($('.grid').length) {
            $(function() {
                  // init Isotope
                  var $container = $('.grid').isotope
                  ({
                        itemSelector: '.grid-item',
                        layoutMode: 'fitRows'
                  });
                  // bind filter button click
                  $('#filter').on( 'click', 'li > a', function() {
                        var filterValue = $( this ).attr('data-filter');
                        // use filterFn if matches value
                        $container.isotope({ filter: filterValue });
                  });
                  // change is-checked class on buttons
                  $('.categories').each( function( i, buttonGroup ) {
                        var $buttonGroup = $( buttonGroup );
                        $buttonGroup.on( 'click', 'li > a', function() {
                              $buttonGroup.find('.active').removeClass('active');
                              $( this ).addClass('active');
                        });
                  });
            });
        }
        

    // Testimonial        
     jQuery(document).ready(function($)
    {
        var ocClients = $("#testimonial-7");
        ocClients.owlCarousel({
            items: 3,
            margin:30,
            nav: false,
                 navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
            dots: true,
            navRewind: true,
            responsive:
            {
                0:{ items:1 },
                480:{ items:1 },
                768:{ items:2 },
                1000:{ items:3 },
                1200:{ items:3 }
            }
        });
    });


    // Client Carousel 
    jQuery(document).ready(function($)
        {
        var ocClients = $("#rp-clients-style-two");
        ocClients.owlCarousel(
        {
            items:6,
            margin: 30,
            nav: false,
                 navText: [''],
            dots: false,
            navRewind: false,
            responsive:
            {
                0:{ items:2 },
                480:{ items:3 },
                768:{ items:4 },
                1000:{ items:6 },
                1200:{ items:6}
        }
        });
    });
	 
	
		

	(function(){
        'use strict';
        $(window).on('load', function(){  	
	        // PIECHART STYLE 1 INIT
            if( $('.piechart.piechart-style1').length ) {
                $('.piechart.piechart-style1').each(function(){
                    var $this = $(this),
                        input = $this.children('input'),
                        percentage = input.attr("value"); ;

                    input.knob({
                        readOnly: true,
                        width: 200,
                        inputColor: '#444',
                       dynamicDraw: true,
                    });

                    $this.appear(function(){
                        $({value: 0}).animate({ value: percentage }, {
                            duration: 1500,
                            easing: 'swing',
                            progress: function () { input.val(Math.ceil(this.value)).trigger('change') }
                        });
                    })
                });
            };
        }); 
    })();            
    
    
    // PIE CHART STYLE 2
    function pieChart2(){
        var chartContainer = $('.piechart-style2').find('.chart-container');
        chartContainer.each(function(index){
            var $this = $(this),
                canvas = $this.find('canvas'),
                ctx = canvas.get(0).getContext("2d"),
                chartData = [];

            $this.find('.chart-data').find('li').each(function(){
                var li = $(this);

                chartData.push({
                    value: li.data('value'),
                    color: li.data('color'),
                    label: li.text()
                })
            });

            window.doughnutChart = new Chart(ctx).Doughnut(chartData, {
                animateRotate : false,
                segmentShowStroke : false,
                showTooltips: false,
                percentageInnerCutout : 55,
                legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
            });
            var legend = doughnutChart.generateLegend();
            $this.append(legend);
        });
    };
    pieChart2();



    // PIE CHART STYLE 3
    function pieChart3(){

        var chartContainer = $('.piechart-style3').find('.chart-container');

        chartContainer.each(function(index){
            var $this = $(this),
                canvas = $this.find('canvas'),
                ctx = canvas.get(0).getContext("2d"),
                chartData = [];

            $this.find('.chart-data').find('li').each(function(){
                var li = $(this);

                chartData.push({
                    value: li.data('value'),
                    color: li.data('color'),
                    label: li.text()
                })
            });

            window.pieChart = new Chart(ctx).Pie(chartData, {
                animateRotate : false,
                segmentShowStroke : false,
                showTooltips: false,
                legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
            });
            var legend = pieChart.generateLegend();
            $this.append(legend);
        });

    };
    pieChart3();
		
	
	// Blog Post Slider JS 
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        centeredSlides: true,
        paginationClickable: true,
        spaceBetween: 30,
        slidesPerView: 4,
        loop:true,
        loopedSlides: 4,
        grabCursor: true
    });
		
		
	// calender JS
	$('#demo').dcalendarpicker();
	$('#calendar-demo').dcalendar();
		
		
	// Portfolio masnory Filter 
 //    $(window).load(function(){
 //         $('.isotope').isotope({
 //         // options
 //         itemSelector: '.element-item',
 //         layoutMode: 'masonry'
 //        });
 //    });
	
	// if($('.isotope').length) {
	// 	$(function() {
	// 		  // init Isotope
	// 		  var $container = $('.isotope').isotope
	// 		  ({
	// 				itemSelector: '.element-item',
	// 				layoutMode: 'fitRows'
	// 		  });
	// 	});
	// }

	
	
	// Photo Swipe Js
	var initPhotoSwipeFromDOM = function(gallerySelector) {
	var parseThumbnailElements = function(el) {
        var thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;
        for(var i = 0; i < numNodes; i++) {
            figureEl = thumbElements[i]; // <figure> element
            // include only element nodes 
            if(figureEl.nodeType !== 1) {
                continue;
            }
            linkEl = figureEl.children[0]; // <a> element
            size = linkEl.getAttribute('data-size').split('x');
            // create slide object
            item = {
                src: linkEl.getAttribute('href'),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
            };
            if(figureEl.children.length > 1) {
                // <figcaption> content
                item.title = figureEl.children[1].innerHTML; 
            }
            if(linkEl.children.length > 0) {
                // <img> thumbnail element, retrieving thumbnail url
                item.msrc = linkEl.children[0].getAttribute('src');
            } 
            item.el = figureEl; // save link to element for getThumbBoundsFn
            items.push(item);
        }
        return items;
    };
    // find nearest parent element
    var closest = function closest(el, fn) {
        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
    };
    // triggers when user clicks on thumbnail
    var onThumbnailsClick = function(e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;
        var eTarget = e.target || e.srcElement;
        // find root element of slide
        var clickedListItem = closest(eTarget, function(el) {
            return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
        });
        if(!clickedListItem) {
            return;
        }
        // find index of clicked item by looping through all child nodes
        // alternatively, you may define index via data- attribute
        var clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;
        for (var i = 0; i < numChildNodes; i++) {
            if(childNodes[i].nodeType !== 1) { 
                continue; 
            }
            if(childNodes[i] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }
        if(index >= 0) {
            // open PhotoSwipe if valid index found
            openPhotoSwipe( index, clickedGallery );
        }
        return false;
    };
    // parse picture index and gallery index from URL (#&pid=1&gid=2)
    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
        params = {};
        if(hash.length < 5) {
            return params;
        }
        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if(!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');  
            if(pair.length < 2) {
                continue;
            }           
            params[pair[0]] = pair[1];
        }
        if(params.gid) {
            params.gid = parseInt(params.gid, 10);
        }
        return params;
    };
    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
        var pswpElement = document.querySelectorAll('.pswp')[0],
            gallery,
            options,
            items;
        items = parseThumbnailElements(galleryElement);
        // define options (if needed)
        options = {
            // define gallery index (for URL)
            galleryUID: galleryElement.getAttribute('data-pswp-uid'),
            getThumbBoundsFn: function(index) {
                // See Options -> getThumbBoundsFn section of documentation for more info
                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect(); 
                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
            }
        };
        // PhotoSwipe opened from URL
        if(fromURL) {
            if(options.galleryPIDs) {
                // parse real index when custom PIDs are used 
                // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                for(var j = 0; j < items.length; j++) {
                    if(items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                // in URL indexes start from 1
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }
        // exit if index not found
        if( isNaN(options.index) ) {
            return;
        }
        if(disableAnimation) {
            options.showAnimationDuration = 0;
        }
        // Pass data to PhotoSwipe and initialize it
        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
        gallery.init();
    };
    // loop through all gallery elements and bind events
    var galleryElements = document.querySelectorAll( gallerySelector );
	    for(var i = 0, l = galleryElements.length; i < l; i++) {
	        galleryElements[i].setAttribute('data-pswp-uid', i+1);
	        galleryElements[i].onclick = onThumbnailsClick;
	    }
	    // Parse URL and open gallery if it contains #&pid=3&gid=1
	    var hashData = photoswipeParseHash();
	    if(hashData.pid && hashData.gid) {
	        openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
	    }
	};
	// execute above function
	initPhotoSwipeFromDOM('.my-gallery');

		

	//popover
    $(document).ready(function(){
		$('[data-toggle="popover"]').popover();   
	});
		

	//tool tip
	$(document).ready(function(){
       $('[data-toggle="tooltip"]').tooltip();   
   });
	   
	   
	// pricing table Js ( style 8 )
	jQuery(document).ready(function($){
	//hide the subtle gradient layer (.cd-pricing-list > li::after) when pricing table has been scrolled to the end (mobile version only)
	checkScrolling($('.rp-pricing-body'));
	$(window).on('resize', function(){
		window.requestAnimationFrame(function(){checkScrolling($('.rp-pricing-body'))});
	});
	$('.rp-pricing-body').on('scroll', function(){ 
		var selected = $(this);
		window.requestAnimationFrame(function(){checkScrolling(selected)});
	});

	function checkScrolling(tables){
		tables.each(function(){
			var table= $(this),
				totalTableWidth = parseInt(table.children('.rp-pricing-features').width()),
		 		tableViewport = parseInt(table.width());
			if( table.scrollLeft() >= totalTableWidth - tableViewport -1 ) {
				table.parent('li').addClass('is-ended');
			} else {
				table.parent('li').removeClass('is-ended');
			}
		});
	}

	//switch from monthly to annual pricing tables
	bouncy_filter($('.rp-pricing-container'));

	function bouncy_filter(container) {
		container.each(function(){
			var pricing_table = $(this);
			var filter_list_container = pricing_table.children('.rp-pricing-switcher'),
				filter_radios = filter_list_container.find('input[type="radio"]'),
				pricing_table_wrapper = pricing_table.find('.rp-pricing-wrapper');

			//store pricing table items
			var table_elements = {};
			filter_radios.each(function(){
				var filter_type = $(this).val();
				table_elements[filter_type] = pricing_table_wrapper.find('li[data-type="'+filter_type+'"]');
			});

			//detect input change event
			filter_radios.on('change', function(event){
				event.preventDefault();
				//detect which radio input item was checked
				var selected_filter = $(event.target).val();

				//give higher z-index to the pricing table items selected by the radio input
				show_selected_items(table_elements[selected_filter]);

				//rotate each cd-pricing-wrapper 
				//at the end of the animation hide the not-selected pricing tables and rotate back the .cd-pricing-wrapper
				
				if( !Modernizr.cssanimations ) {
					hide_not_selected_items(table_elements, selected_filter);
					pricing_table_wrapper.removeClass('is-switched');
				} else {
					pricing_table_wrapper.addClass('is-switched').eq(0).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {		
						hide_not_selected_items(table_elements, selected_filter);
						pricing_table_wrapper.removeClass('is-switched');
						//change rotation direction if .cd-pricing-list has the .cd-bounce-invert class
						if(pricing_table.find('.rp-pricing-list').hasClass('rp-bounce-invert')) pricing_table_wrapper.toggleClass('reverse-animation');
					});
				}
			});
		});
	}
	function show_selected_items(selected_elements) {
		selected_elements.addClass('is-selected');
	}

	function hide_not_selected_items(table_containers, filter) {
		$.each(table_containers, function(key, value){
	  		if ( key != filter ) {	
				$(this).removeClass('is-visible is-selected').addClass('is-hidden');

			} else {
				$(this).addClass('is-visible').removeClass('is-hidden is-selected');
			}
		});
	}
	});
		
		
	// https://github.com/mattboldt/typed.js
	!function(t){"use strict";var s=function(s,e){this.el=t(s),this.options=t.extend({},t.fn.typed.defaults,e),this.isInput=this.el.is("input"),this.attr=this.options.attr,this.showCursor=this.isInput?!1:this.options.showCursor,this.elContent=this.attr?this.el.attr(this.attr):this.el.text(),this.contentType=this.options.contentType,this.typeSpeed=this.options.typeSpeed,this.startDelay=this.options.startDelay,this.backSpeed=this.options.backSpeed,this.backDelay=this.options.backDelay,this.stringsElement=this.options.stringsElement,this.strings=this.options.strings,this.strPos=0,this.arrayPos=0,this.stopNum=0,this.loop=this.options.loop,this.loopCount=this.options.loopCount,this.curLoop=0,this.stop=!1,this.cursorChar=this.options.cursorChar,this.shuffle=this.options.shuffle,this.sequence=[],this.build()};s.prototype={constructor:s,init:function(){var t=this;t.timeout=setTimeout(function(){for(var s=0;s<t.strings.length;++s)t.sequence[s]=s;t.shuffle&&(t.sequence=t.shuffleArray(t.sequence)),t.typewrite(t.strings[t.sequence[t.arrayPos]],t.strPos)},t.startDelay)},build:function(){var s=this;if(this.showCursor===!0&&(this.cursor=t('<span class="typed-cursor">'+this.cursorChar+"</span>"),this.el.after(this.cursor)),this.stringsElement){s.strings=[],this.stringsElement.hide();var e=this.stringsElement.find("p");t.each(e,function(e,i){s.strings.push(t(i).html())})}this.init()},typewrite:function(t,s){if(this.stop!==!0){var e=Math.round(70*Math.random())+this.typeSpeed,i=this;i.timeout=setTimeout(function(){var e=0,r=t.substr(s);if("^"===r.charAt(0)){var o=1;/^\^\d+/.test(r)&&(r=/\d+/.exec(r)[0],o+=r.length,e=parseInt(r)),t=t.substring(0,s)+t.substring(s+o)}if("html"===i.contentType){var n=t.substr(s).charAt(0);if("<"===n||"&"===n){var a="",h="";for(h="<"===n?">":";";t.substr(s).charAt(0)!==h;)a+=t.substr(s).charAt(0),s++;s++,a+=h}}i.timeout=setTimeout(function(){if(s===t.length){if(i.options.onStringTyped(i.arrayPos),i.arrayPos===i.strings.length-1&&(i.options.callback(),i.curLoop++,i.loop===!1||i.curLoop===i.loopCount))return;i.timeout=setTimeout(function(){i.backspace(t,s)},i.backDelay)}else{0===s&&i.options.preStringTyped(i.arrayPos);var e=t.substr(0,s+1);i.attr?i.el.attr(i.attr,e):i.isInput?i.el.val(e):"html"===i.contentType?i.el.html(e):i.el.text(e),s++,i.typewrite(t,s)}},e)},e)}},backspace:function(t,s){if(this.stop!==!0){var e=Math.round(70*Math.random())+this.backSpeed,i=this;i.timeout=setTimeout(function(){if("html"===i.contentType&&">"===t.substr(s).charAt(0)){for(var e="";"<"!==t.substr(s).charAt(0);)e-=t.substr(s).charAt(0),s--;s--,e+="<"}var r=t.substr(0,s);i.attr?i.el.attr(i.attr,r):i.isInput?i.el.val(r):"html"===i.contentType?i.el.html(r):i.el.text(r),s>i.stopNum?(s--,i.backspace(t,s)):s<=i.stopNum&&(i.arrayPos++,i.arrayPos===i.strings.length?(i.arrayPos=0,i.shuffle&&(i.sequence=i.shuffleArray(i.sequence)),i.init()):i.typewrite(i.strings[i.sequence[i.arrayPos]],s))},e)}},shuffleArray:function(t){var s,e,i=t.length;if(i)for(;--i;)e=Math.floor(Math.random()*(i+1)),s=t[e],t[e]=t[i],t[i]=s;return t},reset:function(){var t=this;clearInterval(t.timeout);var s=this.el.attr("id");this.el.after('<span id="'+s+'"/>'),this.el.remove(),"undefined"!=typeof this.cursor&&this.cursor.remove(),t.options.resetCallback()}},t.fn.typed=function(e){return this.each(function(){var i=t(this),r=i.data("typed"),o="object"==typeof e&&e;r||i.data("typed",r=new s(this,o)),"string"==typeof e&&r[e]()})},t.fn.typed.defaults={strings:["These are the default values...","You know what you should do?","Use your own!","Have a great day!"],stringsElement:null,typeSpeed:0,startDelay:0,backSpeed:0,shuffle:!1,backDelay:500,loop:!1,loopCount:!1,showCursor:!0,cursorChar:"|",attr:null,contentType:"html",callback:function(){},preStringTyped:function(){},onStringTyped:function(){},resetCallback:function(){}}}(window.jQuery);

	$(function(){
	  $('.text').typed({
		strings: [
		  "Oops! It looks like you're lost. <br />" + 
		  "Sorry about that. <br />" +
		  "Let me try and help. <br />" +
		  "Go back <a href='index.html'>home</a> and start over."
		],
		typeSpeed: -5000,
		showCursor: false
	  });
	});
	  var four = document.getElementById('wobble');
		function wobble() {
		  var dist = 60;
		  var id = setInterval(function() {
			if(dist % 2 == 0) {
			  var deg = 180 + dist;
			} else {
			  var deg = 180 - dist;
			}
			//four.style.transform = "rotate(" + deg + "deg)";
			if(dist > 15){
			  dist -= 11;
			} else {
			  dist = -dist;
			}
		  }, 1000);
		}
		window.addEventListener('load', function() {wobble()});
		 var lFollowX = 0,
		lFollowY = 0,
		x = 0,
		y = 0,
		friction = 1 / 30;
		function animate() {
		  x += (lFollowX - x) * friction;
		  y += (lFollowY - y) * friction;
		  //translate = 'translate(' + x + 'px, ' + y + 'px) scale(1.1)';
		 //  $('img').css({
			// '-webit-transform': translate,
			// '-moz-transform': translate,
			// 'transform': translate
		 //  });
		  window.requestAnimationFrame(animate);
		}
		$(window).on('mousemove click', function(e) {
    	  var lMouseX = Math.max(-100, Math.min(100, $(window).width() / 2 - e.clientX));
		  var lMouseY = Math.max(-100, Math.min(100, $(window).height() / 2 - e.clientY));
		  lFollowX = (20 * lMouseX) / 100; // 100 : 12 = lMouxeX : lFollow
		  lFollowY = (10 * lMouseY) / 100;
		});
		animate();
		
		// Banner Full Height JS
        // $(window).on("load resize",function(){
        //     $winHeight = $(this).height();
        //     $(".banner.full").css("height",$winHeight );
        // });
	   
        // Screenshot Slider JS 
        var swiper = new Swiper('.screenshot-container', {
            pagination: '.swiper-pagination',
            slidesPerView: 4,
            paginationClickable: true,
            spaceBetween: 30,
            grabCursor: true,
            breakpoints: {
            1150: {
                slidesPerView: 5,
                
            },
            1023: {
                slidesPerView: 4,
                
            },
            767: {
                slidesPerView: 3,
                
            },
            480: {
                slidesPerView: 1,
                spaceBetween: 30
                
            },
            350: {
                slidesPerView: 1,
                spaceBetween: 30
                
            },
            420: {
                slidesPerView: 1,
                spaceBetween: 30
                
            },
            639: {
                slidesPerView: 2,
                
            }
        }
        });
		
		 // Case study Full Height JS
        // $(window).on("load resize",function(){
        //     $winHeight = $(this).height();
        //     $(".case-study-slider").css("height",$winHeight - "115" );
        // });
    
        // Case Study Style Two main Slider
        jQuery(document).ready(function($) {
            var ocClientsFull = $("#case-study");
            ocClientsFull.owlCarousel({
                items: 1,
                itemsDesktop : [970,1],
                margin: 0,                                
                padding: 0,
                loop: true,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                autoplay: true,
                autoplayHoverPause: false,
                dots: false,
                navRewind: false,
                responsive:{
                    0:{ items:1 },
                    480:{ items:1 },
                    768:{ items:1 },
                    992:{ items:1 },
                    1200:{ items:1 },
                    1400:{ items:1 }
                }
            });
        });
		
		 // Sidebar Navigation
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        $(document).ready(function(){
            $('#nav-icon1,#nav-icon2,#nav-icon3,#nav-icon4').click(function(){
                $(this).toggleClass('open');
            });
        });

        // Preloader js 
        if ( $('.preloader-container').length ) {
            $('body').jpreLoader({
                splashID: "#preloader-container",
                loaderVPos: '70%'
            });
        };

       
		//Project Slider
        jQuery(document).ready(function($) {
            var ocClientsFull = $("#rp-slider-style-one");
            ocClientsFull.owlCarousel({
                items: 1,
                center: true,
                stagePadding: 250,
                loop: true,
                margin: 50,
                nav: true,
                video: true,
                dots: false,
                navText: ["<span class='fa fa-angle-left'></span>", "<span class='fa fa-angle-right'></span>"],
                responsive: {
                    0: {
                        stagePadding: 20
                    },
                    600: {
                        stagePadding: 120
                    },
                    1000: {
                        stagePadding: 250
                    }
                }
                // }).animate({
                //     'opacity': 1
                // }, 600)
            });

        });
		
		// Testimonial Style 1 Carousal 
        jQuery(document).ready(function($)
        {
            var ocClients = $("#rp-testimonial");
            ocClients.owlCarousel({
                items: 1,
                margin:0,
                nav: false,
                     navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                dots: true,
                navRewind: true,
                responsive:
                {
                    0:{ items:1 },
                    480:{ items:1 },
                    768:{ items:1 },
                    1000:{ items:1 },
                    1200:{ items:1 }
                }
        	});
        });
    	
    	// Testimonial Style 2 Carousal 
        jQuery(document).ready(function($)
        {
            var ocClients = $("#rp-testimonial1");
            ocClients.owlCarousel({
                items: 1,
                margin:0,
                nav: false,
                     navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                dots: true,
                navRewind: true,
                responsive:
                {
                    0:{ items:1 },
                    480:{ items:1 },
                    768:{ items:1 },
                    1000:{ items:1 },
                    1200:{ items:1 }
                }
        	});
        });
    	
    	// Testimonial Style 3 Carousal 
        $('.rp-testimonial-center').slick({
		  centerMode: true,
		  dots: true,
		  arrows: false,
		  centerPadding: '0',
		  slidesToShow: 3,

		  responsive: [
		    {
		      breakpoint: 920,
		      settings: {
		        arrows: false,
		        centerMode: true,
		        centerPadding: '0',
		        slidesToShow: 2
		      }
		    },
		    {
		      breakpoint: 767,
		      settings: {
		        arrows: false,
		        centerMode: true,
		        centerPadding: '0',
		        slidesToShow: 1
		      }
		    }
		  ]
		});
	  	

	  	// Testimonial Style 5 
		var galleryTop = new Swiper('.gallery-top', {
	        nextButton: '.swiper-button-next',
	        prevButton: '.swiper-button-prev',
	        spaceBetween: 40,
	        loop:true,
            grabCursor: true,
	        loopedSlides: 10,   
			breakpoints: {
	        1024: {
                slidesPerView: 1,
                spaceBetween: 40
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 30
            },
            640: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
	    });
	    var galleryThumbs = new Swiper('.gallery-thumbs', {
	        spaceBetween: 40,
	        slidesPerView: 10,
	        touchRatio: 0.2,
	        loop:true,
	        loopedSlides: 10, 
            grabCursor: true,
	        slideToClickedSlide: true,
	        breakpoints: {
            1150: {
                slidesPerView: 9,
                
            },
            1023: {
                slidesPerView: 8,
                
            },
            767: {
                slidesPerView: 6,
                
            },
            480: {
                slidesPerView: 5,
                spaceBetween: 20
                
            },
            350: {
                slidesPerView: 3,
                spaceBetween: 20
                
            },
            420: {
                slidesPerView: 3,
                spaceBetween: 20
                
            },
            639: {
                slidesPerView: 4,
                
            }
        }
	    });
	    galleryTop.params.control = galleryThumbs;
	    galleryThumbs.params.control = galleryTop;
    

    	// Testimonial Style 5  ( Dark background ) 
		var galleryTopdemo2 = new Swiper('.gallery-top-demo2', {
	        nextButton: '.swiper-button-next',
	        prevButton: '.swiper-button-prev',
	        spaceBetween: 10,
	        loop:true,
            grabCursor: true,
	        loopedSlides: 10,  
	        breakpoints: {
            1024: {
                slidesPerView: 1,
                spaceBetween: 40
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 30
            },
            640: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        } 
	    });
	    var galleryThumbsdemo2 = new Swiper('.gallery-thumbs-demo2', {
	        spaceBetween: 40,
	        slidesPerView: 10,
	        touchRatio: 0.2,
	        loop:true,
	        loopedSlides: 10, 
            grabCursor: true,
	        slideToClickedSlide: true,
	        breakpoints: {
            1150: {
                slidesPerView: 9,
                
            },
            1023: {
                slidesPerView: 8,
                
            },
            767: {
                slidesPerView: 6,
                
            },
            480: {
                slidesPerView: 3,
                
            },
            639: {
                slidesPerView: 4,
                
            }
        }
	    });
	    galleryTopdemo2.params.control = galleryThumbsdemo2;
	    galleryThumbsdemo2.params.control = galleryTopdemo2;
    	

    	// Testimonial Style 6
        jQuery(document).ready(function($)
        {
            var ocClients = $("#rp-testimonial2");
            ocClients.owlCarousel({
                items: 3,
                margin:0,
                nav: false,
                     navText: [''],
                dots: false,
                navRewind: true,
                responsive:
                {
                    0:{ items:1 },
                    480:{ items:1 },
                    768:{ items:2 },
                    1000:{ items:3 },
                    1200:{ items:3 }
                }
        	});
        });
		
		
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-7243260-2']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		  
		  /*$(function() {
				Grid.init();
			}); */
			
			
			 // HORIZONTAL PROGRESS BAR
			(function(){
				'use strict';
				$(window).on('load', function(){    
					if ( $('.h-progress').length ) {
						$('.h-progress .progress-bar').each(function(){
							var $this = $(this),
								percentage = $this.find('.percentage');

							$this.appear(function(){
								$this.width( percentage.text() + '%' );
								percentage.countTo({ speed: 1500, to: percentage.text(), refreshInterval: 20 })
							});
						});
					};

					
					// VERTICAL PROGRESS BAR
					if ( $('.v-progress').length ) {
						$('.v-progress .progress-bar').each(function(){
							var $this = $(this),
								percentage = $this.find('.percentage');

							$this.appear(function(){
								$this.height( percentage.text() + '%' );
								percentage.countTo({ speed: 1500, to: percentage.text(), refreshInterval: 20 })
							});
						});
					};

				}); 
		})();
		
		
		//split slider
		// $(document).ready(function() {
		// 	$('#myContainer').multiscroll({
		// 		sectionsColor: [],
		// 		anchors: ['first', 'second', 'third' ,'forth', 'fifth'],
		// 		menu: '#menu',
		// 		navigation: true,
		// 		navigationTooltips: [],
		// 		loopBottom: true,
		// 		loopTop: true,
		// 		sectionSelector: '.section',
		// 		leftSelector: '.left',
		// 		rightSelector: '.right',
		// 	});
		// });
		
		// Count Down JS
		$('#countdown-3').timeTo({
			timeTo: new Date(new Date('Tue Dec 25 2017 09:00:00 GMT+0530 (India Standard Time)')),
			displayDays: 2,
			theme: "white",
			displayCaptions: true,
			fontSize: 48,
			captionSize: 14
		});
		
		 // Count Down JS
		$('#countdown-4').timeTo({
			timeTo: new Date(new Date('Tue Dec 25 2017 09:00:00 GMT+0530 (India Standard Time)')),
			displayDays: 2,
			theme: "white",
			displayCaptions: true,
			fontSize: 48,
			captionSize: 14
		});
			 

		 // Count Down JS
		$('#countdown-5').timeTo({
			timeTo: new Date(new Date('Tue Dec 25 2017 09:00:00 GMT+0530 (India Standard Time)')),
			displayDays: 2,
			theme: "white",
			displayCaptions: true,
			fontSize: 48,
			captionSize: 14
		});		

		// Count Down JS
		$('#countdown-6').timeTo({
			timeTo: new Date(new Date('Tue Dec 25 2017 09:00:00 GMT+0530 (India Standard Time)')),
			displayDays: 2,
			theme: "white",
			displayCaptions: true,
			fontSize: 48,
			captionSize: 14
		});	

		// Count Down JS
		$('#countdown-7').timeTo({
			timeTo: new Date(new Date('Tue Dec 25 2017 09:00:00 GMT+0530 (India Standard Time)')),
			displayDays: 2,
			theme: "white",
			displayCaptions: true,
			fontSize: 48,
			captionSize: 14
		});
		
		
		
		// Vertical Timeline JS 
		jQuery(document).ready(function($){
		var timelineBlocks = $('.rp-timeline-block'),
			offset = 0.8;
		//hide timeline blocks which are outside the viewport
		hideBlocks(timelineBlocks, offset);
		//on scolling, show/animate timeline blocks when enter the viewport
		$(window).on('scroll', function(){
			(!window.requestAnimationFrame) 
				? setTimeout(function(){ showBlocks(timelineBlocks, offset); }, 100)
				: window.requestAnimationFrame(function(){ showBlocks(timelineBlocks, offset); });
		});
		function hideBlocks(blocks, offset) {
			blocks.each(function(){
				( $(this).offset().top > $(window).scrollTop()+$(window).height()*offset ) && $(this).find('.rp-timeline-img, .rp-timeline-content').addClass('is-hidden');
			});
		}
		function showBlocks(blocks, offset) {
			blocks.each(function(){
				( $(this).offset().top <= $(window).scrollTop()+$(window).height()*offset && $(this).find('.rp-timeline-img').hasClass('is-hidden') ) && $(this).find('.rp-timeline-img, .rp-timeline-content').removeClass('is-hidden').addClass('bounce-in');
			});
		}
		});
		
	
		// calender JS 
		$('#demo').dcalendarpicker();
		$('#calendar-demo').dcalendar();
		
		
		// carousal js 
        jQuery(document).ready(function($) {
            var ocClientsFull = $("#rp-clients-full");
            ocClientsFull.owlCarousel({
                items: 1,
                itemsDesktop : [970,1],
                margin: 59,                                
                padding: 80,
                loop: true,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                autoplay: true,
                autoplayHoverPause: false,
                dots: false,
                navRewind: false,
                responsive:{
                    0:{ items:1 },
                    480:{ items:1 },
                    768:{ items:1 },
                    992:{ items:1 },
                    1200:{ items:1 },
                    1400:{ items:1 }
                }
            });
        });
		
		// preloader
		$(window).load(function(){
			$('#preloader').fadeOut('slow',function(){$(this).remove();});
		});
		
})(jQuery);
