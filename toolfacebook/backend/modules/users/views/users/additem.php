<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs=array(
    'Users'=>array('index'),
    $model->user_id=>array('view','id'=>$model->user_id),
    'Update',
);

$this->menu=array(
    array('label'=>'List Users', 'url'=>array('index')),

);
?>
<h1>Gửi Mail Item</h1>
<div class="form">
 <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'users-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'serverid'); ?>
        <?php 
            echo CHtml::activeDropDownList($model,'serverid',GHelpers::getDropDownList('Servers','server_id','server_name'),array('empty'=>'Chọn server'));
        ?>
        <?php echo $form->error($model,'serverid'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>50)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'message'); ?>
        <?php echo $form->textField($model,'message'); ?>
        <?php echo $form->error($model,'message'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'itemid'); ?>
        <?php echo $form->textField($model,'itemid'); ?>
        <?php echo $form->error($model,'itemid'); ?>
    </div>


  
    <div class="row buttons">
        <?php echo CHtml::submitButton('Gửi Item'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->