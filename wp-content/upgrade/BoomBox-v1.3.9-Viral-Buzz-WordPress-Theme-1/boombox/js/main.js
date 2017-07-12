
/** GLOBAL Variables */

var isMobile;
var html;
var windowWidth;
var windowHeight;
var isRTL = false;
var clickEventType = ((document.ontouchstart !== null) ? 'click' : 'touchstart');


(function ($) {
    "use strict";

    html = $('html');

    /** Detect Device Type */
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        isMobile = true;
        html.addClass('mobile');
    } else {
        isMobile = false;
        html.addClass('desktop');
    }

    if($('body').hasClass('rtl')){
        isRTL = true;
    }


    function setSize(){
        windowWidth = $(window).width();
        windowHeight = $(window).height();
        $('.wh').css('height', windowHeight +'px');
        $('.min-wh').css('min-height', windowHeight +'px');
        $('.error404 .page-wrapper').css('min-height', windowHeight);

        var topWidth = $('.page-wrapper').width(),
            bottomWidth = $('.page-wrapper').width();

        $('#video-stream .viewport').css('height',$('#video-stream .video-wrapper').height());

        $('#header .top').css('width',topWidth);
        $('#header .bottom').css('width',bottomWidth);
    }
    setSize();

    function headerAlign() {
        // Header items vertical alignment

        var topHeight = $('#header .top').height(),
            bottomHeight = $('#header .bottom').height();

        $('#header .top .container > *,#header .top .mobile-box > *').each(function(){
            var elementHeight = $(this).innerHeight();
            $(this).css({
                'top': (topHeight-elementHeight)/2 +'px',
                'opacity': 1
            });
        });
        $('#header .top .navigation-box .wrapper > *').each(function(){
            var elementHeight = $(this).innerHeight();
            $(this).css({
                'top': (topHeight-elementHeight)/2 +'px'
            });
        });
        $('#header .bottom .container > *,#header .bottom .mobile-box > *').each(function(){
            var elementHeight = $(this).innerHeight();
            $(this).css({
                'top': (bottomHeight-elementHeight)/2 +'px',
                'opacity': 1
            });
        });
        $('#header .bottom .navigation-box .wrapper > *').each(function(){
            var elementHeight = $(this).innerHeight();
            $(this).css({
                'top': (bottomHeight-elementHeight)/2 +'px'
            });
        });
    }
    headerAlign();


    /** Tabs */
    var tabActive = $('.tabs-menu>li.active');
    if( tabActive.length > 0 ){
        for (var i = 0; i < tabActive.length; i++) {
            var tab_id = $(tabActive[i]).children().attr('href');

            $(tab_id).addClass('active').show();
        }
    }

    $('.tabs-menu a').on(clickEventType, function(e){
        var tab = $(this);
        var tab_id = tab.attr('href');
        var tab_wrap = tab.closest('.tabs');
        var tab_content = tab_wrap.find('.tab-content');

        tab.parent().addClass("active");
        tab.parent().siblings().removeClass('active');
        tab_content.not(tab_id).removeClass('active').hide();
        $(tab_id).addClass('active').fadeIn(500);

        e.preventDefault();
    });


    /** Window Load */
    $(window).load(function () {
        setSize();
        headerAlign();

        if(!isMobile && $('.fixed-header').length) {
            if ($('.fixed-top').length && $('.no-top').length < 1) {
                var StickyTop = new Waypoint.Sticky({
                    element: $('.fixed-top .top')[0]
                });
            } else if ($('.fixed-bottom').length && $('.no-bottom').length < 1) {
                var StickyBottom = new Waypoint.Sticky({
                    element: $('.fixed-bottom .bottom')[0]
                });
            } else if ($('.fixed-both').length){
                var StickyHeader = new Waypoint.Sticky({
                    element: $('.fixed-both')[0]
                });
            }
        }

        html.addClass('page-loaded');
    });

    /** Window Resize */
    $(window).resize(function () {
        setSize();

        if(this.resizeTO) clearTimeout(this.resizeTO);
        this.resizeTO = setTimeout(function() {
            $(this).trigger('resizeEnd');
        }, 100);
    });


    $(window).bind('resizeEnd', function() {
        headerAlign();
    });

})(jQuery);

function initMainNavigation(container) {

    // Add dropdown toggle that displays child menu items.
    var dropdownToggle = jQuery('<button />', {
        'class': 'dropdown-toggle'
    });

    container.find('.menu-item-has-children > a').after(dropdownToggle);

    container.find('.dropdown-toggle').on(clickEventType, function (e) {
        var _this = jQuery(this);

        e.preventDefault();
        e.stopPropagation();
        _this.parent().parent().find('.toggled-on').removeClass('toggled-on');
        _this.toggleClass('toggled-on');
        _this.next('.children, .sub-menu').toggleClass('toggled-on');
    });
}
