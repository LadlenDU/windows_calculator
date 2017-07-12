<?php
/**
 * Buddypress plugin functions
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

if( is_plugin_active( 'buddypress/bp-loader.php' ) ) {

    define ( 'BP_AVATAR_FULL_WIDTH', 186 );
    define ( 'BP_AVATAR_FULL_HEIGHT', 186 );
    define ( 'BP_AVATAR_THUMB_WIDTH', 66 );
    define ( 'BP_AVATAR_THUMB_HEIGHT', 66 );

    define ( 'BP_AVATAR_DEFAULT', BOOMBOX_THEME_URL . 'buddypress/images/user.jpg' );
    define ( 'BP_AVATAR_DEFAULT_THUMB', BOOMBOX_THEME_URL . 'buddypress/images/user-150.jpg' );

    /**
     * Hook into cover image to attach style handle for profile image
     */
    add_filter('bp_before_xprofile_cover_image_settings_parse_args', 'boombox_buddypress_attach_theme_handle', 10, 1);
    add_filter('bp_before_groups_cover_image_settings_parse_args', 'boombox_buddypress_attach_theme_handle', 10, 1);
    function boombox_buddypress_attach_theme_handle($settings = array()) {

        $theme_handle = 'bp-parent-css';
        if( is_rtl() ) {
            $theme_handle .= '-rtl';
        }
        $settings['theme_handle'] = $theme_handle;
        $settings['width'] = 1920;
        $settings['height'] = 265;

        return $settings;
    }

    /**
     * Hook into 'add friend' button args to modify required params
     */
    add_filter( 'bp_get_add_friend_button', 'boombox_bp_get_add_friend_button', 10, 1 );
    function boombox_bp_get_add_friend_button( $button_args ) {
        $button_args['link_class'] = 'btn btn-primary';

        return $button_args;
    }

    /**
     * Hook into 'private message' button args to modify required params
     */
    add_filter( 'bp_get_send_message_button_args', 'boombox_bp_get_send_message_button_args', 10, 1 );
    function boombox_bp_get_send_message_button_args( $button_args ) {
        $button_args['link_class'] = 'btn btn-primary';

        return $button_args;
    }

    /**
     * Hook into 'public message' button args to modify required params
     */
    add_filter( 'bp_get_send_public_message_button', 'boombox_bp_get_send_public_message_button', 10, 1 );
    function boombox_bp_get_send_public_message_button( $button_args ) {
        $button_args['link_class'] = 'btn btn-primary';

        return $button_args;
    }

    /**
     * Locate wordpress author post link to buddypress profile
     */
    add_filter( 'author_link', "boombox_author_link", 10, 3 );
    function boombox_author_link( $link, $author_id, $author_nicename ) {
        return bp_core_get_user_domain( $author_id );
    }

    /**
     * Hook for generate the "x members" count string for a group.
     */
    function boombox_make_number_rounded( $value, $number, $decimals ) {
        return sprintf( '<span class="count">%s</span>', $value );
    }

    /**
     * Output the Group members template
     */
    function boombox_bp_groups_members_template_part() {
        ?>
        <div class="item-list-tabs" id="subnav" role="navigation">
            <ul>
                <?php do_action('bp_members_directory_member_sub_types'); ?>
            </ul>
        </div>

        <div class="bbp-filters">
            <div class="row">
                <div class="col-sm-6">
                    <div class="bbp-filter">
                        <?php boombox_bp_groups_members_filter(); ?>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="bbp-search">
                        <div class="groups-members-search" role="search">
                            <?php bp_directory_members_search_form(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="members-group-list" class="group_members dir-list">

            <?php bp_get_template_part('groups/single/members'); ?>

        </div>
    <?php
    }

    /**
     * Output the Group members filters
     */
    function boombox_bp_groups_members_filter() {
        ?>
        <div id="group_members-order-select" class="filter">
            <label for="group_members-order-by"><?php _e('Order By:', 'buddypress'); ?></label>
            <select id="group_members-order-by">
                <option value="last_joined"><?php _e('Newest', 'buddypress'); ?></option>
                <option value="first_joined"><?php _e('Oldest', 'buddypress'); ?></option>

                <?php if (bp_is_active('activity')) : ?>
                    <option value="group_activity"><?php _e('Group Activity', 'buddypress'); ?></option>
                <?php endif; ?>

                <option value="alphabetical"><?php _e('Alphabetical', 'buddypress'); ?></option>

                <?php do_action('bp_groups_members_order_options'); ?>

            </select>
        </div>
    <?php
    }

    /***
     * Modify groups/members default avatar
     */
    add_filter( 'bp_core_avatar_default',       'boombox_groups_default_avatar', 10, 3 );
    add_filter( 'bp_core_avatar_default_thumb', 'boombox_groups_default_avatar', 10, 3 );
    function boombox_groups_default_avatar( $avatar, $params ) {
        if ( isset( $params['object'] ) && 'group' === $params['object'] ) {
            if ( isset( $params['type'] ) && 'thumb' === $params['type'] ) {
                $file = 'group-150';
            } else {
                $file = 'group';
            }
            $avatar = BOOMBOX_THEME_URL . "buddypress/images/$file.jpg";
        }

        return $avatar;
    }

    /***
     * Modify user default avatar
     */
    add_filter( 'bp_core_avatar_default',       'boombox_user_default_avatar', 10, 3 );
    add_filter( 'bp_core_avatar_default_thumb', 'boombox_user_default_avatar', 10, 3 );
    function boombox_user_default_avatar( $avatar, $params ) {
        if ( isset( $params['object'] ) && 'user' === $params['object'] ) {
            if ( isset( $params['type'] ) && 'thumb' === $params['type'] ) {
                $file = 'user-150';
            } else {
                $file = 'user';
            }
            $avatar = BOOMBOX_THEME_URL . "buddypress/images/$file.jpg";
        }

        return $avatar;
    }

    /***
     * Force To Prevent Using Grav
     */
    add_filter( 'bp_core_fetch_avatar_no_grav', 'boombox_force_no_grav', 10, 2 );
    function boombox_force_no_grav( $no_grav, $params ) {
        $no_grav = true;

        return $no_grav;
    }

    /**
     * Change invited users list HTML
     */
    add_filter( 'bp_get_new_group_invite_friend_list', 'boombox_get_new_group_invite_friend_list', 10, 3);
    function boombox_get_new_group_invite_friend_list( $items, $r, $args ) {
        $friends = friends_get_friends_invite_list( $r['user_id'], $r['group_id'] );

        if ( ! empty( $friends ) ) {

            $items = array();

            $invites = groups_get_invites_for_group( $r['user_id'], $r['group_id'] );

            for ( $i = 0, $count = count( $friends ); $i < $count; ++$i ) {
                $checked = in_array( (int) $friends[ $i ]['id'], (array) $invites );
                $items[] = '<' . $r['separator'] . '><label class="bbp-checkbox" for="f-' . esc_attr( $friends[ $i ]['id'] ) . '"><input' . checked( $checked, true, false ) . ' type="checkbox" name="friends[]" id="f-' . esc_attr( $friends[ $i ]['id'] ) . '" value="' . esc_attr( $friends[ $i ]['id'] ) . '" /><span class="bbp-checkbox-check"></span>' . esc_html( $friends[ $i ]['full_name'] ) . '</label></' . $r['separator'] . '>';
            }

        }

        return $items;
    }

    /**
     * Open wrapper for member/home templates
     */
    add_action( 'bp_before_member_home_content', 'boombox_bp_before_member_home_content', 10 );
    function boombox_bp_before_member_home_content() {
        $bbp_wrapper_classes = array('bbp-wrapper');

        if( ! bp_attachments_get_user_has_cover_image() ) {
            $bbp_wrapper_classes[] = 'no-item-image';
        }

        echo sprintf( '<div class="%s">', implode(' ', $bbp_wrapper_classes) );
    }

    /**
     * Close wrapper for member/home templates
     */
    add_action( 'bp_after_member_home_content', 'boombox_bp_after_member_home_content', 10 );
    function boombox_bp_after_member_home_content() {
        echo sprintf( '</div>' );
    }

    /**
     * Open wrapper for group/home templates
     */
    add_action( 'bp_before_group_home_content', 'boombox_bp_before_group_home_content', 10 );
    function boombox_bp_before_group_home_content() {
        $bbp_wrapper_classes = array('bbp-wrapper');

        if( ! bp_attachments_get_group_has_cover_image() ) {
            $bbp_wrapper_classes[] = 'no-item-image';
        }

        echo sprintf( '<div class="%s">', implode(' ', $bbp_wrapper_classes) );
    }

    /**
     * Close wrapper for group/home templates
     */
    add_action( 'bp_after_group_home_content', 'boombox_bp_after_group_home_content', 10 );
    function boombox_bp_after_group_home_content() {
        echo sprintf( '</div>' );
    }

    /**
     * Social Media Icons based on the profile user info
     */
    function member_social_extend() {
        $displayed_user_id = bp_displayed_user_id();

        $facebook_info = xprofile_get_field_data('Facebook', $displayed_user_id);
        $twitter_info = xprofile_get_field_data('Twitter', $displayed_user_id);
        $youtube_info = xprofile_get_field_data('Youtube', $displayed_user_id);

        if($facebook_info||$twitter_info||$youtube_info){
            echo '<ul class="bbp-social">';

            if($facebook_info) echo '<li><a href="'.$facebook_info.'" title="My Facebook" target="_blank"><span class="icon-facebook"></span></a></li>';
            if($twitter_info) echo '<li><a href="'.$twitter_info.'" title="My Facebook" target="_blank"><span class="icon-twitter"></span></a></li>';
            if($youtube_info) echo '<li><a href="'.$youtube_info.'" title="My Facebook" target="_blank"><span class="icon-youtube-play"></span></a></li>';

            echo '</ul>';
        }
    }
    add_filter( 'bp_before_member_header_meta', 'member_social_extend' );

    /**
     * Replace some settings tables with Boombox ones
     */
    remove_action( 'bp_notification_settings', 'bp_activity_screen_notification_settings', 1 );
    add_action( 'bp_notification_settings', 'boombox_bp_activity_screen_notification_settings', 1 );
    function boombox_bp_activity_screen_notification_settings() {
        if ( bp_activity_do_mentions() ) {
            if ( ! $mention = bp_get_user_meta( bp_displayed_user_id(), 'notification_activity_new_mention', true ) ) {
                $mention = 'yes';
            }
        }

        if ( ! $reply = bp_get_user_meta( bp_displayed_user_id(), 'notification_activity_new_reply', true ) ) {
            $reply = 'yes';
        }

        ?>

        <table class="notification-settings" id="activity-notification-settings">
            <thead>
            <tr>
                <th class="title"><?php _e( 'Activity', 'buddypress' ) ?></th>
                <th class="yes"><?php _e( 'Yes', 'buddypress' ) ?></th>
                <th class="no"><?php _e( 'No', 'buddypress' )?></th>
            </tr>
            </thead>

            <tbody>
            <?php if ( bp_activity_do_mentions() ) : ?>
                <tr id="activity-notification-settings-mentions">
                    <td><?php printf( __( 'A member mentions you in an update using "@%s"', 'buddypress' ), bp_core_get_username( bp_displayed_user_id() ) ) ?></td>
                    <td class="yes">
                        <label for="notification-activity-new-mention-yes" class="bbp-radio">
                            <input type="radio" name="notifications[notification_activity_new_mention]" id="notification-activity-new-mention-yes" value="yes" <?php checked( $mention, 'yes', true ) ?>/>
                            <span class="bbp-radio-check"></span>
                            <span class="bp-screen-reader-text"><?php
                            /* translators: accessibility text */
                            _e( 'Yes, send email', 'buddypress' );
                            ?></span>
                        </label>
                    </td>
                    <td class="no">
                        <label for="notification-activity-new-mention-no" class="bbp-radio">
                            <input type="radio" name="notifications[notification_activity_new_mention]" id="notification-activity-new-mention-no" value="no" <?php checked( $mention, 'no', true ) ?>/>
                            <span class="bbp-radio-check"></span>
                            <span class="bp-screen-reader-text"><?php
                            /* translators: accessibility text */
                            _e( 'No, do not send email', 'buddypress' );
                            ?></span>
                        </label>
                    </td>
                </tr>
            <?php endif; ?>

            <tr id="activity-notification-settings-replies">
                <td><?php _e( "A member replies to an update or comment you've posted", 'buddypress' ) ?></td>
                <td class="yes">
                    <label for="notification-activity-new-reply-yes" class="bbp-radio">
                        <input type="radio" name="notifications[notification_activity_new_reply]" id="notification-activity-new-reply-yes" value="yes" <?php checked( $reply, 'yes', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'Yes, send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
                <td class="no">
                    <label for="notification-activity-new-reply-no" class="bbp-radio">
                        <input type="radio" name="notifications[notification_activity_new_reply]" id="notification-activity-new-reply-no" value="no" <?php checked( $reply, 'no', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'No, do not send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
            </tr>

            <?php

            /**
             * Fires inside the closing </tbody> tag for activity screen notification settings.
             *
             * @since 1.2.0
             */
            do_action( 'bp_activity_screen_notification_settings' ) ?>
            </tbody>
        </table>
    <?php }

    remove_action( 'bp_notification_settings', 'messages_screen_notification_settings', 2 );
    add_action( 'bp_notification_settings', 'boombox_friends_screen_notification_settings' );
    function boombox_friends_screen_notification_settings() {
        if ( !$send_requests = bp_get_user_meta( bp_displayed_user_id(), 'notification_friends_friendship_request', true ) )
            $send_requests   = 'yes';

        if ( !$accept_requests = bp_get_user_meta( bp_displayed_user_id(), 'notification_friends_friendship_accepted', true ) )
            $accept_requests = 'yes'; ?>

        <table class="notification-settings" id="friends-notification-settings">
            <thead>
            <tr>
                <th class="title"><?php _ex( 'Friends', 'Friend settings on notification settings page', 'buddypress' ) ?></th>
                <th class="yes"><?php _e( 'Yes', 'buddypress' ) ?></th>
                <th class="no"><?php _e( 'No', 'buddypress' )?></th>
            </tr>
            </thead>

            <tbody>
            <tr id="friends-notification-settings-request">
                <td><?php _ex( 'A member sends you a friendship request', 'Friend settings on notification settings page', 'buddypress' ) ?></td>
                <td class="yes">
                    <label for="notification-friends-friendship-request-yes" class="bbp-radio">
                        <input type="radio" name="notifications[notification_friends_friendship_request]" id="notification-friends-friendship-request-yes" value="yes" <?php checked( $send_requests, 'yes', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'Yes, send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
                <td class="no">
                     <label for="notification-friends-friendship-request-no" class="bbp-radio">
                         <input type="radio" name="notifications[notification_friends_friendship_request]" id="notification-friends-friendship-request-no" value="no" <?php checked( $send_requests, 'no', true ) ?>/>
                         <span class="bbp-radio-check"></span>
                         <span class="bp-screen-reader-text"><?php
                         /* translators: accessibility text */
                         _e( 'No, do not send email', 'buddypress' );
                         ?></span>
                    </label>
                </td>
            </tr>
            <tr id="friends-notification-settings-accepted">
                <td><?php _ex( 'A member accepts your friendship request', 'Friend settings on notification settings page', 'buddypress' ) ?></td>
                <td class="yes">
                    <label for="notification-friends-friendship-accepted-yes" class="bbp-radio">
                        <input type="radio" name="notifications[notification_friends_friendship_accepted]" id="notification-friends-friendship-accepted-yes" value="yes" <?php checked( $accept_requests, 'yes', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'Yes, send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
                <td class="no">
                    <label for="notification-friends-friendship-accepted-no" class="bbp-radio">
                        <input type="radio" name="notifications[notification_friends_friendship_accepted]" id="notification-friends-friendship-accepted-no" value="no" <?php checked( $accept_requests, 'no', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'No, do not send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
            </tr>

            <?php

            /**
             * Fires after the last table row on the friends notification screen.
             *
             * @since 1.0.0
             */
            do_action( 'friends_screen_notification_settings' ); ?>

            </tbody>
        </table>

        <?php
    }

    remove_action( 'bp_notification_settings', 'friends_screen_notification_settings' );
    add_action( 'bp_notification_settings', 'boombox_messages_screen_notification_settings', 2 );
    function boombox_messages_screen_notification_settings() {
        if ( bp_action_variables() ) {
            bp_do_404();
            return;
        }

        if ( !$new_messages = bp_get_user_meta( bp_displayed_user_id(), 'notification_messages_new_message', true ) ) {
            $new_messages = 'yes';
        } ?>

        <table class="notification-settings" id="messages-notification-settings">
            <thead>
            <tr>
                <th class="title"><?php _e( 'Messages', 'buddypress' ) ?></th>
                <th class="yes"><?php _e( 'Yes', 'buddypress' ) ?></th>
                <th class="no"><?php _e( 'No', 'buddypress' )?></th>
            </tr>
            </thead>

            <tbody>
            <tr id="messages-notification-settings-new-message">
                <td><?php _e( 'A member sends you a new message', 'buddypress' ) ?></td>
                <td class="yes">
                    <label for="notification-messages-new-messages-yes" class="bbp-radio">
                        <input type="radio" name="notifications[notification_messages_new_message]" id="notification-messages-new-messages-yes" value="yes" <?php checked( $new_messages, 'yes', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'Yes, send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
                <td class="no">
                    <label for="notification-messages-new-messages-no" class="bbp-radio">
                        <input type="radio" name="notifications[notification_messages_new_message]" id="notification-messages-new-messages-no" value="no" <?php checked( $new_messages, 'no', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'No, do not send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
            </tr>

            <?php

            /**
             * Fires inside the closing </tbody> tag for messages screen notification settings.
             *
             * @since 1.0.0
             */
            do_action( 'messages_screen_notification_settings' ); ?>
            </tbody>
        </table>

        <?php
    }

    remove_action( 'bp_notification_settings', 'groups_screen_notification_settings' );
    add_action( 'bp_notification_settings', 'boombox_groups_screen_notification_settings' );
    function boombox_groups_screen_notification_settings() {
        if ( !$group_invite = bp_get_user_meta( bp_displayed_user_id(), 'notification_groups_invite', true ) )
            $group_invite  = 'yes';

        if ( !$group_update = bp_get_user_meta( bp_displayed_user_id(), 'notification_groups_group_updated', true ) )
            $group_update  = 'yes';

        if ( !$group_promo = bp_get_user_meta( bp_displayed_user_id(), 'notification_groups_admin_promotion', true ) )
            $group_promo   = 'yes';

        if ( !$group_request = bp_get_user_meta( bp_displayed_user_id(), 'notification_groups_membership_request', true ) )
            $group_request = 'yes';

        if ( ! $group_request_completed = bp_get_user_meta( bp_displayed_user_id(), 'notification_membership_request_completed', true ) ) {
            $group_request_completed = 'yes';
        }
        ?>

        <table class="notification-settings" id="groups-notification-settings">
            <thead>
            <tr>
                <th class="title"><?php _ex( 'Groups', 'Group settings on notification settings page', 'buddypress' ) ?></th>
                <th class="yes"><?php _e( 'Yes', 'buddypress' ) ?></th>
                <th class="no"><?php _e( 'No', 'buddypress' )?></th>
            </tr>
            </thead>

            <tbody>
            <tr id="groups-notification-settings-invitation">
                <td><?php _ex( 'A member invites you to join a group', 'group settings on notification settings page','buddypress' ) ?></td>
                <td class="yes">
                    <label for="notification-groups-invite-yes" class="bbp-radio">
                        <input type="radio" name="notifications[notification_groups_invite]" id="notification-groups-invite-yes" value="yes" <?php checked( $group_invite, 'yes', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'Yes, send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
                <td class="no">
                    <label for="notification-groups-invite-no" class="bbp-radio">
                        <input type="radio" name="notifications[notification_groups_invite]" id="notification-groups-invite-no" value="no" <?php checked( $group_invite, 'no', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'No, do not send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
            </tr>
            <tr id="groups-notification-settings-info-updated">
                <td><?php _ex( 'Group information is updated', 'group settings on notification settings page', 'buddypress' ) ?></td>
                <td class="yes">
                    <label for="notification-groups-group-updated-yes" class="bbp-radio">
                        <input type="radio" name="notifications[notification_groups_group_updated]" id="notification-groups-group-updated-yes" value="yes" <?php checked( $group_update, 'yes', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'Yes, send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
                <td class="no">
                    <label for="notification-groups-group-updated-no" class="bbp-radio">
                        <input type="radio" name="notifications[notification_groups_group_updated]" id="notification-groups-group-updated-no" value="no" <?php checked( $group_update, 'no', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'No, do not send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
            </tr>
            <tr id="groups-notification-settings-promoted">
                <td><?php _ex( 'You are promoted to a group administrator or moderator', 'group settings on notification settings page', 'buddypress' ) ?></td>
                <td class="yes">
                    <label for="notification-groups-admin-promotion-yes" class="bbp-radio">
                        <input type="radio" name="notifications[notification_groups_admin_promotion]" id="notification-groups-admin-promotion-yes" value="yes" <?php checked( $group_promo, 'yes', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'Yes, send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
                <td class="no">
                    <label for="notification-groups-admin-promotion-no" class="bbp-radio">
                        <input type="radio" name="notifications[notification_groups_admin_promotion]" id="notification-groups-admin-promotion-no" value="no" <?php checked( $group_promo, 'no', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'No, do not send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
            </tr>
            <tr id="groups-notification-settings-request">
                <td><?php _ex( 'A member requests to join a private group for which you are an admin', 'group settings on notification settings page', 'buddypress' ) ?></td>
                <td class="yes">
                    <label for="notification-groups-membership-request-yes" class="bbp-radio">
                        <input type="radio" name="notifications[notification_groups_membership_request]" id="notification-groups-membership-request-yes" value="yes" <?php checked( $group_request, 'yes', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'Yes, send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
                <td class="no">
                    <label for="notification-groups-membership-request-no" class="bbp-radio">
                        <input type="radio" name="notifications[notification_groups_membership_request]" id="notification-groups-membership-request-no" value="no" <?php checked( $group_request, 'no', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'No, do not send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
            </tr>
            <tr id="groups-notification-settings-request-completed">
                <td><?php _ex( 'Your request to join a group has been approved or denied', 'group settings on notification settings page', 'buddypress' ) ?></td>
                <td class="yes">
                    <label for="notification-groups-membership-request-completed-yes" class="bbp-radio">
                        <input type="radio" name="notifications[notification_membership_request_completed]" id="notification-groups-membership-request-completed-yes" value="yes" <?php checked( $group_request_completed, 'yes', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'Yes, send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
                <td class="no">
                    <label for="notification-groups-membership-request-completed-no" class="bbp-radio">
                        <input type="radio" name="notifications[notification_membership_request_completed]" id="notification-groups-membership-request-completed-no" value="no" <?php checked( $group_request_completed, 'no', true ) ?>/>
                        <span class="bbp-radio-check"></span>
                        <span class="bp-screen-reader-text"><?php
                        /* translators: accessibility text */
                        _e( 'No, do not send email', 'buddypress' );
                        ?></span>
                    </label>
                </td>
            </tr>

            <?php

            /**
             * Fires at the end of the available group settings fields on Notification Settings page.
             *
             * @since 1.0.0
             */
            do_action( 'groups_screen_notification_settings' ); ?>

            </tbody>
        </table>

        <?php
    }

    /**
     * Render user notifications box
     */
    add_action( 'boombox_user_notifications', 'bbp_user_notifications', 10 );
    function bbp_user_notifications() {

        if( !is_user_logged_in() ) return;

        $user_id = bp_loggedin_user_id();

        $max_show = 5;
        $count = bp_notifications_get_unread_notification_count( $user_id );
        $notifications = bp_notifications_get_notifications_for_user( $user_id, 'string' );

        $all_notifications_url = esc_url( bp_loggedin_user_domain() . bp_get_notifications_slug() );
        ?>
        <!-- Start: User Notifications -->
        <div class="user-notifications">
            <a class="notifications-link icon-notification <?php if( $count ) echo 'has-count' ?>" href="<?php echo $all_notifications_url; ?>">
                <?php if( $count ) { ?>
                <span class="notifications-count"><?php echo bp_core_number_format( $count ); ?></span>
                <?php } ?>
            </a>

            <?php if( (bool)$notifications ) { ?>
            <div class="notifications-list menu">
                <ul>
                    <?php foreach($notifications as $index => $notification) { ?>
                    <?php if( $index >= $max_show ) break; ?>
                    <li><?php echo $notification; ?></li>
                    <?php } ?>
                </ul>
                <?php if( $count > $max_show ) { ?>
                <a href="<?php echo $all_notifications_url; ?>" class="notifications-more"><?php esc_html_e('View all', 'buddypress'); ?></a>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <!-- End: User Notifications -->
        <?php
    }


    /**
     * Add menu item to buddypress navigation
     */
    add_filter( 'bp_nav_menu_objects', 'bbp_nav_menu_objects', 9999, 2 );
    function bbp_nav_menu_objects( $menu_items, $args ) {

        $user_id = bp_loggedin_user_id();

        if( $user_id ) {
            $menu = new stdClass;
            $menu->class = array( 'menu-parent' );
            $menu->css_id = 'logout';
            $menu->link = wp_logout_url( bp_get_requested_url() );
            $menu->name = esc_html__('Logout', 'boddypress');
            $menu->parent = 0;

            $menu_items[] = $menu;
        }

        return $menu_items;
    }
    
}