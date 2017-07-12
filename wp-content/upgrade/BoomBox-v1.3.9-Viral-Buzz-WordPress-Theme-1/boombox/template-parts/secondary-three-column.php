<div id="secondary-container" class="secondary-container">
    <?php
        $boombox_sidebar_id = 'page-secondary';
        if ( is_active_sidebar( $boombox_sidebar_id ) ) :
            dynamic_sidebar( $boombox_sidebar_id );
        endif;
    ?>
</div>