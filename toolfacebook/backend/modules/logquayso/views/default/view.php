<?php
/* @var $this LogQuaysoController */
/* @var $model LogQuayso */

$this->breadcrumbs=array(
	'Log Quaysos'=>array('index'),
	$model->LogId,
);

$this->menu=array(
	array('label'=>'List LogQuayso', 'url'=>array('index')),
	array('label'=>'Create LogQuayso', 'url'=>array('create')),
	array('label'=>'Update LogQuayso', 'url'=>array('update', 'id'=>$model->LogId)),
	array('label'=>'Delete LogQuayso', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->LogId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage LogQuayso', 'url'=>array('admin')),
);
?>

<h1>View LogQuayso #<?php echo $model->LogId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'LogId',
		'userid',
		'username',
		'content',
		'server_id',
		'datequay',
		'type',
		'quantily',
		'codeingame',
		'isfreeday',
	),
)); ?>
