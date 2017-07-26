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

    $(".wnd_calc_setting_checkbox").change(function () {
        calculatePrice();
    });

    $(".wnd_calc_order").click(function (e) {
        e.preventDefault();

        var windowEl = $("#wnd_calc_order_form [name=window]");
        var priceInfo = calculatePrice();
        var textPriceInfo = "Окно:\n";

        textPriceInfo += "    " + priceInfo.elements.window_type[0].name;
        if (priceInfo.elements.window_type[0].price) {
            textPriceInfo += " - " + formPrice(priceInfo.elements.window_type[0].price);
        }
        textPriceInfo += "\n\n" + "Панели:\n";

        var pane = priceInfo.elements.window_panes;
        for (var key in pane) {
            textPriceInfo += "    " + pane[key].name;
            if (pane[key].price) {
                textPriceInfo += " - " + formPrice(pane[key].price);
            }
            textPriceInfo += "\n";

            textPriceInfo += "        Размер: " + pane[key].width + "x" + pane[key].height + " мм\n";
            textPriceInfo += "        Цена по площади: " + formPrice(pane[key].price_square) + "\n";
        }

        textPriceInfo += "\nХарактеристики:\n";

        var characteristics = priceInfo.elements.characteristics;
        for (var key in characteristics) {
            if (characteristics[key].price) {
                //textPriceInfo += "    " + characteristics[key].name + ": " + characteristics[key].item_name + " - " + formPrice(characteristics[key].price) + "\n";
                // Временно уберем цену
                textPriceInfo += "    " + characteristics[key].name + ": " + characteristics[key].item_name + "\n";
            }
        }

        textPriceInfo += "\n";

        if (priceInfo.elements.accessories.length) {
            textPriceInfo += "Комплектующие:\n";
            var accessories = priceInfo.elements.accessories;
            for (var key in accessories) {
                if (accessories[key].price) {
                    textPriceInfo += "    " + accessories[key].name + " - " + formPrice(accessories[key].price) + "\n";
                }
            }
            textPriceInfo += "\n";
        }

        textPriceInfo += "--\nИтого: " + formPrice(priceInfo.price);
        windowEl.text(textPriceInfo);

        $('#wnd_calc_order_popup').bPopup({
            easing: 'easeOutBack',
            speed: 450,
            transition: 'slideDown'
        });
        return false;
    });

    $("#wnd_calc_order_form").submit(function (e) {
        e.preventDefault();

        var ok = true;

        var nameEl = $("#wnd_calc_order_form [name=name]");
        var emailEl = $("#wnd_calc_order_form [name=email]");

        var name = nameEl.val($.trim(nameEl.val())).val();
        var email = emailEl.val($.trim(emailEl.val())).val();

        $("#wnd_calc_order_form .help-block").hide();

        if (!name) {
            $("#wnd_calc_order_form .help-block.no_name").show();
            ok = false;
        }
        if (!email) {
            $("#wnd_calc_order_form .help-block.email").text('Это поле необходимо заполнить');
            $("#wnd_calc_order_form .help-block.email").show();
            ok = false;
        } else {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(email)) {
                $("#wnd_calc_order_form .help-block.email").text('Неправильный формат адреса');
                $("#wnd_calc_order_form .help-block.email").show();
                ok = false;
            }
        }

        if (ok) {
            $.post(wndSelPluginPath + '/ajax.php', $(this).serialize(), function (res) {
                if (res.status == 'success') {
                    $("#wnd_calc_order_popup").bPopup().close();
                    alert('Заказ успешно создан');
                    $("#wnd_calc_order_form").get(0).reset();
                } else if (res.status == 'error') {
                    alert(res.msg);
                } else if (res.status == 'captcha_error') {
                    $("#wnd_calc_order_form .help-block.captcha").show();
                }
                cptch_reload($('#wnd_calc_order_form .cptch_reload_button'));
            }).error(function () {
                alert('Произошла ошибка. Пожалуйста, повторите попытку позже.');
                cptch_reload($('#wnd_calc_order_form .cptch_reload_button'));
            });
        }

        return false;
    });

    function formPrice(price) {
        return $.number(price, 2, '.', ' ') + " руб.";
    }

    function setSubpaneSelectEvents() {
        $(".wnd_calc_size_wh").unbind('change');
        $(".wnd_calc_size_wh").change(function () {
            calculatePrice();
        });
        $(".wnd_sel_pane_wnd").unbind('click');
        $(".wnd_sel_pane_wnd").click(function () {
            var wndNum = $(this).data('wnd-id'),
                paneNum = $(this).data('pane-id'),
                subpaneNum = $(this).data('subpane-id');
            var index = subpaneNum + 1;
            if (!wndSelVariables.window.panes.subtypes.src_image[wndNum][paneNum][index]) {
                index = 0;
            }

            var par = $(this).parent().attr('style');
            var matches = par.match(/top:\s*(.+?);/);
            var top = matches[1] || 0;

            var html = generatePane(wndNum, paneNum, index, top);
            $(this).parent().replaceWith(html);
            setSubpaneSelectEvents();
            calculatePrice();
        });
    }

    function calculatePrice() {
        var price = 0;
        var elements = {
            window_type: [],
            window_panes: [],
            //window_subpanes: [],
            characteristics: [],
            accessories: []
        };

        var tmpPrice = 0;

        var windowPrice = 0;    // стоимость окна (по площади + доп. цены) - руб.
        var windowSquare = 0;   // площадь окна (сумма площади всех панелей) - кв.м.
        var windowWidth = 0;    // общая ширина окна - п.м.
        var windowPanesHeight = 0;    // суммарная высота отдельных блоков

        // окна
        tmpPrice = parseFloat($(".wnd_calc_prev_window.wnd_calc_selected").data('price')) || 0;
        elements.window_type.push({name: $(".wnd_calc_prev_window.wnd_calc_selected").data('name'), price: tmpPrice});
        price += tmpPrice;
        windowPrice += tmpPrice;

        // панели

        // высота
        var heightElement = $(".wnd_calc_window_item").find(".wnd_sel_wnd_height");
        var heHeight = parseFloat(heightElement.val()) || 0;
        if (!heHeight) {
            // скорее всего высота не подгрузилась
            return;
        }
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

        // цена и ширина
        $(".wnd_calc_window_item .wnd_sel_pane_wnd").each(function () {
            var panel = $(this);

            // цена
            tmpPrice = parseFloat(panel.data('pane-price')) || 0;
            //elements.window_panes.push({name: 'Оконная панель ' + (index + 1), price: tmpPrice});
            //var paneInfo = {name: 'Оконная панель ' + (index + 1), price: tmpPrice, height: heHeight};
            var paneInfo = {price: tmpPrice, height: heHeight};
            price += tmpPrice;
            windowPrice += tmpPrice;

            // ширина
            var widthElement = $(this).parent().find('input');
            widthElement.val($.trim(widthElement.val()));
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

            paneInfo.width = weWidth;
            windowWidth += weWidth;
            windowPanesHeight += heHeight;

            var squarePrice = parseFloat($(this).data('subpane-price')) || 0;
            var square = (heHeight / 1000) * (weWidth / 1000);
            windowSquare += square;
            tmpPrice = squarePrice * square;
            //elements.push({name: $(this).data('subpane-name'), price: tmpPrice});
            paneInfo.name = $(this).data('subpane-name');
            paneInfo.price_square = tmpPrice;
            price += tmpPrice;
            windowPrice += tmpPrice;

            elements.window_panes.push(paneInfo);
        });

        // характеристики
        tmpPrice = parseFloat($("#wnd_calc_select_profile").val()) || 0;
        elements.characteristics.push({
            name: 'Профиль',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_profile option:selected").text()
        });
        //price += tmpPrice;
        price += windowPrice * tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_furniture").val()) || 0;
        elements.characteristics.push({
            name: 'Фурнитура',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_furniture option:selected").text()
        });
        //price += tmpPrice;
        price += windowPrice * tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_dglazed").val()) || 0;
        elements.characteristics.push({
            name: 'Стеклопакет',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_dglazed option:selected").text()
        });
        //price += tmpPrice;
        price += windowPrice * tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_setting").val()) || 0;
        elements.characteristics.push({
            name: 'Установка',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_setting option:selected").text()
        });
        //price += tmpPrice;
        price += windowSquare * tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_sill").val()) || 0;
        elements.characteristics.push({
            name: 'Подоконник',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_sill option:selected").text()
        });
        //price += tmpPrice;
        price += (windowWidth + (200 / 1000)) * tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_otliv").val()) || 0;
        elements.characteristics.push({
            name: 'Отлив',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_otliv option:selected").text()
        });
        //price += tmpPrice;
        price += (windowWidth + (100 / 1000)) * tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_slopes").val()) || 0;
        elements.characteristics.push({
            name: 'Откосы',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_slopes option:selected").text()
        });
        //price += tmpPrice;
        price += (windowPanesHeight + windowWidth + (200 / 1000)) * tmpPrice;

        // комплектующие
        $(".wnd_calc_setting_checkbox").each(function () {
            if ($(this).prop('checked')) {
                tmpPrice = parseFloat($(this).data('price')) || 0;
                elements.accessories.push({name: $(this).data('name'), price: tmpPrice});
                price += tmpPrice;
            } else {
                tmpPrice = 0;
            }
        });

        $("#wnd_calc_price").text($.number(price, 2, '.', ' '));

        return {price: price, elements: elements};
    }

    function generatePane(wndNum, paneNum, subpaneNum, top) {
        var src = wndSelVariables.window.panes.subtypes.src_image[wndNum][paneNum][subpaneNum];
        var panePrice = wndSelVariables.window.panes.price[wndNum][paneNum];
        var subPaneName = wndSelVariables.window.panes.subtypes.name[wndNum][paneNum][subpaneNum];
        var subPanePrice = wndSelVariables.window.panes.subtypes.price[wndNum][paneNum][subpaneNum];
        var html = '<div style="position: relative; display: inline-block; line-height: 0; top: ' + (top || 0) + ';">'
            + '<img class="wnd_sel_pane_wnd" src="' + $("<div>").text(src).html()
            + '" alt="" data-wnd-id="' + wndNum + '" data-pane-id="' + paneNum + '" data-subpane-id="' + subpaneNum
            + '" data-pane-price="' + panePrice + '" data-subpane-name="' + subPaneName
            + '" data-subpane-price="' + subPanePrice + '">'
            + '<div style="height:50px;width:100%;position:relative;">'
            + '<img style="position:absolute;left:0;top:0" src="' + lw + '" alt="">'
            + '<img style="position:absolute;right:0;top:0" src="' + rw + '" alt="">'
            + '<div style="width:100%;height:1px;background-color:#d7d7d7;position:absolute;left:0;top:34px;"></div>'
            + '<input class="wnd_calc_size_wh" type="text" value="' + wndSelVariables.window.panes['width'][wndNum][paneNum] + '" '
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
            //$(".wnd_calc_window_item .wnd_sel_pane_wnd").first().load(function () {
                $(".wnd_calc_window_item .wnd_sel_pane_wnd").last().load(function () {

                    var offset = '0px';

                    var heightLast = $(".wnd_calc_window_item .wnd_sel_pane_wnd").last().height();
                    var height = $(".wnd_calc_window_item .wnd_sel_pane_wnd").first().height();
                    //console.log("heightLast: " + heightLast + "height: " + height);
                    if (heightLast > height) {
                        $(".wnd_calc_window_item .wnd_sel_pane_wnd").each(function () {
                            var el = $(this);
                            if (el.height() != heightLast) {
                                offset = "-" + (heightLast - el.height()) + "px";
                                $(this).parent().css("top", offset);
                            }
                        });
                    }
                    var html = '<div style="display: inline-block; position: relative; width: 50px;height:' + height + 'px;top:' + offset + ';">'
                    //var html = '<div style="display: inline-block; position: relative; width: 50px;height:' + height + 'px;">'
                        + '<img style="position:absolute;left:0;top:0" src="' + th + '" alt="">'
                        + '<img style="position:absolute;left:0;bottom:0" src="' + bh + '" alt="">'
                        + '<div style="height:100%;width:1px;background-color:#d7d7d7;position:absolute;left:34px;top:0;"></div>'
                        + '<input class="wnd_sel_wnd_height wnd_calc_size_wh" type="text" value="' + wndSelVariables.window.height[number] + '" '
                        + 'style="width:60px;height:23px;position:absolute;left:5px;top:50%;transform:translate(0,-50%);padding:0;text-align:center;font-family:\'GOST_A_italic\',sans-serif;" '
                        + 'data-height-min="' + wndSelVariables.window['height-min'][number] + '" data-height-max="' + wndSelVariables.window['height-max'][number] + '">'
                        + '</div>';

                    $(".wnd_calc_window_item").append(html);
                    setSubpaneSelectEvents();
                    calculatePrice();
                });
            //});
        }
    }

    var id = $(".wnd_calc_window_type_select .wnd_calc_prev_window:first-child").data('id');
    selectWindow(id);

    calculatePrice();
});