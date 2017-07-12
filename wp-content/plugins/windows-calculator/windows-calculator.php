<?php
/**
 * Plugin Name: Калькулятор окон
 * Description: Вычисляет цены на окна.
 * Version: 1.0
 */

// Register the Custom Music Review Post Type

/*function register_cpt_music_review()
{

    $labels = array(
        'name' => _x('Music Reviews', 'music_review'),
        'singular_name' => _x('Music Review', 'music_review'),
        'add_new' => _x('Add New', 'music_review'),
        'add_new_item' => _x('Add New Music Review', 'music_review'),
        'edit_item' => _x('Edit Music Review', 'music_review'),
        'new_item' => _x('New Music Review', 'music_review'),
        'view_item' => _x('View Music Review', 'music_review'),
        'search_items' => _x('Search Music Reviews', 'music_review'),
        'not_found' => _x('No music reviews found', 'music_review'),
        'not_found_in_trash' => _x('No music reviews found in Trash', 'music_review'),
        'parent_item_colon' => _x('Parent Music Review:', 'music_review'),
        'menu_name' => _x('Music Reviews', 'music_review'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Music reviews filterable by genre',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes'),
        'taxonomies' => array('genres'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-format-audio',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type('music_review', $args);
}

add_action('init', 'register_cpt_music_review');

function genres_taxonomy()
{
    register_taxonomy(
        'genres',
        'music_review',
        array(
            //'hierarchical' => true,
            'label' => 'Genres',
            //'query_var' => true,
            'rewrite' => array(
                'slug' => 'genre',
                'with_front' => false
            )
        )
    );
}

add_action('init', 'genres_taxonomy');

// Function used to automatically create Music Reviews page.
function create_music_review_pages()
{
    //post status and options
    $post = array(
        'comment_status' => 'open',
        'ping_status' => 'closed',
        'post_date' => date('Y-m-d H:i:s'),
        'post_name' => 'music_review',
        'post_status' => 'publish',
        'post_title' => 'Music Reviews',
        'post_type' => 'page',
    );
    //insert page and save the id
    $newvalue = wp_insert_post($post, false);
    //save the id in the database
    update_option('mrpage', $newvalue);
}

// // Activates function if plugin is activated
register_activation_hook(__FILE__, 'create_music_review_pages');*/


add_action('admin_menu', 'plugin_admin_add_page');
function plugin_admin_add_page()
{
    add_options_page('Настройки калькулятора окон', 'Настройки калькулятора окон', 'manage_options', 'plugin', 'plugin_options_page');
}

function plugin_options_page()
{
    ?>
    <div>
        <h2>My custom plugin</h2>
        Options relating to the Custom Plugin.
        <form action="options.php" method="post">
            <?php settings_fields('plugin_options'); ?>
            <?php do_settings_sections('plugin'); ?>

            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>"/>
        </form>
    </div>

    <?php
}

// add the admin settings and such
add_action('admin_init', 'plugin_admin_init');
function plugin_admin_init()
{
    register_setting('plugin_options', 'plugin_options', 'plugin_options_validate');
    add_settings_section('plugin_main', 'Main Settings', 'plugin_section_text', 'plugin');
    add_settings_field('plugin_text_string', 'Plugin Text Input', 'plugin_setting_string', 'plugin', 'plugin_main');
}

function plugin_section_text() {
    echo '<p>Main description of this section here.</p>';
}

function plugin_setting_string() {
    $options = get_option('plugin_options');
    echo "<input id='plugin_text_string' name='plugin_options[text_string]' size='40' type='text' value='{$options['text_string']}' />";
}

function plugin_options_validate($input) {
    $newinput['text_string'] = trim($input['text_string']);
    if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
        $newinput['text_string'] = 'rrrrrrr';
    }
    return $newinput;
}


// ---------
function shortcode()
{
    ob_start();
    include 'template.php';
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode('windows_calculator', 'shortcode');
