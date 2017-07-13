jQuery(function($){
    var wnd = $("#wnd_calc_profile");
    $("#wnd_calc_profile_add").click(function(e) {
        e.preventDefault();

        var newRow = '<tr>'
            + "<td>-</td>"
            + '<td>'
            + '<input type="text" value="" name="plugin_options_wnd_calc[\'profile\'][]">'
            + '<input type="checkbox" class="mod_profile" title="Модифицировать">'
            + '</td>'
            + '<td><button class="rem_profile">Удалить</button></td>'
            + '</tr>';

        wnd.find("tbody").append(newRow);

        return false;
    });
});