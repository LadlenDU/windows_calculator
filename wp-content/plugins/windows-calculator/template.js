jQuery(function ($) {

    /*function escapeHtml(text) {
     return text
     .replace(/&/g, "&amp;")
     .replace(/</g, "&lt;")
     .replace(/>/g, "&gt;")
     .replace(/"/g, "&quot;")
     .replace(/'/g, "&#039;");
     }*/

    $(".wnd_calc_prev_window").click(function () {
        selectWindow($(this).data('id'));
        calculatePrice();
    });

    $(".wnd_calc_select").change(function () {
        calculatePrice();
    });

    function calculatePrice() {
        var price = parseFloat($("#wnd_calc_select_profile").val()) || 0;
        price += parseFloat($("#wnd_calc_select_dglazed").val()) || 0;
        $("#wnd_calc_price").text($.number(price, 2, '.', ' '));
    }

    function selectWindow(number) {
        $(".wnd_calc_prev_window").removeClass('wnd_calc_selected');
        $(".wnd_calc_prev_window[data-id=" + number + "]").addClass('wnd_calc_selected');

        var html = '';
        // построение фреймов
        var info = wndSelVariables.window.panes.subtypes.src_image[number];
        for (var key in info) {
            if (info[key][0]) {
                html += '<img src="' + $("<div>").text(info[key][0]).html() + '" alt="">';
            }
        }

        $(".wnd_calc_window_item").html(html);
    }

    var id = $(".wnd_calc_window_type_select .wnd_calc_prev_window:first-child").data('id');
    selectWindow(id);

    calculatePrice();
});