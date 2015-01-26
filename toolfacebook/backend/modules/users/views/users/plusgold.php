<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
    'Users'=>array('index'),
    'Plus Gold',
);

$this->menu=array(
    array('label'=>'List Users', 'url'=>array('index')),
    array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Cộng vàng cho tài khoản</h1>
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'users-form',
            'enableAjaxValidation'=>false,
        )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php $this->widget('bootstrap.widgets.TbAlert'); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'display_name'); ?>
        <?php echo $form->textField($model,'display_name',array('size'=>50,'maxlength'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'server_id'); ?>
        <?php echo $form->DropDownList($model, 'server_id', GHelpers::getDropDownList('Servers','server_id','server_name','status IN (1,4)','published_date DESC'),array('empty' => 'Chọn máy chủ'));?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'gold'); ?>
        <?php echo $form->textField($model,'gold'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Đồng Ý'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->