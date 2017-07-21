jQuery(function ($) {

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

        var lw = wndSelPluginPath + '/img/width-left.png';
        var rw = wndSelPluginPath + '/img/width-right.png';
        var th = wndSelPluginPath + '/img/height-top.png';
        var bh = wndSelPluginPath + '/img/height-bottom.png';

        var currUrl = '';

        var html = '';
        // построение фреймов
        var info = wndSelVariables.window.panes.subtypes.src_image[number];
        //wndSelVariables.window.panes['width-max'][number][key]
        for (var key in info) {
            if (info[key][0]) {
                currUrl = info[key][0];
                html += '<div style="position: relative; display: inline-block; line-height: 0">'
                    + '<img class="wnd_sel_pane_wnd" src="' + $("<div>").text(info[key][0]).html() + '" alt="">'
                    + '<div style="height:50px;width:100%;position:relative;">'
                    + '<img style="position:absolute;left:0;top:0" src="' + lw + '" alt="">'
                    + '<img style="position:absolute;right:0;top:0" src="' + rw + '" alt="">'
                    + '<div style="width:100%;height:1px;background-color:#d7d7d7;position:absolute;left:0;top:34px;"></div>'
                    + '<input type="text" value="' + wndSelVariables.window.panes['width'][number][key] + '" '
                    + 'style="width:60px;height:23px;position:absolute;left:50%;top:22px;color:black;transform:translate(-50%, 0);padding:0;text-align:center;font-family:\'GOST_A_italic\',sans-serif;">'
                    + '</div>'
                    + '</div>';
            }
        }

        $(".wnd_calc_window_item").html(html);

        if (currUrl) {
            $(".wnd_calc_window_item .wnd_sel_pane_wnd").last().load(function () {
                var height = $(".wnd_calc_window_item .wnd_sel_pane_wnd").last().height();
                var html = '<div style="display: inline-block; position: relative; width: 50px;height:' + height + 'px;">'
                    + '<img style="position:absolute;left:0;top:0" src="' + th + '" alt="">'
                    + '<img style="position:absolute;left:0;bottom:0" src="' + bh + '" alt="">'
                    + '<div style="height:100%;width:1px;background-color:#d7d7d7;position:absolute;left:34px;top:0;"></div>'
                    + '</div>';

                $(".wnd_calc_window_item").append(html);
            });
        }
    }

    var id = $(".wnd_calc_window_type_select .wnd_calc_prev_window:first-child").data('id');
    selectWindow(id);

    calculatePrice();
});