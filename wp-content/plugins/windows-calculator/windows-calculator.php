<?php
/**
 * Plugin Name: Калькулятор окон
 * Description: Вычисляет цены на окна.
 * Version: 1.0
 */

add_action('wp_enqueue_scripts', 'wnd_calc_scripts');
function wnd_calc_scripts()
{
    wp_enqueue_style('wnd_calc_style', plugins_url('', __FILE__) . '/template.css');
    wp_enqueue_script('wnd_calc_script', plugins_url('', __FILE__) . '/template.js', ['jquery']);
}

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

$defaultWndCalcOptions = [
    'profile' => [
        'name' => ['REHAU BLITZ', 'REHAU INTELIO', 'REHAU BRILLANT', 'REHAU DELIGHT', 'REHAU SIB', 'REHAU GENEO'],
        'price' => [100.3, 102, 110, 120, 140.40, 30],
    ],
    'dglazed' => [
        'name' => ['Стандартный', 'Энергосберегающий'],
        'price' => [1000, 2000],
    ],
    'sill' => [
        'name' => ['Нет', '200 мм', '250 мм', '300 мм', '350 мм', '400 мм', '500 мм'],
        'price' => [0, 101, 102, 103, 104, 105, 106],
    ],
    'otliv' => [
        'name' => ['Нет', '100 мм', '150 мм', '200 мм', '250 мм', '300 мм', '350 мм', '400 мм'],
        'price' => [0, 111, 112, 113, 114, 115, 116, 117],
    ],
    'setting' => [
        'name' => ['Нет', 'Стандарт', 'ГОСТ'],
        'price' => [0, 2000, 3000],
    ],
    'furniture' => [
        'name' => ['Нет', 'ROTO', 'VORNE', 'SIGENIA'],
        'price' => [0, 500, 600, 700],
    ],
    'slopes' => [
        'name' => ['Нет', '200 мм', '250 мм', '300 мм', '350 мм', '400 мм', '500 мм'],
        'price' => [0, 101, 102, 103, 104, 105, 106],
    ],
    'accessories' => [
        'name' => ['Москитная сетка', 'Детский замок', 'Гребенка'],
        'price' => [510, 620, 730],
    ],
];


//delete_option('plugin_options_wnd_calc');

// add the admin settings and such
add_action('admin_init', 'plugin_admin_init');
function plugin_admin_init()
{
    register_setting('plugin_options_wnd_calc', 'plugin_options_wnd_calc', 'plugin_options_validate_wnd_calc');
    add_settings_section('plugin_main_wnd_calc', 'Настройки', 'plugin_section_text_wnd_calc', 'windows_calculator');

    add_settings_field('plugin_wnd_calc_window', 'Тип окон', 'plugin_wnd_calc_window_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_profile', 'Профиль', 'plugin_wnd_calc_profile_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_dglazed', 'Стеклопакет', 'plugin_wnd_calc_dglazed_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_sill', 'Подоконник', 'plugin_wnd_calc_sill_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_otliv', 'Отлив', 'plugin_wnd_calc_otliv_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_setting', 'Установка', 'plugin_wnd_calc_setting_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_furniture', 'Фурнитура', 'plugin_wnd_calc_furniture_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_slopes', 'Откосы', 'plugin_wnd_calc_slopes_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_accessories', 'Комплектующие', 'plugin_wnd_calc_accessories_func', 'windows_calculator', 'plugin_main_wnd_calc');

    wp_enqueue_style('wnd_calc_admin_style', plugins_url('', __FILE__) . '/admin.css');
    wp_enqueue_script('wnd_calc_admin_script', plugins_url('', __FILE__) . '/admin.js', ['jquery']);

    wp_enqueue_media();
}

function plugin_section_text_wnd_calc()
{
    //echo '<p>Main description of this section here.</p>';
}

function plugin_wnd_calc_accessories_func()
{
    showChangeOptionTable('accessories');
}

function plugin_wnd_calc_slopes_func()
{
    showChangeOptionTable('slopes');
}

function plugin_wnd_calc_furniture_func()
{
    showChangeOptionTable('furniture');
}

function plugin_wnd_calc_setting_func()
{
    showChangeOptionTable('setting');
}

function plugin_wnd_calc_otliv_func()
{
    showChangeOptionTable('otliv');
}

function plugin_wnd_calc_sill_func()
{
    showChangeOptionTable('sill');
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
    $options = get_option('plugin_options_wnd_calc', $GLOBALS['defaultWndCalcOptions']);
    $s = '<table class="wnd_calc_wnd_options"><thead><tr><th>Название</th><th>Цена</th><th>&nbsp;</th><th>Высота</th><th>Частей</th><th><input class="calc_wnd_option_type" type="hidden" value="window"></th></tr></thead><tbody>';
    if (!empty($options['window'])) {
        foreach ($options['window']['name'] as $key => $pf) {
            $panes = isset($options['window']['panes'][$key]) ? $options['window']['panes'][$key] : [];
            $s .= '<tr>'
                . '<td>'
                . '<input class="name_wnd_option" type="text" value="' . esc_html($pf) . '" name="plugin_options_wnd_calc[window][name][]" readonly="readonly">'
                . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                . '</td>'
                . '<td>'
                . '<input type="text" value="' . esc_html($options['window']['price'][$key]) . '" name="plugin_options_wnd_calc[window][price][]" readonly="readonly">'
                . '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать">'
                . '</td>'
                . '<td class="tbl_center">'
                . '<input type="hidden" value="' . esc_html($options['window']['id_small'][$key]) . '" name="plugin_options_wnd_calc[window][id_small][]">'
                . '<input type="hidden" value="' . esc_html($options['window']['src_small'][$key]) . '" name="plugin_options_wnd_calc[window][src_small][]">'
                . '<img alt="" src="' . esc_html($options['window']['src_small'][$key]) . '" class="mod_wnd_option_class_preview_image" title="Нажмите чтобы увеличить">'
                . '<div><button class="mod_wnd_option_change_preview_image" title="Добавить/изменить маленькое окно">Мал. окно</button></div>'
                . '</td>'
                . '<td>'
                . '<input class="name_wnd_option" type="text" value="' . esc_html($options['window']['height'][$key]) . '" name="plugin_options_wnd_calc[window][height][]" readonly="readonly">'
                . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                . '</td>'
                . '<td>'
                //. '<input class="name_wnd_option" type="number" min="1" max="50" value="' . esc_html($options['window']['number_of_panes'][$key]) . '" name="plugin_options_wnd_calc[window][number_of_panes][]" readonly="readonly">'
                . '<input class="name_wnd_option" type="number" min="1" max="50" value="' . count($panes) . '" name="plugin_options_wnd_calc[window][number_of_panes][]" readonly="readonly">'
                . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                . '</td>'
                /*. '<td class="tbl_center">'
                . '<input type="hidden" value="' . esc_html($options['window']['id_big'][$key]) . '" name="plugin_options_wnd_calc[window][id_big][]">'
                . '<input type="hidden" value="' . esc_html($options['window']['src_big'][$key]) . '" name="plugin_options_wnd_calc[window][src_big][]">'
                . '<img alt="" src="' . esc_html($options['window']['src_big'][$key]) . '" class="mod_wnd_option_class_preview_image" title="Нажмите чтобы увеличить">'
                . '<div><button class="mod_wnd_option_change_preview_image" title="Добавить/изменить большое окно">Бол. окно</button></div>'
                . '</td>'*/
                . '<td class="tbl_center"><button class="rem_wnd_option">Удалить</button></td>'
                . '</tr>';


            $s .= '<tr style="text-align: right"><td colspan="6">'
                . '<table style="width:90%">'
                //. '<thead<tr><th>Название</th></tr><tr><th>Типов</th></tr></thead>'
                . '<tbody>';
            if ($panes) {
                foreach ($panes as $keyPane => $pane) {
                    $subtypes = isset($pane['subtypes']) ? $pane['subtypes'] : [];
                    $s .= '<tr>'
                        . '<td style="text-align:right">Количество подтипов: '
                        . '<input type="number" min="1" max="50" value="' . count($subtypes) . '" name="plugin_options_wnd_calc[window][panes][' . $key . '][number_of_subtypes]" readonly="readonly">'
                        . '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать">'
                        . '</td>'
                        . '</tr>';
                }
            }
            $s .= '</tbody>'
                . '</table>'
                . '</td></tr>';
        }
    }
}

$s .= '</tbody></table><button class="wnd_calc_wnd_option_add_window">Добавить</button>';

echo $s;
}

function showChangeOptionTable($id)
{
    $options = get_option('plugin_options_wnd_calc', $GLOBALS['defaultWndCalcOptions']);
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
                . '<td class="tbl_center"><button class="rem_wnd_option">Удалить</button></td>'
                . '</tr>';
        }
    }

    $s .= '</tbody></table><button class="wnd_calc_wnd_option_add">Добавить</button>';

    echo $s;
}

/*function plugin_options_validate_wnd_calc($input)
{
    $newInput = $input;
    $newInput['text_string'] = trim($input['text_string']);
    return $newInput;
}*/


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
