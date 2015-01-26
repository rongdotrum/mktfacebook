<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
        $this->renderPartial('/partial/_meta');       
        ?>             
        
        
        <script type="text/javascript">
            $(document).ready(function() {
                /*=== popup payment ==*/
                $('#idnapthe').click(function() {
                    $('.popupPayment').show();
                });
                $('.closePay').click(function() {
                    $('.popupPayment').hide();
                });
                $("body").delegate('.classbuttonFB', 'mouseover', function(i) {
                    $(this).animate({
                        backgroundColor: '#D2141E'
                    }, 300);
                });
                $("body").delegate('.classbuttonFB', 'mouseout', function(i) {
                    $(this).animate({
                        backgroundColor: '#008000'
                    }, 300);
                });
                $('#topbar_default .nav ul > li > a#options').mouseover(function() {
                    $('.nav ul ul').show();
                });
                $('.nav ul ul').mouseover(function() {
                    $(this).show();
                });
                $('#topbar_default .nav ul > li > a#options').mouseout(function() {
                    $('.nav ul ul').hide();
                });
                $('.nav ul ul').mouseout(function() {
                    $(this).hide();
                });

                /*=== slider wing ===*/
                var prev = $('.boxWing .prev');
                var next = $('.boxWing .next');
                var ul = $('.boxWing #ulWing');
                var li = ul.find('li');
                var c = 0;
                next.click(function() {
                    animate(c = c + 1 <= li.length - 6 ? (c + 1) : 0);
                });
                prev.click(function() {
                    animate(c = c - 1 < 0 ? (li.length - 6) : (c - 1));
                });
                function animate(i) {
                    ul.stop().animate({left: -(i * 75) + "px"}, 300);
                }
                ;
                setInterval(function() {
                    next.trigger('click');
                }, 5000);
            });


        </script>
        <?php
            if (isset(Yii::app()->session['isregist'])):
            ?>
            <!-- Facebook Conversion Code for Chan Gioi -->
            <script>(function() {
                    var _fbq = window._fbq || (window._fbq = []);
                    if (!_fbq.loaded) {
                        var fbds = document.createElement('script');
                        fbds.async = true;
                        fbds.src = '//connect.facebook.net/en_US/fbds.js';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(fbds, s);
                        _fbq.loaded = true;
                    }
                })();
                window._fbq = window._fbq || [];
                window._fbq.push(['track', '6031488528476', {'value':'0.00','currency':'VND'}]);
            </script>
            <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6031488528476&amp;cd[value]=0.00&amp;cd[currency]=VND&amp;noscript=1" /></noscript>
            <?php
              unset(Yii::app()->session['isregist']);
              endif;
        ?>
    </head>

    <body>
        <div id="head" class="row">
            <div id="topbar_default">
                <div class="logo">
                    <a target="_blank" onclick="<?= $this->url_home ?>" href="<?= $this->url_home ?>"><img src="<?php echo $this->module->assetsUrl.'/css/'.$this->module->name.'/images/logoapp.png' ?>"/></a>
                </div>
                <div class="profile">
                    <a href="" class="avata">
                        <img  src="https://graph.facebook.com/<?= Yii::app()->request->cookies['fb_id'] ?>/picture" class="">
                    </a>
                    <span></span>
                    <span></span>
                </div>
                <div class="nav">
                    <ul>
                        <li>
                            <a href="javascript:void(0)" id="options"><i class="icon options"></i><span>Tiện ích</span></a>
                            <div>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)" onclick="fbfullscreen('frame_content')"><i class="icon fullscreen"></i><span>Toàn màn hình</span></a>
                                    </li>
                                    <span class="separate"></span>
                                    <li>
                                        <a href="<?=  Yii::app()->params['facebook'] ?>" target="_blank"><i class="icon fanpage"></i><span>Fanpage</span></a>
                                    </li>
                                    <span class="separate"></span>
                                    <li>
                                        <a href="<?= Yii::app()->createUrl('site') ?>" target="_blank"><i class="icon home"></i><span>Trang chủ</span></a>
                                    </li>
                                    <span class="separate"></span>
                                    <li>
                                        <a href="<?= Yii::app()->createUrl('article/khuyenmai') ?>" target="_blank"><i class="icon home"></i><span>Khuyến mãi</span></a>
                                    </li>
                                    <span class="separate"></span>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="<?= Yii::app()->createUrl($this->module->name.'/payment') ?>" id="idnapthe"><i class="icon recharge"></i><span>Nạp Thẻ</span></a>
                        </li>
                        <li>
                            <a href="<?= $this->urlapp ?>/giftcode" target="_blank" ><i class="icon giftcode"></i><span>Code Tân Thủ</span></a>
                        </li>
                        <li>
                            <a href="<?= Yii::app()->createUrl($this->module->name.'/listservers') ?>"></i><span>Tất cả server</span></a>
                        </li>
                        <li>
                            <a  href="javascript:;" onclick="FacebookInviteFriends('<?php
                            if (isset(Yii::app()->session['serverInfo']->server_name))
                                echo Yii::app()->session['serverInfo']->server_name;
                            else
                                echo 'Mình';
                            ?>')"><i class="icon invites"></i><span>Mời bạn bè</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div style=" z-index:999;display: block;background: white;height: 57px;line-height: 45px;width: 100%; margin: 0 auto;top: 0px;left: 0px;">
        </div>
         <?php echo $content;
        ?>
    </body>
</html>