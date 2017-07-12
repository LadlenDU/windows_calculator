<?php
/**
 * The template for displaying the single post
 *
 * @package BoomBox_Theme
 */

// Prevent direct script access.
if (!defined('ABSPATH')) {
    die('No direct script access allowed');
}

get_header();

$boombox_featured_image_size = 'boombox_image768';
$boombox_single_options = boombox_get_single_page_settings($boombox_featured_image_size);
$boombox_featured_video = $boombox_single_options['featured_video'];
$boombox_template_options = $boombox_single_options['template_options'];
$boombox_post_template = $boombox_single_options['post_template'];
$boombox_is_nsfw_post = $boombox_single_options['is_nsfw'];
$boombox_article_classes = $boombox_single_options['classes'];
$boombox_disable_strip = $boombox_single_options['disable_strip'];

if (!$boombox_disable_strip):
    get_template_part('template-parts/featured', 'strip');
endif;

boombox_the_advertisement('boombox-single-before-content', 'large');

if ('full-width' == $boombox_post_template && have_posts()): the_post();
    $boombox_fimage_style = '';
    if ($boombox_template_options['media'] && has_post_thumbnail() && boombox_show_thumbail() ) :
        $boombox_thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        $boombox_fimage_style = isset($boombox_thumbnail_url[0]) ? 'style="background-image: url(\'' . esc_url($boombox_thumbnail_url[0]) . '\')"' : '';
    endif; ?>
    <div class="post-featured-image" <?php echo $boombox_fimage_style; ?>>
        <div class="content">
            <!-- entry-header -->
            <header class="entry-header">
                <?php get_template_part('template-parts/single/single', 'header'); ?>
            </header>
        </div>
    </div>
    <?php
    rewind_posts();
endif; ?>

<!--<div id="video-stream" class="video-stream">-->
<!--    <div class="container">-->
<!--        <div class="video-stream_main">-->
<!--            <div class="video-wrapper">-->
<!--                <div class="video-container">-->
<!--                    <div class="responsivewrapper">-->
<!--                        <div id="stream-player" data-id="M7lc1UVf-VE"></div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="video-cover">-->
<!--                    <a class="video-play" href="#">-->
<!--                        <span class="play"><i class="icon icon-video2"></i></span>-->
<!--                        <div class="responsivewrapper" style="background-image: url('http://dev.novembit.com/boombox/wp-content/uploads/2016/09/image-760x450.png')"></div>-->
<!--                    </a>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div --><?php //echo $top_sharebar_id; ?><!-- class="post-share-box">-->
<!--                --><?php //get_template_part('template-parts/single/share', 'box'); ?>
<!--            </div>-->
<!--        </div>-->
<!--        <div class="video-stream_secondary">-->
<!--            <div class="viewport">-->
<!--                <ul id="stream-scroll">-->
<!--                    <li class="stream-item active">-->
<!--                        <a class="img-container" href="#">-->
<!--                            <div class="responsivewrapper" style="background-image: url('http://cdn-jarvis-fun.9cache.com/media/photo/p3GybOr6g_360w_v1.jpg')">-->
<!---->
<!--                            </div>-->
<!--                        </a>-->
<!--                        <div class="info">-->
<!--                            <h4 class="item-title">-->
<!--                                <a href="#">-->
<!--                                    Going Wireless With Your Headphones-->
<!--                                </a>-->
<!--                            </h4>-->
<!--                            <div class="meta">By <span>Ina Chavez</span></div>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="stream-item">-->
<!--                        <a class="img-container" href="#">-->
<!--                            <div class="responsivewrapper" style="background-image: url('http://cdn-jarvis-fun.9cache.com/media/photo/p3GybOr6g_360w_v1.jpg')">-->
<!---->
<!--                            </div>-->
<!--                        </a>-->
<!--                        <div class="info">-->
<!--                            <h4 class="item-title">-->
<!--                                <a href="#">-->
<!--                                    James & Jenna's "Suicide Squad" Waltz Will Make Joker And Quinn's Fans Fall In Love-->
<!--                                </a>-->
<!--                            </h4>-->
<!--                            <div class="meta">By <span>Ina Chavez</span></div>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="stream-item">-->
<!--                        <a class="img-container" href="#">-->
<!--                            <div class="responsivewrapper" style="background-image: url('http://cdn-jarvis-fun.9cache.com/media/photo/p3GybOr6g_360w_v1.jpg')">-->
<!---->
<!--                            </div>-->
<!--                        </a>-->
<!--                        <div class="info">-->
<!--                            <h4 class="item-title">-->
<!--                                <a href="#">-->
<!--                                    James & Jenna's "Suicide Squad" Waltz Will Make Joker And Quinn's Fans Fall In Love-->
<!--                                </a>-->
<!--                            </h4>-->
<!--                            <div class="meta">By <span>Ina Chavez</span></div>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="stream-item">-->
<!--                        <a class="img-container" href="#">-->
<!--                            <div class="responsivewrapper" style="background-image: url('http://cdn-jarvis-fun.9cache.com/media/photo/p3GybOr6g_360w_v1.jpg')">-->
<!---->
<!--                            </div>-->
<!--                        </a>-->
<!--                        <div class="info">-->
<!--                            <h4 class="item-title">-->
<!--                                <a href="#">-->
<!--                                    James & Jenna's "Suicide Squad" Waltz Will Make Joker And Quinn's Fans Fall In Love-->
<!--                                </a>-->
<!--                            </h4>-->
<!--                            <div class="meta">By <span>Ina Chavez</span></div>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--            <div class="video-next-prev">-->
<!--                <a class="nav prev-page" href="#">-->
<!--                    <i class="icon icon-chevron-left"></i>-->
<!--                    <span class="text">Previous</span>-->
<!--                </a>-->
<!--                <a class="nav next-page disabled" href="#">-->
<!--                    <i class="icon icon-chevron-right"></i>-->
<!--                    <span class="text">Next</span>-->
<!--                </a>-->
<!--            </div>-->
<!--        </div>-->
<!--        <script>-->
<!--            //This code loads the IFrame Player API code asynchronously.-->
<!--            var tag = document.createElement('script');-->
<!---->
<!--            tag.src = "https://www.youtube.com/iframe_api";-->
<!--            var firstScriptTag = document.getElementsByTagName('script')[0];-->
<!--            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);-->
<!--        </script>-->
<!--    </div>-->
<!--</div>-->

<div class="container main-container">
    <div id="main" class="site-main" role="main">
        <?php if (have_posts()): the_post(); ?>
            <article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>" <?php post_class($boombox_article_classes); ?>>
                <?php if ('full-width' != $boombox_post_template): ?>
                    <!-- entry-header -->
                    <header class="entry-header">
                        <?php get_template_part('template-parts/single/single', 'header'); ?>
                        <hr/>
                    </header>
                <?php endif; ?>

                <div class="post-meta-info">
                    <?php if ($boombox_template_options['author'] || $boombox_template_options['date'] ||
                        $boombox_template_options['views'] || $boombox_template_options['comments_count']
                    ): ?>
                        <div class="post-meta row">
                            <div class="col-md-6 col-sm-6">
                                <div class="author-meta">
                                    <?php if ($boombox_template_options['author']) :
                                        boombox_post_author( array('with_avatar' => true) );
                                    endif;
                                    if ($boombox_template_options['date']) :
                                        boombox_post_date();
                                    endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="view-meta">
                                    <?php if ($boombox_template_options['comments_count']) :
                                        boombox_post_comments();
                                    endif;
                                    if ($boombox_template_options['views']) :
                                        boombox_show_post_views();
                                    endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if ('full-width' == $boombox_post_template): ?>
                            <hr/>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($boombox_template_options['top_sharebar']) { ?>
                        <?php $top_sharebar_id = $boombox_template_options['sticky_top_sharebar'] ? 'id="sticky-share-box"' : ''; ?>
                        <div <?php echo $top_sharebar_id; ?> class="post-share-box top">
                            <?php get_template_part('template-parts/single/share', 'box'); ?>
                        </div>
                    <?php } ?>
                </div>

                <?php
                /* Show NSFW message, if is NSFW post */
                $boombox_auth_is_disabled = boombox_disabled_site_auth();
                if ($boombox_is_nsfw_post && !is_user_logged_in() && !$boombox_auth_is_disabled):
                    printf('<a href="%1$s" class="entry-nsfw js-authentication" >%2$s</a>',
                        esc_url('#sign-in'),
                        boombox_get_nsfw_message()
                    );
                endif;

                if (!$boombox_is_nsfw_post || ($boombox_is_nsfw_post && is_user_logged_in())):

                    if ($boombox_template_options['media'] && 'full-width' != $boombox_post_template && boombox_show_thumbail() && (has_post_thumbnail() || $boombox_featured_video)) : ?>
                        <!-- thumbnail -->
                        <div class="post-thumbnail">
                            <?php
                            if ($boombox_featured_video) :
                                echo $boombox_featured_video;
                            elseif (has_post_thumbnail()) :
                                the_post_thumbnail($boombox_featured_image_size, array( 'play' => true ));
                                boombox_post_thumbnail_caption();
                            endif; ?>
                        </div>
                        <!-- thumbnail -->
                    <?php endif; ?>

                    <!-- entry-content -->
                    <div class="entry-content">
                        <?php the_content(); ?>

                        <?php if ($boombox_template_options['next_prev_buttons']) :
                            get_template_part('template-parts/single/next-prev-buttons');
                        endif; ?>

                    </div>
                    <?php
                endif; ?>


                <!-- entry-footer -->
                <footer class="entry-footer">
                    <hr/>
                    <?php if ($boombox_template_options['tags']) :
                        boombox_tags_list();
                    endif; ?>
                    <?php if ($boombox_template_options['bottom_sharebar']) { ?>
                        <div class="post-share-box bottom">
                            <?php do_action('boombox_single_post_text_before_share'); ?>
                            <?php get_template_part('template-parts/single/share', 'box'); ?>
                        </div>
                    <?php } ?>
                </footer>
            </article>

            <?php if ($boombox_template_options['reactions']) :
                get_template_part('template-parts/single/reaction', 'vote');
            endif; ?>

            <?php if ($boombox_template_options['author_info']) :
                boombox_post_author_short_info();
            endif; ?>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif; ?>

            <?php boombox_the_advertisement('boombox-single-before-navigation', 'large'); ?>

            <?php if ($boombox_template_options['navigation']) :
                get_template_part('template-parts/single/navigation');
            endif; ?>

            <?php if ($boombox_template_options['subscribe_form']) :
                boombox_mailchimp_form();
            endif; ?>

            <?php if ($boombox_template_options['floating_navbar']) :
                get_template_part( 'template-parts/single/fixed', 'header' );
            endif; ?>

            <?php if( $boombox_template_options['side_navigation'] ) :
                get_template_part( 'template-parts/single/fixed', 'navigation' );
            endif; ?>

            <?php if ('post' == get_post_type()):
                get_template_part('template-parts/single/posts', 'related');

                get_template_part('template-parts/single/posts', 'more-from');
            endif; ?>

            <?php if ('post' == get_post_type()):
                get_template_part('template-parts/single/posts', 'dont-miss');
            endif; ?>

        <?php endif; ?>


    </div>

    <?php if ('no-sidebar' != $boombox_post_template):
        get_sidebar();
    endif; ?>
</div>

<?php get_footer(); ?>
