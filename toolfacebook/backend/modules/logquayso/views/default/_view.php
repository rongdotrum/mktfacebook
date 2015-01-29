<?php
/* @var $this LogQuaysoController */
/* @var $data LogQuayso */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('LogId')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->LogId), array('view', 'id'=>$data->LogId)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('userid')); ?>:</b>
	<?php echo CHtml::encode($data->userid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('server_id')); ?>:</b>
	<?php echo CHtml::encode($data->server_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('datequay')); ?>:</b>
	<?php echo CHtml::encode($data->datequay); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('quantily')); ?>:</b>
	<?php echo CHtml::encode($data->quantily); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('codeingame')); ?>:</b>
	<?php echo CHtml::encode($data->codeingame); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isfreeday')); ?>:</b>
	<?php echo CHtml::encode($data->isfreeday); ?>
	<br />

	*/ ?>

</div>