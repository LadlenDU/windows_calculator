<?php
/**
 * Plugin Name: Калькулятор окон
 * Description: Вычисляет цены на окна.
 * Version: 1.0
 */

add_action('admin_menu', 'plugin_admin_add_wnd_calc_page');
function plugin_admin_add_wnd_calc_page()
{
    add_options_page('Настройки калькулятора окон', 'Калькулятор окон', 'manage_options', 'windows_calculator', 'plugin_options_page');
}

function plugin_options_page()
{
    ?>
    <div class="wrap">
        <h2>Расчет цены окон</h2>

        <form action="options.php" method="post">
            <?php settings_fields('plugin_options_wnd_calc'); ?>
            <?php do_settings_sections('windows_calculator'); ?>

            <input name="Submit" type="submit" value="<?php esc_attr_e('Сохранить изменения'); ?>"/>
        </form>
    </div>

    <?php
}

// add the admin settings and such
add_action('admin_init', 'plugin_admin_init');
function plugin_admin_init()
{
    register_setting('plugin_options_wnd_calc', 'plugin_options_wnd_calc', 'plugin_options_validate_wnd_calc');
    add_settings_section('plugin_main_wnd_calc', 'Настройки', 'plugin_section_text_wnd_calc', 'windows_calculator');
    add_settings_field('plugin_wnd_calc_window', 'Тип окон', 'plugin_wnd_calc_window_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_profile', 'Профиль', 'plugin_wnd_calc_profile_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_dglazed', 'Стеклопакет', 'plugin_wnd_calc_dglazed_func', 'windows_calculator', 'plugin_main_wnd_calc');


    wp_enqueue_style('wnd_calc_admin_style', plugins_url('', __FILE__) . '/admin.css');
    wp_enqueue_script('wnd_calc_admin_script', plugins_url('', __FILE__) . '/admin.js', ['jquery']);

    wp_enqueue_media();
}

function plugin_section_text_wnd_calc()
{
    //echo '<p>Main description of this section here.</p>';
}

function plugin_wnd_calc_profile_func()
{
    showChangeOptionTable('profile');
}

function plugin_wnd_calc_dglazed_func()
{
    showChangeOptionTable('dglazed');
}

function plugin_wnd_calc_window_func()
{
    $options = get_option('plugin_options_wnd_calc');
    $s = '<table class="wnd_calc_wnd_options"><thead><tr><th>Название</th><th>Цена</th><th>&nbsp;</th><th>&nbsp;</th><th><input class="calc_wnd_option_type" type="hidden" value="window"></th></tr></thead><tbody>';
    if (!empty($options['window'])) {
        foreach ($options['window']['name'] as $key => $pf) {
            $s .= '<tr>'
                . '<td>'
                . '<input class="name_wnd_option" type="text" value="' . esc_html($pf) . '" name="plugin_options_wnd_calc[window][name][]" readonly="readonly">'
                . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                . '</td>'
                . '<td>'
                . '<input type="text" value="' . esc_html($options['window']['price'][$key]) . '" name="plugin_options_wnd_calc[window][price][]" readonly="readonly">'
                . '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать">'
                . '</td>'
                . '<td>'
                . '<input type="hidden" value="' . esc_html($options['window']['id_small'][$key]) . '" name="plugin_options_wnd_calc[window][id_small][]">'
                . '<input type="hidden" value="' . esc_html($options['window']['src_small'][$key]) . '" name="plugin_options_wnd_calc[window][src_small][]">'
                . '<img alt="маленькое окно" src="' . esc_html($options['window']['src_small'][$key]) . '" class="mod_wnd_option_class_preview_image">'
                . '<button class="mod_wnd_option_change_preview_image" title="Добавить/изменить маленькое окно">Мал. окно</button>'
                . '</td>'
                . '<td class="delete_wnd_option"><button class="rem_wnd_option">Удалить</button></td>'
                . '</tr>';
        }
    }

    $s .= '</tbody></table><button class="wnd_calc_wnd_option_add_window">Добавить</button>';

    echo $s;
}

function showChangeOptionTable($id)
{
    $options = get_option('plugin_options_wnd_calc');
    //echo "<input id='plugin_wnd_calc_profile' name='plugin_options_wnd_calc[text_string]' size='40' type='text' value='{$options['text_string']}' />";
    $s = '<table class="wnd_calc_wnd_options"><thead><tr><th>Название</th><th>Цена</th><th><input class="calc_wnd_option_type" type="hidden" value="' . $id . '"></th></tr></thead><tbody>';
    if (!empty($options[$id])) {
        foreach ($options[$id]['name'] as $key => $pf) {
            $s .= '<tr>'
                . '<td>'
                . '<input class="name_wnd_option" type="text" value="' . esc_html($pf) . '" name="plugin_options_wnd_calc[' . $id . '][name][]" readonly="readonly">'
                . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                . '</td>'
                . '<td>'
                . '<input type="text" value="' . esc_html($options[$id]['price'][$key]) . '" name="plugin_options_wnd_calc[' . $id . '][price][]" readonly="readonly">'
                . '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать">'
                . '</td>'
                . '<td class="delete_wnd_option"><button class="rem_wnd_option">Удалить</button></td>'
                . '</tr>';
        }
    }

    $s .= '</tbody></table><button class="wnd_calc_wnd_option_add">Добавить</button>';

    echo $s;
}

function plugin_options_validate_wnd_calc($input)
{
    $newInput = $input;
    $newInput['text_string'] = trim($input['text_string']);
    return $newInput;
}


// ---------
function shortcode_wnd_calc()
{
    ob_start();
    include 'template.php';
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode('windows_calculator', 'shortcode_wnd_calc');
