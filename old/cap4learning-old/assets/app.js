import 'bootstrap';
import './scss/main.scss';
import $ from 'jquery';
require('waypoints/lib/noframework.waypoints.js');

const general = {
    "mqBreakpoints": {
        xs: 0,
        sm: 576,
        md: 768,
        lg: 992,
        xl: 1156,
        sxl: 1399,
        xxl: 1580,
    },

    "animationHandler": function() {
        const windowHeight = window.innerHeight;
        let yPxTrigger, yPercentTrigger;

        // Triggering on scroll
        const triggerAnimation = [
            // {
            //     id: 'home-intro',
            //     offsetTop: (1 * window.innerHeight),
            //     revert: false,
            //     handler: function (direction) {
            //         if (direction === 'down') {
            //             document.getElementById('home-intro').classList.add('-active');
            //             document.getElementById('home-intro').classList.add('animate__animated');
            //             document.getElementById('home-intro').classList.add('animate__fadeIn');
            //         }
            //     }
            // },
            {
                id: 'home-search-bar',
                offsetTop: (1 * window.innerHeight),
                revert: false,
                handler: function (direction) {
                    if (direction === 'down') {
                        document.getElementById('home-search-bar').classList.add('-active');
                        document.getElementById('home-search-bar').classList.add('animate__animated');
                        document.getElementById('home-search-bar').classList.add('animate__fadeInUp');
                    }
                }
            },
            {
                id: 'home-training-list',
                offsetTop: (1 * window.innerHeight),
                revert: false,
                handler: function (direction) {
                    if (direction === 'down') {
                        document.getElementById('home-training-list').classList.add('-active');
                        document.getElementById('home-training-list').classList.add('animate__animated');
                        document.getElementById('home-training-list').classList.add('animate__fadeInUp');
                    }
                }
            },
            {
                id: 'home-training-content',
                offsetTop: (1 * window.innerHeight),
                revert: false,
                handler: function (direction) {
                    if (direction === 'down') {
                        document.getElementById('home-training-content').classList.add('-active');
                        document.getElementById('home-training-content').classList.add('animate__animated');
                        document.getElementById('home-training-content').classList.add('animate__fadeInUp');
                    }
                }
            },
            {
                id: 'home-offer-content',
                offsetTop: (0.8 * window.innerHeight),
                revert: false,
                handler: function (direction) {
                    if (direction === 'down') {
                        document.getElementById('home-offer-content').classList.add('-active');
                        document.getElementById('home-offer-content').classList.add('animate__animated');
                        document.getElementById('home-offer-content').classList.add('animate__fadeInUp');
                    }
                }
            },
            {
                id: 'home-offer-listing',
                offsetTop: (0.85 * window.innerHeight),
                revert: false,
                handler: function (direction) {
                    if (direction === 'down') {
                        document.getElementById('home-offer-listing').classList.add('-active');
                        document.getElementById('home-offer-listing').classList.add('animate__animated');
                        document.getElementById('home-offer-listing').classList.add('animate__fadeInRight');
                    }
                }
            },
            {
                id: 'home-newsletter',
                offsetTop: (0.75 * window.innerHeight),
                revert: false,
                handler: function (direction) {
                    if (direction === 'down') {
                        document.getElementById('home-newsletter').classList.add('-active');
                        document.getElementById('home-newsletter').classList.add('animate__animated');
                        document.getElementById('home-newsletter').classList.add('animate__fadeIn');
                    }
                }
            },
            {
                id: 'home-newsletter-img',
                offsetTop: (0.75 * window.innerHeight),
                revert: false,
                handler: function (direction) {
                    if (direction === 'down') {
                        document.getElementById('home-newsletter-img').classList.add('-active');
                        document.getElementById('home-newsletter-img').classList.add('animate__animated');
                        document.getElementById('home-newsletter-img').classList.add('animate__fadeInLeft');
                    }
                }
            },
        ];

        $.each(triggerAnimation, function (key, animation) {
            if ($('#' + animation.id).length){
                if (animation.revert === false) {
                    // Triggering with offset
                    yPxTrigger = $('#' + animation.id).offset().top - animation.offsetTop;
                    yPercentTrigger = '-' + Math.round(yPxTrigger / windowHeight * 100) + '%';
                } else {
                    // Triggering when scroll up and element hidden from screen
                    yPxTrigger = $('#' + animation.id).offset().top - windowHeight + $('#' + animation.id).height();
                    yPercentTrigger = '-' + Math.round(yPxTrigger / windowHeight * 100) + '%';
                }

                window['spyscroll-animation-' + key] = new Waypoint({
                    element: document.getElementById('js-main'),
                    handler: animation.handler,
                    offset: yPercentTrigger
                });
            }
        });


        if (window.pageYOffset === 0) {
            $(window).scroll();
        }

    },

    "buttonHoverHandler": function() {
        let buttons = $('.btn');

        buttons.mouseenter(function(e) {
            const parentOffset = $(this).offset();
            const relX = e.pageX - parentOffset.left;
            const relY = e.pageY - parentOffset.top;
            $(this).prev(".btn-fx-circle").css({"left": relX, "top": relY });
            $(this).prev(".btn-fx-circle").removeClass("desplode-circle");
            $(this).prev(".btn-fx-circle").addClass("explode-circle");

        });

        buttons.mouseleave(function(e) {
            const parentOffset = $(this).offset();
            const relX = e.pageX - parentOffset.left;
            const relY = e.pageY - parentOffset.top;
            $(this).prev(".btn-fx-circle").css({"left": relX, "top": relY });
            $(this).prev(".btn-fx-circle").removeClass("explode-circle");
            $(this).prev(".btn-fx-circle").addClass("desplode-circle");
        });

        let stretchedLink = $('.js-btn-fx-a');

        stretchedLink.mouseenter(function(e) {
            const parentOffset = $(this).offset();
            const relX = e.pageX - parentOffset.left;
            const relY = e.pageY - parentOffset.top;
            $(this).prev(".btn-fx-circle").css({"left": relX, "top": relY });
            $(this).prev(".btn-fx-circle").removeClass("desplode-circle");
            $(this).prev(".btn-fx-circle").addClass("explode-circle");

        });

        stretchedLink.mouseleave(function(e) {
            const parentOffset = $(this).offset();
            const relX = e.pageX - parentOffset.left;
            const relY = e.pageY - parentOffset.top;
            $(this).prev(".btn-fx-circle").css({"left": relX, "top": relY });
            $(this).prev(".btn-fx-circle").removeClass("explode-circle");
            $(this).prev(".btn-fx-circle").addClass("desplode-circle");
        });
    },

    "offersHandler": function() {
        let offers = $('.js-offer-expandable');
        let button = null;

        if (offers.length) {
            offers.each(function(k, v) {
                let $this = $(this);
                $this.on('click', function(e) {
                    if (e.target.matches('svg') || e.target.matches('use')) {
                        $this.removeClass('-center');
                        $this.removeClass('-expand');
                        offers.removeClass('-resized');
                        $this.parent().removeClass('-open')
                    } else {
                        if (!$this.hasClass('-center')) {
                            offers.addClass('-resized');
                            offers.removeClass('-center');
                            offers.removeClass('-expand');
                            $this.removeClass('-resized');
                            $this.addClass('-center');
                            $this.parent().addClass('-open');
                            setTimeout(function() {
                                $this.addClass('-expand');
                            }, 400);
                        }
                    }
                })
            })
        }
    },

    "menuHandler": function() {
        $('.navbar-toggler').on('click', function() {
            $('body').toggleClass('menu-open');
        });

        // if ( !document.getElementById('js-body').classList.contains('js-menu-fixed')){
        //     let waypointText = new Waypoint({
        //         element: document.getElementById('js-main'),
        //         handler: function handler(direction) {
        //             if (direction === 'down') {
        //                 document.getElementById('js-body').classList.add('js-menu-fixed');
        //             } else {
        //                 document.getElementById('js-body').classList.remove('js-menu-fixed');
        //             }
        //         },
        //         // offset: '-10'
        //     });
        // }

        if (document.getElementById('js-body').classList.contains('-transparent')){
            let waypointText = new Waypoint({
                element: document.getElementById('js-main'),
                handler: function handler(direction) {
                    if (direction === 'down') {
                        document.getElementById('js-body').classList.remove('-transparent');
                    } else {
                        document.getElementById('js-body').classList.add('-transparent');
                    }
                },
                offset: '-10'
            });
        }

        let waypointTMobile = new Waypoint({
            element: document.getElementById('js-main'),
            handler: function handler(direction) {
                if (direction === 'down') {
                    document.getElementById('js-body').classList.add('js-menu-mobile-fixed');
                } else {
                    document.getElementById('js-body').classList.remove('js-menu-mobile-fixed');
                }
            },
            offset: '-5%'
        });
    },

    "trainingHandler": function() {
        if (window.innerWidth >= general.mqBreakpoints.sxl) {
            let form = document.getElementById('contact');
            let menu = document.getElementById('js-training-menu');

            let hasScrollAnim = false;
            let hasScroll = false;

            if (form && menu) {
                window.onscroll = function(){
                    let height = form.offsetTop
                    if((window.scrollY + menu.offsetHeight + 80)  >= height) { // change target to number

                        if (!hasScroll) {
                            hasScrollAnim = false;
                        }

                        if (hasScrollAnim) {
                            document.getElementById('js-training-menu').style.position = 'absolute';
                            document.getElementById('js-training-menu').style.bottom = '16px';
                            document.getElementById('js-training-menu').style.top = 'auto';
                        }
                    } else {
                        document.getElementById('js-training-menu').style.position = 'fixed';
                        document.getElementById('js-training-menu').style.bottom = 'unset';
                        document.getElementById('js-training-menu').style.top = 'unset'
                    }
                    hasScroll = true;
                };

                const trigger = new Event('scroll');
                window.dispatchEvent(trigger);
            } else if (menu) {
                let footer = document.getElementById('footer');

                window.onscroll = function(){
                    let height = footer.offsetTop
                    if((window.scrollY + menu.offsetHeight + 230)  >= height) { // change target to number

                        if (!hasScroll) {
                            hasScrollAnim = false;
                        }

                        if (hasScrollAnim) {
                            document.getElementById('js-training-menu').style.position = 'absolute';
                            document.getElementById('js-training-menu').style.bottom = '0';
                            document.getElementById('js-training-menu').style.top = 'auto';
                        }
                    } else {
                        document.getElementById('js-training-menu').style.position = 'fixed';
                        document.getElementById('js-training-menu').style.bottom = 'unset';
                        document.getElementById('js-training-menu').style.top = 'unset'
                    }
                    hasScroll = true;
                };

                const trigger = new Event('scroll');
                window.dispatchEvent(trigger);
            }
        }
    },

    "searchBarHandler": function() {
        const buttonsOpen = document.querySelectorAll('.js-searchbar-opening');
        const buttonClose = document.querySelector('.js-searchbar-closing');

        buttonsOpen.forEach($button => $button.addEventListener('click', (event) => {
            const panel = document.querySelector('#searchbar');
            panel.classList.remove('animate__animated', 'animate__fadeOutRight', 'animate__fadeInRight');
            panel.classList.add('animate__animated', 'animate__fadeInRight');

        }));

        buttonClose.addEventListener('click', () => {
            const panel = document.querySelector('#searchbar');
            panel.classList.add('animate__animated', 'animate__fadeOutRight');
            panel.classList.remove('animate__animated');
        });
    },

    "contactHandler": function() {
        $('.js-select-change').on('click', function() {
            let select = $('#'+$(this).data('select-id'));
            select.find('option[value='+$(this).data('select-option')+']').attr('selected','selected');
        })
    },

    "sessionSlotHandler": function() {
        $('.js-training-slot-btn').on('click', function() {
            $(this).toggleClass('active');
            $('.js-training-slot-wrapper').toggleClass('active');
        })
    }
};
export default general;

(function($){
    $(document).ready(function () {
        general.buttonHoverHandler();
        general.animationHandler();
        general.offersHandler();
        general.trainingHandler();
        general.searchBarHandler();
        general.contactHandler();
        general.menuHandler();
        general.sessionSlotHandler();
    });
})($);
