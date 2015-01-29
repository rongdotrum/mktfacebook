<?php
/* @var $this QuaysoController */
/* @var $model Quayso */

$this->breadcrumbs=array(
	'Quaysos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Quayso', 'url'=>array('index')),
	array('label'=>'Manage Quayso', 'url'=>array('admin')),
);
?>

<h1>Create Quayso</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'item'=>$item)); ?>