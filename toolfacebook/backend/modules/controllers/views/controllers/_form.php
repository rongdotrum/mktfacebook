<?php
/* @var $this ControllersController */
/* @var $model Controllers */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'controllers-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>


    <div class="row">
        <?php echo $form->labelEx($model, 'url'); ?>
        <?php
        //echo $form->textField($model, 'controller_name', array('size' => 50, 'maxlength' => 50));
        echo CHtml::activeDropDownList($model, 'url', CHtml::listData($modules, 'url', 'url'), array('empty' => '--Chọn Module--'));
        ?>
        <?php echo $form->error($model, 'controller_name'); ?>
    </div>



    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'parent'); ?>
        <?php
        //   echo $form->textField($model,'parent');
        echo CHtml::activeDropDownList($model, 'parent', CHtml::listData(Controllers::model()->findAll('parent = 0'), 'controller_id', 'description'), array('empty' => 'Menu Gốc'));
        ?>
        <?php echo $form->error($model, 'parent'); ?>
    </div>


    <div class="row">
        <?php echo $form->labelEx($model, 'special'); ?>
        <?php
        echo Chtml::activeDropDownList($model, 'special', array(0 => "Hiển Thị Mọi User", 1 => "Chỉ Hiển Thị Với Admin"));
//echo $form->textField($model, 'special');
        ?>
        <?php echo $form->error($model, 'special'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Tạo Mới' : 'Lưu Chỉnh Sửa', array('class' => 'btn btn-primary btn-small')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->