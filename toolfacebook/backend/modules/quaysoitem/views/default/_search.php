<?php
/* @var $this QuaysoItemController */
/* @var $model QuaysoItem */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'itemid'); ?>
		<?php echo $form->textField($model,'itemid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'idingame'); ?>
		<?php echo $form->textField($model,'idingame'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'itemname'); ?>
		<?php echo $form->textField($model,'itemname',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'count'); ?>
		<?php echo $form->textField($model,'count'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'percent'); ?>
		<?php echo $form->textField($model,'percent',array('size'=>5,'maxlength'=>5)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->