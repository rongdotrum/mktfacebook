<?php
/* @var $this QuaysoItemController */
/* @var $model QuaysoItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'quayso-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	

	<div class="row">
		<?php echo $form->labelEx($model,'itemname'); ?>
		<?php echo $form->textField($model,'itemname',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'itemname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'count'); ?>
		<?php echo $form->textField($model,'count'); ?>
		<?php echo $form->error($model,'count'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'percent'); ?>
		<?php echo $form->textField($model,'percent',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'percent'); ?>
	</div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'limititem'); ?>
        <?php echo $form->textField($model,'limititem',array('size'=>5,'maxlength'=>5)); ?>
        <?php echo $form->error($model,'limititem'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'image'); ?>
        <?php echo $form->textField($model,'image',array('size'=>5,'maxlength'=>250)); ?>
        <?php echo $form->error($model,'image'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'image_hover'); ?>
        <?php echo $form->textField($model,'image_hover',array('size'=>5,'maxlength'=>250)); ?>
        <?php echo $form->error($model,'image_hover'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->