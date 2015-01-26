

window.fbAsyncInit = function() {
    FB.init({
        appId: '896350517066260',
        cookie: true, // enable cookies to allow the server to access
        // the session
        xfbml: true, // parse social plugins on this page
        version: 'v2.1' // use version 2.1
    });

};

// Load the SDK asynchronously
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.

function FacebookInviteFriends(server)
{
    FB.ui({method: 'apprequests',
      message: 'Ta đang trên đường trở Thành Cưởng Giả, Hãy cùng ta tham gia Chân Giới để trở Thành Cường Giả!!!!!'
    }, function(response){
        console.log(response);
    });
}
function fbfullscreen(id){
//  debugger;

  if(id != ""){  
     // $('#'+id).focus();
      var element = document.getElementById(id);
      //    window.fullScreenApi.requestFullScreen(document.body); 
      if (element.requestFullscreen) 
          return element.requestFullscreen();
       else if (element.webkitRequestFullScreen) 
          return       element.webkitRequestFullScreen();
       else if (element.mozRequestFullScreen) { 
          return     element.mozRequestFullScreen();
       }  else alert('Xin lỗi, trình duyệt không hỗ trợ');
   }
} 


function ShareFriend()
{
   FB.ui({
        method: 'feed',
        link: url_share,
        caption: 'Nhận GiftCode '+name_game,
        description : 'Các bạn có muốn nhận ngay những phần quà cực hấp dẫn trong game không? Chỉ cần nhấn LIKE và SHARE ngay tại trang Fanpage của '+name_game+' ngay nhé! Những gì hấp dẫn nhất đang chờ đợi bạn trong '+name_game+'.'
      }, function(response){
          
          if(response['post_id'])
          {
            var data_cm = {}; //Array
            $.ajax({
                url: '/'+mod_app+'/giftcode/saveshare',
                type: "POST",
                beforeSend: function()
                {
                    //$('#thongbaofanpage').html('');
                    //xu ly waiting
                },
                data: data_cm,
                success: function(data, textStatus, jqXHR)
                {
                    //thanh cong
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    //that bai
                }
            });
          }
          else
          {
              alert('khong thanh cong');
          }
      });

}
function GetGiftCode()
{
    var data_cm = {}; //Array
    var response = {};
    $.ajax({
        url: '/'+mod_app+'/giftcode/getGiftCode',
        type: "POST",
        data:{server_id:$('#server_gif_code').val(),code:$('#input_gift_code').val()},
        async :false,
        beforeSend: function()
        {
            $('#thongbaofanpage').html('');
            //xu ly waiting
        },            
        success: function(data, textStatus, jqXHR)
        {
            response= jQuery.parseJSON(data);
            if (response.success == true)
            {                
                $('#thongbaofanpage').html('<span style="color:green;font-weight:bold;font-size:15px;">' + response.message + '</span>');
                
            }
            else
            {               
                $('#thongbaofanpage').html('Thông báo: <span style="color:red;font-weight:bold;font-size:15px;">' + response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {

        }
    });
    
}
