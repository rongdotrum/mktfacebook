/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function editConsignBuy(id, url) {
    var request = {'id': id};
    if (id == undefined) {
        $('#ConsignBuyRequestExt_wanted_price').val('');
        $('#ConsignBuyRequestExt_fixed_price').val('');
        $('#ConsignBuyRequestExt_transaction_fee').val('');
        $('#ConsignBuyRequestExt_transaction_status').val('');
        $('#ConsignBuyRequestExt_admin_incharge').val('');
        $('#ConsignBuyRequestExt_contract_id').val('');
        $('#ConsignBuyRequestExt_member_id').val('');
        $("#dlgEditConsignBuy").dialog('open');
    } else {
        $.getJSON(url, request, function(data) {
            $('#ConsignBuyRequestExt_wanted_price').val(data.wanted_price);
            $('#ConsignBuyRequestExt_fixed_price').val(data.fixed_price);
            $('#ConsignBuyRequestExt_transaction_fee').val(data.transaction_fee);
            $('#ConsignBuyRequestExt_transaction_status').val(data.transaction_status);
            $('#ConsignBuyRequestExt_admin_incharge').val(data.admin_incharge);
            $('#ConsignBuyRequestExt_contract_id').val(data.contract_id);
            $('#ConsignBuyRequestExt_member_id').val(data.member_id);
        });
        $("#dlgEditConsignBuy").dialog('open');
    }
}

/** Delete ConsignBuy */
function deleteConsignBuy(url) {
    var contract_id = $('#ConsignBuyRequestExt_contract_id').val();
    var member_id = $('#ConsignBuyRequestExt_member_id').val();
    var id = {"contract_id": contract_id, "member_id": member_id};
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

/** Save ConsignBuygroup */
function saveConsignBuy(url) {
    var formdata = $('#edit-form').serialize();
    $.post(url, formdata, function(data) {
        if (data.success == 'yes') {
            $("#dlgEditConsignBuy").dialog('close');
            window.location = window.location;
        } else {
            settings = $('#edit-form').data('settings');
            $.each(settings.attributes, function() {
                $.fn.yiiactiveform.updateInput(this, data.error, $('#edit-form'));
            });
        }
    }, 'json');
}

function SubmitComment(_url, _contract_id, _url_reload)
{
    var content = $('#inputText').val();
    if (escape(content).replace(/\%0A/g, '') == '' || escape(content) == "%0A" || content == '' || validateSpecialChars()(content) == false)
    {
        $('#inputText').val('');
        return false;
    }
    $('#inputText').attr('disabled', 'disabled');
    var data_cm = {Content: encodeURI(content), contract_id: _contract_id, content: content}; //Array
    $.ajax({
        url: _url,
        type: "POST",
        data: data_cm,
        success: function(data, textStatus, jqXHR)
        {
            $('#inputText').removeAttr('disabled');
            $('#inputText').val('');
            if (data == 'nologin')
            {

                LoadPopUpMessage('Bạn cần đăng nhập để thực hiện chức năng này');
            }
            else
            {
                if (data != 'khong thanh cong')
                {
                    ReLoadListComment(_url_reload, _contract_id);
                }
                else
                {
                    LoadPopUpMessage('Có lỗi xảy ra trong quá trình cập nhật dữ liệu');
                }
                $('#inputText').css('height', '70px');
            }

        },
        error: function(jqXHR, textStatus, errorThrown)
        {

        }
    });
}
function LoadListComment(_url, _contract_id, _type)
{
    $('.sendComment').prepend(strloading('7px', '0px'));
    $('.sendComment button').attr('disabled', 'diabled');
    var data_cm = {contract_id: _contract_id, page: $('#page_LCM').val()}; //Array
    $.ajax({
        url: _url,
        type: "POST",
        data: data_cm,
        success: function(data, textStatus, jqXHR)
        {
            $('.sendComment button').removeAttr('disabled');
            removeloadingimg();
            switch (data)
            {
                case 'nologin':
                    //LoadPopUpMessage('Bạn cần đăng nhập để thực hiện chức năng này');
                    break;
                case 'empty':
                    //$(".hienthi_ykien").unbind("click");
                    //$(".hienthi_ykien").hide();
                    break;
                default:
                    if (_type == 'reload')
                        $('.listComment').html(data);
                    else
                        $('.listComment').append(data);
                    //$(".hienthi_ykien").show();
            }

        },
        error: function(jqXHR, textStatus, errorThrown)
        {

        }
    });
}
function LoadMoreListCM(_url, _contract_id)
{
    $('#page_LCM').val(parseInt($('#page_LCM').val()) + parseInt('1'));
    LoadListComment(_url, _contract_id, 'none');
}
function ReLoadListComment(_url, _contract_id)
{
    $('#page_LCM').val(1);
    LoadListComment(_url, _contract_id, 'reload');
}