<?php
/* @var $this LogQuaysoController */
/* @var $model LogQuayso */

$this->breadcrumbs=array(
	'Log Quaysos'=>array('index'),
	$model->LogId=>array('view','id'=>$model->LogId),
	'Update',
);

$this->menu=array(
	array('label'=>'List LogQuayso', 'url'=>array('index')),
	array('label'=>'Create LogQuayso', 'url'=>array('create')),
	array('label'=>'View LogQuayso', 'url'=>array('view', 'id'=>$model->LogId)),
	array('label'=>'Manage LogQuayso', 'url'=>array('admin')),
);
?>

<h1>Update LogQuayso <?php echo $model->LogId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>