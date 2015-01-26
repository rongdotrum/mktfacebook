/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function editMember(id, url) {
    var request = {'id': id};
    if (id == undefined) {
        $('#User_login_name').val('');
        $('#User_display_name').val('');
        $('#User_location').val('');
        $('#User_email').val('');
        $('#User_birth_day').val('');
        $("#dlgEditMember").dialog('open');
    } else {
        $.getJSON(url, request, function(data) {
            $('#User_member_id').val(data.member_id);
            $('#User_login_name').val(data.login_name);
            $('#User_display_name').val(data.display_name);
            $('#User_location').val(data.location);
            $('#User_email').val(data.email);
            $('#User_birth_day').val(data.birth_day);
        });
        $("#dlgEditMember").dialog('open');
    }
}

/** Delete Member */
function deleteMember(url) {
    var id = $('#User_member_id').val();
    var request = {'id': id};
    if (confirm(confirmation)) {
        $.post(url, request, function(data) {
            if (data.success == 'yes') {
                $("#dlgEditForum").dialog('close');
                window.location = window.location;
            } else {
                alert(data.message);
            }
        }, 'json');
    }
}

/** Save Membergroup */
function saveMember(url) {
    var formdata = $('#edit-member-form').serialize();
    $.post(url, formdata, function(data) {
        if (data.success == 'yes') {
            $("#dlgEditMember").dialog('close');
            window.location = window.location;
        } else {
            settings = $('#edit-member-form').data('settings');
            $.each(settings.attributes, function() {
                $.fn.yiiactiveform.updateInput(this, data.error, $('#edit-member-form'));
            });
        }
    }, 'json');
}