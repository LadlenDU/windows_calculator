jQuery(function ($) {

    function htmlWindowSubPane(key, index) {
        var newRow = '<tr>'
            + '<td colspan="2" style="text-align:right">'
            + 'Имя: <input type="text" value="" name="plugin_options_wnd_calc[window][panes][subtypes][name][' + key + '][' + index + '][]">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td colspan="2" style="text-align:right">'
            + 'Цена м<sup>2</sup>: <input type="text" value="0" name="plugin_options_wnd_calc[window][panes][subtypes][price][' + key + '][' + index + '][]">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td style="text-align:right">'
            + '<input type="hidden" value="" name="plugin_options_wnd_calc[window][panes][subtypes][id_image][' + key + '][' + index + '][]">'
            + '<input type="hidden" value="" name="plugin_options_wnd_calc[window][panes][subtypes][src_image][' + key + '][' + index + '][]">'
            + '<img alt="" src="" class="mod_wnd_option_class_preview_image big" title="Нажмите чтобы увеличить">'
            + '<div><button class="mod_wnd_option_change_preview_image" title="Добавить/изменить изображение">Изображение</button></div>'
            + '</td>'
            + '</tr>';

        return newRow;
    }

    function htmlWindowPane(key, index) {
        var newRow = '<table style="width:90%;float:right;" class="wnd_calc_panes_list">'
            + '<thead>'
            + '<tr>'
            + '<th>'
            + 'Ширина:<br><input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][panes][width][' + key + '][' + index + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</th>'
            + '<th>'
            + 'Мин. ширина:<br><input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][panes][width-min][' + key + '][' + index + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</th>'
            + '<th>'
            + 'Макс. ширина:<br><input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][panes][width-max][' + key + '][' + index + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</th>'
            + '<th>'
            + 'Цена:<br><input class="name_wnd_option_short" type="text" value="0" name="plugin_options_wnd_calc[window][panes][price][' + key + '][' + index + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</th>'
            + '<th>Количество подтипов:<br>'
            + '<input class="name_wnd_option_short add_window_subpane" type="number" min="1" max="20" value="1">'
            + '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать" checked="checked">'
            + '</th>'
            + '</tr>'

            + '<tr>'
            + '<th class="wnd_calc_diff_heights_sub_cell">'
            + 'Высота:<br><input disabled="disabled" class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][panes][height][' + key + '][' + index + ']">'
            + '<input type="checkbox" disabled="disabled" class="mod_wnd_option_name" title="Редактировать">'
            + '</th>'
            + '<th class="wnd_calc_diff_heights_sub_cell">'
            + 'Мин. высота:<br><input disabled="disabled" class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][panes][height-min][' + key + '][' + index + ']">'
            + '<input type="checkbox" disabled="disabled" class="mod_wnd_option_name" title="Редактировать">'
            + '</th>'
            + '<th class="wnd_calc_diff_heights_sub_cell">'
            + 'Макс. высота:<br><input disabled="disabled" class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][panes][height-max][' + key + '][' + index + ']">'
            + '<input type="checkbox" disabled="disabled" class="mod_wnd_option_name" title="Редактировать">'
            + '</th>'
            + '<th colspan="2" style="vertical-align: middle;text-align: center" title="Верхняя панель (сталинский тип)"><label class="wnd_calc_whether_top_panel"><input type="checkbox" class="mod_wnd_option_name" name="plugin_options_wnd_calc[window][panes][whether-top-panel][' + key + '][' + index + ']">Верхняя панель</label></th>'
            + '</tr>'

            + '</thead>'
            + '<tbody>'
            + htmlWindowSubPane(key, index)
            + '</tbody>'
            + '</table>';

        return newRow;
    }

    $(".wnd_calc_wnd_option_add").click(function (e) {
        e.preventDefault();

        var oType = $(this).prev().find(".calc_wnd_option_type").val();

        var newRow = '<tr>'
            + '<td>'
            + '<input class="name_wnd_option" type="text" value="" name="plugin_options_wnd_calc[' + oType + '][name][]">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td>'
            + '<input type="text" value="" name="plugin_options_wnd_calc[' + oType + '][price][]">'
            + '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td class="tbl_center"><button class="rem_wnd_option">Удалить</button></td>'
            + '</tr>';

        $(this).prev().find("tbody").append(newRow);

        bindEventsToOptions();

        return false;
    });

    $(".wnd_calc_wnd_option_add_window").click(function (e) {
        e.preventDefault();

        //TODO: wrong
        //var key = $('[name="plugin_options_wnd_calc[window][name][]"]').length;

        var key = 0;

        var windows = $('[name^="plugin_options_wnd_calc[window][name]"]');
        windows.each(function () {
            var name = $(this).attr('name').match(/^.*\[(.+)\]$/);
            if (key < name[1]) {
                key = name[1];
            }
        });

        ++key;

        var newRow = '<tr>'
            + '<td>'
            + '<span class="wnd_small">Название</span><br>'
            + '<input class="name_wnd_option name_wnd_option_not_short" type="text" value="" name="plugin_options_wnd_calc[window][name][' + key + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td>'
            + '<span class="wnd_small">Цена</span><br>'
            + '<input class="name_wnd_option_short" type="text" value="0" name="plugin_options_wnd_calc[window][price][' + key + ']">'
            + '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td class="tbl_center">'
            + '<input type="hidden" value="" name="plugin_options_wnd_calc[window][id_small][' + key + ']">'
            + '<input type="hidden" value="" name="plugin_options_wnd_calc[window][src_small][' + key + ']">'
            + '<img alt="" src="#" class="mod_wnd_option_class_preview_image" title="Нажмите чтобы увеличить">'
            + '<div><button class="mod_wnd_option_change_preview_image" title="Добавить/изменить маленькое окно">Мал. окно</button></div>'
            + '</td>'
            + '<td>'
            + '<span class="wnd_small">Высота</span><br>'
            + '<input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][height][' + key + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'

            + '<td class="wnd_calc_diff_heights_cell">'
            + '<span class="wnd_small">Разные высоты</span><br>'
            + '<input type="checkbox" class="mod_wnd_option_name" name="plugin_options_wnd_calc[window][height-different][' + key + ']" title="Разные высоты панелей">'
            + '</td>'

            + '<td class="wnd_calc_height_rel_cell">'
            + '<span class="wnd_small">Мин. высота</span><br>'
            + '<input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][height-min][' + key + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td class="wnd_calc_height_rel_cell">'
            + '<span class="wnd_small">Макс. высота</span><br>'
            + '<input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][height-max][' + key + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td class="wnd_calc_height_rel_cell">'
            + '<span class="wnd_small">Панелей</span><br>'
            + '<input class="name_wnd_option_short add_window_pane" type="number" min="1" max="20" value="1">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td class="tbl_center"><button data-type="window" class="rem_wnd_option">Удалить</button></td>'
            + '</tr>';

        newRow += '<tr><td colspan="9" style="text-align: right">'
            + htmlWindowPane(key, 0)
            + '</td></tr>';

        $(this).prev().find("tbody").first().append(newRow);

        bindEventsToOptions();

        return false;
    });


    function bindEventsToOptions() {
        $(".wnd_calc_wnd_options .mod_wnd_option_name, .wnd_calc_wnd_options .mod_wnd_option_price").unbind('change').change(function () {
            $(this).prev().prop('readonly', !$(this).prop('checked'));
        });
        $(".wnd_calc_wnd_options .rem_wnd_option").unbind('click').click(function (e) {
            e.preventDefault();
            var curTr = $(this).parent().parent();
            var name = curTr.find(".name_wnd_option");
            var type = $(this).data('type');
            if (confirm('Вы уверены что хотите удалить элемент "' + name.val() + '"?')) {
                if (type == 'window') {
                    var panes = curTr.next();
                    curTr.remove();
                    panes.remove();
                } else {
                    curTr.remove();
                }
            }
            return false;
        });

        $(".wnd_calc_wnd_options .add_window_pane").unbind('change').change(function () {
            var curTr = $(this).parent().parent();
            var paneContainer = curTr.next().children('td');
            var currCount = paneContainer.children('table').length;
            var newCount = parseInt($(this).val()) || 0;
            if (newCount > currCount) {
                // add elements
                var nameAttr = curTr.find(".name_wnd_option").attr('name');
                var matches = nameAttr.match(/^.*\[(.+)\]$/);
                for (var i = 0; i < newCount - currCount; ++i) {
                    var html = htmlWindowPane(matches[1], currCount + i);
                    paneContainer.append(html);
                }
            } else if (newCount < currCount) {
                // remove elements
                for (var i = 0; i < currCount - newCount; ++i) {
                    paneContainer.children('table:last-child').remove();
                }
            }
            bindEventsToOptions();
        });

        $(".wnd_calc_wnd_options .add_window_subpane").unbind('change').change(function () {
            //var subpane = $(this).parents('table').first();
            var subpane = $(this).closest('table');
            var subpaneContainer = subpane.children('tbody');
            var currCount = subpaneContainer.children('tr').length;
            var newCount = parseInt($(this).val()) || 0;

            var subpaneName = subpane.find('th').first().find('input').attr('name');
            var subpaneId = subpaneName.match(/^.*\[(.+)\]$/);

            if (newCount > currCount) {
                // add elements
                //var nameAttr = $(this).parents('table').first().parents('tr').first().prev().find(".name_wnd_option").attr('name');
                var nameAttr = subpane.closest('tr').prev().find(".name_wnd_option").attr('name');
                var matches = nameAttr.match(/^.*\[(.+)\]$/);
                for (var i = 0; i < newCount - currCount; ++i) {
                    var html = htmlWindowSubPane(matches[1], subpaneId[1]);
                    subpaneContainer.append(html);
                }
            } else if (newCount < currCount) {
                // remove elements
                for (var i = 0; i < currCount - newCount; ++i) {
                    subpaneContainer.children('tr:last-child').remove();
                }
            }
            bindEventsToOptions();
        });

        // window
        $(".wnd_calc_wnd_options .mod_wnd_option_class_preview_image").unbind('click').click(function () {
            window.open($(this).attr('src'));
        });
        $(".wnd_calc_wnd_options .mod_wnd_option_change_preview_image").unbind('click').click(function (e) {
            e.preventDefault();

            var button = $(this);

            if (typeof wp.media == 'function') {
                var custom_uploader = wp.media({
                    title: 'Выбор изображения',
                    button: {
                        text: 'Добавить изображение'
                    },
                    multiple: false
                })
                    .on('select', function () {
                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                        var srcElem = button.parent();
                        srcElem.prev().attr('src', attachment.url);
                        srcElem.prev().prev().val(attachment.url);
                        srcElem.prev().prev().prev().val(attachment.id);
                    })
                    .open();
            }

            return false;
        });

        $(".wnd_calc_diff_heights_cell input").unbind('change').change(function () {
            var checked = $(this).prop('checked');
            var tr = $(this).closest('tr');
            tr.find('.wnd_calc_height_rel_cell input').prop('disabled', checked);

            tr.next('tr').find('td > table .wnd_calc_diff_heights_sub_cell input').prop('disabled', !checked);
            if (!checked) {
                var fp = tr.next().find('> td > .wnd_calc_panes_list:first-child');
                var wtp = fp.find('.wnd_calc_whether_top_panel input[type="checkbox"]');
                fp.find('.wnd_calc_diff_heights_sub_cell input').prop('disabled', !wtp.prop('checked'));
            }
        });

        $('.wnd_calc_whether_top_panel input[type="checkbox"]').unbind('change').change(function () {
            var tr = $(this).closest('tr');
            if ($(this).prop('checked')) {
                tr.find('.wnd_calc_diff_heights_sub_cell input').prop('disabled', false);
            } else {
                var el = tr.closest(".wnd_calc_panes_list").closest('tr').prev()
                    .find('.wnd_calc_diff_heights_cell input[type="checkbox"]');
                tr.find('.wnd_calc_diff_heights_sub_cell input').prop('disabled', !el.prop('checked'));
            }
        });

    }

    bindEventsToOptions();
});