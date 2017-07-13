jQuery(function ($) {
    var wnd = $("#wnd_calc_profile");
    $("#wnd_calc_profile_add").click(function (e) {
        e.preventDefault();

        var newRow = '<tr>'
            + '<td>'
            + '<input class="profile_text" type="text" value="" name="plugin_options_wnd_calc[profile][name][]">'
            + '<input type="checkbox" class="mod_profile_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td>'
            + '<input type="text" value="" name="plugin_options_wnd_calc[profile][price][]">'
            + '<input type="checkbox" class="mod_profile_price" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td class="delete_profile"><button class="rem_profile">Удалить</button></td>'
            + '</tr>';

        wnd.find("tbody").append(newRow);

        bindEventsProfile();

        return false;
    });

    function bindEventsProfile() {
        $("#wnd_calc_profile .mod_profile_name, #wnd_calc_profile .mod_profile_price").unbind('change');
        $("#wnd_calc_profile .mod_profile_name, #wnd_calc_profile .mod_profile_price").change(function () {
            $(this).prev().prop('readonly', !$(this).prop('checked'));
        });
        $("#wnd_calc_profile .rem_profile").unbind('click');
        $("#wnd_calc_profile .rem_profile").click(function (e) {
            e.preventDefault();
            var name = $(this).parent().parent().find(".profile_text");
            if (confirm('Вы уверены что хотите удалить элемент "' + name.val() + '"?')) {
                $(this).parent().parent().remove();
            }
            return false;
        });
    }

    bindEventsProfile();
});