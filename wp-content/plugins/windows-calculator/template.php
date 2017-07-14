<?php
$options = get_option('plugin_options_wnd_calc');
foreach ($options as $key => $info) {
    switch ($key)
    {
        case 'profile':
            showDropdown('Профиль', $key, $info);
            break;
        case 'dglazed':
            showDropdown('Стеклопакет', $key, $info);
            break;
        default:
            break;
    }
}

function showDropdown($name, $optKey, $info) {
    echo "$name:<br>";
    echo '<select class="wnd_calc_select" id="wnd_calc_select_' . $optKey . '">';
    foreach ($info['name'] as $key => $pf) {
        echo '<option value="' . esc_html($info['price'][$key]) . '">' . esc_html($pf) . '</option>';
    }
    echo '</select><br>';
}

?>
Цена: <div id="wnd_calc_price"></div>
<script>
    jQuery(function ($) {
        function calculatePrice() {
            var price = parseFloat($("#wnd_calc_select_profile").val()) || 0;
            price += parseFloat($("#wnd_calc_select_dglazed").val()) || 0;
            $("#wnd_calc_price").text(price);
        }

        calculatePrice();

        $(".wnd_calc_select").change(function(){
            calculatePrice();
        });
    });
</script>