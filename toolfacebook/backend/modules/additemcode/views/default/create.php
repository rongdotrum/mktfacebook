<?php
/* @var $this ItemGiftcodeInputController */
/* @var $model ItemGiftcodeInput */

$this->breadcrumbs=array(
	'Item Giftcode Inputs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ItemGiftcodeInput', 'url'=>array('index')),
	array('label'=>'Manage ItemGiftcodeInput', 'url'=>array('admin')),
);
?>

<h1>Create ItemGiftcodeInput</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>