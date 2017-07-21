jQuery(function ($) {

    var lw = wndSelPluginPath + '/img/width-left.png';
    var rw = wndSelPluginPath + '/img/width-right.png';
    var th = wndSelPluginPath + '/img/height-top.png';
    var bh = wndSelPluginPath + '/img/height-bottom.png';

    $(".wnd_calc_prev_window").click(function () {
        selectWindow($(this).data('id'));
        calculatePrice();
    });

    $(".wnd_calc_select").change(function () {
        calculatePrice();
    });


    function setSubpaneSelectEvents() {
        $(".wnd_sel_pane_wnd").unbind('click');
        $(".wnd_sel_pane_wnd").click(function () {
            var wndNum = $(this).data('wnd-id'),
                paneNum = $(this).data('pane-id'),
                subpaneNum = $(this).data('subpane-id');
            var index = subpaneNum + 1;
            if (!wndSelVariables.window.panes.subtypes.src_image[wndNum][paneNum][index]) {
                index = 0;
            }

            var html = generatePane(wndNum, paneNum, index);
            $(this).parent().replaceWith(html);
            setSubpaneSelectEvents();
        });
    }

    function calculatePrice() {
        var price = 0;
        var elements = [];

        var tmpPrice = 0;

        // окна
        tmpPrice = $(".wnd_calc_prev_window.wnd_calc_selected").data('price');
        elements.push({name: $(".wnd_calc_prev_window.wnd_calc_selected").data('name'), price: tmpPrice});
        price += tmpPrice;

        // панели
        var panel = $(".wnd_calc_window_item .wnd_sel_pane_wnd");
        tmpPrice = panel.first().data('pane-price');
        elements.push({name: 'Оконная панель', price: tmpPrice});
        price += tmpPrice;

        // высота
        var heightElement = $(this).closest(".wnd_calc_window_item").find(".wnd_sel_wnd_height");
        var heHeight = parseFloat(heightElement.val()) || 0;
        var heHeightMin = parseFloat(heightElement.data('height-min')) || 0;
        var heHeightMax = parseFloat(heightElement.data('height-max')) || 0;
        if (heHeight < heHeightMin) {
            heHeight = heHeightMin;
            heightElement.val(heHeight);
            alert('Вы ввели слишком маленькую высоту - высота приведена к минимально возможному значению.');
        } else if (heHeight > heHeightMax) {
            heHeight = heHeightMax;
            heightElement.val(heHeight);
            alert('Вы ввели слишком большую высоту - высота приведена к максимально возможному значению.');
        }

        // ширина
        panel.each(function () {
            var widthElement = $(this).parent().find('input');
            widthElement.val(trim(widthElement.val()));
            var weWidth = parseFloat(widthElement.val()) || 0;
            var weWidthMin = parseFloat(widthElement.data('width-min')) || 0;
            var weWidthMax = parseFloat(widthElement.data('width-max')) || 0;
            if (weWidth < weWidthMin) {
                weWidth = weWidthMin;
                widthElement.val(weWidth);
                alert('Вы ввели слишком маленькую ширину - ширина приведена к минимально возможному значению.');
            } else if (weWidth > weWidthMax) {
                weWidth = weWidthMax;
                widthElement.val(weWidth);
                alert('Вы ввели слишком большую ширину - ширина приведена к максимально возможному значению.');
            }

            var squarePrice = $(this).data('subpane-price');
            var square = (heHeight / 1000) * (weWidth / 1000);
            tmpPrice = squarePrice * square;
            elements.push({name: $(this).data('subpane-name'), price: tmpPrice});
            price += tmpPrice;
        });

        // характеристики
        tmpPrice = parseFloat($("#wnd_calc_select_profile").val()) || 0;
        elements.push({name: 'Профиль', price: tmpPrice});
        price += tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_dglazed").val()) || 0;
        elements.push({name: 'Стеклопакет', price: tmpPrice});
        price += tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_sill").val()) || 0;
        elements.push({name: 'Подоконник', price: tmpPrice});
        price += tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_otliv").val()) || 0;
        elements.push({name: 'Отлив', price: tmpPrice});
        price += tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_setting").val()) || 0;
        elements.push({name: 'Установка', price: tmpPrice});
        price += tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_furniture").val()) || 0;
        elements.push({name: 'Фурнитура', price: tmpPrice});
        price += tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_slopes").val()) || 0;
        elements.push({name: 'Откосы', price: tmpPrice});
        price += tmpPrice;

        // комплектующие
        $(".wnd_calc_setting_checkbox").each(function () {
            tmpPrice = $(this).data('price');
            elements.push({name: $(this).data('name'), price: tmpPrice});
            price += tmpPrice;
        });

        $("#wnd_calc_price").text($.number(price, 2, '.', ' '));
    }

    function generatePane(wndNum, paneNum, subpaneNum) {
        var src = wndSelVariables.window.panes.subtypes.src_image[wndNum][paneNum][subpaneNum];
        var panePrice = wndSelVariables.window.panes.price[wndNum][paneNum];
        var subPaneName = wndSelVariables.window.panes.subtypes.name[wndNum][paneNum][subpaneNum];
        var subPanePrice = wndSelVariables.window.panes.subtypes.price[wndNum][paneNum][subpaneNum];
        var html = '<div style="position: relative; display: inline-block; line-height: 0">'
            + '<img class="wnd_sel_pane_wnd" src="' + $("<div>").text(src).html()
            + '" alt="" data-wnd-id="' + wndNum + '" data-pane-id="' + paneNum + '" data-subpane-id="' + subpaneNum
            + '" data-pane-price="' + panePrice + '" data-subpane-name="' + subPaneName
            + '" data-subpane-price="' + subPanePrice + '">'
            + '<div style="height:50px;width:100%;position:relative;">'
            + '<img style="position:absolute;left:0;top:0" src="' + lw + '" alt="">'
            + '<img style="position:absolute;right:0;top:0" src="' + rw + '" alt="">'
            + '<div style="width:100%;height:1px;background-color:#d7d7d7;position:absolute;left:0;top:34px;"></div>'
            + '<input type="text" value="' + wndSelVariables.window.panes['width'][wndNum][paneNum] + '" '
            + 'style="width:60px;height:23px;position:absolute;left:50%;top:22px;transform:translate(-50%, 0);padding:0;text-align:center;font-family:\'GOST_A_italic\',sans-serif;" '
            + 'data-width-min="' + wndSelVariables.window.panes['width-min'][wndNum][paneNum] + '" data-width-max="' + wndSelVariables.window.panes['width-max'][wndNum][paneNum] + '">'
            + '</div>'
            + '</div>';

        return html;
    }

    function selectWindow(number) {
        $(".wnd_calc_prev_window").removeClass('wnd_calc_selected');
        $(".wnd_calc_prev_window[data-id=" + number + "]").addClass('wnd_calc_selected');

        var currUrl = '';
        var html = '';

        // построение фреймов
        var info = wndSelVariables.window.panes.subtypes.src_image[number];
        //wndSelVariables.window.panes['width-max'][number][key]
        for (var key in info) {
            if (info[key][0]) {
                currUrl = info[key][0];
                html += generatePane(number, key, 0);
            }
        }

        $(".wnd_calc_window_item").html(html);
        setSubpaneSelectEvents();

        if (currUrl) {
            $(".wnd_calc_window_item .wnd_sel_pane_wnd").last().load(function () {
                var height = $(".wnd_calc_window_item .wnd_sel_pane_wnd").last().height();
                var html = '<div style="display: inline-block; position: relative; width: 50px;height:' + height + 'px;">'
                    + '<img style="position:absolute;left:0;top:0" src="' + th + '" alt="">'
                    + '<img style="position:absolute;left:0;bottom:0" src="' + bh + '" alt="">'
                    + '<div style="height:100%;width:1px;background-color:#d7d7d7;position:absolute;left:34px;top:0;"></div>'
                    + '<input class="wnd_sel_wnd_height" type="text" value="' + wndSelVariables.window.height[number] + '" '
                    + 'style="width:60px;height:23px;position:absolute;left:5px;top:50%;transform:translate(0,-50%);padding:0;text-align:center;font-family:\'GOST_A_italic\',sans-serif;" '
                    + 'data-height-min="' + wndSelVariables.window['height-min'][number] + '" data-height-max="' + wndSelVariables.window['height-max'][number] + '">'
                    + '</div>';

                $(".wnd_calc_window_item").append(html);
                //setSubpaneSelectEvents();
            });
        }
    }

    var id = $(".wnd_calc_window_type_select .wnd_calc_prev_window:first-child").data('id');
    selectWindow(id);

    calculatePrice();
});