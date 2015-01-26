<?php
/* @var $this AdminLogController */
/* @var $model AdminLog */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'Log_Id'); ?>
		<?php echo $form->textField($model,'Log_Id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Admin_Id'); ?>
		<?php echo $form->textField($model,'Admin_Id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Admin_name'); ?>
		<?php echo $form->textField($model,'Admin_name',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Action'); ?>
		<?php echo $form->textField($model,'Action',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Content'); ?>
		<?php echo $form->textField($model,'Content',array('size'=>60,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Ip'); ?>
		<?php echo $form->textField($model,'Ip',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Datetime'); ?>
		<?php echo $form->textField($model,'Datetime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->