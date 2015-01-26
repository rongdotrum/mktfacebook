<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
         <?php
        $this->renderPartial('/partial/_meta');
        ?>
        <link rel="stylesheet" type="text/css" href="<?= $this->module->assetsUrl ?>/giftcodefanpage/giftCode.css?v=2">
    </head>
    <body>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId='<?= Yii::app()->params['appfb_id']?>'&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="wrap">
            <a id="Logo" href="<?= $this->url_home ?>" target="_blank" title="<?= $this->pageTitle ?>"><?= $this->pageTitle ?></a>
            <ul class="menu">
                <li>
                    <a class="TrangChu" target="_blank"  href="<?= $this->url_home ?>" title="Trang chủ">Trang chủ</a>
                    <a class="NapThe" target="_blank" href="<?= $this->url_home ?>/payment" title="Nạp thẻ">Nạp thẻ</a>
                    <a class="HoTro" target="_blank" href="<?= $this->url_home ?>" title="Hỗ trợ">Hỗ trợ</a>
                </li>
            </ul>
             <div class="content" style="padding-top: 0px;">
                <div style="width:60%;margin:10px auto 5px">
                    <label style="font-size:15px;font-weight:bold;width:97px;text-align:right">Chọn Server:</label>
                    <?php
                        echo CHtml::dropDownList('server_gif_code', '', GHelpers::getDropDownList('Servers', 'server_id', 'server_name', 'status = 1 and published_date <= now()'), array('empty' => 'Chọn Máy Chủ'));
                    ?>                    
                </div>
                <div style="width:60%;margin:10px auto 5px">
                <label style="font-size:15px;font-weight:bold;width:97px;padding-right:14px">Nhập code:</label>
                    <?php
                        echo CHtml::textField('input_gift_code','',array('placeholder'=>'Nhập mã giftcode'));
                    ?>                    
                </div>

                <ul class="GiftCode">
                    <li>
                        <fb:like href="<?=  Yii::app()->params['facebook'] ?>" layout="button" action="like" show_faces="false" share="false" data-layout="box_count"></fb:like>
                        <a href="javascript:;" class="Invite" title="Mời bạn bè" onclick="ShareFriend();">Mời bạn bè</a>
                        <button id="GetGift" href="#" title="Nhận Giftcode" onclick="GetGiftCode();">Nhận Giftcode</button>
                    </li>
                </ul>
                <div style="margin-left:20px;margin-top:30px;margin-right:20px"><p id="thongbaofanpage"></p></div>
            </div>
        </div> 
    </body>
</html>
