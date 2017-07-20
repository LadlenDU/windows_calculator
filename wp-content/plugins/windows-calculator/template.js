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

    function selectWindow(number) {
        // построение фреймов
        for (var key in wndSelVariables.window.panes.subtypes.src_image[number]) {

        }
    }
});