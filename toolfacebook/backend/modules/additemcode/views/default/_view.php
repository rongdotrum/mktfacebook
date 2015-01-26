<?php
/* @var $this ItemGiftcodeInputController */
/* @var $data ItemGiftcodeInput */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('itemid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->itemid), array('view', 'id'=>$data->itemid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />


</div>