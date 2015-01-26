<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/message.css');
?>

<div class="boxContent">
    <div class="message error" style="text-align: center;">
        <?php echo CHtml::encode($message); ?>
    </div>    
</div>