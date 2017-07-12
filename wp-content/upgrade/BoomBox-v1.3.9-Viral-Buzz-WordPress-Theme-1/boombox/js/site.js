(function ($) {
    "use strict";

    /** Variables */
    // available variables html, windowWidth, windowHeight, clickEventType


    /** Functions */

        // add main navigation to init
    initMainNavigation($('.main-navigation'));



    // Sidebar first widget

    $('#secondary .widget:first,#secondary-container .widget:first').addClass('first');


    /** Plugins  */

    $.fn.fitText = function () {

        return this.each(function () {

            var $this = $(this),
                style = $this.css('font-size'),
                fontSize = parseFloat(style);

            //  resize items based on the object width
            for (var i = fontSize; i > 3; i--) {

                $this.css('font-size', i);

                if ($this.width() <= $this.parent().width()) break;
            }
        });
    };

    // $(".badge-text .badge .text,.badge-text-angle .badge .text,.no-svg  .badge .text").fitText();


    if ($('.fixed-next-page').length) {
        var target = $('#header'),
            offset = target.height();

        $(window).scroll(function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop >= offset) {
                $('.fixed-next-page').addClass('active');
            } else {
                $('.fixed-next-page').removeClass('active');
            }
        });
    }


    //Featured Carousel

    if ($(".featured-carousel").length) {

        $(".featured-carousel.big-item").slick({
            infinite: false,
            slidesToShow: 6,
            slidesToScroll: 2,
            rtl: isRTL,
            responsive: [
                {
                    breakpoint: 1000,
                    settings: {
                        arrows: false,
                        slidesToShow: 4,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        arrows: true,
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 0,
                    settings: {
                        arrows: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
        $(".featured-carousel.small-item").slick({
            infinite: false,
            slidesToShow: 8,
            slidesToScroll: 2,
            rtl: isRTL,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 1000,
                    settings: {
                        arrows: false,
                        slidesToShow: 4,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        arrows: true,
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 0,
                    settings: {
                        arrows: true,
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }


    // Popups
    $('.js-inline-popup').fancybox({
        padding: 0
    });


    // Post Featured Video autoplay
    if (html.hasClass('video')) {
        $('.post-thumbnail video').not('.gif-video').each(function () {
            var video = $(this)[0];
            featuredVideo(video);
        });
    }

    function featuredVideo(video) {


        var $videoWrapper = $(video).parent(),
            autoPause = true,
            canPlay = true;

        if (!isMobile) {
            var videoView = new Waypoint.Inview({
                element: video,
                entered: function () {
                    if (canPlay) {
                        $videoWrapper.addClass('play');
                        video.play();
                        // console.log("play")
                    }

                },
                exited: function () {
                    if (canPlay) {
                        setTimeout(function () {
                            video.pause();
                            // console.log("pause")
                        }, 150);

                    }
                }
            });

            $videoWrapper.find('.icon-volume').on(clickEventType, function () {
                $(video).prop('controls', true);
                $(video).prop('muted', false);
                $(this).hide();
                canPlay = false;
                return false;
            });

        } else {
            $videoWrapper.on(clickEventType, function () {
                $videoWrapper.addClass('play');
                video.play();
                $(video).prop('controls', true);
                $(video).prop('muted', false);
                $videoWrapper.find('.icon-volume').hide();
                return false;
            });
        }
    }

    // Post GIF play on scroll & click

    function GIFimage() {

        if(isMobile &&  (boombox_gif_event = 'hover')){
           var  boombox_gif_event = 'click';
        }

        $('.single .single.post img[src*=".gif"],.post-list.standard img[src*=".gif"]').not('.gallery-item img[src*=".gif"], .regif_row_parent img[src*=".gif"]').Hyena({
            "style":1,
            "controls"  :false,
            "on_hover"  : (boombox_gif_event == 'hover'),
            "on_scroll" : (boombox_gif_event == 'scroll')
        });

    }

    GIFimage();

    // Post Featured Video autoplay
    if (html.hasClass('video')) {
        $('.post-thumbnail video').not('.gif-video').each(function () {
            var video = $(this)[0];
            featuredVideo(video);
        });

        $(' video.gif-video').each(function () {
            var video = $(this)[0];
            GIFvideo(video);
        });

        $(' img.gif-image').each(function () {
            var img = $(this)[0];
            GIFtoVideo(img);
        });
    }


    function GIFvideo(video) {

        if(isMobile){
           var  boombox_gif_event = 'click';
        }

        video.pause();

        $(video).attr('width','100%').attr('height','auto');

        var $videoWrapper = $(video).parent(),
            canPlay = true;


        if(isMobile) {
            $(video).attr('webkit-playsinline','webkit-playsinline');
        }
        if(boombox_gif_event == 'hover') {

            $videoWrapper.on('mouseenter touchstart',function(){
                $videoWrapper.addClass('play');
                video.play();

            }).on('mouseleave touchend',function(){
                $videoWrapper.removeClass('play');
                video.pause();
            });

        } else if(boombox_gif_event == 'scroll'){

            var videoView = new Waypoint.Inview({
                element: video,
                entered: function () {
                    if (canPlay) {
                        $videoWrapper.addClass('play');
                        video.play();
                    }

                },
                exited: function () {
                    if (canPlay) {
                        setTimeout(function () {
                            $videoWrapper.removeClass('play');
                            video.pause();
                        }, 150);

                    }
                }
            });
        } else {
            $videoWrapper.on(clickEventType, function (e) {
                e.stopPropagation();
                if(!$videoWrapper.hasClass('play')){
                    video.play();
                    $videoWrapper.addClass('play');
                } else {
                    video.pause();
                    $videoWrapper.removeClass('play');
                }
                return false;
            });
        }
    }

    function GIFtoVideo(img) {

        var $videoWrapper = $(img).parent();
        var imgUrl = $(img).attr('src');

        $videoWrapper.on('click', function () {
           if(!$(this).hasClass('video-done')){

               var videoUrl = $(img).data('video');
               var video = '<video autoplay loop muted width="100%" webkit-playsinline="webkit-playsinline" height="auto" poster="'+ imgUrl +'">' +
                   '<source src='+ videoUrl +' type="video/mp4">'+
                   '</video>';
               $(video).appendTo($videoWrapper);

               $(video)[0].play(); // for IOS

               // For Android
               $(video)[0].addEventListener("loadstart", showVideo, false);
               function showVideo(e) {
                   $(video)[0].play();
               }
               $videoWrapper.find('img').remove();
               $(this).addClass('play');
               $(this).addClass('video-done');
           }
        });

        var videoView = new Waypoint.Inview({
            element: $videoWrapper,
            exited: function () {
               if($videoWrapper.hasClass('video-done')){
                   var img = '<img  src='+ imgUrl +' alt="">';
                   $(img).appendTo($videoWrapper);
                   $videoWrapper.find('video').remove();
                   $videoWrapper.removeClass('play');
                   $videoWrapper.removeClass('video-done');
               }
            }
        });
    }

    if($(".has-full-post-button").length){
        $('.post-list.standard .post-thumbnail img').each(function(){
            fullPostShow($(this));
        });
    }
    function fullPostShow(obj){
        var oW  = obj.attr('width'),
            oH  = obj.attr('height');

        if (oH/oW >= 3){
            obj.parents('.post-thumbnail').addClass('show-short-media');
            obj.parents('.post').addClass('full-post-show');
        }
    }

    /* Youtube Stream */

    if($('#stream-player').length){


        var player, container = $('#video-stream'), videoID = $('#stream-player').data('id') ;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('stream-player', {
                height: '420',
                width: '760',
                videoId: videoID,
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        }
        onYouTubeIframeAPIReady();

        function onPlayerReady(event) {

            container.find('.video-play').on(clickEventType,function(e){
                e.preventDefault();
                event.target.playVideo();
                container.addClass('isPlaying');
            });
        }

        function onPlayerStateChange(event) {}
        function stopVideo() {
            player.stopVideo();
        }

        var activeVideo =  container.find('li.active'),
            pos = activeVideo.position(),
            scrollContainner = document.getElementById("stream-scroll");
        scrollContainner.scrollTop = pos.top;
    }


    /** Events  */

        // Top search toggle
    $(document).on(clickEventType, '.top-search .js-toggle', function (e) {
        e.preventDefault();
        e.stopPropagation();
        var $this = $(this);
        if ($this.parent().hasClass('open')) {
            $this.parent().removeClass('open');
        } else {
            $this.parent().addClass('open');
            setTimeout(function () {
                $this.parent().find('input')[0].focus()
            }, 3000);
        }
    });
    $(document).on(clickEventType, '.top-search,#more-menu,#mobile-navigation', function (e) {
        e.stopPropagation();
    });


    // Body click events
    $(document).on(clickEventType, 'body', function (e) {
        $('.top-search').removeClass('open');
        $('#more-menu-toggle').removeClass('active');
        $('.more-menu-item .more-menu').removeClass('active');
        $('.toggled-on').removeClass('toggled-on');
        if (html.hasClass('main-menu-open')) {
            e.preventDefault();
            html.removeClass('main-menu-open');
        }
    });

    // Main menu open event
    $(document).on(clickEventType, '#menu-button', function (e) {
        e.stopPropagation();
        e.preventDefault();
        html.addClass('main-menu-open');
    });

    // Main menu  close event
    $(document).on(clickEventType, '#menu-close', function (e) {
        e.stopPropagation();
        e.preventDefault();
        html.removeClass('main-menu-open');
    });

    // More menu toggle
    $(document).on(clickEventType, '#more-menu-toggle', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).toggleClass('active');
        $('.more-menu-item .more-menu').toggleClass('active');
    });


    // Animation to page top
    $(document).on(clickEventType, '#go-top', function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll > 500) {
            $('#go-top').addClass('show');
        } else {
            $('#go-top').removeClass('show');
        }

    });


    function StickySocialBox(enebled) {

        var
            sticky = $('#sticky-share-box'),
            offset = 0;


        if ($('.fixed-header').length && !isMobile) {
            if ($('.fixed-top').length) {
                offset = $('.fixed-top .top').outerHeight(true);
            } else if ($('.fixed-bottom').length) {
                offset = $('.fixed-bottom .bottom').outerHeight(true);
            } else if($('.fixed-both').length){
                offset = $('.fixed-both').outerHeight(true);
            }
        } else if ($('.fixed-next-page').length) {
            offset = $('.fixed-next-page').outerHeight(true);
        }

        if (!enebled) {
            var StickyActive = new Waypoint.Sticky({
                element: sticky[0],
                offset: offset
            });
        }

        var stickyParent = sticky.parent('.sticky-wrapper'),
            stickyWidth = stickyParent.outerWidth();
        sticky.removeAttr('style');
        sticky.css({
            'width': stickyWidth,
            'top': offset + 'px',
        });
    }

    if ($('#sticky-share-box').length) {
        StickySocialBox(false);
    }


    //var StickySidebar;
    var
        STfooter = $('#sticky-border'),
        STstickyHeight = 1,
        STborderOffset = STfooter.offset().top,
        SToffset = 25;

    function StickySidebar(enebled, obj) {

       if($('#secondary').outerHeight(true) < $('#main').outerHeight(true)){

           var STsticky = $(obj);

           STfooter = $('#sticky-border'),
               STstickyHeight = STsticky.innerHeight();
                STborderOffset = STfooter.offset().top,
               SToffset = 25;

           if ($('.fixed-header').length) {
               if ($('.fixed-top').length) {
                   SToffset = $('.fixed-top .top').outerHeight(true) + 25
               } else if ($('.fixed-bottom').length) {
                   SToffset = $('.fixed-bottom .bottom').outerHeight(true) + 25
               } else {
                   SToffset = $('.fixed-both').outerHeight(true) + 25
               }

           } else if ($('.fixed-next-page').length) {
               SToffset = $('.fixed-next-page').outerHeight(true) + 25;
           }

           if (!enebled) {
               var StickyActive = new Waypoint.Sticky({
                   element: STsticky[0],
                   offset: SToffset
               });
           }

           var stickyParent = STsticky.parent('.sticky-wrapper'),
               stickyWidth = stickyParent.outerWidth();

           STsticky.removeAttr('style');

           STsticky.css({
               'width': stickyWidth,
               'top': SToffset + 'px'
           });

           $(window).scroll(function () {
               var scrollTop = $(window).scrollTop();
               STborderOffset = STfooter.offset().top;

               if (scrollTop >= (STborderOffset - STstickyHeight - SToffset)) {

                   STsticky.css({
                       'position': 'absolute',
                       'bottom': 0,
                       'top':'inherit',
                       'width': stickyWidth
                   });
               } else {
                   STsticky.removeAttr('style');
                   STsticky.css({
                       'width': stickyWidth,
                       'top': SToffset + 'px'
                   });
               }
           })
       }
    }

    function StickyContent(obj) {
        var sticky = $(obj),
            next = sticky.nextAll('.widget');
        $(next).appendTo(sticky);
    }

    if ($('#load-more-button').length) {

        var
            load_more_btn = $('#load-more-button'),
            loading = false,
            firstClick = false,
            loadType = load_more_btn.data('scroll');


        $('#load-more-button').on(clickEventType, function () {
            if (loading) return;

            loading = true;

            var next_page_url = load_more_btn.attr('data-next_url');

            load_more_btn.parent().addClass('loading');
            jQuery.post(next_page_url, {},
                function (response) {
                    var html = $(response),
                        container = html.find('#post-items'),
                        articles = container.find('article').addClass('item-added'),
                        more_btn = html.find('#load-more-button');

                    $('#post-items').append(articles);

                    var index = 0;
                    $('.item-added').each(function () {
                        $(this).find('img').on('load', function () {
                            index++;

                            if (index == $('.item-added img').length - 1) {
                                if ($('#secondary .sticky-sidebar,#secondary-container .sticky-sidebar').length && !isMobile) {
                                    StickySidebar(true, '.sticky-sidebar');
                                }

                                // Post GIF play on scroll & click

                                $('.post-list.standard .item-added  img[src*=".gif"]').Hyena({
                                    "style":1,
                                    "controls"  :false,
                                    "on_hover"  : (boombox_gif_event == 'hover'),
                                    "on_scroll" : (boombox_gif_event == 'scroll')
                                });

                                $('#post-items  .item-added').removeClass('item-added');
                            }
                        });
                    });
                    if ($('#secondary .sticky-sidebar,#secondary-container .sticky-sidebar').length && !isMobile) {
                        StickySidebar(true, '.sticky-sidebar');
                    }
                    // Post Featured Video autoplay
                    if ($("html").hasClass('video')) {
                        $('#post-items  .item-added video').not('.gif-video').each(function () {
                            var video = $(this)[0];
                            featuredVideo(video);
                        });
                        $('#post-items  .item-added video.gif-video').each(function () {
                            var video = $(this)[0];
                            GIFvideo(video);
                        });

                        $('#post-items  .item-added img.gif-image').each(function () {
                            var img = $(this)[0];
                            GIFtoVideo(img);
                        });
                    }
                    if($(".has-full-post-button").length){
                        $('.post-list.standard .item-added .post-thumbnail img').each(function(){
                            fullPostShow($(this));
                        });
                    }
                    //$('#post-items  .item-added').removeClass('item-added');

                    load_more_btn.parent().removeClass('loading');

                    if (more_btn.length > 0) {
                        var next_url = more_btn.data('next_url');
                        load_more_btn.attr('data-next_url', next_url);
                    } else {
                        load_more_btn.parent().remove();
                    }

                    loading = false;
                    firstClick = true;
                    if (loadType === 'on_demand' || loadType === 'infinite_scroll') {
                        infiniteScroll();
                    }
                }
            );

        });


        var infiniteScroll = function () {

            if (loadType === 'on_demand' && !firstClick) {
                return false;
            }

            load_more_btn.waypoint(function (direction) {
                if (direction === 'down') {
                    load_more_btn.trigger('click');
                }
            }, {
                offset: '150%'
            });
        }

        if (loadType === 'infinite_scroll') {
            infiniteScroll();
        }

    }


    /** Window Load */
    $(window).load(function () {
        if ($('.sticky-sidebar').length && !isMobile) {

            $('.sticky-sidebar').each(function () {
                StickyContent($(this));
                StickySidebar(false, $(this));
            });

        }

        if ($('.fixed-pagination').length) {
            var target = $('#footer'),
                offset = $('.page-wrapper').innerHeight() - target.height();

            $(window).scroll(function () {
                var scrollTop = $(window).scrollTop();

                if (scrollTop >= offset - 1000) {
                    $('.fixed-pagination').addClass('hide');
                } else {
                    $('.fixed-pagination').removeClass('hide');
                }
            });
        }
        if ($('#sticky-share-box').length) {
            var target = $('#footer'),
                offset = $('.page-wrapper').innerHeight() - target.height();

            $(window).scroll(function () {
                var scrollTop = $(window).scrollTop();

                if (scrollTop >= offset - 1000) {
                    $('#sticky-share-box').addClass('hidden');
                } else {
                    $('#sticky-share-box').removeClass('hidden');
                }
            });
        }

    });


    /** Window Resize */
    $(window).resize(function () {
        if ($('#secondary .sticky-sidebar,#secondary-container .sticky-sidebar').length && !isMobile) {
            StickySidebar(true, '.sticky-sidebar');
            $(window).scroll();
        }
        if ($('#sticky-share-box').length) {
            StickySocialBox(true);
        }
    });


})(jQuery);
