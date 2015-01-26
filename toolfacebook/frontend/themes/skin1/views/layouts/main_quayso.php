<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
            $this->renderPartial('/partials/_meta');
            Yii::app()->clientScript->registerCssFile($this->_assetsUrl.'/css/main.css?v='.$this->version_assets);
            Yii::app()->clientScript->registerCssFile($this->_assetsUrl.'/css/style.css?v='.$this->version_assets);
            Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/message.css?v='.$this->version_assets);
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerScriptFile($this->_assetsUrl.'/js/main.js?v='.$this->version_assets);
            Yii::app()->clientScript->registerScript(__CLASS__,'var appid ="'.Yii::app()->params['appfb_id'].'"',CClientScript::POS_HEAD);
        ?>
           <script type="text/javascript">
            $(document).ready(function() {
                /*=== tab menu ===*/
                $(".buttonLink > a").click(function(){
                    var param = $(this).attr("rel");
                    $(".subboxQuaySo").hide();
                    $("#" + param).show();
                    $(".buttonLink a").removeClass("active");
                    $(this).addClass("active");        
                });

            });
        </script>
    </head>
    <body class="ys_home">    
        <div id="wrapper">
            <div class="nr">    
                <div id="home_body">
                    <div id="centerQuaySo">
                        <div class="aStart">
                            <a href="<?php echo app()->createUrl('play')?>" class="startGame">Chơi ngay</a>      
                        </div>
                        <div class="contentQuaySo">
                            <?php echo $content ?>                  
                        </div>                
                    </div>                                            
                </div>
            </div>
        </div>     
    </body>
</html>
