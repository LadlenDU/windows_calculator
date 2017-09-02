jQuery(function ($) {

    var lw = wndSelPluginPath + '/img/width-left.png';
    var rw = wndSelPluginPath + '/img/width-right.png';
    var th = wndSelPluginPath + '/img/height-top.png';
    var bh = wndSelPluginPath + '/img/height-bottom.png';
    var thl = wndSelPluginPath + '/img/height-top-left.png';
    var bhl = wndSelPluginPath + '/img/height-bottom-left.png';

    $(".wnd_calc_prev_window").click(function () {
        selectWindow($(this).data('id'));
        $(".wnd_calc_hide_sizes").prop('checked', true);
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
            if (!pane.hasOwnProperty(key)) {
                continue;
            }
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
            if (!characteristics.hasOwnProperty(key)) {
                continue;
            }
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
                if (!accessories.hasOwnProperty(key)) {
                    continue;
                }
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
        $(".wnd_calc_size_wh").unbind('change').change(function () {
            calculatePrice();
        });
        $(".wnd_sel_pane_wnd").unbind('click').click(function () {
            var wndNum = $(this).data('wnd-id'),
                paneNum = $(this).data('pane-id'),
                subpaneNum = $(this).data('subpane-id');
            var index = subpaneNum + 1;
            if (!wndSelVariables.window.panes.subtypes.src_image[wndNum][paneNum][index]) {
                index = 0;
            }

            // var par = $(this).parent().attr('style');
            // var matches = par.match(/top:\s*(.+?);/);
            // var top = matches[1] || 0;

            //var html = generatePane(wndNum, paneNum, index, top);
            var html = generatePane(wndNum, paneNum, index);
            $(this).parent().parent().replaceWith(html);
            /*if ($(".wnd_calc_window_item").data('height-different')) {
             $(this).parent().parent().replaceWith(html);
             } else {
             $(this).parent().replaceWith(html);
             }*/
            setHeightElement(wndNum);
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

        //var windowPrice = 0;    // стоимость окна (по площади + доп. цены) - руб.
        var windowSquare = 0;   // площадь окна (сумма площади всех панелей) - кв.м.
        var windowWidth = 0;    // общая ширина окна - п.м.
        var windowPanesHeight = 0;    // суммарная высота отдельных блоков

        // окна
        tmpPrice = parseFloat($(".wnd_calc_prev_window.wnd_calc_selected").data('price')) || 0;
        elements.window_type.push({name: $(".wnd_calc_prev_window.wnd_calc_selected").data('name'), price: tmpPrice});
        price += tmpPrice;
        //windowPrice += tmpPrice;

        // панели

        //if ($(".wnd_calc_window_item").data('height-different')) {  // для окон с различной высотой
        if (true) {
            // цена и ширина
            $(".wnd_calc_window_item .wnd_sel_pane_wnd").each(function () {
                var panel = $(this);

                var ifTopPanel = whetherTopPanel(panel.data('wnd-id'), panel.data('pane-id'));

                // высота
                if ($(".wnd_calc_window_item").data('height-different') || ifTopPanel) {

                    var heightElement = panel.parent().parent().find('> .wnd_calc_size_element input');
                    heightElement.val($.trim(heightElement.val()));
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
                        //console.log("heHeight: " + heHeight);
                        heHeight = heHeightMax;
                        heightElement.val(heHeight);
                        alert('Вы ввели слишком большую высоту - высота приведена к максимально возможному значению.');
                    }
                } else {
                    var heightElement = $(".wnd_calc_window_item").find(".wnd_sel_wnd_height").last();
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
                }

                // цена
                tmpPrice = parseFloat(panel.data('pane-price')) || 0;
                //elements.window_panes.push({name: 'Оконная панель ' + (index + 1), price: tmpPrice});
                //var paneInfo = {name: 'Оконная панель ' + (index + 1), price: tmpPrice, height: heHeight};
                var paneInfo = {panel: panel, if_top_panel: ifTopPanel, price: tmpPrice, height: heHeight};
                if (!ifTopPanel) {
                    price += tmpPrice;
                }
                //windowPrice += tmpPrice;

                paneInfo.height = heHeight;
                //windowHeight += heHeight;
                //windowPanesHeight += heHeight * 2;

                // ширина
                if (!ifTopPanel) {
                    var widthElement = panel.parent().find('input');
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
                }

                windowPanesHeight += heHeight * 2;
                paneInfo.name = panel.data('subpane-name');

                if (!ifTopPanel) {
                    var squarePrice = parseFloat(panel.data('subpane-price')) || 0;
                    var square = (heHeight / 1000) * (weWidth / 1000);
                    windowSquare += square;
                    tmpPrice = squarePrice * square;
                    //elements.push({name: $(this).data('subpane-name'), price: tmpPrice});
                    //paneInfo.name = $(this).data('subpane-name');
                    paneInfo.price_square = tmpPrice;
                    price += tmpPrice;
                    //windowPrice += tmpPrice;
                }

                elements.window_panes.push(paneInfo);
            });
        } else {

            // высота
            var heightElement = $(".wnd_calc_window_item").find(".wnd_sel_wnd_height").last();
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

                if (whetherTopPanel(panel.data('wnd-id'), panel.data('pane-id'))) {
                    return;
                }

                // цена
                tmpPrice = parseFloat(panel.data('pane-price')) || 0;
                //elements.window_panes.push({name: 'Оконная панель ' + (index + 1), price: tmpPrice});
                //var paneInfo = {name: 'Оконная панель ' + (index + 1), price: tmpPrice, height: heHeight};
                var paneInfo = {price: tmpPrice, height: heHeight};
                price += tmpPrice;
                //windowPrice += tmpPrice;

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
                windowPanesHeight += heHeight * 2;

                var squarePrice = parseFloat($(this).data('subpane-price')) || 0;
                var square = (heHeight / 1000) * (weWidth / 1000);
                windowSquare += square;
                tmpPrice = squarePrice * square;
                //elements.push({name: $(this).data('subpane-name'), price: tmpPrice});
                paneInfo.name = $(this).data('subpane-name');
                paneInfo.price_square = tmpPrice;
                price += tmpPrice;
                //windowPrice += tmpPrice;

                elements.window_panes.push(paneInfo);
            });

            var selPaneId = $(".wnd_calc_prev_window.wnd_calc_selected").data('id');
            if (whetherTopPanel(selPaneId, 0)) {
                var panel = $(".wnd_sel_pane_wnd[data-wnd-id=" + selPaneId + "]")[0];
                panel = $(panel);

                // цена
                tmpPrice = parseFloat(panel.data('pane-price')) || 0;
                price += tmpPrice;

                var heightElement = panel.parent().parent().find('> .wnd_calc_size_element input');
                heightElement.val($.trim(heightElement.val()));
                var heHeight = parseFloat(heightElement.val()) || 0;

                var paneInfo = {price: tmpPrice, height: heHeight};

                paneInfo.width = windowWidth;
                weWidth = windowWidth;

                var squarePrice = parseFloat(panel.data('subpane-price')) || 0;
                var square = (heHeight / 1000) * (weWidth / 1000);
                windowSquare += square;
                tmpPrice = squarePrice * square;
                paneInfo.name = panel.data('subpane-name');
                paneInfo.price_square = tmpPrice;
                price += tmpPrice;

                elements.window_panes.push(paneInfo);
            }
        }

        var stalinPane = (elements.window_panes && elements.window_panes[0]);
        if (stalinPane && stalinPane.if_top_panel) {
            //elements.window_panes.push(paneInfo);
            //var stalinPane = elements.window_panes[0];
            var panel = stalinPane.panel;

            price += stalinPane.price;

            // ширина
            stalinPane.width = windowWidth;

            var squarePrice = parseFloat(panel.data('subpane-price')) || 0;
            var square = (stalinPane.height / 1000) * (stalinPane.width / 1000);
            windowSquare += square;
            tmpPrice = squarePrice * square;
            stalinPane.price_square = tmpPrice;
            price += tmpPrice;
        }

        /*var selPaneId = $(".wnd_calc_prev_window.wnd_calc_selected").data('id');
         if (whetherTopPanel(selPaneId, 0)) {
         var panel = $(".wnd_sel_pane_wnd[data-wnd-id=" + selPaneId + "]")[0];
         panel = $(panel);

         // цена
         tmpPrice = parseFloat(panel.data('pane-price')) || 0;
         price += tmpPrice;

         var heightElement = panel.parent().parent().find('> .wnd_calc_size_element input');
         heightElement.val($.trim(heightElement.val()));
         var heHeight = parseFloat(heightElement.val()) || 0;

         var paneInfo = {price: tmpPrice, height: heHeight};

         paneInfo.width = windowWidth;
         weWidth = windowWidth;

         var squarePrice = parseFloat(panel.data('subpane-price')) || 0;
         var square = (heHeight / 1000) * (weWidth / 1000);
         windowSquare += square;
         tmpPrice = squarePrice * square;
         paneInfo.name = panel.data('subpane-name');
         paneInfo.price_square = tmpPrice;
         price += tmpPrice;

         elements.window_panes.push(paneInfo);
         }*/

        //TODO: tmpPrice => tmpKoeff и т.п.

        // характеристики
        tmpPrice = parseFloat($("#wnd_calc_select_profile").val()) || 0;
        elements.characteristics.push({
            name: 'Профиль',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_profile option:selected").text()
        });
        //price += tmpPrice;
        //var p2 = windowPrice * tmpPrice;
        price *= tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_furniture").val()) || 0;
        elements.characteristics.push({
            name: 'Фурнитура',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_furniture option:selected").text()
        });
        //price += tmpPrice;
        /*var p3 = p2 * tmpPrice;
         if (!tmpPrice) {
         p3 = p2;
         }
         price += p3;*/
        if (!tmpPrice) {
            tmpPrice = 1;
        }
        price *= tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_dglazed").val()) || 0;
        elements.characteristics.push({
            name: 'Стеклопакет',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_dglazed option:selected").text()
        });
        //price += tmpPrice;
        //var p4 = p3 * tmpPrice;
        //price += p4;
        price *= tmpPrice;

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
        price += (windowWidth + 200) / 1000 * tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_otliv").val()) || 0;
        elements.characteristics.push({
            name: 'Отлив',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_otliv option:selected").text()
        });
        //price += tmpPrice;
        price += (windowWidth + 100) / 1000 * tmpPrice;

        tmpPrice = parseFloat($("#wnd_calc_select_slopes").val()) || 0;
        elements.characteristics.push({
            name: 'Откосы',
            price: tmpPrice,
            item_name: $("#wnd_calc_select_slopes option:selected").text()
        });
        //price += tmpPrice;
        price += (windowPanesHeight + windowWidth + 200) / 1000 * tmpPrice;

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

    //function generatePane(wndNum, paneNum, subpaneNum, top) {
    function generatePane(wndNum, paneNum, subpaneNum) {
        var src = wndSelVariables.window.panes.subtypes.src_image[wndNum][paneNum][subpaneNum];
        var panePrice = wndSelVariables.window.panes.price[wndNum][paneNum];
        var subPaneName = wndSelVariables.window.panes.subtypes.name[wndNum][paneNum][subpaneNum];
        var subPanePrice = wndSelVariables.window.panes.subtypes.price[wndNum][paneNum][subpaneNum];
        //var html = '<div style="position: relative; display: inline-block; line-height: 0; top: ' + (top || 0) + ';">'

        var ifTopPanel = whetherTopPanel(wndNum, paneNum);

        //var css = ifTopPanel ? 'left:-35px;' : '';

        var szClass = (paneNum == 0) ? 'wnd_calc_right_pane_elem' : 'wnd_calc_left_pane_elem';

        var html = '<div style="position: relative; display: inline-block; line-height: 0; vertical-align: top;">'
            //+ '<div style="display: inline-block; float: left">'
            //+ '<div class="' + szClass + '" style="' + css + '">'
            + '<div class="' + szClass + '">'
            + '<img class="wnd_sel_pane_wnd" src="' + $("<div>").text(src).html()
            + '" alt="" data-wnd-id="' + wndNum + '" data-pane-id="' + paneNum + '" data-subpane-id="' + subpaneNum
            + '" data-pane-price="' + panePrice + '" data-subpane-name="' + subPaneName
            + '" data-subpane-price="' + subPanePrice + '">';
        if (!ifTopPanel) {
            html += '<div class="wnd_calc_size_element" style="height:50px;width:100%;position:relative;">'
                + '<img style="position:absolute;left:0;top:0" src="' + lw + '" alt="">'
                + '<img style="position:absolute;right:0;top:0" src="' + rw + '" alt="">'
                + '<div style="width:100%;height:1px;background-color:#d7d7d7;position:absolute;left:0;top:34px;"></div>'
                + '<input class="wnd_calc_size_wh" type="text" value="' + wndSelVariables.window.panes['width'][wndNum][paneNum] + '" '
                + 'style="width:60px;height:23px;position:absolute;left:50%;top:22px;transform:translate(-50%, 0);padding:0;text-align:center;font-family:\'GOST_A_italic\',sans-serif;" '
                + 'data-width-min="' + wndSelVariables.window.panes['width-min'][wndNum][paneNum] + '" data-width-max="' + wndSelVariables.window.panes['width-max'][wndNum][paneNum] + '">'
                + '</div>'
                + '</div>'
        }

        html += '</div>';

        if (ifTopPanel) {
            html += '<br>';
        }

        return html;
    }

    function whetherTopPanel(wndNum, paneNum) {
        return (wndSelVariables.window.panes['whether-top-panel']
            && wndSelVariables.window.panes['whether-top-panel'][wndNum]
            && (wndSelVariables.window.panes['whether-top-panel'][wndNum][paneNum] === true || wndSelVariables.window.panes['whether-top-panel'][wndNum][paneNum] === 'on'));
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
            if (!info.hasOwnProperty(key)) {
                continue;
            }
            if (info[key][0]) {
                currUrl = info[key][0];
                html += generatePane(number, key, 0);
            }
        }

        $(".wnd_calc_window_item").html(html);
        setSubpaneSelectEvents();

        if (currUrl) {
            setHeightElement(number);
        }
    }

    /**
     * Прорисовка элемента высоты
     *
     * @param number
     */
    function setHeightElement(number) {
        if (wndSelVariables.window['height-different'][number]) {
            $(".wnd_calc_window_item").data('height-different', 1);
            $(".wnd_calc_window_item .wnd_sel_pane_wnd").load(function () {
                showHeightElement($(this), number);
                /*var height = $(this).height();
                 var paneId = $(this).data('pane-id');
                 var html = getHeightSizeHtml(height, number, paneId, !paneId);
                 if (paneId) {
                 $('.wnd_sel_pane_wnd[data-wnd-id="' + number + '"][data-pane-id="' + paneId + '"]').parent().after(html);
                 } else {
                 $('.wnd_sel_pane_wnd[data-wnd-id="' + number + '"][data-pane-id="' + paneId + '"]').parent().before(html);
                 }
                 setSubpaneSelectEvents();
                 calculatePrice();*/
            });
        } else {
            $(".wnd_calc_window_item").data('height-different', 0);
            if (whetherTopPanel(number, 0)) {
                $(".wnd_calc_window_item .wnd_sel_pane_wnd").first().load(function () {
                    showHeightElement($(this), number);
                });
            }
            $(".wnd_calc_window_item .wnd_sel_pane_wnd").last().load(function () {
                showHeightElement($(this), number);
                /*var height = $(this).height();
                 var paneId = $(this).data('pane-id');
                 var html = getHeightSizeHtml(height, number, paneId, false);
                 $('.wnd_sel_pane_wnd[data-wnd-id="' + number + '"][data-pane-id="' + paneId + '"]').parent().after(html);
                 setSubpaneSelectEvents();
                 calculatePrice();*/
            });
        }
    }

    function showHeightElement(jqElem, wndNum) {
        var height = jqElem.height();
        var paneId = jqElem.data('pane-id');
        var html = getHeightSizeHtml(height, wndNum, paneId, !paneId);
        if (!$(".wnd_calc_window_item").data('height-different') || paneId) {
            $('.wnd_sel_pane_wnd[data-wnd-id="' + wndNum + '"][data-pane-id="' + paneId + '"]').parent().after(html);
        } else {
            $('.wnd_sel_pane_wnd[data-wnd-id="' + wndNum + '"][data-pane-id="' + paneId + '"]').parent().before(html);
        }
        setSubpaneSelectEvents();
        calculatePrice();
    }

    /**
     * Генерирует html элемента высоты
     *
     * @param height
     * @param windowNumber
     * @param paneId
     * @returns {string}
     */
    function getHeightSizeHtml(height, windowNumber, paneId, left) {
        if (typeof paneId === "undefined") {
            paneId = false;
        }
        if (typeof left === "undefined") {
            left = false;
        }

        var ifTopPanel = whetherTopPanel(windowNumber, paneId);
        paneId = ($(".wnd_calc_window_item").data('height-different') || ifTopPanel) ? paneId : false;

        var numHeight = (paneId !== false) ? wndSelVariables.window.panes.height[windowNumber][paneId] : wndSelVariables.window.height[windowNumber];
        var numHeightMin = (paneId !== false) ? wndSelVariables.window.panes['height-min'][windowNumber][paneId] : wndSelVariables.window['height-min'][windowNumber];
        var numHeightMax = (paneId !== false) ? wndSelVariables.window.panes['height-max'][windowNumber][paneId] : wndSelVariables.window['height-max'][windowNumber];

        /*var ifTopPanel = whetherTopPanel(windowNumber, paneId);
         if (ifTopPanel) {
         numHeight = wndSelVariables.window.panes.height[windowNumber][paneId];
         numHeightMin = wndSelVariables.window.panes['height-min'][windowNumber][paneId];
         numHeightMax = wndSelVariables.window.panes['height-max'][windowNumber][paneId];
         }*/

        var szClass = (paneId === 0 && !ifTopPanel) ? 'wnd_calc_left_pane_elem' : 'wnd_calc_right_pane_elem';
        /*if (ifTopPanel) {
         szClass = 'wnd_calc_right_pane_elem';
         }*/
        /*if (paneId == 0) {
         var gg = 0;
         }*/
        var thReal = (paneId === 0 && !ifTopPanel) ? thl : th;
        var bhReal = (paneId === 0 && !ifTopPanel) ? bhl : bh;

        var vLineLeft = (paneId === 0 && !ifTopPanel) ? 15 : 34;
        var vInputLeft = (paneId === 0 && !ifTopPanel) ? -10 : 10;

        var vMargin = (paneId === 0 && !ifTopPanel) ? 'margin-left: 20px;' : 'margin-right: 20px;';

        //var html = '<div class="wnd_calc_size_element" style="margin-right: 20px; vertical-align: top; display: inline-block; position: relative; width: 50px;height:' + height + 'px;">'
        var html = '<div class="wnd_calc_size_element ' + szClass + '" style="width: 50px;height:' + height + 'px;' + vMargin + '">'
            + '<img style="position:absolute;left:0;top:0" src="' + thReal + '" alt="">'
            + '<img style="position:absolute;left:0;bottom:0" src="' + bhReal + '" alt="">'
            + '<div style="height:100%;width:1px;background-color:#d7d7d7;position:absolute;left:' + vLineLeft + 'px;top:0;"></div>'
            + '<input class="wnd_sel_wnd_height wnd_calc_size_wh" type="text" value="' + numHeight + '" '
            + 'style="width:60px;height:23px;position:absolute;left:' + vInputLeft + 'px;top:50%;transform:translate(0,-50%);padding:0;text-align:center;font-family:\'GOST_A_italic\',sans-serif;" '
            + 'data-height-min="' + numHeightMin + '" data-height-max="' + numHeightMax + '">'
            + '</div>';

        return html;
    }

    $(".wnd_calc_hide_sizes").change(function () {
        if ($(this).prop('checked')) {
            $(".wnd_calc_size_element").fadeIn();
        } else {
            $(".wnd_calc_size_element").fadeOut();
        }
    });

    var id = $(".wnd_calc_window_type_select .wnd_calc_prev_window:first-child").data('id');
    selectWindow(id);

    calculatePrice();
});
