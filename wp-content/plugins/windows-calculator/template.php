<?php

class WndCalc
{
    public $windowSelect = '';
    public $commonSelect = '';

    public $options;

    public function __construct()
    {
        $this->options = get_option('plugin_options_wnd_calc');
    }

    public function showWindows($key, $info)
    {
        $s = '';
        foreach ($info['src_small'] as $key => $link) {
            $s .= '<img class="wnd_calc_prev_window" src="' . esc_html($link) . '" alt="" data-id="' . esc_html($key)
                . '" data-name="' . $info['name'][$key] . '" data-price="' . $info['price'][$key] . '">';
        }
        $this->windowSelect = $s;
    }

    public function showAccessories($optKey, $info)
    {
        $this->commonSelect .= '<div class="wnd_calc_select_option"><div style="margin-top:10px;margin-bottom:5px;font-size:18px;">Комплектующие:</div>';
        foreach ($info['name'] as $key => $pf) {
            $id = "wnd_calc_checkbox_{$optKey}_{$key}";
            $this->commonSelect .= '<input class="wnd_calc_setting_checkbox" data-name="' . esc_html($pf) . '" data-price="' . esc_html($info['price'][$key]) . '" style="margin-left:96px" type="checkbox" id="' . esc_html($id) . '"><label class="wnd_sel_checkbox_label" for="' . esc_html($id) . '">' . esc_html($pf) . '</label><br>';
        }
        $this->commonSelect .= '</div>';
    }

    protected function showDropdown($name, $optKey, $info)
    {
        $selId = "wnd_calc_select_$optKey";
        $this->commonSelect .= '<div class="wnd_calc_select_option"><label class="wnd_calc_so_label" for="' . $selId . '">' . esc_html($name) . '</label>'
            . '<select class="wnd_calc_select" id="' . $selId . '">';
        foreach ($info['name'] as $key => $pf) {
            $this->commonSelect .= '<option value="' . esc_html($info['price'][$key]) . '">' . esc_html($pf) . '</option>';
        }
        $this->commonSelect .= '</select></div>';
    }

    public function init()
    {
        foreach ($this->options as $key => $info) {
            switch ($key) {
                case 'window':
                    $this->showWindows($key, $info);
                    break;
                case 'profile':
                    $this->showDropdown('Профиль', $key, $info);
                    break;
                case 'dglazed':
                    $this->showDropdown('Стеклопакет', $key, $info);
                    break;
                case 'sill':
                    $this->showDropdown('Подоконник', $key, $info);
                    break;
                case 'otliv':
                    $this->showDropdown('Отлив', $key, $info);
                    break;
                case 'setting':
                    $this->showDropdown('Установка', $key, $info);
                    break;
                case 'furniture':
                    $this->showDropdown('Фурнитура', $key, $info);
                    break;
                case 'slopes':
                    $this->showDropdown('Откосы', $key, $info);
                    break;
                case 'accessories':
                    $this->showAccessories($key, $info);
                    break;
                default:
                    break;
            }
        }
    }
}

$WndCalc = new WndCalc();
$WndCalc->init();

?>
<script>
    var wndSelVariables = <?php echo json_encode($WndCalc->options) ?>;
    var wndSelPluginPath = <?php echo json_encode(plugins_url('', __FILE__)) ?>;
</script>

<div class="wnd_calc_container">
    <div class="wnd_calc_container_tr">
        <div class="wnd_calc_select_wrapper">
            <div class="wnd_calc_window_type">
                <div class="wnd_calc_capt">Тип изделия</div>
                <div class="wnd_calc_window_type_select"><?php echo $WndCalc->windowSelect ?></div>
            </div>
            <div class="wnd_calc_characteristics">
                <div class="wnd_calc_capt">Характеристики</div>
                <div class="wnd_calc_characteristic"><?php echo $WndCalc->commonSelect ?></div>
            </div>
        </div>
        <div class="wnd_calc_result">
            <div class="wnd_calc_capt wnd_calc_capt_sz">Размеры</div>
            <div id="wnd_calc_window_preview">
                Чтобы поменять тип открывания кликните на створку
                <div class="wnd_calc_window_item"></div>
            </div>
            <div class="wnd_calc_price">
                <div class="wnd_calc_total">Всего:
                    <div id="wnd_calc_price"></div>
                    руб.
                </div>
                <button class="wnd_calc_order">Заказать</button>
            </div>
        </div>
    </div>
</div>

<!--<div id="contact_popup">-->
<!--<div style="position:fixed;top:0;left:0;width:100%;height:0;">-->
    <div id="wnd_calc_order_popup">
        <span class="b-close"><span>X</span></span>

        <form id="wnd_calc_order_form">
            Заказать
            <div class="form-group">
                <label for="order_name">Имя <span class="required">*</span></label>
                <input type="text" class="form-control" id="order_name" name="name" placeholder="Имя">
                <small class="help-block" style="display:none">Это поле необходимо заполнить</small>
            </div>
            <div class="form-group">
                <label for="order_email">E-mail <span class="required">*</span></label>
                <input type="email" class="form-control" id="order_email" name="email" placeholder="E-mail">
                <small class="help-block" style="display:none"></small>
            </div>
            <div class="form-group">
                <label for="order_info">Окно</label>
                <textarea class="form-control" id="order_info" rows="5" readonly="readonly"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" id="order_send" name="order_send" value="order_send">
                Отправить
            </button>
        </form>
    </div>
<!--</div>-->