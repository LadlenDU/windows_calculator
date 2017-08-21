<?php
/**
 * Plugin Name: Калькулятор окон
 * Description: Вычисляет цены на окна.
 * Version: 1.1
 */

/*function wnd_calc_scripts()
{
    wp_enqueue_script('jquery');
    //wp_enqueue_script('jquery-ui-core');

    wp_enqueue_style('wnd_calc_style', plugins_url('', __FILE__) . '/template.css');
    wp_enqueue_style('wnd_calc_bpopup', plugins_url('', __FILE__) . '/bpopup.css');

    wp_enqueue_script("jquery-effects-core");
    wp_enqueue_script('wnd_calc_script', plugins_url('', __FILE__) . '/template.js', ['jquery']);
    wp_enqueue_script('wnd_calc_number_format_script', plugins_url('', __FILE__) . '/jquery.number.min.js', ['jquery']);
    wp_enqueue_script('wnd_calc_order_popup_script', plugins_url('', __FILE__) . '/jquery.bpopup.min.js', ['jquery']);
}
add_action('wp_enqueue_scripts', 'wnd_calc_scripts');*/

function wnd_calc_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-effects-core');
}

add_action('wp_enqueue_scripts', 'wnd_calc_scripts');


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
        'price' => [1.3, 1.4, 1.5, 1.6, 1.7, 1.8],
    ],
    'furniture' => [
        'name' => ['Нет', 'ROTO', 'VORNE', 'SIGENIA'],
        'price' => [1, 1.1, 1.2, 1.3],
    ],
    'dglazed' => [
        'name' => ['Стандартный', 'Энергосберегающий'],
        'price' => [2, 2.3],
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
    add_settings_field('plugin_wnd_calc_furniture', 'Фурнитура', 'plugin_wnd_calc_furniture_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_dglazed', 'Стеклопакет', 'plugin_wnd_calc_dglazed_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_setting', 'Установка', 'plugin_wnd_calc_setting_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_sill', 'Подоконник', 'plugin_wnd_calc_sill_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_otliv', 'Отлив', 'plugin_wnd_calc_otliv_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_slopes', 'Откосы', 'plugin_wnd_calc_slopes_func', 'windows_calculator', 'plugin_main_wnd_calc');
    add_settings_field('plugin_wnd_calc_accessories', 'Комплектующие', 'plugin_wnd_calc_accessories_func', 'windows_calculator', 'plugin_main_wnd_calc');

    wp_enqueue_script('jquery');

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
    showChangeOptionTable('slopes', 'price_for_window_width_height');
}

function plugin_wnd_calc_furniture_func()
{
    showChangeOptionTable('furniture', 'koeff_window_price');
}

function plugin_wnd_calc_dglazed_func()
{
    showChangeOptionTable('dglazed', 'koeff_window_price');
}

function plugin_wnd_calc_setting_func()
{
    showChangeOptionTable('setting', 'price_for_window_square');
}

function plugin_wnd_calc_otliv_func()
{
    showChangeOptionTable('otliv', 'price_for_window_width');
}

function plugin_wnd_calc_sill_func()
{
    showChangeOptionTable('sill', 'price_for_window_width');
}


function plugin_wnd_calc_profile_func()
{
    showChangeOptionTable('profile', 'koeff_window_price');
}

function plugin_wnd_calc_window_func()
{
    $options = get_option('plugin_options_wnd_calc', $GLOBALS['defaultWndCalcOptions']);
    $s = '<table class="wnd_calc_wnd_options wnd_calc_wnd_options_wnd"><thead><tr><th>Название</th><th>Цена</th><th>&nbsp;</th><th class="wnd_calc_diff_heights_cell">Разные высоты</th><th>Высота</th><th>Мин. высота</th><th>Макс. высота</th><th>Панелей</th><th><input class="calc_wnd_option_type" type="hidden" value="window"></th></tr></thead><tbody>';
    if (!empty($options['window'])) {
        foreach ($options['window']['name'] as $key => $pf) {
            $panes = isset($options['window']['panes']['width'][$key]) ? $options['window']['panes']['width'][$key] : [];
            $differentHeights = empty($options['window']['height-different'][$key]) ? '' : ' checked="checked" ';
            $diffHeightsDisabled = empty($options['window']['height-different'][$key]) ? '' : ' disabled="disabled" ';
            $diffHeightsEnabled = empty($options['window']['height-different'][$key]) ? ' disabled="disabled" ' : '';
            $s .= '<tr>'
                . '<td>'
                . '<span class="wnd_small">Название</span><br>'
                . '<input class="name_wnd_option name_wnd_option_not_short" type="text" value="' . esc_html($pf) . '" name="plugin_options_wnd_calc[window][name][' . $key . ']" readonly="readonly">'
                . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                . '</td>'
                . '<td>'
                . '<span class="wnd_small">Цена</span><br>'
                . '<input class="name_wnd_option_short" type="text" value="' . esc_html($options['window']['price'][$key]) . '" name="plugin_options_wnd_calc[window][price][' . $key . ']" readonly="readonly">'
                . '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать">'
                . '</td>'
                . '<td class="tbl_center">'
                . '<input type="hidden" value="' . esc_html($options['window']['id_small'][$key]) . '" name="plugin_options_wnd_calc[window][id_small][' . $key . ']">'
                . '<input type="hidden" value="' . esc_html($options['window']['src_small'][$key]) . '" name="plugin_options_wnd_calc[window][src_small][' . $key . ']">'
                . '<img alt="" src="' . esc_html($options['window']['src_small'][$key]) . '" class="mod_wnd_option_class_preview_image" title="Нажмите чтобы увеличить">'
                . '<div><button class="mod_wnd_option_change_preview_image" title="Добавить/изменить маленькое окно">Мал. окно</button></div>'
                . '</td>'

                . '<td class="wnd_calc_diff_heights_cell">'
                . '<span class="wnd_small">Разные высоты</span><br>'
                . '<input type="checkbox" class="mod_wnd_option_name" ' . $differentHeights . ' name="plugin_options_wnd_calc[window][height-different][' . $key . ']" title="Разные высоты панелей">'
                . '</td>'

                . '<td class="wnd_calc_height_rel_cell">'
                . '<span class="wnd_small">Высота</span><br>'
                . '<input ' . $diffHeightsDisabled . ' class="name_wnd_option_short" type="text" value="' . esc_html($options['window']['height'][$key]) . '" name="plugin_options_wnd_calc[window][height][' . $key . ']" readonly="readonly">'
                . '<input ' . $diffHeightsDisabled . ' type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                . '</td>'
                . '<td class="wnd_calc_height_rel_cell">'
                . '<span class="wnd_small">Мин. высота</span><br>'
                . '<input ' . $diffHeightsDisabled . ' class="name_wnd_option_short" type="text" value="' . esc_html($options['window']['height-min'][$key]) . '" name="plugin_options_wnd_calc[window][height-min][' . $key . ']" readonly="readonly">'
                . '<input ' . $diffHeightsDisabled . ' type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                . '</td>'
                . '<td class="wnd_calc_height_rel_cell">'
                . '<span class="wnd_small">Макс. высота</span><br>'
                . '<input ' . $diffHeightsDisabled . ' class="name_wnd_option_short" type="text" value="' . esc_html($options['window']['height-max'][$key]) . '" name="plugin_options_wnd_calc[window][height-max][' . $key . ']" readonly="readonly">'
                . '<input ' . $diffHeightsDisabled . ' type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                . '</td>'
                . '<td>'
                . '<span class="wnd_small">Панелей</span><br>'
                . '<input class="name_wnd_option_short add_window_pane" type="number" min="1" max="20" value="' . count($panes) . '" readonly="readonly">'
                . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                . '</td>'
                . '<td class="tbl_center"><button data-type="window" class="rem_wnd_option">Удалить</button></td>'
                . '</tr>';

            $s .= '<tr><td colspan="9" style="text-align: right">';

            if ($panes) {
                foreach ($panes as $keyPane => $pane) {
                    $subtypes = isset($options['window']['panes']['subtypes']['id_image'][$key][$keyPane]) ? $options['window']['panes']['subtypes']['id_image'][$key][$keyPane] : [];

                    $s .= '<table style="width:90%;float:right;" class="wnd_calc_panes_list">'
                        . '<thead>'
                        . '<tr>'
                        . '<th>'
                        . 'Ширина:<br><input class="name_wnd_option_short" type="text" value="' . esc_html($pane) . '" name="plugin_options_wnd_calc[window][panes][width][' . $key . '][' . $keyPane . ']" readonly="readonly">'
                        . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                        . '</th>'
                        . '<th>'
                        . 'Мин. ширина:<br><input class="name_wnd_option_short" type="text" value="' . esc_html($options['window']['panes']['width-min'][$key][$keyPane]) . '" name="plugin_options_wnd_calc[window][panes][width-min][' . $key . '][' . $keyPane . ']" readonly="readonly">'
                        . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                        . '</th>'
                        . '<th>'
                        . 'Макс. ширина:<br><input class="name_wnd_option_short" type="text" value="' . esc_html($options['window']['panes']['width-max'][$key][$keyPane]) . '" name="plugin_options_wnd_calc[window][panes][width-max][' . $key . '][' . $keyPane . ']" readonly="readonly">'
                        . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                        . '</th>'
                        . '<th>'
                        . 'Цена:<br><input class="name_wnd_option_short" type="text" value="' . esc_html($options['window']['panes']['price'][$key][$keyPane]) . '" name="plugin_options_wnd_calc[window][panes][price][' . $key . '][' . $keyPane . ']" readonly="readonly">'
                        . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                        . '</th>'
                        . '<th>Количество подтипов:<br>'
                        . '<input class="name_wnd_option_short add_window_subpane" type="number" min="1" max="20" value="' . count($subtypes) . '" readonly="readonly">'
                        . '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать">'
                        . '</th>'
                        . '</tr>'

                        . '<tr>'
                        . '<th class="wnd_calc_diff_heights_sub_cell">'
                        . 'Высота:<br><input ' . $diffHeightsEnabled . ' class="name_wnd_option_short" type="text" value="' . esc_html($options['window']['panes']['height'][$key][$keyPane]) . '" name="plugin_options_wnd_calc[window][panes][height][' . $key . '][' . $keyPane . ']" readonly="readonly">'
                        . '<input type="checkbox" ' . $diffHeightsEnabled . ' class="mod_wnd_option_name" title="Редактировать">'
                        . '</th>'
                        . '<th class="wnd_calc_diff_heights_sub_cell">'
                        . 'Мин. высота:<br><input ' . $diffHeightsEnabled . ' class="name_wnd_option_short" type="text" value="' . esc_html($options['window']['panes']['height-min'][$key][$keyPane]) . '" name="plugin_options_wnd_calc[window][panes][height-min][' . $key . '][' . $keyPane . ']" readonly="readonly">'
                        . '<input type="checkbox" ' . $diffHeightsEnabled . ' class="mod_wnd_option_name" title="Редактировать">'
                        . '</th>'
                        . '<th class="wnd_calc_diff_heights_sub_cell">'
                        . 'Макс. высота:<br><input ' . $diffHeightsEnabled . ' class="name_wnd_option_short" type="text" value="' . esc_html($options['window']['panes']['height-max'][$key][$keyPane]) . '" name="plugin_options_wnd_calc[window][panes][height-max][' . $key . '][' . $keyPane . ']" readonly="readonly">'
                        . '<input type="checkbox" ' . $diffHeightsEnabled . ' class="mod_wnd_option_name" title="Редактировать">'
                        . '</th>'
                        . '<th colspan="2" style="vertical-align: middle;text-align: center" title="Верхняя панель (сталинский тип)"><label class="wnd_calc_whether_top_panel"><input type="checkbox" class="mod_wnd_option_name" name="plugin_options_wnd_calc[window][panes][whether-top-panel][' . $key . '][' . $keyPane . ']">Верхняя панель</label></th>'
                        . '</tr>'

                        . '</thead>'
                        . '<tbody>';

                    foreach ($subtypes as $keySubtype => $sbtype) {
                        $src = $options['window']['panes']['subtypes']['src_image'][$key][$keyPane][$keySubtype];
                        $price = $options['window']['panes']['subtypes']['price'][$key][$keyPane][$keySubtype];
                        $name = $options['window']['panes']['subtypes']['name'][$key][$keyPane][$keySubtype];
                        $s .= '<tr>'
                            . '<td colspan="2" style="text-align:right">'
                            . 'Имя: <input type="text" value="' . esc_html($name) . '" name="plugin_options_wnd_calc[window][panes][subtypes][name][' . $key . '][' . $keyPane . '][]" readonly="readonly">'
                            . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                            . '</td>'
                            . '<td colspan="2" style="text-align:right">'
                            . 'Цена м<sup>2</sup>: <input type="text" value="' . esc_html($price) . '" name="plugin_options_wnd_calc[window][panes][subtypes][price][' . $key . '][' . $keyPane . '][]" readonly="readonly">'
                            . '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать">'
                            . '</td>'
                            . '<td style="text-align:right">'
                            . '<input type="hidden" value="' . esc_html($sbtype) . '" name="plugin_options_wnd_calc[window][panes][subtypes][id_image][' . $key . '][' . $keyPane . '][]">'
                            . '<input type="hidden" value="' . esc_html($src) . '" name="plugin_options_wnd_calc[window][panes][subtypes][src_image][' . $key . '][' . $keyPane . '][]">'
                            . '<img alt="" src="' . esc_html($src) . '" class="mod_wnd_option_class_preview_image big" title="Нажмите чтобы увеличить">'
                            . '<div><button class="mod_wnd_option_change_preview_image" title="Добавить/изменить изображение">Изображение</button></div>'
                            . '</td>'
                            . '</tr>';
                    }

                    $s .= '</tbody>';

                    $s .= '</table>';
                }
            } else {
                $s .= '&nbsp;';
            }
            $s .= '</td></tr>';
        }
    }

    $s .= '</tbody></table><button class="wnd_calc_wnd_option_add_window">Добавить</button>';

    echo $s;
}

/**
 * @param $id
 * @param string $priceType тип цены: [
 *      'koeff_window_price', - коэффициент удорожания от стоимости окна
 *      'price_for_window_square', - цена за площадь окна (кв. м.)
 *      'price_for_window_width', - цена за ширину окна (п. м.)
 *      'price_for_window_width_height', - цена за ширину окна + высота блоков (п. м.)
 *      'price_for_item' - цена за штуку
 *  ]
 */
function showChangeOptionTable($id, $priceType = 'price_for_item')
{
    $options = get_option('plugin_options_wnd_calc', $GLOBALS['defaultWndCalcOptions']);

    switch ($priceType) {
        case 'koeff_window_price':
            $priceCaption = 'Коэфф. от ст-сти окна';
            break;
        case 'price_for_window_square':
            //, - цена за площадь окна (кв. м.)
            $priceCaption = 'Цена за кв.м. окна';
            break;
        case 'price_for_window_width':
            //, - цена за ширину окна (п. м.)
            $priceCaption = 'Цена за п.м. окна';
            break;
        case 'price_for_window_width_height':
            //, - цена за ширину окна + высота блоков (п. м.)
            $priceCaption = 'Цена за ширину и высоту окна';
            break;
        default:
            $priceCaption = 'Цена за шт.';
            break;
    }

    //echo "<input id='plugin_wnd_calc_profile' name='plugin_options_wnd_calc[text_string]' size='40' type='text' value='{$options['text_string']}' />";
    $s = '<table class="wnd_calc_wnd_options"><thead><tr><th>Название</th><th>' . $priceCaption . '</th><th><input class="calc_wnd_option_type" type="hidden" value="' . $id . '"></th></tr></thead><tbody>';
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

//wp_enqueue_script('jquery');

wp_register_style('wnd_calc_style', plugins_url('', __FILE__) . '/template.css');
wp_register_style('wnd_calc_bpopup', plugins_url('', __FILE__) . '/bpopup.css');

//wp_register_script('jquery-effects-core');    // wrong params
wp_register_script('wnd_calc_script', plugins_url('', __FILE__) . '/template.js', ['jquery']);
wp_register_script('wnd_calc_number_format_script', plugins_url('', __FILE__) . '/jquery.number.min.js', ['jquery']);
wp_register_script('wnd_calc_order_popup_script', plugins_url('', __FILE__) . '/jquery.bpopup.min.js', ['jquery']);

function shortcode_wnd_calc()
{
    wp_enqueue_style('wnd_calc_style');
    wp_enqueue_style('wnd_calc_bpopup');

    wp_enqueue_script('wnd_calc_script');
    wp_enqueue_script('wnd_calc_number_format_script');
    wp_enqueue_script('wnd_calc_order_popup_script');

    ob_start();
    require_once 'template.php';
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode('windows_calculator', 'shortcode_wnd_calc');
