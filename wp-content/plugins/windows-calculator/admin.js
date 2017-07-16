jQuery(function ($) {
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

        var key = $('[name="plugin_options_wnd_calc[window][name][]"]').length;

        var newRow = '<tr>'
            + '<td>'
            + '<input class="name_wnd_option name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][name][' + key + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td>'
            + '<input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][price][' + key + ']">'
            + '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td class="tbl_center">'
            + '<input type="hidden" value="" name="plugin_options_wnd_calc[window][id_small][' + key + ']">'
            + '<input type="hidden" value="" name="plugin_options_wnd_calc[window][src_small][' + key + ']">'
            + '<img alt="" src="#" class="mod_wnd_option_class_preview_image" title="Нажмите чтобы увеличить">'
            + '<div><button class="mod_wnd_option_change_preview_image" title="Добавить/изменить маленькое окно">Мал. окно</button></div>'
            + '</td>'
            + '<td>'
            + '<input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][height][' + key + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td>'
            + '<input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][height-min][' + key + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td>'
            + '<input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][height-max][' + key + ']">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td>'
            + '<input class="name_wnd_option_short" type="number" min="1" max="50" value="1">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td class="tbl_center"><button class="rem_wnd_option">Удалить</button></td>'
            + '</tr>';

        newRow += '<tr><td colspan="8" style="text-align: right">';

        newRow += '<table style="width:90%;float:right;">'
            + '<thead>'
            + '<tr>'
            + '<th>'
            + 'Ширина:<br><input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][panes][width][' + key + '][]">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</th>'
            + '<th>'
            + 'Мин. ширина:<br><input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][panes][width-min][' + key + '][]">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</th>'
            + '<th>'
            + 'Макс. ширина:<br><input class="name_wnd_option_short" type="text" value="" name="plugin_options_wnd_calc[window][panes][width-max][' + key + '][]">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</th>'
            + '<th>Количество подтипов:<br>'
            + '<input class="name_wnd_option_short" type="number" min="1" max="50" value="1">'
            + '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать" checked="checked">'
            + '</th>'
            + '</tr>'
            + '</thead>';

        newRow += '<tbody>';

        newRow += '<tr>'
                + '<td class="tbl_center" colspan="4" style="text-align:right">'
                + '<input type="hidden" value="" name="plugin_options_wnd_calc[window][panes][subtypes][id_image][' + key + '][0][]">'
                + '<input type="hidden" value="" name="plugin_options_wnd_calc[window][panes][subtypes][src_image][' + key + '][0][]">'
                + '<img alt="" src="" class="mod_wnd_option_class_preview_image big" title="Нажмите чтобы увеличить">'
                + '<div><button class="mod_wnd_option_change_preview_image" title="Добавить/изменить изображение">Изображение</button></div>'
                + '</td>'
                + '</tr>';

        newRow += '</tbody>';

        newRow += '</table>';

        newRow += '</td></tr>';

        $(this).prev().find("tbody").first().append(newRow);

        bindEventsToOptions();

        return false;
    });


    function bindEventsToOptions() {
        $(".wnd_calc_wnd_options .mod_wnd_option_name, .wnd_calc_wnd_options .mod_wnd_option_price").unbind('change');
        $(".wnd_calc_wnd_options .mod_wnd_option_name, .wnd_calc_wnd_options .mod_wnd_option_price").change(function () {
            $(this).prev().prop('readonly', !$(this).prop('checked'));
        });
        $(".wnd_calc_wnd_options .rem_wnd_option").unbind('click');
        $(".wnd_calc_wnd_options .rem_wnd_option").click(function (e) {
            e.preventDefault();
            var name = $(this).parent().parent().find(".name_wnd_option");
            if (confirm('Вы уверены что хотите удалить элемент "' + name.val() + '"?')) {
                $(this).parent().parent().remove();
            }
            return false;
        });
        // window
        $(".wnd_calc_wnd_options .mod_wnd_option_class_preview_image").unbind('click');
        $(".wnd_calc_wnd_options .mod_wnd_option_class_preview_image").click(function(){
            window.open($(this).attr('src'));
        });
        $(".wnd_calc_wnd_options .mod_wnd_option_change_preview_image").unbind('click');
        $(".wnd_calc_wnd_options .mod_wnd_option_change_preview_image").click(function (e) {
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
            }/* else { //fallback
                post_id = button.attr('rel');

                tb_show(button.attr('value'), 'wp-admin/media-upload.php?post_id=' + post_id + '&type=image&TB_iframe=1');

                window.send_to_editor = function (html) {
                    img = jQuery('img', html);
                    imgurl = img.attr('src');
                    classes = img.attr('class');
                    id = classes.replace(/(.*?)wp-image-/, '');
                    image.val(id).trigger('change');
                    preview.attr('src', imgurl);
                    tb_remove();
                }
            }*/

            return false;
        });

    }

    bindEventsToOptions();
});