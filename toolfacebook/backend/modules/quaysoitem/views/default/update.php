<?php
/* @var $this QuaysoItemController */
/* @var $model QuaysoItem */

$this->breadcrumbs=array(
	'Quayso Items'=>array('index'),
	$model->itemid=>array('view','id'=>$model->itemid),
	'Update',
);

$this->menu=array(
	array('label'=>'List QuaysoItem', 'url'=>array('index')),
	array('label'=>'Create QuaysoItem', 'url'=>array('create')),
	array('label'=>'View QuaysoItem', 'url'=>array('view', 'id'=>$model->itemid)),
	array('label'=>'Manage QuaysoItem', 'url'=>array('admin')),
);
?>

<h1>Update QuaysoItem <?php echo $model->itemid; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>