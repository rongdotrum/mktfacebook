<?php
/* @var $this QuaysoItemController */
/* @var $data QuaysoItem */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->itemid), array('view', 'id'=>$data->itemid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idingame')); ?>:</b>
	<?php echo CHtml::encode($data->idingame); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemname')); ?>:</b>
	<?php echo CHtml::encode($data->itemname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('count')); ?>:</b>
	<?php echo CHtml::encode($data->count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('percent')); ?>:</b>
	<?php echo CHtml::encode($data->percent); ?>
	<br />


</div>