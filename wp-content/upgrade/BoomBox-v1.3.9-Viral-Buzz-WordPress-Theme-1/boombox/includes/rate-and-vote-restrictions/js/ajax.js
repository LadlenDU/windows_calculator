(function ($) {
    "use strict";

    var boombox_body = $('body');
    /**
     * Points
     */
    boombox_body.on(clickEventType, '.js-post-point .point-btn', function (e) {
        e.preventDefault();
        var _this               = $(this);
        var action              = _this.data( 'action' );
        var post_id             = _this.closest( '.js-post-point' ).data( 'post_id' );
        var container           = $( '.js-post-point[data-post_id=' + post_id + ']' );
        var mobile_container    = container.siblings( '.mobile-info' );
        _this           = container.find( '.point-btn[data-action=' + action + ']' );

        if (!post_id) {
            return;
        }

        _this.attr( 'disabled', 'disabled' );
        container.find( '.count').addClass( 'loading' );

        if ( _this.hasClass( 'active' ) ) {
            _this.removeClass( 'active' );
            $.post(
                boombox_ajax_params.ajax_url,
                {
                    action      : 'boombox_ajax_point_discard',
                    sub_action  : action,
                    id          : post_id
                },
                function ( response ) {
                    var data = $.parseJSON( response );
                    if ( data.status == true ) {
                        container.find( '.count .text' ).text( data.point_count );
                        mobile_container.find( '.mobile-votes-count').text( data.point_count );
                    }
                    container.find( '.count').removeClass( 'loading' );
                   _this.removeAttr( 'disabled' );
                }
            );
        } else {
            container.find( '.active' ).removeClass( 'active' );
            _this.addClass( 'active' );
            $.post(
                boombox_ajax_params.ajax_url,
                {
                    action      : 'boombox_ajax_point',
                    sub_action  : action,
                    id          : post_id
                },
                function ( response ) {
                    var data = $.parseJSON( response );
                    if ( data.status == true ) {
                        container.find( '.count .text' ).text( data.point_count );
                        mobile_container.find( '.mobile-votes-count').text( data.point_count );
                    }
                    container.find( '.count').removeClass( 'loading' );
                    _this.removeAttr( 'disabled' );
                }
            );
        }
    });

    /**
     * Reactions
     */
    boombox_body.on(clickEventType, '.js-reaction-item .reaction-vote-btn', function (e) {
        e.preventDefault();
        var disabled_class = 'disabled';
        var _this            = $(this);
        if( _this.hasClass( disabled_class ) ){
            return;
        }
        _this.addClass( disabled_class );
        _this.parent().addClass( 'voted' );

        var reaction     = _this.closest( '.reaction-item' ).data( 'reaction_id' );
        var container       = _this.closest( '.reaction-sections' );
        var post_id         = container.data( 'post_id' );

        if ( !post_id || !reaction ) {
            return;
        }

        $.post(
            boombox_ajax_params.ajax_url,
            {
                action      : 'boombox_ajax_reaction_add',
                post_id     : post_id,
                reaction_id : reaction
            },
            function ( response ) {
                _this.removeClass( disabled_class );
                var data = $.parseJSON( response );
                if ( data.status == true ) {
                    container.find( '.reaction-item' ).each( function(){
                        var reaction_id = $( this ).data( 'reaction_id' );

                        var reaction_total = data.reaction_total[ reaction_id ];
                        if( reaction_total ){
                            $( this ).find( '.reaction-stat' ).height( reaction_total.height + '%' );
                            $( this ).find( '.reaction-stat-count' ).text( reaction_total.total );
                        }

                        var reaction_restriction = data.reaction_restrictions[ reaction_id ];
                        if( reaction_restriction && false === reaction_restriction.can_react ){
                            $( this ).find( '.reaction-vote-btn' ).addClass( disabled_class );
                        }
                    } );
                }
            }
        );
    });

    /**
     * Track single post views
     */
    if( parseInt( boombox_ajax_params.track_view ) ) {

        var post_id = $('article.single').data('post-id');
        if( post_id ) {

            $.post(
                boombox_ajax_params.ajax_url,
                {
                    action: 'boombox_ajax_track_view',
                    post_id: post_id
                },
                function (response) {}
            );
        }
    }

})(jQuery);