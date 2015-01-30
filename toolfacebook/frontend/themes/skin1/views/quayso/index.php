<?php
    Yii::app()->clientScript->registerCoreScript('jquery');
     if (Yii::app()->request->isSecureConnection)
            $varflash = 'https://'.$_SERVER['SERVER_NAME'];
        else
            $varflash = 'http://'.$_SERVER['SERVER_NAME'];     
?>
<div style="width:752px;height:800px;margin:5px auto;">
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
    <param name="FlashVars" value="host=<?php echo $varflash; ?>" />
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
        <param name="FlashVars" value="host=<?php echo $varflash; ?>" />
        <!--<![endif]-->    
        <!--[if !IE]>-->
    </object>
    <!--<![endif]-->
</object>

<a class="btnshare"  onclick="sharefb()" href="javascript:;">Click Share Để Nhận Thêm Lượt Quay</a>

</div>
<style>
.btnshare {   
    display:block;
    text-decoration: none;
    width:300px;
    height:50px;
    border:1px solid black;
    line-height:50px;
    text-align: center;
    cursor:pointer;
    margin:5px auto;
    background-color: #006dcc;
    background-image: -moz-linear-gradient(center top , #0088cc, #0044cc);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #ffffff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}
</style>

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
                            window.top.location.href = encodeURI('<?php echo $this->urlapp ?>');
                    },                    
                });          
            }
        });
    }
</script>




