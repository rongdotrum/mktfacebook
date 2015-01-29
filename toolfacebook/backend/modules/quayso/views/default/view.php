<?php
/* @var $this QuaysoController */
/* @var $model Quayso */

$this->breadcrumbs=array(
	'Quaysos'=>array('index'),
	$model->ID,
);

$this->menu=array(
	array('label'=>'List Quayso', 'url'=>array('index')),
	array('label'=>'Create Quayso', 'url'=>array('create')),
	array('label'=>'Update Quayso', 'url'=>array('update', 'id'=>$model->ID)),
	array('label'=>'Delete Quayso', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->ID),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Quayso', 'url'=>array('admin')),
);
?>

<h1>View Quayso #<?php echo $model->ID; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'ID',
		'position',
		'items.itemname',
	),
)); ?>
