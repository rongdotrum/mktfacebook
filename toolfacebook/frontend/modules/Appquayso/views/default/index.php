<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/message.css');
    
?>
<div class="message error" style="text-align:center">
      <?php echo Yii::app()->user->getFlash('error') ?>
</div>
