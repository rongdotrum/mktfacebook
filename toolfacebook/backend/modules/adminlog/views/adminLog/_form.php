<?php
/* @var $this AdminLogController */
/* @var $model AdminLog */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'admin-log-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Admin_Id'); ?>
		<?php echo $form->textField($model,'Admin_Id'); ?>
		<?php echo $form->error($model,'Admin_Id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Admin_name'); ?>
		<?php echo $form->textField($model,'Admin_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'Admin_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Action'); ?>
		<?php echo $form->textField($model,'Action',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'Action'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Content'); ?>
		<?php echo $form->textField($model,'Content',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'Content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Ip'); ?>
		<?php echo $form->textField($model,'Ip',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'Ip'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Datetime'); ?>
		<?php echo $form->textField($model,'Datetime'); ?>
		<?php echo $form->error($model,'Datetime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->