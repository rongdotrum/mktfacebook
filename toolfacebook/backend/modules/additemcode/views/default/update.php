<?php
/* @var $this ItemGiftcodeInputController */
/* @var $model ItemGiftcodeInput */

$this->breadcrumbs=array(
	'Item Giftcode Inputs'=>array('index'),
	$model->itemid=>array('view','id'=>$model->itemid),
	'Update',
);

$this->menu=array(
	array('label'=>'List ItemGiftcodeInput', 'url'=>array('index')),
	array('label'=>'Create ItemGiftcodeInput', 'url'=>array('create')),
	array('label'=>'View ItemGiftcodeInput', 'url'=>array('view', 'id'=>$model->itemid)),
	array('label'=>'Manage ItemGiftcodeInput', 'url'=>array('admin')),
);
?>

<h1>Update ItemGiftcodeInput <?php echo $model->itemid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>