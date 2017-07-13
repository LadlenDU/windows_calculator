jQuery(function ($) {
    var wnd = $(".wnd_calc_wnd_options");
    $("#wnd_calc_profile_add").click(function (e) {
        e.preventDefault();

        var newRow = '<tr>'
            + '<td>'
            + '<input class="profile_wnd_option" type="text" value="" name="plugin_options_wnd_calc[profile][name][]">'
            + '<input type="checkbox" class="mod_wnd_option_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td>'
            + '<input type="text" value="" name="plugin_options_wnd_calc[profile][price][]">'
            + '<input type="checkbox" class="mod_wnd_option_price" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td class="delete_wnd_option"><button class="rem_wnd_option">Удалить</button></td>'
            + '</tr>';

        wnd.find("tbody").append(newRow);

        bindEventsProfile();

        return false;
    });

    function bindEventsProfile() {
        $(".wnd_calc_wnd_options .mod_wnd_option_name, .wnd_calc_wnd_options .mod_wnd_option_price").unbind('change');
        $(".wnd_calc_wnd_options .mod_wnd_option_name, .wnd_calc_wnd_options .mod_wnd_option_price").change(function () {
            $(this).prev().prop('readonly', !$(this).prop('checked'));
        });
        $(".wnd_calc_wnd_options .rem_wnd_option").unbind('click');
        $(".wnd_calc_wnd_options .rem_wnd_option").click(function (e) {
            e.preventDefault();
            var name = $(this).parent().parent().find(".profile_wnd_option");
            if (confirm('Вы уверены что хотите удалить элемент "' + name.val() + '"?')) {
                $(this).parent().parent().remove();
            }
            return false;
        });
    }

    bindEventsProfile();
});