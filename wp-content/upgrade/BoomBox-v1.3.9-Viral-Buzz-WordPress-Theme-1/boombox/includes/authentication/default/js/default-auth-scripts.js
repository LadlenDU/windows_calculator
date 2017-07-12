jQuery(function ($) {
    'use strict';

    var boombox_login_form             = $( 'form#boombox-login' );
    var boombox_register_form          = $( 'form#boombox-register' );
    var boombox_forgot_password_form   = $( 'form#boombox_forgot_password' );
    var boombox_login_form_captcha     = null;
    var boombox_register_form_captcha  = null;

    $.validator.addMethod("loginRegex", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-\_]+$/i.test(value);
    } );

    //authentication Popup
    $('.js-authentication').fancybox({
        padding:0,
        beforeShow: function(){
            var is_nsfw = $( this.element ).hasClass('entry-nsfw');
            if ( boombox_login_form.length > 0 ) {
                if( is_nsfw ){
                    boombox_login_form.closest( '.authentication').addClass( 'is-nsfw-auth' );
                }
                boombox_login_form[0].reset();
                boombox_login_form.find( '.error' ).removeClass( 'error' );
                boombox_login_form.find( '.status' ).text( '' );
                if( ajax_auth_object.enable_login_captcha ) {
                    if( ajax_auth_object.captcha_type === 'image' ) {
                        boombox_refresh_captcha(boombox_login_form, boombox_login_form.attr('action'));
                    } else {
                        var login_captcha_container = boombox_login_form.find( '#boombox-login-captcha' );
                        if( boombox_login_form_captcha === null ) {
                            boombox_login_form_captcha = grecaptcha.render( login_captcha_container.attr('id'), {
                                sitekey : login_captcha_container.data('sitekey'),
                                theme   : 'light'
                            });
                        } else {
                            grecaptcha.reset( boombox_login_form_captcha );
                        }
                    }
                }
            }
            if ( boombox_register_form.length > 0 ) {
                if( is_nsfw ){
                    boombox_login_form.closest( '.authentication').addClass( 'is-nsfw-auth' );
                }
                boombox_register_form[0].reset();
                boombox_register_form.find( '.error' ).removeClass( 'error' );
                boombox_register_form.find( '.status' ).text( '' );
                if( ajax_auth_object.enable_registration_captcha ) {
                    if( ajax_auth_object.captcha_type === 'image' ) {
                        boombox_refresh_captcha(boombox_register_form, boombox_register_form.attr('action'));
                    } else {
                        var register_captcha_container = boombox_register_form.find( '#boombox-register-captcha' );
                        if( boombox_register_form_captcha === null ) {
                            boombox_register_form_captcha = grecaptcha.render( register_captcha_container.attr('id'), {
                                sitekey : register_captcha_container.data('sitekey'),
                                theme   : 'light'
                            });
                        } else {
                            grecaptcha.reset( boombox_register_form_captcha );
                        }
                    }
                }
            }
            if ( boombox_forgot_password_form.length > 0 ) {
                boombox_forgot_password_form[0].reset();
                boombox_forgot_password_form.find( '.error' ).removeClass( 'error' );
                boombox_forgot_password_form.find( '.status' ).text( '' );
            }
        }
    });

    /**
     * Client side form validation
     */
    if ( boombox_register_form.length > 0 ){
        boombox_register_form.validate(
            {
                rules: {
                    "signonusername": {
                        loginRegex: true
                    },
                    password2: {
                        equalTo: '#signonpassword'
                    }
                },
                errorPlacement: function( error, element ) {}
            }
        );
    }
    if ( boombox_login_form.length > 0 ){
        boombox_login_form.validate(
            {
                errorPlacement: function( error, element ) {}
            }
        );

    }
    if ( boombox_forgot_password_form.length > 0 ){
        boombox_forgot_password_form.validate(
            {
                errorPlacement: function( error, element ) {}
            }
        );
    }

    /**
     * Perform AJAX login on form submit
     */
    boombox_login_form.on( 'submit', function (e) {
        if ( ! $( this ).valid() )
            return false;

        var _this        = $( this );
        var user_email   = _this.find( '[name="useremail"]' ).val();
        var password     = _this.find( '[name="password"]' ).val();
        var security     = _this.find( '[name="security"]' ).val();
        var is_nsfw_auth = _this.closest( '.authentication').hasClass( 'is-nsfw-auth' );
        var redirect_url = ajax_auth_object.login_redirect_url;
        var data = {
            action      : 'boombox_ajax_login',
            useremail   : user_email,
            password    : password,
            security    : security
        }
        if( ajax_auth_object.enable_login_captcha ) {
            if( ajax_auth_object.captcha_type === 'image' ) {
                data.captcha = _this.find('[name="captcha-code"]').val();
            } else if( ajax_auth_object.captcha_type === 'google' ) {
                data.captcha = _this.find( '[name="g-recaptcha-response"]' ).val();
            }
        }

        _this.parent().find( 'p.status').show().text( ajax_auth_object.loading_message );

        $.post(
            ajax_auth_object.ajaxurl,
            data,
            function ( response ) {
                var data = $.parseJSON( response );
                _this.parent().find( 'p.status').show().text( data.message );
                if ( data.loggedin == true ) {
                    if( is_nsfw_auth ){
                        redirect_url = ajax_auth_object.nsfw_redirect_url;
                    }
                    document.location.href = redirect_url;
                }else{
                    if( ajax_auth_object.enable_login_captcha ) {
                        if( ajax_auth_object.captcha_type === 'image' ) {
                            boombox_refresh_captcha(_this, _this.attr('action'));
                        } else if( ajax_auth_object.captcha_type === 'google' ) {
                            grecaptcha.reset();
                        }
                    }
                }
            }
        );
        e.preventDefault();
    });

    /**
     * Perform AJAX register on form submit
     */
    boombox_register_form.on( 'submit', function (e) {
        if ( ! $( this ).valid() )
            return false;

        var _this        = $( this );
        var username     = _this.find( '[name="signonusername"]' ).val();
        var useremail    = _this.find( '[name="signonemail"]' ).val();
        var password     = _this.find( '[name="signonpassword"]' ).val();
        var security     = _this.find( '[name="signonsecurity"]' ).val();
        var is_nsfw_auth = _this.closest( '.authentication').hasClass( 'is-nsfw-auth' );
        var redirect_url = ajax_auth_object.register_redirect_url;
        var data = {
            action      : 'boombox_ajax_register',
            username    : username,
            useremail   : useremail,
            password    : password,
            security    : security
        }

        if( ajax_auth_object.enable_registration_captcha ) {
            if( ajax_auth_object.captcha_type === 'image' ) {
                data.captcha = _this.find( '[name="signoncaptcha"]' ).val();
            } else if( ajax_auth_object.captcha_type === 'google' ) {
                data.captcha = _this.find( '[name="g-recaptcha-response"]' ).val();
            }
        }

        _this.parent().find( 'p.status').show().text( ajax_auth_object.loading_message );

        $.post(
            ajax_auth_object.ajaxurl,
            data,
            function ( response ) {
                var data = $.parseJSON( response );
                _this.parent().find( 'p.status').show().text( data.message );
                if ( data.loggedin == true ) {
                    if( is_nsfw_auth ){
                        redirect_url = ajax_auth_object.nsfw_redirect_url;
                    }
                    document.location.href = redirect_url;
                }else{
                    if( ajax_auth_object.enable_registration_captcha ) {
                        if( ajax_auth_object.captcha_type === 'image' ) {
                            boombox_refresh_captcha(_this, _this.attr('action'));
                        } else if( ajax_auth_object.captcha_type === 'google' ) {
                            grecaptcha.reset();
                        }
                    }
                }
            }
        );
        e.preventDefault();
    });

    /**
     * Lost Password
     * Perform AJAX forget password on form submit
     */
    boombox_forgot_password_form.on('submit', function (e) {
        if (!$(this).valid())
            return false;

        var _this       = $(this);
        var userlogin   = _this.find( '[name="userlogin"]' ).val();
        var security    = _this.find( '[name="forgotsecurity"]' ).val();

        _this.parent().find( 'p.status').show().text( ajax_auth_object.loading_message );

        $.post(
            ajax_auth_object.ajaxurl,
            {
                action      : 'boombox_ajax_forgot_password',
                userlogin   : userlogin,
                security    : security
            },
            function ( response ) {
                var data = $.parseJSON( response );
                $( 'p.status', _this ).text( data.message );
            }
        );
        e.preventDefault();
        return false;
    });

    /**
     * Refresh Captcha
     */
    $( 'body' ).on( 'click', '.auth-refresh-captcha', function(){
        var form = $( this).closest( 'form' );
        var type = form.attr('action');
        boombox_refresh_captcha( form, type );
    } );

    /**
     * Refresh Captcha Function
     *
     * @param selector
     */
    function boombox_refresh_captcha( selector, type ){
        selector.find( '.captcha' ).attr( 'src', ajax_auth_object.captcha_file_url + '?' + Math.random() + '&type=' + type );
    }

});