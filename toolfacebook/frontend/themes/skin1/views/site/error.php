<?php
$this->pageTitle = Yii::app()->name . ' - Error';
$this->breadcrumbs = array(
    'Error',
);
?>

<div class="contentCenter">
    <div class="two_nrtop"><!-- --></div>
    <div class="two_nr_sfqlb">
        <div class="big_box_wrap">
            <h3>Có Lỗi Xảy Ra</h3>
            <div class="box_main_link">
                <a href="<?php echo app()->createUrl('site')?>">Trang chủ</a>
            </div>
            <div class="news_content_wrap">
                 <?php echo CHtml::encode($message); ?>
            </div>
        </div>                            
    </div>
    <div class="two_nrfoot"><!-- --></div>
</div>                





