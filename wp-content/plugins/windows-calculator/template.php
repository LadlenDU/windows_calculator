<?php

class WndCalc
{
    public $windowSelect = '';
    public $commonSelect = '';

    public function init()
    {
        $options = get_option('plugin_options_wnd_calc');
        foreach ($options as $key => $info) {
            switch ($key) {
                case 'window':
                    //showWindows($key, $info);
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
                    //showCheckboxes($key, $info);
                    break;
                default:
                    break;
            }
        }
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
}

$WndCalc = new WndCalc();
$WndCalc->init();

?>
Цена:
<script>
    jQuery(function ($) {
        function calculatePrice() {
            var price = parseFloat($("#wnd_calc_select_profile").val()) || 0;
            price += parseFloat($("#wnd_calc_select_dglazed").val()) || 0;
            $("#wnd_calc_price").text(price);
        }

        calculatePrice();

        $(".wnd_calc_select").change(function () {
            calculatePrice();
        });
    });
</script>

<div class="wnd_calc_container">
    <div class="wnd_calc_select">
        <div class="wnd_calc_window_type"><?php echo $WndCalc->windowSelect ?></div>
        <div class="wnd_calc_characteristic"><?php echo $WndCalc->commonSelect ?></div>
    </div>
    <div class="wnd_calc_result">
        <div id="wnd_calc_window_preview">
            Чтобы поменять тип открывания кликнете на створку
        </div>
        <div class="wnd_calc_price">
            <div id="wnd_calc_price"></div>
        </div>
    </div>
</div>
