<?php
/* @var $this AdminLogController */
/* @var $data AdminLog */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Log_Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Log_Id), array('view', 'id'=>$data->Log_Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Admin_Id')); ?>:</b>
	<?php echo CHtml::encode($data->Admin_Id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Admin_name')); ?>:</b>
	<?php echo CHtml::encode($data->Admin_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Action')); ?>:</b>
	<?php echo CHtml::encode($data->Action); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Content')); ?>:</b>
	<?php echo CHtml::encode($data->Content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Ip')); ?>:</b>
	<?php echo CHtml::encode($data->Ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Datetime')); ?>:</b>
	<?php echo CHtml::encode($data->Datetime); ?>
	<br />


</div>