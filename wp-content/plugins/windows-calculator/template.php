<?php
$options = get_option('plugin_options_wnd_calc');
if (!empty($options['profile'])) {
    echo 'Тип профиля:<br>';
    echo '<select>';
    foreach ($options['profile']['name'] as $key => $pf) {
        echo '<option value="' . esc_html($options['profile']['price'][$key]) . '">' . esc_html($pf) . '</option>';
    }
    echo '</select>';
}
?>
<script>
    jQuery(function ($) {

    });
</script>