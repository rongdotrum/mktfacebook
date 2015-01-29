<?php
/* @var $this LogQuaysoController */
/* @var $model LogQuayso */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'LogId'); ?>
		<?php echo $form->textField($model,'LogId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'userid'); ?>
		<?php echo $form->textField($model,'userid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'content'); ?>
		<?php echo $form->textField($model,'content',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'server_id'); ?>
		<?php echo $form->textField($model,'server_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'datequay'); ?>
		<?php echo $form->textField($model,'datequay'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'quantily'); ?>
		<?php echo $form->textField($model,'quantily'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'codeingame'); ?>
		<?php echo $form->textField($model,'codeingame',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'isfreeday'); ?>
		<?php echo $form->textField($model,'isfreeday'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->