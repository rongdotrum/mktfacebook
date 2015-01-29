<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
?>
<div style="width: 752px;">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="752" height="431" id="FlashVars_AS2" align="middle">
    <param name="movie" value="<?php echo app()->request->baseUrl ?>/swf/quayso_ovuong.swf" />
    <param name="quality" value="high" />
    <param name="bgcolor" value="#FFFFFF" />
    <param name="play" value="true" />
    <param name="loop" value="true" />
    <param name="wmode" value="transparent" />
    <param name="scale" value="showall" />
    <param name="menu" value="true" />
    <param name="devicefont" value="false" />
    <param name="salign" value="" />
    <param name="allowScriptAccess" value="sameDomain" />
    <param name="FlashVars" value="host=<?php echo $_SERVER['SERVER_NAME']; ?>" />
    <!--[if !IE]>-->
    <object type="application/x-shockwave-flash" data="<?php echo app()->request->baseUrl ?>/swf/quayso_ovuong.swf" width="752" height="431">
        <param name="movie" value="<?php echo app()->request->baseUrl ?>/swf/quayso_ovuong.swf" />
        <param name="quality" value="high" />
        <param name="bgcolor" value="#FFFFFF" />
        <param name="play" value="true" />
        <param name="loop" value="true" />
        <param name="wmode" value="transparent" />
        <param name="scale" value="showall" />
        <param name="menu" value="true" />
        <param name="devicefont" value="false" />
        <param name="salign" value="" />
        <param name="allowScriptAccess" value="sameDomain" />
        <param name="FlashVars" value="host=<?php echo $_SERVER['SERVER_NAME']; ?>" />
        <!--<![endif]-->
        <a href="http://www.adobe.com/go/getflash">
            <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
        </a>
        <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
</object>

<div class="btnshare" style="margin-left: 17px;background-color: white; width:200px;height:100px;border:1px solid black;line-height:100px;text-align: center;cursor:pointer" onclick="sharefb()">Share</div>
</div>




<script type="">
    function sharefb() {       
        FB.ui({
            method: 'share',
            href: 'https://www.facebook.com/mongthienlong.mongvl',
        }, function(response){          
            if (typeof(response) == 'undefined' || typeof(response.error_code) != 'undefined') 
            {

            }
            else
                {
                $.ajax({
                    url: '/quayso/sharefb',                                 
                    success: function(data)
                    {
                        if (data == 1)  
                            location.reload();
                    },                    
                });          
            }
        });
    }
</script>




