jQuery(function($){
    var wnd = $("#wnd_calc_profile");
    $("#wnd_calc_profile_add").click(function(e) {
        e.preventDefault();

        var newRow = '<tr>'
            + '<td>'
            + '<input type="text" value="" name="plugin_options_wnd_calc[profile][name][]">'
            + '<input type="checkbox" class="mod_profile_name" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td>'
            + '<input type="text" value="" name="plugin_options_wnd_calc[profile][price][]">'
            + '<input type="checkbox" class="mod_profile_price" title="Редактировать" checked="checked">'
            + '</td>'
            + '<td><button class="rem_profile">Удалить</button></td>'
            + '</tr>';

        wnd.find("tbody").append(newRow);

        bindEvents();

        return false;
    });

    function bindEvents() {
        $("#wnd_calc_profile .mod_profile_name, #wnd_calc_profile .mod_profile_price").unbind('change');
        $("#wnd_calc_profile .mod_profile_name, #wnd_calc_profile .mod_profile_price").change(function () {
            $(this).prev().prop('disabled', !$(this).prop('checked'));
        });
    }

    bindEvents();
});