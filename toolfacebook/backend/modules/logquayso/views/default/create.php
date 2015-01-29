<?php
/* @var $this LogQuaysoController */
/* @var $model LogQuayso */

$this->breadcrumbs=array(
	'Log Quaysos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LogQuayso', 'url'=>array('index')),
	array('label'=>'Manage LogQuayso', 'url'=>array('admin')),
);
?>

<h1>Create LogQuayso</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>